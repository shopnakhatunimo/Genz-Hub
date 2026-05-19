<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>স্বাগতম</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        <div style="background: #f8f9fa; padding: 30px; border-radius: 10px;">
            <h1 style="color: #2563eb; margin-bottom: 20px;">স্বাগতম, {{ $user->name }}!</h1>
            <p>{{ getSiteName() }}-এ আপনাকে স্বাগতম। আমরা আপনাকে আমাদের পরিবারের অংশ হতে পেরে আনন্দিত।</p>
            <p>আপনার অ্যাকাউন্ট সফলভাবে তৈরি হয়েছে। এখন আপনি আমাদের সব পণ্য ব্রাউজ করতে পারবেন এবং অর্ডার করতে পারবেন।</p>
            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ route('home') }}" style="background: #2563eb; color: white; padding: 12px 30px; text-decoration: none; border-radius: 5px; display: inline-block;">শপিং শুরু করুন</a>
            </div>
            <p style="font-size: 14px; color: #666;">যেকোনো প্রশ্নের জন্য আমাদের সাথে যোগাযোগ করুন।</p>
            <p style="margin-top: 20px;">ধন্যবাদ,<br>{{ getSiteName() }}</p>
        </div>
    </div>
</body>
</html>
