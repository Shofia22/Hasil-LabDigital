@extends('layouts.lab')

@section('title', 'Input Hasil Lab')

@section('content')
    <h1 class="text-2xl font-semibold">Input Hasil Pemeriksaan</h1>
    <p class="text-gray-600">Masukkan data hasil laboratorium pasien</p>
    <div class="max-w-3xl mt-6">
        <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-200">
            <div class="p-6 text-gray-900">
                    <h3 class="font-medium mb-4">Form Input Hasil Lab</h3>
                    <form method="POST" action="{{ route('lab.store-lab-result') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="patient_id" class="block text-sm font-medium text-gray-700 mb-2">Pasien</label>
                                <select name="patient_id" id="patient_id" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 px-3 py-2" required>
                                    <option value="">-- Pilih Pasien --</option>
                                    @foreach($patients as $patient)
                                    <option value="{{ $patient->id }}">{{ $patient->name }}</option>
                                    @endforeach
                                </select>
                                @error('patient_id')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="doctor_id" class="block text-sm font-medium text-gray-700 mb-2">Dokter</label>
                                <select name="doctor_id" id="doctor_id" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 px-3 py-2" required>
                                    <option value="">-- Pilih Dokter --</option>
                                    @foreach($doctors as $doctor)
                                    <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
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
                                <input type="text" name="test_type" id="test_type" placeholder="Contoh: Darah Lengkap" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 px-3 py-2" required>
                                @error('test_type')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Pemeriksaan</label>
                                <input type="date" name="date" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 px-3 py-2" />
                            </div>
                        </div>
                        <div class="mt-4">
                            <label for="result_value" class="block text-sm font-medium text-gray-700 mb-2">Nilai Hasil</label>
                            <textarea name="result_value" id="result_value" rows="6" placeholder="Masukkan hasil pemeriksaan" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 px-3 py-2" required></textarea>
                            @error('result_value')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Upload File Hasil (PDF/Gambar)</label>
                            <label for="result_file" class="mt-2 block w-full rounded-xl border-2 border-dashed border-blue-300 bg-blue-50/50 p-6 text-center cursor-pointer hover:bg-blue-50 transition">
                                <div class="flex flex-col items-center text-blue-700">
                                    <svg class="w-8 h-8 mb-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                                    <div class="font-medium">Klik atau drag & drop file</div>
                                    <div class="text-xs text-blue-600 mt-1">PDF, DOC, Gambar (Maks. 10MB)</div>
                                </div>
                                <input type="file" name="result_file" id="result_file" class="hidden" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" />
                            </label>
                            @error('result_file')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mt-8 flex items-center justify-between">
                            <a href="{{ route('lab.lab-results') }}" class="text-gray-600 hover:text-gray-800 font-medium">← Kembali</a>
                            <button type="submit" class="bg-blue-600 text-white font-semibold px-6 py-2.5 rounded-lg hover:bg-blue-700 transition">Simpan Pemeriksaan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
