<?php
/*
Plugin Name: Download Attachement After Submission of Contact form
Plugin URI:
Description: Download Attachement After Submission of Contact form , requires Bootstrap 4
Author: Abdallah Ouahib
Version: 1.1.1
Author URI:
Requires : Bootstrap 4
*/

/** Requirement of contact form 7 */
add_action( 'admin_init', 'check_plugin_has_contact_plugin' );
function check_plugin_has_contact_plugin() {
    if ( is_admin() && current_user_can( 'activate_plugins' ) &&  !is_plugin_active( 'contact-form-7/wp-contact-form-7.php' ) ) {
        add_action( 'admin_notices', 'check_plugin_notice' );

        deactivate_plugins( plugin_basename( __FILE__ ) ); 

        if ( isset( $_GET['activate'] ) ) {
            unset( $_GET['activate'] );
        }
    }
}

function check_plugin_notice(){
    ?><div class="error"><p>Sorry, but Download Attachement After Submission of Contact form requires the Contact form 7 Plugin.</p></div><?php
}



include( plugin_dir_path( __FILE__ ) . 'includes/fields/contactfield.php');
include( plugin_dir_path( __FILE__ ) . 'includes/shortcodes/modalbutton.php');
include( plugin_dir_path( __FILE__ ) . 'includes/assets/js/script.php');
include( plugin_dir_path( __FILE__ ) . 'includes/fields/mediafield.php');

