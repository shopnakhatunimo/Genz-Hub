# Render-এ Deploy করার গাইড (Zero-Config)

এই প্রজেক্টে **Installation Wizard** আছে — deploy করার পর ব্রাউজার থেকেই সব কিছু সেটআপ করা যাবে।

---

## মাত্র ৩টি ধাপে সম্পূর্ণ Deploy

---

## ধাপ ১: GitHub-এ কোড পুশ করুন

```bash
git init
git add .
git commit -m "Initial commit"
git remote add origin https://github.com/YOUR_USERNAME/ecommerce-website.git
git push -u origin main
```

---

## ধাপ ২: Render-এ Deploy করুন

1. 👉 [render.com](https://render.com) → GitHub দিয়ে Sign Up
2. Dashboard → **New +** → **Web Service**
3. আপনার GitHub repo connect করুন
4. নিচের settings দিন:

| Field | Value |
|-------|-------|
| **Name** | ecommerce-website |
| **Runtime** | PHP |
| **Region** | Oregon |
| **Plan** | Free |

**Build Command:**
```
composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev && npm install && npm run build && [ ! -f .env ] && cp .env.example .env; php artisan key:generate --force && touch database/database.sqlite && php artisan storage:link
```

**Start Command:**
```
php artisan serve --host=0.0.0.0 --port=$PORT
```

**Health Check Path:** `/up`

5. **কোনো Environment Variable দেওয়ার দরকার নেই** — Render নিজেই `render.yaml` পড়ে সব সেট করবে।
6. **"Create Web Service"** ক্লিক করুন

Build শেষ হতে ৫–১০ মিনিট লাগবে।

---

## ধাপ ৩: Setup Wizard চালান

Deploy সম্পন্ন হওয়ার পর আপনার সাইটে যান:

```
https://ecommerce-website.onrender.com
```

**Setup Wizard স্বয়ংক্রিয়ভাবে খুলবে।** Wizard-এ পর্যায়ক্রমে দিন:

| ধাপ | কী দিতে হবে |
|-----|-------------|
| ১. সিস্টেম যাচাই | সব ✅ হলে এগিয়ে যান |
| ২. ডাটাবেস | **SQLite** বেছে নিন (কোনো সার্ভার লাগবে না) |
| ৩. সাইট তথ্য | দোকানের নাম, URL |
| ৪. অ্যাডমিন | আপনার নাম, ইমেইল, পাসওয়ার্ড |
| ৫. ইমেইল | Gmail info (ঐচ্ছিক — পরেও দেওয়া যাবে) |
| ৬. ইন্সটল | "ইন্সটলেশন শুরু করুন" চাপুন |

Wizard শেষ হলে সরাসরি **অ্যাডমিন প্যানেলে** চলে যাবেন।

---

## Admin Panel

| | |
|--|--|
| **URL** | `https://your-app.onrender.com/admin` |
| **Email** | Wizard-এ যা দিয়েছিলেন |
| **Password** | Wizard-এ যা দিয়েছিলেন |

### Admin-এ প্রথম কাজ:
1. **Settings → General** — সাইটের ছবি, ফোন নম্বর যোগ করুন
2. **Settings → SMTP** — ইমেইল পাঠানোর জন্য Gmail সেটআপ করুন
3. **Settings → Payment** — Cash on Delivery চালু করুন
4. **Categories** → ক্যাটাগরি তৈরি করুন
5. **Products** → পণ্য যোগ করুন

---

## ডাটাবেস অপশন

### SQLite (ডিফল্ট — কোনো setup লাগে না)
Wizard-এ SQLite বেছে নিন। ফাইল হিসেবে সংরক্ষিত হয়।

> ⚠️ **Render Free Plan সমস্যা:** প্রতিবার redeploy হলে SQLite ডেটা মুছে যায়।
> সমাধান: MySQL বা PostgreSQL ব্যবহার করুন (নিচে দেখুন)।

### MySQL — PlanetScale (বিনামূল্যে, ৫ GB)
1. 👉 [planetscale.com](https://planetscale.com) → Free account
2. New Database → Singapore region
3. Connect → Laravel → credentials নিন
4. Wizard-এ MySQL বেছে নিন, credentials দিন

### PostgreSQL — Neon (বিনামূল্যে)
1. 👉 [neon.tech](https://neon.tech) → Free account
2. New Project → Singapore
3. Connection string নিন
4. Wizard-এ PostgreSQL বেছে নিন

---

## Gmail SMTP সেটআপ (Wizard বা Admin Panel থেকে)

1. 👉 [myaccount.google.com](https://myaccount.google.com) → Security
2. 2-Step Verification চালু করুন
3. App Passwords → Generate → ১৬ সংখ্যার password পাবেন
4. Wizard বা Admin → Settings → SMTP-তে দিন:

| Field | Value |
|-------|-------|
| Host | `smtp.gmail.com` |
| Port | `587` |
| Username | আপনার Gmail |
| Password | App Password (১৬ সংখ্যা) |
| Encryption | `tls` |

---

## Render Free Plan সীমাবদ্ধতা

| সমস্যা | সমাধান |
|--------|--------|
| ১৫ মিনিট idle → ঘুমিয়ে পড়ে | প্রথম request-এ ৩০ সেক দেরি — স্বাভাবিক |
| SQLite ডেটা মুছে যায় (redeploy-এ) | PlanetScale MySQL বা Neon PostgreSQL ব্যবহার করুন |
| আপলোড ছবি মুছে যায় | Cloudinary বা AWS S3 ব্যবহার করুন |
| মাসে ৭৫০ ঘণ্টা compute | Paid plan নিন বা Railway.app ব্যবহার করুন |

---

## সমস্যা হলে

| সমস্যা | সমাধান |
|--------|--------|
| **Wizard খুলছে না** | Build সফল হয়েছে কিনা Logs দেখুন |
| **500 Error** | Render → Logs tab দেখুন |
| **DB সংযোগ হচ্ছে না** | DB host/port/credentials পুনরায় দিন |
| **CSS/JS দেখা যাচ্ছে না** | Build log-এ `npm run build` সফল হয়েছে কিনা দেখুন |
| **Wizard বারবার আসছে** | DB-তে Admin আছে কিনা দেখুন; redeploy-এর পরও Wizard আসলে External DB ব্যবহার করুন |

---

## Custom Domain

1. Web Service → Settings → Custom Domains
2. Domain যোগ করুন → DNS নির্দেশনা অনুসরণ করুন
3. Admin → Settings → General-এ Site URL আপডেট করুন
4. Render বিনামূল্যে SSL/TLS দেবে
