
$(document).ready(function() {

    /* Nav */
    $('.menu li').mouseenter(function(){
        if ( $(document).width() < 1060 ) return false;
        $(this).find('ul').stop().slideDown(200);
    }).mouseleave(function(){
        if ( $(document).width() < 1060 ) return false;
        $(this).find('ul').stop().slideUp(200);
    });

    /* Nav mobile */
    $('.menu li.toggle').click(function(){
        $(this).siblings('li').slideToggle(200);
    });
    $('.menu li a[href=#]').click(function(e){
        e.preventDefault();
        if ( $(document).width() > 1059 ) return false;
        $(this).parent().find('ul').stop().slideToggle(200);
    });

    $(window).resize(function(){
        if ( $(document).width() > 1059 ) $('.menu li:not(.toggle)').show();
    });

    $('body').removeClass('preload');
    $('.top_msg').click(function() {
        $that = $(this);
        $that.slideUp(500, function() {
            $that.remove();
        });
    });

});