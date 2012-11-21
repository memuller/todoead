<?php
/*-----------------------------------------------------------------------------------

CLASS INFORMATION

Description: Settings Screen Data
Date Created: 2012-03-23.
Last Modified: 2011-03-25.
Author: Patrick
Since: 1.0.0


TABLE OF CONTENTS

- function __construct
- function init_sections
- function init_fields

-----------------------------------------------------------------------------------*/

class WooDojo_Maintenance_Mode_Settings extends WooDojo_Settings_API {
	var $templates_dir;

	/**
	 * __construct function.
	 * 
	 * @access public
	 * @since 1.0.0
	 * @return void
	 */
	public function __construct () {
	    parent::__construct(); // Required in extended classes.
	} // End __construct()
	
	/**
	 * init_sections function.
	 * 
	 * @access public
	 * @since 1.0.0
	 * @return void
	 */
	public function init_sections () {
		$sections = array();
		
		$sections['general'] = array(
			'name' 			=> __( 'General Settings', 'woodojo-maintenance-mode' ), 
			'description'	=> sprintf( __( 'The default option is to use a native error message on the front end of your website. You can customize this by entering a title and note below. To customize your own maintenance mode theme, you can add a %s file to your current theme (child theme, if you\'re using one).', 'woodojo-maintenance-mode' ), '<code>503.php</code>' )
		);
		
		$this->sections = $sections;
	} // End init_sections()
	
	/**
	 * init_fields function.
	 * 
	 * @access public
	 * @since 1.0.0
	 * @return void
	 */
	public function init_fields () {
	    $options = array( 'wp_die' => __( 'Use WordPress Default', 'woodojo-maintenance-mode' ), 'theme-503' => __( '503.php in the current theme', 'woodojo-maintenance-mode' ) );

	    $results = $this->find_templates();

		if ( is_array( $results ) && count( $results ) > 0 ) {
			foreach ( $results as $k => $v ) {
				$options[$k] = $v;
			}
		}

		// Allow themes/plugins to filter here.
	    $options = apply_filters( 'woodojo_maintenance_mode_templates', $options );

	    $fields = array();
	    
		$fields['enable'] = array(
		    'name' => __( 'Enable', 'woodojo-maintenance-mode' ), 
		    'description' => __( 'Turn on maintenance mode.', 'woodojo-maintenance-mode' ), 
		    'type' => 'checkbox', 
		    'default' => false, 
		    'section' => 'general'
		);
	    
		$fields['role'] = array(
		    'name' => __( 'Bypass Capability Requirement', 'woodojo-maintenance-mode' ), 
		    'description' => __( 'Determine which level of users can see the website when in Maintenance Mode.', 'woodojo-maintenance-mode'), 
		    'type' => 'select', 
		    'default' => 'manage_options', 
		    'options'	=> array(
		    	'manage_options'	=> __( 'Administrator', 'woodojo-maintenance-mode' ),
		    	'publish_pages'		=> __( 'Editor', 'woodojo-maintenance-mode' ),
		    	'publish_posts'		=> __( 'Author', 'woodojo-maintenance-mode' ),
		    	'edit_posts'		=> __( 'Contributor', 'woodojo-maintenance-mode' ),
		    	'read'				=> __( 'Subscriber', 'woodojo-maintenance-mode' )
		    ),
		    'section' => 'general'
		);
	    
		$fields['template'] = array(
		    'name' => __( 'Template', 'woodojo-maintenance-mode' ), 
		    'description' => __( 'Choose the design to be used for your Maintenance Mode screen.', 'woodojo-maintenance-mode' ), 
		    'type' => 'select', 
		    'default' => 'wp_die', 
		    'options'	=> $options,
		    'section' => 'general'
		);
	    
		$fields['page_title'] = array(
		    'name' => __( 'Maintenance Page Title', 'woodojo-maintenance-mode' ), 
		    'description' => __( 'This is the page title for the Maintenance Mode page. Leave blank to use your website\'s title.', 'woodojo-maintenance-mode' ), 
		    'type' => 'text', 
		    'default' => '', 
		    'section' => 'general'
		);

		$fields['title'] = array(
		    'name' => __( 'Maintenance Title', 'woodojo-maintenance-mode' ), 
		    'description' => __( 'This is the HTML title of the Maintenance Mode page. Leave blank for the default.', 'woodojo-maintenance-mode' ), 
		    'type' => 'text', 
		    'default' => '', 
		    'section' => 'general'
		);
	    
		$fields['note'] = array(
		    'name' => __( 'Maintenance Note', 'woodojo-maintenance-mode' ), 
		    'description' => __( 'A brief note that will be included in the Maintenance Mode page. Leave blank for the default text.', 'woodojo-maintenance-mode' ), 
		    'type' => 'textarea', 
		    'default' => '', 
		    'section' => 'general'
		);
		
		$this->fields = $fields;
	
	} // End init_fields()

	/**
 	 * find_templates function.
	 * 
	 * @access public
	 * @since 1.0.0
	 * @return array $results
	 */
	private function find_templates () {
		$results = array();

		$files = WooDojo_Utils::glob_php( '*.php', GLOB_MARK, $this->templates_dir );

		if ( is_array( $files ) && count( $files ) > 0 ) {
			foreach ( $files as $k => $v ) {
				$data = $this->get_template_data( $v );
				if ( is_object( $data ) && isset( $data->title ) ) {
					$results[$v] = $data->title;
				}
			}
		}

		return $results;
	} // End find_templates()

	/**
	 * get_template_data function.
	 * 
	 * @access public
	 * @since 1.0.0
	 * @param string $file The path to the file to be scanned for template file data.
	 * @return object/boolean
	 */
	private function get_template_data ( $file ) {
		$headers = array(
			'title' => 'Template Name',
			'description' => 'Description', 
			'version' => 'Version'
		);
		$mod = get_file_data( $file, $headers );
		if ( ! empty( $mod['title'] ) ) {
			$obj = new StdClass();
			
			foreach ( $mod as $k => $v ) {
				$obj->$k = $v;
			}

			return $obj;
		}
		return false;
	} // End get_template_data()
} // End Class WooDojo_Maintenance_Mode_Settings
?>