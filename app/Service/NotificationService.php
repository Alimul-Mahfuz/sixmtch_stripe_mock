<?php

namespace App\Service;

use App\Models\Notification;

class NotificationService
{
    function create(string $title, string $body, int $receiver_id)
    {
        $auth_user = auth()->user();
        $notification = [
            'title' => $title,
            'body' => $body,
            'read' => false,
            'sender_id' => $auth_user->id,
            'receiver_id' => $receiver_id
        ];
        return Notification::query()->create($notification);

    }

    function getNotification(): \Illuminate\Pagination\LengthAwarePaginator
    {
        $auth_user = auth()->user();
        return Notification::query()
            ->where('receiver_id', $auth_user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(5);
    }

    function getNotificationById(int $id): Notification
    {
        return Notification::query()->findOrFail($id);
    }

    function markAsRead(int $id): void
    {
        Notification::query()->where('id', $id)->update(['read' => true]);
    }

    function getUnreadCount(): int{
        return Notification::query()
            ->where('read', false)
            ->where('receiver_id', auth()->user()->id)
            ->count();
    }
}
