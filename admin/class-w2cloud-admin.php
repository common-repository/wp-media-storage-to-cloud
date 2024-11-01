<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://rextheme.com
 * @since      1.0.0
 *
 * @package    w2cloud
 * @subpackage w2cloud/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    w2cloud
 * @subpackage w2cloud/admin
 * @author     RexTheme <#>
 */
class w2cloud_Admin
{

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;


    /**
     * The menu of the plugin
     * @access   private
     * @var string $plugin_menu menu of the plugin
     */
    private $plugin_menu;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name       The name of this plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in w2cloud_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The w2cloud_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        $screen = get_current_screen();

        if (in_array($screen->id, apply_filters('w2cloud_page_hooks', array($this->plugin_menu)))) {
            wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/style.css', array(), $this->version, 'all');
        }

        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/wp-debug-admin.css', array(), $this->version, 'all');
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in w2cloud_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The w2cloud_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        $screen = get_current_screen();
        $rest_uri = get_rest_url();
        $permalink_structure = get_option('permalink_structure');
        if (in_array($screen->id, apply_filters('w2cloud_page_hooks', array($this->plugin_menu)))) {
            $production_build = w2cloud_ON_PRODUCTION ? 'min.' : '';

            wp_enqueue_script('w2cloud-vendors-admin', w2cloud_PLUGIN_DIR_URL . "admin/js/vendors~admin.{$production_build}js", array(), $this->version, true);
            wp_enqueue_script('w2cloud-vendors-admin-vendor', w2cloud_PLUGIN_DIR_URL . "admin/js/vendors~admin~vendor.{$production_build}js", array(), $this->version, true);
            wp_enqueue_script($this->plugin_name, w2cloud_PLUGIN_DIR_URL . "admin/js/admin.{$production_build}js", array(), $this->version, true);
            wp_enqueue_script('w2cloud-runtime', w2cloud_PLUGIN_DIR_URL . "admin/js/runtime.{$production_build}js", array(), $this->version, true);
            wp_enqueue_script('w2cloud-vendor', w2cloud_PLUGIN_DIR_URL . "admin/js/vendor.{$production_build}js", array(), $this->version, true);


            wp_localize_script(
                $this->plugin_name,
                'w2cloud_obj',
                array(
                    'api_nonce'        => wp_create_nonce('wp_rest'),
                    'site_admin'       => admin_url(),
                    'site_url'         => home_url(),
                    'plugin_dir_url'   => w2cloud_PLUGIN_DIR_URL,
                    'api_url'	       => $rest_uri.''.$this->plugin_name.'/v1',
                                        'permalink_structure'	=> $permalink_structure,
                    'routes'           => $this->get_w2cloud_routes(),
                    'routeComponents'  => array( 'default' => null ),
                )
            );
        }
        wp_enqueue_script($this->plugin_name, w2cloud_PLUGIN_DIR_URL . "admin/js/wp-debug-admin.js", array(), $this->version, true);
        wp_localize_script( $this->plugin_name, 'wp_debug_ajax', array(
    		        'ajaxurl' => admin_url( 'admin-ajax.php' ),
    		        'ajax_nonce' => wp_create_nonce('wp_debug'),
    		    ) );
    }


    /**
     * Module Integration
     */
    public function w2cloud_admin_initialization()
    {
        $module_integration = new w2cloud_Module_Integration_Manager();
        $module_integration->get_integrations();
    }


    /**
     * attach vue components
     */
    public function w2cloud_admin_spa()
    {
        require dirname(__FILE__) . '/views/w2cloud-spa-components.php';
    }



    /**
     * Register Plugin Admin Pages
     *
     * @since    1.0.0
     */
    public function load_admin_pages()
    {
        $this->plugin_menu = add_menu_page(__('w2cloud', 'w2cloud'), __('WP Cloud', 'w2cloud'), 'manage_options', 'wp-cloud', array($this, 'w2cloud_plugin_page'), w2cloud_PLUGIN_DIR_URL. 'admin/app/assets/images/icon.png');
        add_submenu_page( 'wp-cloud', 'Error Log', 'Logs','manage_options', 'wp-cloud-log', array( $this, 'wp_debug_log'));
    }

    /**
     * Plugin initial dashboard
     */
    public static function w2cloud_plugin_page()
    {
        require plugin_dir_path(__FILE__) . '/partials/w2cloud-admin-display.php';
    }

    /**
     * Plugin initial dashboard
     */
    public static function wp_debug_log()
    {
        require plugin_dir_path(__FILE__) . '/partials/wp-debug-log.php';
    }

    /**
     * define w2cloud routes
     * @return array
     */
    public function get_w2cloud_routes()
    {
        $routes = array(
            array(
                'path'      => '/',
                'name'      => 'home',
                'component' => 'Home'
            )
        );
        return apply_filters('w2cloud_routes', $routes);
    }

    /**
     * media attachment hook on upload
     */
    public function w2cloud_upload_media_on_attachment($id)
    {
        ini_set('max_execution_time', '300');

        $mime_type = get_post_mime_type($id);
        $mime_type_explode = explode('/', $mime_type);
        $extension = $mime_type_explode[0];

        if ($extension == 'image') {
            $file_path = get_attached_file($id);
            wp_generate_attachment_metadata($id, $file_path);

            $general_options = get_option('w2cloud_general_settings');
            $settings = json_decode($general_options);
            if ($settings->active_storage == 'gcs') {
                $google = new w2cloud_GCS_Process();
                $process = $google->gcs_media_transfer_handle($id);
            } elseif ($settings->active_storage == 'aws') {
                $amazon = new w2cloud_AWS_Process();
                $process = $amazon->aws_media_transfer_handle($id);
            } elseif ($settings->active_storage == 'do') {
                $ocean = new w2cloud_DO_Process();
                $process = $ocean->do_media_transfer_handle($id);
            }
        }
    }

    /**
    * Clear
    */
    public function wp_debug_clear() {
        $path = get_home_path() .'wp-content/debug.log';
        unlink($path);
        die();
    }
}
