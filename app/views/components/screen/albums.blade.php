@layout('layouts.dashboard.home')
@section('albums')
        <div class="well">
            <h3>
                Pictures
            </h3>
            <a class="btn btn-primary">Link Picasa to my account!</a>
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
                <tbody>
                    <tr>
                        <th class="span1">
                            Include
                        </th>
                        <th>
                            Album
                        </th>
                    </tr>
                    <tr>
                        <td>
                            <input type="checkbox" checked>
                        </td>
                        <td>
                            2013 Paasanimatie
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="checkbox" >
                        </td>
                        <td>
                            2012 Spelletjesvoormiddag
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="checkbox">
                        </td>
                        <td>
                            2012 Tafelvoetbaltornooi
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="checkbox" checked>
                        </td>
                        <td>
                            2012 Waterglijbaan
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
@endsection