<?php $ot_array = temp_get_option_tree_informations();?>
<div id="framework_wrap" class="wrap">
	
	<div id="header">
    <h1>ddb_wp</h1>
   			<div class="button_bar" style="width:50%">
					
		</div>  
 	</div>
  
  <div id="content_wrap">
    <form method="post" id="the-theme-options">
      <div class="info top-info">
        <input type="submit" value="<?php _e('Save All Changes','ddb_wp') ?>" class="button-framework button-framework-imp save-options" name="submit"/>
      </div>
      <div class="ajax-message<?php if ( isset( $message ) ) { echo ' show'; } ?>">
        <?php if ( isset( $message ) ) { echo $message; } ?>
      </div>
      <div id="content">
        <div id="options_tabs">
          <ul class="options_tabs">
            <?php 
            foreach ( $ot_array as $value ) 
            { 
              
			  if ( $value->item_type == 'heading' ) 
              {
                echo '<li><a href="#option_'.$value->item_id.'">' . htmlspecialchars_decode( $value->item_title ).'</a><span></span></li>';
              } 
            } 
            ?>
          </ul>
          
            <?php
            // set count        
            $count = 0;
            // loop options & load corresponding function   
            foreach ( $ot_array as $value ) 
            {
              $count++;
			 // echo '<pre>'; print_r($value); die;
              if ( $value->item_type == 'upload' ) 
              {
                $int = $post_id;
              }
              else if ( $value->item_type == 'textarea' )
              {
                $int = ( is_numeric( trim( $value->item_options ) ) ) ? trim( $value->item_options ) : 8;
              }			 
              else
              {
                $int = $count;
              }
			 call_user_func_array( 'DDBWP_option_tree_' . $value->item_type, array( $value, $settings, $int ) );
            }
            // close heading
            echo '</div>';
            ?>
            
          <br class="clear" />
          
        </div>
        
      </div>
      
      <div class="info bottom">
      
        <input type="submit" value="<?php _e('Reset Options','ddb_wp') ?>" class="button-framework reset" name="reset"/>
        <input type="submit" value="<?php _e('Save All Changes','ddb_wp') ?>" class="button-framework save-options button-framework-imp" name="submit"/>
        
      </div>
      
      <?php wp_nonce_field( '_theme_options', '_ajax_nonce', false ); ?>
      
    </form>
    
  </div>

</div>
<!-- [END] framework_wrap -->