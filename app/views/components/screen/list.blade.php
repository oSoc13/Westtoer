@layout('layouts.dashboard.home')
@section('list')
        <div class="well">
            <h3>
                Content control
            </h3>
            @include('components.tablefilter', array( 'table_id' => 'itemlist') )
            <table class="table" id="itemlist">
                <thead>
                    <tr>
                        <th class="span2">
                            Date <small>(if event)</small>
                        </th>
                        <th>
                            Item
                        </th>
                        <th class="span2">
                            Options
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($events as $event)
                    
                    @if ($event->score == -1)
                    <tr class="error">
                    @elseif ($event->score == -0.5)
                    <tr class="warning">
                    @elseif ($event->score == 1)
                    <tr class="success">
                    @else
                    <tr>
                    @endif
                        <td>
                            @if ($event->startDate == null)
                            Attraction
                            @else
                            {{{ $event->startDate }}}
                            <br>
                            <small>
                                {{{ $event->startTime }}}
                                {{{ $event->endTime }}}
                            </small>
                            @endif
                        </td>
                        <td>
                            {{{ $event->name }}}
                            <br>
                            <small>
                                @if (isset($event->streetAddress))
                                    {{{ $event->streetAddress }}}
                                @endif
                                @if (isset($event->streetAddress) && isset($event->postalCode))
                                    -
                                @endif
                                @if (isset($event->postalCode))
                                    {{{ $event->postalCode }}}
                                @endif
                                @if (isset($event->addressLocality))
                                    {{{ $event->addressLocality }}}
                                @endif
                            </small>
                        </td>
                        <td class="form-actions">
                            

                                {{ Form::open(array('url' => URL::to('/ui/thumbs-up/' . $screen_id . '/'. urlencode ($event->name)), 'method' => 'get', 'style' => 'display:inline;')) }}
                                    <button type="submit" class="btn btn-link" style="display:inline; width:14px; height:20px; padding:0; ">
                                        <i class="icon-thumbs-up"></i>
                                    </button>
                                {{ Form::token() . Form::close() }}
                                {{ Form::open(array('url' => URL::to('/ui/thumbs-down/' . $screen_id . '/'. urlencode ($event->name)), 'method' => 'get', 'style' => 'display:inline;')) }}
                                    <button type="submit" class="btn btn-link" style="display:inline; width:14px; height:20px; padding:0; ">
                                        <i class="icon-thumbs-down"></i>
                                    </button>
                                {{ Form::token() . Form::close() }}

                                {{ Form::open(array('url' => URL::to('/ui/remove/' . $screen_id . '/'. urlencode ($event->name)), 'method' => 'get', 'style' => 'display:inline;')) }}
                                    <button type="submit" class="btn btn-link" style="display:inline; width:14px; height:20px; padding:0; ">
                                        <i class="icon-remove"></i>
                                    </button>
                                {{ Form::token() . Form::close() }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="pagination pagination-centered hidden">
                <ul>
                    <li>
                        <a href="#">Prev</a>
                    </li>
                    <li>
                        <a href="#">1</a>
                    </li>
                    <li>
                        <a href="#">2</a>
                    </li>
                    <li>
                        <a href="#">3</a>
                    </li>
                    <li>
                        <a href="#">Next</a>
                    </li>
                </ul>
            </div>
            <h3>
                Legend
            </h3>
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td>
                            <span class="label label-success"><i class="icon-thumbs-up icon-white"></i> Thumbs up</span>
                        </td>
                        <td>
                            Mark this item as important.
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span class="label label-warning"><i class="icon-thumbs-down icon-white"></i> Thumbs down</span>
                        </td>
                        <td>
                            Mark this item as not/less important.
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span class="label label-important"><i class="icon-remove icon-white"></i> Hide</span>
                        </td>
                        <td>
                            Do not show this item on this screen.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
@endsection