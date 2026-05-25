<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Content-Security-Policy" content="default-src 'self' * data: blob: 'unsafe-inline' 'unsafe-eval'; script-src 'self' 'unsafe-inline' 'unsafe-eval' *; style-src 'self' 'unsafe-inline' *; font-src 'self' data: *; img-src 'self' data: blob: *; frame-src 'self' *; connect-src 'self' * blob: ws: wss:;">

    <title>SnapFit - Indonesian Craft Marketplace</title>
    <link rel="icon" type="image/png" href="/images/logo_snapfit.png">

    <!-- Midtrans Snap JS -->
    <script type="text/javascript"
            src="https://app.{{ config('midtrans.is_production') ? 'midtrans' : 'sandbox.midtrans' }}.com/snap/snap.js"
            data-client-key="{{ config('midtrans.client_key') }}"></script>

    <!-- Google Model Viewer for 3D Crafts -->
    <script type="module" src="https://ajax.googleapis.com/ajax/libs/model-viewer/4.0.0/model-viewer.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div id="app"></div>
</body>
</html>