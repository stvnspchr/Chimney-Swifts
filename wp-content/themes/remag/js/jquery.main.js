/*global jQuery */
/*jshint multistr:true browser:true */
/*!
* FitVids 1.0
*
* Copyright 2011, Chris Coyier - http://css-tricks.com + Dave Rupert - http://daverupert.com
* Credit to Thierry Koblentz - http://www.alistapart.com/articles/creating-intrinsic-ratios-for-video/
* Released under the WTFPL license - http://sam.zoy.org/wtfpl/
*
* Date: Thu Sept 01 18:00:00 2011 -0500
*/

(function( $ ){

  "use strict";

  $.fn.fitVids = function( options ) {
    var settings = {
      customSelector: null
    };

    if(!document.getElementById('fit-vids-style')) {

      var div = document.createElement('div'),
          ref = document.getElementsByTagName('base')[0] || document.getElementsByTagName('script')[0];

      div.className = 'fit-vids-style';
      div.id = 'fit-vids-style';
      div.style.display = 'none';
      div.innerHTML = '&shy;<style>         \
        .fluid-width-video-wrapper {        \
           width: 100%;                     \
           position: relative;              \
           padding: 0;                      \
        }                                   \
                                            \
        .fluid-width-video-wrapper iframe,  \
        .fluid-width-video-wrapper object,  \
        .fluid-width-video-wrapper embed {  \
           position: absolute;              \
           top: 0;                          \
           left: 0;                         \
           width: 100%;                     \
           height: 100%;                    \
        }                                   \
      </style>';

      ref.parentNode.insertBefore(div,ref);

    }

    if ( options ) {
      $.extend( settings, options );
    }

    return this.each(function(){
      var selectors = [
        "iframe[src*='player.vimeo.com']",
        "iframe[src*='youtube.com']",
        "iframe[src*='youtube-nocookie.com']",
        "iframe[src*='kickstarter.com'][src*='video.html']",
        "object",
        "embed"
      ];

      if (settings.customSelector) {
        selectors.push(settings.customSelector);
      }

      var $allVideos = $(this).find(selectors.join(','));
      $allVideos = $allVideos.not("object object"); // SwfObj conflict patch

      $allVideos.each(function(){
        var $this = $(this);
        if (this.tagName.toLowerCase() === 'embed' && $this.parent('object').length || $this.parent('.fluid-width-video-wrapper').length) { return; }
        var height = ( this.tagName.toLowerCase() === 'object' || ($this.attr('height') && !isNaN(parseInt($this.attr('height'), 10))) ) ? parseInt($this.attr('height'), 10) : $this.height(),
            width = !isNaN(parseInt($this.attr('width'), 10)) ? parseInt($this.attr('width'), 10) : $this.width(),
            aspectRatio = height / width;
        if(!$this.attr('id')){
          var videoID = 'fitvid' + Math.floor(Math.random()*999999);
          $this.attr('id', videoID);
        }
        $this.wrap('<div class="fluid-width-video-wrapper"></div>').parent('.fluid-width-video-wrapper').css('padding-top', (aspectRatio * 100)+"%");
        $this.removeAttr('height').removeAttr('width');
      });
    });
  };
})( jQuery );


/*! Copyright (c) 2013 Brandon Aaron (http://brandonaaron.net)
 * Licensed under the MIT License (LICENSE.txt).
 *
 * Thanks to: http://adomas.org/javascript-mouse-wheel/ for some pointers.
 * Thanks to: Mathias Bank(http://www.mathias-bank.de) for a scope bug fix.
 * Thanks to: Seamus Leahy for adding deltaX and deltaY
 *
 * Version: 3.1.3
 *
 * Requires: 1.2.2+
 */

(function (factory) {
    if ( typeof define === 'function' && define.amd ) {
        // AMD. Register as an anonymous module.
        define(['jquery'], factory);
    } else if (typeof exports === 'object') {
        // Node/CommonJS style for Browserify
        module.exports = factory;
    } else {
        // Browser globals
        factory(jQuery);
    }
}(function ($) {

    var toFix = ['wheel', 'mousewheel', 'DOMMouseScroll', 'MozMousePixelScroll'];
    var toBind = 'onwheel' in document || document.documentMode >= 9 ? ['wheel'] : ['mousewheel', 'DomMouseScroll', 'MozMousePixelScroll'];
    var lowestDelta, lowestDeltaXY;

    if ( $.event.fixHooks ) {
        for ( var i = toFix.length; i; ) {
            $.event.fixHooks[ toFix[--i] ] = $.event.mouseHooks;
        }
    }

    $.event.special.mousewheel = {
        setup: function() {
            if ( this.addEventListener ) {
                for ( var i = toBind.length; i; ) {
                    this.addEventListener( toBind[--i], handler, false );
                }
            } else {
                this.onmousewheel = handler;
            }
        },

        teardown: function() {
            if ( this.removeEventListener ) {
                for ( var i = toBind.length; i; ) {
                    this.removeEventListener( toBind[--i], handler, false );
                }
            } else {
                this.onmousewheel = null;
            }
        }
    };

    $.fn.extend({
        mousewheel: function(fn) {
            return fn ? this.bind("mousewheel", fn) : this.trigger("mousewheel");
        },

        unmousewheel: function(fn) {
            return this.unbind("mousewheel", fn);
        }
    });


    function handler(event) {
        var orgEvent = event || window.event,
            args = [].slice.call(arguments, 1),
            delta = 0,
            deltaX = 0,
            deltaY = 0,
            absDelta = 0,
            absDeltaXY = 0,
            fn;
        event = $.event.fix(orgEvent);
        event.type = "mousewheel";

        // Old school scrollwheel delta
        if ( orgEvent.wheelDelta ) { delta = orgEvent.wheelDelta; }
        if ( orgEvent.detail )     { delta = orgEvent.detail * -1; }

        // New school wheel delta (wheel event)
        if ( orgEvent.deltaY ) {
            deltaY = orgEvent.deltaY * -1;
            delta  = deltaY;
        }
        if ( orgEvent.deltaX ) {
            deltaX = orgEvent.deltaX;
            delta  = deltaX * -1;
        }

        // Webkit
        if ( orgEvent.wheelDeltaY !== undefined ) { deltaY = orgEvent.wheelDeltaY; }
        if ( orgEvent.wheelDeltaX !== undefined ) { deltaX = orgEvent.wheelDeltaX * -1; }

        // Look for lowest delta to normalize the delta values
        absDelta = Math.abs(delta);
        if ( !lowestDelta || absDelta < lowestDelta ) { lowestDelta = absDelta; }
        absDeltaXY = Math.max(Math.abs(deltaY), Math.abs(deltaX));
        if ( !lowestDeltaXY || absDeltaXY < lowestDeltaXY ) { lowestDeltaXY = absDeltaXY; }

        // Get a whole value for the deltas
        fn = delta > 0 ? 'floor' : 'ceil';
        delta  = Math[fn](delta / lowestDelta);
        deltaX = Math[fn](deltaX / lowestDeltaXY);
        deltaY = Math[fn](deltaY / lowestDeltaXY);

        // Add event and delta to the front of the arguments
        args.unshift(event, delta, deltaX, deltaY);

        return ($.event.dispatch || $.event.handle).apply(this, args);
    }

}));

/*
  SlidesJS 3.0.3

  Documentation and examples http://slidesjs.com
  Support forum http://groups.google.com/group/slidesjs
  Created by Nathan Searles http://nathansearles.com

  Version: 3.0.3
  Updated: March 15th, 2013

  SlidesJS is an open source project, contribute at GitHub:
  https://github.com/nathansearles/Slides

  (c) 2013 by Nathan Searles

  Licensed under the Apache License, Version 2.0 (the "License");
  you may not use this file except in compliance with the License.
  You may obtain a copy of the License at

  http://www.apache.org/licenses/LICENSE-2.0

  Unless required by applicable law or agreed to in writing, software
  distributed under the License is distributed on an "AS IS" BASIS,
  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
  See the License for the specific language governing permissions and
  limitations under the License.
*/
(function() {

  (function($, window, document) {
    var Plugin, defaults, pluginName;
    pluginName = "slidesjs";
    defaults = {
      width: 940,
      height: 528,
      start: 1,
      navigation: {
        active: true,
        effect: "slide"
      },
      pagination: {
        active: true,
        effect: "slide"
      },
      play: {
        active: false,
        effect: "slide",
        interval: 5000,
        auto: false,
        swap: true,
        pauseOnHover: false,
        restartDelay: 2500
      },
      effect: {
        slide: {
          speed: 500
        },
        fade: {
          speed: 300,
          crossfade: true
        }
      },
      callback: {
        loaded: function() {},
        start: function() {},
        complete: function() {}
      }
    };
    Plugin = (function() {

      function Plugin(element, options) {
        this.element = element;
        this.options = $.extend(true, {}, defaults, options);
        this._defaults = defaults;
        this._name = pluginName;
        this.init();
      }

      return Plugin;

    })();
    Plugin.prototype.init = function() {
      var $element, nextButton, pagination, playButton, prevButton, stopButton,
        _this = this;
      $element = $(this.element);
      this.data = $.data(this);
      $.data(this, "animating", false);
      $.data(this, "total", $element.children().not(".slidesjs-navigation", $element).length);
      $(window).bind("resize", function() {
         this.data = $.data(this);
         $.data(this, "total", $("#content article").length);
         //alert(this.data.total);
      });
      //$.data(this, "total", 100); // custom added to fulfill gpp needs
      $.data(this, "current", this.options.start - 1);
      $.data(this, "vendorPrefix", this._getVendorPrefix());
      if (typeof TouchEvent !== "undefined") {
        $.data(this, "touch", true);
        this.options.effect.slide.speed = this.options.effect.slide.speed / 2;
      }
      $element.css({
        overflow: "hidden"
      });
      $element.slidesContainer = $element.children().not(".slidesjs-navigation", $element).wrapAll("<div class='slidesjs-container'>", $element).parent().css({
        position: "relative"
      });
      $(".slidesjs-container", $element).wrapInner("<div class='slidesjs-control'>", $element).children();
      $(".slidesjs-control", $element).css({
        position: "relative",
        left: 0
      });
      $(".slidesjs-control", $element).children().addClass("slidesjs-slide").css({
        position: "absolute",
        top: 0,
        left: 0,
        width: "100%",
        zIndex: 0,
        display: "none",
        webkitBackfaceVisibility: "hidden"
      });
      $.each($(".slidesjs-control", $element).children(), function(i) {
        var $slide;
        $slide = $(this);
        return $slide.attr("slidesjs-index", i);
      });
      if (this.data.touch) {
        $(".slidesjs-control", $element).on("touchstart", function(e) {
          return _this._touchstart(e);
        });
        $(".slidesjs-control", $element).on("touchmove", function(e) {
          return _this._touchmove(e);
        });
        $(".slidesjs-control", $element).on("touchend", function(e) {
          return _this._touchend(e);
        });
      }
      $element.fadeIn(0);
      this.update();
      if (this.data.touch) {
        this._setuptouch();
      }
      $(".slidesjs-control", $element).children(":eq(" + this.data.current + ")").eq(0).fadeIn(0, function() {
        return $(this).css({
          zIndex: 10
        });
      });
      if (this.options.navigation.active) {
        prevButton = $("<a>", {
          "class": "slidesjs-previous slidesjs-navigation",
          href: "#",
          title: "Previous",
          text: ""
        }).appendTo($element);
        nextButton = $("<a>", {
          "class": "slidesjs-next slidesjs-navigation",
          href: "#",
          title: "Next",
          text: ""
        }).appendTo($element);
      }
      $(".slidesjs-next", $element).click(function(e) {
        e.preventDefault();
        _this.stop(true);
        return _this.next(_this.options.navigation.effect);
      });
      $(".slidesjs-previous", $element).click(function(e) {
        e.preventDefault();
        _this.stop(true);
        return _this.previous(_this.options.navigation.effect);
      });
      if (this.options.play.active) {
        playButton = $("<a>", {
          "class": "slidesjs-play slidesjs-navigation",
          href: "#",
          title: "Play",
          text: "Play"
        }).appendTo($element);
        stopButton = $("<a>", {
          "class": "slidesjs-stop slidesjs-navigation",
          href: "#",
          title: "Stop",
          text: "Stop"
        }).appendTo($element);
        playButton.click(function(e) {
          e.preventDefault();
          return _this.play(true);
        });
        stopButton.click(function(e) {
          e.preventDefault();
          return _this.stop(true);
        });
        if (this.options.play.swap) {
          stopButton.css({
            display: "none"
          });
        }
      }
      if (this.options.pagination.active) {
          pagination = $("<ul>", {
            "class": "slidesjs-pagination"
          }).appendTo($element);
          $.each(new Array(this.data.total), function(i) {
            var paginationItem, paginationLink;
            paginationItem = $("<li>", {
              "class": "slidesjs-pagination-item"
            }).appendTo(pagination);
            paginationLink = $("<a>", {
              href: "#",
              "data-slidesjs-item": i,
              html: i + 1
            }).appendTo(paginationItem);
            return paginationLink.click(function(e) {
             activelink = $(e.currentTarget).attr("class");
              e.preventDefault();
              _this.stop(true);
              if (activelink != "active") {
                return _this.goto(($(e.currentTarget).attr("data-slidesjs-item") * 1) + 1);
              }
            });
          });
        }

        if (this.options.pagination.active) {
          $(window).bind("resize", function() {
            $("ul.slidesjs-pagination").remove();
          pagination = $("<ul>", {
            "class": "slidesjs-pagination"
          }).appendTo($element);
          var activearticle = $("#content article.current-slide").index(); //gpp
          var cnt = 0; //gpp
          $.each(new Array($("#content article").length), function(i) { //gpp
            var addactive = ""; //gpp
            if (cnt == activearticle) { //gpp
              var addactive = "active"; //gpp
            }; //gpp
            var paginationItem, paginationLink;
            paginationItem = $("<li>", {
              "class": "slidesjs-pagination-item"
            }).appendTo(pagination);
            paginationLink = $("<a>", {
              href: "#",
              class: addactive, //gpp
              "data-slidesjs-item": i,
              html: i + 1
            }).appendTo(paginationItem);
            cnt++;
            return paginationLink.click(function(e) {
              activelink = $(e.currentTarget).attr("class");
              e.preventDefault();
              _this.stop(true);
              //alert($(e.currentTarget).attr("data-slidesjs-item"));
              if (activelink != "active") {
                return _this.goto(($(e.currentTarget).attr("data-slidesjs-item") * 1) + 1);
              }
            });
          });
        });
        }

      $(window).bind("resize", function() {
        return _this.update();
      });
      this._setActive();
      if (this.options.play.auto) {
        this.play();
      }
      return this.options.callback.loaded(this.options.start);
    };
    Plugin.prototype._setActive = function(number) {
      var $element, current;
      $element = $(this.element);
      this.data = $.data(this);
     current = number > -1 ? number : this.data.current;
     //alert(current);
      //current = $(".slidesjs-control article.current-slide").index();
      $(".active", $element).removeClass("active");
      return $(".slidesjs-pagination li:eq(" + current + ") a", $element).addClass("active"); //custom edited to meet gpp requirements
    };
    Plugin.prototype.update = function(number) {
      var $element, height, width, current;
      $element = $(this.element);
      this.data = $.data(this);
      current = number > -1 ? number : this.data.current;
        //current = $(".slidesjs-control article.current-slide").index();
      $(".slidesjs-control", $element).children(":not(:eq(" + this.data.current + "))").css({
        display: "none",
        left: 0,
        zIndex: 0
      });
      $(".slidesjs-control article.current-slide").first().show().next().hide();

      width = $element.width();
     // height = (this.options.height / this.options.width) * width;
      //height = this.options.height;
      height = $("#content").css("height");
      this.options.width = width;
      this.options.height = height;
      return $(".slidesjs-control, .slidesjs-container", $element).css({
        width: width,
        height: height
      });
    };
    Plugin.prototype.next = function(effect) {
       number = parseInt($(".slidesjs-control article.current-slide").index())+2;   // custom added to fulfill gpp needs
        var $element;
      $element = $(this.element);
      this.data = $.data(this);
      $.data(this, "direction", "next");
      if (effect === void 0) {
        effect = this.options.navigation.effect;
      }
      if (effect === "fade") {
        return this._fade();
      } else {
        return this._slide(number);
      }
    };
    Plugin.prototype.previous = function(effect) {
      var $element;
      number = parseInt($(".slidesjs-control article.current-slide").index());   // custom added to fulfill gpp needs
      $element = $(this.element);
      this.data = $.data(this);
      $.data(this, "direction", "previous");
      if (effect === void 0) {
        effect = this.options.navigation.effect;
      }
      if (effect === "fade") {
        return this._fade();
      } else {
        return this._slide(number);
      }
    };
   Plugin.prototype.goto = function(number) {
    var articlecnt = $("#content article").length; //gpp
      var $element, effect;
      $element = $(this.element);
      this.data = $.data(this);
      if (effect === void 0) {
        effect = this.options.pagination.effect;
      }
      if (number > articlecnt) { //gpp
        number = articlecnt;
      } else if (number < 1) {
        number = 1;
      }
      if (typeof number === "number") {
        if (effect === "fade") {
          return this._fade(number);
        } else {
          return this._slide(number);
        }
      } else if (typeof number === "string") {
        if (number === "first") {
          if (effect === "fade") {
            return this._fade(0);
          } else {
            return this._slide(0);
          }
        } else if (number === "last") {
          if (effect === "fade") {
            return this._fade(articlecnt); //gpp
          } else {
            return this._slide(articlecnt); //gpp
          }
        }
      }
    };
    Plugin.prototype._setuptouch = function() {
      var $element, next, previous, slidesControl;
      $element = $(this.element);
      this.data = $.data(this);
      slidesControl = $(".slidesjs-control", $element);
      next = this.data.current + 1;
      previous = this.data.current - 1;
      if (previous < 0) {
        previous = this.data.total - 1;
      }
      if (next > this.data.total - 1) {
        next = 0;
      }
      slidesControl.children(":eq(" + next + ")").css({
        display: "block",
        left: this.options.width
      });
      return slidesControl.children(":eq(" + previous + ")").css({
        display: "block",
        left: -this.options.width
      });
    };
    Plugin.prototype._touchstart = function(e) {
      var $element, touches;
      $element = $(this.element);
      this.data = $.data(this);
      touches = e.originalEvent.touches[0];
      this._setuptouch();
      $.data(this, "touchtimer", Number(new Date()));
      $.data(this, "touchstartx", touches.pageX);
      $.data(this, "touchstarty", touches.pageY);
      return e.stopPropagation();
    };
    Plugin.prototype._touchend = function(e) {
      var $element, duration, prefix, slidesControl, timing, touches, transform,
        _this = this;
      $element = $(this.element);
      this.data = $.data(this);
      touches = e.originalEvent.touches[0];
      slidesControl = $(".slidesjs-control", $element);
      if (slidesControl.position().left > this.options.width * 0.5 || slidesControl.position().left > this.options.width * 0.1 && (Number(new Date()) - this.data.touchtimer < 250)) {
        $.data(this, "direction", "previous");
        this._slide();
      } else if (slidesControl.position().left < -(this.options.width * 0.5) || slidesControl.position().left < -(this.options.width * 0.1) && (Number(new Date()) - this.data.touchtimer < 250)) {
        $.data(this, "direction", "next");
        this._slide();
      } else {
        prefix = this.data.vendorPrefix;
        transform = prefix + "Transform";
        duration = prefix + "TransitionDuration";
        timing = prefix + "TransitionTimingFunction";
        slidesControl[0].style[transform] = "translateX(0px)";
        slidesControl[0].style[duration] = this.options.effect.slide.speed * 0.85 + "ms";
      }
      slidesControl.on("transitionend webkitTransitionEnd oTransitionEnd otransitionend MSTransitionEnd", function() {
        prefix = _this.data.vendorPrefix;
        transform = prefix + "Transform";
        duration = prefix + "TransitionDuration";
        timing = prefix + "TransitionTimingFunction";
        slidesControl[0].style[transform] = "";
        slidesControl[0].style[duration] = "";
        return slidesControl[0].style[timing] = "";
      });
      return e.stopPropagation();
    };
    Plugin.prototype._touchmove = function(e) {
      var $element, prefix, slidesControl, touches, transform;
      $element = $(this.element);
      this.data = $.data(this);
      touches = e.originalEvent.touches[0];
      prefix = this.data.vendorPrefix;
      slidesControl = $(".slidesjs-control", $element);
      transform = prefix + "Transform";
      $.data(this, "scrolling", Math.abs(touches.pageX - this.data.touchstartx) < Math.abs(touches.pageY - this.data.touchstarty));
      if (!this.data.animating && !this.data.scrolling) {
        e.preventDefault();
        this._setuptouch();
        slidesControl[0].style[transform] = "translateX(" + (touches.pageX - this.data.touchstartx) + "px)";
      }
      return e.stopPropagation();
    };
    Plugin.prototype.play = function(next) {
      var $element, currentSlide, slidesContainer,
        _this = this;
      $element = $(this.element);
      this.data = $.data(this);
      if (!this.data.playInterval) {
        if (next) {
          currentSlide = this.data.current;
          this.data.direction = "next";
          if (this.options.play.effect === "fade") {
            this._fade();
          } else {
            this._slide();
          }
        }
        $.data(this, "playInterval", setInterval((function() {
          currentSlide = _this.data.current;
          _this.data.direction = "next";
          if (_this.options.play.effect === "fade") {
            return _this._fade();
          } else {
            return _this._slide();
          }
        }), this.options.play.interval));
        slidesContainer = $(".slidesjs-container", $element);
        if (this.options.play.pauseOnHover) {
          slidesContainer.unbind();
          slidesContainer.bind("mouseenter", function() {
            return _this.stop();
          });
          slidesContainer.bind("mouseleave", function() {
            if (_this.options.play.restartDelay) {
              return $.data(_this, "restartDelay", setTimeout((function() {
                return _this.play(true);
              }), _this.options.play.restartDelay));
            } else {
              return _this.play();
            }
          });
        }
        $.data(this, "playing", true);
        $(".slidesjs-play", $element).addClass("slidesjs-playing");
        if (this.options.play.swap) {
          $(".slidesjs-play", $element).hide();
          return $(".slidesjs-stop", $element).show();
        }
      }
    };
    Plugin.prototype.stop = function(clicked) {
      var $element;
      $element = $(this.element);
      this.data = $.data(this);
      clearInterval(this.data.playInterval);
      if (this.options.play.pauseOnHover && clicked) {
        $(".slidesjs-container", $element).unbind();
      }
      $.data(this, "playInterval", null);
      $.data(this, "playing", false);
      $(".slidesjs-play", $element).removeClass("slidesjs-playing");
      if (this.options.play.swap) {
        $(".slidesjs-stop", $element).hide();
        return $(".slidesjs-play", $element).show();
      }
    };
    Plugin.prototype._slide = function(number) {
     //alert(number);
      var $element, currentSlide, direction, duration, next, prefix, slidesControl, timing, transform, value,
        _this = this;
      $element = $(this.element);
      this.data = $.data(this);

      $.data(this, "total", jQuery("article").length); // GPP custom added

     //alert(number+"="+this.data.current);
      //if (!this.data.animating && number !== this.data.current-3) {
      if (!this.data.animating) {  // custom updated as per GPP requirements
       //alert(number);
        $.data(this, "animating", true);
        currentSlide = $(".slidesjs-control article.current-slide").index(); // custom added to fulfill gpp needs
        if (number > -1) {
          //alert(number +">"+ currentSlide);
          number = number - 1;
          value = number > currentSlide ? 1 : -1;
          direction = number > currentSlide ? -this.options.width : this.options.width;
          next = number;
        } else {
          value = this.data.direction === "next" ? 1 : -1;
          direction = this.data.direction === "next" ? -this.options.width : this.options.width;
          next = currentSlide + value;
        }
        if (next === -1) {
          next = this.data.total - 1;
        }
        if (next === this.data.total) {
          next = 0;
        }
       // alert(this.data.total);
        this._setActive(next);
        slidesControl = $(".slidesjs-control", $element);
        if (number > -1) {
          slidesControl.children(":not(:eq(" + currentSlide + "))").css({
            display: "none",
            left: 0,
            zIndex: 0
          });
        }
        slidesControl.children(":eq(" + next + ")").css({
          display: "block",
          left: value * this.options.width,
          zIndex: 10
        });
        this.options.callback.start(currentSlide + 1);
        if (this.data.vendorPrefix) {
          prefix = this.data.vendorPrefix;
          transform = prefix + "Transform";
          duration = prefix + "TransitionDuration";
          timing = prefix + "TransitionTimingFunction";
          slidesControl[0].style[transform] = "translateX(" + direction + "px)";
          slidesControl[0].style[duration] = this.options.effect.slide.speed + "ms";
          return slidesControl.on("transitionend webkitTransitionEnd oTransitionEnd otransitionend MSTransitionEnd", function() {
            slidesControl[0].style[transform] = "";
            slidesControl[0].style[duration] = "";
            slidesControl.children(":eq(" + next + ")").css({
              left: 0
            });
            slidesControl.children(":eq(" + currentSlide + ")").css({
              display: "none",
              left: 0,
              zIndex: 0
            });
            $.data(_this, "current", next);
            $.data(_this, "animating", false);
            slidesControl.unbind("transitionend webkitTransitionEnd oTransitionEnd otransitionend MSTransitionEnd");
            slidesControl.children(":not(:eq(" + next + "))").css({
              display: "none",
              left: 0,
              zIndex: 0
            });
            if (_this.data.touch) {
              _this._setuptouch();
            }
            return _this.options.callback.complete(next + 1);
          });
        } else {
          return slidesControl.stop().animate({
            left: direction
          }, this.options.effect.slide.speed, (function() {
            slidesControl.css({
              left: 0
            });
            slidesControl.children(":eq(" + next + ")").css({
              left: 0
            });
            return slidesControl.children(":eq(" + currentSlide + ")").css({
              display: "none",
              left: 0,
              zIndex: 0
            }, $.data(_this, "current", next), $.data(_this, "animating", false), _this.options.callback.complete(next + 1));
          }));
        }
      }
    };
    Plugin.prototype._fade = function(number) {
      var $element, currentSlide, next, slidesControl, value,
        _this = this;
      $element = $(this.element);
      this.data = $.data(this);
      if (!this.data.animating && number !== this.data.current + 1) {
        $.data(this, "animating", true);
        currentSlide = this.data.current;
        if (number) {
          number = number - 1;
          value = number > currentSlide ? 1 : -1;
          next = number;
        } else {
          value = this.data.direction === "next" ? 1 : -1;
          next = currentSlide + value;
        }
        if (next === -1) {
          next = this.data.total - 1;
        }
        if (next === this.data.total) {
          next = 0;
        }
        this._setActive(next);
        slidesControl = $(".slidesjs-control", $element);
        slidesControl.children(":eq(" + next + ")").css({
          display: "none",
          left: 0,
          zIndex: 10
        });
        this.options.callback.start(currentSlide + 1);
        if (this.options.effect.fade.crossfade) {
          slidesControl.children(":eq(" + this.data.current + ")").stop().fadeOut(this.options.effect.fade.speed);
          return slidesControl.children(":eq(" + next + ")").stop().fadeIn(this.options.effect.fade.speed, (function() {
            slidesControl.children(":eq(" + next + ")").css({
              zIndex: 0
            });
            $.data(_this, "animating", false);
            $.data(_this, "current", next);
            return _this.options.callback.complete(next + 1);
          }));
        } else {
          return slidesControl.children(":eq(" + currentSlide + ")").stop().fadeOut(this.options.effect.fade.speed, (function() {
            slidesControl.children(":eq(" + next + ")").stop().fadeIn(_this.options.effect.fade.speed, (function() {
              return slidesControl.children(":eq(" + next + ")").css({
                zIndex: 10
              });
            }));
            $.data(_this, "animating", false);
            $.data(_this, "current", next);
            return _this.options.callback.complete(next + 1);
          }));
        }
      }
    };
    Plugin.prototype._getVendorPrefix = function() {
      var body, i, style, transition, vendor;
      body = document.body || document.documentElement;
      style = body.style;
      transition = "transition";
      vendor = ["Moz", "Webkit", "Khtml", "O", "ms"];
      transition = transition.charAt(0).toUpperCase() + transition.substr(1);
      i = 0;
      while (i < vendor.length) {
        if (typeof style[vendor[i] + transition] === "string") {
          return vendor[i];
        }
        i++;
      }
      return false;
    };
    return $.fn[pluginName] = function(options) {
      return this.each(function() {
        if (!$.data(this, "plugin_" + pluginName)) {
          return $.data(this, "plugin_" + pluginName, new Plugin(this, options));
        }
      });
    };
  })(jQuery, window, document);

}).call(this);




/*
*
* Main JS for the theme
*
*/
jQuery( document ).ready( function( $ ) {

    // Youtube video z-index issue fix
    $('iframe').each(function(){
        var url = $(this).attr("src");
        var char = "?";
        if(url.indexOf("?") != -1){
            var char = "&";
        }
        $(this).attr("src",url+char+"wmode=transparent");
    });

    // fitvid call
    $("#page").fitVids();

    // call on window load and  window resize
    winwidthcal();

    jQuery(window).resize(function() {
        winwidthcal();
    });
   
    // Nav bar fade out on window out
	// jQuery(document).hover(
	// 	function() {
	// 		jQuery( ".menuwrapper" ).fadeIn("slow");
	// 	}, function() {
	// 		jQuery( ".menuwrapper" ).fadeOut("slow");
	// 	}
	// );
	
	// Nav bar fade out mouse when stationary
	// var timer;
	// jQuery(document).mousemove(function() {
 //    	if (timer) {
 //        	clearTimeout(timer);
 //        	timer = 0;
 //        	jQuery('.menuwrapper').fadeIn("slow");
 //    	}

 //    	timer = setTimeout(function() {
 //        	jQuery('.menuwrapper').fadeOut("slow");
 //    	}, 1000)
	// });
	
	// Set side of scroll panes
 	jQuery(window).load(function() {
 		var height = jQuery("#content").height() * .8;
        jQuery(".scroll-pane").height(height);
        
        // jQuery(".site-title").delay(500).fadeIn(5000);
        // jQuery(".site-description").delay(2000).fadeIn(5000);
        // jQuery("#colophon").delay(4000).fadeIn(5000);
    });
    
    //Keyboard navigation
	jQuery( document ).keydown( function( e ) {
		if ( e.which == 37 ) {  // Left arrow key code
            jQuery('a.slidesjs-previous').click();
		}
		else if ( e.which == 39 ) {  // Right arrow key code
            jQuery('a.slidesjs-next').click();
		} 
		else if ( e.which == 38 ) {  // Up arrow key code
			jQuery('.current-slide span.movedown').click();
		}
		else if ( e.which == 40 ) {  // Down arrow key code
			jQuery('.current-slide span.moveup').click();
		}
	} );

    jQuery(".scroll-pane, .menuwpper").mCustomScrollbar({
        scrollInertia:150,
        advanced:{
            updateOnContentResize: true
        }
    });

    function winwidthcal(){
        $("#content article").show();
        len = jQuery("#content article").length;
        var winwidth = jQuery(window).width();

        if( winwidth <= 768 ) {
            var i = 0;
            jQuery("#content article").each(function(){
                var _this = jQuery(this);
                var articleid = _this.attr("id");
                var article = _this.clone().empty();

                    _this.children().unwrap().each(function(){
                        i++;
                        var newClass = "";
                        var delClass = "";
                        if(i%2==0){
                            var re = /-a$/;
                                articleid = articleid.replace(re, "");
                            var newId = articleid+"-a";
                            newClass = "post-duplicate";
                            delClass = "current-slide";

                        } else {
                            var newId = articleid;
                        }
                        jQuery(this).wrap(article).parent().attr("id",newId).addClass(newClass).removeClass(delClass);
                    });
                    i=0;

                });
            var j = 0;
            jQuery("#content article").each(function(){
                jQuery(this).attr("slidesjs-index", j);
                j++;
            });

        } else {
            var i = 0;
            jQuery("#content article.post-duplicate").each(function(){
                var _this = jQuery(this);
                if(_this.hasClass("current-slide")) {
                    _this.prev().addClass("current-slide");
                }
                var prevId = _this.prev().attr("id");
                _this.children().unwrap().appendTo("#"+prevId);
            });

            var j = 0;
            jQuery("#content article").each(function(){
                jQuery(this).attr("slidesjs-index", j);
                j++;
            });

        }
        if (jQuery("#content article").hasClass("current-slide")) {
            // update hash tag
            var curslide = jQuery("#content article.current-slide").index();
            hashnav(curslide+1);
            //alert(curslide);
          }

        /**
         * Vertical Scrollbar
         */
          //jQuery(".scroll-pane").jScrollPane({autoReinitialise: true});
        

    }; // close of winwidthcal

      num = 1;
      // get the hash from url
      var url = window.location.hash;

      // removes the "#" symbol
      var num = window.location.hash.substring(1).split("#");
      if("" == num){
        num = 1;
      }

    $('.home #content, .archive #content').slidesjs({
        //width: 1100,
        //height: 700,
        start: num,
        pagination: {
            active: true,
            effect: "slide"
        },
        navigation: {
          active: false
        },
        callback: {
          loaded: function(number) {
                    num = number;
                    len = jQuery("#content article").length;
                    $("#content article:eq("+(number-1)+")").addClass("current-slide");
                    if(number == 1){
                        jQuery(".slidesjs-previous").hide();
                        jQuery(".slidesjs-next").show();
                        jQuery(".prev-page, .prevblock").show();
                    }else{
                        jQuery(".slidesjs-previous").show();
                        jQuery(".prev-page, .prevblock").hide();
                        jQuery(".slidesjs-next").show();
                    }
                    if(number == len){
                        jQuery(".slidesjs-next").hide();
                        jQuery(".next-page, .nextblock").show();
                    }else{
                        jQuery(".slidesjs-next").show();
                        jQuery(".next-page, .nextblock").hide();
                    }
                    //pagination in single page
                    if(1 == $("#content article").length){
                        jQuery(".slidesjs-previous").hide();
                        jQuery(".slidesjs-next").hide();
                        jQuery(".prev-page, .prevblock").show();
                        jQuery(".next-page, .nextblock").show();
                    }


                },
          start: function(number) {
            $("#content article").removeClass("current-slide");
            /**
             * Vertical Scrollbar
             */
              //jQuery(".scroll-pane").show().jScrollPane({autoReinitialise: true});
            
           //$("#content article").show();
          },
          complete: function(number) {
            $("#content article:eq("+(number-1)+")").addClass("current-slide")/*.find(".content-wrap").css("height", contheight)*/;
             hashnav(number);
            //pagination in home and archive pages
            if(number == 1){
                jQuery(".slidesjs-previous").hide();
                jQuery(".prev-page, .prevblock").show();
            }else{
                jQuery(".slidesjs-previous").show();
                jQuery(".prev-page, .prevblock").hide();
            }

            if(number == len){
                jQuery(".slidesjs-next").hide();
                jQuery(".next-page, .nextblock").show();
            }else{
                jQuery(".slidesjs-next").show();
                jQuery(".next-page, .nextblock").hide();
            }

          }
        }
    });
//}; // close of winwidthcal

  // hide menu if clicked else where
  jQuery(document).on("click", "html", function() {
    //alert(jQuery(this).parents(".menuwrapper"));
    if (jQuery("#topmenu").hasClass("display-menu") == true) {
      jQuery("article").animate({
          left:0
      }, 300);
      jQuery("#togtopmenu").animate({
          left:0
      }, 300);
      jQuery("#topmenu").removeClass("display-menu");
      jQuery(".menuwrapper").css({"z-index":0});
      jQuery(".left-move, .right-move, .slidesjs-pagination, .prevblock, .nextblock").show();
      number = jQuery("#content article.current-slide").index()+1;
      len = jQuery("#content article").length;
      //alert(number+"=="+len);
      if(!jQuery("body").hasClass("single")){
        if(number == len){
            jQuery(".slidesjs-next").hide();
            jQuery(".next-page, .nextblock").show();
        }else{
            jQuery(".slidesjs-next").show();
            jQuery(".next-page, .nextblock").hide();
        }
        if(number == 1){
            jQuery(".slidesjs-previous").hide();
            jQuery(".slidesjs-next").show();
            jQuery(".prev-page, .prevblock").show();
        }else{
            jQuery(".slidesjs-previous").show();
            jQuery(".prev-page, .prevblock").hide();
            jQuery(".slidesjs-next").show();
        }
      }
    };
  });
// Do nothing if clicked inside menuwrapper div
$(document).on('click',".menuwrapper", function(e) {
    e.stopPropagation();
});

$('.gallery').each(function() {
  $(this).magnificPopup({
    type:'image',
    delegate: 'a',
    gallery: {
      enabled: true,
      navigateByImgClick: true,
      preload: [0,1] // Will preload 0 - before current, and 1 after the current image
    },
  });
});

    jQuery(document).on("click", ".showmenu", function(event){
      event.stopPropagation();
       jQuery(this).parent("#topmenu").toggleClass("display-menu");
       var togglevalue = jQuery(this).parent("#topmenu").hasClass("display-menu") == true ? 200 : 0;
        if (togglevalue == 200) {
          jQuery(".left-move, .right-move, .slidesjs-pagination, .prevblock, .nextblock").hide();
          jQuery("article").animate({
              left:togglevalue
          }, 250, function(){
            jQuery(".menuwrapper").css({"z-index":10});
          });
          jQuery("#togtopmenu").animate({
                left:togglevalue
            }, 250);
        } else {
            jQuery(".left-move, .right-move, .slidesjs-pagination, .prevblock, .nextblock").show();
            number = jQuery("#content article.current-slide").index()+1;
            len = jQuery("#content article").length;
            //alert(number+"=="+len);
            if(!jQuery("body").hasClass("single")){
              if(number == len){
                  jQuery(".slidesjs-next").hide();
                  jQuery(".next-page, .nextblock").show();
              }else{
                  jQuery(".slidesjs-next").show();
                  jQuery(".next-page, .nextblock").hide();
              }
              if(number == 1){
                  jQuery(".slidesjs-previous").hide();
                  jQuery(".slidesjs-next").show();
                  jQuery(".prev-page, .prevblock").show();
              }else{
                  jQuery(".slidesjs-previous").show();
                  jQuery(".prev-page, .prevblock").hide();
                  jQuery(".slidesjs-next").show();
              }
            }
            jQuery(".menuwrapper").css({"z-index":0});
            jQuery("article").animate({
                left:togglevalue
            }, 250);
            jQuery("#togtopmenu").animate({
                left:togglevalue
            }, 250);
        }
    });


    //dot navigation hash
    jQuery(document).on("click", ".slidesjs-pagination-item", function() {
      var number = jQuery(this).find("a").html();
      hashnav(number);
    })

    //hash
    function hashnav(number){
     // alert(number);
        //window.location.hash = number;
    }
} );