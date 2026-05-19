<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>অর্ডার পাঠানো হয়েছে</title>
    <style>
        body { font-family: Arial, 'Noto Sans Bengali', sans-serif; line-height: 1.7; color: #333; background: #f5f5f5; }
        .wrapper { max-width: 600px; margin: 30px auto; background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 12px rgba(0,0,0,.08); }
        .header { background: #0ea5e9; padding: 28px 32px; text-align: center; }
        .header h1 { color: #fff; font-size: 22px; margin: 0; }
        .body { padding: 32px; }
        .body p { font-size: 15px; margin-bottom: 14px; color: #555; }
        .btn { display: inline-block; background: #0ea5e9; color: #fff; padding: 12px 28px; border-radius: 8px; text-decoration: none; font-size: 15px; margin: 16px 0; }
        .info-box { background: #f0f9ff; border-left: 4px solid #0ea5e9; border-radius: 8px; padding: 16px 20px; margin: 18px 0; }
        .order-table { width: 100%; border-collapse: collapse; margin: 18px 0; }
        .order-table th, .order-table td { border: 1px solid #eee; padding: 10px 14px; font-size: 14px; }
        .order-table th { background: #f0f9ff; text-align: left; }
        .footer { background: #f8fafc; padding: 20px 32px; text-align: center; border-top: 1px solid #eee; }
        .footer p { font-size: 13px; color: #888; }
    </style>
</head>
<body>
<div class="wrapper">
    <div class="header"><h1>📦 {{ getSiteName() }}</h1></div>
    <div class="body">
        <p>প্রিয় <strong>{{ $order->name }}</strong>,</p>
        <p>সুখবর! আপনার অর্ডার <strong>#{{ $order->order_number }}</strong> পাঠানো হয়েছে এবং শীঘ্রই আপনার কাছে পৌঁছে যাবে।</p>

        <div class="info-box">
            <p style="margin:0;"><strong>অর্ডার নম্বর:</strong> #{{ $order->order_number }}</p>
            <p style="margin:0;"><strong>ডেলিভারির ঠিকানা:</strong> {{ $order->address }}</p>
            @if($order->tracking_number)
            <p style="margin:0;"><strong>ট্র্যাকিং নম্বর:</strong> {{ $order->tracking_number }}</p>
            @endif
        </div>

        <table class="order-table">
            <tr><th>পণ্য</th><th>পরিমাণ</th><th>মূল্য</th></tr>
            @foreach($order->items as $item)
            <tr>
                <td>{{ $item->product_name }}</td>
                <td>{{ $item->quantity }}</td>
                <td>৳{{ number_format($item->subtotal, 2) }}</td>
            </tr>
            @endforeach
            <tr style="font-weight:bold; background:#f0f9ff;">
                <td colspan="2">মোট</td>
                <td>৳{{ number_format($order->total, 2) }}</td>
            </tr>
        </table>

        <p style="text-align:center;">
            <a href="{{ route('order.track', $order->order_number) }}" class="btn">অর্ডার ট্র্যাক করুন</a>
        </p>
        <p>ধন্যবাদ আমাদের সাথে কেনাকাটা করার জন্য।</p>
        <p>শুভেচ্ছায়,<br><strong>{{ getSiteName() }}</strong></p>
    </div>
    <div class="footer">
        <p>&copy; {{ date('Y') }} {{ getSiteName() }}. সর্বস্বত্ব সংরক্ষিত।</p>
    </div>
</div>
</body>
</html>
