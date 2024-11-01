<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://rextheme.com
 * @since      1.0.0
 *
 * @package    w2cloud
 * @subpackage w2cloud/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    w2cloud
 * @subpackage w2cloud/includes
 * @author     RexTheme <#>
 */
class w2cloud {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      w2cloud_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'w2cloud_VERSION' ) ) {
			$this->version = w2cloud_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'w2cloud';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - w2cloud_Loader. Orchestrates the hooks of the plugin.
	 * - w2cloud_i18n. Defines internationalization functionality.
	 * - w2cloud_Admin. Defines all hooks for the admin area.
	 * - w2cloud_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {


    /**
     * Get Composer Autoloader.
     */
    require_once plugin_dir_path( dirname( __FILE__ ) ) . 'vendor/autoload.php';


		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-w2cloud-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-w2cloud-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-w2cloud-public.php';

		$this->loader = new w2cloud_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the w2cloud_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new w2cloud_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new w2cloud_Admin( $this->get_plugin_name(), $this->get_version() );
		$baseOperations = new w2cloud_Rest_Api();
		$media_serv_controller = new w2cloud_media_control();

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
    $this->loader->add_action( 'admin_init', $plugin_admin, 'w2cloud_admin_initialization' );
    $this->loader->add_action( 'admin_menu', $plugin_admin, 'load_admin_pages');
    $this->loader->add_action( 'admin_footer', $plugin_admin, 'w2cloud_admin_spa' );
		$this->loader->add_action( 'wp_ajax_wp_debug_clear', $plugin_admin, 'wp_debug_clear' );


		$general_options = get_option('w2cloud_general_settings');
		if ($general_options) {
			$settings = json_decode($general_options);
			if ($settings->serve_from_bucket) {
				$this->loader->add_filter( 'wp_get_attachment_url', $media_serv_controller, 'w2cloud_media_url_modification' );
				$this->loader->add_filter( 'the_content', $media_serv_controller, 'w2cloud_content_media_url_modification' );
				$this->loader->add_filter( 'wp_get_attachment_image_attributes', $media_serv_controller, 'w2cloud_media_attr_modification' );
			}

			if ($settings->up_on_bucket) {
				$this->loader->add_filter( 'add_attachment', $plugin_admin, 'w2cloud_upload_media_on_attachment' );
			}

			if ($settings->delete_from_bucket) {
				$this->loader->add_filter( 'delete_attachment', $media_serv_controller, 'w2cloud_delete_media' );
			}
		}
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new w2cloud_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    w2cloud_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
