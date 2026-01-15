<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>@yield('title', 'TIIMBOOKTU')</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Chango&family=Della+Respira&family=Fredoka+One&family=Playfair+Display:ital@0;1&family=Inter:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('style.css') }}" />
  @stack('styles')
  <meta property="og:image" content="https://bolt.new/static/og_default.png">
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:image" content="https://bolt.new/static/og_default.png">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
  @include('partials.header')
  @yield('content')
  @include('partials.footer')
  <script src="{{ asset('main.js') }}"></script>
  @stack('scripts')
</body>
</html>
