@extends('layouts.doctor')

@section('title', 'Catatan Dokter')

@section('content')
    <div class="flex items-start justify-between">
        <div>
            <h1 class="text-2xl font-semibold">Catatan Dokter</h1>
            <p class="text-gray-600">Riwayat catatan dan diagnosis yang telah diberikan</p>
        </div>
        <div class="text-sm text-gray-500">Total Catatan <span class="font-semibold text-gray-700">{{ $notes->total() }}</span></div>
    </div>

    <!-- Filter/Search bar -->
    <form method="GET" action="{{ route('doctor.notes') }}" class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-3">
        <div class="md:col-span-2">
            <label class="block text-sm text-gray-600 mb-1">Cari</label>
            <div class="relative">
                <span class="absolute inset-y-0 left-3 flex items-center text-gray-400">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.3-4.3"/></svg>
                </span>
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari pasien / jenis pemeriksaan / isi catatan" class="w-full pl-10 rounded-xl border-gray-300 bg-white focus:border-emerald-600 focus:ring-emerald-600">
            </div>
        </div>
        <div class="flex items-end gap-3">
            <button class="inline-flex items-center px-4 py-2 rounded-xl bg-emerald-600 text-white hover:bg-emerald-700">Terapkan</button>
            <a href="{{ route('doctor.notes') }}" class="inline-flex items-center px-4 py-2 rounded-xl bg-gray-100 text-gray-700 hover:bg-gray-200">Reset</a>
        </div>
    </form>

    <!-- Counter -->
    <div class="mt-3 mb-3 text-sm text-gray-600">
        @if($notes->total() > 0)
            Menampilkan {{ $notes->firstItem() }}–{{ $notes->lastItem() }} dari {{ $notes->total() }} catatan
        @else
            Tidak ada catatan.
        @endif
    </div>

    <div class="space-y-5">
        @forelse($notes as $note)
            @php $result = $note->labResult; @endphp
            <div class="rounded-2xl border border-emerald-300 bg-white p-5">
                <div class="flex items-start justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="7" r="4"/><path d="M5 22v-2a7 7 0 0114 0v2"/></svg>
                        </div>
                        <div>
                            <div class="font-semibold">{{ $result->patient->name }}</div>
                            <div class="text-sm text-gray-600">{{ $result->test_type }}</div>
                            <div class="text-xs text-gray-500 mt-0.5">{{ $result->created_at->format('Y-m-d') }} • Pemeriksaan Laboratorium</div>
                        </div>
                    </div>
                    <span class="px-3 py-1 text-xs rounded-full bg-emerald-50 text-emerald-700">Telah Ditinjau</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                    <div class="rounded-lg border border-blue-200 bg-blue-50 p-4">
                        <div class="font-medium text-blue-800 flex items-center gap-2">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 22v-4a4 4 0 00-8 0v4"/><circle cx="12" cy="7" r="4"/></svg>
                            Hasil Pemeriksaan
                        </div>
                        <div class="text-sm text-blue-900 mt-2 line-clamp-4">{{ Str::limit($result->result_value, 180) }}</div>
                    </div>
                    <div class="rounded-lg border border-emerald-200 bg-emerald-50 p-4">
                        <div class="font-medium text-emerald-800 flex items-center gap-2">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h9l7 7v9a2 2 0 01-2 2z"/></svg>
                            Catatan Dokter
                        </div>
                        <div class="text-sm text-emerald-900 mt-2">{{ $note->note }}</div>
                    </div>
                </div>

                <div class="mt-4 flex flex-wrap items-center gap-3 border-t pt-4">
                    <a href="{{ route('doctor.view-lab-result', $result->id) }}" class="inline-flex items-center gap-2 px-3 py-2 rounded-lg text-sm font-medium bg-emerald-50 text-emerald-700 hover:bg-emerald-100">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 113 3L7 19l-4 1 1-4 12.5-12.5z"/></svg>
                        Edit Catatan
                    </a>
                    <a href="{{ route('doctor.view-lab-result', $result->id) }}" class="inline-flex items-center gap-2 px-3 py-2 rounded-lg text-sm font-medium bg-blue-50 text-blue-700 hover:bg-blue-100">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        Lihat Detail
                    </a>
                    @if($result->result_file)
                        <a href="{{ route('doctor.download-result-file', $result->id) }}" class="inline-flex items-center gap-2 px-3 py-2 rounded-lg text-sm font-medium bg-gray-50 text-gray-700 hover:bg-gray-100">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                            Unduh PDF
                        </a>
                    @endif
                </div>
            </div>
        @empty
            <div class="rounded-xl border border-gray-200 bg-white p-8 text-center text-gray-500">Belum ada catatan dokter.</div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $notes->onEachSide(1)->links() }}
    </div>
@endsection
