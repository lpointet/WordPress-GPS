<?php
/**
 * Register a new scenario in the list of available ones
 *
 * @param   array   $pointers   The list of pointers in the correct order for the scenario
 *
 * @return  bool    $return     TRUE in case of success, FALSE otherwise
 */
function gb_gps_register_scenario($args) {
    global $gb_gps;

    $defaults = array(
        'pointers' => array(),
        'label' => '',
        'description' => '',
        'capabilities' => array(),
    );

    $args = wp_parse_args($args, $defaults);

    extract($args);

    $return = FALSE;

    if(!is_array($capabilities))
        $capabilities = array($capabilities);

    if(!empty($capabilities)) {
        $ok = FALSE;

        // We need at least one of the capabilities to be able to play the scenario
        foreach($capabilities as $cap) {
            if(current_user_can($cap)) {
                $ok = TRUE;
                break;
            }
        }

        if(!$ok)
            return $return;
    }

    $correct_pointers = array();

    // Some sanity checks
    if(!is_array($pointers))
        $pointers = array($pointers);

    foreach($pointers as $hook => $arr_pointer) {
        if(!is_array($arr_pointer))
            $arr_pointer = array($arr_pointer);

        foreach($arr_pointer as $pointer) {
            if($pointer instanceof GBGPS_Pointer) {
                $correct_pointers[$hook][] = $pointer;
            }
        }
    }

    if(!empty($correct_pointers)) {
        // Create the scenario object and add it to the global list
        $scenario = new GBGPS_Scenario($correct_pointers, $label, $description);
        $gb_gps->add_scenario($scenario);
        $return = TRUE;
    }

    return $return;
}