<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>MyDay</title>
  <link rel="shortcut icon" href="{{ asset('images/brand/myday-logo.png') }}" type="image/x-icon">
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
  <div id="app-wrapper">
    @include('layouts.navbar')

    <main class="antialiased">
      <div class="py-8">
        {{ $slot }}
      </div>
    </main>
  </div>

  @stack('scripts')
</body>

</html>
