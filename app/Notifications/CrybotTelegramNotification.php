<?php
namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\TelegramMessage;
use App\Models\CrybotSignal;

class CrybotTelegramNotification extends Notification
{
    protected $signal;
    public function __construct(CrybotSignal $s) { $this->signal = $s; }

    public function via($notifiable) { return ['telegram']; }

    public function toTelegram($notifiable)
    {
        $s = $this->signal;
        $msg = "*CryBot Signal*\nMarket: {$s->market}\nType: {$s->type}\nSide: {$s->side}\nPrice: {$s->price}";
        return TelegramMessage::create()
            ->to($notifiable->telegram_chat_id)
            ->content($msg);
    }
}
