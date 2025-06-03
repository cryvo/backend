<?php
namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\FirebaseMessage;
use App\Models\CrybotSignal;

class CrybotPushNotification extends Notification
{
    protected $signal;
    public function __construct(CrybotSignal $s) { $this->signal = $s; }

    public function via($notifiable) { return ['fcm']; }

    public function toFcm($notifiable)
    {
        $s = $this->signal;
        return (new FirebaseMessage())
            ->title("CryBot {$s->type} Signal")
            ->body("{$s->market} {$s->side}@{$s->price}");
    }
}
