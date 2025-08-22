<?php

namespace App\Policies;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class NotificationPolicy
{
    public function view(User $user, Notification $notification)
    {
        return $notification->user_id === $user->id;
    }

    public function update(User $user, Notification $notification)
    {
        return $notification->user_id === $user->id;
    }

    public function delete(User $user, Notification $notification)
    {
        return $notification->user_id === $user->id;
    }
}