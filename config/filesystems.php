<?php

return [

    'default' => env('FILESYSTEM_DISK', 'local'),

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
            'throw' => false,
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
            'throw' => false,
        ],

        'products' => [
            'driver' => 'local',
            'root' => public_path('uploads/products'),
            'url' => env('APP_URL').'/uploads/products',
            'visibility' => 'public',
        ],

        'categories' => [
            'driver' => 'local',
            'root' => public_path('uploads/categories'),
            'url' => env('APP_URL').'/uploads/categories',
            'visibility' => 'public',
        ],

        'banners' => [
            'driver' => 'local',
            'root' => public_path('uploads/banners'),
            'url' => env('APP_URL').'/uploads/banners',
            'visibility' => 'public',
        ],

        'users' => [
            'driver' => 'local',
            'root' => public_path('uploads/users'),
            'url' => env('APP_URL').'/uploads/users',
            'visibility' => 'public',
        ],

    ],

];
