<?php
class GBGPS_Pointer {
    protected $id;
    protected $selector;
    protected $content;
    protected $position;

    /**
     * Constructor: initialize the class variables
     */
    public function __construct($args) {
        $defaults = array(
            'id' => uniqid(),
            'selector' => '',
            'content' => '',
            'position' => '',
        );

        $args = wp_parse_args($args, $defaults);

        extract($args);

        foreach(array_keys($defaults) as $var) {
            $this->$var = $$var;
        }
    }

    /**
     * Include the needed JavaScript to show the pointer
     */
    public function show() {
        $args = array(
            'content' => $this->content,
            'position' => $this->position,
        );
        $nonce = wp_create_nonce('gb_gps_ajax_nonce');
        ?>
		<script type="text/javascript">
		//<![CDATA[
		(function($){
			var options = <?php echo json_encode( $args ); ?>, setup;

			if ( ! options )
				return;

			options = $.extend( options, {
				close: function() {
                    $.get(
                        ajaxurl,
                        {action : 'gb_gps_stop_scenario', nonce : '<?php echo esc_js($nonce); ?>'}
                    );
				}
			});

			setup = function() {
				$('<?php echo $this->selector; ?>').pointer( options ).pointer('open');
			};

			if ( options.position && options.position.defer_loading )
				$(window).bind( 'load.wp-pointers', setup );
			else
				$(document).ready( setup );

		})( jQuery );
		//]]>
		</script>
		<?php
    }
}