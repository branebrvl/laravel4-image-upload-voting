<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml"
    xmlns:og="http://ogp.me/ns#"
    xmlns:fb="https://www.facebook.com/2008/fbml">
  <head>
    @section('description', 'Render')
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta property="og:title" content="" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="" />
    <meta property="og:image" content="" />
    <meta property="og:site_name" content="" />
    <meta property="og:description" content="@yield('description')" />
    <meta name="description" content="@yield('description')">
    <title>@yield('title') | Render</title>
    <link rel="stylesheet" href="{{ URL::asset('styles/css/index.css') }}">
    @yield('styles')
  </head>

  <body>
    @include('partials.navigation')
    @yield('content')
    @include('partials.footer')

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
    @yield('scripts')
  </body>
</html>
