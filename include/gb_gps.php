<?php
/**
 * Main class
 */
class GBGPS {
    // Remember the instanciated object
    protected static $instance = NULL;

    // The transient name for remembering the currently played scenario
    const ACTIVE_SCENARIO_TRANSIENT_NAME = 'gb_gps_active_scenario';

    // Default scenarios configuration
    public static $default_scenarios = array(
        // First Scenario
        'gb_gps_add_article_scenario' => array(
            'label' => 'Créer un nouvel article',
            'description' => 'Permet de créer un nouvel article qui sera visible sur votre site.',
            'capabilities' => array('edit_posts'),
            'pointers' => array(
                // Hook
                'all' => array(
                    // Pointers
                    array(
                        'selector' => '#menu-posts',
                        'content' => '<h3>Aller dans le menu "Articles"</h3><p>Il vous suffit de cliquer sur ce menu.</p>',
                        'position' => array(
                            'edge' => 'left',
                            'align' => 'center',
                        ),
                    ),
                ),
                'edit.php' => array(
                    array(
                        'selector' => '.add-new-h2',
                        'content' => '<h3>Ouvrir un nouveau formulaire</h3><p>Cliquer sur le bouton "Ajouter".</p>',
                        'position' => array(
                            'edge' => 'top',
                        ),
                    ),
                ),
            ),
        ),
    );

    // The list of scenarios we got
    protected $scenarios = array();

    /**
     * Constructor
     */
    public function __construct() {
        // register_activation_hook(__FILE__, array(&$this, 'activate'));

        // Add some hooks
        // add_action('admin_menu', array(&$this, 'admin_menu'));
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
     * Activation hook
     */
    public function activate() {
    }

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
     */
    public function admin_enqueue_scripts($hook) {
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
        global $pagenow;

        // Retrieve the current scenario
        $id = get_transient($this->get_transient_name());

        if(FALSE === $id || empty($this->scenarios[$id]))
            return;

        if(GBGPS_Scenario::STOP == $this->scenarios[$id]->process($pagenow)) {
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
}