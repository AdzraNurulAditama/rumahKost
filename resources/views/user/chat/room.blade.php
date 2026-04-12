@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto bg-white rounded-2xl shadow p-4">

    <!-- Header -->
    <div class="flex items-center gap-3 border-b pb-3">
        <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center">
            {{ strtoupper(substr($user->name,0,1)) }}
        </div>
        <div>
            <p class="font-semibold">{{ $user->name }}</p>
            <span class="text-green-500 text-sm">Online</span>
        </div>
    </div>

    <!-- Chat Area -->
    <div class="h-[400px] overflow-y-auto p-3 space-y-3">
        @foreach($messages as $msg)
            @if($msg->sender_id == auth()->id())
                <div class="flex justify-end">
                    <div class="bg-blue-500 text-white px-4 py-2 rounded-xl max-w-xs">
                        {{ $msg->message }}
                        <div class="text-xs text-right mt-1">{{ $msg->created_at->format('H:i') }}</div>
                    </div>
                </div>
            @else
                <div class="flex justify-start">
                    <div class="bg-gray-200 px-4 py-2 rounded-xl max-w-xs">
                        {{ $msg->message }}
                        <div class="text-xs text-right mt-1">{{ $msg->created_at->format('H:i') }}</div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>

    <!-- Input -->
    <form action="{{ route('user.chat.send') }}" method="POST" class="flex gap-2 mt-3">
        @csrf
        <input type="hidden" name="receiver_id" value="{{ $user->id }}">
        <input type="text" name="message" placeholder="Ketik pesan..."
               class="flex-1 border rounded-full px-4 py-2 focus:outline-none">
        <button class="bg-blue-600 text-white px-5 rounded-full">Kirim</button>
    </form>

</div>
@endsection