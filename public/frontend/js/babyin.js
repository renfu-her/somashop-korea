$(document).ready(function () {

    // Initialize AOS animation
    AOS.init({
        easing: 'ease-out-back',
        duration: 1000
    });

    // Tooltip
    $('[data-toggle="tooltip"]').tooltip();

    
    $('.dropdown-menu a.dropdown-toggle').on('click', function(e) {
        if (!$(this).next().hasClass('show')) {
          $(this).parents('.dropdown-menu').first().find('.show').removeClass("show");
        }
        var $subMenu = $(this).next(".dropdown-menu");
        $subMenu.toggleClass('show');
  
        $(this).parents('li.nav-item.dropdown.show').on('hidden.bs.dropdown', function(e) {
          $('.dropdown-submenu .show').removeClass("show");
        });
  
        return false;
    });



    $('.btn-minus').click(function () {
        var $input = $(this).parent().find('input');
        var count = parseInt($input.val()) - 1;
        count = count < 1 ? 1 : count;
        $input.val(count);
        $input.change();
        return false;
    });
    $('.btn-plus').click(function () {
        var $input = $(this).parent().find('input');
        $input.val(parseInt($input.val()) + 1);
        $input.change();
        return false;
    });



    $('#MessageCarousel').carousel({
        interval: 900000
    })
    
    $('#MessageCarousel').on('slide.bs.carousel', function (e) {
        /*
            CC 2.0 License Iatek LLC 2018 - Attribution required
        */
        var $e = $(e.relatedTarget);
        var idx = $e.index();
        var itemsPerSlide = 5;
        var totalItems = $('#MessageCarousel .carousel-item').length;
     
        if (idx >= totalItems-(itemsPerSlide-1)) {
            var it = itemsPerSlide - (totalItems - idx);
            for (var i=0; i<it; i++) {
                // append slides to end
                if (e.direction=="left") {
                    $('#MessageCarousel .carousel-item').eq(i).appendTo('#MessageCarousel .carousel-inner');
                }
                else {
                    $('#MessageCarousel .carousel-item').eq(0).appendTo('#MessageCarousel .carousel-inner');
                }
            }
        }
    });
      

    $(".touch_table1").on("touchmove", function(){
        $('.hint-touch1').hide(200);
    });


    $(window).scroll(function () {
        if ($(this).scrollTop() > 50) {
            $('#back-to-top').fadeIn();
            $('.floatingIcon').fadeIn();
            $('.btn-pay-group').addClass("show");
        } else {
            $('#back-to-top').fadeOut();
            $('.floatingIcon').fadeOut();
            $('.btn-pay-group').removeClass("show");
        }
    });

    // scroll body to 0px on click
    $('#back-to-top').click(function () {
        $('#back-to-top').tooltip('hide');
        $('body,html').animate({
            scrollTop: 0
        }, 800);
        return false;
    });

    $('#back-to-top').tooltip('show');

});
