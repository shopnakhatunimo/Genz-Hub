<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckInstallation
{
    public function handle(Request $request, Closure $next): Response
    {
        // সবসময় এই পাথগুলো allow করা হবে
        if ($request->is('setup*') || $request->is('up')) {
            // ইতোমধ্যে install থাকলে /setup এ ঢুকতে দেবে না
            if ($this->isInstalled() && !$request->is('setup/complete')) {
                return redirect('/');
            }
            return $next($request);
        }

        // Install চেক
        if (!$this->isInstalled()) {
            return redirect('/setup');
        }

        return $next($request);
    }

    /**
     * অ্যাপ ইন্সটল হয়েছে কিনা চেক করে।
     * ডাটাবেসে admin থাকলে installed ধরা হয়।
     * DB connection না থাকলে false ফেরত দেয়।
     */
    private function isInstalled(): bool
    {
        // Lock file থাকলে সরাসরি installed
        if (file_exists(storage_path('installed'))) {
            return true;
        }

        // DB-তে admin আছে কিনা চেক (redeploy-safe)
        try {
            return \App\Models\Admin::count() > 0;
        } catch (\Throwable $e) {
            return false;
        }
    }
}
