<?php
/**
	* Module Name: WooDojo - Maintenance Mode
	* Module Description: Easily enable "maintenance mode" while performing various maintenance tasks or developing your website.
	* Module Version: 1.0.0
	* Module Settings: woodojo-maintenance-mode
	*
	* @package WooDojo
	* @subpackage Downloadable
	* @author Patrick
	* @since 1.0.0
*/

 /* Instantiate Maintenance Mode */
 if ( class_exists( 'WooDojo' ) ) {
 	require_once( 'classes/woodojo-maintenance-mode.class.php' );
 	$woodojo_maintenance_mode = new WooDojo_Maintenance_Mode( __FILE__ );
 }
?>