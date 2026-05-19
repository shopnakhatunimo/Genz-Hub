<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function show($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)
            ->with('items.product')
            ->firstOrFail();

        if (auth()->check() && $order->user_id !== auth()->id()) {
            abort(403);
        }

        return view('frontend.orders.show', compact('order'));
    }

    public function track($orderNumber, Request $request)
    {
        $order = Order::where('order_number', $orderNumber)
            ->with('items')
            ->first();

        if (!$order) {
            return redirect()->back()->with('error', 'অর্ডার পাওয়া যায়নি।');
        }

        return view('frontend.orders.track', compact('order'));
    }
}
