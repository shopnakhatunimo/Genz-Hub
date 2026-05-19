<?php

namespace App\Http\Controllers\Setup;

use App\Http\Controllers\Controller;
use App\Services\SetupService;
use Illuminate\Http\Request;

class SetupController extends Controller
{
    public function __construct(protected SetupService $setup) {}

    /**
     * Show the multi-step setup wizard.
     */
    public function index()
    {
        if ($this->alreadyInstalled()) {
            return redirect('/');
        }

        $requirements = $this->setup->checkRequirements();

        return view('setup.index', compact('requirements'));
    }

    /**
     * Test database connection (AJAX).
     */
    public function testDb(Request $request)
    {
        $result = $this->setup->testDbConnection($request->all());
        return response()->json($result);
    }

    /**
     * Run the full installation process (AJAX).
     */
    public function install(Request $request)
    {
        $request->validate([
            'app_name'                   => 'required|string|max:100',
            'app_url'                    => 'required|url',
            'db_connection'              => 'required|in:mysql,pgsql,sqlite',
            'admin_name'                 => 'required|string|max:100',
            'admin_email'                => 'required|email',
            'admin_password'             => 'required|string|min:6|confirmed',
            'admin_password_confirmation'=> 'required',
        ]);

        $data = $request->all();

        // Existing APP_KEY থেকে নিন বা নতুন generate করুন
        $data['app_key'] = env('APP_KEY') ?: $this->setup->generateKey();

        // ধাপ ১: DB dynamically reconfigure করুন (current request-এর জন্য)
        try {
            $this->setup->reconfigureDatabase($data);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false, 'step' => 'db',
                'message' => 'ডাটাবেস সংযোগ স্থাপন করা যায়নি: ' . $e->getMessage(),
            ]);
        }

        // ধাপ ২: Migrations চালান
        if (!$this->setup->runMigrations()) {
            return response()->json([
                'success' => false, 'step' => 'migrate',
                'message' => 'ডাটাবেস টেবিল তৈরি করা যায়নি। ডাটাবেস সংযোগ ও অনুমতি পরীক্ষা করুন।',
            ]);
        }

        // ধাপ ৩: Admin অ্যাকাউন্ট তৈরি করুন
        if (!$this->setup->createAdmin([
            'name'     => $data['admin_name'],
            'email'    => $data['admin_email'],
            'password' => $data['admin_password'],
        ])) {
            return response()->json([
                'success' => false, 'step' => 'admin',
                'message' => 'অ্যাডমিন অ্যাকাউন্ট তৈরি করা যায়নি।',
            ]);
        }

        // ধাপ ৪: Site ও SMTP settings সেভ করুন
        $this->setup->saveSiteSettings($data);

        if (!($data['skip_smtp'] ?? true)) {
            $this->setup->saveSmtpSettings($data);
        }

        // ধাপ ৫: .env ফাইল আপডেট করুন
        $this->setup->writeEnv($data);

        // ধাপ ৬: DB config JSON-এ সেভ করুন (restart ছাড়া পরের request-এও কাজ করবে)
        $this->setup->saveDbConfig($data);

        // ধাপ ৭: Installed হিসেবে mark করুন
        $this->setup->markAsInstalled();

        return response()->json([
            'success'  => true,
            'redirect' => url('/admin'),
            'message'  => 'ইন্সটলেশন সফল! অ্যাডমিন প্যানেলে স্বাগতম।',
        ]);
    }

    private function alreadyInstalled(): bool
    {
        if (file_exists(storage_path('installed'))) {
            return true;
        }
        try {
            return \App\Models\Admin::count() > 0;
        } catch (\Throwable) {
            return false;
        }
    }
}
