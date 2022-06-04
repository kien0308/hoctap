<?php
/*
Plugin Name: Contact Form 7 Cost Calculator - Price Calculation
Plugin URI: https://codecanyon.net/user/rednumber/portfolio
Description: Create forms with field values calculated based in other form field values for contact form 7
Author: Rednumber
Version: 1.6
Author URI: https://codecanyon.net/user/rednumber/portfolio
*/
if ( !function_exists( 'add_action' ) ) {
    echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
    exit;
}
define( 'CT_7_COST_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'CT_7_COST_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'CT_7_COST_TEXT_DOMAIN', "cf7_cost" );

/*
* Include pib
*/
if ( in_array( 'contact-form-7/wp-contact-form-7.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
    include CT_7_COST_PLUGIN_PATH."backend/index.php";
    include CT_7_COST_PLUGIN_PATH."frontend/index.php";
}
/*
* Check plugin contact form 7
*/
class cf7_cost_init {
    function __construct(){
       add_action('admin_notices', array($this, 'on_admin_notices' ) );
    }
    function on_admin_notices(){
        if ( !in_array( 'contact-form-7/wp-contact-form-7.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
            echo '<div class="error"><p>' . __('Plugin need active plugin Contact Form 7', CT_7_COST_TEXT_DOMAIN) . '</p></div>';
        }
    }
}
new cf7_cost_init;