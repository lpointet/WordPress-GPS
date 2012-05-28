<?php
/**
 * Register a new scenario in the list of available ones
 *
 * @param   array   $pointers   The list of pointers in the correct order for the scenario
 *
 * @return  bool    $return     TRUE in case of success, FALSE otherwise    
 */
function gb_gps_register_scenario($pointers, $label = '') {
    global $gb_gps;

    $args = array();
    $return = FALSE;

    // Some sanity checks
    if(!is_array($pointers))
        $pointers = array($pointers);

    foreach($pointers as $hook => $arr_pointer) {
        if(!is_array($arr_pointer))
            $arr_pointer = array($arr_pointer);

        foreach($arr_pointer as $pointer) {
            if($pointer instanceof GBGPS_Pointer) {
                $args[$hook][] = $pointer;
            }
        }
    }

    if(!empty($args)) {
        // Create the scenario object and add it to the global list
        $scenario = new GBGPS_Scenario($args, $label);
        $gb_gps->add_scenario($scenario);
        $return = TRUE;
    }

    return $return;
}