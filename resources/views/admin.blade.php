@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-3xl font-bold mb-6">Admin Panel</h1>

    @if(session('success'))
        <div class="bg-green-200 text-green-800 p-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-200 text-red-800 p-2 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <h2 class="text-2xl font-semibold mb-4">Pending Messages</h2>
    @if(count($messages) > 0)
        <ul class="space-y-4">
            @foreach($messages as $message)
                <li class="flex justify-between items-center p-4 bg-gray-100 rounded hover:bg-gray-200 transition duration-200">
                    <div>
                        <p class="text-gray-800">{{ $message['message'] }}</p>
                        <span class="text-yellow-600">{{ $message['status'] }}</span>
                    </div>
                    <form action="{{ route('admin.validate', $message['id']) }}" method="POST">
                        @csrf
                        <input type="hidden" name="messageId" value="{{ $message['id'] }}">
                        <button type="submit" class="bg-indigo-600 text-white px-3 py-1 rounded hover:bg-indigo-700">
                            Complete Processing
                        </button>
                    </form>
                </li>
            @endforeach
        </ul>
    @else
        <p class="text-gray-600">No pending messages.</p>
    @endif
</div>
@endsection
