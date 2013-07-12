@layout('layouts.master')
@section('breadcrumbs')
    <ul class="breadcrumb">

        
        <li>
            <a href="{{{ URL::to('/') }}}"><i class="icon-home"></i></a>
            <span class="divider">/</span>
        </li>

        @foreach ($bread_items as $breadcrumb)
        <li>
            <a href="{{{ $breadcrumb['uri'] }}}">{{{$breadcrumb['name'] }}}</a>
            <span class="divider">/</span>
        </li>
        @endforeach
        <li class="active">
            {{{ $bread_title }}}
        </li>
    </ul>
@endsection