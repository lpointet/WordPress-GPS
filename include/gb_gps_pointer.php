<?php
class GBGPS_Pointer {
    protected $id;
    protected $selector;
    protected $content;
    protected $position;
    protected $post_type;

    /**
     * Constructor: initialize the class variables
     */
    public function __construct($args) {
        $defaults = array(
            'id' => uniqid(),
            'selector' => '',
            'content' => '',
            'position' => '',
            'post_type' => '',
        );

        $args = wp_parse_args($args, $defaults);

        extract($args);

        foreach(array_keys($defaults) as $var) {
            $this->$var = $$var;
        }
    }

    /**
     * Return the args needed by the javascript: selector, content & position
     */
    protected function args() {
        return array(
            'selector' => $this->selector,
            'content' => $this->content,
            'position' => $this->position,
            'post_type' => $this->post_type,
        );
    }

    /**
     * Include the needed JavaScript to show the pointer(s)
     */
    public static function process($pointers, $post_type) {
        $nonce = wp_create_nonce('gb_gps_ajax_nonce');

        $args = array();
        foreach($pointers as $pointer) {
            if( empty( $pointer->post_type ) || $post_type == $pointer->post_type )
                $args[] = $pointer->args();
        }

        if( empty( $args ) )
            return FALSE;

        ?>
        <script type="text/javascript">
        //<![CDATA[
        (function($){
            var options = <?php echo json_encode( $args ); ?>,
                close = function() {
                    $.get(
                        ajaxurl,
                        {action : 'gb_gps_stop_scenario', nonce : '<?php echo esc_js($nonce); ?>'}
                    );
                };

            if ( ! options )
                return;

            var setup = function() {
                    for(var i = 0, l = options.length; i < l; i++) {
                        if(options[i].position && options[i].position.defer_loading)
                            continue;

                        var option = $.extend( options[i], {
                            close: close
                        });
                        $(option.selector).pointer( option ).pointer('open');
                    }
                },
                setup_defer = function() {
                    for(var i = 0, l = options.length; i < l; i++) {
                        if(options[i].position && options[i].position.defer_loading) {
                            var option = $.extend( options[i], {
                                close: close
                            });
                            $(option.selector).pointer( option ).pointer('open');
                        }
                    }
                };

            $(window).bind( 'load.wp-pointers', setup_defer );
            $(document).ready( setup );
        })( jQuery );
        //]]>
        </script>
        <?php

        return TRUE;
    }
}