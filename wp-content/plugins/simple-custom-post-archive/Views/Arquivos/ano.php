<?php $this_ano = substr($agenda[post_date],0,4); $check_ano = true;?>
            <h3 class="ano" id="<?php echo $this_ano;?>"><?php echo $this_ano;?></h3>
            <div id="container-<?php echo $this_ano;?>">
            <script>
                jQuery(function($){
                      var bol = true;
                        $("#<?php echo $this_ano;?>").click(function() {                            
                            if(bol){
                                  $("#container-<?php echo $this_ano;?>").show("slow");
                                  bol = false;
                            }else{
                                  $("#container-<?php echo $this_ano;?>").hide("slow");
                                  bol = true;
                            }
                        });
                });
            </script>