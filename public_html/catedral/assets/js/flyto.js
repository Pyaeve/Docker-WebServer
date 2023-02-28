/*!
 * jQuery lightweight Fly to
 * Author: @ElmahdiMahmoud
 * Licensed under the MIT license
 */

// self-invoking
;(function ($, window, document, undefined) {
    $.fn.flyto = function ( options ) {
        
    // Establish default settings
        
        var settings = $.extend({
            item      : '.flyto-item',
            target    : '.flyto-target',
            button    : '.flyto-btn',
            shake     : true
        }, options);
        
        
        return this.each(function () {
            var 
                $this    = $(this),
                flybtn   = $this.find(settings.button),
                target   = $(settings.target),
                itemList = $this.find(settings.item);
            
        flybtn.on('click', function () {
            
            var _this = $(this),
                eltoDrag = _this.parent().parent().parent().find('img').eq(0);
                //alert(eltoDrag.attr('src'));
                
        if (eltoDrag) {
           
            var imgclone = eltoDrag.clone()
                .offset({
                top: eltoDrag.offset().top,
                left: eltoDrag.offset().left
            })
                .css({
                    'opacity': '0.9',
                    'position': 'absolute',
                    'height': eltoDrag.height() /2,
                    'width': eltoDrag.width() /2,
                    'z-index': '1000'
            })
                .appendTo($('body'))
                .animate({
                    'top': target.offset().top - 25,
                    'left': target.offset().left + 25,
                    'height': eltoDrag.height() /2,
                    'width': eltoDrag.width() /2
            }, 2200, 'easeInOutExpo');
             imgclone.animate({
                'width': 0,
                'height': 0
            }, function () {
                $(this).detach()
            });
            if (settings.shake) {
            setTimeout(function () {
                target.effect("shake", {
                    times: 3
                }, 500);
            }, 2000);
            }

    
           
        }
        });
        });
    }
})(jQuery, window, document);