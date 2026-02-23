<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'NepSole - Nepali Footwear')</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: #fff;
            color: #111827;
        }
    </style>
    @stack('styles')
</head>
<body>
    @include('components.navbar')
    
    @yield('content')
    
    @include('components.footer')
    
    @stack('scripts')
</body>
</html>
