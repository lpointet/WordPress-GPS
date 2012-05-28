<?php
/*
Plugin Name: WordPress GPS
Plugin URI: http://www.globalis-ms.com
Description: This plugin Provide an admin screen to WordPress users in which they will choose one scenario to play. That scenario will help them through the WordPress administration thanks to WP-Pointers API
Version: 1.0.0
Author: Lionel POINTET, GLOBALIS media systems
Author URI: http://www.globalis-ms.com
License: GPL2
*/

// Include the config file
require 'include/config.php';

// Include some needed classes
require GB_GPS_COMPLETE_PATH . '/include/gb_gps_pointer.php';
require GB_GPS_COMPLETE_PATH . '/include/gb_gps_scenario.php';
require GB_GPS_COMPLETE_PATH . '/include/gb_gps.php';

// Include the public API
require GB_GPS_COMPLETE_PATH . '/include/api.php';

// Function triggered to register the default scenarios included with the plugin
function gb_gps_default_scenarios() {
    // Let the other plugins or themes filter the default scenarios configuration so that they can easily delete some (or even all) of them
    $scenarios = apply_filters('gb_gps_default_scenarios', GBGPS::$default_scenarios);

    foreach($scenarios as $scenario => $config) {
        $pts = array();
        foreach($config['pointers'] as $hook => $pointers) {
            $pts[$hook] = array();
            foreach($pointers as $pt_conf) {
                $pts[$hook][] = new GBGPS_Pointer($pt_conf);
            }
        }

        if(!empty($pts)) {
            gb_gps_register_scenario($pts, $config['label']);
        }
    }
}
add_action('init', 'gb_gps_default_scenarios');

// Let's rock
global $gb_gps;
$gb_gps = GBGPS::get_instance();