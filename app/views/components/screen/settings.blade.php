@layout('layouts.dashboard.home')
@section('settings')
        <div class="well">
            <h3>
                Veld &amp; duin settings
            </h3>
            <div class="row-fluid">
                <div class="span6">
                    <div class="control-group">
                        <label class="control-label">
                            <i class="icon-map-marker"></i>
                            Location
                        </label>
                        <div class="controls">
                            <input type="text" placeholder="Bruges">
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
                            <input type="text" class="span2" placeholder="15">
                        </div>
                    </div>
                </div>
                <div class="span6">
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
                </div>
            </div>
        </div>
@endsection