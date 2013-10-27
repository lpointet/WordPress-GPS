<?php
class GBGPS_Scenario {
    // Array ( hook => array ( num_key => GBGPS_Pointer ) )
    protected $pointers;
    protected $label;
    protected $description;
    private $nb_pointers;
    private $places;

    const STOP = 1;

    /**
     * Constructor: remember the pointers list
     */
    public function __construct($pointers, $label = '', $description = '') {
        $this->pointers = $pointers;
        $this->label = $label;
        $this->description = $description;
        $this->nb_pointers = count($this->pointers);
        $this->places = array();

        $i = 0;
        foreach($this->pointers as $hook => $pointer) {
            $this->places[$hook] = $i++;
        }
    }

    /**
     * Retrieve the current page hook and decide which pointer to show
     */
    public function process($hook, $post_type = NULL) {
        if(empty($this->pointers[$hook])) {
            $hook = 'all';
        }

        $displayed = FALSE;

        if(!empty($this->pointers[$hook])) {
            $displayed = GBGPS_Pointer::process($this->pointers[$hook], $post_type);
        }

        return $displayed && $this->places[$hook] == $this->nb_pointers - 1 ? self::STOP : 0;
    }

    /**
     * Return TRUE or FALSE whether the scenario has something to show on the current page
     */
    public function has_display($hook) {
        return !empty($this->pointers[$hook]) || !empty($this->pointers['all']);
    }

    /**
     * Return the label
     */
    public function get_label() {
        return $this->label;
    }

    /**
     * Return the description
     */
    public function get_description() {
        return $this->description;
    }
}