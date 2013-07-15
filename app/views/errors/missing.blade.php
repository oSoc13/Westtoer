<!DOCTYPE html>
<html lang="en">
    <head>
        @include('components.head')
    </head>
    <body>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <script src="{{ URL::asset('/assets/js/bootstrap.js') }}"></script>
    @include('components.navbar')
    <div class="container text-center">
        <h1>{{ $exception->getMessage() }}</h1>
        <p>
            <a href="javascript:history.go(-1)"><i class="icon-arrow-left"></i> Go back</a>
        </p>

        <p>
            <a href="javascript:history.go(-1)">
                <img src="{{ URL::asset('/assets/img/404.png') }}" >
            </a>
        </p>
        

        <p>
            <a href="javascript:history.go(-1)"><i class="icon-arrow-left"></i> Go back</a>
        </p>
        <hr>
        
        <footer>
            <p class="pull-right"><a href="#">Back to top</a></p>
            <p><a href="http://summerofcode.be">#oSoc13</a></p>
        </footer>
    </div>
    </body>
</html>
