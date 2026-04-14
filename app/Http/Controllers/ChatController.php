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
    // ROOM CHAT (USER & ADMIN)
    // ======================
    public function index(User $user)
    {
        $authId = Auth::id();

        $messages = Message::where(function ($q) use ($user, $authId) {
            $q->where('sender_id', $authId)
              ->where('receiver_id', $user->id);
        })->orWhere(function ($q) use ($user, $authId) {
            $q->where('sender_id', $user->id)
              ->where('receiver_id', $authId);
        })->orderBy('created_at', 'asc')->get();

        // CEK ROLE
        if (Auth::user()->role === 'admin') {
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
            'message'     => 'nullable|string',
            'file'        => 'nullable|file|mimes:jpg,jpeg,png,gif,webp,pdf,docx|max:5120'
        ]);

        // biar ga kosong dua-duanya
        if (!$request->message && !$request->hasFile('file')) {
            return back()->with('error', 'Pesan tidak boleh kosong');
        }

        $filePath = null;

        // ======================
        // UPLOAD FILE
        // ======================
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('chat_files', 'public');
        }

        // ======================
        // SIMPAN KE DATABASE
        // ======================
        Message::create([
            'sender_id'   => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'message'     => $request->message,
            'image'       => $filePath // 🔥 FIX UTAMA DI SINI
        ]);

        return back()->with('success', 'Pesan terkirim');
    }


    // ======================
    // ADMIN - LIST USER CHAT
    // ======================
    public function adminIndex()
    {
        $users = User::where('id', '!=', Auth::id())->get();

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