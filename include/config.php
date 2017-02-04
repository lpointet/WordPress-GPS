<?php
/**
 * Remember plugin path & URL
 */
define('GB_GPS_PATH', plugin_basename( realpath(dirname( __FILE__ ).'/..')  ));
define('GB_GPS_COMPLETE_PATH', WP_PLUGIN_DIR.'/'.GB_GPS_PATH);
define('GB_GPS_URL', WP_PLUGIN_URL.'/'.GB_GPS_PATH);

// Name of the text domain
define('GB_GPS_TEXT_DOMAIN', 'wordpress-gps');