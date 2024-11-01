<?php
/**
 * REST_API Handler
 */
class w2cloud_Rest_Api
{

    /**
     * Instance of this class.
     *
     * @since    0.8.1
     *
     * @var      object
     */
    protected static $instance = null;


    /**
     * Namespace of of this endpoints.
     *
     * @since    0.8.1
     *
     * @var      object
     */
    public $namespace = '';


    /**
     * Initialize the plugin by setting localization and loading public scripts
     * and styles.
     *
     * @since     0.8.1
     */
    public function __construct()
    {
        $version = '1';
        $this->plugin_slug = 'w2cloud';
        $this->namespace = $this->plugin_slug . '/v' . $version;
        $this->do_hooks();
    }


    /**
     * Set up WordPress hooks and filters
     *
     * @return void
     */
    public function do_hooks()
    {
        add_action('rest_api_init', array( $this, 'register_routes' ));
    }

    /**
     * Return an instance of this class.
     *
     * @since     0.8.1
     *
     * @return    object    A single instance of this class.
     */
    public static function get_instance()
    {
        // If the single instance hasn't been set, set it now.
        if (null == self::$instance) {
            self::$instance = new self;
            self::$instance->do_hooks();
        }

        return self::$instance;
    }


    /**
     * Register the routes for the objects of the controller.
     */
    public function register_routes()
    {
        register_rest_route($this->namespace, '/gcsAuth', array(
        array(
            'methods' => \WP_REST_Server::CREATABLE,
            'callback' => array($this, 'submit_gcs_auth_data'),
            'permission_callback' => '__return_true'

        ),
      ));

        register_rest_route($this->namespace, '/gcsAuthValidation', array(
        array(
            'methods' => \WP_REST_Server::READABLE,
            'callback' => array($this, 'validate_gcs_auth_data'),
            'permission_callback' => '__return_true'

        ),
      ));

        register_rest_route($this->namespace, '/awsAuth', array(
        array(
            'methods' => \WP_REST_Server::CREATABLE,
            'callback' => array($this, 'submit_aws_auth_data'),
            'permission_callback' => '__return_true'

        ),
      ));

        register_rest_route($this->namespace, '/awsAuthValidation', array(
        array(
            'methods' => \WP_REST_Server::READABLE,
            'callback' => array($this, 'validate_aws_auth_data'),
            'permission_callback' => '__return_true'

        ),
      ));

        register_rest_route($this->namespace, '/doAuth', array(
        array(
            'methods' => \WP_REST_Server::CREATABLE,
            'callback' => array($this, 'submit_do_auth_data'),
            'permission_callback' => '__return_true'

        ),
      ));

        register_rest_route($this->namespace, '/doAuthValidation', array(
        array(
            'methods' => \WP_REST_Server::READABLE,
            'callback' => array($this, 'validate_do_auth_data'),
              'permission_callback' => '__return_true'

        ),
      ));

        register_rest_route($this->namespace, '/getGcsAuthData', array(
        array(
            'methods' => \WP_REST_Server::READABLE,
            'callback' => array($this, 'get_gcs_auth_data'),
            'permission_callback' => '__return_true'

        ),
      ));

        register_rest_route($this->namespace, '/processMediaTransfer', array(
        array(
            'methods' => \WP_REST_Server::CREATABLE,
            'callback' => array($this, 'process_gcs_media_transfer'),
            'permission_callback' => '__return_true'
        ),
      ));

        register_rest_route($this->namespace, '/processAWSMediaTransfer', array(
        array(
            'methods' => \WP_REST_Server::CREATABLE,
            'callback' => array($this, 'process_aws_media_transfer'),
            'permission_callback' => '__return_true'
        ),
      ));

        register_rest_route($this->namespace, '/processDOMediaTransfer', array(
        array(
            'methods' => \WP_REST_Server::CREATABLE,
            'callback' => array($this, 'process_do_media_transfer'),
            'permission_callback' => '__return_true'
        ),
      ));

        register_rest_route($this->namespace, '/w2cloudPluginRating', array(
        array(
            'methods' => \WP_REST_Server::READABLE,
            'callback' => array($this, 'w2cloud_plugin_rating'),
            'permission_callback' => '__return_true'
        ),
      ));

        register_rest_route($this->namespace, '/w2cloudPluginCompatibility', array(
        array(
            'methods' => \WP_REST_Server::READABLE,
            'callback' => array($this, 'w2cloud_plugin_compatibility'),
            'permission_callback' => '__return_true'
        ),
      ));

        register_rest_route($this->namespace, '/w2cloudSubmitGeneralSettings', array(
        array(
            'methods' => \WP_REST_Server::CREATABLE,
            'callback' => array($this, 'submit_general_settings'),
            'permission_callback' => '__return_true'
        ),
      ));

        register_rest_route($this->namespace, '/w2cloudGetGeneralSettings', array(
        array(
            'methods' => \WP_REST_Server::READABLE,
            'callback' => array($this, 'get_general_settings'),
            'permission_callback' => '__return_true'
        ),
      ));

        register_rest_route($this->namespace, '/getReadyChannels', array(
        array(
            'methods' => \WP_REST_Server::READABLE,
            'callback' => array($this, 'get_ready_channels'),
            'permission_callback' => '__return_true'
        ),
      ));
    }

    public function submit_gcs_auth_data($request)
    {
        $data = $request->get_param('data');
        $bucket = $request->get_param('bucket');

        $google = new w2cloud_GCS_Process();

        $query_images_args = array(
            'post_type'      => 'attachment',
            'post_mime_type' => 'image',
            'post_status'    => 'inherit',
            'posts_per_page' => - 1,
        );

        $query_images = new WP_Query($query_images_args);
        $files = array();
        foreach ($query_images->posts as $file) {
            $files[] =  $file->ID ;
        }
        if ($files[0]) {
            $check_id = $files[0];
            $response = $google->gcs_auth_form_data_validate($bucket, $data, $check_id);
            if ($response == 'success') {
                update_option('gcs_auth_data', $data);
                update_option('gcs_bucket', $bucket);
                return(array(
                'status'=>'success',
                'message'=>'Successfully checked and saved data'
              ));
            } else {
                return(array(
                'status'=>'error',
                'message'=>$response
              ));
            }
            return $response;
        } else {
            return(array(
              'status'=>'error',
              'message'=>'No media file found to check validation'
            ));
        }
    }

    public function validate_gcs_auth_data($request)
    {
        $google = new w2cloud_GCS_Process();
        $response = $google->gcs_auth_checker();
        return $response;
    }

    public function submit_aws_auth_data($request)
    {
        $aws_client_id = $request->get_param('aws_client_id');
        $aws_client_secret = $request->get_param('aws_client_secret');
        $aws_bucket = $request->get_param('aws_bucket');
        $aws_region = $request->get_param('aws_region');

        $amazon = new w2cloud_AWS_Process();

        $query_images_args = array(
            'post_type'      => 'attachment',
            'post_mime_type' => 'image',
            'post_status'    => 'inherit',
            'posts_per_page' => - 1,
        );

        $query_images = new WP_Query($query_images_args);
        $files = array();
        foreach ($query_images->posts as $file) {
            $files[] =  $file->ID ;
        }
        if ($files[0]) {
            $check_id = $files[0];
            $response = $amazon->aws_auth_form_data_validate($aws_bucket, $aws_client_id, $aws_client_secret, $aws_region, $check_id);
            if ($response == 'success') {
                update_option('aws_client_id', $aws_client_id);
                update_option('aws_client_secret', $aws_client_secret);
                update_option('aws_bucket', $aws_bucket);
                update_option('aws_region', $aws_region);
                return(array(
                'status'=>'success',
                'message'=>'Successfully checked and saved data'
              ));
            } else {
                return(array(
                'status'=>'error',
                'message'=>$response
              ));
            }
        } else {
            return(array(
              'status'=>'error',
              'message'=>'No media file found to check validation'
            ));
        }
    }

    public function validate_aws_auth_data($request)
    {
        $amazon = new w2cloud_AWS_Process();
        $response = $amazon->aws_auth_checker();
        return $response;
    }

    public function get_gcs_auth_data($request)
    {
        $type = $request->get_param('type');

        $query_images_args = array(
            'post_type'      => 'attachment',
            'post_mime_type' => 'image',
            'post_status'    => 'inherit',
            'posts_per_page' => - 1,
        );

        $query_images = new WP_Query($query_images_args);
        $files = array();
        foreach ($query_images->posts as $file) {
            if ($type == 'unsynced') {
                $status = get_post_meta($file->ID, 'w2cloud_sync');
                if ($status[0] != 'success') {
                    $files[] =  $file->ID;
                }
            } else {
                $files[] =  $file->ID;
            }
        }
        // $data = array_slice($files, 0, 500, true);
        $data = $files;
        return(array(
            'status'=>'success',
            'message'=>$data
          ));
    }

    public function process_gcs_media_transfer($request)
    {
        $id = (int)$request->get_param('id');
        $google = new w2cloud_GCS_Process();
        $process = $google->gcs_media_transfer_handle($id);
        return $process;
    }

    public function process_aws_media_transfer($request)
    {
        $id = (int)$request->get_param('id');
        $amazon = new w2cloud_AWS_Process();
        $process = $amazon->aws_media_transfer_handle($id);
        return $process;
    }

    public function process_do_media_transfer($request)
    {
        $id = (int)$request->get_param('id');
        $ocean = new w2cloud_DO_Process();
        $process = $ocean->do_media_transfer_handle($id);
        return $process;
    }

    public function w2cloud_plugin_rating($request)
    {
        $args = (object) array( 'slug' => 'wpvr ' );
        $request = array( 'action' => 'plugin_information', 'timeout' => 15, 'request' => serialize($args) );
        $url = 'http://api.wordpress.org/plugins/info/1.0/';
        $response = wp_remote_post($url, array( 'body' => $request ));
        $plugin_info = unserialize($response['body']);
        $rating_array = $plugin_info->ratings;
        foreach ($rating_array as $star) {
            $rating[] = $star;
        }
        $average = $plugin_info->rating / array_sum($rating);
        $format = number_format($average, 1, '.', '');
        return $format;
    }


    public function w2cloud_plugin_compatibility()
    {
        $compatibility_info = array();

        //===php version===//

        $php_version_value = phpversion();
        $php_version = array(
        'title' => "PHP Version :",
        'value' => $php_version_value,
      );
        $compatibility_info[]['php_version'] =  $php_version;

        //===php post max size===//

        $post_max_size_value = ini_get('post_max_size');
        $post_max_size = array(
        'title' => "Post Max Size :",
        'value' => $post_max_size_value,
      );
        $compatibility_info[]['post_max_size'] =  $post_max_size;

        //===php max execution time===//

        $max_execution_value = ini_get('max_execution_time');
        $max_execution_size = array(
        'title' => "Max Execution Time :",
        'value' => $max_execution_value,
      );
        $compatibility_info[]['max_execution_time'] =  $max_execution_size;


        //===php max input vars===//

        $max_input_value = ini_get('max_input_vars');
        $max_input_size = array(
        'title' => "Max Input Vars :",
        'value' => $max_input_value,
      );
        $compatibility_info[]['max_input_vars'] =  $max_input_size;


        //===php memory limit===//

        $memory_limit_value = @ini_get('memory_limit');
        $memory_limit_size = array(
        'title' => "Memory Limit :",
        'value' => $memory_limit_value,
      );
        $compatibility_info[]['memory_limit'] =  $memory_limit_size;

        //===wordpress max upload size===//

        $up_in_byte = wp_max_upload_size();
        $up_in_kilo_byte = $up_in_byte/1000;
        $up_in_mega_byte = floor($up_in_kilo_byte/1000);
        $max_upload_size = $up_in_mega_byte.'M';

        $max_upload_size_value = $max_upload_size;
        $max_upload_size_number = array(
        'title' => "Max Upload Size :",
        'value' => $max_upload_size_value,
      );

        $compatibility_info[]['max_upload_size'] =  $max_upload_size_number;


        //===fsockopen or curl enabled===//

        $fsockopen_or_curl_enabled = (function_exists('fsockopen') || function_exists('curl_init'));

        if ($fsockopen_or_curl_enabled) {
            $fsockopen_or_curl_enabled_value = "Enabled";
        } else {
            $fsockopen_or_curl_enabled_value = "Disabled";
        }

        $fsockopen_or_curl_enabled_array = array(
          'title' => "Fsockopen/cURL :",
          'value' => $fsockopen_or_curl_enabled_value,
        );

        $compatibility_info[]['fsockopen_or_curl_enabled'] =  $fsockopen_or_curl_enabled_array;


        //===curl version===//

        $curl_info = curl_version();

        if (isset($curl_info['version'])) {
            $curl_version_value = $curl_info['version'];
            $curl_version_number = array(
        'title' => "Curl Version :",
        'value' => $curl_version_value,
      );

            $compatibility_info[]['curl_version'] =  $curl_version_number;
        } else {
            $compatibility_info[]['curl_version'] =  'none';
        }

        //===curl ssl version===//

        if (isset($curl_info['ssl_version'])) {
            $ssl_version_value = $curl_info['ssl_version'];
            $ssl_version_number = array(
        'title' => "SSL Version :",
        'value' => $ssl_version_value,
      );
            $compatibility_info[]['ssl_version'] =  $ssl_version_number;
        } else {
            $compatibility_info['ssl_version'] =  'none';
        }
        return $compatibility_info;
    }





    public function submit_general_settings($request)
    {
        $settings = $request->get_param('settings');
        update_option('w2cloud_general_settings', $settings);
        return(array(
           'status'=>'success',
           'message'=>'Successfully saved'
         ));
    }

    public function get_general_settings($request)
    {
        $default = '{"active_storage":"none","serve_from_bucket":false,"up_on_bucket":false,"delete_from_bucket":false, "erase_from_local":false}';
        $settings = get_option('w2cloud_general_settings');
        if ($settings) {
            $decoded_settings = json_decode($settings);
            return $decoded_settings;
        } else {
            $decode_default = json_decode($default);
            return $decode_default;
        }
    }

    public function get_ready_channels($request)
    {
        $data = array();
        $channels = w2cloud_avail_channels();
        $option = array(
         'text' => 'None',
         'value' => 'none',
       );
        $data[] = $option;
        foreach ($channels as $key => $value) {
            if ($key == 'gcs') {
                $google = new w2cloud_GCS_Process();
                $response = $google->gcs_auth_checker();
                if ($response['message'] == 'ready') {
                    $option = array(
               'text' => $value,
               'value' => $key,
             );
                    $data[] = $option;
                }
            } elseif ($key == 'aws') {
                $amazon = new w2cloud_AWS_Process();
                $response = $amazon->aws_auth_checker();
                if ($response['message'] == 'ready') {
                    $option = array(
               'text' => $value,
               'value' => $key,
             );
                    $data[] = $option;
                }
            } elseif ($key == 'do') {
                $ocean = new w2cloud_DO_Process();
                $response = $ocean->do_auth_checker();
                if ($response['message'] == 'ready') {
                    $option = array(
               'text' => $value,
               'value' => $key,
             );
                    $data[] = $option;
                }
            }
        }
        return $data;
    }

    public function submit_do_auth_data($request)
    {
        $do_client_id = $request->get_param('do_client_id');
        $do_client_secret = $request->get_param('do_client_secret');
        $do_bucket = $request->get_param('do_bucket');
        $do_region = $request->get_param('do_region');


        $ocean = new w2cloud_DO_Process();

        $query_images_args = array(
             'post_type'      => 'attachment',
             'post_mime_type' => 'image',
             'post_status'    => 'inherit',
             'posts_per_page' => - 1,
         );

        $query_images = new WP_Query($query_images_args);
        $files = array();
        foreach ($query_images->posts as $file) {
            $files[] =  $file->ID ;
        }
        if ($files[0]) {
            $check_id = $files[0];
            $response = $ocean->do_auth_form_data_validate($do_bucket, $do_client_id, $do_client_secret, $do_region, $check_id);
            if ($response == 'success') {
                update_option('do_client_id', $do_client_id);
                update_option('do_client_secret', $do_client_secret);
                update_option('do_bucket', $do_bucket);
                update_option('do_region', $do_region);
                return(array(
                 'status'=>'success',
                 'message'=>'Successfully checked and saved data'
               ));
            } else {
                return(array(
                 'status'=>'error',
                 'message'=>$response
               ));
            }
            return $response;
        } else {
            return(array(
               'status'=>'error',
               'message'=>'No media file found to check validation'
             ));
        }
    }

    public function validate_do_auth_data($request)
    {
        $ocean = new w2cloud_DO_Process();
        $response = $ocean->do_auth_checker();
        return $response;
    }

    /**
     * Check if a given request has access to update a setting
     *
     * @param WP_REST_Request $request Full data about the request.
     * @return WP_Error|bool
     */
    public function w2cloud_permissions_check($request)
    {
        // return true;
        return current_user_can('manage_options');
    }
}
