(function($) {

    // USE STRICT
    "use strict";

    var hmlsColorPicker = ['#hmls_background_color', '#hmls_message_color', '#hmls_button_color', '#hmls_button_text_color'];

    $.each(hmlsColorPicker, function(index, value) {
        $(value).wpColorPicker();
    });

    $('.hmls-closebtn').on('click', function() {
        this.parentElement.style.display = 'none';
    });

})(jQuery);