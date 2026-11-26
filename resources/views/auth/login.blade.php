<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - Kelola.in</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <!-- Tailwind CSS CDN -->
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

<body class="min-h-screen w-full bg-white flex flex-col lg:flex-row">
    <!-- Kolom Kiri: Foto Rak Sembako + Overlay Gelap Tipis + Branding -->
    <div class="hidden lg:flex lg:w-1/2 relative min-h-screen flex-col justify-center px-12 xl:px-14 overflow-hidden">
        <!-- Foto Latar Belakang Rak Sembako -->
        <img
            src="{{ asset('images/backgroundkelola.jpg') }}"
            alt="Latar Belakang Rak Toko Sembako"
            class="absolute inset-0 w-full h-full object-cover"
            onerror="this.style.display='none'; this.parentElement.classList.add('bg-slate-200');"
        >
        <!-- Overlay Putih Transparan (~45%) -->
        <div class="absolute inset-0 bg-[#1E3A5F]/45 backdrop-blur-[0.5px]"></div>

        <!-- Konten Branding -->
        <div class="relative z-10 max-w-md">
            <!-- Logo Toko -->
            <div class="mb-4">
                <img
                    src="{{ asset('images/logo.png') }}"
                    alt="Logo Kelola.in"
                    class="w-16 h-16 object-contain"
                    onerror="this.style.display='none'; document.getElementById('logo-fallback').style.display='flex';"
                >
                <!-- Fallback jika file logo.png belum diletakkan di public/images -->
                <div id="logo-fallback" class="w-16 h-16 bg-[#1A6CF0] rounded-2xl items-center justify-center shadow-md relative" style="display: none;">
                    <svg class="w-9 h-9 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                        <line x1="3" y1="6" x2="21" y2="6"></line>
                        <path d="M16 10a4 4 0 0 1-8 0"></path>
                        <polyline points="9 13 11 15 15 11" stroke-width="2.5"></polyline>
                    </svg>
                </div>
            </div>

            <!-- Teks Branding -->
            <h1 class="text-3xl xl:text-4xl font-black tracking-wide text-[#1A6CF0] mb-3">
                KELOLA.IN
            </h1>
            <h2 class="text-lg xl:text-xl font-bold text-[#FFFFFF] mb-3 drop-shadow-[0_2px_4px_rgba(0,0,0,0.8)]">
                Kelola Toko, Lebih Mudah
            </h2>

            <p class="text-base xl:text-lg font-normal text-[#FFFFFF] leading-snug max-w-xs drop-shadow-[0_2px_4px_rgba(0,0,0,0.8)]">
                Solusi lengkap untuk mengelola toko Anda dengan lebih praktis dan efisien
            </p>
        </div>
    </div>

    <!-- Kolom Kanan: Form Login -->
    <div class="w-full lg:w-1/2 min-h-screen bg-white flex flex-col items-center justify-center px-6 py-12">
        <div class="w-full max-w-[420px]">
            <!-- Judul & Subjudul Form -->
            <div class="text-center mb-7">
                <h2 class="text-2xl sm:text-[28px] font-bold text-[#0F2B5C] tracking-tight">
                    Selamat Datang!
                </h2>
                <p class="text-xs text-slate-500 mt-2">
                    Masuk ke akun Anda untuk melanjutkan
                </p>
            </div>

            <!-- Notifikasi Status / Logout Sukses -->
            @if (session('status'))
                <div class="mb-4 p-3 bg-emerald-50 border border-emerald-200 rounded-lg flex items-center gap-2 text-emerald-800 text-xs">
                    <svg class="w-4 h-4 shrink-0 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>{{ session('status') }}</span>
                </div>
            @endif

            <!-- Notifikasi Error Validasi / Login -->
            @if ($errors->any())
                <div class="mb-4 p-3 bg-rose-50 border border-rose-200 rounded-lg text-rose-800 text-xs">
                    <div class="flex items-center gap-1.5 font-semibold mb-1 text-rose-700">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Terjadi kesalahan:</span>
                    </div>
                    <ul class="list-disc list-inside space-y-0.5 text-[11px]">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Form Login -->
            <form method="POST" action="{{ route('login.attempt') }}" class="space-y-4">
                @csrf

                <!-- Input Username / Email -->
                <div>
                    <label for="username" class="block text-xs font-semibold text-slate-700 mb-1">
                        Username atau Email
                    </label>
                    <input
                        type="text"
                        id="username"
                        name="username"
                        value="{{ old('username') }}"
                        required
                        autofocus
                        placeholder="Masukkan email"
                        class="w-full h-10 px-3.5 rounded-lg border border-slate-500 text-sm text-slate-800 placeholder:text-xs placeholder:text-slate-400 focus:outline-none focus:border-[#1A6CF0] focus:ring-1 focus:ring-[#1A6CF0] transition"
                    >
                </div>

                <!-- Input Password -->
                <div>
                    <label for="password" class="block text-xs font-semibold text-slate-700 mb-1">
                        Password
                    </label>
                    <div class="relative">
                        <input
                            type="password"
                            id="password"
                            name="password"
                            required
                            placeholder="Masukkan Password"
                            class="w-full h-10 px-3.5 pr-10 rounded-lg border border-slate-500 text-sm text-slate-800 placeholder:text-xs placeholder:text-slate-400 focus:outline-none focus:border-[#1A6CF0] focus:ring-1 focus:ring-[#1A6CF0] transition"
                        >
                        <!-- Tombol Toggle Tampilkan / Sembunyikan Password -->
                        <button
                            type="button"
                            id="togglePasswordBtn"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 focus:outline-none"
                            aria-label="Tampilkan atau sembunyikan kata sandi"
                        >
                            <!-- Ikon Mata Dicoret (Default: Tersembunyi) -->
                            <svg id="eyeSlashIcon" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                            </svg>
                            <!-- Ikon Mata Terbuka (Saat Terlihat) -->
                            <svg id="eyeIcon" class="w-4 h-4 hidden" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Checkbox Remember Me & Tautan Forgot Password -->
                <div class="flex items-center justify-between text-xs pt-1">
                    <label class="flex items-center gap-1.5 cursor-pointer text-slate-600 select-none">
                        <input
                            type="checkbox"
                            name="remember"
                            id="remember"
                            class="w-3.5 h-3.5 rounded border-slate-400 text-[#1A6CF0] focus:ring-[#1A6CF0]"
                        >
                        <span>Remember me</span>
                    </label>

                    <a href="{{ route('password.forgot') }}" class="text-[#1A6CF0] hover:underline font-medium text-xs">
                        Forgot Password ?
                    </a>
                </div>

                <!-- Tombol Submit Log In -->
                <button
                    type="submit"
                    class="w-full h-10 mt-5 bg-[#1A6CF0] hover:bg-[#155bd0] active:bg-[#114ab0] text-white font-semibold text-sm rounded-lg transition duration-150 flex items-center justify-center"
                >
                    Log In
                </button>
            </form>
        </div>
    </div>

    <!-- JavaScript Toggle Show/Hide Password -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toggleBtn = document.getElementById('togglePasswordBtn');
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');
            const eyeSlashIcon = document.getElementById('eyeSlashIcon');

            if (toggleBtn && passwordInput) {
                toggleBtn.addEventListener('click', function () {
                    const isPassword = passwordInput.getAttribute('type') === 'password';
                    passwordInput.setAttribute('type', isPassword ? 'text' : 'password');

                    if (isPassword) {
                        eyeSlashIcon.classList.add('hidden');
                        eyeIcon.classList.remove('hidden');
                    } else {
                        eyeIcon.classList.add('hidden');
                        eyeSlashIcon.classList.remove('hidden');
                    }
                });
            }
        });
    </script>
</body>

</html>
