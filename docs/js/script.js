/* Author: J.Kim

*/

$(document).ready(function() {
    // Dropdown example for topbar nav
    // ===============================

    $("body").bind("click", function (e) {
        $('a.menu').parent("li").removeClass("open");
    });

    $("li.menu").hover(function (e) {
        var $li = $(this).toggleClass('open');
        return false;
    }, function (e) {
        $(this).removeClass("open");
    });

    $('.topbar').localScroll();
    $('#contents').localScroll();

    $('#api_key_form').submit(function() {
        var desc = $(this).find('#desc').val();
        if(desc == '') {
            $(this).find('.error').show();
            return false;
        }
    });
});




