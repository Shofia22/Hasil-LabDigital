@extends('layouts.doctor')

@section('title', 'Detail Hasil Lab')

@section('content')
    <div class="max-w-4xl">
            <!-- Result Details -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div>
                            <h3 class="text-lg font-medium mb-2">Patient Information</h3>
                            <p><strong>Name:</strong> {{ $labResult->patient->name }}</p>
                            <p><strong>Email:</strong> {{ $labResult->patient->email }}</p>
                        </div>
                        <div>
                            <h3 class="text-lg font-medium mb-2">Result Information</h3>
                            <p><strong>Test Type:</strong> {{ $labResult->test_type }}</p>
                            <p><strong>Status:</strong> 
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    @if($labResult->status === 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($labResult->status === 'reviewed') bg-blue-100 text-blue-800
                                    @else bg-green-100 text-green-800 @endif">
                                    {{ ucfirst($labResult->status) }}
                                </span>
                            </p>
                            <p><strong>Date:</strong> {{ $labResult->created_at->format('M d, Y H:i') }}</p>
                        </div>
                    </div>
                    
                    <div class="mb-6">
                        <h3 class="text-lg font-medium mb-2">Result Value</h3>
                        <div class="bg-gray-50 p-4 rounded-md">
                            <pre class="whitespace-pre-wrap">{{ $labResult->result_value }}</pre>
                        </div>
                    </div>
                    
                    @if($labResult->result_file)
                    <div class="mb-6">
                        <h3 class="text-lg font-medium mb-2">Result File</h3>
                        <a href="{{ route('lab.download-result-file', $labResult->id) }}" class="text-indigo-600 hover:text-indigo-900">
                            Download Result File
                        </a>
                    </div>
                    @endif
                    
                    <div class="mb-6">
                        <h3 class="text-lg font-medium mb-2">Lab Staff Information</h3>
                        <p><strong>Name:</strong> {{ $labResult->labStaff->name }}</p>
                        <p><strong>Email:</strong> {{ $labResult->labStaff->email }}</p>
                    </div>
                </div>
            </div>
            
            <!-- Doctor Notes -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium mb-4">Doctor Notes</h3>
                    
                    @if($labResult->doctorNotes->count() > 0)
                        <div class="space-y-4 mb-6">
                            @foreach($labResult->doctorNotes as $note)
                            <div class="border-l-4 border-indigo-500 pl-4 py-2 bg-gray-50">
                                <p class="text-gray-800">{{ $note->note }}</p>
                                <p class="text-sm text-gray-600 mt-1">By {{ $note->doctor->name }} on {{ $note->created_at->format('M d, Y H:i') }}</p>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-600">No notes yet.</p>
                    @endif
                    
                    <!-- Add Note Form -->
                    <form method="POST" action="{{ route('doctor.add-note', $labResult->id) }}" class="mt-6">
                        @csrf
                        <div class="mb-4">
                            <label for="note" class="block text-sm font-medium text-gray-700 mb-1">Add Note</label>
                            <textarea name="note" id="note" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required></textarea>
                        </div>
                        
                        <div class="flex items-center justify-end">
                            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">Add Note</button>
                        </div>
                    </form>
                    
                    <!-- Update Status Form -->
                    <form method="POST" action="{{ route('doctor.update-status', $labResult->id) }}" class="mt-6">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Update Status</label>
                            <select name="status" id="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                <option value="pending" {{ $labResult->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="reviewed" {{ $labResult->status === 'reviewed' ? 'selected' : '' }}>Reviewed</option>
                                <option value="completed" {{ $labResult->status === 'completed' ? 'selected' : '' }}>Completed</option>
                            </select>
                        </div>
                        
                        <div class="flex items-center justify-end">
                            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">Update Status</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
