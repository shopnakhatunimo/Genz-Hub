<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Order;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = auth()->user();
        $orders = Order::where('user_id', $user->id)->latest()->take(5)->get();
        return view('frontend.account.index', compact('user', 'orders'));
    }

    public function profile()
    {
        $user = auth()->user();
        return view('frontend.account.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . auth()->id(),
            'phone' => 'nullable|string|max:20',
        ]);

        auth()->user()->update($request->only('name', 'email', 'phone'));

        return redirect()->back()->with('success', 'প্রোফাইল আপডেট করা হয়েছে।');
    }

    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('avatar')) {
            $image = $request->file('avatar');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/users'), $imageName);
            
            auth()->user()->update(['avatar' => $imageName]);
        }

        return redirect()->back()->with('success', 'প্রোফাইল ছবি আপডেট করা হয়েছে।');
    }

    public function password()
    {
        return view('frontend.account.password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if (!Hash::check($request->current_password, auth()->user()->password)) {
            return redirect()->back()->with('error', 'বর্তমান পাসওয়ার্ড সঠিক নয়।');
        }

        auth()->user()->update(['password' => Hash::make($request->password)]);

        return redirect()->back()->with('success', 'পাসওয়ার্ড পরিবর্তন করা হয়েছে।');
    }

    public function orders()
    {
        $orders = Order::where('user_id', auth()->id())->latest()->paginate(10);
        return view('frontend.account.orders', compact('orders'));
    }

    public function orderShow($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)
            ->where('user_id', auth()->id())
            ->with('items')
            ->firstOrFail();

        return view('frontend.account.order-show', compact('order'));
    }

    public function wishlist()
    {
        $wishlist = Wishlist::where('user_id', auth()->id())
            ->with('product.primaryImage')
            ->latest()
            ->paginate(20);

        return view('frontend.account.wishlist', compact('wishlist'));
    }

    // Standalone wishlist page (resources/views/frontend/wishlist/index.blade.php)
    public function wishlistPage()
    {
        $wishlists = Wishlist::where('user_id', auth()->id())
            ->with('product.images')
            ->latest()
            ->get();

        return view('frontend.wishlist.index', compact('wishlists'));
    }

    public function wishlistAdd(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $exists = Wishlist::where('user_id', auth()->id())
            ->where('product_id', $request->product_id)
            ->exists();

        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'পণ্যটি ইতিমধ্যেই উইশলিস্টে আছে।'
            ]);
        }

        Wishlist::create([
            'user_id' => auth()->id(),
            'product_id' => $request->product_id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'পণ্যটি উইশলিস্টে যোগ করা হয়েছে।'
        ]);
    }

    public function wishlistRemove(Request $request)
    {
        if ($request->product_id) {
            Wishlist::where('product_id', $request->product_id)->where('user_id', auth()->id())->delete();
        } else {
            Wishlist::where('id', $request->id)->where('user_id', auth()->id())->delete();
        }

        return redirect()->back()->with('success', 'পণ্যটি উইশলিস্ট থেকে সরানো হয়েছে।');
    }

    public function addresses()
    {
        $addresses = Address::where('user_id', auth()->id())->get();
        return view('frontend.account.addresses', compact('addresses'));
    }

    public function addressStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'city' => 'required|string|max:100',
            'area' => 'required|string|max:100',
            'landmark' => 'nullable|string|max:100',
            'is_default' => 'nullable|boolean',
        ]);

        Address::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'city' => $request->city,
            'area' => $request->area,
            'landmark' => $request->landmark,
            'is_default' => $request->is_default ?? false,
        ]);

        return redirect()->back()->with('success', 'ঠিকানা যোগ করা হয়েছে।');
    }

    public function addressUpdate(Request $request, $id)
    {
        $address = Address::where('id', $id)->where('user_id', auth()->id())->firstOrFail();

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'city' => 'required|string|max:100',
            'area' => 'required|string|max:100',
            'landmark' => 'nullable|string|max:100',
            'is_default' => 'nullable|boolean',
        ]);

        $address->update($request->all());

        return redirect()->back()->with('success', 'ঠিকানা আপডেট করা হয়েছে।');
    }

    public function addressDelete($id)
    {
        Address::where('id', $id)->where('user_id', auth()->id())->delete();

        return redirect()->back()->with('success', 'ঠিকানা মুছে ফেলা হয়েছে।');
    }
}
