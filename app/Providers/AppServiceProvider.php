<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\DB;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Wizard-এ নির্বাচিত DB config প্রতিটি request-এ পুনরায় apply করুন
        $this->loadSetupDbConfig();

        Blade::directive('formatPrice', function ($expression) {
            return "<?php echo formatPrice($expression); ?>";
        });

        Blade::directive('getLogo', function () {
            return "<?php echo getLogo(); ?>";
        });

        Blade::directive('getFavicon', function () {
            return "<?php echo getFavicon(); ?>";
        });

        Blade::directive('getSiteName', function () {
            return "<?php echo getSiteName(); ?>";
        });
    }

    /**
     * Wizard-এ সেট করা DB config storage/app/setup_db.json থেকে লোড করে।
     * এটি নিশ্চিত করে যে .env restart না করেও wizard-এর পরে সঠিক DB ব্যবহার হয়।
     */
    private function loadSetupDbConfig(): void
    {
        $configFile = storage_path('app/setup_db.json');

        if (!file_exists($configFile)) {
            return;
        }

        try {
            $config = json_decode(file_get_contents($configFile), true);
            if (empty($config['driver'])) {
                return;
            }

            $driver = $config['driver'];
            config(['database.default' => $driver]);

            if ($driver === 'sqlite') {
                config(['database.connections.sqlite.database' => $config['database'] ?? database_path('database.sqlite')]);
            } else {
                config([
                    "database.connections.{$driver}.host"     => $config['host'] ?? '127.0.0.1',
                    "database.connections.{$driver}.port"     => $config['port'] ?? 3306,
                    "database.connections.{$driver}.database" => $config['database'] ?? '',
                    "database.connections.{$driver}.username" => $config['username'] ?? '',
                    "database.connections.{$driver}.password" => $config['password'] ?? '',
                ]);
            }

            DB::purge($driver);
            DB::reconnect($driver);
        } catch (\Throwable) {
            // Config load ব্যর্থ হলে নীরবে ব্যর্থ হোক
        }
    }
}
