@layout('layouts.dashboard.home')
@section('newscreen') 
        {{ Form::open(array('url' => '/ui/create/screen', 'method' => 'post')) }}
        <div class="well">
            <h3>
                Create new screen
            </h3>
            <div class="row-fluid">
                <div class="span6">
                    <div class="control-group">
                        <label for="name" class="control-label">
                            <i class="icon-map-marker"></i>
                            Name
                        </label>
                        <div class="controls">
                            <input type="text" id="name" name="name" placeholder="My Screen Name">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="location">
                            <i class="icon-map-marker"></i>
                            Location
                        </label>
                        <div class="controls">
                            <input type="text" id="location" name="location" placeholder="Bruges">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="radius">
                            <i class="icon-repeat"></i>
                            Radius
                        </label>
                        <div class="controls">
                            <input type="text" class="span2" id="radius" name="radius" placeholder="15"> <small>(km)</small>
                        </div>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-inverse">
                Create
            </button>
        </div>
        {{ Form::token() . Form::close() }}
@endsection