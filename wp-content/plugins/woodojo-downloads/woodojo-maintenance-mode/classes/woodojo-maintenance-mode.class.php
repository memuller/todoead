<?php
/*-----------------------------------------------------------------------------------

CLASS INFORMATION

Description: Don't let people see your site when you are maintaining it.
Date Created: 2012-03-23.
Last Modified: 2011-03-25.
Author: Patrick
Since: 1.0.0


TABLE OF CONTENTS

- var $token
- var $settings_screen
- var $templates_dir

- function __construct

-----------------------------------------------------------------------------------*/
class WooDojo_Maintenance_Mode {
		
	/* Variable Declarations */
	var $token;
	var $settings_screen;
	var $templates_dir;
	private $file;
	
	/**
	 * __construct function.
	 * 
	 * @access public
	 * @since 1.0.0
	 * @return void
	 */
	public function __construct ( $file ) {
		$this->templates_dir = trailingslashit( trailingslashit( dirname( $file ) ) . 'templates' );
    	/* Settings Screen */
    	$this->load_settings_screen();
		$this->settings = $this->settings_screen->get_settings();
		
		if( $this->settings['enable'] == true ) {
			
			if( ! is_admin() && !in_array($GLOBALS['pagenow'],array('wp-login.php')) && !current_user_can($this->settings['role'])) {
				add_action('init', array(&$this,'maintenance_mode'));
			} else {
				add_filter('login_message', array(&$this,'login_message'));
				add_filter('admin_notices', array(&$this,'admin_notice'));
				add_action('wp_footer', array(&$this,'wp_footer'));
			}
		}


		
	} // End __construct()
	
	/**
	 * maintenance_mode function.
	 * 
	 * @access public
	 * @since 1.0.0
	 * @return void
	 */
	public function maintenance_mode () {
		nocache_headers(); // Let's not cachify the maintenance mode.
		
		$location = trailingslashit( trailingslashit( WP_PLUGIN_DIR ) . trailingslashit( plugin_basename( dirname( dirname( __FILE__ ) ) ) ) . 'templates' );
		$location_url = trailingslashit( trailingslashit( WP_PLUGIN_URL ) . trailingslashit( plugin_basename( dirname( dirname( __FILE__ ) ) ) ) . 'templates' );

		$template = $this->settings['template'];
		$path_to_load = '';

		// Determine where to look for the template file.
		if ( stristr( $template, '503.php' ) != '' ) {
			$path_to_load = trailingslashit( trailingslashit( WP_CONTENT_DIR ) . 'themes' ) . $template;
		} else {
			// Check for custom paths (not in theme).
			if ( stristr( $template, DIRECTORY_SEPARATOR ) != '' ) {
				$path_to_load = $template;
			}
		}

		if ( $path_to_load == '' ) {
			$path_to_load = $location . $template;
		}

		if( $template != 'wp_die' && $template != 'theme-503' && file_exists( $path_to_load ) ) {

			// Variables made available to the template file.
			$settings = array();
			$settings['note'] = (isset($this->settings['note']) && $this->settings['note'] != '') ? $this->settings['note'] : __( 'This website is currently in maintenance mode.', 'woodojo-maintenance-mode' );
			$settings['title'] = (isset($this->settings['title']) && $this->settings['title'] != '') ? $this->settings['title'] : __( 'Maintenance Mode', 'woodojo-maintenance-mode' );
			$settings['page_title'] = (isset($this->settings['page_title']) && $this->settings['page_title'] != '') ? $this->settings['page_title'] : get_bloginfo( 'name' );
			$settings['path'] = trailingslashit( $location_url . basename( dirname( $path_to_load ) ) );

			$settings['title'] = stripslashes( $settings['title'] );
			$settings['note'] = stripslashes( $settings['note'] );
			$settings['page_title'] = stripslashes( $settings['page_title'] );

			// Allow themes/plugins to filter here.
			$settings = apply_filters( 'woodojo_maintenance_mode_template_settings', $settings );

			include( $path_to_load );
			exit();
		}
		
		if ( $template == 'theme-503' && file_exists( esc_attr( trailingslashit( get_stylesheet_directory() ) . '503.php' ) ) ) {
			locate_template( array( '503.php' ), true, true );
			exit;
		}

		// If all else fails... DIE!
		wp_die( $note, $title );
		
	} // End maintenance_mode()
	
	/**
	 * admin_notice function.
	 * 
	 * @access public
	 * @since 1.0.0
	 * @return void
	 */
	public function admin_notice() {
		if( isset( $_GET['page'] ) && $_GET['page'] != 'woodojo-maintenance-mode' ) {
			echo '<div class="error"><p>' . __( 'Maintenance mode is enabled.','woodojo-maintenance-mode' ) . '</p></div>' . "\n";
    	}
	} // End admin_notice()
	
	/**
	 * wp_footer function.
	 * 
	 * @access public
	 * @since 1.0.0
	 * @return void
	 */
	public function wp_footer() {
		
		echo '<div style="position:fixed; bottom:0; width:100%; height:30px; background:red;"><p style="text-align:center; color:white; line-height:30px; font-size:20px;">'.__('Maintenance mode has been enabled.','woodojo-maintenance-mode').' <a href="'.admin_url().'" style="color:white; text-decoration:underline;">'.__('Go to WP Admin &raquo;','woodojo-maintenance-mode').'</a></p></div>';
		
	} // End wp_footer()
	
	/**
	 * login_message function.
	 * 
	 * @access public
	 * @since 1.0.0
	 * @return void
	 */
	public function login_message() {
		return '<div id="login_error"><p>'.__('Maintenance mode is enabled.','woodojo-maintenance-mode').'</p></div>';
	} // End login_message()
	
	/**
	 * load_settings_screen function.
	 * 
	 * @access public
	 * @since 1.0.0
	 * @return void
	 */
	public function load_settings_screen() {
		
		/* Settings Screen */
		require_once('settings.class.php');
		$this->settings_screen = new WooDojo_Maintenance_Mode_Settings();
		
		/* Setup Settings Data */
		$this->settings_screen->token = 'woodojo-maintenance-mode';
		if ( is_admin() ) {
			$this->settings_screen->name 		= __('Maintenance Mode', 'woodojo-maintenance-mode');
			$this->settings_screen->menu_label	= __('Maintenance', 'woodojo-maintenance-mode');
			$this->settings_screen->page_slug	= 'woodojo-maintenance-mode';
		}
		$this->settings_screen->templates_dir = $this->templates_dir;
		$this->settings_screen->setup_settings();
	
	} // End load_settings_screen()

	/**
	 * maintenance_head function.
	 * @return void 
	 */
	public function maintenance_head () {
		do_action( 'woodojo_maintenance_mode_head' );

		wp_print_scripts();
	}// End maintenance_head()

	/**
	 * page_title function.
	 * @return void 
	 */
	public function page_title () {
		$title = apply_filters( 'woodojo_maintenance_mode_title', $this->settings['page_title'] );

		if ( $title == '' ) {
			$title = get_bloginfo( 'name' );
		}

		echo $title;
	}// End page_title()

	/**
	 * maintenance_end_body function.
	 * @return void 
	 */
	public function maintenance_end_body(){
		do_action('woodojo_maintenance_mode_end_body');

	}// End maintenance_end_body()
}
?>