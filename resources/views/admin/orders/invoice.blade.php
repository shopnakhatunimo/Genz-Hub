<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="utf-8">
    <title>Invoice - {{ $order->order_number }}</title>
    <style>
        body { font-family: sans-serif; font-size: 14px; color: #333; margin: 0; padding: 20px; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #333; padding-bottom: 20px; }
        .header h1 { font-size: 24px; margin: 0 0 5px; }
        .invoice-info { display: flex; justify-content: space-between; margin-bottom: 30px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background: #f5f5f5; }
        .totals { text-align: right; }
        .totals table { width: 300px; float: right; }
        .total-row { font-weight: bold; font-size: 16px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ getSetting('site_name', 'E-Commerce') }}</h1>
        <p>{{ getSetting('site_address', '') }}</p>
        <p>Invoice #{{ $order->order_number }}</p>
    </div>

    <div class="invoice-info">
        <div>
            <strong>গ্রাহকের তথ্য:</strong><br>
            নাম: {{ $order->name }}<br>
            ইমেইল: {{ $order->email }}<br>
            ফোন: {{ $order->phone }}<br>
            ঠিকানা: {{ $order->address }}, {{ $order->city }}
        </div>
        <div>
            <strong>Invoice তারিখ:</strong> {{ $order->created_at->format('d M Y') }}<br>
            <strong>পেমেন্ট পদ্ধতি:</strong> {{ $order->payment_method }}<br>
            <strong>স্ট্যাটাস:</strong> {{ $order->order_status }}
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>পণ্য</th>
                <th>পরিমাণ</th>
                <th>মূল্য</th>
                <th>মোট</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $i => $item)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $item->product_name }}</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ formatPrice($item->price) }}</td>
                <td>{{ formatPrice($item->subtotal) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="totals">
        <table>
            <tr><td>সাবটোটাল</td><td>{{ formatPrice($order->subtotal) }}</td></tr>
            <tr><td>ডেলিভারি চার্জ</td><td>{{ formatPrice($order->shipping_charge) }}</td></tr>
            @if($order->discount > 0)
            <tr><td>ডিসকাউন্ট</td><td>-{{ formatPrice($order->discount) }}</td></tr>
            @endif
            <tr class="total-row"><td><strong>সর্বমোট</strong></td><td><strong>{{ formatPrice($order->total) }}</strong></td></tr>
        </table>
    </div>
</body>
</html>
