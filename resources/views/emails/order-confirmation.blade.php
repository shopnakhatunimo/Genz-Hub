<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>অর্ডার নিশ্চিতকরণ</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        <div style="background: #f8f9fa; padding: 30px; border-radius: 10px;">
            <h1 style="color: #2563eb; margin-bottom: 20px;">অর্ডার নিশ্চিতকরণ</h1>
            <p>প্রিয় {{ $order->name }},</p>
            <p>আপনার অর্ডার সফলভাবে গ্রহণ করা হয়েছে। আপনার অর্ডার নম্বর: <strong>{{ $order->order_number }}</strong></p>
            
            <div style="background: white; padding: 20px; margin: 20px 0; border-radius: 5px;">
                <h3 style="margin-bottom: 15px;">অর্ডার বিবরণ:</h3>
                @foreach($order->items as $item)
                <div style="display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #eee;">
                    <span>{{ $item->product->name }} x {{ $item->quantity }}</span>
                    <span>{{ formatPrice($item->subtotal) }}</span>
                </div>
                @endforeach
                <div style="display: flex; justify-content: space-between; padding: 15px 0; font-weight: bold; font-size: 18px;">
                    <span>মোট:</span>
                    <span>{{ formatPrice($order->total) }}</span>
                </div>
            </div>
            
            <p>আমরা আপনার অর্ডার প্রসেস করছি এবং শীঘ্রই ডেলিভারি করব।</p>
            <p style="margin-top: 20px;">ধন্যবাদ,<br>{{ getSiteName() }}</p>
        </div>
    </div>
</body>
</html>
