@layout('layouts.dashboard.home')
@section('weather')
        <div class="well">
            <h3>
                Weather settings
            </h3>
            {{ Form::open(array('url' => '/ui/weather/'.$screen_id, 'method' => 'post', 'class' => 'pull-left')) }}
            <div class="control-group hidden">
                <div class="form-horizontal">
                    Show weather every&nbsp;
                    <input type="number" value="8" class="span1">
                    &nbsp;slides.
                </div>
            </div>
            <div class="input-append">
                    <input type="text" id="weather_location" name="weather_location" class="span3" placeholder="location">
                    <button type="submit" class="btn">
                        Add new location
                    </button>
            </div>
            {{ Form::token() . Form::close() }}
            @include('components.tablefilter', array( 'table_id' => 'weatherlocations') )
            <table id="weatherlocations" class="table">
                <thead>
                    <tr>
                        <th>
                            Location
                        </th>
                        <th class="span1">
                            Options
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($locations as $item)
                    <tr>
                        <td>
                            {{{ $item->location }}}
                        </td>
                        <td class="text-center">
                            <a href="{{ URL::to('/ui/weather/' . $screen_id . '/'. $item->id . '/remove') }}"><i class="icon-remove"></i></a>
                            <!--i class="icon-move"></i-->
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
@endsection