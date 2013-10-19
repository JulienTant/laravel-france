
$(document).ready(function() {

    /* Nav */
    $('.menu li').mouseenter(function(){
        $(this).find('ul').stop(true,false).slideDown(200);
    }).mouseleave(function(){
        $(this).find('ul').stop(true,false).slideUp(200);
    });

    $('body').removeClass('preload');
    $('.top_msg').click(function() {
        $that = $(this);
        $that.slideUp(500, function() {
            $that.remove();
        });
    });

});