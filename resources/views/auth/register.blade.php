<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'TeleHealth') }} — Register</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased bg-gradient-to-br from-emerald-50 via-white to-blue-50 text-gray-900">
        <div class="min-h-screen grid grid-cols-1 lg:grid-cols-2">
            <!-- Left: Branding -->
            <div class="hidden lg:flex flex-col justify-center px-14 py-12 bg-gradient-to-br from-emerald-600 via-teal-600 to-blue-600 text-white">
                <div class="max-w-md">
                    <div class="flex items-center justify-center w-28 h-28 rounded-full bg-white/20 backdrop-blur-sm mx-0 mb-6">
                        <svg viewBox="0 0 24 24" class="w-14 h-14 text-white" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 12h3l2-5 4 10 2-5h5" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-2">Buat Akun TeleHealth</h3>
                    <p class="text-lg opacity-95 mb-8">Akses sistem laporan laboratorium digital</p>
                </div>
            </div>

            <!-- Right: Register form -->
            <div class="flex items-center justify-center px-6 py-10 lg:px-12">
                <div class="w-full max-w-md">
                    <div class="flex flex-col items-center text-center mb-8">
                        <div class="w-20 h-20 rounded-full bg-gradient-to-r from-emerald-500 to-blue-600 flex items-center justify-center shadow-lg">
                            <svg viewBox="0 0 24 24" class="w-10 h-10 text-white" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 12h3l2-5 4 10 2-5h5" />
                            </svg>
                        </div>
                        <h1 class="mt-4 text-2xl font-bold text-gray-800">{{ config('app.name','TeleHealth') }}</h1>
                        <p class="text-gray-600 mt-1">Digital Laboratory Report System</p>
                    </div>

                    <form method="POST" action="{{ route('register') }}" class="space-y-5">
                        @csrf

                        <!-- Role Selection -->
                        <div>
                            <label for="role" class="block text-sm font-medium text-gray-700 mb-2">Pilih Peran</label>
                            <div class="relative">
                                <select id="role" name="role" class="block w-full rounded-xl border-gray-300 pr-10 py-3 px-4 bg-gray-50 focus:border-emerald-600 focus:ring-emerald-600 shadow-sm transition">
                                    <option value="patient" {{ old('role')==='patient' ? 'selected' : '' }}>Pasien</option>
                                    <option value="doctor" {{ old('role')==='doctor' ? 'selected' : '' }}>Dokter</option>
                                    <option value="lab" {{ old('role')==='lab' ? 'selected' : '' }}>Petugas Lab</option>
                                    <option value="admin" {{ old('role')==='admin' ? 'selected' : '' }}>Admin</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                    <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.24 4.5a.75.75 0 01-1.08 0l-4.24-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>
                            <x-input-error :messages="$errors->get('role')" class="mt-2" />
                        </div>

                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                            <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus autocomplete="name"
                                   class="block w-full rounded-xl border-gray-300 px-4 py-3 bg-gray-50 focus:border-emerald-600 focus:ring-emerald-600 shadow-sm transition" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Email Address -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-emerald-600">
                                    <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M4 4h16v16H4z" fill="none" />
                                        <path d="M22 6l-10 7L2 6" />
                                    </svg>
                                </span>
                                <input id="email" name="email" type="email" value="{{ old('email') }}" required autocomplete="username"
                                       class="block w-full rounded-xl border-gray-300 pl-10 pr-4 py-3 bg-gray-50 focus:border-emerald-600 focus:ring-emerald-600 shadow-sm transition" />
                            </div>
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- Password -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-emerald-600">
                                    <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
                                        <path d="M7 11V7a5 5 0 0110 0v4" />
                                    </svg>
                                </span>
                                <input id="password" name="password" type="password" required autocomplete="new-password"
                                       class="block w-full rounded-xl border-gray-300 pl-10 pr-4 py-3 bg-gray-50 focus:border-emerald-600 focus:ring-emerald-600 shadow-sm transition" />
                            </div>
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-emerald-600">
                                    <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
                                        <path d="M7 11V7a5 5 0 0110 0v4" />
                                    </svg>
                                </span>
                                <input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password"
                                       class="block w-full rounded-xl border-gray-300 pl-10 pr-4 py-3 bg-gray-50 focus:border-emerald-600 focus:ring-emerald-600 shadow-sm transition" />
                            </div>
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </div>

                        <button type="submit" class="w-full inline-flex justify-center items-center rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-4 shadow-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-300">
                            Daftar
                            <svg class="ml-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7-7l7 7-7 7" />
                            </svg>
                        </button>
                    </form>

                    <div class="mt-6 text-center">
                        <p class="text-gray-600">
                            Sudah punya akun?
                            <a href="{{ route('login') }}" class="text-emerald-700 hover:text-emerald-800 font-semibold transition hover:underline">
                                Masuk di sini
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
