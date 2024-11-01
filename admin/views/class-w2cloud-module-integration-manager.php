<?php


/**
 * The Integration Loader
 */
class w2cloud_Module_Integration_Manager {

    /**
     * The integration instances
     *
     * @var array
     */
    public $integrations = array();


    /**
     * Return loaded integrations.
     *
     * @return array
     */
    public function get_integrations() {

        if ( $this->integrations ) {
            return $this->integrations;
        }
        $integrations = apply_filters( 'w2cloud_module_integration', array(
            'w2cloud_dashboard',
            'w2cloud_gcs',
            'w2cloud_aws',
            'w2cloud_do',
            'w2cloud_gcs_sync',
            'w2cloud_aws_sync',
            'w2cloud_compatibility',
            'w2cloud_support',
            'w2cloud_setting',
            'w2cloud_file',
            'w2cloud_general',
            'w2cloud_storage',
            'w2cloud_wizard',
            'w2cloud_media',
            'w2cloud_syncs',
            'w2cloud_do_sync',
            'w2cloud_amazon_media_check',
            'w2cloud_gcs_media_check',
        ));

        // Load integration classes
        foreach ( $integrations as $integration ) {
            $integration_instance = new $integration();
            $this->integrations[ $integration_instance->id ] = $integration_instance;
        }
    }
}
