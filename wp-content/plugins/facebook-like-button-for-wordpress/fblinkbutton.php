<?php
/*
Plugin Name: Facebook Like Button For Wordpress
Plugin URI: http://willfults.com/facebook-like-wordpres/
Description: Adds a button which lets users "Like" a page
Version: 1.0.2
Author: willfults
Author URI: http://willfults.com
*/

function fblike_options() {
	add_menu_page('FB Like Button', 'FB Like Button', 8, basename(__FILE__), 'fblike_options_page');
	add_submenu_page(basename(__FILE__), 'Settings', 'Settings', 8, basename(__FILE__), 'fblike_options_page');
    
}

/**
* Build up all the params for the button
*/
function fblike_build_options() {
	// get the post varibale (should be in the loop)
	global $post;
	// get the permalink
    if (get_post_status($post->ID) == 'publish') {
        $url = get_permalink();
    }
    $button =  urlencode($url);
/*
	// now build up the params, start with the source
    if (get_option('fblike_source')) {
        $button .= '&amp;source=' . urlencode(get_option('fblike_source'));
    }
*/
	// show faces
if (get_option('fblike_layout') == 'count') {
 	$button .= '&amp;layout=button_count';
} else {
	$button .= '&amp;layout=standard';
}		
	
	
    if (get_option('fblike_faces') == 'true') {
        $button .= '&amp;show-faces=true';
    } else {
		$button .= '&amp;show-faces=false';
	}

if (get_option('fblike_text') == 'like') {
 $button .= '&amp;width=450&amp;action=like';
} else {
	$button .= '&amp;width=450&amp;action=recommend';
}		
/*
if (get_option('fblike_font') == 'like') {
  $button .= '&amp;font=verdana';
} else {
	$button .= '&amp;font=verdana';
}	
	*/

if (get_option('fblike_color') == 'light') {
 $button .= '&amp;colorscheme=light';
} else {
	$button .= '&amp;colorscheme=dark';
}


	// return all the params
	return $button;
}

/**
* Generate the iFrame render of the button
*/
function fblike_generate_button() {
	// build up the outer style
    $button = '<div class="fblikebutton_button" style="' . get_option('fblike_style') . '">';
$button .= '<iframe src="http://www.facebook.com/plugins/like.php?href=' . fblike_build_options() . '" scrolling="no" frameborder="0" allowTransparency="true" style="border:none; overflow:hidden; width:450px; height:26px"></iframe>';
	$button .= '</div>';
	// return the iframe code
    return $button;
}

/**
* Generates the image button
*/
function fblike_generate_static_button() {
	if (get_post_status($post->ID) == 'publish') {
        $url = get_permalink();
		return
		'<div class="fblikebutton_button" style="' . get_option('fblike_style') . '">
			<iframe src="http://www.facebook.com/plugins/like.php?href=' . fblike_build_options() . '" scrolling="no" frameborder="0" allowTransparency="true" style="border:none; overflow:hidden; width:450px; height:26px"></iframe>
		</div>';
	} else {
		return;
	}
}

/**
* Gets run when the content is loaded in the loop
*/
function fblike_update($content) {

    global $post;

    // add the manual option
    if (get_option('fblike_where') == 'manual') {
        return $content;
	}
    // is it a page
    if (get_option('fblike_display_page') == null && is_page()) {
        return $content;
    }
	// are we on the front page
    if (get_option('fblike_display_front') == null && is_home()) {
        return $content;
    }
	// are we in a feed
    if (is_feed()) {
		$button = fblike_generate_static_button();
		$where = 'fblike_rss_where';
    } else {
		$button = fblike_generate_button();
		$where = 'fblike_where';
	}
	// are we displaying in a feed
	if (is_feed() && get_option('fblike_display_rss') == null) {
		return $content;
	}

	// are we just using the shortcode
	if (get_option($where) == 'shortcode') {
		return str_replace('[fblikebutton]', $button, $content);
	} else {
		// if we have switched the button off
		if (get_post_meta($post->ID, 'fblikebutton') == null) {
			if (get_option($where) == 'beforeandafter') {
				// adding it before and after
				return $button . $content . $button;
			} else if (get_option($where) == 'before') {
				// just before
				return $button . $content;
			} else {
				// just after
				return $content . $button;
			}
		} else {
			// not at all
			return $content;
		}
	}
}

// Manual output
function fblikebutton() {
    if (get_option('fblike_where') == 'manual') {
        return fblike_generate_button();
    } else {
        return false;
    }
}

// Remove the filter excerpts
function fblike_remove_filter($content) {
	if (!is_feed()) {
    	remove_action('the_content', 'fblike_update');
	}
    return $content;
}



function fblike_options_page() {
?>
    <div class="wrap">
    <div class="icon32" id="icon-options-general"><br/></div><h2>Configurações de Integração Facebook botão 'Like'</h2>
    <p>Este plugin irá instalar o Facebook como botão em cada um dos seus posts.
     Ele pode ser facilmente estilo em seus posts, modificando o campo abaixo styling.
    </p>
    <form method="post" action="options.php">
    <?php

        if(function_exists('settings_fields')){
            settings_fields('tm-options');
        } else {
            wp_nonce_field('update-options');
            ?>
            <input type="hidden" name="action" value="update" />
            <input type="hidden" name="page_options" value="fblike_where,fblike_style,fblike_version,fblike_display_page,fblike_display_front,fblike_display_rss,fblike_display_feed,fblike_source,fblike_url_shortner,fblike_space,fblike_color,fblike_faces" />
            <?php
        }
    ?>
        <table class="form-table">
            <tr>
	            <tr>
	                <th scope="row" valign="top">
	                    Exibição
	                </th>
	                <td>
	                    <input type="checkbox" value="1" <?php if (get_option('fblike_display_page') == '1') echo 'checked="checked"'; ?> name="fblike_display_page" id="fblike_display_page" group="fblike_display"/>
	                    <label for="fblike_display_page">Exibir o botão em páginas</label>
	                    <br/>
	                    <input type="checkbox" value="1" <?php if (get_option('fblike_display_front') == '1') echo 'checked="checked"'; ?> name="fblike_display_front" id="fblike_display_front" group="fblike_display"/>
	                    <label for="fblike_display_front">Exibir o botão na primeira página (home)</label>
	                   

	                </td>
	            </tr>
                <th scope="row" valign="top">
                    Posição
                </th>
                <td>
                	<select name="fblike_where">
                		<option <?php if (get_option('fblike_where') == 'before') echo 'selected="selected"'; ?> value="before">Antes</option>
                		<option <?php if (get_option('fblike_where') == 'after') echo 'selected="selected"'; ?> value="after">Depois</option>
                		<option <?php if (get_option('fblike_where') == 'beforeandafter') echo 'selected="selected"'; ?> value="beforeandafter">Antes e Depois</option>
                		<option <?php if (get_option('fblike_where') == 'shortcode') echo 'selected="selected"'; ?> value="shortcode">Shortcode [fblikebutton]</option>
                		<option <?php if (get_option('fblike_where') == 'manual') echo 'selected="selected"'; ?> value="manual">Manual</option>
                	</select>
                </td>


                
            </tr>
            <tr>
               <th scope="row" valign="top">
                    Mostrar Faces
                </th>
                <td>
                	<select name="fblike_faces">
                		<option <?php if (get_option('fblike_faces') == 'true') echo 'selected="selected"'; ?> value="true">True</option>
                		<option <?php if (get_option('fblike_faces') == 'false') echo 'selected="selected"'; ?> value="false">False</option>
                	</select>
                </td>
            </tr>
            
            <tr>
            	 <th scope="row" valign="top">
                    Cores
                </th>
                <td>
                	<select name="fblike_color">
                		<option <?php if (get_option('fblike_color') == 'light') echo 'selected="selected"'; ?> value="light">Light</option>
                		<option <?php if (get_option('fblike_color') == 'dark') echo 'selected="selected"'; ?> value="dark">Dark</option>
                	</select>
                </td>
            </tr>
            
            <tr>
            	 <th scope="row" valign="top">
                    Botão Texto 
                </th>
                <td>
                	<select name="fblike_text">
                		<option <?php if (get_option('fblike_text') == 'like') echo 'selected="selected"'; ?> value="like">Like (Curti)</option>
                		<option <?php if (get_option('fblike_text') == 'recommend') echo 'selected="selected"'; ?> value="recommend">Recommend (Recomendar)</option>
                	</select>
                	<span class="description">(Atualmente Facebook permite 'Like' ou 'Recommend')</span>
                </td>
            </tr>
            
            <tr>
            	 <th scope="row" valign="top">
                    Layout
                </th>
                <td>
                	<select name="fblike_layout">
                		<option <?php if (get_option('fblike_layout') == 'standard') echo 'selected="selected"'; ?> value="standard">Padrão</option>
                		<option <?php if (get_option('fblike_layout') == 'count') echo 'selected="selected"'; ?> value="count">Contagem</option>
                	</select>
                </td>
            </tr>
            
            
            <tr>
                <th scope="row" valign="top"><label for="fblike_style">Styling</label></th>
                <td>
                    <input type="text" value="<?php echo htmlspecialchars(get_option('fblike_style')); ?>" name="fblike_style" id="fblike_style" />
                    <span class="description">Adicione o estilo para o div que envolve o botão E.g. <code>margin-bottom:15px; margin-top:15px;</code></span>
                </td>
            </tr>


        </table>
        <p class="submit">
            <input type="submit" name="Submit" value="<?php _e('Save Changes') ?>" />
        </p>
       
        </form>
    </div>
<?php
}



// register these variables 4 admin page
function fblike_init(){
    if(function_exists('register_setting')){
        register_setting('tm-options', 'fblike_display_page');
        register_setting('tm-options', 'fblike_display_front');
        register_setting('tm-options', 'fblike_display_rss');
        register_setting('tm-options', 'fblike_source', 'fblike_sanitize_username');
        register_setting('tm-options', 'fblike_style');
        register_setting('tm-options', 'fblike_version');
        register_setting('tm-options', 'fblike_where');
        register_setting('tm-options', 'fblike_rss_where');
        register_setting('tm-options', 'fblike_faces');
        register_setting('tm-options', 'fblike_color');
        register_setting('tm-options', 'fblike_text');
        register_setting('tm-options', 'fblike_layout');
        register_setting('tm-options', 'fblike_font');
        

    }
}

function fblike_sanitize_username($username){
    return preg_replace('/[^A-Za-z0-9_]/','',$username);
}

// Only all the admin options if the user is an admin
if(is_admin()){
    add_action('admin_menu', 'fblike_options');
    add_action('admin_init', 'fblike_init');
}

// Set the default options when the plugin is activated
function fblike_activate(){
    add_option('fblike_where', 'before');
    add_option('fblike_rss_where', 'before');
    add_option('fblike_source');
    add_option('fblike_style', 'float: right; margin-left: 10px;');
    add_option('fblike_display_page', '1');
    add_option('fblike_display_front', '1');
    add_option('fblike_display_rss', '0');
}

add_filter('the_content', 'fblike_update', 8);
add_filter('get_the_excerpt', 'fblike_remove_filter', 9);


//add_action('admin_print_scripts', 'fblike_js_admin_header');
add_action('wp_ajax_fblike_ajax_elev_lookup', 'fblike_ajax_elev_lookup');



register_activation_hook( __FILE__, 'fblike_activate');
