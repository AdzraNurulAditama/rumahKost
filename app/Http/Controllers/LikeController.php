<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function toggle($id)
    {
        try {
            if (!Auth::check()) {
                return response()->json([
                    'status' => 'unauthorized'
                ], 401);
            }

            $userId = Auth::id();

            // 🔍 Cek apakah sudah like
            $like = Like::where('user_id', $userId)
                        ->where('kost_id', $id)
                        ->first();

            if ($like) {
                $like->delete();

                return response()->json([
                    'status' => 'unliked'
                ]);
            } else {
                Like::create([
                    'user_id' => $userId,
                    'kost_id' => $id
                ]);

                return response()->json([
                    'status' => 'liked'
                ]);
            }

        } catch (\Exception $e) {
            // 🧨 Kalau error → biar kelihatan di Network
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}