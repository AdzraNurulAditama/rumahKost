@extends('admin.layouts.admin')

@section('content')

@php use Illuminate\Support\Str; @endphp

<div class="flex h-[85vh] bg-white rounded-xl shadow overflow-hidden">

    <!-- ===================== -->
    <!-- SIDEBAR USER -->
    <!-- ===================== -->
    <div class="w-1/3 border-r overflow-y-auto">

        <div class="p-4 font-bold border-b text-lg">
            Chat User
        </div>

        @foreach(\App\Models\User::where('id','!=',auth()->id())->get() as $u)
            <a href="{{ route('admin.chat.room', $u->id) }}"
               class="flex items-center gap-3 p-3 border-b hover:bg-gray-100
               {{ $u->id == $user->id ? 'bg-gray-100' : '' }}">

                <div class="w-10 h-10 bg-blue-500 text-white rounded-full flex items-center justify-center">
                    {{ strtoupper(substr($u->name,0,1)) }}
                </div>

                <div>
                    <p class="font-semibold">{{ $u->name }}</p>
                    <span class="text-xs text-gray-500">Klik untuk chat</span>
                </div>
            </a>
        @endforeach

    </div>

    <!-- ===================== -->
    <!-- CHAT AREA -->
    <!-- ===================== -->
    <div class="flex-1 flex flex-col">

        <!-- HEADER -->
        <div class="p-4 border-b flex items-center gap-3">

            <div class="w-10 h-10 bg-blue-500 text-white rounded-full flex items-center justify-center">
                {{ strtoupper(substr($user->name,0,1)) }}
            </div>

            <div>
                <p class="font-semibold">{{ $user->name }}</p>
                <span class="text-sm text-green-500">Online</span>
            </div>

        </div>

        <!-- MESSAGES -->
        <div id="chatBox" class="flex-1 overflow-y-auto p-4 space-y-3">

            @foreach($messages as $msg)
                @if($msg->sender_id == auth()->id())
                    <!-- ADMIN -->
                    <div class="flex justify-end">
                        <div class="bg-blue-500 text-white px-4 py-2 rounded-xl max-w-xs">

                            {{ $msg->message }}

                            @if($msg->file)
                                <div class="mt-2">
                                    @if(Str::endsWith($msg->file, ['jpg','png','jpeg']))
                                        <img src="{{ asset('storage/'.$msg->file) }}" class="rounded-lg w-40">
                                    @else
                                        <a href="{{ asset('storage/'.$msg->file) }}" target="_blank" class="underline text-sm">
                                            📎 Lihat File
                                        </a>
                                    @endif
                                </div>
                            @endif

                            <div class="text-xs text-right mt-1 opacity-70">
                                {{ $msg->created_at->format('H:i') }}
                            </div>

                        </div>
                    </div>
                @else
                    <!-- USER -->
                    <div class="flex justify-start">
                        <div class="bg-gray-200 px-4 py-2 rounded-xl max-w-xs">

                            {{ $msg->message }}

                            @if($msg->file)
                                <div class="mt-2">
                                    @if(Str::endsWith($msg->file, ['jpg','png','jpeg']))
                                        <img src="{{ asset('storage/'.$msg->file) }}" class="rounded-lg w-40">
                                    @else
                                        <a href="{{ asset('storage/'.$msg->file) }}" target="_blank" class="underline text-sm">
                                            📎 Lihat File
                                        </a>
                                    @endif
                                </div>
                            @endif

                            <div class="text-xs text-right mt-1 opacity-70">
                                {{ $msg->created_at->format('H:i') }}
                            </div>

                        </div>
                    </div>
                @endif
            @endforeach

        </div>

        <!-- INPUT -->
        <form action="{{ route('admin.chat.send') }}" method="POST"
              enctype="multipart/form-data"
              class="p-3 border-t flex items-center gap-2">

            @csrf

            <input type="hidden" name="receiver_id" value="{{ $user->id }}">

            <!-- upload -->
            <label class="cursor-pointer bg-gray-200 px-3 py-2 rounded-full">
                📎
                <input type="file" name="file" class="hidden">
            </label>

            <!-- text -->
            <input type="text" name="message"
                   class="flex-1 border rounded-full px-4 py-2 focus:outline-none"
                   placeholder="Ketik pesan...">

            <!-- send -->
            <button class="bg-blue-600 text-white px-5 rounded-full">
                Kirim
            </button>

        </form>

    </div>

</div>

<!-- AUTO SCROLL -->
<script>
    const chatBox = document.getElementById('chatBox');
    chatBox.scrollTop = chatBox.scrollHeight;
</script>

@endsection