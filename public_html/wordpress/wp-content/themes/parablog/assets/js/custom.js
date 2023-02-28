jQuery(function($) {

    /* -----------------------------------------
    Preloader
    ----------------------------------------- */
    $('#preloader').delay(1000).fadeOut();
    $('#loader').delay(1000).fadeOut("slow");

    /* -----------------------------------------
    Navigation
    ----------------------------------------- */
    $('.menu-toggle').click(function() {
        $(this).toggleClass('open');
    });

    $('.header-search-wrap').find(".search-submit").bind('keydown', function(e) {
        var tabKey = e.keyCode === 9;
        if (tabKey) {
            e.preventDefault();
            $('.header-search-icon').focus();
        }
    });

    $('.header-search-icon').on('keydown', function(e) {
        var tabKey = e.keyCode === 9;
        var shiftKey = e.shiftKey;
        if ($('.header-search-wrap').hasClass('show')) {
            if (shiftKey && tabKey) {
                e.preventDefault();
                $('.header-search-wrap').removeClass('show');
                $('.header-search-icon').focus();
            }
        }
    });

    /* -----------------------------------------
    Sticky Header
    ----------------------------------------- */
    const body = document.querySelector('body');
    const header = document.querySelector('.mobile-header-bottom');
    window.onscroll = function() {
        if (window.pageYOffset > 45) {
            header.classList.add('fix-header');
            body.classList.add('fix-header-added');
        } else {
            header.classList.remove('fix-header');
            body.classList.remove('fix-header-added');
        }
    };
    $(document).ready(function() {
        var divHeight = $('.mobile-header-bottom').height();
        $('.mobile-header-bottom-outer').css('min-height', divHeight + 'px');
    });

    /* -----------------------------------------
    Keyboard Navigation
    ----------------------------------------- */
    $(window).on('load resize', function() {
        if ($(window).width() < 1200) {
            $('.main-navigation').find("li").last().bind('keydown', function(e) {
                if (e.which === 9) {
                    e.preventDefault();
                    $('#masthead').find('.menu-toggle').focus();
                }
            });
        } else {
            $('.main-navigation').find("li").unbind('keydown');
        }
    });

    var primary_menu_toggle = $('#masthead .menu-toggle');
    primary_menu_toggle.on('keydown', function(e) {
        var tabKey = e.keyCode === 9;
        var shiftKey = e.shiftKey;

        if (primary_menu_toggle.hasClass('open')) {
            if (shiftKey && tabKey) {
                e.preventDefault();
                $('.main-navigation').toggleClass('toggled');
                primary_menu_toggle.removeClass('open');
            };
        }
    });

    $('.header-search-wrap').find(".search-submit").bind('keydown', function(e) {
        var tabKey = e.keyCode === 9;
        if (tabKey) {
            e.preventDefault();
            $('.header-search-icon').focus();
        }
    });

    $('.header-search-icon').on('keydown', function(e) {
        var tabKey = e.keyCode === 9;
        var shiftKey = e.shiftKey;
        if ($('.header-search-wrap').hasClass('show')) {
            if (shiftKey && tabKey) {
                e.preventDefault();
                $('.header-search-wrap').removeClass('show');
                $('.header-search-icon').focus();
            }
        }
    });
    
    /* -----------------------------------------
    Search
    ----------------------------------------- */
    var searchWrap = $('.header-search-wrap');
    $(".header-search-icon").click(function(e) {
        e.preventDefault();
        searchWrap.toggleClass("show");
        searchWrap.find('input.search-field').focus();
    });
    $(document).click(function(e) {
        if (!searchWrap.is(e.target) && !searchWrap.has(e.target).length) {
            $(".header-search-wrap").removeClass("show");
        }
    });

    /* -----------------------------------------
    Main Slider
    ----------------------------------------- */
    $('.banner-style-2 .banner-slider').slick({
        autoplaySpeed: 3000,
        dots: false,
        arrows: true,
        centerMode: true,
        centerPadding: '350px',
        slidesToShow: 1,
        nextArrow: '<span class="fas fa-angle-right slick-next"></span>',
        prevArrow: '<span class="fas fa-angle-left slick-prev"></span>',
        responsive: [
            {
                breakpoint: 1300,
                settings: {
                    centerPadding: '50px',
                    slidesToShow: 1,
                }
            },
            {
                breakpoint: 1025,
                settings: {
                    centerPadding: '50px',
                    slidesToShow: 1,
                }
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 1,
                    centerMode: false,
                    arrows: false,
                    dots: true,
                }
            }
        ]
    });
    
    /* -----------------------------------------
    post Slider
    ----------------------------------------- */
    $('.post-slider ').slick({
        autoplay: false,
        autoplaySpeed: 3000,
        dots: false,
        arrows: true,
        adaptiveHeight: true,
        nextArrow: '<span class="fas fa-angle-right slick-next"></span>',
        prevArrow: '<span class="fas fa-angle-left slick-prev"></span>',
    });
    /* -----------------------------------------
    trending carousel
    ----------------------------------------- */
    $('.trending-carousel ').slick({
        slidesToShow: 5,
        slidesToScroll: 1,
        autoplay: true,
        infinite: true,
        loop: true,
        vertical: true,
        verticalSwiping: true,
        dots: false,
        prevArrow: false,
        nextArrow: false,
    });

    /* -----------------------------------------
    Scroll Top
    ----------------------------------------- */
    var scrollToTopBtn = $('.parablog-scroll-to-top');

    $(window).scroll(function() {
        if ($(window).scrollTop() > 400) {
            scrollToTopBtn.addClass('show');
        } else {
            scrollToTopBtn.removeClass('show');
        }
    });

    scrollToTopBtn.on('click', function(e) {
        e.preventDefault();
        $('html, body').animate({
            scrollTop: 0
        }, '300');
    });

    /* -----------------------------------------
    Parallax
    ----------------------------------------- */
    if ( $("body").hasClass("parallax-body") ){
        var image = document.getElementsByClassName('blog-parallax');
        new simpleParallax(image, {
            scale: 1.5,
            delay: 0.4,
        });
    }
});