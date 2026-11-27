<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya - Kelola.in</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style> body { font-family: 'Plus Jakarta Sans', sans-serif; } </style>
</head>
<body class="bg-slate-50 min-h-screen">
    <!-- Navbar Top -->
    <header class="bg-white border-b border-slate-200 sticky top-0 z-30">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 h-16 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ url('/') }}" class="w-10 h-10 bg-[#1A6CF0] hover:bg-emerald-700 text-white rounded-xl flex items-center justify-center font-bold shadow-md shadow-emerald-500/20 transition">
                    K
                </a>
                <div>
                    <h1 class="text-base font-bold text-slate-800 leading-tight">Kelola.in</h1>
                    <span class="text-xs text-[#1A6CF0] font-semibold tracking-wide uppercase">Pengaturan Profil Akun</span>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ url('/') }}" class="px-3.5 py-1.5 text-xs font-semibold text-slate-600 hover:text-slate-800 bg-slate-100 hover:bg-slate-200 rounded-lg transition">
                    ← Kembali ke Dashboard
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="px-3.5 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-700 text-xs font-semibold rounded-lg border border-rose-200 transition">
                        Keluar
                    </button>
                </form>
            </div>
        </div>
    </header>

    <main class="max-w-5xl mx-auto px-4 sm:px-6 py-8">
        <!-- Header Profil -->
        <div class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 shadow-sm mb-8 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6">
            <div class="flex items-center gap-5">
                <div class="w-16 h-16 rounded-2xl bg-[#1A6CF0] text-white font-bold flex items-center justify-center text-xl uppercase shadow-lg shadow-[#1A6CF0]/20">
                    {{ substr($user->name, 0, 2) }}
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-slate-800">{{ $user->name }}</h2>
                    <p class="text-xs sm:text-sm text-slate-500 mt-0.5">
                        <span class="font-mono text-slate-700">@<span>{{ $user->username }}</span></span> • <span class="font-mono text-slate-700">{{ $user->email }}</span>
                    </p>
                </div>
            </div>

            <div class="flex flex-col sm:items-end gap-2 w-full sm:w-auto pt-4 sm:pt-0 border-t sm:border-t-0 border-slate-100">
                <div class="flex items-center gap-2">
                    <span class="text-xs text-slate-400">Peran Sistem:</span>
                    <span class="px-3 py-1 bg-indigo-50 text-indigo-700 border border-indigo-200 text-xs font-bold rounded-lg uppercase tracking-wide">
                        {{ $user->role?->name ?? 'Belum ada role' }}
                    </span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-xs text-slate-400">Status Akun:</span>
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 bg-emerald-50 text-emerald-700 border border-emerald-200 text-xs font-semibold rounded-md">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                        Aktif
                    </span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- 1. Formulir Ubah Informasi Profil -->
            <div class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 shadow-sm flex flex-col justify-between">
                <div>
                    <div class="mb-6 pb-4 border-b border-slate-100">
                        <h3 class="text-lg font-bold text-slate-800">Informasi Pribadi</h3>
                        <p class="text-xs text-slate-500 mt-1">Perbarui nama lengkap, username akun, dan alamat email Anda.</p>
                    </div>

                    @if (session('success_profile'))
                        <div class="mb-5 p-3.5 bg-emerald-50 border border-emerald-200 rounded-xl flex items-center gap-2.5 text-emerald-800 text-xs font-medium">
                            <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span>{{ session('success_profile') }}</span>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('profile.update') }}" class="space-y-4">
                        @csrf
                        @method('PUT')

                        <!-- Nama Lengkap -->
                        <div>
                            <label for="name" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">
                                Nama Lengkap
                            </label>
                            <input
                                type="text"
                                id="name"
                                name="name"
                                value="{{ old('name', $user->name) }}"
                                required
                                class="w-full px-3.5 py-2.5 rounded-xl border @error('name') border-rose-400 focus:ring-rose-200 @else border-slate-300 focus:ring-emerald-200 focus:border-emerald-600 @enderror text-sm text-slate-800 focus:outline-none focus:ring-4 transition"
                            >
                            @error('name')
                                <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Username -->
                        <div>
                            <label for="username" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">
                                Username
                            </label>
                            <input
                                type="text"
                                id="username"
                                name="username"
                                value="{{ old('username', $user->username) }}"
                                required
                                class="w-full px-3.5 py-2.5 rounded-xl border @error('username') border-rose-400 focus:ring-rose-200 @else border-slate-300 focus:ring-emerald-200 focus:border-emerald-600 @enderror text-sm text-slate-800 focus:outline-none focus:ring-4 transition"
                            >
                            @error('username')
                                <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">
                                Alamat Email
                            </label>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                value="{{ old('email', $user->email) }}"
                                required
                                class="w-full px-3.5 py-2.5 rounded-xl border @error('email') border-rose-400 focus:ring-rose-200 @else border-slate-300 focus:ring-emerald-200 focus:border-emerald-600 @enderror text-sm text-slate-800 focus:outline-none focus:ring-4 transition"
                            >
                            @error('email')
                                <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Keterangan Keamanan Role & Status -->
                        <div class="p-3 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-500 space-y-1">
                            <p>🔒 <strong>Peran Sistem:</strong> <span class="text-slate-700 font-semibold">{{ $user->role?->name }}</span> (Hanya dapat diubah oleh Admin).</p>
                            <p>🔒 <strong>Status Akun:</strong> <span class="text-slate-700 font-semibold">Aktif</span> (Dikelola oleh Admin).</p>
                        </div>

                        <div class="pt-2">
                            <button
                                type="submit"
                                class="w-full py-2.5 px-4 bg-[#1A6CF0] hover:bg-emerald-700 active:bg-emerald-800 text-white font-semibold text-sm rounded-xl shadow-md shadow-emerald-600/20 transition"
                            >
                                Simpan Informasi Profil
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- 2. Formulir Ubah Kata Sandi -->
            <div class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 shadow-sm flex flex-col justify-between">
                <div>
                    <div class="mb-6 pb-4 border-b border-slate-100">
                        <h3 class="text-lg font-bold text-slate-800">Ubah Kata Sandi</h3>
                        <p class="text-xs text-slate-500 mt-1">Pastikan akun Anda tetap aman dengan menggunakan kata sandi yang kuat.</p>
                    </div>

                    @if (session('success_password'))
                        <div class="mb-5 p-3.5 bg-emerald-50 border border-emerald-200 rounded-xl flex items-center gap-2.5 text-emerald-800 text-xs font-medium">
                            <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span>{{ session('success_password') }}</span>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('profile.password.update') }}" class="space-y-4">
                        @csrf
                        @method('PUT')

                        <!-- Kata Sandi Saat Ini -->
                        <div>
                            <label for="current_password" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">
                                Kata Sandi Saat Ini
                            </label>
                            <input
                                type="password"
                                id="current_password"
                                name="current_password"
                                required
                                placeholder="Masukkan kata sandi lama Anda"
                                class="w-full px-3.5 py-2.5 rounded-xl border @error('current_password') border-rose-400 focus:ring-rose-200 @else border-slate-300 focus:ring-emerald-200 focus:border-emerald-600 @enderror text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-4 transition"
                            >
                            @error('current_password')
                                <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Kata Sandi Baru -->
                        <div>
                            <label for="password" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">
                                Kata Sandi Baru
                            </label>
                            <input
                                type="password"
                                id="password"
                                name="password"
                                required
                                placeholder="Minimal 6 karakter"
                                class="w-full px-3.5 py-2.5 rounded-xl border @error('password') border-rose-400 focus:ring-rose-200 @else border-slate-300 focus:ring-emerald-200 focus:border-emerald-600 @enderror text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-4 transition"
                            >
                            @error('password')
                                <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Konfirmasi Kata Sandi Baru -->
                        <div>
                            <label for="password_confirmation" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">
                                Konfirmasi Kata Sandi Baru
                            </label>
                            <input
                                type="password"
                                id="password_confirmation"
                                name="password_confirmation"
                                required
                                placeholder="Ulangi kata sandi baru"
                                class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-emerald-200 focus:border-emerald-600 text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-4 transition"
                            >
                        </div>

                        <div class="p-3 bg-amber-50 border border-amber-200 rounded-xl text-xs text-amber-800">
                            🛡️ <strong>Prinsip Privasi:</strong> Kata sandi asli Anda tidak pernah ditampilkan kembali pada layar demi menjaga kerahasiaan akun.
                        </div>

                        <div class="pt-2">
                            <button
                                type="submit"
                                class="w-full py-2.5 px-4 bg-slate-800 hover:bg-slate-900 active:bg-black text-white font-semibold text-sm rounded-xl shadow-md transition"
                            >
                                Perbarui Kata Sandi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
