@extends('layouts.patient')

@section('title', 'Hasil Pemeriksaan')

@section('content')
    <h1 class="text-2xl font-semibold">Hasil Pemeriksaan Saya</h1>

    <!-- Filter Bar -->
    <form method="GET" action="{{ route('patient.lab-results') }}" class="mt-4 mb-6 grid grid-cols-1 md:grid-cols-3 gap-3">
        <div>
            <label class="block text-sm text-gray-600 mb-1">Status</label>
            <select name="status" class="w-full rounded-xl border-gray-300 bg-white focus:border-emerald-600 focus:ring-emerald-600">
                <option value="" {{ request('status')==='' ? 'selected' : '' }}>Semua</option>
                <option value="completed" {{ request('status')==='completed' ? 'selected' : '' }}>Selesai</option>
                <option value="reviewed" {{ request('status')==='reviewed' ? 'selected' : '' }}>Direview</option>
                <option value="pending" {{ request('status')==='pending' ? 'selected' : '' }}>Menunggu</option>
            </select>
        </div>
        <div class="md:col-span-2">
            <label class="block text-sm text-gray-600 mb-1">Cari</label>
            <div class="relative">
                <span class="absolute inset-y-0 left-3 flex items-center text-gray-400">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.3-4.3"/></svg>
                </span>
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari pemeriksaan / dokter" class="w-full pl-10 rounded-xl border-gray-300 bg-white focus:border-emerald-600 focus:ring-emerald-600">
            </div>
        </div>
        <div class="flex items-end gap-3">
            <button class="inline-flex items-center px-4 py-2 rounded-xl bg-emerald-600 text-white hover:bg-emerald-700">Terapkan</button>
            <a href="{{ route('patient.lab-results') }}" class="inline-flex items-center px-4 py-2 rounded-xl bg-gray-100 text-gray-700 hover:bg-gray-200">Reset</a>
        </div>
    </form>

    <!-- Counter -->
    <div class="mb-3 text-sm text-gray-600">
        @if($labResults->total() > 0)
            Menampilkan {{ $labResults->firstItem() }}–{{ $labResults->lastItem() }} dari {{ $labResults->total() }} hasil
        @else
            Tidak ada hasil.
        @endif
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
        @forelse($labResults as $result)
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
                <div class="flex items-center text-sm text-gray-600 mb-3">
                    <svg class="w-4 h-4 mr-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
                    {{ $result->created_at->format('Y-m-d') }}
                </div>
                <div class="text-xs text-gray-500">Dokter Pemeriksa</div>
                <div class="mb-4 text-sm font-medium">{{ $result->doctor ? $result->doctor->name : 'Belum ditentukan' }}</div>

                <div class="flex items-center gap-2">
                    <a href="{{ route('patient.view-lab-result', $result->id) }}"
                       class="inline-flex items-center gap-2 rounded-lg px-3 py-2 text-sm font-medium bg-blue-600 text-white hover:bg-blue-700">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        Lihat Detail
                    </a>
                    <a href="{{ route('patient.download-result-pdf', $result->id) }}"
                       class="inline-flex items-center gap-2 rounded-lg px-3 py-2 text-sm font-medium bg-gray-900 text-white hover:bg-gray-800">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4Z"/></svg>
                        PDF
                    </a>
                    @if($result->result_file)
                        <a href="{{ route('patient.download-result-file', $result->id) }}"
                           class="inline-flex items-center gap-2 rounded-lg px-3 py-2 text-sm font-medium bg-emerald-50 text-emerald-700 hover:bg-emerald-100">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                            Unduh
                        </a>
                    @endif
                </div>
            </div>
        @empty
            <div class="col-span-full">
                <div class="rounded-xl border border-gray-200 bg-white p-8 text-center text-gray-500">Belum ada hasil pemeriksaan.</div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $labResults->onEachSide(1)->links() }}
    </div>
@endsection
