@extends('layouts.patient')

@section('title', 'Profil')

@section('content')
    <h1 class="text-2xl font-semibold">Profil</h1>
    <div class="mt-6 max-w-2xl">
        <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-200">
            <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('patient.update-profile') }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                        </div>
                        
                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                        </div>
                        
                        <div class="flex items-center justify-end">
                            <button type="submit" class="bg-emerald-600 text-white px-4 py-2 rounded-md hover:bg-emerald-700">Update Profil</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
