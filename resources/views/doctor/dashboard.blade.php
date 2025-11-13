@extends('layouts.doctor')

@section('title', 'Dashboard Dokter')

@section('content')
    @php $completedCount = $myResults->where('status','completed')->count(); @endphp

    <h1 class="text-2xl font-semibold">Dashboard Dokter</h1>
    <p class="text-gray-600">Akses dan tinjau hasil laboratorium pasien</p>

    <!-- Stat cards like mockup -->
    <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="rounded-2xl border-2 border-blue-300 bg-white p-5">
            <div class="flex items-start justify-between">
                <div>
                    <div class="text-sm text-gray-600">Total Hasil Lab</div>
                    <div class="mt-2 text-3xl font-semibold">{{ $myResults->count() }}</div>
                    <div class="text-xs text-gray-500 mt-1">Hasil pemeriksaan</div>
                </div>
                <svg class="w-6 h-6 text-blue-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="8" y="2" width="8" height="4" rx="1"/><path d="M8 6h8v14a2 2 0 01-2 2H10a2 2 0 01-2-2V6z"/></svg>
            </div>
        </div>
        <div class="rounded-2xl border-2 border-yellow-300 bg-white p-5">
            <div class="flex items-start justify-between">
                <div>
                    <div class="text-sm text-gray-600">Menunggu Review</div>
                    <div class="mt-2 text-3xl font-semibold">{{ $pendingResults }}</div>
                    <div class="text-xs text-gray-500 mt-1">Belum diberi catatan</div>
                </div>
                <svg class="w-6 h-6 text-yellow-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 8v4l3 3"/><circle cx="12" cy="12" r="9"/></svg>
            </div>
        </div>
        <div class="rounded-2xl border-2 border-green-300 bg-white p-5">
            <div class="flex items-start justify-between">
                <div>
                    <div class="text-sm text-gray-600">Selesai Review</div>
                    <div class="mt-2 text-3xl font-semibold">{{ $completedCount }}</div>
                    <div class="text-xs text-gray-500 mt-1">Sudah diberi catatan</div>
                </div>
                <svg class="w-6 h-6 text-green-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5"/></svg>
            </div>
        </div>
    </div>

    <!-- Latest results table -->
    <div class="mt-8 bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="p-6">
            <h3 class="font-semibold mb-4">Hasil Laboratorium Terbaru</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Pasien</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis Pemeriksaan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($myResults->take(8) as $result)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $result->patient->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $result->test_type }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $result->created_at->format('Y-m-d') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                @if($result->status === 'completed')
                                    <span class="px-2 py-1 text-xs rounded-full bg-black text-white">Review Selesai</span>
                                @elseif($result->status === 'pending')
                                    <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">Perlu Review</span>
                                @else
                                    <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">Direview</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <a href="{{ route('doctor.view-lab-result', $result->id) }}" class="inline-flex items-center gap-1 text-blue-600 hover:text-blue-800">
                                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                    Lihat
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="px-6 py-6 text-center text-gray-500">Belum ada data.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
