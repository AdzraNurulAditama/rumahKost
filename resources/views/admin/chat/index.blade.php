@extends('admin.layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto bg-white p-4 rounded-xl shadow">

    <h2 class="text-xl font-bold mb-4">Chat User</h2>

    @forelse($users as $u)
        <a href="{{ route('admin.chat.room', $u->id) }}"
           class="flex items-center gap-3 p-3 border-b hover:bg-gray-100">

            <div class="w-10 h-10 bg-blue-500 text-white rounded-full flex items-center justify-center">
                {{ strtoupper(substr($u->username,0,1)) }}
            </div>

            <div>
                <p class="font-semibold">{{ $u->username }}</p>
                <span class="text-sm text-gray-500">Klik untuk chat</span>
            </div>

        </a>
    @empty
        <p class="text-gray-500">Belum ada user</p>
    @endforelse

</div>
@endsection