@php($unreadCount = Auth::user()->notifications()->unread()->count())
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ trim($__env->yieldContent('title') . ' — ') }}{{ config('app.name', 'TeleHealth') }}</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-900">
    <div class="min-h-screen grid grid-cols-12">
        <aside class="col-span-12 md:col-span-3 lg:col-span-2 bg-white border-r border-gray-200 flex flex-col">
            <div class="px-6 py-6 flex items-center space-x-3">
                <div class="w-9 h-9 rounded-full bg-rose-100 flex items-center justify-center text-rose-600">
                    <svg viewBox="0 0 24 24" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 12h3l2-5 4 10 2-5h5" />
                    </svg>
                </div>
                <div>
                    <div class="font-semibold">TeleHealth</div>
                    <div class="text-xs text-gray-500">Admin Panel</div>
                </div>
            </div>
            <nav class="px-3 space-y-1">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('admin.dashboard') ? 'bg-emerald-600 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12l9-9 9 9"/><path d="M9 21V9h6v12"/></svg>
                    Dashboard
                </a>
                <a href="{{ route('admin.doctors') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('admin.doctors') ? 'bg-emerald-50 text-emerald-700' : 'text-gray-700 hover:bg-gray-100' }}">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="7" r="4"/><path d="M5 22v-2a7 7 0 0114 0v2"/><path d="M19 7h2m-1-1v2"/></svg>
                    Kelola Dokter
                </a>
                <a href="{{ route('admin.patients') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('admin.patients') ? 'bg-emerald-50 text-emerald-700' : 'text-gray-700 hover:bg-gray-100' }}">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg>
                    Kelola Pasien
                </a>
                <a href="{{ route('admin.lab-staff') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('admin.lab-staff') ? 'bg-emerald-50 text-emerald-700' : 'text-gray-700 hover:bg-gray-100' }}">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2h12"/><path d="M8 2v6L4 18a4 4 0 003.8 6h8.4A4 4 0 0020 18l-4-10V2"/></svg>
                    Kelola Petugas Lab
                </a>
                <a href="{{ route('admin.lab-results') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('admin.lab-results') ? 'bg-emerald-50 text-emerald-700' : 'text-gray-700 hover:bg-gray-100' }}">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="8" y="2" width="8" height="4" rx="1"/><path d="M8 6h8v14a2 2 0 01-2 2H10a2 2 0 01-2-2V6z"/><path d="M9 12h6"/><path d="M9 9h6"/></svg>
                    Hasil Laboratorium
                </a>
                <a href="{{ route('admin.reports') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('admin.reports') ? 'bg-emerald-600 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3v18h18"/><rect x="7" y="10" width="3" height="7" rx="1"/><rect x="12" y="7" width="3" height="10" rx="1"/><rect x="17" y="13" width="3" height="4" rx="1"/></svg>
                    Laporan Sistem
                </a>
            </nav>
            <div class="mt-auto p-3">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium text-red-600 hover:bg-red-50">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><path d="M16 17l5-5-5-5"/><path d="M21 12H9"/></svg>
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        <main class="col-span-12 md:col-span-9 lg:col-span-10">
            <div class="h-16 bg-white border-b border-gray-200 flex items-center px-4 sm:px-6 lg:px-8 justify-between">
                <div class="relative w-full max-w-xl">
                    <span class="absolute inset-y-0 left-3 flex items-center text-gray-400">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.3-4.3"/></svg>
                    </span>
                    <input type="text" placeholder="Cari data..." class="w-full pl-10 pr-3 py-2 rounded-xl border-gray-300 bg-gray-50 focus:border-emerald-600 focus:ring-emerald-600">
                </div>
                <div class="flex items-center gap-4">
                    <a href="{{ route('notifications.index') }}" class="relative text-gray-500 hover:text-gray-700">
                        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 17h5l-1.4-1.4A2 2 0 0118 14.2V11a6 6 0 00-4-5.7V5a2 2 0 10-4 0v.3C7.7 6.2 6 8.4 6 11v3.2c0 .5-.2 1-.6 1.4L4 17h5"/></svg>
                        @if($unreadCount > 0)
                            <span class="absolute -top-1 -right-1 text-[10px] leading-none px-1.5 py-0.5 rounded-full bg-red-600 text-white">{{ $unreadCount }}</span>
                        @endif
                    </a>
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-blue-600 text-white flex items-center justify-center text-sm font-semibold">
                            {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                        </div>
                        <div class="hidden sm:block">
                            <div class="text-sm font-medium">{{ Auth::user()->name }}</div>
                            <div class="text-xs text-gray-500">Admin</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="px-4 sm:px-6 lg:px-8 py-6">
                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>
