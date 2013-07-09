@layout('layouts.dashboard.home')
@section('weather')
        <div class="well">
            <h3>
                Weather settings
            </h3>
            <div class="control-group">
                <div class="controls">
                    Show weather every&nbsp;
                    <input type="number" value="8" class="span1">
                    &nbsp;slides.
                </div>
            </div>
            <div class="control-group">
                <form class="navbar-form form-horizontal">
                    <input type="text" class="span3" placeholder="location">
                    <button type="submit" class="btn">
                        Add new location
                    </button>
                </form>
            </div>
            <table class="table">
                <tbody>
                    <tr>
                        <th>
                            Location
                        </th>
                        <th class="span1">
                            Options
                        </th>
                    </tr>
                    <tr>
                        <td>
                            Brugge
                        </td>
                        <td class="text-center">
                            <i class="icon-remove"></i>
                            <i class="icon-move"></i>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Oostende
                        </td>
                        <td class="text-center">
                            <i class="icon-remove"></i>
                            <i class="icon-move"></i>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Blankenberge
                        </td>
                        <td class="text-center">
                            <i class="icon-remove"></i>
                            <i class="icon-move"></i>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
@endsection