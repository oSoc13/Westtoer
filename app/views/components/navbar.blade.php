
    <div class="navbar navbar-inverse navbar-fixed-top">
        <div class="navbar-inner">
            <div class="container">
                <button type="button" class="btn btn-navbar collapsed" data-toggle="collapse" data-target=".nav-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="brand" href="{{{ URL::to('/') }}}" >oSoc13 Westtoer</a>
                <div class="nav-collapse collapse" style="height: 0px;">
                    <ul class="nav">
                        @if ( strpos(URL::current(), URL::to('/ui')) === 0 )
                        <li class="active">
                        @else
                        <li>
                        @endif
                            <a href="{{{ URL::to('/ui') }}}">Dashboard</a>
                        </li>
                        @if ( strpos(URL::current(), URL::to('/api')) === 0 )
                        <li class="active">
                        @else
                        <li>
                        @endif
                            <a href="{{{ URL::to('/api') }}}">API Help</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    