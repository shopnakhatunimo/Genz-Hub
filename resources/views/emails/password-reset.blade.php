<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>পাসওয়ার্ড রিসেট</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        <div style="background: #f8f9fa; padding: 30px; border-radius: 10px;">
            <h1 style="color: #2563eb; margin-bottom: 20px;">পাসওয়ার্ড রিসেট</h1>
            <p>প্রিয় {{ $user->name }},</p>
            <p>আপনার অ্যাকাউন্টের পাসওয়ার্ড রিসেট করার জন্য একটি অনুরোধ পেয়েছি।</p>
            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ route('password.reset', $token) }}" style="background: #2563eb; color: white; padding: 12px 30px; text-decoration: none; border-radius: 5px; display: inline-block;">পাসওয়ার্ড রিসেট করুন</a>
            </div>
            <p style="font-size: 14px; color: #666;">যদি আপনি এই অনুরোধ না করে থাকেন, তবে এই ইমেইলটি উপেক্ষা করুন।</p>
            <p style="margin-top: 20px;">ধন্যবাদ,<br>{{ getSiteName() }}</p>
        </div>
    </div>
</body>
</html>
