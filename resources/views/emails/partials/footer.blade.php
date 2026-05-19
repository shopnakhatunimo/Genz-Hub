    </div>
    <div class="footer">
        <p>এই ইমেইলটি স্বয়ংক্রিয়ভাবে পাঠানো হয়েছে। অনুগ্রহ করে সরাসরি উত্তর দেবেন না।</p>
        <p style="margin-top:8px;">
            <a href="{{ url('/') }}">{{ getSiteName() }}</a> &bull;
            {{ getSetting('site_phone') }} &bull;
            {{ getSetting('site_email') }}
        </p>
        <p style="margin-top:8px; font-size:12px; color:#aaa;">&copy; {{ date('Y') }} {{ getSiteName() }}. সর্বস্বত্ব সংরক্ষিত।</p>
    </div>
</div>
</body>
</html>
