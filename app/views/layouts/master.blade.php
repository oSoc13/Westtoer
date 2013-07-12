<!DOCTYPE html>
<html lang="en">
  <head>
    @yield('head')
  </head>
  <body>
    @yield('navbar')
    <div class="container">
        @yield('breadcrumbs')
        @yield('messages')
        @yield('content')
    </div>
    <!--style>
      
      /* To push content below navbar */
      @media (min-width: 980px) {
        body {
          margin-top: 41px;
        }
      }
      
    </style-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js">
    </script>
    <script src="/assets/js/bootstrap.js">
    </script>
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
  </body>
</html>
