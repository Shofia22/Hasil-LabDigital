<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Notifications') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium">Your Notifications</h3>
                        <a href="{{ route('patient.mark-all-as-read') }}" class="text-indigo-600 hover:text-indigo-900 text-sm">Mark all as read</a>
                    </div>
                    
                    @if($notifications->count() > 0)
                        <div class="space-y-4">
                            @foreach($notifications as $notification)
                            <div class="border-l-4 @if($notification->read_status === 'unread') border-indigo-500 bg-blue-50 @else border-gray-300 bg-gray-50 @endif pl-4 py-3">
                                <p class="text-gray-800">{{ $notification->message }}</p>
                                <p class="text-sm text-gray-600 mt-1">{{ $notification->created_at->format('M d, Y H:i') }}
                                    @if($notification->read_status === 'unread')
                                    <span class="text-xs bg-indigo-100 text-indigo-800 px-2 py-1 rounded">Unread</span>
                                    @endif
                                </p>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-600">No notifications yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>