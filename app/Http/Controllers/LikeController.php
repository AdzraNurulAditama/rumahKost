<?php

namespace App\Http\Controllers;

use App\Models\Like;

class LikeController extends Controller
{
    public function toggle($kostId)
    {
        if (!auth()->check()) {
            return response()->json(['status' => 'unauthorized'], 401);
        }

        $userId = auth()->id();

        $like = Like::where('user_id', $userId)
                    ->where('kost_id', $kostId)
                    ->first();

        if ($like) {
            $like->delete();
            return response()->json(['status' => 'unliked']); // ✅ fix: was 'removed'
        } else {
            Like::create([
                'user_id' => $userId,
                'kost_id' => $kostId
            ]);

            return response()->json(['status' => 'liked']); // ✅ fix: was 'added'
        }
    }
}