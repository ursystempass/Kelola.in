<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\OtpResetPasswordMail;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\View\View;

class ForgotPasswordController extends Controller
{
    /** Masa berlaku kode OTP dalam menit. */
    public const OTP_LIFETIME_MINUTES = 10;

    /** Batas maksimal percobaan salah sebelum dikunci sementara. */
    public const MAX_OTP_ATTEMPTS = 5;

    /**
     * Menampilkan formulir permintaan OTP reset kata sandi.
     */
    public function showRequestForm(): View
    {
        return view('auth.forgot-password', [
            'step' => 'request',
        ]);
    }

    /**
     * Membuat dan mengirim kode OTP ke email pengguna jika akun terdaftar dan aktif.
     */
    public function sendOtp(Request $request): RedirectResponse
    {
        $request->validate([
            'username' => ['required', 'string'],
        ], [
            'username.required' => 'Username atau email wajib diisi.',
        ]);

        $identifier = $request->input('username');
        $user = User::findByIdentifier($identifier);

        // Hanya kirim OTP jika akun benar-benar ada dan berstatus aktif
        if ($user && $user->is_active) {
            $otpCode = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);

            // Simpan OTP dalam bentuk hash agar tidak terbaca jika database bocor
            DB::table('password_reset_tokens')->updateOrInsert(
                ['email' => $user->email],
                [
                    'token' => Hash::make($otpCode),
                    'created_at' => now(),
                ]
            );

            // Kirim OTP ke email pengguna melalui Mailable dan tangkap error mailer
            try {
                Mail::to($user->email)->send(
                    new OtpResetPasswordMail($user, $otpCode, self::OTP_LIFETIME_MINUTES)
                );
            } catch (\Throwable $e) {
                report($e);

                DB::table('password_reset_tokens')->where('email', $user->email)->delete();

                return back()->withErrors([
                    'username' => 'Gagal mengirim email OTP. Silakan periksa koneksi atau konfigurasi email lalu coba lagi.',
                ])->withInput($request->only('username'));
            }
        }

        // Simpan identifier di session untuk dipakai saat memverifikasi form reset
        $request->session()->put('reset_identifier', $identifier);

        // Tampilkan pesan umum yang sama baik akun ditemukan maupun tidak untuk mencegah user enumeration
        return redirect()->route('password.reset.form')
            ->with('status', 'Jika akun terdaftar, kode OTP telah dikirim ke email akun tersebut.');
    }

    /**
     * Menampilkan formulir input OTP dan kata sandi baru.
     */
    public function showResetForm(Request $request): View|RedirectResponse
    {
        // Pengguna tidak boleh langsung membuka halaman reset tanpa meminta OTP terlebih dahulu
        if (! $request->session()->has('reset_identifier')) {
            return redirect()->route('password.forgot');
        }

        return view('auth.forgot-password', [
            'step' => 'reset',
        ]);
    }

    /**
     * Memverifikasi kode OTP dan menyimpan kata sandi baru.
     */
    public function resetPassword(Request $request): RedirectResponse
    {
        $identifier = $request->session()->get('reset_identifier');

        // Pastikan alur dimulai dari permintaan OTP
        if (! $identifier) {
            return redirect()->route('password.forgot');
        }

        $request->validate([
            'otp' => ['required', 'digits:6'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ], [
            'otp.required' => 'Kode OTP wajib diisi.',
            'otp.digits' => 'Kode OTP harus berupa 6 angka.',
            'password.required' => 'Kata sandi baru wajib diisi.',
            'password.min' => 'Kata sandi baru minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi baru tidak cocok.',
        ]);

        // Kunci pembatasan percobaan per identifier dan IP
        $throttleKey = 'reset-otp:' . strtolower($identifier) . '|' . $request->ip();

        // Tolak jika sudah melebihi batas percobaan salah untuk mencegah brute force
        if (RateLimiter::tooManyAttempts($throttleKey, self::MAX_OTP_ATTEMPTS)) {
            return back()->withErrors([
                'otp' => 'Terlalu banyak percobaan. Coba lagi beberapa menit lagi.',
            ])->withInput($request->only('otp'));
        }

        $user = User::findByIdentifier($identifier);
        $record = $user ? DB::table('password_reset_tokens')->where('email', $user->email)->first() : null;

        $isExpired = ! $record || Carbon::parse($record->created_at)->addMinutes(self::OTP_LIFETIME_MINUTES)->isPast();
        $isValidOtp = $user && $user->is_active && $record && ! $isExpired && Hash::check($request->input('otp'), $record->token);

        // Jika OTP salah atau kedaluwarsa, catat percobaan gagal dan tolak
        if (! $isValidOtp) {
            RateLimiter::hit($throttleKey, 600);

            return back()->withErrors([
                'otp' => 'Kode OTP salah atau sudah kedaluwarsa.',
            ])->withInput($request->only('otp'));
        }

        // Bersihkan pembatas percobaan karena verifikasi sudah berhasil
        RateLimiter::clear($throttleKey);

        // Model User sudah memiliki cast 'password' => 'hashed', jadi tidak memakai Hash::make()
        $user->update([
            'password' => $request->input('password'),
        ]);

        // Hapus token agar kode OTP hanya dapat digunakan satu kali
        DB::table('password_reset_tokens')->where('email', $user->email)->delete();

        // Bersihkan identifier dari session
        $request->session()->forget('reset_identifier');

        return redirect()->route('login')
            ->with('status', 'Kata sandi berhasil diubah. Silakan masuk dengan kata sandi baru.');
    }
}
