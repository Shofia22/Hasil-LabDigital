@extends('layouts.patient')

@section('title', 'Detail Hasil Pemeriksaan')

@section('content')
    <div class="max-w-4xl">
        <!-- Detail Hasil -->
        <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-gray-200 mb-6">
            <div class="p-6 text-gray-900">
                <div class="flex items-start justify-between mb-4">
                    <h2 class="text-xl font-semibold">View Laboratory Result</h2>
                    <span class="text-xs px-2 py-1 rounded-full
                        @if($labResult->status === 'completed') bg-gray-900 text-white
                        @elseif($labResult->status === 'pending') bg-gray-100 text-gray-700
                        @else bg-blue-100 text-blue-700 @endif">
                        {{ $labResult->status }}
                    </span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div>
                        <h3 class="text-lg font-medium mb-2">Patient Information</h3>
                        <p><strong>Name:</strong> {{ $labResult->patient->name }}</p>
                        <p><strong>Email:</strong> {{ $labResult->patient->email }}</p>
                    </div>
                    <div>
                        <h3 class="text-lg font-medium mb-2">Result Information</h3>
                        <p><strong>Test Type:</strong> {{ $labResult->test_type }}</p>
                        <p><strong>Date:</strong> {{ $labResult->created_at->format('M d, Y H:i') }}</p>
                    </div>
                </div>

                <div class="mb-6">
                    <h3 class="text-lg font-medium mb-2">Result Value</h3>
                    <div class="bg-gray-50 p-4 rounded-md">
                        <pre class="whitespace-pre-wrap">{{ $labResult->result_value ?: '-' }}</pre>
                    </div>
                </div>

                <div class="mb-2 flex gap-2">
                    <a href="{{ route('patient.download-result-pdf', $labResult->id) }}" class="inline-flex items-center gap-2 px-3 py-2 rounded-lg bg-gray-900 text-white hover:bg-gray-800">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4Z"/></svg>
                        Download PDF
                    </a>
                    @if($labResult->result_file)
                    <a href="{{ route('patient.download-result-file', $labResult->id) }}" class="inline-flex items-center gap-2 px-3 py-2 rounded-lg bg-emerald-600 text-white hover:bg-emerald-700">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                        Download File
                    </a>
                    @endif
                </div>

                <div class="mt-6">
                    <h3 class="text-lg font-medium mb-2">Lab Staff Information</h3>
                    <p><strong>Name:</strong> {{ $labResult->labStaff->name }}</p>
                    <p><strong>Email:</strong> {{ $labResult->labStaff->email }}</p>
                </div>
            </div>
        </div>

        <!-- Catatan Dokter -->
        <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-gray-200">
            <div class="p-6 text-gray-900">
                <h3 class="text-lg font-medium mb-4">Doctor Notes</h3>
                @if($labResult->doctorNotes->count() > 0)
                    <div class="space-y-4">
                        @foreach($labResult->doctorNotes as $note)
                            <div class="border-l-4 border-emerald-600 pl-4 py-2 bg-gray-50">
                                <p class="text-gray-800">{{ $note->note }}</p>
                                <p class="text-sm text-gray-600 mt-1">By {{ $note->doctor->name }} on {{ $note->created_at->format('M d, Y H:i') }}</p>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-600">No notes from the doctor yet.</p>
                @endif
            </div>
        </div>
    </div>
@endsection
