<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Banner;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $totalOrders = Order::count();
        $totalProducts = Product::count();
        $totalUsers = User::count();
        $totalRevenue = Order::where('payment_status', 'paid')->sum('total');

        $recentOrders = Order::latest()->take(10)->get();
        $topProducts = Product::orderBy('sold_count', 'desc')->take(5)->get();
        $activeBanners = Banner::where('status', true)->count();

        // Monthly sales data (compatible with MySQL and PostgreSQL)
        $dbDriver = config('database.default');
        if ($dbDriver === 'pgsql') {
            $monthlySales = Order::selectRaw("EXTRACT(MONTH FROM created_at) as month, SUM(total) as total")
                ->whereRaw("EXTRACT(YEAR FROM created_at) = ?", [date('Y')])
                ->where('payment_status', 'paid')
                ->groupBy('month')
                ->orderBy('month')
                ->get();
        } else {
            $monthlySales = Order::selectRaw('MONTH(created_at) as month, SUM(total) as total')
                ->whereYear('created_at', date('Y'))
                ->where('payment_status', 'paid')
                ->groupBy('month')
                ->orderBy('month')
                ->get();
        }

        return view('admin.dashboard.index', compact(
            'totalOrders',
            'totalProducts',
            'totalUsers',
            'totalRevenue',
            'recentOrders',
            'topProducts',
            'activeBanners',
            'monthlySales'
        ));
    }
}
