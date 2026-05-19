@extends('layouts.admin.app')

@section('title', 'ব্যবহারকারীসমূহ')
@section('header', 'ব্যবহারকারীসমূহ')

@section('content')
@if(session('success'))
<div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">{{ session('success') }}</div>
@endif

<div class="mb-4">
    <form method="GET" class="flex gap-4">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="নাম বা ইমেইল খুঁজুন..." class="input-field max-w-xs">
        <select name="status" class="input-field max-w-xs">
            <option value="">সব স্ট্যাটাস</option>
            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>সক্রিয়</option>
            <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>নিষ্ক্রিয়</option>
            <option value="blocked" {{ request('status') === 'blocked' ? 'selected' : '' }}>ব্লক</option>
        </select>
        <button type="submit" class="btn-primary">ফিল্টার</button>
    </form>
</div>

<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ব্যবহারকারী</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ফোন</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">স্ট্যাটাস</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">যোগদান</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">অ্যাকশন</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($users as $user)
            <tr>
                <td class="px-6 py-4">
                    <p class="font-medium">{{ $user->name }}</p>
                    <p class="text-sm text-gray-500">{{ $user->email }}</p>
                </td>
                <td class="px-6 py-4 text-gray-600">{{ $user->phone ?? '-' }}</td>
                <td class="px-6 py-4">
                    <span class="px-2 py-1 text-xs rounded {{ $user->status === 'active' ? 'bg-green-100 text-green-800' : ($user->status === 'blocked' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                        {{ $user->status === 'active' ? 'সক্রিয়' : ($user->status === 'blocked' ? 'ব্লক' : 'নিষ্ক্রিয়') }}
                    </span>
                </td>
                <td class="px-6 py-4 text-gray-600">{{ $user->created_at->format('d M Y') }}</td>
                <td class="px-6 py-4">
                    <div class="flex space-x-2">
                        <a href="{{ route('admin.users.show', $user->id) }}" class="text-blue-600 hover:text-blue-800 text-sm">দেখুন</a>
                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800 text-sm" onclick="return confirm('মুছে ফেলবেন?')">মুছুন</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="px-6 py-8 text-center text-gray-500">কোনো ব্যবহারকারী নেই</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-4">{{ $users->links() }}</div>
</div>
@endsection
