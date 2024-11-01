<?php
class w2cloud_gcs_media_check extends w2cloud_Abstract_Modules {

    public function __construct() {
        $this->id         = 'gcsMediaCheck';
        $this->template   = dirname( __FILE__ ) . '/template.php';
        add_filter( 'admin_footer', array( $this, 'load_template' ) );
    }

}
