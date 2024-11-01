<?php
class w2cloud_compatibility extends w2cloud_Abstract_Modules {

    public function __construct() {
        $this->id         = 'compatibility';
        $this->template   = dirname( __FILE__ ) . '/template.php';
        add_filter( 'admin_footer', array( $this, 'load_template' ) );
    }

}
