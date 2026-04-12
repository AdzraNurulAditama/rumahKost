<?php

namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcastNow
{
    use SerializesModels;

    public $message;

    public function __construct(Message $message)
    {
        $this->message = $message->load('user');
    }

    public function broadcastOn()
    {
        return [
            new Channel('chat.' . $this->message->conversation_id),
            // new Channel('chat-global')
        ];
    }

    public function broadcastAs()
    {
        return 'MessageSent';
    }

    public function broadcastWith()
    {
        return [
            'user_id' => $this->message->user_id,
            'user'    => $this->message->user->username,
            'message' => $this->message->message,
            'image'   => $this->message->image,
            'time'    => $this->message->created_at->format('H:i'),
            'status'  => $this->message->status
        ];
    }

}