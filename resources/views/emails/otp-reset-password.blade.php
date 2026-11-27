<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kode OTP Reset Kata Sandi</title>
</head>
<body style="margin:0;padding:0;background-color:#F3F6FC;font-family:Arial,Helvetica,sans-serif;color:#0F2B5C;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="padding:32px 16px;">
        <tr>
            <td align="center">
                <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="max-width:520px;background-color:#FFFFFF;border:1px solid #E5EAF3;border-radius:16px;padding:32px;">
                    <tr>
                        <td>
                            <p style="margin:0 0 8px 0;font-size:18px;font-weight:700;color:#1A6CF0;">KELOLA.IN</p>
                            <h1 style="margin:0 0 16px 0;font-size:20px;font-weight:700;color:#0F2B5C;">Kode OTP Reset Kata Sandi</h1>
                            <p style="margin:0 0 16px 0;font-size:14px;line-height:1.6;color:#334155;">
                                Halo <strong>{{ $user->name }}</strong>,
                            </p>
                            <p style="margin:0 0 20px 0;font-size:14px;line-height:1.6;color:#334155;">
                                Kami menerima permintaan pengaturan ulang kata sandi untuk akun <strong>{{ $user->username }}</strong>. Gunakan kode OTP berikut untuk melanjutkan proses reset kata sandi:
                            </p>

                            <div style="margin:24px 0;padding:18px 24px;background-color:#EEF5FF;border:1px dashed #1A6CF0;border-radius:12px;text-align:center;">
                                <span style="font-size:32px;font-weight:700;letter-spacing:8px;color:#0F2B5C;">{{ $otpCode }}</span>
                            </div>

                            <p style="margin:0 0 12px 0;font-size:13px;line-height:1.6;color:#475569;">
                                Kode OTP ini berlaku selama <strong>{{ $lifetimeMinutes }} menit</strong> dan hanya dapat digunakan satu kali.
                            </p>
                            <p style="margin:0 0 24px 0;font-size:13px;line-height:1.6;color:#B91C1C;">
                                Demi keamanan akun Anda, jangan bagikan kode ini kepada siapa pun, termasuk pihak yang mengaku dari Kelola.in.
                            </p>

                            <hr style="border:none;border-top:1px solid #E5EAF3;margin:20px 0;">
                            <p style="margin:0;font-size:12px;color:#64748B;">
                                Jika Anda tidak merasa meminta reset kata sandi, abaikan email ini.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
