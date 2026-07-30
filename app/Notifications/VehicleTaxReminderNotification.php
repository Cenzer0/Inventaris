<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class VehicleTaxReminderNotification extends Notification
{
    use Queueable;

    protected $item;
    protected $taxMonthName;

    /**
     * Create a new notification instance.
     */
    public function __construct(\App\Models\Item $item, string $taxMonthName)
    {
        $this->item = $item;
        $this->taxMonthName = $taxMonthName;
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
        return [
            'item_id' => $this->item->id,
            'message' => "Pengingat Pajak Kendaraan: {$this->item->name} - Pajak jatuh tempo bulan {$this->taxMonthName}. Segera lakukan pembayaran.",
            'url' => route('items.show', $this->item->id, false),
            'icon' => 'fas fa-file-invoice-dollar text-danger',
        ];
    }
}
