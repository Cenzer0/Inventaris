<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InventoryTransactionNotification extends Notification
{
    use Queueable;

    protected $transaction;

    /**
     * Create a new notification instance.
     */
    public function __construct(\App\Models\InventoryTransaction $transaction)
    {
        $this->transaction = $transaction;
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
        $type = $this->transaction->transaction_type === 'usage' ? 'Keluar' : 'Masuk';
        return [
            'transaction_id' => $this->transaction->id,
            'message' => "Transaksi Barang {$type}: {$this->transaction->quantity} {$this->transaction->item->unit->name} {$this->transaction->item->name}.",
            'url' => route('items.show', $this->transaction->item_id, false),
            'icon' => $type === 'Masuk' ? 'fas fa-arrow-down text-success' : 'fas fa-arrow-up text-danger',
        ];
    }
}
