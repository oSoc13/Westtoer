@layout('layouts.dashboard.home')
@section('albums')
        <div class="well">
            <div class="ribbon-wrapper-green"><div class="ribbon-green">TODO</div></div>
            <h3>
                Pictures
            </h3>
            {{ Form::open(array('url' => '/ui/picasa/'. $screen_id, 'method' => 'post')) }}
            <div class="control-group">
                <label for="picasa_username" class="control-label">
                    <i class="icon-picture"></i>
                    Picasa Username
                </label>
                <div class="input-append">
                    <input type="text" id="picasa_username" name="picasa_username" placeholder="picasa username">
                    <button type="submit" class="btn">
                        Save and retrieve albums
                    </button>
                </div>
            </div>
            <div class="picasacontent hidden">
                <div class="clearfix">
                    <form class="form-search pull-right">
                        <div class="input-prepend">
                            <button type="submit" class="btn">
                                <i class="icon-search"></i>
                            </button>
                            <input type="search" class="search-query" placeholder="Filter">
                        </div>
                    </form>
                    <a class="btn"><i class="icon-check"></i> select all</a>
                    <a class="btn"><i class="icon-ban-circle"></i> select none</a>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th class="span1">
                                Include
                            </th>
                            <th>
                                Album
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <input type="checkbox" checked>
                            </td>
                            <td>
                                2013 Paasanimatie
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="pagination pagination-centered">
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
            </div>
            {{ Form::token() . Form::close() }}
        </div>
@endsection