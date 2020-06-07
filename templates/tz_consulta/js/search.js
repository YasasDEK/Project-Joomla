!function ($) {
    "use strict";
    $(document).ready(function(){
        if( $('#tz-position-8').length ) {
            $('#tz-position-8').prepend('<a href="#" class="search-button"><i class="fa fa-search"></i></a>');
        } else {
            $('#tz-megamenu-area').append('<a href="#" class="search-button"><i class="fa fa-search"></i></a>');
        }

        $('.search-button').on('click', function (event) {
            event.preventDefault();
            $('#tz-position-4').addClass('search-box-show');
        })

        $('.close-searchbox').on('click', function (event) {
            event.preventDefault();
            $('#tz-position-4').removeClass('search-box-show');
        })
    });
}(jQuery);