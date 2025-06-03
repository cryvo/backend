<?php
namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\FirebaseMessage;
use App\Models\MtTradeEvent;

class MtTradeNotification extends Notification
{
    protected $evt;
    public function __construct(MtTradeEvent $e) { $this->evt = $e; }
    public function via($notifiable) { return ['fcm']; }
    public function toFcm($notifiable)
    {
        $e = $this->evt;
        return (new FirebaseMessage())
            ->title("MT Trade: {$e->symbol}")
            ->body("{$e->type}@{$e->price} ({$e->volume})");
    }
}
