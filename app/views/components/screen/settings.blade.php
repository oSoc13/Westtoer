@layout('layouts.dashboard.home')
@section('settings') 
        {{ Form::open(array('url' => '/ui/screen/'. $screen_id, 'method' => 'post')) }}
        <input type="hidden" name="screen_id" value="{{{ $screen_id }}}">
        <div class="well">
            <h3>
                {{{ $name }}} settings
            </h3>
            <div class="row-fluid">
                <div class="span6">
                    <div class="control-group">
                        <label class="control-label">
                            <i class="icon-map-marker"></i>
                            Location
                        </label>
                        <div class="controls">
                            <input type="text" name="location" placeholder="Bruges" value="{{{ $location }}}">
                        </div>
                    </div>
                    <p>
                    </p>
                    <div class="control-group">
                        <label class="control-label">
                            <i class="icon-repeat"></i>
                            Radius
                        </label>
                        <div class="controls">
                            <input type="text" class="span2" name="radius" placeholder="15" value="{{{ $radius }}}">
                        </div>
                    </div>
                </div>
                <!--div class="span6">
                    <div class="control-group">
                        <label class="control-label">
                            <i class="icon-list-alt"></i>
                            Type of content
                        </label>
                        <div class="controls">
                            <select>
                                <option value="events">
                                    Events
                                </option>
                                <option value="attractions">
                                    Attractions
                                </option>
                                <option value="eventsattractions">
                                    Events &amp; Attractions
                                </option>
                            </select>
                        </div>
                    </div>
                </div-->
            </div>

            <button type="submit" class="btn btn-inverse">
                Save settings
            </button>
        </div>
        {{ Form::token() . Form::close() }}
@endsection