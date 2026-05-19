<?php

namespace App\Services;

use App\Models\SmtpSetting;
use Illuminate\Support\Facades\Mail;

class MailService
{
    public static function send($to, $subject, $view, $data = [])
    {
        SmtpSetting::applyConfig();

        try {
            Mail::send($view, $data, function ($message) use ($to, $subject) {
                $message->to($to)
                    ->subject($subject);
            });

            return true;
        } catch (\Exception $e) {
            \Log::error('Mail sending failed: ' . $e->getMessage());
            return false;
        }
    }

    public static function sendWelcomeEmail($user)
    {
        return self::send(
            $user->email,
            'স্বাগতম - ' . getSiteName(),
            'emails.welcome',
            ['user' => $user]
        );
    }

    public static function sendOrderConfirmation($order)
    {
        return self::send(
            $order->email,
            'অর্ডার নিশ্চিতকরণ - ' . $order->order_number,
            'emails.order-confirmation',
            ['order' => $order]
        );
    }

    public static function sendOrderShipped($order)
    {
        return self::send(
            $order->email,
            'অর্ডার পাঠানো হয়েছে - ' . $order->order_number,
            'emails.order-shipped',
            ['order' => $order]
        );
    }

    public static function sendOrderDelivered($order)
    {
        return self::send(
            $order->email,
            'অর্ডার ডেলিভারি হয়েছে - ' . $order->order_number,
            'emails.order-delivered',
            ['order' => $order]
        );
    }

    public static function sendPasswordReset($user, $token)
    {
        return self::send(
            $user->email,
            'পাসওয়ার্ড রিসেট',
            'emails.password-reset',
            ['user' => $user, 'token' => $token]
        );
    }
}
