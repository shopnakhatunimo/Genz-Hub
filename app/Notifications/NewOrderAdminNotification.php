<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class NewOrderAdminNotification extends Notification
{
    use Queueable;

    public Order $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('নতুন অর্ডার প্রাপ্ত - #' . $this->order->order_number)
            ->greeting('নতুন অর্ডার!')
            ->line('একটি নতুন অর্ডার পাওয়া গেছে।')
            ->line('অর্ডার নম্বর: #' . $this->order->order_number)
            ->line('গ্রাহকের নাম: ' . $this->order->name)
            ->line('মোট মূল্য: ৳' . number_format($this->order->total, 2))
            ->action('অর্ডার দেখুন', url('/admin/orders/' . $this->order->id))
            ->line('অনুগ্রহ করে দ্রুত প্রক্রিয়া করুন।');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'order_id'     => $this->order->id,
            'order_number' => $this->order->order_number,
            'total'        => $this->order->total,
        ];
    }
}
