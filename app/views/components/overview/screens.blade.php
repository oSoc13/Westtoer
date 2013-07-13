@layout('layouts.dashboard.home')
@section('screens')
        <div class="well">
            <h3>
                Screen overview
            </h3>
            @include('components.tablefilter', array( 'table_id' => 'screenlist') )
            <table class="table" id="screenlist">
                <thead>
                    <tr>
                        <th class="span1">
                            ID
                        </th>
                        <th>
                            Name
                        </th>
                        <th class="span2">
                            Location
                            <br>
                            <small>
                                (radius)
                            </small>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($screens as $screen)
                    <tr>
                        <td>
                            {{{ $screen->id }}}
                        </td>
                        <td>
                            <a href="{{{ URL::to('/ui/screen/' . $screen->id) }}}">{{{ $screen->name }}}</a>
                        </td>
                        <td>
                            {{{ $screen->location }}}
                            <br>
                            <small>
                                {{{ $screen->radius }}}
                            </small>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
@endsection