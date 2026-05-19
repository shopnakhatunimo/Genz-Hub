<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>নিউজলেটার</title>
    <style>
        body { font-family: Arial, 'Noto Sans Bengali', sans-serif; line-height: 1.7; color: #333; background: #f5f5f5; }
        .wrapper { max-width: 600px; margin: 30px auto; background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 12px rgba(0,0,0,.08); }
        .header { background: #7c3aed; padding: 28px 32px; text-align: center; }
        .header h1 { color: #fff; font-size: 22px; margin: 0; }
        .body { padding: 32px; font-size: 15px; color: #555; }
        .btn { display: inline-block; background: #7c3aed; color: #fff; padding: 12px 28px; border-radius: 8px; text-decoration: none; font-size: 15px; margin: 16px 0; }
        .footer { background: #f8fafc; padding: 20px 32px; text-align: center; border-top: 1px solid #eee; }
        .footer p { font-size: 12px; color: #aaa; }
        .footer a { color: #7c3aed; text-decoration: none; }
    </style>
</head>
<body>
<div class="wrapper">
    <div class="header"><h1>📩 {{ getSiteName() }} নিউজলেটার</h1></div>
    <div class="body">
        {!! $body !!}
        <p style="text-align:center; margin-top:24px;">
            <a href="{{ url('/shop') }}" class="btn">এখনই কেনাকাটা করুন</a>
        </p>
    </div>
    <div class="footer">
        <p>আপনি এই ইমেইল পাচ্ছেন কারণ আপনি আমাদের নিউজলেটারে সাবস্ক্রাইব করেছেন।</p>
        <p><a href="{{ url('/newsletter/unsubscribe') }}">আনসাবস্ক্রাইব করুন</a></p>
        <p>&copy; {{ date('Y') }} {{ getSiteName() }}.</p>
    </div>
</div>
</body>
</html>
