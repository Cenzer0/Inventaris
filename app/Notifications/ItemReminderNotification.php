<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ItemReminderNotification extends Notification
{
    use Queueable;

    protected $item;
    protected $reason;

    /**
     * Create a new notification instance.
     */
    public function __construct(\App\Models\Item $item, string $reason)
    {
        $this->item = $item;
        $this->reason = $reason;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $icon = $this->item->item_type === 'Kendaraan' ? 'fas fa-car text-warning' : 'fas fa-plug text-primary';
        return [
            'item_id' => $this->item->id,
            'message' => "Pengingat {$this->item->item_type}: {$this->item->name} - {$this->reason}",
            'url' => route('items.show', $this->item->id, false),
            'icon' => $icon,
        ];
    }
}
