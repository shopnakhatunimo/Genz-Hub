<?php

namespace App\Services;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;

class SetupService
{
    /**
     * Write or update .env file with provided values.
     */
    public function writeEnv(array $data): bool
    {
        $envPath = base_path('.env');
        $envExample = base_path('.env.example');

        // Current .env বা .env.example থেকে শুরু
        $content = file_exists($envPath)
            ? file_get_contents($envPath)
            : (file_exists($envExample) ? file_get_contents($envExample) : '');

        $driver = $data['db_connection'] ?? 'sqlite';

        $replacements = [
            'APP_NAME'          => '"' . ($data['app_name'] ?? 'E-Commerce') . '"',
            'APP_ENV'           => 'production',
            'APP_DEBUG'         => 'false',
            'APP_URL'           => rtrim($data['app_url'] ?? url('/'), '/'),
            'APP_KEY'           => $data['app_key'] ?? $this->generateKey(),
            'DB_CONNECTION'     => $driver,
            'SESSION_DRIVER'    => 'file',
            'CACHE_STORE'       => 'file',
            'QUEUE_CONNECTION'  => 'database',
            'MAIL_MAILER'       => 'smtp',
            'MAIL_HOST'         => $data['mail_host'] ?? 'smtp.gmail.com',
            'MAIL_PORT'         => $data['mail_port'] ?? '587',
            'MAIL_ENCRYPTION'   => $data['mail_encryption'] ?? 'tls',
            'MAIL_USERNAME'     => $data['mail_username'] ?? '',
            'MAIL_PASSWORD'     => $data['mail_password'] ?? '',
            'MAIL_FROM_ADDRESS' => $data['mail_from_address'] ?? ($data['mail_username'] ?? ''),
            'MAIL_FROM_NAME'    => '"' . ($data['app_name'] ?? 'E-Commerce') . '"',
        ];

        // DB specific fields
        if ($driver === 'sqlite') {
            $dbPath = database_path('database.sqlite');
            $replacements['DB_DATABASE'] = $dbPath;
        } else {
            $replacements['DB_HOST']     = $data['db_host'] ?? '127.0.0.1';
            $replacements['DB_PORT']     = $data['db_port'] ?? ($driver === 'pgsql' ? '5432' : '3306');
            $replacements['DB_DATABASE'] = $data['db_database'] ?? '';
            $replacements['DB_USERNAME'] = $data['db_username'] ?? '';
            $replacements['DB_PASSWORD'] = $data['db_password'] ?? '';
        }

        foreach ($replacements as $key => $value) {
            if (preg_match("/^{$key}=.*/m", $content)) {
                $content = preg_replace("/^{$key}=.*/m", "{$key}={$value}", $content);
            } else {
                $content .= "\n{$key}={$value}";
            }
        }

        return file_put_contents($envPath, $content) !== false;
    }

    /**
     * Test database connection with given credentials.
     */
    public function testDbConnection(array $data): array
    {
        try {
            $driver = $data['db_connection'] ?? 'mysql';

            if ($driver === 'sqlite') {
                $path = database_path('database.sqlite');
                if (!file_exists($path)) {
                    touch($path);
                }
                new \PDO("sqlite:{$path}");
                return ['success' => true];
            }

            $dsn = match ($driver) {
                'mysql'  => "mysql:host={$data['db_host']};port={$data['db_port']};dbname={$data['db_database']}",
                'pgsql'  => "pgsql:host={$data['db_host']};port={$data['db_port']};dbname={$data['db_database']}",
                default  => throw new \Exception('অসমর্থিত ডাটাবেস ড্রাইভার।'),
            };

            new \PDO($dsn, $data['db_username'], $data['db_password'], [
                \PDO::ATTR_TIMEOUT => 5,
            ]);

            return ['success' => true];
        } catch (\Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * Reconfigure database connection dynamically in current request.
     */
    public function reconfigureDatabase(array $data): void
    {
        $driver = $data['db_connection'] ?? 'sqlite';

        if ($driver === 'sqlite') {
            $dbPath = database_path('database.sqlite');
            if (!file_exists($dbPath)) {
                touch($dbPath);
            }
            config([
                'database.default'                       => 'sqlite',
                'database.connections.sqlite.database'   => $dbPath,
            ]);
        } else {
            config([
                'database.default'                              => $driver,
                "database.connections.{$driver}.host"          => $data['db_host'] ?? '127.0.0.1',
                "database.connections.{$driver}.port"          => $data['db_port'] ?? ($driver === 'pgsql' ? '5432' : '3306'),
                "database.connections.{$driver}.database"      => $data['db_database'] ?? '',
                "database.connections.{$driver}.username"      => $data['db_username'] ?? '',
                "database.connections.{$driver}.password"      => $data['db_password'] ?? '',
            ]);
        }

        \DB::purge($driver);
        \DB::reconnect($driver);
    }

    /**
     * Run migrations and seed default data.
     */
    public function runMigrations(): bool
    {
        try {
            Artisan::call('migrate', ['--force' => true]);
            Artisan::call('db:seed', ['--force' => true]);
            return true;
        } catch (\Exception $e) {
            \Log::error('Migration failed: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Create the admin user.
     */
    public function createAdmin(array $data): bool
    {
        try {
            \App\Models\Admin::updateOrCreate(
                ['email' => $data['email']],
                [
                    'name'     => $data['name'],
                    'email'    => $data['email'],
                    'password' => Hash::make($data['password']),
                    'status'   => true,
                ]
            );
            return true;
        } catch (\Exception $e) {
            \Log::error('Admin creation failed: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Save site settings to DB.
     */
    public function saveSiteSettings(array $data): void
    {
        $settings = [
            'site_name'  => $data['app_name'] ?? 'E-Commerce',
            'site_url'   => $data['app_url'] ?? url('/'),
            'currency'   => $data['currency'] ?? '৳',
        ];

        foreach ($settings as $key => $value) {
            try {
                \App\Models\Setting::set($key, $value, 'general');
            } catch (\Exception $e) {
                // ignore
            }
        }
    }

    /**
     * Save SMTP settings to DB.
     */
    public function saveSmtpSettings(array $data): void
    {
        if (empty($data['mail_host'])) {
            return;
        }

        try {
            \App\Models\SmtpSetting::updateOrCreate(
                ['id' => 1],
                [
                    'mailer'       => 'smtp',
                    'host'         => $data['mail_host'] ?? 'smtp.gmail.com',
                    'port'         => $data['mail_port'] ?? '587',
                    'username'     => $data['mail_username'] ?? '',
                    'password'     => $data['mail_password'] ?? '',
                    'encryption'   => $data['mail_encryption'] ?? 'tls',
                    'from_address' => $data['mail_from_address'] ?? $data['mail_username'] ?? '',
                    'from_name'    => $data['app_name'] ?? 'E-Commerce',
                    'status'       => true,
                ]
            );
        } catch (\Exception $e) {
            \Log::error('SMTP settings save failed: ' . $e->getMessage());
        }
    }

    /**
     * Mark the app as installed (lock file + DB flag).
     */
    public function markAsInstalled(): void
    {
        // Lock file (local hosting-এর জন্য)
        $lockDir = storage_path();
        if (is_writable($lockDir)) {
            file_put_contents(storage_path('installed'), date('Y-m-d H:i:s'));
        }

        // DB-তে installed marker (Render/cloud-এর জন্য redeploy-safe)
        try {
            \App\Models\Setting::set('app_installed', '1', 'system');
            \App\Models\Setting::set('installed_at', now()->toDateTimeString(), 'system');
        } catch (\Exception $e) {
            // ignore
        }
    }

    /**
     * DB config storage/app/setup_db.json-এ সেভ করে।
     * AppServiceProvider প্রতিটি request-এ এটি লোড করে।
     * এটি নিশ্চিত করে যে .env-এর পরিবর্তন restart ছাড়াই কার্যকর হয়।
     */
    public function saveDbConfig(array $data): void
    {
        $driver = $data['db_connection'] ?? 'sqlite';

        $config = ['driver' => $driver];

        if ($driver === 'sqlite') {
            $config['database'] = database_path('database.sqlite');
        } else {
            $config['host']     = $data['db_host'] ?? '127.0.0.1';
            $config['port']     = $data['db_port'] ?? ($driver === 'pgsql' ? 5432 : 3306);
            $config['database'] = $data['db_database'] ?? '';
            $config['username'] = $data['db_username'] ?? '';
            $config['password'] = $data['db_password'] ?? '';
        }

        $dir = storage_path('app');
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        file_put_contents(
            storage_path('app/setup_db.json'),
            json_encode($config, JSON_PRETTY_PRINT)
        );
    }

    /**
     * Generate a new Laravel APP_KEY.
     */
    public function generateKey(): string
    {
        return 'base64:' . base64_encode(random_bytes(32));
    }

    /**
     * Check system requirements.
     */
    public function checkRequirements(): array
    {
        $checks = [
            ['label' => 'PHP >= 8.2',               'pass' => version_compare(PHP_VERSION, '8.2.0', '>='), 'value' => PHP_VERSION],
            ['label' => 'OpenSSL Extension',         'pass' => extension_loaded('openssl'),    'value' => extension_loaded('openssl') ? 'চালু' : 'বন্ধ'],
            ['label' => 'PDO Extension',             'pass' => extension_loaded('pdo'),        'value' => extension_loaded('pdo') ? 'চালু' : 'বন্ধ'],
            ['label' => 'Mbstring Extension',        'pass' => extension_loaded('mbstring'),   'value' => extension_loaded('mbstring') ? 'চালু' : 'বন্ধ'],
            ['label' => 'Tokenizer Extension',       'pass' => extension_loaded('tokenizer'),  'value' => extension_loaded('tokenizer') ? 'চালু' : 'বন্ধ'],
            ['label' => 'JSON Extension',            'pass' => extension_loaded('json'),       'value' => extension_loaded('json') ? 'চালু' : 'বন্ধ'],
            ['label' => 'Ctype Extension',           'pass' => extension_loaded('ctype'),      'value' => extension_loaded('ctype') ? 'চালু' : 'বন্ধ'],
            ['label' => 'storage/ লেখার অনুমতি',   'pass' => is_writable(storage_path()),    'value' => is_writable(storage_path()) ? 'আছে' : 'নেই'],
            ['label' => '.env লেখার অনুমতি',        'pass' => is_writable(base_path('.env')) || is_writable(base_path()), 'value' => (is_writable(base_path('.env')) || is_writable(base_path())) ? 'আছে' : 'নেই'],
        ];

        $allPassed = collect($checks)->every(fn($c) => $c['pass']);

        return ['checks' => $checks, 'allPassed' => $allPassed];
    }
}
