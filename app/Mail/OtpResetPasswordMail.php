<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OtpResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Membuat instance email OTP reset kata sandi.
     */
    public function __construct(
        public User $user,
        public string $otpCode,
        public int $lifetimeMinutes = 10,
    ) {
    }

    /**
     * Mendefinisikan subjek dan metadata amplop email.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Kode OTP Reset Kata Sandi - Kelola.in',
        );
    }

    /**
     * Mendefinisikan template view isi email.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.otp-reset-password',
        );
    }

    /**
     * Daftar lampiran email (tidak ada).
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
