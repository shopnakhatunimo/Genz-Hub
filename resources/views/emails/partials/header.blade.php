<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, 'Noto Sans Bengali', sans-serif; background: #f5f5f5; color: #333; }
        .wrapper { max-width: 600px; margin: 30px auto; background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 12px rgba(0,0,0,.08); }
        .header { background: #1a73e8; padding: 28px 32px; text-align: center; }
        .header img { height: 45px; }
        .header h1 { color: #fff; font-size: 22px; margin-top: 10px; }
        .body { padding: 32px; }
        .body p { font-size: 15px; line-height: 1.8; margin-bottom: 14px; color: #555; }
        .btn { display: inline-block; background: #1a73e8; color: #fff !important; padding: 12px 28px; border-radius: 8px; text-decoration: none; font-size: 15px; margin: 16px 0; }
        .order-table { width: 100%; border-collapse: collapse; margin: 18px 0; }
        .order-table th, .order-table td { border: 1px solid #eee; padding: 10px 14px; font-size: 14px; text-align: left; }
        .order-table th { background: #f8fafc; color: #444; font-weight: 600; }
        .total-row td { font-weight: bold; background: #f0f7ff; }
        .footer { background: #f8fafc; padding: 20px 32px; text-align: center; border-top: 1px solid #eee; }
        .footer p { font-size: 13px; color: #888; }
        .footer a { color: #1a73e8; text-decoration: none; }
        .status-badge { display: inline-block; padding: 4px 12px; border-radius: 20px; font-size: 13px; font-weight: 600; }
        .status-pending    { background: #fff3cd; color: #856404; }
        .status-processing { background: #cce5ff; color: #004085; }
        .status-shipped    { background: #d4edda; color: #155724; }
        .status-delivered  { background: #d1e7dd; color: #0f5132; }
        .status-cancelled  { background: #f8d7da; color: #842029; }
    </style>
</head>
<body>
<div class="wrapper">
    <div class="header">
        <h1>{{ getSiteName() }}</h1>
    </div>
    <div class="body">
