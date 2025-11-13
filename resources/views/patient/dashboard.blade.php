@extends('layouts.patient')

@section('title', 'Dashboard Pasien')

@section('content')
    @php $pendingResults = $labResults->whereIn('status',["pending","reviewed"])->count(); @endphp

    <h1 class="text-2xl font-semibold">Dashboard Pasien</h1>
    <p class="text-gray-600">Selamat datang, {{ Auth::user()->name }}</p>

    <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-5">
        <div class="rounded-2xl border-2 border-blue-300 bg-white p-5">
            <div class="flex items-start justify-between">
                <div>
                    <div class="text-sm text-gray-600">Total Pemeriksaan</div>
                    <div class="mt-2 text-3xl font-semibold">{{ $totalResults }}</div>
                    <div class="text-xs text-gray-500 mt-1">Semua pemeriksaan</div>
                </div>
                <svg class="w-6 h-6 text-blue-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14 22v-4a4 4 0 00-8 0v4"/><circle cx="12" cy="7" r="4"/>
                </svg>
            </div>
        </div>
        <div class="rounded-2xl border-2 border-green-300 bg-white p-5">
            <div class="flex items-start justify-between">
                <div>
                    <div class="text-sm text-gray-600">Hasil Tersedia</div>
                    <div class="mt-2 text-3xl font-semibold">{{ $completedResults }}</div>
                    <div class="text-xs text-gray-500 mt-1">Siap diunduh</div>
                </div>
                <svg class="w-6 h-6 text-green-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20 6L9 17l-5-5"/>
                </svg>
            </div>
        </div>
        <div class="rounded-2xl border-2 border-yellow-300 bg-white p-5">
            <div class="flex items-start justify-between">
                <div>
                    <div class="text-sm text-gray-600">Menunggu Hasil</div>
                    <div class="mt-2 text-3xl font-semibold">{{ $pendingResults }}</div>
                    <div class="text-xs text-gray-500 mt-1">Dalam proses</div>
                </div>
                <svg class="w-6 h-6 text-yellow-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="3" width="18" height="18" rx="2"/><path d="M9 7h6M9 11h6M9 15h3"/>
                </svg>
            </div>
        </div>
    </div>

    <h2 class="mt-8 mb-3 font-semibold">Hasil Pemeriksaan Saya</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
        @foreach($labResults->take(6) as $result)
            <div class="relative rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                <div class="absolute top-4 right-4">
                    @if($result->status === 'completed')
                        <span class="text-[11px] px-2 py-1 rounded-full bg-gray-900 text-white">selesai</span>
                    @elseif($result->status === 'pending')
                        <span class="text-[11px] px-2 py-1 rounded-full bg-gray-100 text-gray-700">menunggu</span>
                    @else
                        <span class="text-[11px] px-2 py-1 rounded-full bg-blue-100 text-blue-700">direview</span>
                    @endif
                </div>
                <div class="text-lg font-semibold mb-2">{{ $result->test_type }}</div>
                <div class="flex items-center text-sm text-gray-600 mb-4">
                    <svg class="w-4 h-4 mr-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
                    {{ $result->created_at->format('Y-m-d') }}
                </div>
                <div class="text-xs text-gray-500">Dokter Pemeriksa</div>
                <div class="mb-4 text-sm font-medium">{{ $result->doctor ? $result->doctor->name : 'Belum ditentukan' }}</div>

                <div class="flex items-center gap-2">
                    @php $disabled = $result->status !== 'completed' && !$result->result_file; @endphp
                    <a href="{{ route('patient.view-lab-result', $result->id) }}"
                       class="inline-flex items-center gap-2 rounded-lg px-3 py-2 text-sm font-medium {{ $disabled ? 'bg-gray-200 text-gray-400 cursor-not-allowed' : 'bg-blue-600 text-white hover:bg-blue-700' }}">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        Lihat Detail
                    </a>
                </div>
            </div>
        @endforeach
    </div>
@endsection

