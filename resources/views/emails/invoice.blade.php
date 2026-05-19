<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ইনভয়েস #{{ $order->order_number }}</title>
    <style>
        body { font-family: Arial, 'Noto Sans Bengali', sans-serif; line-height: 1.6; color: #333; background: #f5f5f5; }
        .wrapper { max-width: 650px; margin: 30px auto; background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 12px rgba(0,0,0,.08); }
        .header { background: #1e3a5f; padding: 28px 32px; display: flex; justify-content: space-between; align-items: center; }
        .header h1 { color: #fff; font-size: 20px; margin: 0; }
        .header .invoice-num { color: #93c5fd; font-size: 14px; }
        .body { padding: 32px; }
        .row-two { display: flex; gap: 20px; margin-bottom: 24px; }
        .box { flex: 1; background: #f8fafc; border-radius: 8px; padding: 14px 18px; }
        .box h3 { font-size: 13px; color: #888; margin-bottom: 6px; text-transform: uppercase; letter-spacing: .5px; }
        .box p { font-size: 14px; color: #333; margin: 0; line-height: 1.6; }
        .order-table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        .order-table th { background: #1e3a5f; color: #fff; padding: 10px 14px; font-size: 13px; text-align: left; }
        .order-table td { border-bottom: 1px solid #eee; padding: 10px 14px; font-size: 14px; }
        .order-table tr:last-child td { border-bottom: none; }
        .totals { margin-left: auto; width: 260px; }
        .totals table { width: 100%; border-collapse: collapse; }
        .totals td { padding: 6px 10px; font-size: 14px; }
        .totals .grand-total td { font-weight: bold; font-size: 16px; background: #1e3a5f; color: #fff; }
        .footer { background: #f8fafc; padding: 20px 32px; text-align: center; border-top: 1px solid #eee; }
        .footer p { font-size: 12px; color: #aaa; }
    </style>
</head>
<body>
<div class="wrapper">
    <div class="header">
        <div>
            <h1>{{ getSiteName() }}</h1>
            <div class="invoice-num">ইনভয়েস #{{ $order->order_number }}</div>
        </div>
        <div style="text-align:right; color:#93c5fd; font-size:13px;">
            <div>তারিখ: {{ $order->created_at->format('d M, Y') }}</div>
            <div>স্ট্যাটাস: {{ $order->status }}</div>
        </div>
    </div>
    <div class="body">
        <div class="row-two">
            <div class="box">
                <h3>গ্রাহকের তথ্য</h3>
                <p>{{ $order->name }}<br>{{ $order->phone }}<br>{{ $order->email }}</p>
            </div>
            <div class="box">
                <h3>ডেলিভারির ঠিকানা</h3>
                <p>{{ $order->address }}<br>{{ $order->city }}, {{ $order->district }}</p>
            </div>
        </div>

        <table class="order-table">
            <tr><th>#</th><th>পণ্য</th><th>মূল্য</th><th>পরিমাণ</th><th>মোট</th></tr>
            @foreach($order->items as $i => $item)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $item->product_name }}</td>
                <td>৳{{ number_format($item->price, 2) }}</td>
                <td>{{ $item->quantity }}</td>
                <td>৳{{ number_format($item->subtotal, 2) }}</td>
            </tr>
            @endforeach
        </table>

        <div class="totals">
            <table>
                <tr><td>সাবটোটাল</td><td style="text-align:right;">৳{{ number_format($order->subtotal ?? $order->total, 2) }}</td></tr>
                @if($order->discount > 0)
                <tr><td>ছাড়</td><td style="text-align:right; color:#dc2626;">-৳{{ number_format($order->discount, 2) }}</td></tr>
                @endif
                <tr><td>ডেলিভারি চার্জ</td><td style="text-align:right;">৳{{ number_format($order->shipping_charge ?? 0, 2) }}</td></tr>
                <tr class="grand-total"><td>মোট পরিশোধযোগ্য</td><td style="text-align:right;">৳{{ number_format($order->total, 2) }}</td></tr>
            </table>
        </div>

        <p style="margin-top:24px; font-size:13px; color:#888;">পেমেন্ট পদ্ধতি: {{ $order->payment_method === 'cod' ? 'ক্যাশ অন ডেলিভারি' : 'অনলাইন পেমেন্ট' }}</p>
    </div>
    <div class="footer">
        <p>ধন্যবাদ আমাদের সাথে কেনাকাটা করার জন্য। &copy; {{ date('Y') }} {{ getSiteName() }}.</p>
    </div>
</div>
</body>
</html>
