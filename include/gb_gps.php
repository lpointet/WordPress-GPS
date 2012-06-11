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

    // Default scenarios configuration
    public static $default_scenarios = array(
        // Add a post
        'gb_gps_add_post_scenario' => array(
            'label' => 'Créer un nouvel article',
            'description' => 'Permet de créer un nouvel article qui sera visible sur votre site.',
            'capabilities' => array('edit_posts'),
            'pointers' => array(
                // Hook
                'all' => array(
                    // Pointers
                    array(
                        'selector' => '#menu-posts',
                        'content' => '<h3>Aller dans le menu "Articles"</h3><p>Cliquez sur "Articles" afin d\'accéder à la partie correspondante. Vous verrez alors la liste de tous les articles existants.</p>',
                        'position' => array(
                            'edge' => 'top',
                            'align' => 'right',
                        ),
                    ),
                ),
                'edit.php' => array(
                    array(
                        'selector' => '.add-new-h2',
                        'content' => '<h3>Ouvrir un nouveau formulaire</h3><p>Cliquez sur le bouton "Ajouter" afin d\'accéder au formulaire de création d\'un article.</p>',
                        'position' => array(
                            'edge' => 'top',
                            'offset' => '-40 0',
                        ),
                    ),
                ),
            ),
        ),
        // Set a category to a post
        'gb_gps_add_cat_to_post' => array(
            'label' => 'Affecter une catégorie à un article',
            'description' => 'Permet d\'ajouter une liaison entre un article existant et une catégorie.',
            'capabilities' => array('edit_posts'),
            'pointers' => array(
                // Hook
                'all' => array(
                    // Pointers
                    array(
                        'selector' => '#menu-posts',
                        'content' => '<h3>Aller dans le menu "Articles"</h3><p>Cliquez sur "Articles" afin d\'accéder à la partie correspondante. Vous verrez alors la liste de tous les articles existants.</p>',
                        'position' => array(
                            'edge' => 'top',
                            'align' => 'right',
                        ),
                    ),
                ),
                'edit.php' => array(
                    array(
                        'selector' => '#title',
                        'content' => '<h3>Sélectionner un article</h3><p>Cliquez sur le titre de l\'article sur lequel vous souhaitez affecter la catégorie.</p>',
                        'position' => array(
                            'edge' => 'bottom',
                            'align' => 'right',
                            'offset' => '-100 23',
                        ),
                    ),
                ),
                'post.php' => array(
                    array(
                        'selector' => '#categorydiv',
                        'content' => '<h3>Cocher la catégorie</h3><p>Cochez la catégorie que vous voulez affecter à l\'article. Si elle n\'existe pas, vous pouvez en ajouter une nouvelle directement.</p>',
                        'position' => array(
                            'edge' => 'bottom',
                            'offset' => '0 -5',
                        ),
                    ),
                ),
            ),
        ),
        // Add an user
        'gb_gps_add_user' => array(
            'label' => 'Ajouter un nouvel utilisateur',
            'description' => 'Permet d\'ajouter un nouvel utilisateur ayant accès au backoffice de WordPress.',
            'capabilities' => array('edit_users'),
            'pointers' => array(
                // Hook
                'all' => array(
                    // Pointers
                    array(
                        'selector' => '#menu-users',
                        'content' => '<h3>Aller dans le menu "Utilisateurs"</h3><p>Cliquez sur "Utilisateurs" afin d\'accéder à la partie correspondante. Vous verrez alors la liste de tous les utilisateurs existants.</p>',
                        'position' => array(
                            'edge' => 'top',
                            'align' => 'right',
                        ),
                    ),
                ),
                'users.php' => array(
                    array(
                        'selector' => '.add-new-h2',
                        'content' => '<h3>Ouvrir un nouveau formulaire</h3><p>Cliquez sur le bouton "Ajouter" afin d\'accéder au formulaire de création d\'un utilisateur.</p>',
                        'position' => array(
                            'edge' => 'top',
                            'offset' => '-40 0',
                        ),
                    ),
                ),
                'user-new.php' => array(
                    array(
                        'selector' => '#user_login',
                        'content' => '<p>Remplissez le champ "Identifiant".</p>',
                        'position' => array(
                            'edge' => 'left',
                            'offset' => '0 -30',
                        ),
                    ),
                    array(
                        'selector' => '#email',
                        'content' => '<p>Remplissez le champ "E-mail".</p>',
                        'position' => array(
                            'edge' => 'left',
                            'offset' => '0 -30',
                        ),
                    ),
                    array(
                        'selector' => '#pass1',
                        'content' => '<p>Remplissez les champs "Mot de passe".</p>',
                        'position' => array(
                            'edge' => 'left',
                            'offset' => '0 -30',
                        ),
                    ),
                    array(
                        'selector' => '#role',
                        'content' => '<p>Sélectionnez le rôle souhaité pour cet utilisateur.</p>',
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

    /**
     * Add an admin menu page to allow the user to choose the scenario he wants to play
     */
    public function admin_menu() {
        $this->handlePost();
        add_menu_page( 'WordPress GPS', 'GPS', 'edit_posts', self::MENU_SLUG, array(&$this, 'display_admin_menu') );
    }

    /**
     * Handle the post data to launch the wanted scenario
     */
    protected function handlePost() {
        if(!empty($_POST) && wp_verify_nonce($_POST['nonce'], 'gb_gps_nonce')) {
            if(isset($_POST['scenario'])) {
                $this->set_active_scenario($_POST['scenario']);
                $this->message = 'Le scénario a bien été lancé.';
            }
        }
    }

    /**
     * Display the admin panel where the user will choose which scenario will be played
     */
    public function display_admin_menu() {
        // Security check
        if(!current_user_can('edit_posts')) {
            wp_die('Ne refaites jamais ça !');
        }

        require GB_GPS_COMPLETE_PATH . '/include/admin_menu.tpl.php';
    }
}