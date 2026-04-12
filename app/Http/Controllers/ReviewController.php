<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Review;

class ReviewController extends Controller
{

    public function index()
    {
        $user = Auth::user();

        $reviews = Review::with('kost')
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        return view('user.ulasan', compact('user', 'reviews'));
    }

    public function store(Request $request, $kost_id)
    {
        $request->validate([
            'komentar' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        Review::create([
            'user_id' => Auth::id(),
            'kost_id' => $kost_id,
            'komentar' => $request->komentar,
            'rating' => $request->rating,
        ]);

        return back()->with('success', 'Ulasan berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        $review = Review::findOrFail($id);

        if ($review->user_id != Auth::id()) {
            return back()->with('error', 'Tidak punya akses!');
        }

        $review->delete();

        return back()->with('success', 'Komentar berhasil dihapus!');
    }
}