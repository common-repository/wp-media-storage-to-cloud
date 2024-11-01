<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://rextheme.com
 * @since      1.0.0
 *
 * @package    w2cloud
 * @subpackage w2cloud/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    w2cloud
 * @subpackage w2cloud/includes
 * @author     RexTheme <#>
 */
class w2cloud_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		if ( file_exists( get_home_path() .'wp-config.php') ) {
			$path = get_home_path() .'wp-config.php';
			$config_transformer = new WPConfigTransformer( $path );
			$config_transformer->remove( 'constant', 'WP_DEBUG' );
			$config_transformer->remove( 'constant', 'WP_DEBUG_LOG' );
			$config_transformer->remove( 'constant', 'SCRIPT_DEBUG' );
			$config_transformer->remove( 'constant', 'SAVEQUERIES' );
		}
	}

}
