<?php
use Illuminate\Support\Facades\Channel;
use App\Http\Controllers\ChatController;
use App\Models\Conversation;

Broadcast::channel('chat.{id}', function ($user, $id) {
    $conversation = Conversation::find($id);

    return $conversation &&
        ($conversation->user_id == $user->id ||
         $conversation->admin_id == $user->id);
});