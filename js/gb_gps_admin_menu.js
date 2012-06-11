(function($) {
    $(function() {
        var descriptions = $('.gb_gps_description');

        $('#gb_gps_select_scenario').change(function()  {
            descriptions.addClass('hidden').parent().find('#gb_gps_' + $(this).val() + '_description').removeClass('hidden');
        });
    });
})(jQuery);