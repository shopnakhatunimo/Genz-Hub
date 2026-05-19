<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>নতুন অর্ডার</title>
    <style>
        body { font-family: Arial, 'Noto Sans Bengali', sans-serif; line-height: 1.7; color: #333; background: #f5f5f5; }
        .wrapper { max-width: 600px; margin: 30px auto; background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 12px rgba(0,0,0,.08); }
        .header { background: #dc2626; padding: 28px 32px; text-align: center; }
        .header h1 { color: #fff; font-size: 22px; margin: 0; }
        .body { padding: 32px; }
        .body p { font-size: 15px; margin-bottom: 14px; color: #555; }
        .btn { display: inline-block; background: #dc2626; color: #fff; padding: 12px 28px; border-radius: 8px; text-decoration: none; font-size: 15px; margin: 16px 0; }
        .info-box { background: #fef2f2; border-left: 4px solid #dc2626; border-radius: 8px; padding: 16px 20px; margin: 18px 0; }
        .order-table { width: 100%; border-collapse: collapse; margin: 18px 0; }
        .order-table th, .order-table td { border: 1px solid #eee; padding: 10px 14px; font-size: 14px; }
        .order-table th { background: #fef2f2; text-align: left; }
        .footer { background: #f8fafc; padding: 20px 32px; text-align: center; border-top: 1px solid #eee; }
        .footer p { font-size: 13px; color: #888; }
    </style>
</head>
<body>
<div class="wrapper">
    <div class="header"><h1>🛍️ নতুন অর্ডার পাওয়া গেছে!</h1></div>
    <div class="body">
        <p>একটি নতুন অর্ডার পাওয়া গেছে। অনুগ্রহ করে দ্রুত প্রক্রিয়া করুন।</p>

        <div class="info-box">
            <p style="margin:0;"><strong>অর্ডার নম্বর:</strong> #{{ $order->order_number }}</p>
            <p style="margin:0;"><strong>গ্রাহকের নাম:</strong> {{ $order->name }}</p>
            <p style="margin:0;"><strong>ফোন:</strong> {{ $order->phone }}</p>
            <p style="margin:0;"><strong>ঠিকানা:</strong> {{ $order->address }}</p>
            <p style="margin:0;"><strong>পেমেন্ট:</strong> {{ $order->payment_method === 'cod' ? 'ক্যাশ অন ডেলিভারি' : 'অনলাইন পেমেন্ট' }}</p>
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
            @if($order->discount > 0)
            <tr><td colspan="2">ছাড়</td><td>-৳{{ number_format($order->discount, 2) }}</td></tr>
            @endif
            <tr style="font-weight:bold; background:#fef2f2;">
                <td colspan="2">মোট</td>
                <td>৳{{ number_format($order->total, 2) }}</td>
            </tr>
        </table>

        <p style="text-align:center;">
            <a href="{{ url('/admin/orders/' . $order->id) }}" class="btn">অর্ডার প্রক্রিয়া করুন</a>
        </p>
    </div>
    <div class="footer">
        <p>এই ইমেইল স্বয়ংক্রিয়ভাবে পাঠানো হয়েছে। &copy; {{ date('Y') }} {{ getSiteName() }}.</p>
    </div>
</div>
</body>
</html>
