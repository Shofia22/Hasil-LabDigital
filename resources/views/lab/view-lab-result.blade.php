@extends('layouts.lab')

@section('title', 'Detail Hasil Lab')

@section('content')
    <div class="mb-6">
        <a href="{{ route('lab.lab-results') }}" class="text-gray-600 hover:text-gray-800 font-medium">← Kembali ke Daftar</a>
    </div>

    <div class="max-w-4xl">
        <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-200">
            <div class="p-6 text-gray-900">
                <!-- Header dengan info dasar -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8 pb-8 border-b border-gray-200">
                    <div>
                        <div class="text-sm text-gray-500 uppercase tracking-wide">Pasien</div>
                        <p class="text-lg font-semibold mt-1">{{ $labResult->patient->name }}</p>
                        <p class="text-sm text-gray-600 mt-1">{{ $labResult->patient->email }}</p>
                    </div>
                    <div>
                        <div class="text-sm text-gray-500 uppercase tracking-wide">Jenis Pemeriksaan</div>
                        <p class="text-lg font-semibold mt-1">{{ $labResult->test_type }}</p>
                        <p class="text-sm text-gray-600 mt-1">{{ $labResult->created_at->format('d M Y') }}</p>
                    </div>
                    <div>
                        <div class="text-sm text-gray-500 uppercase tracking-wide">Status</div>
                        <div class="mt-1">
                            @if($labResult->status === 'pending')
                                <span class="px-3 py-1 text-sm rounded-full bg-yellow-100 text-yellow-800 font-medium">Menunggu</span>
                            @elseif($labResult->status === 'reviewed')
                                <span class="px-3 py-1 text-sm rounded-full bg-blue-100 text-blue-800 font-medium">Direview</span>
                            @else
                                <span class="px-3 py-1 text-sm rounded-full bg-green-100 text-green-800 font-medium">Selesai</span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Hasil Pemeriksaan -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Hasil Pemeriksaan</h3>
                    <div class="bg-gray-50 p-6 rounded-lg border border-gray-200">
                        <pre class="whitespace-pre-wrap text-sm text-gray-700 font-mono">{{ $labResult->result_value }}</pre>
                    </div>
                </div>

                <!-- File Hasil jika ada -->
                @if($labResult->result_file)
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">File Hasil</h3>
                    <div class="flex items-center justify-between bg-blue-50 p-4 rounded-lg border border-blue-200">
                        <div class="flex items-center gap-3">
                            <svg class="w-6 h-6 text-blue-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"/><polyline points="13 2 13 9 20 9"/></svg>
                            <div>
                                <p class="font-medium text-blue-900">{{ basename($labResult->result_file) }}</p>
                                <p class="text-sm text-blue-700">Klik untuk mengunduh file</p>
                            </div>
                        </div>
                        <a href="{{ route('lab.download-result-file', $labResult->id) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium">
                            Unduh
                        </a>
                    </div>
                </div>
                @endif

                <!-- Informasi Dokter -->
                @if($labResult->doctor)
                <div class="mb-8 pb-8 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Dokter Penanggungjawab</h3>
                    <div class="bg-gradient-to-r from-emerald-50 to-blue-50 p-6 rounded-lg border border-emerald-200">
                        <p class="font-medium text-gray-900">{{ $labResult->doctor->name }}</p>
                        <p class="text-sm text-gray-600 mt-1">{{ $labResult->doctor->email }}</p>
                    </div>
                </div>
                @endif

                <!-- Action Buttons -->
                <div class="flex items-center justify-between">
                    <a href="{{ route('lab.lab-results') }}" class="text-gray-600 hover:text-gray-800 font-medium">← Kembali</a>
                    <div class="space-x-3">
                        <a href="{{ route('lab.edit-lab-result', $labResult->id) }}" class="inline-block px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium">
                            Edit Pemeriksaan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

