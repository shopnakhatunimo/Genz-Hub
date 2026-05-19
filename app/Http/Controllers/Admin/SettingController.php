<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\SmtpSetting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $settings = Setting::getByGroup('general');
        return view('admin.settings.general', compact('settings'));
    }

    public function general()
    {
        return $this->index();
    }

    public function updateGeneral(Request $request)
    {
        $settings = [
            'site_name' => $request->site_name,
            'site_email' => $request->site_email,
            'site_phone' => $request->site_phone,
            'site_address' => $request->site_address,
            'currency' => $request->currency,
            'facebook' => $request->facebook,
            'twitter' => $request->twitter,
            'instagram' => $request->instagram,
            'youtube' => $request->youtube,
        ];

        foreach ($settings as $key => $value) {
            Setting::set($key, $value, 'general');
        }

        if ($request->hasFile('logo')) {
            $logo = time() . '.' . $request->file('logo')->getClientOriginalExtension();
            $request->file('logo')->move(public_path('uploads'), $logo);
            Setting::set('logo', $logo, 'general');
        }

        if ($request->hasFile('favicon')) {
            $favicon = time() . '.' . $request->file('favicon')->getClientOriginalExtension();
            $request->file('favicon')->move(public_path('uploads'), $favicon);
            Setting::set('favicon', $favicon, 'general');
        }

        return redirect()->back()->with('success', 'সেটিংস আপডেট করা হয়েছে।');
    }

    public function smtp()
    {
        $smtp = SmtpSetting::first();
        return view('admin.settings.smtp', compact('smtp'));
    }

    public function updateSmtp(Request $request)
    {
        $request->validate([
            'host' => 'required|string',
            'port' => 'required|string',
            'username' => 'required|string',
            'password' => 'required|string',
            'encryption' => 'nullable|string',
            'from_address' => 'required|email',
            'from_name' => 'required|string',
        ]);

        SmtpSetting::updateOrCreate(
            ['id' => $request->id],
            [
                'mailer' => 'smtp',
                'host' => $request->host,
                'port' => $request->port,
                'username' => $request->username,
                'password' => $request->password,
                'encryption' => $request->encryption,
                'from_address' => $request->from_address,
                'from_name' => $request->from_name,
                'status' => true,
            ]
        );

        return redirect()->back()->with('success', 'SMTP সেটিংস আপডেট করা হয়েছে।');
    }

    public function testSmtp(Request $request)
    {
        return $this->testEmail($request);
    }

    public function testEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        try {
            SmtpSetting::applyConfig();
            \Mail::raw('এটি একটি টেস্ট ইমেইল।', function ($message) use ($request) {
                $message->to($request->email)
                    ->subject('টেস্ট ইমেইল');
            });

            return redirect()->back()->with('success', 'টেস্ট ইমেইল সফলভাবে পাঠানো হয়েছে।');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'ইমেইল পাঠাতে সমস্যা হয়েছে: ' . $e->getMessage());
        }
    }

    public function seo()
    {
        $settings = Setting::getByGroup('seo');
        return view('admin.settings.seo', compact('settings'));
    }

    public function updateSeo(Request $request)
    {
        $settings = [
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'meta_keywords' => $request->meta_keywords,
            'google_analytics' => $request->google_analytics,
            'facebook_pixel' => $request->facebook_pixel,
        ];

        foreach ($settings as $key => $value) {
            Setting::set($key, $value, 'seo');
        }

        return redirect()->back()->with('success', 'SEO সেটিংস আপডেট করা হয়েছে।');
    }

    public function payment()
    {
        $settings = Setting::getByGroup('payment');
        return view('admin.settings.payment', compact('settings'));
    }

    public function updatePayment(Request $request)
    {
        $settings = [
            'cash_on_delivery' => $request->cash_on_delivery ?? '0',
            'online_payment' => $request->online_payment ?? '0',
            'bkash_merchant_key' => $request->bkash_merchant_key,
            'nagad_merchant_key' => $request->nagad_merchant_key,
        ];

        foreach ($settings as $key => $value) {
            Setting::set($key, $value, 'payment');
        }

        return redirect()->back()->with('success', 'পেমেন্ট সেটিংস আপডেট করা হয়েছে।');
    }

    // ===================================
    // Social Settings
    // ===================================

    public function social()
    {
        return view('admin.settings.social');
    }

    public function updateSocial(Request $request)
    {
        $keys = ['facebook', 'instagram', 'twitter', 'youtube', 'whatsapp', 'tiktok'];

        foreach ($keys as $key) {
            Setting::set($key, $request->input($key), 'social');
        }

        return redirect()->back()->with('success', 'সোশ্যাল মিডিয়া সেটিংস আপডেট করা হয়েছে।');
    }

    // ===================================
    // Maintenance Mode
    // ===================================

    public function maintenance()
    {
        $isDown = app()->isDownForMaintenance();
        return view('admin.settings.maintenance', compact('isDown'));
    }

    public function maintenanceToggle()
    {
        if (app()->isDownForMaintenance()) {
            \Artisan::call('up');
            return redirect()->back()->with('success', 'ওয়েবসাইট স্বাভাবিকভাবে চালু করা হয়েছে।');
        }

        \Artisan::call('down', [
            '--render' => 'errors.503',
            '--secret' => config('app.key'),
        ]);

        return redirect()->back()->with('success', 'মেইনটেন্যান্স মোড চালু করা হয়েছে।');
    }

    public function maintenanceMessage(Request $request)
    {
        $request->validate([
            'maintenance_title'   => 'nullable|string|max:255',
            'maintenance_message' => 'nullable|string|max:500',
            'maintenance_eta'     => 'nullable|string|max:100',
        ]);

        Setting::set('maintenance_title', $request->maintenance_title, 'general');
        Setting::set('maintenance_message', $request->maintenance_message, 'general');
        Setting::set('maintenance_eta', $request->maintenance_eta, 'general');

        return redirect()->back()->with('success', 'মেইনটেন্যান্স বার্তা আপডেট করা হয়েছে।');
    }
}
