@layout('layouts.dashboard.home')
@section('list')
        <div class="well">
            <h3>
                Content control
            </h3>
            <form class="form-search text-right">
                <div class="input-prepend">
                    <button type="submit" class="btn">
                        <i class="icon-search"></i>
                    </button>
                    <input type="search" id="itemlistfilter" class="search-query" placeholder="Filter">
                </div>
            </form>
            <table class="table">
                <thead>
                    <tr>
                        <th class="span2">
                            Date
                        </th>
                        <th>
                            Item
                        </th>
                        <th class="span1">
                            Options
                        </th>
                    </tr>
                </thead>
                <tbody id="itemlist">
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
                            {{{ $event->startDate }}}
                            <br>
                            <small>
                                {{{ $event->startTime }}}
                                {{{ $event->endTime }}}
                            </small>
                        </td>
                        <td>
                            {{{ $event->name }}}
                            <br>
                            <small>
                                {{ $event->addressLocality }}
                            </small>
                        </td>
                        <td>
                            <a href="{{ URL::to('/ui/thumbs-up/' . $screen_id . '/'. urlencode ($event->name)) }}"><i class="icon-thumbs-up"></i></a>
                            <a href="{{ URL::to('/ui/thumbs-down/' . $screen_id . '/'. urlencode ($event->name)) }}"><i class="icon-thumbs-down"></i></a>
                            <a href="{{ URL::to('/ui/remove/' . $screen_id . '/'. urlencode ($event->name)) }}"><i class="icon-remove"></i></a>
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

        <script type="text/javascript">
             $(document).ready(function() {
                  $.expr[':'].containsIgnoreCase = function(n,i,m){
                      return jQuery(n).text().toUpperCase().indexOf(m[3].toUpperCase())>=0;
                  };
              
                  $("#itemlistfilter").keyup(function(){

                      $("#itemlist").find("tr").hide();
                      var data = this.value.split(" ");
                      var jo = $("#itemlist").find("tr");
                      $.each(data, function(i, v){
                           jo = jo.filter("*:containsIgnoreCase('"+v+"')");
                      });

                      jo.show();

                  }).focus(function(){
                      this.value="";
                      $(this).css({"color":"black"});
                      $(this).unbind('focus');
                  }).css({"color":"#C0C0C0"});
              });
        </script>
@endsection