<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>TeleHealth — Login</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased bg-gradient-to-br from-emerald-50 via-white to-blue-50 text-gray-900">
        <div class="min-h-screen grid grid-cols-1 lg:grid-cols-2">
            <!-- Left: Modern Intro with gradient -->
            <div class="hidden lg:flex flex-1 items-center justify-center px-14 py-12 bg-gradient-to-br from-emerald-600 via-teal-600 to-blue-600 text-white">
                <div class="w-full max-w-lg text-center">
                    <div class="flex items-center justify-center">
                        <div class="flex h-28 w-28 items-center justify-center rounded-full bg-white/20 backdrop-blur-sm mb-6">
                            <svg viewBox="0 0 24 24" class="w-14 h-14 text-white" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 12h3l2-5 4 10 2-5h5" />
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-3xl font-bold mb-4">Digital Laboratory Report System</h3>
                    <p class="text-xl leading-relaxed mb-8">
                        Secure access to laboratory results for healthcare providers and patients
                    </p>

                    <div class="grid grid-cols-3 gap-4 mb-8">
                        <div class="bg-white/20 backdrop-blur-sm rounded-xl p-4 text-center">
                            <div class="text-2xl font-bold">99%</div>
                            <div class="text-sm">Accuracy</div>
                        </div>
                        <div class="bg-white/20 backdrop-blur-sm rounded-xl p-4 text-center">
                            <div class="text-2xl font-bold">24/7</div>
                            <div class="text-sm">Access</div>
                        </div>
                        <div class="bg-white/20 backdrop-blur-sm rounded-xl p-4 text-center">
                            <div class="text-2xl font-bold">100%</div>
                            <div class="text-sm">Secure</div>
                        </div>
                    </div>

                    <div class="bg-white/10 backdrop-blur-sm rounded-2xl overflow-hidden shadow-2xl">
                        <img alt="Medical Dashboard" class="w-full h-64 object-cover opacity-90" loading="lazy"
                             src="https://images.unsplash.com/photo-1585421514738-01798e348b17?q=80&w=1200&auto=format&fit=crop" />
                    </div>
                </div>
            </div>

            <!-- Right: Form with modern design -->
            <div class="flex items-center justify-center px-6 py-10 lg:px-12">
                <div class="w-full max-w-md">
                    <div class="flex flex-col items-center text-center mb-10">
                        <div class="w-20 h-20 rounded-full bg-gradient-to-r from-emerald-500 to-blue-600 flex items-center justify-center shadow-lg">
                            <svg viewBox="0 0 24 24" class="w-10 h-10 text-white" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 12h3l2-5 4 10 2-5h5" />
                            </svg>
                        </div>
                        <h1 class="mt-4 text-2xl font-bold text-gray-800">TeleHealth</h1>
                        <p class="text-gray-600 mt-1">Digital Laboratory Report System</p>
                    </div>

                    <!-- Session status -->
                    <x-auth-session-status class="mb-4" :status="session('status')" />

                    <form method="POST" action="{{ route('login') }}" class="space-y-6" novalidate>
                        @csrf

                        <!-- Email / Username -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg viewBox="0 0 24 24" class="h-5 w-5 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M4 4h16v16H4z" fill="none" />
                                        <path d="M22 6l-10 7L2 6" />
                                    </svg>
                                </div>
                                <input id="email" name="email" type="email" autocomplete="username" required autofocus
                                       placeholder="email@example.com"
                                       value="{{ old('email') }}"
                                       class="block w-full rounded-xl border-gray-300 pl-10 pr-4 py-3 bg-gray-50 focus:border-emerald-600 focus:ring-emerald-600 shadow-sm transition" />
                            </div>
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- Password -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg viewBox="0 0 24 24" class="h-5 w-5 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
                                        <path d="M7 11V7a5 5 0 0110 0v4" />
                                    </svg>
                                </div>
                                <input id="password" name="password" type="password" autocomplete="current-password" required
                                       class="block w-full rounded-xl border-gray-300 pl-10 pr-4 py-3 bg-gray-50 focus:border-emerald-600 focus:ring-emerald-600 shadow-sm transition" />
                            </div>
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <!-- Remember Me + Forgot Password -->
                        <div class="flex items-center justify-between">
                            <label for="remember_me" class="inline-flex items-center select-none">
                                <input id="remember_me" type="checkbox" name="remember" class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-600 shadow-sm">
                                <span class="ml-2 text-sm text-gray-600">Ingat saya</span>
                            </label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-sm text-emerald-700 hover:text-emerald-800 font-medium transition hover:underline">
                                    Lupa kata sandi?
                                </a>
                            @endif
                        </div>

                        <button type="submit" class="w-full inline-flex justify-center items-center rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-4 shadow-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-300">
                            Masuk
                            <svg class="ml-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                            </svg>
                        </button>
                    </form>

                    <!-- Demo credentials box -->
                    <div class="mt-8 rounded-xl bg-gradient-to-r from-emerald-50 to-blue-50 border border-emerald-100 p-4 text-sm">
                        <p class="font-semibold text-emerald-800 mb-2 flex items-center">
                            <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Demo Credentials
                        </p>
                        <p class="text-emerald-700">For testing purposes:</p>
                        <ul class="mt-1 text-emerald-700 space-y-1">
                            <li class="flex justify-between">
                                <span>Admin:</span>
                                <span>admin@example.com / password</span>
                            </li>
                            <li class="flex justify-between">
                                <span>Doctor:</span>
                                <span>doctor@example.com / password</span>
                            </li>
                            <li class="flex justify-between">
                                <span>Lab Staff:</span>
                                <span>lab@example.com / password</span>
                            </li>
                            <li class="flex justify-between">
                                <span>Patient:</span>
                                <span>patient@example.com / password</span>
                            </li>
                        </ul>
                    </div>

                    <!-- Registration link -->
                    @if (Route::has('register'))
                    <div class="mt-6 text-center">
                        <p class="text-gray-600">
                            Belum punya akun?
                            <a href="{{ route('register') }}" class="text-emerald-700 hover:text-emerald-800 font-semibold transition hover:underline">
                                Daftar sekarang
                            </a>
                        </p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Clean page: no extra scripts needed -->
    </body>
 </html>
