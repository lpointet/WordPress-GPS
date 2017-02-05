<?php
/*
Plugin Name: WordPress GPS
Plugin URI: https://github.com/lpointet/wordpress-gps
Description: This plugin provides an admin screen to WordPress users in which they will choose one scenario to play. That scenario will help them through the WordPress administration thanks to WP-Pointers API
Version: 1.0.16
Author: Lionel POINTET
Text Domain: wordpress-gps
Domain Path: /language
Author URI: https://github.com/lpointet/
License: GPL2
*/

// Include the config file
require 'include/config.php';

load_plugin_textdomain(GB_GPS_TEXT_DOMAIN, NULL, GB_GPS_PATH . '/language/');

// Include the lang file
require GB_GPS_COMPLETE_PATH . '/include/lang.php';

// Include some needed classes
require GB_GPS_COMPLETE_PATH . '/include/gb_gps_pointer.php';
require GB_GPS_COMPLETE_PATH . '/include/gb_gps_scenario.php';
require GB_GPS_COMPLETE_PATH . '/include/gb_gps.php';

// Include the public API
require GB_GPS_COMPLETE_PATH . '/include/api.php';

// Function triggered to register the default scenarios included with the plugin
function gb_gps_default_scenarios() {
    require GB_GPS_COMPLETE_PATH . '/scenarios.php';

    // Let the other plugins or themes filter the default scenarios configuration so that they can easily delete some (or even all) of them
    $scenarios = apply_filters('gb_gps_default_scenarios', $scenarios);

    foreach($scenarios as $scenario => $config) {
        $pts = array();
        foreach($config['pointers'] as $hook => $pointers) {
            $pts[$hook] = array();
            foreach($pointers as $pt_conf) {
                $pts[$hook][] = gb_gps_create_pointer($pt_conf);
            }
        }

        if(!empty($pts)) {
            $args = array(
                'pointers' => $pts,
                'label' => $config['label'],
                'description' => $config['description'],
                'capabilities' => $config['capabilities'],
            );
            gb_gps_register_scenario($args);
        }
    }
}
add_action('admin_init', 'gb_gps_default_scenarios');

// Let's rock
global $gb_gps;
$gb_gps = GBGPS::get_instance();