@layout('layouts.master')
@section('navbar')
    <div class="navbar navbar-inverse navbar-fixed-top">
        <div class="navbar-inner">
            <div class="container">
                <button type="button" class="btn btn-navbar collapsed" data-toggle="collapse" data-target=".nav-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="brand" href="{{{ URL::to('/ui/') }}}">oSoc13 Westtoer</a>
                <div class="nav-collapse collapse" style="height: 0px;">
                    <ul class="nav">
                        <li class="active">
                            <a href="/ui">Dashboard</a>
                        </li>
                        <li>
                            <a href="/api">API Help</a>
                        </li>
                    </ul>
                </div>
                <!--/.nav-collapse -->
            </div>
        </div>
    </div>
@endsection