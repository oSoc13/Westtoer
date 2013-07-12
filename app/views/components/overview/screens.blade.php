@layout('layouts.dashboard.home')
@section('screens')
        <div class="well">
            <h3>
                Screen overview
            </h3>
            <form class="form-search text-right">
                <div class="input-prepend">
                    <button type="submit" class="btn">
                        <i class="icon-search"></i>
                    </button>
                    <input type="search" id="screenfilter" class="search-query" placeholder="Filter">
                </div>
            </form>
            <table class="table">
                <tbody id="screenlist">
                    <tr>
                        <th class="span1">
                            ID
                        </th>
                        <th>
                            Name
                        </th>
                        <th class="span1">
                            Location
                        </th>
                    </tr>
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

        <script type="text/javascript">
            /*var $rows = $('#screenlist tr');
            $('#screenfilter').keyup(function() {
                var val = jQuery.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();

                $rows.show().filter(function() {
                    var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
                    return !~text.indexOf(val);
                }).hide();
            });
            */
             $(document).ready(function() {
             //Declare the custom selector 'containsIgnoreCase'.
                  $.expr[':'].containsIgnoreCase = function(n,i,m){
                      return jQuery(n).text().toUpperCase().indexOf(m[3].toUpperCase())>=0;
                  };
              
                  $("#screenfilter").keyup(function(){

                      $("#screenlist").find("tr").hide();
                      var data = this.value.split(" ");
                      var jo = $("#screenlist").find("tr");
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