            <form class="form-search text-right pull-right">
                <div class="input-prepend">
                    <button type="submit" class="btn">
                        <i class="icon-search"></i>
                    </button>
                    <input type="search" id="{{{ $table_id }}}filter" class="search-query" placeholder="Filter">
                </div>
            </form>
            <script type="text/javascript">
                 $(document).ready(function() {
                      $.expr[':'].containsIgnoreCase = function(n,i,m){
                          return jQuery(n).text().toUpperCase().indexOf(m[3].toUpperCase())>=0;
                      };
                  
                      $("#{{{ $table_id }}}filter").keyup(function(){

                          $("#{{{ $table_id }}} tbody").find("tr").hide();
                          var data = this.value.split(" ");
                          var jo = $("#{{{ $table_id }}} tbody").find("tr");
                          $.each(data, function(i, v){
                               jo = jo.filter("*:containsIgnoreCase('"+v+"')");
                          });

                          jo.show();

                      }).focus(function(){
                          this.value="";
                          $(this).unbind('focus');
                      });
                  });
            </script>