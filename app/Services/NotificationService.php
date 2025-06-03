<?php
namespace App\Services;

use App\Models\User;
use App\Models\CrybotSignal;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Notification;
use App\Notifications\CrybotTelegramNotification;
use App\Notifications\CrybotPushNotification;

class NotificationService
{
    public function sendCrybotSignal(User $user, CrybotSignal $signal)
    {
        // 1) Telegram
        Notification::route('telegram',$user->telegram_chat_id)
            ->notify(new CrybotTelegramNotification($signal));

        // 2) FCM Push
        Notification::route('fcm',$user->fcm_token)
            ->notify(new CrybotPushNotification($signal));
    }
}
