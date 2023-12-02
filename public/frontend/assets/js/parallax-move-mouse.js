;(function ($) {


    $('.pxl-image-parallax .pxl-item--image').each(function () {
        $(this).parents('.elementor-top-section').mousemove(function(e) {
            var el_move = $(this).find('.pxl-image-parallax .pxl-item--image');
            console.log(el_move);
            var el_value = $(this).find('.pxl-image-parallax .pxl-item--image').data('parallax-value');
            pxl_parallax_move(e, el_move, -el_value, $(this));
        });
    });

    function pxl_parallax_move(e, target, movement, section) {

        var relX = e.pageX - section.offset().left;
        
        var relY = e.pageY - section.offset().top;

        TweenMax.to(target, 1, {
            x: (relX - section.width() / 2) / section.width() * movement,
            y: (relY - section.height() / 2) / section.height() * movement
        });
    
    }
    

})(jQuery);