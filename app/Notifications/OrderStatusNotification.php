<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class OrderStatusNotification extends Notification
{
    use Queueable;

    public Order $order;
    public string $status;

    public function __construct(Order $order, string $status)
    {
        $this->order  = $order;
        $this->status = $status;
    }

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $statusLabels = [
            'pending'    => 'অপেক্ষারত',
            'processing' => 'প্রক্রিয়াধীন',
            'shipped'    => 'পাঠানো হয়েছে',
            'delivered'  => 'ডেলিভারি সম্পন্ন',
            'cancelled'  => 'বাতিল',
        ];

        $label = $statusLabels[$this->status] ?? $this->status;

        return (new MailMessage)
            ->subject('অর্ডার স্ট্যাটাস আপডেট - #' . $this->order->order_number)
            ->greeting('প্রিয় ' . $notifiable->name . ',')
            ->line('আপনার অর্ডার #' . $this->order->order_number . ' এর স্ট্যাটাস পরিবর্তন হয়েছে।')
            ->line('বর্তমান স্ট্যাটাস: **' . $label . '**')
            ->action('অর্ডার দেখুন', route('order.show', $this->order->order_number))
            ->line('ধন্যবাদ আমাদের সাথে কেনাকাটা করার জন্য।');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'order_id'     => $this->order->id,
            'order_number' => $this->order->order_number,
            'status'       => $this->status,
            'message'      => 'আপনার অর্ডার #' . $this->order->order_number . ' এর স্ট্যাটাস পরিবর্তন হয়েছে।',
        ];
    }
}
