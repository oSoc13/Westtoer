<!DOCTYPE html>
<html lang="en">
  <head>
    @yield('head')
  </head>
  <body>
    @yield('navbar')
    <div class="container">
        @yield('breadcrumbs')
        @yield('messages')
        @yield('content')
    </div>
    <!--style>
      
      /* To push content below navbar */
      @media (min-width: 980px) {
        body {
          margin-top: 41px;
        }
      }
      
    </style-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js">
    </script>
    <script src="/assets/js/bootstrap.js">
    </script>
    <script>

    </script>
  </body>
</html>
