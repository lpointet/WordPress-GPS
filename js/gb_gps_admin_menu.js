(function($) {
    $(function() {
        var descriptions = $('.gb_gps_description');

        $('#gb_gps_select_scenario').change(function()  {
            var val = $(this).val();

            descriptions.addClass('hidden').parent().find('#gb_gps_' + val + '_description').removeClass('hidden');
        });
    });
})(jQuery);