<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Kata Sandi - Kelola.in</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <!-- Tailwind CSS CDN untuk preview instan & konsistensi tampilan -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;900&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body class="flex min-h-screen items-center justify-center bg-[#F3F6FC] p-4">
    <div class="w-full max-w-[440px]">
        <!-- Logo & Judul Aplikasi -->
        <div class="mb-6 text-center">
            <img src="{{ asset('images/logo.png') }}" alt="Logo Kelola.in" class="mx-auto mb-4 h-16 w-16 object-contain">
            <h1 class="text-2xl font-black tracking-wide text-[#1A6CF0]">KELOLA.IN</h1>
            <p class="mt-2 text-xs text-slate-500">Sistem Informasi Toko Sembako</p>
        </div>

        <!-- Kartu Form -->
        <div class="rounded-2xl border border-[#E5EAF3] bg-white p-8 shadow-[0_8px_30px_rgba(15,40,100,0.08)] sm:p-10">
            <div class="mb-6">
                @if ($step === 'reset')
                    <h2 class="text-lg font-bold text-[#0F2B5C]">Atur Ulang Kata Sandi</h2>
                    <p class="mt-2 text-xs text-slate-500">Masukkan kode OTP 6 angka yang dikirim ke email akun Anda beserta kata sandi baru.</p>
                @else
                    <h2 class="text-lg font-bold text-[#0F2B5C]">Lupa Kata Sandi</h2>
                    <p class="mt-2 text-xs text-slate-500">Masukkan username atau email akun Anda. Kami akan mengirimkan kode OTP untuk mengatur ulang kata sandi.</p>
                @endif
            </div>

            <!-- Pesan Notifikasi Status -->
            @if (session('status'))
                <div class="mb-6 flex items-start gap-3 rounded-xl border border-[#1A6CF0]/30 bg-[#1A6CF0]/10 p-4 text-sm text-[#0F2B5C]">
                    <svg class="mt-0.5 h-5 w-5 shrink-0 text-[#1A6CF0]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>{{ session('status') }}</span>
                </div>
            @endif

            <!-- Pesan Kesalahan / Error Alert -->
            @if ($errors->any())
                <div class="mb-6 flex items-start gap-3 rounded-xl border border-rose-200 bg-rose-50 p-4 text-sm text-rose-800">
                    <svg class="mt-0.5 h-5 w-5 shrink-0 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div class="space-y-1">
                        @foreach ($errors->all() as $error)
                            <p class="font-medium">{{ $error }}</p>
                        @endforeach
                    </div>
                </div>
            @endif

            @if ($step === 'reset')
                <!-- Langkah 2: Verifikasi OTP & Input Kata Sandi Baru -->
                <form method="POST" action="{{ route('password.reset.update') }}" class="space-y-4">
                    @csrf

                    <!-- Input Kode OTP -->
                    <div>
                        <label for="otp" class="mb-2 block text-xs font-semibold text-slate-700">Kode OTP (6 angka)</label>
                        <input
                            type="text"
                            id="otp"
                            name="otp"
                            inputmode="numeric"
                            maxlength="6"
                            value="{{ old('otp') }}"
                            required
                            autofocus
                            placeholder="123456"
                            class="h-12 w-full rounded-xl border bg-white px-4 text-center text-lg font-medium tracking-widest text-slate-800 transition duration-150 placeholder:text-sm placeholder:text-slate-400 focus:outline-none focus:ring-1 @error('otp') border-rose-400 focus:border-rose-400 focus:ring-rose-200 @else border-slate-200 focus:border-[#1A6CF0] focus:ring-[#1A6CF0] @enderror"
                        >
                        @error('otp')
                            <p class="mt-2 text-xs text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Input Kata Sandi Baru -->
                    <div>
                        <label for="password" class="mb-2 block text-xs font-semibold text-slate-700">Kata Sandi Baru</label>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            required
                            placeholder="Minimal 6 karakter"
                            class="h-12 w-full rounded-xl border bg-white px-4 text-sm text-slate-800 transition duration-150 placeholder:text-sm placeholder:text-slate-400 focus:outline-none focus:ring-1 @error('password') border-rose-400 focus:border-rose-400 focus:ring-rose-200 @else border-slate-200 focus:border-[#1A6CF0] focus:ring-[#1A6CF0] @enderror"
                        >
                        @error('password')
                            <p class="mt-2 text-xs text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Input Konfirmasi Kata Sandi Baru -->
                    <div>
                        <label for="password_confirmation" class="mb-2 block text-xs font-semibold text-slate-700">Ulangi Kata Sandi Baru</label>
                        <input
                            type="password"
                            id="password_confirmation"
                            name="password_confirmation"
                            required
                            placeholder="Ulangi kata sandi baru"
                            class="h-12 w-full rounded-xl border border-slate-200 bg-white px-4 text-sm text-slate-800 transition duration-150 placeholder:text-sm placeholder:text-slate-400 focus:border-[#1A6CF0] focus:outline-none focus:ring-1 focus:ring-[#1A6CF0]"
                        >
                        @error('password_confirmation')
                            <p class="mt-2 text-xs text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tombol Simpan -->
                    <button
                        type="submit"
                        class="flex h-12 w-full items-center justify-center rounded-xl bg-[#1A6CF0] text-sm font-semibold text-white transition duration-150 hover:bg-[#155bd0] active:bg-[#114ab0]"
                    >
                        <span>Simpan Kata Sandi Baru</span>
                    </button>

                    <!-- Tautan Kirim Ulang OTP -->
                    <div class="pt-2 text-center">
                        <a href="{{ route('password.forgot') }}" class="text-xs font-medium text-[#1A6CF0] transition hover:text-[#155bd0]">
                            Kirim ulang kode OTP
                        </a>
                    </div>
                </form>
            @else
                <!-- Langkah 1: Permintaan OTP -->
                <form method="POST" action="{{ route('password.otp.send') }}" class="space-y-4">
                    @csrf

                    <!-- Input Username / Email -->
                    <div>
                        <label for="username" class="mb-2 block text-xs font-semibold text-slate-700">Username atau Email</label>
                        <input
                            type="text"
                            id="username"
                            name="username"
                            value="{{ old('username') }}"
                            required
                            autofocus
                            placeholder="Contoh: admin atau admin@kelolain.com"
                            class="h-12 w-full rounded-xl border bg-white px-4 text-sm text-slate-800 transition duration-150 placeholder:text-sm placeholder:text-slate-400 focus:outline-none focus:ring-1 @error('username') border-rose-400 focus:border-rose-400 focus:ring-rose-200 @else border-slate-200 focus:border-[#1A6CF0] focus:ring-[#1A6CF0] @enderror"
                        >
                        @error('username')
                            <p class="mt-2 text-xs text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tombol Kirim OTP -->
                    <button
                        type="submit"
                        class="flex h-12 w-full items-center justify-center gap-2 rounded-xl bg-[#1A6CF0] text-sm font-semibold text-white transition duration-150 hover:bg-[#155bd0] active:bg-[#114ab0]"
                    >
                        <span>Kirim Kode OTP</span>
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </button>
                </form>
            @endif

            <!-- Tautan Kembali ke Login -->
            <div class="mt-8 border-t border-slate-100 pt-4 text-center">
                <a href="{{ route('login') }}" class="inline-flex items-center gap-2 text-xs font-medium text-[#1A6CF0] transition hover:text-[#155bd0]">
                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span>Kembali ke halaman masuk</span>
                </a>
            </div>
        </div>

        <!-- Footer -->
        <p class="mt-8 text-center text-xs text-slate-500">
            © 2026 Kelola.in • Akun hanya dapat didaftarkan oleh Administrator.
        </p>
    </div>
</body>

</html>
