(function(window, $) {

    // USE STRICT
    "use strict";

    var hmlsColl = document.getElementsByClassName("hmls-collapsible");
    var i;

    for (i = 0; i < hmlsColl.length; i++) {
        hmlsColl[i].addEventListener("click", function() {
            this.classList.toggle("active");
            var content = this.nextElementSibling;
            if (content.style.maxHeight) {
                content.style.maxHeight = null;
            } else {
                content.style.maxHeight = content.scrollHeight + "px";
            }
        });
    }

})(window, jQuery);