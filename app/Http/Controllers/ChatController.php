<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;
use App\Models\Kost;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    // ======================
    // USER / ADMIN - ROOM CHAT
    // ======================
    public function index(User $user)
    {
        $messages = Message::where(function ($q) use ($user) {
            $q->where('sender_id', Auth::id())
              ->where('receiver_id', $user->id);
        })->orWhere(function ($q) use ($user) {
            $q->where('sender_id', $user->id)
              ->where('receiver_id', Auth::id());
        })->orderBy('created_at')->get();

        // CEK ROLE
        if (Auth::user()->role == 'admin') {
            return view('admin.chat.room', compact('messages', 'user'));
        }

        return view('user.chat.room', compact('messages', 'user'));
    }


    // ======================
    // KIRIM PESAN + FILE
    // ======================
    public function send(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'nullable|string',
            'file' => 'nullable|file|mimes:jpg,jpeg,png,pdf,docx|max:2048'
        ]);

        // biar ga kosong dua-duanya
        if (!$request->message && !$request->hasFile('file')) {
            return back()->with('error', 'Pesan tidak boleh kosong');
        }

        $filePath = null;

        // upload file
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('chat_files', 'public');
        }

        Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
            'file' => $filePath
        ]);

        return back()->with('success', 'Pesan terkirim');
    }


    // ======================
    // ADMIN - LIST USER CHAT
    // ======================
    public function adminIndex()
    {
        $users = User::where('id', '!=', auth()->id())->get();

        return view('admin.chat.index', compact('users'));
    }


    // ======================
    // DARI HALAMAN KOST → CHAT ADMIN
    // ======================
    public function chatKost(Kost $kost)
    {
        $admin = User::where('role', 'admin')->first();

        if (!$admin) {
            return back()->with('error', 'Admin tidak ditemukan');
        }

        return redirect()->route('user.chat.room', $admin->id);
    }
}