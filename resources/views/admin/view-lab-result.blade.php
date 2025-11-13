@extends('layouts.admin')

@section('title', 'Detail Hasil Lab')

@section('content')
    <div class="max-w-5xl">
        <h1 class="text-2xl font-semibold">Detail Hasil Laboratorium</h1>
        <p class="text-gray-600 mb-6">Informasi lengkap hasil pemeriksaan</p>

        <div class="bg-white rounded-xl border border-gray-200 p-6 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <div class="text-xs text-gray-500">Pasien</div>
                    <div class="font-medium">{{ $labResult->patient->name }}</div>
                </div>
                <div>
                    <div class="text-xs text-gray-500">Dokter</div>
                    <div class="font-medium">{{ $labResult->doctor ? $labResult->doctor->name : 'Not assigned' }}</div>
                </div>
                <div>
                    <div class="text-xs text-gray-500">Petugas Lab</div>
                    <div class="font-medium">{{ $labResult->labStaff->name }}</div>
                </div>
                <div>
                    <div class="text-xs text-gray-500">Status</div>
                    <div>
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full @if($labResult->status==='pending') bg-yellow-100 text-yellow-800 @elseif($labResult->status==='reviewed') bg-blue-100 text-blue-800 @else bg-green-100 text-green-800 @endif">{{ ucfirst($labResult->status) }}</span>
                    </div>
                </div>
                <div class="md:col-span-2">
                    <div class="text-xs text-gray-500">Jenis Pemeriksaan</div>
                    <div class="font-medium">{{ $labResult->test_type }}</div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 p-6 mb-6">
            <h3 class="font-semibold mb-3">Nilai Hasil</h3>
            <pre class="whitespace-pre-wrap text-sm text-gray-800">{{ $labResult->result_value }}</pre>
        </div>

        @if($labResult->result_file)
        <div class="bg-white rounded-xl border border-gray-200 p-6 mb-6">
            <h3 class="font-semibold mb-3">File Hasil</h3>
            <a href="{{ route('lab.download-result-file', $labResult->id) }}" class="inline-flex items-center gap-2 px-3 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700">Unduh</a>
        </div>
        @endif

        @if($labResult->doctorNotes && $labResult->doctorNotes->count())
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h3 class="font-semibold mb-3">Catatan Dokter</h3>
            <div class="space-y-3">
                @foreach($labResult->doctorNotes as $note)
                    <div class="border-l-4 border-emerald-500 pl-4">
                        <div class="text-sm text-gray-800">{{ $note->note }}</div>
                        <div class="text-xs text-gray-500 mt-1">Oleh {{ $note->doctor->name }} • {{ $note->created_at->format('Y-m-d H:i') }}</div>
                    </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
@endsection
