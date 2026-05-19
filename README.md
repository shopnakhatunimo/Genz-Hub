# Laravel E-Commerce Website

একটি সম্পূর্ণ, প্রফেশনাল, স্কেলেবল এবং প্রোডাকশন-রেডি মোবাইল-ফার্স্ট ই-কমার্স ওয়েবসাইট যা Laravel দিয়ে তৈরি।

## ফিচারসমূহ

### ফ্রন্টএন্ড
- মোবাইল-ফার্স্ট রেসপন্সিভ ডিজাইন
- পণ্য ব্রাউজিং ও সার্চ
- ক্যাটাগরি ও সাবক্যাটাগরি
- শপিং কার্ট (AJAX সহ)
- উইশলিস্ট
- ইউজার অ্যাকাউন্ট ম্যানেজমেন্ট
- অর্ডার ট্র্যাকিং
- রিভিউ সিস্টেম
- কন্টাক্ট ফর্ম
- নিউজলেটার সাবস্ক্রিপশন

### অ্যাডমিন প্যানেল
- ড্যাশবোর্ড অ্যানালিটিক্স
- পণ্য ম্যানেজমেন্ট
- ক্যাটাগরি ম্যানেজমেন্ট
- অর্ডার ম্যানেজমেন্ট
- ইউজার ম্যানেজমেন্ট
- কুপন ম্যানেজমেন্ট
- ব্যানার ম্যানেজমেন্ট
- রিভিউ মডারেশন
- সাইট সেটিংস
- SMTP কনফিগারেশন

### টেকনিক্যাল ফিচার
- Laravel 11.x
- Blade Templates
- Tailwind CSS
- Alpine.js
- MySQL Database
- AJAX ইন্টারঅ্যাকশন
- SMTP মেইল সিস্টেম
- SEO অপ্টিমাইজড
- Render ডিপ্লয়মেন্ট রেডি

## ইনস্টলেশন

### প্রয়োজনীয়তা
- PHP >= 8.2
- Composer
- MySQL >= 5.7
- Node.js >= 18
- npm

### সেটআপ প্রক্রিয়া

1. রিপোজিটরি ক্লোন করুন:
```bash
git clone <repository-url>
cd ecommerce-website
```

2. ডিপেন্ডেন্সি ইনস্টল করুন:
```bash
composer install
npm install
```

3. এনভায়রনমেন্ট সেটআপ করুন:
```bash
cp .env.example .env
php artisan key:generate
```

4. `.env` ফাইল কনফিগার করুন:
```env
APP_NAME=E-Commerce
APP_ENV=local
APP_KEY=your-app-key
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ecommerce
DB_USERNAME=root
DB_PASSWORD=

MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
```

5. ডাটাবেস মাইগ্রেট করুন:
```bash
php artisan migrate
```

6. ডাটাবেস সিড করুন:
```bash
php artisan db:seed
```

7. স্টোরেজ লিংক করুন:
```bash
php artisan storage:link
```

8. অ্যাসেট কম্পাইল করুন:
```bash
npm run dev
```

9. ডেভেলপমেন্ট সার্ভার চালু করুন:
```bash
php artisan serve
```

10. ব্রাউজারে ওপেন করুন: `http://localhost:8000`

### অ্যাডমিন লগইন
- URL: `/admin/login`
- Email: `admin@example.com`
- Password: `password`

## ফোল্ডার স্ট্রাকচার

```
ecommerce-website/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Frontend/
│   │   │   ├── Admin/
│   │   │   └── Auth/
│   │   └── Middleware/
│   ├── Models/
│   ├── Services/
│   └── Helpers/
├── resources/
│   ├── views/
│   │   ├── layouts/
│   │   │   ├── frontend/
│   │   │   └── admin/
│   │   ├── frontend/
│   │   ├── admin/
│   │   └── emails/
│   ├── css/
│   └── js/
├── routes/
│   ├── web.php
│   ├── admin.php
│   └── api.php
├── database/
│   ├── migrations/
│   └── seeders/
├── public/
│   └── uploads/
└── config/
```

## ডিপ্লয়মেন্ট (Render)

প্রজেক্টটি Render এ ডিপ্লয় করতে এই ধাপগুলো অনুসরণ করুন:

1. রিপোজিটরি আপনার GitHub/GitLab এ পুশ করুন
2. Render এ নতুন Web Service তৈরি করুন
3. `render.yaml` ফাইল ব্যবহার করে কনফিগার করুন
4. এনভায়রনমেন্ট ভেরিয়েবল সেট করুন
5. ডিপ্লয় করুন

## ডাটাবেস টেবিলসমূহ

- users
- admins
- categories
- subcategories
- products
- product_images
- carts
- cart_items
- orders
- order_items
- wishlists
- reviews
- coupons
- banners
- settings
- smtp_settings
- addresses
- newsletters
- contacts
- payments

## কন্ট্রিবিউশন

কন্ট্রিবিউশন স্বাগতম! অনুগ্রহ করে একটি পুল রিকোয়েস্ট খুলুন।

## লাইসেন্স

এই প্রজেক্টটি MIT লাইসেন্সের অধীনে লাইসেন্সকৃত।

## সাপোর্ট

সাপোর্টের জন্য: support@example.com
# Genz-Hub
