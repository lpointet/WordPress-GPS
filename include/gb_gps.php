<?php
/**
 * Main class
 */
class GBGPS {
    // Remember the instanciated object
    protected static $instance = NULL;

    // The transient name for remembering the currently played scenario
    const ACTIVE_SCENARIO_TRANSIENT_NAME = 'gb_gps_active_scenario';

    // The admin menu slug
    const MENU_SLUG = 'gb_gps_launch_scenario';

    // The list of scenarios we got
    protected $scenarios = array();

    /**
     * Constructor
     */
    public function __construct() {
        // Add some hooks
        add_action('admin_menu', array(&$this, 'admin_menu'));
        add_action('admin_print_footer_scripts', array(&$this, 'play_scenario'));
        add_action('admin_enqueue_scripts', array(&$this, 'admin_enqueue_scripts'));
        add_action('wp_ajax_gb_gps_stop_scenario', array(&$this, 'stop_scenario'));
    }

    /**
     * Return an instance of the class only if we are on the admin side
     */
    public static function get_instance() {
        if(is_admin() && !self::$instance) {
            self::$instance = new GBGPS();
        }

        return self::$instance;
    }

    /**
     * Return the transient's name to store the current scenario for a user
     * We don't use user meta because of the expiration functionality => we don't want the scenario is played forever
     */
    protected function get_transient_name() {
        // Get the current user
        $user = wp_get_current_user();

        // Append its ID with the transient name
        return $user->ID . '_' . self::ACTIVE_SCENARIO_TRANSIENT_NAME;
    }

    /**
     * Remember the currently played scenario, saving a transient
     */
    public function set_active_scenario($id = NULL) {
        if(NULL === $id) {
            delete_transient($this->get_transient_name());
        }
        else
            set_transient($this->get_transient_name(), $id, 600);
    }

    /**
     * Include the needed WordPress scripts to display pointers on the right pages
     * Include the admin panel script when needed
     */
    public function admin_enqueue_scripts($hook) {
        if('toplevel_page_' . self::MENU_SLUG === $hook) {
            wp_enqueue_script('gb_gps_admin_menu', GB_GPS_URL . '/js/gb_gps_admin_menu.js', array('jquery'));
        }

        // Retrieve the current scenario
        $id = get_transient($this->get_transient_name());

        if(FALSE === $id || empty($this->scenarios[$id]))
            return;

        if($this->scenarios[$id]->has_display($hook)) {
            // Add pointers script and style to queue
            wp_enqueue_style( 'wp-pointer' );
            wp_enqueue_script( 'wp-pointer' );
        }
    }

    /**
     * Activate pointers if we are currently playing a scenario
     */
    public function play_scenario() {
        global $pagenow, $typenow;

        // Retrieve the current scenario
        $id = get_transient($this->get_transient_name());

        if(FALSE === $id || empty($this->scenarios[$id]))
            return;

        if(GBGPS_Scenario::STOP == $this->scenarios[$id]->process($pagenow, $typenow)) {
            $this->set_active_scenario();
        }
    }

    /**
     * Add a new scenario to the list
     */
    public function add_scenario($scenario) {
        $this->scenarios[] = $scenario;
    }

    /**
     * AJAX function called to stop the currently played scenario
     */
    public function stop_scenario() {
        // Check to see if the submitted nonce matches with the generated nonce we created earlier (see lib.php)
        if ( ! wp_verify_nonce( $_REQUEST['nonce'], 'gb_gps_ajax_nonce' ) )
            die('Busted!');

        // Reset the scenario
        $this->set_active_scenario();

        header('HTTP/1.1 204 No Content');
        exit;
    }

    /**
     * Add an admin menu page to allow the user to choose the scenario he wants to play
     */
    public function admin_menu() {
        $this->handlePost();
        add_menu_page( GB_GPS_ADMIN_MENU_PAGE_TITLE, GB_GPS_ADMIN_MENU_MENU_TITLE, 'read', self::MENU_SLUG, array(&$this, 'display_admin_menu') );
    }

    /**
     * Handle the post data to launch the wanted scenario
     */
    protected function handlePost() {
        global $plugin_page;

        if(self::MENU_SLUG == $plugin_page && !empty($_POST) && check_admin_referer('gb_gps_nonce', 'nonce')) {
            if(isset($_POST['scenario'])) {
                $this->set_active_scenario($_POST['scenario']);
                $this->message = GB_GPS_MESSAGE_LAUNCHED_SCENARIO;
            }
        }
    }

    /**
     * Display the admin panel where the user will choose which scenario will be played
     */
    public function display_admin_menu() {
        // Security check
        if(!current_user_can('read')) {
            wp_die(GB_GPS_MESSAGE_CAPABILITY_ERROR);
        }

        require GB_GPS_COMPLETE_PATH . '/include/admin_menu.tpl.php';
    }
}