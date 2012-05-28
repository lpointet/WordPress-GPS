<?php
class GBGPS_Scenario {
    // Array ( hook => array ( num_key => GBGPS_Pointer ) )
    protected $pointers;
    protected $label;

    /**
     * Constructor: remember the pointers list
     */
    public function __construct($pointers, $label = '') {
        $this->pointers = $pointers;
        $this->label = $label;
    }

    /**
     * Retrieve the current page hook and decide which pointer to show
     */
    public function process($hook) {
        if(!empty($this->pointers[$hook])) {
            foreach($this->pointers[$hook] as $pointer) {
                $pointer->show();
            }
        }
    }

    /**
     * Return TRUE or FALSE whether the scenario has something to show on the current page
     */
    public function has_display($hook) {
        return !empty($this->pointers[$hook]);
    }
}