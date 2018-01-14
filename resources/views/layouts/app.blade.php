<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="login-status" content="{{ Auth::check() }}">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <script>
      var App =  {
        csrfToken: "{{ csrf_token() }}",
        stripeKey: "{{ config('services.stripe.key') }}"
      };
    </script>

    <title>{{ config('app.name', 'Behaviorist Tech') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app" class="container is-fluid">
        <app-navbar></app-navbar>
        <br>
        @yield('content')
    </div>

    <!-- Scripts -->
      <script src="/js/manifest.js"></script>
      <script> var CKEDITOR_BASEPATH = '/js/ckeditor/'; </script>
      <script src="/js/vendor.js"></script>
      <script> CKEDITOR.basePath = '/js/ckeditor/'; </script>
      <script src="/js/app.js"></script>
</body>
</html>
