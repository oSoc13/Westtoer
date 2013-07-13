<!DOCTYPE html>
<html lang="en">
  <head>
    @yield('head')
  </head>
  <body>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <script src="{{ URL::asset('/assets/js/bootstrap.js') }}"></script>
    @yield('navbar')
    <div class="container">
        @yield('breadcrumbs')
        @yield('messages')
        @yield('content')
    </div>
  </body>
</html>
