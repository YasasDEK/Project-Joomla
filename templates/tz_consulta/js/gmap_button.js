!function ($,window) {
    "use strict";
    window.gmap_button = function (id) {
        $('.main-container').prepend($('#sppb-addon-map-'+id));
        $('#sppb-addon-gbutton-'+id).on('click', function (event) {
            event.preventDefault();
            $('#sppb-addon-map-'+id).slideToggle({
                duration: 400
            })
        })
    }

}(jQuery,window);