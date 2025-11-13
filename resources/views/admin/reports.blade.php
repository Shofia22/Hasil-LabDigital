@extends('layouts.admin')

@section('title', 'Laporan Sistem')

@section('content')
    <h1 class="text-2xl font-semibold">Laporan Sistem</h1>
    <p class="text-gray-600">Laporan aktivitas dan statistik sistem</p>

    <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h3 class="font-semibold mb-4">Statistik Bulanan</h3>
            <ul class="space-y-2 text-sm">
                <li class="flex items-center justify-between">
                    <span>Total Pemeriksaan</span>
                    <span class="font-semibold">{{ $totalResults }}</span>
                </li>
                <li class="flex items-center justify-between text-emerald-700">
                    <span>Pemeriksaan Selesai</span>
                    <span class="font-semibold">{{ $completed }}</span>
                </li>
                <li class="flex items-center justify-between text-yellow-600">
                    <span>Dalam Proses</span>
                    <span class="font-semibold">{{ $inProcess }}</span>
                </li>
            </ul>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h3 class="font-semibold mb-4">Pengguna Aktif</h3>
            <ul class="space-y-2 text-sm">
                <li class="flex items-center justify-between"><span>Dokter</span><span class="font-semibold">{{ $doctorCount }}</span></li>
                <li class="flex items-center justify-between"><span>Pasien</span><span class="font-semibold">{{ $patientCount }}</span></li>
                <li class="flex items-center justify-between"><span>Petugas Lab</span><span class="font-semibold">{{ $labStaffCount }}</span></li>
            </ul>
        </div>
    </div>

    <div class="mt-8 bg-white rounded-xl border border-gray-200 p-6">
        <h3 class="font-semibold mb-4">Aktivitas Terbaru</h3>
        <div class="space-y-3">
            @forelse($recentActivity as $activity)
                <div class="rounded-lg p-4 flex items-start gap-3 border border-gray-100">
                    <div class="w-9 h-9 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="16" rx="2"/><path d="M7 8h10M7 12h6"/></svg>
                    </div>
                    <div>
                        <div class="text-sm">{{ $activity->action }}</div>
                        <div class="text-xs text-gray-500">{{ $activity->created_at->diffForHumans() }}</div>
                    </div>
                </div>
            @empty
                <div class="text-gray-500">Belum ada aktivitas.</div>
            @endforelse
        </div>
    </div>
@endsection
