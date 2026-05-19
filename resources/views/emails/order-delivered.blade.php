<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ডেলিভারি সম্পন্ন</title>
    <style>
        body { font-family: Arial, 'Noto Sans Bengali', sans-serif; line-height: 1.7; color: #333; background: #f5f5f5; }
        .wrapper { max-width: 600px; margin: 30px auto; background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 12px rgba(0,0,0,.08); }
        .header { background: #16a34a; padding: 28px 32px; text-align: center; }
        .header h1 { color: #fff; font-size: 22px; margin: 0; }
        .body { padding: 32px; }
        .body p { font-size: 15px; margin-bottom: 14px; color: #555; }
        .btn { display: inline-block; background: #16a34a; color: #fff; padding: 12px 28px; border-radius: 8px; text-decoration: none; font-size: 15px; margin: 8px 0; }
        .btn-outline { background: #fff; color: #16a34a; border: 2px solid #16a34a; margin-left: 10px; }
        .info-box { background: #f0fdf4; border-left: 4px solid #16a34a; border-radius: 8px; padding: 16px 20px; margin: 18px 0; }
        .stars { font-size: 28px; letter-spacing: 4px; }
        .footer { background: #f8fafc; padding: 20px 32px; text-align: center; border-top: 1px solid #eee; }
        .footer p { font-size: 13px; color: #888; }
    </style>
</head>
<body>
<div class="wrapper">
    <div class="header"><h1>✅ {{ getSiteName() }}</h1></div>
    <div class="body">
        <p>প্রিয় <strong>{{ $order->name }}</strong>,</p>
        <p>আপনার অর্ডার <strong>#{{ $order->order_number }}</strong> সফলভাবে ডেলিভারি হয়েছে। আশা করি আপনি পণ্যটি পছন্দ করেছেন!</p>

        <div class="info-box">
            <p style="margin:0;"><strong>অর্ডার নম্বর:</strong> #{{ $order->order_number }}</p>
            <p style="margin:0;"><strong>মোট পরিমাণ:</strong> ৳{{ number_format($order->total, 2) }}</p>
            <p style="margin:0;"><strong>ডেলিভারির তারিখ:</strong> {{ now()->format('d M, Y') }}</p>
        </div>

        <p>আপনার মতামত আমাদের কাছে অত্যন্ত গুরুত্বপূর্ণ। পণ্যটি সম্পর্কে আপনার রিভিউ দিন:</p>
        <p class="stars">⭐⭐⭐⭐⭐</p>

        <p style="text-align:center;">
            <a href="{{ route('order.show', $order->order_number) }}" class="btn">রিভিউ দিন</a>
            <a href="{{ url('/shop') }}" class="btn btn-outline">আবার কেনাকাটা করুন</a>
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
