@extends('layouts.app')

@section('content')

@php use Illuminate\Support\Str; @endphp

<div class="max-w-4xl mx-auto bg-white rounded-2xl shadow p-4">

    <!-- ================= HEADER ================= -->
    <div class="flex items-center gap-3 border-b pb-3">
        @if($user->photo)
            <img src="{{ asset('storage/'.$user->photo) }}"
                 class="w-10 h-10 rounded-full object-cover">
        @else
            <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center text-sm font-bold">
                {{ strtoupper(substr($user->username ?? $user->name, 0, 1)) }}
            </div>
        @endif

        <div>
            <p class="font-semibold">{{ $user->username ?? $user->name }}</p>
            <span class="text-green-500 text-sm">Online</span>
        </div>
    </div>

    <!-- ================= CHAT ================= -->
    <div id="chatBox" class="h-[400px] overflow-y-auto p-3 space-y-3">

        @foreach($messages as $msg)

            @php
                $isMine   = $msg->sender_id == auth()->id();

                // 🔥 FIX: pakai image
                $isImage  = $msg->image && Str::endsWith(strtolower($msg->image), ['jpg','jpeg','png','gif','webp']);
                $isFile   = $msg->image && !$isImage;
                $fileName = $msg->image ? basename($msg->image) : '';
                $ext      = $msg->image ? strtoupper(pathinfo($msg->image, PATHINFO_EXTENSION)) : '';
            @endphp

            <div class="flex {{ $isMine ? 'justify-end' : 'justify-start' }}">
                <div class="px-4 py-2 rounded-2xl max-w-xs {{ $isMine ? 'bg-blue-500 text-white rounded-br-sm' : 'bg-gray-200 text-gray-800 rounded-bl-sm' }}">

                    {{-- TEXT --}}
                    @if($msg->message)
                        <p class="text-sm">{{ $msg->message }}</p>
                    @endif

                    {{-- IMAGE --}}
                    @if($isImage)
                        <div class="mt-2">
                            <a href="{{ asset('storage/'.$msg->image) }}" target="_blank">
                                <img src="{{ asset('storage/'.$msg->image) }}"
                                     class="rounded-xl max-w-[200px] w-full">
                            </a>
                        </div>
                    @endif

                    {{-- FILE --}}
                    @if($isFile)
                        <a href="{{ asset('storage/'.$msg->image) }}"
                           target="_blank"
                           class="mt-2 flex items-center gap-2 px-3 py-2 rounded-xl bg-white hover:bg-gray-100">
                            <span class="text-xs font-bold text-blue-600">{{ $ext }}</span>
                            <span class="text-xs truncate max-w-[120px]">{{ $fileName }}</span>
                        </a>
                    @endif

                    <div class="text-xs text-right mt-1 opacity-70">
                        {{ $msg->created_at->format('H:i') }}
                    </div>

                </div>
            </div>

        @endforeach

    </div>

    <!-- ================= PREVIEW ================= -->
    <div id="previewArea" style="display:none"
         class="mb-2 p-2 bg-gray-50 border rounded-xl flex items-center gap-3">

        <img id="imgPreview" style="display:none"
             class="w-14 h-14 object-cover rounded-lg">

        <div id="filePreview" style="display:none" class="flex items-center gap-2">
            <span id="fileName" class="text-sm text-gray-700"></span>
        </div>

        <button type="button" onclick="clearFile()" class="ml-auto text-red-500">
            ❌
        </button>
    </div>

    <!-- ================= INPUT ================= -->
    <form id="chatForm"
          action="{{ route('user.chat.send') }}"
          method="POST"
          enctype="multipart/form-data"
          class="flex gap-2 items-center">

        @csrf

        <input type="hidden" name="receiver_id" value="{{ $user->id }}">

        <input type="file" name="file" id="fileInput"
               style="display:none"
               accept="image/*,.pdf,.doc,.docx"
               onchange="previewFile(this)">

        <button type="button"
                onclick="document.getElementById('fileInput').click()"
                class="px-3 py-2 bg-gray-200 rounded-full">
            📎
        </button>

        <input type="text" name="message"
               placeholder="Ketik pesan..."
               class="flex-1 border rounded-full px-4 py-2">

        <button type="submit"
                class="bg-blue-600 text-white px-5 py-2 rounded-full">
            Kirim
        </button>

    </form>

</div>

<script>
    const chatBox = document.getElementById('chatBox');
    chatBox.scrollTop = chatBox.scrollHeight;

    function previewFile(input) {
        const file = input.files[0];
        if (!file) return;

        const previewArea = document.getElementById('previewArea');
        const imgPreview  = document.getElementById('imgPreview');
        const filePreview = document.getElementById('filePreview');
        const fileName    = document.getElementById('fileName');

        previewArea.style.display = 'flex';

        if (file.type.startsWith('image/')) {
            imgPreview.src = URL.createObjectURL(file);
            imgPreview.style.display = 'block';
            filePreview.style.display = 'none';
        } else {
            fileName.textContent = file.name;
            filePreview.style.display = 'flex';
            imgPreview.style.display = 'none';
        }
    }

    function clearFile() {
        document.getElementById('fileInput').value = '';
        document.getElementById('previewArea').style.display = 'none';
        document.getElementById('imgPreview').style.display = 'none';
        document.getElementById('filePreview').style.display = 'none';
    }
</script>

@endsection