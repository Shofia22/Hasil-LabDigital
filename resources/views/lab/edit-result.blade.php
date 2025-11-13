@extends('layouts.lab')

@section('title', 'Ubah Hasil Lab')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-gray-900">Ubah Data Pemeriksaan</h1>
        <p class="text-gray-600 mt-1">Update informasi hasil laboratorium</p>
    </div>

    <div class="max-w-3xl">
        <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-200">
            <div class="p-6 text-gray-900">
                <form method="POST" action="{{ route('lab.update-lab-result', $labResult->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="patient_id" class="block text-sm font-medium text-gray-700 mb-2">Pasien</label>
                            <select name="patient_id" id="patient_id" class="block w-full border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 px-3 py-2" required>
                                @foreach($patients as $patient)
                                <option value="{{ $patient->id }}" {{ $labResult->patient_id === $patient->id ? 'selected' : '' }}>
                                    {{ $patient->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('patient_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="doctor_id" class="block text-sm font-medium text-gray-700 mb-2">Dokter</label>
                            <select name="doctor_id" id="doctor_id" class="block w-full border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 px-3 py-2" required>
                                @foreach($doctors as $doctor)
                                <option value="{{ $doctor->id }}" {{ $labResult->doctor_id === $doctor->id ? 'selected' : '' }}>
                                    {{ $doctor->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('doctor_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                        <div>
                            <label for="test_type" class="block text-sm font-medium text-gray-700 mb-2">Jenis Pemeriksaan</label>
                            <input type="text" name="test_type" id="test_type" value="{{ old('test_type', $labResult->test_type) }}" class="block w-full border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 px-3 py-2" required>
                            @error('test_type')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                            <select name="status" id="status" class="block w-full border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 px-3 py-2" required>
                                <option value="pending" {{ $labResult->status === 'pending' ? 'selected' : '' }}>Menunggu</option>
                                <option value="reviewed" {{ $labResult->status === 'reviewed' ? 'selected' : '' }}>Direview</option>
                                <option value="completed" {{ $labResult->status === 'completed' ? 'selected' : '' }}>Selesai</option>
                            </select>
                            @error('status')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <label for="result_value" class="block text-sm font-medium text-gray-700 mb-2">Hasil Pemeriksaan</label>
                        <textarea name="result_value" id="result_value" rows="6" class="block w-full border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 px-3 py-2" required>{{ old('result_value', $labResult->result_value) }}</textarea>
                        @error('result_value')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mt-4">
                        <label for="result_file" class="block text-sm font-medium text-gray-700 mb-2">File Hasil (PDF, DOC, Gambar)</label>
                        <input type="file" name="result_file" id="result_file" class="block w-full border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 px-3 py-2" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                        @error('result_file')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        @if($labResult->result_file)
                        <p class="mt-2 text-sm text-gray-600">File saat ini: <a href="{{ route('lab.download-result-file', $labResult->id) }}" class="text-blue-600 hover:text-blue-800 underline">{{ basename($labResult->result_file) }}</a></p>
                        @endif
                    </div>
                    
                    <div class="mt-8 flex items-center justify-between">
                        <a href="{{ route('lab.lab-results') }}" class="text-gray-600 hover:text-gray-800 font-medium">← Kembali</a>
                        <div class="space-x-3">
                            <a href="{{ route('lab.lab-results') }}" class="inline-block px-6 py-2.5 rounded-lg border border-gray-300 text-gray-700 font-semibold hover:bg-gray-50 transition">Batal</a>
                            <button type="submit" class="inline-block bg-blue-600 text-white font-semibold px-6 py-2.5 rounded-lg hover:bg-blue-700 transition">Simpan Perubahan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
