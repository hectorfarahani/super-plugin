<?php

/**
 * Plugin Name: SPSP
 * Description: SPSP
 * Version:     SPSP
 * Author:      SPSP
 * Text Domain: SPSP
 * Domain Path: /languages
 * License:     GPLv3
 */

namespace SPSP;

use SPSP\Front\Init as Front;
use SPSP\Admin\Init as Admin;
use SPSP\Includes\Assets;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

require_once 'vendor/autoload.php';

register_activation_hook( __FILE__, '\SPSP\SPSP_activation_hook_callback' );

function SPSP_activation_hook_callback() {
	\SPSP\Includes\Init::activate();
}

register_deactivation_hook( __FILE__, '\SPSP\SPSP_deactivation_hook_callback' );

function SPSP_deactivation_hook_callback() {
	\SPSP\Includes\Init::deactivate();
}


Admin::instance();
Assets::instance();
Front::instance();
