<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>মেইনটেন্যান্স চলছে</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: Arial, 'Noto Sans Bengali', sans-serif;
            background: linear-gradient(135deg, #1e3a5f 0%, #2563eb 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            text-align: center;
            padding: 20px;
        }
        .container { max-width: 500px; }
        .icon { font-size: 80px; margin-bottom: 24px; animation: spin 3s linear infinite; display: inline-block; }
        @keyframes spin {
            0%, 100% { transform: rotate(0deg); }
            25% { transform: rotate(-10deg); }
            75% { transform: rotate(10deg); }
        }
        h1 { font-size: 32px; margin-bottom: 12px; }
        p { font-size: 16px; opacity: .85; line-height: 1.8; margin-bottom: 12px; }
        .eta { display: inline-block; background: rgba(255,255,255,.15); border: 1px solid rgba(255,255,255,.3); border-radius: 50px; padding: 8px 24px; font-size: 14px; margin-top: 16px; }
        .contact { margin-top: 32px; font-size: 14px; opacity: .7; }
        .contact a { color: #93c5fd; text-decoration: none; }
    </style>
</head>
<body>
    <div class="container">
        <div class="icon">🔧</div>
        <h1>{{ config('app.maintenance_title', 'মেইনটেন্যান্স চলছে') }}</h1>
        <p>{{ config('app.maintenance_message', 'আমরা আমাদের সাইট আপডেট করছি।<br>শীঘ্রই ফিরে আসছি।') }}</p>
        @if(config('app.maintenance_eta'))
        <div class="eta">⏱ আনুমানিক সময়: {{ config('app.maintenance_eta') }}</div>
        @endif
        <div class="contact">
            <p>জরুরি যোগাযোগের জন্য:</p>
            <p><a href="mailto:{{ config('mail.from.address') }}">{{ config('mail.from.address') }}</a></p>
        </div>
    </div>
</body>
</html>
