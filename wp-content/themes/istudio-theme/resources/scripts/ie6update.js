﻿/**
 *
   IE6Update.js
   
 * IE6Update is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; version 3 of the License.
 *
 * IE6Update is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Activebar2; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * * * * * * * * * * * *
 * 
 * This is code is derived from Activebar2
 *
 * Activebar2 is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; version 3 of the License.
 *
 * Activebar2 is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Activebar2; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * You may contact the author by mail: jakob@php.net
 * 
 * Or write to:
 * Jakob Westhoff
 * Kleiner Floraweg 35
 * 44229 Dortmund
 * Germany
 *
 * The latest version of ActiveBar can be obtained from:
 * http://www.westhoffswelt.de/
 *
 * @package Core
 * @version $Revision$
 * @license http://www.gnu.org/licenses/gpl-3.0.txt GPL
 */
try {
  document.execCommand("BackgroundImageCache", true, true);
} catch(err) {}
if(window.__noconflict){ jQuery.noConflict();} 
(function($) {
    $.fn.activebar = function( options ) {
        options = $.fn.extend( {}, $.fn.activebar.defaults, options );
        if ( $.fn.activebar.container === null ) {
            $.fn.activebar.container = initializeActivebar( options );
        }
        setOptionsOnContainer( $.fn.activebar.container, options );
        $.fn.activebar.hide();
        $( '.content', $.fn.activebar.container ).empty();
        $(this).each( function() {
            $( '.content', $.fn.activebar.container ).append( this );
        });
        $.fn.activebar.container.unbind( 'click' );
        if( options.url !== null ) {
            $.fn.activebar.container.click( 
                function() {
                    window.location.href = options.url;
                }
            );
        }
        $.fn.activebar.container.css( 'top', '-' + $.fn.activebar.container.height() + 'px' );
        if(options.preload){
          var load = {a:0, b:0, c:0, d:0}          
          function preloadInit(){
            if(load.a && load.b && load.c && load.d){
              $.fn.activebar.show();
            }
          }
          $('<img src="'+options.icons_path+'icon.png" class="normal">').load(function(){load.a=1; preloadInit()});
          $('<img src="'+options.icons_path+'icon-over.png" class="normal">').load(function(){load.b=1; preloadInit()});
          $('<img src="'+options.icons_path+'close.png" class="normal">').load(function(){load.c=1; preloadInit()});
          $('<img src="'+options.icons_path+'close-over.png" class="normal">').load(function(){load.d=1; preloadInit()});
        }else{
          $.fn.activebar.show();
        }
    };
    $.fn.activebar.defaults = {
        'background': '#ffffe1',
        'border': '#666', 
        'highlight': '#3399ff',
        'font': 'Bitstream Vera Sans,verdana,sans-serif',
        'fontColor': 'InfoText',
        'fontSize': '11px',
        'icons_path' : 'ie6upimg/',
        'url': 'http://www.microsoft.com/windows/internet-explorer/default.aspx',
        'preload': true
    };
    $.fn.activebar.state = 0;
    $.fn.activebar.container = null;
    $.fn.activebar.show = function() {
        if ( $.fn.activebar.state > 1 ) {
            return;
        }
        $.fn.activebar.state = 2;
        $.fn.activebar.container.css( 'display', 'block' );
        var height = $.fn.activebar.container.height();
        $.fn.activebar.container.animate({
            'top': '+=' + height + 'px' 
        }, height * 20, 'linear', function() {
            $.fn.activebar.state = 3;
        });
    };
    $.fn.activebar.hide = function() {
        if ( $.fn.activebar.state < 2 ) {
            return;
        }
        $.fn.activebar.state = 1;
        var height   = $.fn.activebar.container.height();
        $.fn.activebar.container.animate({
            'top': '-=' + height + 'px' 
        }, height * 20, 'linear', function() {
            $.fn.activebar.container.css( 'display', 'none' );
            $.fn.activebar.visible = false;
        });
    };
     function initializeActivebar( options ) {
        var container = $( '<div></div>' ).attr( 'id', 'activebar-container' );
        container.css({
          'display': 'none',
          'position': 'fixed',
          'zIndex': '9999',
          'top': '0px',
          'left': '0px',            
          'cursor': 'default',
          'padding': '4px',
          'font-size' : '9px',
					'text-align':'left',
          'background': options.background,
          'borderBottom': '1px solid ' + options.border,
          'color': options.fontColor
        });
        $(window).bind( 'resize', function() {
            container.width( $(this).width() );
        });
        $(window).trigger( 'resize' );
        if ( $.browser.msie && ( $.browser.version.substring( 0, 1 ) == '5' || $.browser.version.substring( 0, 1 ) == '6' ) ) {
            container.css( 'position', 'absolute' );
            $( window ).scroll(
                function() {
                    container.stop( true, true );
                    if ( $.fn.activebar.state == 3 ) {
                      container.css( 'top', $( window ).scrollTop() + 'px' );
                    }
                    else {
                      container.css( 'top', ( $( window ).scrollTop() - container.height() ) + 'px' );
                    }
                }
            ).resize(function(){$(window).scroll();}); 
        }
        container.append( 
          $( '<div></div>' ).attr( 'class', 'icon' )
          .css({
            'float': 'left',
            'width': '16px',
            'height': '16px',
            'margin': '0 4px 0 0',
            'padding': '0'
          })
          .append('<img src="'+options.icons_path+'icon.png" class="normal">')
          .append('<img src="'+options.icons_path+'icon-over.png" class="hover">')
        );
        container.append( 
          $( '<div></div>' ).attr( 'class', 'close' )
          .css({
            'float': 'right',
            'margin': '0 5px 0 0 ',
            'width': '16px',
            'height': '16px'
          })
          .click(function(event) {
                $.fn.activebar.hide();
                event.stopPropagation();
          }) 
          .append('<img src="'+options.icons_path+'close.png" class="normal">')
          .append('<img src="'+options.icons_path+'close-over.png" class="hover">')
        );
        container.append( 
          $( '<div></div>' ).attr( 'class', 'content' )
          .css({
            'margin': '0px 8px',
            'paddingTop': '1px'
          })
        );
        $('.hover', container).hide();
        $('body').prepend( container );
        return container;
     };
     function setOptionsOnContainer( container, options ) {
        container.unbind( 'mouseenter mouseleave' );
        container.hover( 
            function() {
                $(this).css({backgroundColor: options.highlight, color: "#FFFFFF"}).addClass('hover');
                $('.hover', container).show();
                $('.normal', container).hide();
            },
            function() {
                $(this).css( {'backgroundColor': options.background, color: "#000000"} ).removeClass('hover');
                $('.hover', container).hide();
                $('.normal', container).show();
            }
        );
        $( '.content', container ).css({
            'fontFamily': options.font,
            'fontSize': options.fontSize
        });                                      
     }
})(jQuery);
jQuery(document).ready(function($) {
  $('<div></div>').html(IE6UPDATE_OPTIONS.message || 'Internet Explorer is missing updates required to view this site. Click here to update... ')
  .activebar(window.IE6UPDATE_OPTIONS);
});