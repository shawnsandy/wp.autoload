/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

//Theme scripts
jQuery(document).ready(function($){

    //add scroll to to page anchors
    //
    $('a[href^="#"]').bind('click.smoothscroll',function (e) {
        e.preventDefault();

        var target = this.hash,
        $target = $(target);

        $('html, body').stop().animate({
            'scrollTop': $target.offset().top
        }, 900, 'swing', function () {
            window.location.hash = target;
        });
    });

    //$('.carousel').carousel()
    $('.bj-tooltip').tooltip();
    //$('#left-nav').scrollspy();

    //add some responsive stuff

    var width = $(window).width();

    if ((width >= 1860)) {

        $('body').addClass('screen-xlarge');

    }else if ((width > 1560)){

        $('body').addClass('screen-large');
    }
    else if((width > 1160)){

        $('body').addClass('screen-medium');
    }
    else if ((width >= 920 )){

        $('body').addClass('screen-default');

    } else if ((width >= 768)){

        $('body').addClass('tablet-portrait');

    }else if ((width >= 420)){

        $('body').addClass('tablet-landscape');

    }else if ((width <= 399)){

        $('body').addClass('mobile-phone');

    }

    $(".info-bar-btn").click(function(){
        $("#info-bar").slideToggle("slow");
        $(this).toggleClass("active");
    })



})

