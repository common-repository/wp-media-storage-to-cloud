<?php

/**
 * Fired during plugin activation
 *
 * @link       https://rextheme.com
 * @since      1.0.0
 *
 * @package    w2cloud
 * @subpackage w2cloud/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    w2cloud
 * @subpackage w2cloud/includes
 * @author     RexTheme <#>
 */
class w2cloud_Activator
{

    /**
     * Short Description. (use period)
     *
     * Long Description.
     *
     * @since    1.0.0
     */
    public static function activate()
    {
        $default = '{"active_storage":"none","serve_from_bucket":false,"up_on_bucket":false,"delete_from_bucket":false, "erase_from_local":false}';
        update_option('w2cloud_general_settings', $default);
        add_option('w2cloud_activation_redirect', true);
        update_option('w2cloud_dashboard_option', 0);
        if ( file_exists( get_home_path() .'wp-config.php') ) {
          $path = get_home_path() .'wp-config.php';
          $config_transformer = new WPConfigTransformer( $path );
          $config_transformer->update( 'constant', 'WP_DEBUG', 'true', array( 'raw' => true ) );
          $config_transformer->update( 'constant', 'WP_DEBUG_LOG', 'true', array( 'raw' => true ) );
          $config_transformer->update( 'constant', 'SCRIPT_DEBUG', 'true', array( 'raw' => true ) );
          $config_transformer->update( 'constant', 'SAVEQUERIES', 'true', array( 'raw' => true ) );
        }
    }
}
