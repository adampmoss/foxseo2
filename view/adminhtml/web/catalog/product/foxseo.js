
require([
    'jquery'
], function ($) {

    $(window).load(toggleProductRedirectSku);

    function toggleProductRedirectSku() {

        if ($('select#foxseo_discontinued').val() == 3)
        {
            $('.field-foxseo_discontinued_product').show()
            $('#foxseo_discontinued_product').addClass('required-entry');
        } else {
            $('.field-foxseo_discontinued_product').hide();
            $('#foxseo_discontinued_product').removeClass('required-entry');
        }

    }

    $(document).ready(function(){
        $('select#foxseo_discontinued').on('change', function() {
            toggleProductRedirectSku();
        });
    });
});
