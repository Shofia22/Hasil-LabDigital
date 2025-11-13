@extends('layouts.lab')

@section('title', 'Daftar Pemeriksaan')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-gray-900">Daftar Pemeriksaan</h1>
        <p class="text-gray-600 mt-1">Semua data pemeriksaan laboratorium</p>
    </div>

    <div class="max-w-7xl">
        <div class="mb-6">
            <a href="{{ route('lab.create-lab-result') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition">
                + Tambah Pemeriksaan Baru
            </a>
        </div>

        <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-200">
            @if($labResults->isEmpty())
                <div class="p-12 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada pemeriksaan</h3>
                    <p class="text-gray-500 mb-4">Mulai dengan membuat pemeriksaan laboratorium baru</p>
                    <a href="{{ route('lab.create-lab-result') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg transition">
                        Buat Pemeriksaan Baru
                    </a>
                </div>
            @else
                <div class="p-6 text-gray-900">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis Test</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pasien</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dokter</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($labResults as $result)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $result->test_type }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $result->patient->name ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $result->doctor ? $result->doctor->name : '-' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        @if($result->status === 'completed')
                                            <span class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-800 font-medium">Selesai</span>
                                        @elseif($result->status === 'pending')
                                            <span class="px-3 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800 font-medium">Menunggu</span>
                                        @elseif($result->status === 'reviewed')
                                            <span class="px-3 py-1 text-xs rounded-full bg-blue-100 text-blue-800 font-medium">Direview</span>
                                        @else
                                            <span class="px-3 py-1 text-xs rounded-full bg-gray-100 text-gray-800 font-medium">{{ ucfirst($result->status) }}</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $result->created_at->format('d M Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                        <a href="{{ route('lab.view-lab-result', $result->id) }}" class="text-blue-600 hover:text-blue-800 hover:underline">Lihat</a>
                                        <a href="{{ route('lab.edit-lab-result', $result->id) }}" class="text-emerald-600 hover:text-emerald-800 hover:underline">Edit</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
