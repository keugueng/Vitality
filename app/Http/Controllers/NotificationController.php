<?php

namespace App\Http\Controllers;

use App\Models\UserNotification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $userId = $request->user()->id;

        $notifications = UserNotification::forUser($userId)
            ->orderByDesc('created_at')
            ->limit(20)
            ->get()
            ->map(fn ($n) => [
                'id'           => $n->id,
                'type'         => $n->type,
                'title'        => $n->title,
                'body'         => $n->body,
                'action_url'   => $n->action_url,
                'action_label' => $n->action_label,
                'read'         => $n->isRead(),
                'created_at'   => $n->created_at->diffForHumans(),
            ]);

        return response()->json($notifications);
    }

    public function markRead(Request $request, $id)
    {
        $userId = $request->user()->id;

        UserNotification::forUser($userId)->where('id', $id)
            ->update(['read_at' => now()]);

        return response()->json(['ok' => true]);
    }

    public function markAllRead(Request $request)
    {
        $userId = $request->user()->id;

        UserNotification::forUser($userId)->whereNull('read_at')
            ->update(['read_at' => now()]);

        return response()->json(['ok' => true]);
    }

    public function unreadCount(Request $request)
    {
        $userId = $request->user()->id;

        $count = UserNotification::forUser($userId)->whereNull('read_at')->count();

        return response()->json(['count' => $count]);
    }
}
