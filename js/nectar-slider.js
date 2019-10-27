
/*
 * Swiper 2.0 RC1 - Mobile Touch Slider
 * http://www.idangero.us/sliders/swiper/
 *
 * Copyright 2012-2013, Vladimir Kharlampidi
 * The iDangero.us
 * http://www.idangero.us/
 *
 * Licensed under GPL & MIT
 *
 * Updated on: May 31, 2013
*/
var Swiper = function (selector, params, callback) {
    /*=========================
      A little bit dirty but required part for IE8 and old FF support
      ===========================*/
    if (document.body.__defineGetter__) {
        if (HTMLElement) {
            var element = HTMLElement.prototype;
            if (element.__defineGetter__)
                element.__defineGetter__("outerHTML", function () { return new XMLSerializer().serializeToString(this); } );
        }
    }
    
    if (!window.getComputedStyle) {
        window.getComputedStyle = function (el, pseudo) {
            this.el = el;
            this.getPropertyValue = function (prop) {
                var re = /(\-([a-z]){1})/g;
                if (prop == 'float') prop = 'styleFloat';
                if (re.test(prop)) {
                    prop = prop.replace(re, function () {
                        return arguments[2].toUpperCase();
                    });
                }
                return el.currentStyle[prop] ? el.currentStyle[prop] : null;
            }
            return this;
        }
    }
    if (!Array.prototype.indexOf) {
        Array.prototype.indexOf = function(obj, start) {
            for (var i = (start || 0), j = this.length; i < j; i++) {
                if (this[i] === obj) { return i; }
            }
            return -1;
        }
    }
    if (!document.querySelectorAll) {
        if (!window.jQuery) return;
    }
    function $$(s) {
        if (document.querySelectorAll)
            return document.querySelectorAll(s)
        else
            return jQuery(s)
    }    

    /*=========================
      Check for correct selector
      ===========================*/
    if(typeof selector == 'undefined') return; 

    if(!(selector.nodeType)){
        if ($$(selector).length==0) return;
    }

     /*=========================
      _this
      ===========================*/
    var _this = this

     /*=========================
      Default Flags and vars
      ===========================*/
    _this.touches = {
        start:0,
        startX:0,
        startY:0,
        current:0,
        currentX:0,
        currentY:0,
        diff:0,
        abs:0
    };
    _this.positions = {
        start:0,
        abs:0,
        diff:0,
        current : 0 
    };
    _this.times = {
        start:0,
        end:0
    };

    _this.id = (new Date()).getTime();
    _this.container = (selector.nodeType) ? selector : $$(selector)[0];
    _this.isTouched = false;
    _this.isMoved = false;
    _this.activeIndex = 0;
    _this.activeLoaderIndex = 0;
    _this.loopIndex = 0;
    _this.previousIndex = null;
    _this.velocity = 0;
    _this.snapGrid = [];
    _this.slidesGrid = [];
    _this.wrapperLeft=0, 
    _this.wrapperRight=0, 
    _this.wrapperTop=0, 
    _this.wrapperBottom=0
    var wrapper, slideSize, wrapperSize, direction, isScrolling, containerSize;
    
    /*=========================
      Default Parameters
      ===========================*/
    var defaults = {
        mode : 'horizontal', // or 'vertical'
        touchRatio : 1,
        speed : 300,
        freeMode : false,
        freeModeFluid : false,
        momentumRatio: 1,
        momentumBounce: true,
        momentumBounceRatio: 1,
        slidesPerView : 1,
        slidesPerGroup : 1,
        simulateTouch : true,
        followFinger : true,
        shortSwipes : true,
        moveStartThreshold:false,
        autoplay: false,
        onlyExternal : false,
        createPagination : true,
        pagination : false,
        paginationElement: 'span',
        paginationClickable: false,
        paginationAsRange: true,
        resistance : true, // or false or 100%
        scrollContainer : false,
        preventLinks : true,
        noSwiping : false, // or class
        noSwipingClass : 'swiper-no-swiping', //:)
        initialSlide: 0,
        keyboardControl: false, 
        mousewheelControl : false,
        resizeEvent : 'auto', //or 'resize' or 'orientationchange'
        useCSS3Transforms : true,
        //Loop mode
        loop:false,
        loopAdditionalSlides:0,
        //Auto Height
        calculateHeight: false,
        //Images Preloader
        updateOnImagesReady : true,
        //Form elements
        releaseFormElements : true,
        //Watch for active slide, useful when use effects on different slide states
        watchActiveIndex: false,
        //Slides Visibility Fit
        visibilityFullFit : false,
        //Slides Offset
        offsetPxBefore : 0,
        offsetPxAfter : 0,
        offsetSlidesBefore : 0,
        offsetSlidesAfter : 0,
        centeredSlides: false,
        //Queue callbacks
        queueStartCallbacks : false,
        queueEndCallbacks : false,
        //Auto Resize
        autoResize : true,
        //DOMAnimation
        DOMAnimation : true,
        //Slides Loader
        loader: {
            slides:[], //array with slides
            slidesHTMLType:'inner', // or 'outer'
            surroundGroups: 1 //keep preloaded slides groups around view
        },
        //Namespace
        slideElement : 'div',
        slideClass : 'swiper-slide',
        slideActiveClass : 'swiper-slide-active',
        slideVisibleClass : 'swiper-slide-visible',
        wrapperClass : 'swiper-wrapper',
        paginationElementClass: 'swiper-pagination-switch',
        paginationActiveClass : 'swiper-active-switch', 
        paginationVisibleClass : 'swiper-visible-switch' 
    }
    params = params || {};  
    for (var prop in defaults) {
        if (prop in params && typeof params[prop]==='object') {
            for (var subProp in defaults[prop]) {
                if (! (subProp in params[prop])) {       
                    params[prop][subProp] = defaults[prop][subProp]
                }
            }
        }
        else if (! (prop in params)) {
            params[prop] = defaults[prop]   
        }
    }
    _this.params = params;
    if (params.scrollContainer) {
        params.freeMode = true;
        params.freeModeFluid = true;    
    }
    if (params.loop) {
        params.resistance = '100%'
    }
    var isH = params.mode=='horizontal';
    
    /*=========================
      Define Touch Events
      ===========================*/

    _this.touchEvents = {
        touchStart : _this.support.touch || !params.simulateTouch  ? 'touchstart' : (_this.browser.ie10 ? 'MSPointerDown' : 'mousedown'),
        touchMove : _this.support.touch || !params.simulateTouch ? 'touchmove' : (_this.browser.ie10 ? 'MSPointerMove' : 'mousemove'),
        touchEnd : _this.support.touch || !params.simulateTouch ? 'touchend' : (_this.browser.ie10 ? 'MSPointerUp' : 'mouseup')
    };
    
    /*=========================
      Wrapper
      ===========================*/
    for (var i = _this.container.childNodes.length - 1; i >= 0; i--) {
        if (_this.container.childNodes[i].className) {
            var _wrapperClasses = _this.container.childNodes[i].className.split(' ')
            for (var j = 0; j < _wrapperClasses.length; j++) {
                if (_wrapperClasses[j]===params.wrapperClass) {
                    wrapper = _this.container.childNodes[i]
                }
            };  
        }
    };

    _this.wrapper = wrapper;
    /*=========================
      Slide API
      ===========================*/
    _this._extendSwiperSlide = function  (el) {
        el.append = function () {
            if (params.loop) {
                el.insertAfter(_this.slides.length-_this.loopedSlides);
                _this.removeLoopedSlides();
                _this.calcSlides();
                _this.createLoop();
            }
            else {
                _this.wrapper.appendChild(el);    
            }
            
            _this.reInit();
            return el;
        }
        el.prepend = function () {
            if (params.loop) {
                _this.wrapper.insertBefore(el, _this.slides[_this.loopedSlides]);
                _this.removeLoopedSlides();
                _this.calcSlides();
                _this.createLoop();
            }
            else {
                _this.wrapper.insertBefore(el, _this.wrapper.firstChild);
            }
            _this.reInit();
            return el;
        }
        el.insertAfter = function (index) {
            if(typeof index === 'undefined') return false;
            var beforeSlide;

            if (params.loop) {
                beforeSlide = _this.slides[index + 1 + _this.loopedSlides];
                _this.wrapper.insertBefore(el, beforeSlide)
                _this.removeLoopedSlides();
                _this.calcSlides();
                _this.createLoop();
            }
            else {
                beforeSlide = _this.slides[index + 1];
                _this.wrapper.insertBefore(el, beforeSlide)
            }
            _this.reInit();
            return el;
        }
        el.clone = function () {
            return _this._extendSwiperSlide(el.cloneNode(true))
        }
        el.remove = function () {
            _this.wrapper.removeChild(el);
            _this.reInit()
        }
        el.html = function (html) {
            if (typeof html === 'undefined') {
                return el.innerHTML
            }
            else {
                el.innerHTML = html;
                return el;
            }
        }
        el.index = function () {
            var index
            for (var i = _this.slides.length - 1; i >= 0; i--) {
                if(el==_this.slides[i]) index = i
            };
            return index;
        }
        el.isActive = function () {
            if (el.index() == _this.activeIndex) return true;
            else return false;
        }
        if (!el.swiperSlideDataStorage) el.swiperSlideDataStorage={};
        el.getData = function (name) {
            return el.swiperSlideDataStorage[name]
        }
        el.setData = function (name, value) {
            el.swiperSlideDataStorage[name] = value;
            return el;
        }
        el.data = function (name, value) {
            if (!value) {
                return el.getAttribute('data-'+name);
            }
            else {
                el.setAttribute('data-'+name,value);
                return el;
            }
        }
        el.getWidth = function (outer) {
            return _this.h.getWidth(el, outer)
        }
        el.getHeight = function (outer) {
            return _this.h.getHeight(el, outer)
        }
        el.getOffset = function() {
            return _this.h.getOffset(el)
        }
        return el;
    }

    //Calculate information about number of slides
    _this.calcSlides = function (forceCalcSlides) {
        var oldNumber = _this.slides ? _this.slides.length : false;
        _this.slides = [];
        _this.displaySlides = [];
        for (var i = 0; i < _this.wrapper.childNodes.length; i++) {
            if (_this.wrapper.childNodes[i].className) {
                var _className = _this.wrapper.childNodes[i].className;
                var _slideClasses = _className.split(' ')
                for (var j = 0; j < _slideClasses.length; j++) {
                    if(_slideClasses[j]===params.slideClass) {
                        _this.slides.push(_this.wrapper.childNodes[i])
                    }
                };
            } 
        };
        for (var i = _this.slides.length - 1; i >= 0; i--) {
            _this._extendSwiperSlide(_this.slides[i]);
        };
        if (!oldNumber) return;
        if(oldNumber!=_this.slides.length || forceCalcSlides) {
            // Number of slides has been changed
            removeSlideEvents();
            addSlideEvents();
            _this.updateActiveSlide();
            if (params.createPagination && _this.params.pagination) _this.createPagination();
            _this.callPlugins('numberOfSlidesChanged')
        }
    }

    //Create Slide
    _this.createSlide = function (html, slideClassList, el) {
        var slideClassList = slideClassList || _this.params.slideClass;
        var el = el||params.slideElement;
        var newSlide = document.createElement(el)
        newSlide.innerHTML = html||'';
        newSlide.className = slideClassList;
        return _this._extendSwiperSlide(newSlide);
    }

    //Append Slide  
    _this.appendSlide = function (html, slideClassList, el) {
        if (!html) return;
        if (html.nodeType) {
            return _this._extendSwiperSlide(html).append()
        }
        else {
            return _this.createSlide(html, slideClassList, el).append()
        }
    }
    _this.prependSlide = function (html, slideClassList, el) {
        if (!html) return;
        if (html.nodeType) {
            return _this._extendSwiperSlide(html).prepend()
        }
        else {
            return _this.createSlide(html, slideClassList, el).prepend()
        }
    }
    _this.insertSlideAfter = function (index, html, slideClassList, el) {
        if (typeof index === 'undefined') return false;
        if (html.nodeType) {
            return _this._extendSwiperSlide(html).insertAfter(index);
        }
        else {
            return _this.createSlide(html, slideClassList, el).insertAfter(index);
        }
    }
    _this.removeSlide = function (index) {
        if (_this.slides[index]) {
            if (params.loop) {
                if (!_this.slides[index+_this.loopedSlides]) return false;
                _this.slides[index+_this.loopedSlides].remove();
                _this.removeLoopedSlides();
                _this.calcSlides();
                _this.createLoop();  
            }
            else _this.slides[index].remove();
            return true;
        }
        else return false;
    }
    _this.removeLastSlide = function () {
        if (_this.slides.length>0) {
            if (params.loop) {
                _this.slides[_this.slides.length - 1 - _this.loopedSlides].remove();
                _this.removeLoopedSlides();
                _this.calcSlides();
                _this.createLoop();
            }
            else _this.slides[ (_this.slides.length-1) ].remove();
            return true;
        }
        else {
            return false;
        }
    }
    _this.removeAllSlides = function () {
        for (var i = _this.slides.length - 1; i >= 0; i--) {
            _this.slides[i].remove()
        };
    }
    _this.getSlide = function (index) {
        return _this.slides[index]
    }
    _this.getLastSlide = function () {
        return _this.slides[ _this.slides.length-1 ]
    }
    _this.getFirstSlide = function () {
        return _this.slides[0]
    }

    //Currently Active Slide
    _this.activeSlide = function () {
        return _this.slides[_this.activeIndex]
    }

    /*=========================
      Plugins API
      ===========================*/
    var _plugins = [];
    for (var plugin in _this.plugins) {
        if (params[plugin]) {
            var p = _this.plugins[plugin](_this, params[plugin])
            if (p)
                _plugins.push( p )  
        }
    }
    _this.callPlugins = function(method, args) {
        if (!args) args = {}
        for (var i=0; i<_plugins.length; i++) {
            if (method in _plugins[i]) {
                _plugins[i][method](args);
            }
        }
    }

    /*=========================
      WP8 Fix
      ===========================*/
    if (_this.browser.ie10 && !params.onlyExternal) {
        if (isH) _this.wrapper.classList.add('swiper-wp8-horizontal')  
        else _this.wrapper.classList.add('swiper-wp8-vertical') 
    }

    /*=========================
      Free Mode Class
      ===========================*/
    if (params.freeMode) {
        _this.container.className+=' swiper-free-mode'
    }

    /*==================================================
        Init/Re-init/Resize Fix
    ====================================================*/
    _this.initialized = false;
    _this.init = function(force, forceCalcSlides) {
        var _width = _this.h.getWidth(_this.container);
        var _height = _this.h.getHeight(_this.container);
        if (_width==_this.width && _height==_this.height && !force) return;
        _this.width = _width;
        _this.height = _height;

        containerSize = isH ? _width : _height;
        var wrapper = _this.wrapper;

        if (force) {
            _this.calcSlides(forceCalcSlides)
        }

        if (params.slidesPerView=='auto') {
            //Auto mode
            var slidesWidth = 0;
            var slidesHeight = 0;

            //Unset Styles
            if (params.slidesOffset>0) {
                wrapper.style.paddingLeft = '';
                wrapper.style.paddingRight = '';
                wrapper.style.paddingTop = '';
                wrapper.style.paddingBottom = '';    
            }
            wrapper.style.width = '';
            wrapper.style.height = '';
            if (params.offsetPxBefore>0) {
                if (isH) _this.wrapperLeft = params.offsetPxBefore;
                else _this.wrapperTop = params.offsetPxBefore;   
            }
            if (params.offsetPxAfter>0) {
                if (isH) _this.wrapperRight = params.offsetPxAfter;
                else _this.wrapperBottom = params.offsetPxAfter;   
            }

            if (params.centeredSlides) {
                if (isH) {
                    _this.wrapperLeft = (containerSize - this.slides[0].getWidth(true) )/2;
                    _this.wrapperRight = (containerSize - _this.slides[ _this.slides.length-1 ].getWidth(true))/2;
                }
                else {
                    _this.wrapperTop = (containerSize - _this.slides[0].getHeight(true))/2;
                    _this.wrapperBottom = (containerSize - _this.slides[ _this.slides.length-1 ].getHeight(true))/2;
                }
            }

            if (isH) {
                if (_this.wrapperLeft>0) wrapper.style.paddingLeft = _this.wrapperLeft+'px'
                if (_this.wrapperRight>0) wrapper.style.paddingRight = _this.wrapperRight+'px'
            }
            else {
                if (_this.wrapperTop>0) wrapper.style.paddingTop = _this.wrapperTop+'px'
                if (_this.wrapperBottom>0) wrapper.style.paddingBottom = _this.wrapperBottom+'px'
            }
            var slideLeft = 0;
            var centeredSlideLeft=0;
            _this.snapGrid = [];
            _this.slidesGrid = [];
            for(var i = 0; i<_this.slides.length; i++) {
                var slideWidth = _this.slides[i].getWidth(true);
                var slideHeight = _this.slides[i].getHeight(true);
                var _slideSize = isH ? slideWidth : slideHeight;
                if (params.centeredSlides) {
                    var nextSlideWidth = i== _this.slides.length-1 ? 0 : _this.slides[i+1].getWidth(true);
                    var nextSlideHeight = i== _this.slides.length-1 ? 0 : _this.slides[i+1].getHeight(true)
                    var nextSlideSize = isH ? nextSlideWidth : nextSlideHeight;
                    if (_slideSize>containerSize) {
                        for (var j=0; j<=Math.floor(_slideSize/(containerSize+_this.wrapperLeft)); j++) {
                            if (j==0) _this.snapGrid.push(slideLeft+_this.wrapperLeft)
                            else _this.snapGrid.push(slideLeft+_this.wrapperLeft+containerSize*j)
                        }
                        _this.slidesGrid.push(slideLeft+_this.wrapperLeft);
                    }
                    else {
                        _this.snapGrid.push(centeredSlideLeft);   
                        _this.slidesGrid.push(centeredSlideLeft);
                    }

                    centeredSlideLeft += _slideSize/2 + nextSlideSize/2;

                }
                else {
                    if (_slideSize>containerSize) {
                        for (var j=0; j<=Math.floor(_slideSize/containerSize); j++) {
                            _this.snapGrid.push(slideLeft+containerSize*j)            
                        }
                    }
                    else {
                        _this.snapGrid.push(slideLeft);
                    }
                    _this.slidesGrid.push(slideLeft);
                }
                
                slideLeft += _slideSize;

                slidesWidth += slideWidth;
                slidesHeight += slideHeight;
            }
            if(isH) {
                wrapperSize = slidesWidth + _this.wrapperRight + _this.wrapperLeft;
                wrapper.style.width = (slidesWidth)+'px';
                wrapper.style.height = (_this.height)+'px';
            }
            else {
                wrapperSize = slidesHeight + _this.wrapperTop + _this.wrapperBottom;
                wrapper.style.width = (_this.width)+'px';
                wrapper.style.height = (slidesHeight)+'px';
            }
            
        }
        else if (params.scrollContainer) {
            //Scroll Container
            wrapper.style.width = '';
            wrapper.style.height = '';
            var wrapperWidth = _this.slides[0].getWidth(true);
            var wrapperHeight = _this.slides[0].getHeight(true);
            wrapperSize = isH ? wrapperWidth : wrapperHeight;
            wrapper.style.width = wrapperWidth+'px';
            wrapper.style.height = wrapperHeight+'px';
            slideSize = isH ? wrapperWidth : wrapperHeight;
            
        }
        else {
            //For usual slides
            if (params.calculateHeight) {
                var slideMaxHeight = 0;
                var wrapperHeight = 0;
                //ResetWrapperSize
                if (!isH) _this.container.style.height= '';
                wrapper.style.height='';

                for (var i=0; i<_this.slides.length; i++) {
                    //ResetSlideSize
                    _this.slides[i].style.height='';
                    slideMaxHeight = Math.max( _this.slides[i].getHeight(true), slideMaxHeight )
                    if (!isH) wrapperHeight+=_this.slides[i].getHeight(true);
                }
                var slideHeight = slideMaxHeight;
                if (isH) var wrapperHeight = slideHeight;
                containerSize = _this.height = slideHeight
                if (!isH) _this.container.style.height= containerSize+'px'
            }
            else {
                var slideHeight = isH ? _this.height : _this.height/params.slidesPerView ;    
                var wrapperHeight = isH ? _this.height : _this.slides.length*slideHeight;
            }
            var slideWidth = isH ? _this.width/params.slidesPerView : _this.width;
            var wrapperWidth = isH ? _this.slides.length*slideWidth : _this.width;
            slideSize = isH ? slideWidth : slideHeight;

            if (params.offsetSlidesBefore>0) {
                if (isH) _this.wrapperLeft = slideSize*params.offsetSlidesBefore;
                else _this.wrapperTop = slideSize*params.offsetSlidesBefore;   
            }
            if (params.offsetSlidesAfter>0) {
                if (isH) _this.wrapperRight = slideSize*params.offsetSlidesAfter;
                else _this.wrapperBottom = slideSize*params.offsetSlidesAfter;   
            }
            if (params.offsetPxBefore>0) {
                if (isH) _this.wrapperLeft = params.offsetPxBefore;
                else _this.wrapperTop = params.offsetPxBefore;   
            }
            if (params.offsetPxAfter>0) {
                if (isH) _this.wrapperRight = params.offsetPxAfter;
                else _this.wrapperBottom = params.offsetPxAfter;   
            }
            if (params.centeredSlides) {
                if (isH) {
                    _this.wrapperLeft = (containerSize - slideSize)/2;
                    _this.wrapperRight = (containerSize - slideSize)/2;
                }
                else {
                    _this.wrapperTop = (containerSize - slideSize)/2;
                    _this.wrapperBottom = (containerSize - slideSize)/2;
                } 
            }
            if (isH) {
                if (_this.wrapperLeft>0) wrapper.style.paddingLeft = _this.wrapperLeft+'px'
                if (_this.wrapperRight>0) wrapper.style.paddingRight = _this.wrapperRight+'px'
            }
            else {
                if (_this.wrapperTop>0) wrapper.style.paddingTop = _this.wrapperTop+'px'
                if (_this.wrapperBottom>0) wrapper.style.paddingBottom = _this.wrapperBottom+'px'
            }

            wrapperSize = isH ? wrapperWidth + _this.wrapperRight + _this.wrapperLeft : wrapperHeight + _this.wrapperTop + _this.wrapperBottom;
            wrapper.style.width = wrapperWidth+'px'
            wrapper.style.height = wrapperHeight+'px'
            var slideLeft = 0;
            _this.snapGrid = [];
            _this.slidesGrid = [];
            for (var i=0; i<_this.slides.length; i++) {
                _this.snapGrid.push(slideLeft)
                _this.slidesGrid.push(slideLeft)
                slideLeft+=slideSize;
                _this.slides[i].style.width = slideWidth+'px';
                _this.slides[i].style.height = slideHeight+'px';
            }

        }

        if (!_this.initialized) _this.callPlugins('onFirstInit');
        else _this.callPlugins('onInit');
        _this.initialized = true;
    }
    _this.reInit = function (forceCalcSlides) {
        _this.init(true, forceCalcSlides)
    }
    _this.resizeFix = function(e){
        _this.callPlugins('beforeResizeFix');
        _this.init()
        if (!params.freeMode) {
            if (params.loop) _this.swipeTo(_this.loopIndex, 0, false);
            else _this.swipeTo(_this.activeIndex, 0, false);
        }
        else {
            var pos = isH ? _this.getWrapperTranslate('x') : _this.getWrapperTranslate('y')
            if (pos < -maxWrapperPosition()) {
                var x = isH ? -maxWrapperPosition() : 0;
                var y = isH ? 0 : -maxWrapperPosition();
                _this.setWrapperTransition(0)
                _this.setWrapperTranslate(x,y,0)   
            }
        }
        _this.callPlugins('afterResizeFix');
    }
    
    /*========================================== 
        Max and Min Positions
    ============================================*/
    function maxWrapperPosition() {
        var a = (wrapperSize - containerSize);
        if (params.freeMode) {
            a = wrapperSize - containerSize;
        }
        // if (params.loop) a -= containerSize;
        if (params.slidesPerView > _this.slides.length) a = 0;
        if (a<0) a = 0
        return a;
    }
    function minWrapperPosition() {
        var a = 0;
        // if (params.loop) a = containerSize;
        return a;   
    }

    /*========================================== 
        Event Listeners 
    ============================================*/
    function initEvents() {
        //Touch Events
        if (!_this.browser.ie10) {
            if (_this.support.touch) {
                _this.h.addEventListener(_this.wrapper, 'touchstart', onTouchStart, false)
                _this.h.addEventListener(_this.wrapper, 'touchmove', onTouchMove, false)
                _this.h.addEventListener(_this.wrapper, 'touchend', onTouchEnd, false)
            }
            if (params.simulateTouch) {
                _this.h.addEventListener(_this.wrapper, 'mousedown', onTouchStart, false)
                _this.h.addEventListener(document, 'mousemove', onTouchMove, false)
                _this.h.addEventListener(document, 'mouseup', onTouchEnd, false)
            }
        }
        else {
            _this.h.addEventListener(_this.wrapper, _this.touchEvents.touchStart, onTouchStart, false)
            _this.h.addEventListener(document, _this.touchEvents.touchMove, onTouchMove, false)
            _this.h.addEventListener(document, _this.touchEvents.touchEnd, onTouchEnd, false)
        }
        //Resize Event
        if (params.autoResize) {
            _this.h.addEventListener(window, 'resize', _this.resizeFix, false)
        }
        //Slide Events
        addSlideEvents();
        //Mousewheel
        _this._wheelEvent = false;
        if (params.mousewheelControl) {
            if ( document.onmousewheel !== undefined ) {
                _this._wheelEvent = "mousewheel"
            }
            try {
                WheelEvent("wheel");
                _this._wheelEvent = "wheel";
            } catch (e) {}
            if ( !_this._wheelEvent ) {
                _this._wheelEvent = "DOMMouseScroll";
            }
            
            if (_this._wheelEvent) {
                _this.h.addEventListener(_this.container, _this._wheelEvent, handleMousewheel, false);
            }
        }

        //Keyboard
        if (params.keyboardControl) {
            _this.h.addEventListener(document, 'keydown', handleKeyboardKeys, false);
        }

        if (params.updateOnImagesReady) {
            var images = []
            if (document.querySelectorAll) images = _this.container.querySelectorAll('img');
            else if (window.jQuery) images = $$(_this.container).find('img');
            var loaded = 0;
            for (var i=0; i<images.length; i++) {
                images[i].onload = function(){
                    loaded++;
                    if (loaded==images.length) {
                        _this.reInit()
                        if (params.onImagesReady) params.onImagesReady(_this)
                    }
                }
            }
        }
    }

    
    
    //Remove Event Listeners
    _this.destroy = function(removeResizeFix){
        //Touch Events
        if (!_this.browser.ie10) {
            if (_this.support.touch) {
                _this.h.removeEventListener(_this.wrapper, 'touchstart', onTouchStart, false)
                _this.h.removeEventListener(_this.wrapper, 'touchmove', onTouchMove, false)
                _this.h.removeEventListener(_this.wrapper, 'touchend', onTouchEnd, false)
            }
            if (params.simulateTouch) {
                _this.h.removeEventListener(_this.wrapper, 'mousedown', onTouchStart, false)
                _this.h.removeEventListener(document, 'mousemove', onTouchMove, false)
                _this.h.removeEventListener(document, 'mouseup', onTouchEnd, false)
            }
        }
        else {
            _this.h.removeEventListener(_this.wrapper, _this.touchEvents.touchStart, onTouchStart, false)
            _this.h.removeEventListener(document, _this.touchEvents.touchMove, onTouchMove, false)
            _this.h.removeEventListener(document, _this.touchEvents.touchEnd, onTouchEnd, false)
        }
        //Resize Event
        if (params.autoResize) {
            _this.h.removeEventListener(window, 'resize', _this.resizeFix, false)
        }
        //Init Slide Events
        removeSlideEvents();
        
        //Pagination
        if (params.paginationClickable) {
            removePaginationEvents()
        }

        //Mousewheel
        if (params.mousewheelControl && _this._wheelEvent) {
           _this.h.removeEventListener(_this.container, _this._wheelEvent, handleMousewheel, false); 
        }

        //Keyboard
        if (params.keyboardControl) {
            _this.h.removeEventListener(document, 'keydown', handleKeyboardKeys, false);
        }

        //Stop autoplay
        if (params.autoplay) {
            _this.stopAutoplay()
        }

        _this.callPlugins('onDestroy');
    }
    function addSlideEvents() {
        //Prevent Links Events
        if (params.preventLinks) {
            var links = [];
            if (document.querySelectorAll) {
                links = _this.container.querySelectorAll('a')    
            }
            else if (window.jQuery) {
                links = $$(_this.container).find('a')
            }
            for (var i=0; i<links.length; i++) {
                _this.h.addEventListener(links[i], 'click', preventClick, false)
            }
        }
        //Release Form Elements
        if (params.releaseFormElements) {
            var formElements = document.querySelectorAll ? _this.container.querySelectorAll('input, textarea, select') : $$(_this.container).find('input, textarea, select')
            for (var i=0; i<formElements.length; i++) {
                _this.h.addEventListener(formElements[i], _this.touchEvents.touchStart, releaseForms, true)
            }
        }

        //Slide Clicks & Touches
        if (params.onSlideClick) {
            for (var i=0; i<_this.slides.length; i++) {
                _this.h.addEventListener(_this.slides[i], 'click', slideClick, false);
            }
        }
        if (params.onSlideTouch) {
            for (var i=0; i<_this.slides.length; i++) {
                _this.h.addEventListener(_this.slides[i], _this.touchEvents.touchStart, slideTouch, false);
            }
        }
    }
    function removeSlideEvents() {
        //Slide Clicks & Touches
        if (params.onSlideClick) {
            for (var i=0; i<_this.slides.length; i++) {
                _this.h.removeEventListener(_this.slides[i], 'click', slideClick, false);
            }
        }
        if (params.onSlideTouch) {
            for (var i=0; i<_this.slides.length; i++) {
                _this.h.removeEventListener(_this.slides[i], _this.touchEvents.touchStart, slideTouch, false);
            }
        }
        //Release Form Elements
        if (params.releaseFormElements) {
            var formElements = document.querySelectorAll ? _this.container.querySelectorAll('input, textarea, select') : $$(_this.container).find('input, textarea, select')
            for (var i=0; i<formElements.length; i++) {
                _this.h.removeEventListener(formElements[i], _this.touchEvents.touchStart, releaseForms, true)
            }
        }
        //Prevent Links Events
        if (params.preventLinks) {
            var links = [];
            if (document.querySelectorAll) {
                links = _this.container.querySelectorAll('a')    
            }
            else if (window.jQuery) {
                links = $$(_this.container).find('a')
            }
            for (var i=0; i<links.length; i++) {
                _this.h.removeEventListener(links[i], 'click', preventClick, false)
            }
        }
    }
    /*========================================== 
        Keyboard Control 
    ============================================*/
    function handleKeyboardKeys (e) {
        var kc = e.keyCode || e.charCode;
        if (kc==37 || kc==39 || kc==38 || kc==40) {
            var inView = false;
            //Check that swiper should be inside of visible area of window
            var swiperOffset = _this.h.getOffset( _this.container );
            var scrollLeft = _this.h.windowScroll().left;
            var scrollTop = _this.h.windowScroll().top;
            var windowWidth = _this.h.windowWidth();
            var windowHeight = _this.h.windowHeight();
            var swiperCoord = [
                [swiperOffset.left, swiperOffset.top],
                [swiperOffset.left + _this.width, swiperOffset.top],
                [swiperOffset.left, swiperOffset.top + _this.height],
                [swiperOffset.left + _this.width, swiperOffset.top + _this.height]
            ]
            for (var i=0; i<swiperCoord.length; i++) {
                var point = swiperCoord[i]
                if (
                    point[0]>=scrollLeft && point[0]<=scrollLeft+windowWidth && 
                    point[1]>=scrollTop && point[1]<=scrollTop+windowHeight
                ) {
                    inView = true;
                }
                    
            }
            if (!inView) return;
        }
        if (isH) {
            if (kc==37 || kc==39) {
                if (e.preventDefault) e.preventDefault();
                else e.returnValue = false;
            }
            if (kc == 39) _this.swipeNext()
            if (kc == 37) _this.swipePrev()
        }
        else {
            if (kc==38 || kc==40) {
                if (e.preventDefault) e.preventDefault();
                else e.returnValue = false;
            }
            if (kc == 40) _this.swipeNext()
            if (kc == 38) _this.swipePrev()
        }
    }
        
    /*========================================== 
        Mousewheel Control
    ============================================*/
    function handleMousewheel (e) {
        var we = _this._wheelEvent;
        var delta;
        //Opera & IE
        if (e.detail) delta = -e.detail;
        //WebKits   
        else if (we == 'mousewheel') delta = e.wheelDelta; 
        //Old FireFox
        else if (we == 'DOMMouseScroll') delta = -e.detail;
        //New FireFox
        else if (we == 'wheel') {
            delta = Math.abs(e.deltaX)>Math.abs(e.deltaY) ? - e.deltaX : - e.deltaY;
        }
        if (!params.freeMode) {
            if(delta<0) _this.swipeNext()
            else _this.swipePrev()
        }
        else {
            //Freemode or scrollContainer:
            var currentTransform =isH ? _this.getWrapperTranslate('x') : _this.getWrapperTranslate('y')
            var x,y;
            if (isH) {
                x = _this.getWrapperTranslate('x') + delta;
                y = _this.getWrapperTranslate('y');
                if (x>0) x = 0;
                if (x<-maxWrapperPosition()) x = -maxWrapperPosition();
            }
            else {
                x = _this.getWrapperTranslate('x');
                y = _this.getWrapperTranslate('y')+delta;
                if (y>0) y = 0;
                if (y<-maxWrapperPosition()) y = -maxWrapperPosition();
            }
            _this.setWrapperTransition(0)
            _this.setWrapperTranslate(x,y,0)
        }
        if (params.autoplay) _this.stopAutoplay();

        if(e.preventDefault) e.preventDefault();
        else e.returnValue = false;
        return false;
    }

    /*=========================
      Grab Cursor
      ===========================*/
    if (params.grabCursor) {
        _this.container.style.cursor = 'move';
        _this.container.style.cursor = 'grab';
        _this.container.style.cursor = '-moz-grab';
        _this.container.style.cursor = '-webkit-grab';
    }

    /*=========================
      Slides Events Handlers
      ===========================*/
    _this.allowSlideClick = true;
    function slideClick(e) {
        if(_this.allowSlideClick) {
            _this.clickedSlide = this;
            _this.clickedSlideIndex = _this.slides.indexOf(this);
            params.onSlideClick(_this);
        }
    }
    function slideTouch(e) {
        _this.clickedSlide = this;
        _this.clickedSlideIndex = _this.slides.indexOf(this);
        params.onSlideTouch(_this);
    }
    _this.allowLinks = true;
    function preventClick(e) {
        if (!_this.allowLinks) {
            if(e.preventDefault) e.preventDefault();
            else e.returnValue = false;
            return false;
        }
    }
    function releaseForms(e) {
        if (e.stopPropagation) e.stopPropagation()
        else e.returnValue = false;
        return false;
    }
    
    /*==================================================
        Event Handlers
    ====================================================*/
    var isTouchEvent = false;
    var allowThresholdMove;
    var allowMomentumBounce = true;
    function onTouchStart(event) {
        if (params.preventLinks) _this.allowLinks = true;
        //Exit if slider is already was touched
        if (_this.isTouched || params.onlyExternal) {
            return false
        }

        if (params.noSwiping && event.target && event.target.className.indexOf(params.noSwipingClass) > -1) return false;
        allowMomentumBounce = false;

        //Check For Nested Swipers
        _this.isTouched = true;
        isTouchEvent = event.type=='touchstart';

        if (!isTouchEvent || event.targetTouches.length == 1 ) {
            if (params.loop) _this.fixLoop();
            _this.callPlugins('onTouchStartBegin');

            if(!isTouchEvent) {
                if(event.preventDefault) event.preventDefault();
                else event.returnValue = false;
            }

            var pageX = isTouchEvent ? event.targetTouches[0].pageX : (event.pageX || event.clientX)
            var pageY = isTouchEvent ? event.targetTouches[0].pageY : (event.pageY || event.clientY)
            
            //Start Touches to check the scrolling
            _this.touches.startX = _this.touches.currentX = pageX;
            _this.touches.startY = _this.touches.currentY = pageY;
            
            _this.touches.start = _this.touches.current = isH ? pageX : pageY ;
            
            //Set Transition Time to 0
            _this.setWrapperTransition(0)
            
            //Get Start Translate Position
            _this.positions.start = _this.positions.current = isH ? _this.getWrapperTranslate('x') : _this.getWrapperTranslate('y');

            //Set Transform
            if (isH) {
                _this.setWrapperTranslate( _this.positions.start, 0, 0)
            }
            else {
                _this.setWrapperTranslate( 0, _this.positions.start, 0)
            }
            
            //TouchStartTime
            _this.times.start = (new Date()).getTime()
            
            //Unset Scrolling
            isScrolling = undefined;
            
            //Set Treshold
            if (params.moveStartThreshold>0) allowThresholdMove = false;

            //CallBack
            if (params.onTouchStart) params.onTouchStart(_this)
            _this.callPlugins('onTouchStartEnd');
            
        }
    }
    var velocityPrevPosition, velocityPrevTime;
    function onTouchMove(event) {
        // If slider is not touched - exit
        if (!_this.isTouched || params.onlyExternal) return;
        if (isTouchEvent && event.type=='mousemove') return;

        var pageX = isTouchEvent ? event.targetTouches[0].pageX : (event.pageX || event.clientX)
        var pageY = isTouchEvent ? event.targetTouches[0].pageY : (event.pageY || event.clientY)

        //check for scrolling
        if ( typeof isScrolling === 'undefined' && isH) {
          isScrolling = !!( isScrolling || Math.abs(pageY - _this.touches.startY) > Math.abs( pageX - _this.touches.startX ) )
        }
        if ( typeof isScrolling === 'undefined' && !isH) {
          isScrolling = !!( isScrolling || Math.abs(pageY - _this.touches.startY) < Math.abs( pageX - _this.touches.startX ) )
        }
        if (isScrolling ) {
            _this.isTouched = false;
            return
        }
        
        //Check For Nested Swipers
        if (event.assignedToSwiper) {
            _this.isTouched = false;
            return
        }
        event.assignedToSwiper = true;

        //Moved Flag
        _this.isMoved = true;  
        
        //Block inner links
        if (params.preventLinks) {
            _this.allowLinks = false;   
        }
        if (params.onSlideClick) {
            _this.allowSlideClick = false;
        }
        
        //Stop AutoPlay if exist
        if (params.autoplay) {
            _this.stopAutoplay()
        }
        if (!isTouchEvent || event.touches.length == 1) {
            
            _this.callPlugins('onTouchMoveStart');

            if(event.preventDefault) event.preventDefault();
            else event.returnValue = false;
            
            _this.touches.current = isH ? pageX : pageY ;
            
            _this.positions.current = (_this.touches.current - _this.touches.start) * params.touchRatio + _this.positions.start            
            
            //Resistance Callbacks
            if(_this.positions.current > 0 && params.onResistanceBefore) {
                params.onResistanceBefore(_this, _this.positions.current);
            }
            if(_this.positions.current < -maxWrapperPosition() && params.onResistanceBefore) {
                params.onResistanceAfter(_this, Math.abs(_this.positions.current + maxWrapperPosition()));
            }
            //Resistance
            if (params.resistance && params.resistance!='100%') {
                //Resistance for Negative-Back sliding
                if(_this.positions.current > 0) {
                    var resistance = 1 - _this.positions.current/containerSize/2;
                    if (resistance < 0.5) 
                        _this.positions.current = (containerSize/2);
                    else 
                        _this.positions.current = _this.positions.current * resistance;
                }
                //Resistance for After-End Sliding
                if ( _this.positions.current < -maxWrapperPosition() ) {
                    
                    var diff = (_this.touches.current - _this.touches.start)*params.touchRatio + (maxWrapperPosition()+_this.positions.start)
                    var resistance = (containerSize+diff)/(containerSize);
                    var newPos = _this.positions.current-diff*(1-resistance)/2
                    var stopPos = -maxWrapperPosition() - containerSize/2;
                    
                    if (newPos < stopPos || resistance<=0)
                        _this.positions.current = stopPos;
                    else 
                        _this.positions.current = newPos
                }
            }
            if (params.resistance && params.resistance=='100%') {
                //Resistance for Negative-Back sliding
                if(_this.positions.current > 0 && !(params.freeMode&&!params.freeModeFluid)) {
                    _this.positions.current = 0;
                }
                //Resistance for After-End Sliding
                if ( (_this.positions.current) < -maxWrapperPosition() && !(params.freeMode&&!params.freeModeFluid)) {
                    _this.positions.current = -maxWrapperPosition();
                }
            }
            //Move Slides
            if (!params.followFinger) return

            if (!params.moveStartThreshold) {
                if (isH) _this.setWrapperTranslate( _this.positions.current, 0, 0)
                else _this.setWrapperTranslate( 0, _this.positions.current, 0)    
            }
            else {
                if ( Math.abs(_this.touches.current - _this.touches.start)>params.moveStartThreshold || allowThresholdMove) {
                    allowThresholdMove = true;
                    if (isH) _this.setWrapperTranslate( _this.positions.current, 0, 0)
                    else _this.setWrapperTranslate( 0, _this.positions.current, 0)  
                }
                else {
                    _this.positions.current = _this.positions.start
                }
            }    

            if (params.freeMode || params.watchActiveIndex) {
                _this.updateActiveSlide(_this.positions.current)
            }

            //Grab Cursor
            if (params.grabCursor) {
                _this.container.style.cursor = 'move';
                _this.container.style.cursor = 'grabbing';
                _this.container.style.cursor = '-moz-grabbing';
                _this.container.style.cursor = '-webkit-grabbing';
            }  
            //Velocity
            if (!velocityPrevPosition) velocityPrevPosition = _this.touches.current;
            if (!velocityPrevTime) velocityPrevTime = (new Date).getTime()
            _this.velocity = (_this.touches.current - velocityPrevPosition)/((new Date).getTime() - velocityPrevTime)/2
            if (Math.abs(_this.touches.current - velocityPrevPosition)<2) _this.velocity=0
            velocityPrevPosition = _this.touches.current
            velocityPrevTime = (new Date).getTime()
            //Callbacks
            _this.callPlugins('onTouchMoveEnd');
            if (params.onTouchMove) params.onTouchMove(_this)

            return false
        }
    }
    function onTouchEnd(event) {
        //Check For scrolling
        if (isScrolling) _this.swipeReset();
        // If slider is not touched exit
        if ( params.onlyExternal || !_this.isTouched ) return;
        _this.isTouched = false

        //Return Grab Cursor
        if (params.grabCursor) {
            _this.container.style.cursor = 'move';
            _this.container.style.cursor = 'grab';
            _this.container.style.cursor = '-moz-grab';
            _this.container.style.cursor = '-webkit-grab';
        } 

        //Check for Current Position
        if (!_this.positions.current && _this.positions.current!==0) {
            _this.positions.current = _this.positions.start 
        }
        
        //For case if slider touched but not moved
        if (params.followFinger) {
            if (isH) _this.setWrapperTranslate( _this.positions.current, 0, 0)
            else _this.setWrapperTranslate( 0, _this.positions.current, 0)
        }
        //--
        
        // TouchEndTime
        _this.times.end = (new Date()).getTime();
        
        //Difference
        _this.touches.diff = _this.touches.current - _this.touches.start        
        _this.touches.abs = Math.abs(_this.touches.diff)
        
        _this.positions.diff = _this.positions.current - _this.positions.start
        _this.positions.abs = Math.abs(_this.positions.diff)
        
        var diff = _this.positions.diff ;
        var diffAbs =_this.positions.abs ;
        var timeDiff = _this.times.end - _this.times.start

        if(diffAbs < 5 && (timeDiff) < 300 && _this.allowLinks == false) {
            if (!params.freeMode && diffAbs!=0) _this.swipeReset()
            //Release inner links
            if (params.preventLinks) {
                _this.allowLinks = true;
            }
            if (params.onSlideClick) {
                _this.allowSlideClick = true;
            }
        }
        setTimeout(function(){
            //Release inner links
            if (params.preventLinks) {
                _this.allowLinks = true;
            }
            if (params.onSlideClick) {
                _this.allowSlideClick = true;
            }
        },100)


        //Exit if not moved
        if (!_this.isMoved) {
            _this.isMoved = false;
            if (params.onTouchEnd) params.onTouchEnd(_this)
            _this.callPlugins('onTouchEnd');
            return;
        }
        _this.isMoved = false;
        
        var maxPosition = maxWrapperPosition();
        
        //Prevent Negative Back Sliding
        if (_this.positions.current > 0) {
            _this.swipeReset()
            if (params.onTouchEnd) params.onTouchEnd(_this)
            _this.callPlugins('onTouchEnd');
            return;
        }
        //Prevent After-End Sliding
        if (_this.positions.current < -maxPosition) {
            _this.swipeReset()
            if (params.onTouchEnd) params.onTouchEnd(_this)
            _this.callPlugins('onTouchEnd');
            return;
        }
        
        //Free Mode
        if (params.freeMode) {
            if ( params.freeModeFluid ) {
                var momentumDuration = 1000*params.momentumRatio;
                var momentumDistance = _this.velocity*momentumDuration;
                var newPosition = _this.positions.current + momentumDistance
                var doBounce = false;
                var afterBouncePosition;
                var bounceAmount = Math.abs( _this.velocity )*20*params.momentumBounceRatio;
                if (newPosition < -maxPosition) {
                    if (params.momentumBounce && _this.support.transitions) {
                        if (newPosition + maxPosition < -bounceAmount) newPosition = -maxPosition-bounceAmount;
                        afterBouncePosition = -maxPosition;
                        doBounce=true;
                        allowMomentumBounce = true;
                    }
                    else newPosition = -maxPosition;
                }
                if (newPosition > 0) {
                    if (params.momentumBounce && _this.support.transitions) {
                        if (newPosition>bounceAmount) newPosition = bounceAmount;
                        afterBouncePosition = 0
                        doBounce = true;
                        allowMomentumBounce = true;
                    }
                    else newPosition = 0;
                }
                //Fix duration
                if (_this.velocity!=0) momentumDuration = Math.abs((newPosition - _this.positions.current)/_this.velocity)
                
                if (isH) _this.setWrapperTranslate( newPosition, 0, 0);
                else _this.setWrapperTranslate( 0, newPosition, 0);

                _this.setWrapperTransition( momentumDuration );

                if (params.momentumBounce && doBounce) {
                    _this.wrapperTransitionEnd(function(){
                        if (!allowMomentumBounce) return;
                        if (params.onMomentumBounce) params.onMomentumBounce(_this);
                        if (isH) _this.setWrapperTranslate(afterBouncePosition, 0, 0);
                        else _this.setWrapperTranslate(0, afterBouncePosition, 0);
                        _this.setWrapperTransition(300);
                    })
                }

                _this.updateActiveSlide(newPosition)
            }
            if (!params.freeModeFluid || timeDiff >= 300) _this.updateActiveSlide(_this.positions.current)

            if (params.onTouchEnd) params.onTouchEnd(_this)
            _this.callPlugins('onTouchEnd');
            return;
        }
        
        //Direction
        direction = diff < 0 ? "toNext" : "toPrev"
        
        //Short Touches
        if (direction=="toNext" && ( timeDiff <= 300 ) ) {
            if (diffAbs < 30 || !params.shortSwipes) _this.swipeReset()
            else _this.swipeNext(true);
        }
        
        if (direction=="toPrev" && ( timeDiff <= 300 ) ) {
            if (diffAbs < 30 || !params.shortSwipes) _this.swipeReset()
            else _this.swipePrev(true);
        }

        //Long Touches
        var targetSlideSize = 0;
        if(params.slidesPerView == 'auto') {
            //Define current slide's width
            var currentPosition = Math.abs( isH ? _this.getWrapperTranslate('x') : _this.getWrapperTranslate('y') );
            var slidesOffset = 0;
            var _slideSize;
            for (var i=0; i<_this.slides.length; i++) {
                _slideSize = isH ? _this.slides[i].getWidth(true) : _this.slides[i].getHeight(true);
                slidesOffset+= _slideSize;
                if (slidesOffset>currentPosition) {
                    targetSlideSize = _slideSize;
                    break;
                }
            }
            if (targetSlideSize>containerSize) targetSlideSize = containerSize;
        }
        else {
            targetSlideSize = slideSize * params.slidesPerView;
        }
        if (direction=="toNext" && ( timeDiff > 300 ) ) {
            if (diffAbs >= targetSlideSize*0.5) {
                _this.swipeNext(true)
            }
            else {
                _this.swipeReset()
            }
        }
        if (direction=="toPrev" && ( timeDiff > 300 ) ) {
            if (diffAbs >= targetSlideSize*0.5) {
                _this.swipePrev(true);
            }
            else {
                _this.swipeReset()
            }
        }
        if (params.onTouchEnd) params.onTouchEnd(_this)
        _this.callPlugins('onTouchEnd');
    }
    
    /*==================================================
        Swipe Functions
    ====================================================*/
    _this.swipeNext = function(internal){
        if (!internal && params.loop) _this.fixLoop();
        _this.callPlugins('onSwipeNext');
        var currentPosition = isH ? _this.getWrapperTranslate('x') : _this.getWrapperTranslate('y');
        var newPosition = currentPosition;
        if (params.slidesPerView=='auto') {
            for (var i=0; i<_this.snapGrid.length; i++) {
                if (-currentPosition >= _this.snapGrid[i] && -currentPosition<_this.snapGrid[i+1]) {
                    newPosition = -_this.snapGrid[i+1]
                    break;
                }
            }
        }
        else {
            var groupSize = slideSize * params.slidesPerGroup;
            newPosition = -(Math.floor(Math.abs(currentPosition)/Math.floor(groupSize))*groupSize + groupSize); 
        }
        if (newPosition < - maxWrapperPosition()) {
            newPosition = - maxWrapperPosition()
        };
        
        if (newPosition == currentPosition) return false;        

        swipeToPosition(newPosition, 'next');
        return true
    }
    _this.swipePrev = function(internal){
        if (!internal && params.loop) _this.fixLoop();
        if (!internal && params.autoplay) _this.stopAutoplay();
        _this.callPlugins('onSwipePrev');

        var currentPosition = Math.ceil( isH ? _this.getWrapperTranslate('x') : _this.getWrapperTranslate('y') );
        var newPosition;
        if (params.slidesPerView=='auto') {
            newPosition = 0;
            for (var i=1; i<_this.snapGrid.length; i++) {
                if (-currentPosition == _this.snapGrid[i]) {
                    newPosition = -_this.snapGrid[i-1]
                    break;
                }
                if (-currentPosition > _this.snapGrid[i] && -currentPosition<_this.snapGrid[i+1]) {
                    newPosition = -_this.snapGrid[i]
                    break;
                }
            }
        }
        else {
            var groupSize = slideSize * params.slidesPerGroup;
            newPosition = -(Math.ceil(-currentPosition/groupSize)-1)*groupSize;
        }
        
        if (newPosition > 0) newPosition = 0;

        if (newPosition == currentPosition) return false;        
        swipeToPosition(newPosition, 'prev');
        return true;
        
    }
    _this.swipeReset = function(){
        _this.callPlugins('onSwipeReset');
        var currentPosition = isH ? _this.getWrapperTranslate('x') : _this.getWrapperTranslate('y');
        var groupSize = slideSize * params.slidesPerGroup;
        var newPosition;
        var maxPosition = -maxWrapperPosition();
        if (params.slidesPerView=='auto') {
            newPosition = 0;
            for (var i=0; i<_this.snapGrid.length; i++) {
                if (-currentPosition >= _this.snapGrid[i] && -currentPosition<_this.snapGrid[i+1]) {
                    if(_this.positions.diff>0) newPosition = -_this.snapGrid[i+1]
                    else newPosition = -_this.snapGrid[i]    
                    break;
                }
            }
            if (-currentPosition >= _this.snapGrid[_this.snapGrid.length-1]) newPosition = -_this.snapGrid[_this.snapGrid.length-1];
            if (currentPosition <= -maxWrapperPosition()) newPosition = -maxWrapperPosition()
        }
        else {
            newPosition = currentPosition<0 ? Math.round(currentPosition/groupSize)*groupSize : 0
        }
        if (params.scrollContainer)  {
            newPosition = currentPosition<0 ? currentPosition : 0;
        }
        if (newPosition < -maxWrapperPosition()) {
            newPosition = -maxWrapperPosition()
        }
        if (params.scrollContainer && (containerSize>slideSize)) {
            newPosition = 0;
        }

        if (newPosition == currentPosition) return false;

        swipeToPosition(newPosition, 'reset');
        return true;
    }
    _this.swipeTo = function(index, speed, runCallbacks){
        index = parseInt(index, 10); 
        _this.callPlugins('onSwipeTo', {index:index, speed:speed});
        if (params.loop) index = index + _this.loopedSlides;
        var currentPosition = isH ? _this.getWrapperTranslate('x') : _this.getWrapperTranslate('y');
        if (index > (_this.slides.length-1)) return;
        if (index<0) return;
        var newPosition
        if (params.slidesPerView=='auto') {
            newPosition = -_this.slidesGrid[ index ];
        }
        else {
            newPosition =  -index*slideSize;
        }
        if (newPosition < - maxWrapperPosition()) {
            newPosition = - maxWrapperPosition();
        };
        
        if (newPosition == currentPosition) return false;

        runCallbacks = runCallbacks===false ? false : true;
        swipeToPosition(newPosition, 'to', {index:index, speed:speed, runCallbacks:runCallbacks});
        return true;
    }
    function swipeToPosition(newPosition, action, toOptions) {
        if (_this.support.transitions || !params.DOMAnimation) {
            if (isH) _this.setWrapperTranslate(newPosition,0,0);
            else _this.setWrapperTranslate(0,newPosition,0);
            var speed = (action=='to' && toOptions.speed>=0) ? toOptions.speed : params.speed;
            _this.setWrapperTransition(speed);    
        }
        else {
            //Try the DOM animation
            var currentPosition = isH ? _this.getWrapperTranslate('x') : _this.getWrapperTranslate('y');
            var speed = (action=='to' && toOptions.speed>=0) ? toOptions.speed : params.speed;
            var animationStep = Math.ceil( (newPosition - currentPosition)/speed*(1000/60) );
            var direction = currentPosition > newPosition ? 'toNext' : 'toPrev';
            var condition = direction=='toNext' ? currentPosition > newPosition : currentPosition < newPosition;
            if (_this._DOMAnimating) return;
            function anim(){
                currentPosition += animationStep;
                condition = direction=='toNext' ? currentPosition > newPosition : currentPosition < newPosition;
                if (condition) {
                    if (isH) _this.setWrapperTranslate(Math.round(currentPosition),0)
                    else _this.setWrapperTranslate(0,Math.round(currentPosition))
                    _this._DOMAnimating = true
                    window.setTimeout(function(){
                        anim()
                    }, 1000 / 60)
                }
                else {
                    if (params.onSlideChangeEnd) params.onSlideChangeEnd(_this)
                    if (isH) _this.setWrapperTranslate(newPosition,0);
                    else _this.setWrapperTranslate(0, newPosition);
                    _this._DOMAnimating = false;
                }
            }
            anim()
        }

        //Update Active Slide Index
        _this.updateActiveSlide(newPosition);

        //Callbacks
        if (params.onSlideNext && action=='next') {
            params.onSlideNext(_this, newPosition)
        }
        if (params.onSlidePrev && action=='prev') {
            params.onSlidePrev(_this, newPosition)
        }
        //"Reset" Callback
        if (params.onSlideReset && action=='reset') {
            params.onSlideReset(_this, newPosition)
        }

        //"Next", "Prev" and "To" Callbacks
        if (action=='next' || action=='prev' || (action=='to' && toOptions.runCallbacks==true))
            slideChangeCallbacks()
    }

    /*==================================================
        Transition Callbacks
    ====================================================*/
    //Prevent Multiple Callbacks 
    _this._queueStartCallbacks = false;
    _this._queueEndCallbacks = false;
    function slideChangeCallbacks() {
        //Transition Start Callback
        _this.callPlugins('onSlideChangeStart');
        if (params.onSlideChangeStart) {
            if (params.queueStartCallbacks && _this.support.transitions) {
                if (_this._queueStartCallbacks) return;
                _this._queueStartCallbacks = true;
                params.onSlideChangeStart(_this)
                _this.wrapperTransitionEnd(function(){
                    _this._queueStartCallbacks = false;
                })    
            }
            else params.onSlideChangeStart(_this)
        }
        //Transition End Callback
        if (params.onSlideChangeEnd) {
            if (_this.support.transitions) {
                if (params.queueEndCallbacks) {
                    if (_this._queueEndCallbacks) return;
                    _this._queueEndCallbacks = true;
                    _this.wrapperTransitionEnd(params.onSlideChangeEnd)
                }
                else _this.wrapperTransitionEnd(params.onSlideChangeEnd)
            }
            else {
                if (!params.DOMAnimation) {
                    setTimeout(function(){
                        params.onSlideChangeEnd(_this)
                    },10)
                }
            }
        }
    }
    /*==================================================
        Update Active Slide Index
    ====================================================*/
    _this.updateActiveSlide = function(position) {
        if (!_this.initialized) return;
        if (_this.slides.length==0) return;
        _this.previousIndex = _this.activeIndex;
        if (position>0) position=0;
        if (typeof position=='undefined') position = isH ? _this.getWrapperTranslate('x') : _this.getWrapperTranslate('y');

        if (params.slidesPerView == 'auto') {
            var slidesOffset = 0;
            _this.activeIndex = 0;
            for ( var i = 0; i < _this.slides.length; i++ ) {
                slidesOffset += isH ? _this.h.getWidth(_this.slides[i], true) : _this.h.getHeight(_this.slides[i], true)
                _this.activeIndex = i;
                if(slidesOffset > Math.abs(position)) break;
            };
        }
        else {
            if (params.visibilityFullFit) _this.activeIndex = Math.ceil( -position/slideSize );
            else _this.activeIndex = Math.round( -position/slideSize )
            
        }
        if (_this.activeIndex== _this.slides.length ) _this.activeIndex = _this.slides.length-1
        if (_this.activeIndex<0) _this.activeIndex = 0

        // Check for slide
        if (!_this.slides[_this.activeIndex]) return;
        // Calc Visible slides
        _this.calcVisibleSlides(position);

        // Mark visible and active slides with additonal classes
        var activeClassRegexp = new RegExp( "\\s*" + params.slideActiveClass );
        var inViewClassRegexp = new RegExp( "\\s*" + params.slideVisibleClass );

        for (var i = 0; i < _this.slides.length; i++) {
            _this.slides[ i ].className = _this.slides[ i ].className.replace( activeClassRegexp, '' ).replace( inViewClassRegexp, '' );
            if ( _this.visibleSlides.indexOf( _this.slides[ i ] )>=0 ) {
                _this.slides[ i ].className += ' ' + params.slideVisibleClass;        
            }

        }
        _this.slides[ _this.activeIndex ].className += ' ' + params.slideActiveClass;

        //Update loop index
        if (params.loop) {
            var ls = _this.loopedSlides;
            _this.loopIndex = _this.activeIndex - ls;
            if (_this.loopIndex >= _this.slides.length - ls*2 ) {
                _this.loopIndex = _this.slides.length - ls*2 - _this.loopIndex;
            }
            if (_this.loopIndex<0) {
                _this.loopIndex = _this.slides.length - ls*2 + _this.loopIndex;
            }
        }
        else {
            _this.loopIndex = _this.activeIndex;
        }
        //Update Pagination
        if (params.pagination) {
            _this.updatePagination(position);
        }
    }
    /*==================================================
        Pagination
    ====================================================*/
    _this.createPagination = function (firstInit) {
        if (params.paginationClickable && _this.paginationButtons) {
            removePaginationEvents();
        }
        var paginationHTML = "";
        var numOfSlides = _this.slides.length;
        var numOfButtons = numOfSlides;
        if (params.loop) numOfButtons -= _this.loopedSlides*2
        for (var i = 0; i < numOfButtons; i++) {
            paginationHTML += '<'+params.paginationElement+' class="'+params.paginationElementClass+'"></'+params.paginationElement+'>'
        }
        _this.paginationContainer = params.pagination.nodeType ? params.pagination : $$(params.pagination)[0];
        _this.paginationContainer.innerHTML = paginationHTML;
        _this.paginationButtons = []
        if (document.querySelectorAll)
            _this.paginationButtons = _this.paginationContainer.querySelectorAll('.'+params.paginationElementClass);
        else if (window.jQuery)
            _this.paginationButtons = $$(_this.paginationContainer).find('.'+params.paginationElementClass);

        if (!firstInit) _this.updatePagination()
        _this.callPlugins('onCreatePagination');
        if (params.paginationClickable) {
            addPaginationEvents();
        }
    }
    function removePaginationEvents() {
        var pagers = _this.paginationButtons;
        for (var i=0; i<pagers.length; i++) {
            _this.h.removeEventListener(pagers[i],'click', paginationClick, false)
        }
    }
    function addPaginationEvents() {
        var pagers = _this.paginationButtons;
        for (var i=0; i<pagers.length; i++) {
            _this.h.addEventListener(pagers[i],'click', paginationClick, false)
        }
    }
    function paginationClick(e){
        var index;
        var target = e.target || e.srcElement;
        var pagers = _this.paginationButtons;
        for (var i=0; i<pagers.length; i++) {
            if (target===pagers[i]) index = i;
        }
        _this.swipeTo(index)
    }
    _this.updatePagination = function(position) {
        if (_this.slides.length<1) return;

        if (document.querySelectorAll)
            var activePagers = _this.paginationContainer.querySelectorAll('.'+params.paginationActiveClass)
        else if (window.jQuery)
            var activePagers = $$(_this.paginationContainer).find('.'+params.paginationActiveClass);
        
        if(!activePagers) return
        //Reset all Buttons' class to not active
        var pagers = _this.paginationButtons;
        for (var i=0; i < pagers.length; i++) {
            pagers[i].className = params.paginationElementClass
        }
        var indexOffset = params.loop ? _this.loopedSlides : 0;
        if (params.paginationAsRange) {
            if (!_this.visibleSlides) _this.calcVisibleSlides(position)
            //Get Visible Indexes    
            var visibleIndexes = [];
            for (var i = 0; i < _this.visibleSlides.length; i++) {
                var visIndex = _this.slides.indexOf( _this.visibleSlides[i] ) - indexOffset

                if (params.loop && visIndex<0) {
                    visIndex = _this.slides.length - _this.loopedSlides*2 + visIndex;
                }
                if (params.loop && visIndex>=_this.slides.length-_this.loopedSlides*2) {
                    visIndex = _this.slides.length - _this.loopedSlides*2 - visIndex;
                    visIndex = Math.abs(visIndex)
                }
                visibleIndexes.push( visIndex )
            }
            for (i=0; i<visibleIndexes.length; i++) {
                if (pagers[ visibleIndexes[i] ]) pagers[ visibleIndexes[i] ].className += ' ' + params.paginationVisibleClass;
            }
            if (params.loop) {
                pagers[ _this.loopIndex ].className += ' ' + params.paginationActiveClass;
            }
            else {
                pagers[ _this.activeIndex ].className += ' ' + params.paginationActiveClass;   
            }
        }
        else {
            if (params.loop) {
                pagers[ _this.loopIndex ].className+=' '+params.paginationActiveClass+' '+params.paginationVisibleClass;
            }
            else {
                pagers[ _this.activeIndex ].className+=' '+params.paginationActiveClass+' '+params.paginationVisibleClass;    
            }
            
        }
        
    }
    _this.calcVisibleSlides = function(position){
        var visibleSlides = [];
        var _slideLeft = 0, _slideSize = 0, _slideRight = 0;
        if (isH && _this.wrapperLeft>0) position = position+_this.wrapperLeft;
        if (!isH && _this.wrapperTop>0) position = position+_this.wrapperTop;

        for (var i=0; i<_this.slides.length; i++) {
            _slideLeft += _slideSize;
            if (params.slidesPerView == 'auto')
                _slideSize  = isH ? _this.h.getWidth(_this.slides[i],true) : _this.h.getHeight(_this.slides[i],true);
            else _slideSize = slideSize;

            _slideRight = _slideLeft + _slideSize;
            var isVisibile = false;
            if (params.visibilityFullFit) {
                if (_slideLeft >= -position && _slideRight <= -position+containerSize) isVisibile = true;
                if (_slideLeft <= -position && _slideRight >= -position+containerSize) isVisibile = true;
            }
            else {
                if (_slideRight > -position && _slideRight <= ((-position+containerSize))) isVisibile = true;
                if (_slideLeft >= -position && _slideLeft < ((-position+containerSize))) isVisibile = true;
                if (_slideLeft < -position && _slideRight > ((-position+containerSize))) isVisibile = true;
            }
                
            if (isVisibile) visibleSlides.push(_this.slides[i])

        }
        if (visibleSlides.length==0) visibleSlides = [ _this.slides[ _this.activeIndex ] ]

        _this.visibleSlides = visibleSlides;
    }

    /*========================================== 
        Autoplay 
    ============================================*/
    var autoPlayInterval
    _this.startAutoplay = function() {
        if (params.autoplay && !params.loop) {
            autoPlayInterval = setInterval(function(){
                if (!_this.swipeNext(true)) _this.swipeTo(0);
            }, params.autoplay)
        }
        if (params.autoplay && params.loop) {
            autoPlay = setInterval(function(){
                _this.swipeNext()
            }, params.autoplay)
        }
        _this.callPlugins('onAutoplayStart');
    }
    _this.stopAutoplay = function() {
        if (autoPlayInterval) clearInterval(autoPlayInterval);
        _this.callPlugins('onAutoplayStop');
    }
    /*==================================================
        Loop
    ====================================================*/  
    _this.loopCreated = false;
    _this.removeLoopedSlides = function(){
        if (_this.loopCreated) {
            for (var i=0; i<_this.slides.length; i++) {
                if (_this.slides[i].getData('looped')===true) _this.wrapper.removeChild(_this.slides[i]);
            }
        }
    }
    _this.createLoop = function(){
        if (_this.slides.length==0) return;
        _this.loopedSlides = params.slidesPerView+params.loopAdditionalSlides;

        var slideFirstHTML = '';
        var slideLastHTML = '';

        //Grab First Slides
        for (var i=0; i<_this.loopedSlides; i++) {
            slideFirstHTML+=_this.slides[i].outerHTML
        }
        //Grab Last Slides
        for (i=_this.slides.length-_this.loopedSlides; i<_this.slides.length; i++) {
            slideLastHTML+=_this.slides[i].outerHTML
        }
        wrapper.innerHTML = slideLastHTML + wrapper.innerHTML + slideFirstHTML;

        _this.loopCreated = true;
        _this.calcSlides();

        //Update Looped Slides with special class
        for (i=0; i<_this.slides.length; i++) {
            if (i<_this.loopedSlides || i>=_this.slides.length-_this.loopedSlides) _this.slides[i].setData('looped', true);
        }
        _this.callPlugins('onCreateLoop');

    }
    _this.fixLoop = function(){  
        //Fix For Negative Oversliding
        if (_this.activeIndex < _this.loopedSlides) {
            var newIndex = _this.slides.length - _this.loopedSlides*3 + _this.activeIndex;
            _this.swipeTo(newIndex, 0, false)
        }
        //Fix For Positive Oversliding
        else if (_this.activeIndex > _this.slides.length - params.slidesPerView*2) {
            var newIndex = -_this.slides.length + _this.activeIndex + _this.loopedSlides
            _this.swipeTo(newIndex,0, false)
        }
    }
    /*==================================================
        Slides Loader
    ====================================================*/
    _this.loadSlides = function(){
        var slidesHTML = '';
        _this.activeLoaderIndex = 0;
        for (var i=0; i< params.slidesPerView*(1+params.loader.surroundGroups); i++) {
            if (params.loader.slidesHTMLType=='outer') slidesHTML+=params.loader.slides[i];
            else {
                slidesHTML+='<'+params.slideElement+' class="'+params.slideClass+'" data-swiperindex="'+i+'">'+params.loader.slides[i]+'</'+params.slideElement+'>'
            }
        }
        _this.wrapper.innerHTML = slidesHTML;
        _this.calcSlides(true);
        //Add permanent transitionEnd callback
        _this.wrapperTransitionEnd(_this.reloadSlides, true)
    }
    _this.reloadSlides = function(){

        var newActiveIndex = parseInt(_this.activeSlide().data('swiperindex'),10)
        if (newActiveIndex<0 || newActiveIndex>params.loader.slides.length-1) return //<-- Exit 
        _this.activeLoaderIndex = newActiveIndex;
        var firstIndex = Math.max(0, newActiveIndex - params.slidesPerView*params.loader.surroundGroups)
        var lastIndex = Math.min(newActiveIndex+params.slidesPerView*(1+params.loader.surroundGroups)-1, params.loader.slides.length-1)

        //Remove All Slides
        _this.wrapper.innerHTML = '';

        //New Slides
        var slidesHTML = '';
        for (var i = firstIndex; i<=lastIndex; i++) {
            slidesHTML += params.loader.slidesHTMLType == 'outer' ? params.loader.slides[i] : '<'+params.slideElement+' class="'+params.slideClass+'" data-swiperindex="'+i+'">'+params.loader.slides[i]+'</'+params.slideElement+'>'
        }
        _this.wrapper.innerHTML = slidesHTML;
        
        //Update Transforms
        if (newActiveIndex>0) {
            var newTransform = -slideSize*(newActiveIndex-firstIndex)
            _this.setWrapperTransition(0)
            if (isH) _this.setWrapperTranslate(newTransform,0,0)
            else _this.setWrapperTranslate(0,newTransform,0)
        }
        //reInit
        _this.reInit(true);
    }
    /*==================================================
        Make Swiper
    ====================================================*/
    function makeSwiper(){
        _this.calcSlides();
        if (params.loader.slides.length>0 && _this.slides.length==0) {
            _this.loadSlides();
        }
        if (params.loop) {
            _this.createLoop();
        }
        _this.init();
        initEvents();
        if (params.pagination && params.createPagination) {
            _this.createPagination(true);
        }
        if (params.loop || params.initialSlide>0) {
            _this.swipeTo( params.initialSlide, 0, false );
        }
        else {
            _this.updateActiveSlide(0);
        }
        if (params.autoplay) {
            _this.startAutoplay();
        }
        
    }
    makeSwiper();
}

Swiper.prototype = {
    plugins : {},
    /*==================================================
        Wrapper Operations
    ====================================================*/
    wrapperTransitionEnd : function(callback, permanent) {
        var a = this
        var el = a.wrapper
        var events = ['webkitTransitionEnd','transitionend', 'oTransitionEnd', 'MSTransitionEnd', 'msTransitionEnd'];
        if (callback) {
            function fireCallBack() {
                callback(a)
                if (a.params.queueEndCallbacks) a._queueEndCallbacks = false
                if (!permanent) {
                    for (var i=0; i<events.length; i++) {
                        el.removeEventListener(events[i], fireCallBack, false)
                    }
                }
            }
            for (var i=0; i<events.length; i++) {
                el.addEventListener(events[i], fireCallBack, false)
            }
        }
    },

    getWrapperTranslate : function(axis){
        var el = this.wrapper
        var matrix;
        var curTransform;
        if (window.WebKitCSSMatrix) {
            var transformMatrix = new WebKitCSSMatrix(window.getComputedStyle(el, null).webkitTransform)
            matrix = transformMatrix.toString().split(',');
        }
        else {
            var transformMatrix =   window.getComputedStyle(el, null).MozTransform || window.getComputedStyle(el, null).OTransform || window.getComputedStyle(el, null).MsTransform || window.getComputedStyle(el, null).msTransform  || window.getComputedStyle(el, null).transform|| window.getComputedStyle(el, null).getPropertyValue("transform").replace("translate(", "matrix(1, 0, 0, 1,");
            matrix = transformMatrix.toString().split(',');
            
        }
        if (this.params.useCSS3Transforms) { 
            if (axis=='x') {
                //Crazy IE10 Matrix
                if (matrix.length==16) 
                    curTransform = parseFloat( matrix[12] )
                //Latest Chrome and webkits Fix
                else if (window.WebKitCSSMatrix)
                    curTransform = transformMatrix.m41
                //Normal Browsers
                else 
                    curTransform = parseFloat( matrix[4] )
            }
            if (axis=='y') {
                //Crazy IE10 Matrix
                if (matrix.length==16) 
                    curTransform = parseFloat( matrix[13] )
                //Latest Chrome and webkits Fix
                else if (window.WebKitCSSMatrix)
                    curTransform = transformMatrix.m42
                //Normal Browsers
                else 
                    curTransform = parseFloat( matrix[5] )
            }
        }
        else {
            if (axis=='x') curTransform = parseFloat(el.style.left,10) || 0
            if (axis=='y') curTransform = parseFloat(el.style.top,10) || 0
        }
        return curTransform || 0;
    },

    setWrapperTranslate : function(x,y,z) {
        var es = this.wrapper.style
        x=x||0;
        y=y||0;
        z=z||0;
        if (this.params.useCSS3Transforms) {
            if (this.support.transforms3d) {
                es.webkitTransform = es.MsTransform = es.msTransform = es.MozTransform = es.OTransform = es.transform = 'translate3d('+x+'px, '+y+'px, '+z+'px)'
            }
            else {
                
                es.webkitTransform = es.MsTransform = es.msTransform = es.MozTransform = es.OTransform = es.transform = 'translate('+x+'px, '+y+'px)'
                if (!this.support.transforms) {
                    es.left = x+'px'
                    es.top = y+'px'
                }
            }
        }
        else {
            es.left = x+'px';
            es.top = y+'px';
        }
        this.callPlugins('onSetWrapperTransform', {x:x, y:y, z:z})
    },
    
    setWrapperTransition : function(duration) {
        var es = this.wrapper.style
        es.webkitTransitionDuration = es.MsTransitionDuration = es.msTransitionDuration = es.MozTransitionDuration = es.OTransitionDuration = es.transitionDuration = duration/1000+'s';
        this.callPlugins('onSetWrapperTransition', {duration: duration})
    },

    /*==================================================
        Helpers
    ====================================================*/
    h : {
        getWidth: function (el, outer) {
            var width = window.getComputedStyle(el, null).getPropertyValue('width')
            var returnWidth = parseFloat(width);
            //IE Fixes
            if(isNaN(returnWidth) || width.indexOf('%')>0) {
                returnWidth = el.offsetWidth - parseFloat(window.getComputedStyle(el, null).getPropertyValue('padding-left')) - parseFloat(window.getComputedStyle(el, null).getPropertyValue('padding-right'));
            }
            if (outer) returnWidth += parseFloat(window.getComputedStyle(el, null).getPropertyValue('padding-left')) + parseFloat(window.getComputedStyle(el, null).getPropertyValue('padding-right'))

            return returnWidth;
        },
        getHeight: function(el, outer) {
            if (outer) return el.offsetHeight;
            
            var height = window.getComputedStyle(el, null).getPropertyValue('height')
            var returnHeight = parseFloat(height);
            //IE Fixes
            if(isNaN(returnHeight) || height.indexOf('%')>0) {
                returnHeight = el.offsetHeight - parseFloat(window.getComputedStyle(el, null).getPropertyValue('padding-top')) - parseFloat(window.getComputedStyle(el, null).getPropertyValue('padding-bottom'));
            }
            if (outer) returnHeight += parseFloat(window.getComputedStyle(el, null).getPropertyValue('padding-top')) + parseFloat(window.getComputedStyle(el, null).getPropertyValue('padding-bottom'))
            return returnHeight;
        },
        getOffset: function(el) {
            var box = el.getBoundingClientRect();
            var body = document.body;
            clientTop  = el.clientTop  || body.clientTop  || 0;
            clientLeft = el.clientLeft || body.clientLeft || 0;
            scrollTop  = window.pageYOffset || el.scrollTop;
            scrollLeft = window.pageXOffset || el.scrollLeft;
            if (document.documentElement && !window.pageYOffset) {
                //IE7-8
                scrollTop  = document.documentElement.scrollTop;
                scrollLeft = document.documentElement.scrollLeft;
            }
            return {
                top: box.top  + scrollTop  - clientTop,
                left: box.left + scrollLeft - clientLeft
            };
        },
        windowWidth : function() {
            if (window.innerWidth) return window.innerWidth
            else if (document.documentElement && document.documentElement.clientWidth) return document.documentElement.clientWidth; 
        },
        windowHeight : function() {
            if (window.innerHeight) return window.innerHeight
            else if (document.documentElement && document.documentElement.clientHeight) return document.documentElement.clientHeight; 
        },
        windowScroll : function() {
            var left=0, top=0;
            if (typeof pageYOffset != 'undefined') {
                return {
                    left: window.pageXOffset,
                    top: window.pageYOffset
                }
            }
            else if (document.documentElement) {
                return {
                    left: document.documentElement.scrollLeft,
                    top: document.documentElement.scrollTop
                }
            }
        },

        addEventListener : function (el, event, listener, useCapture) {
            if (el.addEventListener) {
                el.addEventListener(event, listener, useCapture)
            }
            else if (el.attachEvent) {
                el.attachEvent('on'+event, listener)
            }
        },
        removeEventListener : function (el, event, listener, useCapture) {
            if (el.removeEventListener) {
                el.removeEventListener(event, listener, useCapture)
            }
            else if (el.detachEvent) {
                el.detachEvent('on'+event, listener)
            }
        }
    },
    setTransform : function (el, transform) {
        var es = el.style
        es.webkitTransform = es.MsTransform = es.msTransform = es.MozTransform = es.OTransform = es.transform = transform
    },
    setTranslate : function (el, translate) {
        var es = el.style
        var pos = {
            x : translate.x || 0,
            y : translate.y || 0,
            z : translate.z || 0
        };
        var transformString = this.support.transforms3d ? 'translate3d('+(pos.x)+'px,'+(pos.y)+'px,'+(pos.z)+'px)' : 'translate('+(pos.x)+'px,'+(pos.y)+'px)';
        es.webkitTransform = es.MsTransform = es.msTransform = es.MozTransform = es.OTransform = es.transform = transformString;
        if (this.support.transforms) {
            es.left = pos.x+'px'
            es.top = pos.y+'px'
        }
    },
    setTransition : function (el, duration) {
        var es = el.style
        es.webkitTransitionDuration = es.MsTransitionDuration = es.msTransitionDuration = es.MozTransitionDuration = es.OTransitionDuration = es.transitionDuration = duration+'ms';
    },
    /*==================================================
        Feature Detection
    ====================================================*/ 
    support: {

        touch : (window.Modernizr && Modernizr.touch===true) || (function() {
            return !!(("ontouchstart" in window) || window.DocumentTouch && document instanceof DocumentTouch);
        })(),
            
        transforms3d : (window.Modernizr && Modernizr.csstransforms3d===true) || (function() {
            var div = document.createElement('div');
            return ( "webkitPerspective" in div.style || "MozPerspective" in div.style || "OPerspective" in div.style || "MsPerspective" in div.style || "perspective" in div.style );
        })(),

        transforms : (window.Modernizr && Modernizr.csstransforms===true) || (function(){
            var div = document.createElement('div').style
            return ('transform' in div) || ('WebkitTransform' in div) || ('MozTransform' in div) || ('msTransform' in div) || ('MsTransform' in div) || ('OTransform' in div);
        })(),

        transitions : (window.Modernizr && Modernizr.csstransitions===true) || (function(){
            var div = document.createElement('div').style
            return ('transition' in div) || ('WebkitTransition' in div) || ('MozTransition' in div) || ('msTransition' in div) || ('MsTransition' in div) || ('OTransition' in div);
        })()
    },

    browser : {

        ie8 : (function(){
            var rv = -1; // Return value assumes failure.
            if (navigator.appName == 'Microsoft Internet Explorer') {
                var ua = navigator.userAgent;
                var re = new RegExp("MSIE ([0-9]{1,}[\.0-9]{0,})");
                if (re.exec(ua) != null)
                    rv = parseFloat(RegExp.$1);
            }
            return rv != -1 && rv < 9;
        })(),

        ie10 : window.navigator.msPointerEnabled
    }
}

/*=========================
  jQuery & Zepto Plugins
  ===========================*/   
if (window.jQuery||window.Zepto) {
    (function($){
        $.fn.swiper = function(params) {
            var s = new Swiper($(this)[0], params)
            $(this).data('swiper',s);
            return s
        }
    })(window.jQuery||window.Zepto)
}












 
 

jQuery(document).ready(function($){ 
	 
	//move parallax sliders to correct dom location 

	var parallaxSlider = $('.parallax_slider_outer.first-section');
	parallaxSlider.insertBefore('.container-wrap');	
	
	
	var $smoothSrollWidth = ($('body').attr('data-smooth-scrolling') == '1') ? 0 : 0; //will come back to this 
	
	if($('body > #boxed').length == 0 && $('.nectar-slider-wrap[data-full-width="true"]').parent().attr('id') != 'portfolio-extra' && $('.nectar-slider-wrap[data-full-width="true"]').parents('#post-area:not(".span_12")').length == 0){ 
		$('.nectar-slider-wrap[data-full-width="true"], .parallax_slider_outer.first-section .nectar-slider-wrap').css('left', -(($(window).width()-$smoothSrollWidth)/2 - $('.main-content').width()/2))+'px';
		$('.nectar-slider-wrap[data-full-width="true"] .swiper-container, .nectar-slider-wrap[data-full-width="true"], .parallax_slider_outer.first-section .swiper-container, .parallax_slider_outer.first-section .nectar-slider-wrap').css('width',$(window).width());
	} 
	else if( $('.nectar-slider-wrap[data-full-width="true"]').parent().attr('id') == 'portfolio-extra' && $('#full_width_portfolio').length != 0){  
		$('.nectar-slider-wrap[data-full-width="true"], .parallax_slider_outer.first-section .nectar-slider-wrap').css('left', -(($(window).width()-$smoothSrollWidth)/2 - $('.main-content').width()/2))+'px';
		$('.nectar-slider-wrap[data-full-width="true"] .swiper-container, .nectar-slider-wrap[data-full-width="true"], .parallax_slider_outer.first-section .swiper-container, .parallax_slider_outer.first-section .nectar-slider-wrap').css('width',$(window).width());
	}
	else { 
		//var $container = ($('#portfolio-extra').length > 0) ? '#portfolio-extra' : '.container-wrap'; 
		//boxed portfolio
		//if($('body > #boxed').length > 0) $container = '.container-wrap';
		var $container = '.container-wrap'; 
		$('.nectar-slider-wrap .swiper-container, .nectar-slider-wrap, .parallax_slider_outer.first-section .swiper-container, .parallax_slider_outer.first-section .nectar-slider-wrap').css('width',$($container).width());
	}
	
	//show slider once full width calcs have taken place
	$('.nectar-slider-wrap').show();
	
	//videos
	$('.swiper-slide .slider-video').mediaelementplayer({
		enableKeyboard: false,
		iPadUseNativeControls: false,
   		// force iPhone's native controls
   		iPhoneUseNativeControls: false,
   		// force Android's native controls
   		AndroidUseNativeControls: false
	});
	
	//set bg colors / textures after js has made the slider fullwidth
	$('.swiper-container, .swiper-slide').css('background-color','#000');
	$('.video-texture').css('opacity','1');
	
	//nectar sliders
	var $nectarSliders = [];
	
	$('.nectar-slider-wrap').each(function(i){
		var $arrows = $(this).find('.swiper-container').attr('data-arrows');
		var $bullets = $(this).find('.swiper-container').attr('data-bullets');
		var $swipe = $(this).find('.swiper-container').attr('data-desktop-swipe');

		//swipe  
		if($swipe == 'true' && $('#'+$(this).attr('id') +' .swiper-wrapper > div').length > 1 ){
			var $grab = 1;
			var $desktopSwipe = 1;
		} else {
			var $grab = 0;
			var $desktopSwipe = 0;
		}

		//bullets
		if($bullets == 'true' && $(this).find('.swiper-wrapper > div').length > 1){
			$bullets = '#'+$(this).attr('id')+' .slider-pagination';
		} else {
			$bullets = null;
		}

		$nectarSliders[i] = new Swiper('#'+$(this).attr('id')+' .swiper-container', {
			loop: false,
			grabCursor: $grab,
			speed: 650,
			useCSS3Transforms: false,
			pagination : $bullets,
			simulateTouch : $desktopSwipe,
			onSlideChangeEnd: captionTransition,
			onSlideChangeStart: sliderArrowCount,
			onTouchMove: clearAutoplay
		});
		
		$nectarSliders[i].swipeReset();
		 
		//Navigation arrows
		if($arrows == 'true' && $('#'+$(this).attr('id') +' .swiper-wrapper > div').length > 1 ){
			
			$('.slide-count i').transition({ scale: 0 });
			
			//hover event
			$('.swiper-container .slider-prev, .swiper-container .slider-next').hover(function(){
				
				$(this).find('.slide-count i').clearQueue().stop(true,true).delay(100).transition({ scale: 1 },225);
				
				$(this).stop().animate({
					'width' : '120px'
				},300,'easeOutCubic');
				$(this).find('.slide-count span').clearQueue().stop().delay(100).animate({
					'opacity' : '1'
				},225,'easeOutCubic');
			},function(){
				
				$('.slide-count i').stop(true,true).transition({ scale: 0 },200);
				
				$(this).stop().animate({
					'width' : '64px'
				},300,'easeOutCubic');
				$(this).find('.slide-count span').stop(true,true).animate({
					'opacity' : '0'
				},200,'easeOutCubic');
			});
			
			//add slide counts
			$('#'+$(this).attr('id')+' .slider-prev .slide-count .slide-total').html( $('#'+$(this).attr('id') + ' .swiper-wrapper > div').length );
			$('#'+$(this).attr('id')+' .slider-next .slide-count .slide-total').html( $('#'+$(this).attr('id') + ' .swiper-wrapper > div').length );
			
			//prev
			$('#'+$(this).attr('id')+' .slider-prev').click(function(e) {
				
			   if($(this).hasClass('inactive')) return false;
			   
			   var $that = $(this); 
			   	
			   if( $(this).parents('.swiper-container').find('.swiper-slide-active').index()+1 == 1){
			   		
			   		//make sure the animation is complete
				   	 var $timeout;
				   
				     clearTimeout($timeout);
				     $timeout = setTimeout(function(){ $that.removeClass('inactive'); } ,700);
				     
			   		 $(this).parents('.swiper-container').find('.swiper-wrapper').stop(true,false).css('transition','none').animate({
			   		 	'left' : parseInt($(this).parents('.swiper-container').find('.swiper-wrapper').css('left')) + 20
			   		 },200,function(){
			   		 	$(this).parents('.swiper-container').find('.swiper-wrapper').stop(true,false).css('transition','left,top');
			   		 	$nectarSliders[i].swipeReset();
			   		 });
			   		 
			   		 $(this).addClass('inactive');
			   		
			   }	
				
			   e.preventDefault();
			   $nectarSliders[i].swipePrev();
			});
			
			//next
			$('#'+$(this).attr('id')+' .slider-next').click(function(e) {
			   
			   if($(this).hasClass('inactive')) return false;
			   
			   var $that = $(this); 	
			   var $slideNum = $(this).parents('.swiper-container').find('.swiper-wrapper > div').length;

			   if( $(this).parents('.swiper-container').find('.swiper-slide-active').index()+1 == $slideNum) {
			   		 
			   		 //make sure the animation is complete
				   	 var $timeout;
				   
				     clearTimeout($timeout);
				     $timeout = setTimeout(function(){ $that.removeClass('inactive'); } ,700);
				     
			   		 $(this).parents('.swiper-container').find('.swiper-wrapper').stop(true,false).css('transition','none').animate({
			   		 	'left' : parseInt($(this).parents('.swiper-container').find('.swiper-wrapper').css('left')) - 20
			   		 },200,function(){
			   		 	$(this).parents('.swiper-container').find('.swiper-wrapper').stop(true,false).css('transition','left,top');
			   		 	$nectarSliders[i].swipeReset();
			   		 });
			   		 
			   		 $(this).addClass('inactive');
			   }
			   
			   e.preventDefault();
			   $nectarSliders[i].swipeNext();
			   
			});
		}
	    //Clickable pagination
	    if($bullets != null && $('#'+$(this).attr('id') +' .swiper-wrapper > div').length > 1 ){
		    $('#'+$(this).attr('id')+' .slider-pagination .swiper-pagination-switch').click(function(){
		        $nectarSliders[i].swipeTo($(this).index());
		    });
	    }
	});
	
	
	
	
	
	//responsive slider

	var $sliderHeights = [];
	$('.swiper-container').each(function(i){
		$sliderHeights[i] = parseInt($(this).attr('data-height'));	
	});
	
	sliderSize();
	$(window).resize(sliderSize);
	function sliderSize(){
		
		//check for mobile first
		if( window.innerWidth < 1000 && window.innerWidth > 690 ) {
			
			//fullwidth sliders
			$('.nectar-slider-wrap[data-full-width="true"] .swiper-container').each(function(i){
				$(this).attr('data-height',$sliderHeights[i]/1.4 )	
			});
			
			//boxed sliders
			$('.nectar-slider-wrap[data-full-width="false"] .swiper-container, .nectar-slider-wrap[data-full-width="boxed-full-width"] .swiper-container').each(function(i){
				$(this).attr('data-height',$sliderHeights[i]/1.9 )	
			});
		} 
		
		else if( window.innerWidth <= 690 ) {
	      
	      //fullwidth sliders		
		  $('.nectar-slider-wrap[data-full-width="true"] .swiper-container').each(function(i){
			$(this).attr('data-height',$sliderHeights[i]/2.7 )	
		  });
		  
		  //boxed sliders
		  $('.nectar-slider-wrap[data-full-width="false"] .swiper-container, .nectar-slider-wrap[data-full-width="boxed-full-width"] .swiper-container').each(function(i){
			$(this).attr('data-height',$sliderHeights[i]/2.9 )	
		  });
		
		} 
		
		else if( window.innerWidth < 1300 && window.innerWidth >= 1000  ) {
	      
	      //fullwidth sliders		
		  $('.nectar-slider-wrap[data-full-width="true"] .swiper-container').each(function(i){
			$(this).attr('data-height',$sliderHeights[i]/1.2 )	
		  });
		  
		  //boxed sliders
		  $('.nectar-slider-wrap[data-full-width="false"] .swiper-container, .nectar-slider-wrap[data-full-width="boxed-full-width"] .swiper-container').each(function(i){
			$(this).attr('data-height',$sliderHeights[i]/1.2 )	
		  });
		
		} 
		
		else {
			
			//fullwidth sliders
			$('.nectar-slider-wrap[data-full-width="true"] .swiper-container').each(function(i){
				$(this).attr('data-height',$sliderHeights[i] )	
			});
			
			//boxed sliders
			$('.nectar-slider-wrap[data-full-width="false"] .swiper-container, .nectar-slider-wrap[data-full-width="boxed-full-width"] .swiper-container').each(function(i){
				$(this).attr('data-height',$sliderHeights[i] )	
			});
		}

	}
	
	
	
	
	 

	//slider height
	
	var min_w = 1500; // minimum video width allowed
	var vid_w_orig;  // original video dimensions
	var vid_h_orig;
	
    vid_w_orig = 1280;
    vid_h_orig = 720;
    var $headerHeight = $('header').height()-1;
    
    $(window).resize(function () { resizeToCover(); slideContentPos(); });
    $(window).trigger('resize'); 
 
	function resizeToCover() {
		$('.nectar-slider-wrap').each(function(i){
			
			//width resize 
			if($('body > #boxed').length == 0 && $('.nectar-slider-wrap[data-full-width="true"]').parent().attr('id') != 'portfolio-extra' && $(this).parents('#post-area:not(".span_12")').length == 0){ 
				$('.nectar-slider-wrap[data-full-width="true"], .parallax_slider_outer.first-section .nectar-slider-wrap').css('left', -(($(window).width()-$smoothSrollWidth)/2 - $('.main-content').width()/2))+'px';
				$('.nectar-slider-wrap[data-full-width="true"] .swiper-container, .nectar-slider-wrap[data-full-width="true"], .parallax_slider_outer.first-section .swiper-container, .parallax_slider_outer.first-section .nectar-slider-wrap').css('width',$(window).width());
			} 
			else if( $('.nectar-slider-wrap[data-full-width="true"]').parent().attr('id') == 'portfolio-extra' && $('#full_width_portfolio').length != 0){   
				$('.nectar-slider-wrap[data-full-width="true"], .parallax_slider_outer.first-section .nectar-slider-wrap').css('left', -(($(window).width()-$smoothSrollWidth)/2 - $('.main-content').width()/2))+'px';
				$('.nectar-slider-wrap[data-full-width="true"] .swiper-container, .nectar-slider-wrap[data-full-width="true"], .parallax_slider_outer.first-section .swiper-container, .parallax_slider_outer.first-section .nectar-slider-wrap').css('width',$(window).width());
			}
			else {
				var $container = '.container-wrap';
				$('.nectar-slider-wrap .swiper-container, .nectar-slider-wrap, .parallax_slider_outer.first-section .swiper-container, .parallax_slider_outer.first-section .nectar-slider-wrap').css('width',$($container).width());
			}
			
			var $sliderHeight = parseInt($(this).find('.swiper-container').attr('data-height'));
			var isFullWidthCompatible = ($(this).attr('data-full-width') == 'true') ? 'true' : 'false';
			
			if($(this).parent().attr('id') == 'portfolio-extra' && $('#full_width_portfolio').length == 0 || $(this).parents('#post-area').length > 0) { isFullWidthCompatible = 'false'; };
			
			var $sliderWidth = (isFullWidthCompatible == 'true') ? $(window).width()-$smoothSrollWidth : $(this).width();
			
			$(this).parents('.parallax_slider_outer').css('height',$sliderHeight);
			$(this).css('height',$sliderHeight);
			$(this).find('.swiper-container, .swiper-slide').css({'height':$sliderHeight+2, 'top':'-1px'});
			$(this).find('.swiper-container').css('width', $sliderWidth);
			//$(this).find('.swiper-slide').css('width', $sliderWidth);
			
		    // set the video viewport to the window size
		    $(this).find('.video-wrap').width($sliderWidth+2);
		    $(this).find('.video-wrap').height($sliderHeight+2);
		
		    // use largest scale factor of horizontal/vertical
		    var scale_h = $sliderWidth / vid_w_orig;
		    var scale_v = ($sliderHeight - $headerHeight) / vid_h_orig; 
		    var scale = scale_h > scale_v ? scale_h : scale_v;
			
			//update minium width to never allow excess space
		    min_w = 1280/720 * ($sliderHeight+20);
		    
		    // don't allow scaled width < minimum video width
		    if (scale * vid_w_orig < min_w) {scale = min_w / vid_w_orig;}
		        
		    // now scale the video
		    $(this).find('video, .mejs-overlay, .mejs-poster').width(Math.ceil(scale * vid_w_orig +2));
		    $(this).find('video, .mejs-overlay, .mejs-poster').height(Math.ceil(scale * vid_h_orig +2));
		    
		    // and center it by scrolling the video viewport
		    $(this).find('.video-wrap').scrollLeft(($(this).find('video').width() - $sliderWidth) / 2);
		    
		    $(this).find('.swiper-slide').each(function(){
		    	
		    	//video alignment
		    	if($(this).find('.video-wrap').length > 0){
			    	//align  middle
				    if($(this).attr('data-bg-alignment') == 'center'){
				    	$(this).find('.video-wrap, .mejs-overlay, .mejs-poster').scrollTop(($(this).find('video').height() - ($sliderHeight)) / 2);
				    }
				    //align bottom
				    else if($(this).attr('data-bg-alignment') == 'bottom'){
				    	$(this).find('.video-wrap').scrollTop(($(this).find('video').height() - ($sliderHeight+2)));
				    }
				    //align top
				    else {
				    	$(this).find('.video-wrap').scrollTop(0);
				    } 
			    }
		    	
		    });

		});
	}; 
	
	//caption transitions 
	function captionTransition(obj){ 
			var $containerClass;
			
			(typeof obj == 'undefined') ? $containerClass = 'div[id^=ns-id-]' : $containerClass = '#'+$(obj.container).parents('.nectar-slider-wrap').attr('id'); ;
			
	 		var fromLeft = Math.abs(parseInt($($containerClass+' .swiper-wrapper').css('left')));
			var currentSlide = Math.round(fromLeft/$($containerClass+' .swiper-slide').width()); 
			
			if(isNaN(currentSlide)) currentSlide = 0;
			
			//make sure user isn't going back to same slide 
			if( $($containerClass+' .swiper-slide:nth-child('+ (currentSlide + 1) +')').find('.content *').length > 0 ) {
				if($($containerClass+' .swiper-slide:nth-child('+ (currentSlide + 1) +')').find('.content *').css('opacity') != '0') return false;
			} 
			 
			//hide all
			$($containerClass+' .swiper-slide .content p, '+$containerClass+' .swiper-slide .content h2, '+$containerClass+' .swiper-slide .content .buttons').stop(true,true).animate({'opacity':0, 'padding-top': 25},1);

			//hide video if there's one
			if($($containerClass+' .swiper-slide').find('.video-wrap video').length > 0){
				$($containerClass+' .swiper-slide').each(function(){
					if($(this).find('.video-wrap video').length > 0) { 
						$(this).find('.video-wrap video').get(0).pause();
						if($(this).find('.mejs-overlay.mejs-overlay-play').hasClass('playing')) $(this).find('.mejs-overlay.mejs-overlay-play').removeClass('playing');
						if($(this).find('.mejs-poster').hasClass('playing')) $(this).find('.mejs-poster').removeClass('playing');
						
						var $that = $(this).find('.mejs-overlay.mejs-overlay-play');
						var $that2 = $(this).find('.mejs-poster');
						
						if($that.hasClass('playing') && $that.hasClass('mobile-played')) {
							setTimeout(function(){ $that.addClass('behind-buttons'); $that2.addClass('behind-buttons');},200);
						} else {
							$that.removeClass('behind-buttons'); $that2.removeClass('behind-buttons');
						}
					}
				});
			}
		
			//play video if there's one
			if($($containerClass+' .swiper-slide:nth-child('+ (currentSlide + 1) +')').find('.video-wrap video').length > 0){
				
				$($containerClass+' .swiper-slide:nth-child('+ (currentSlide + 1) +')').find('.video-wrap video').get(0).play();
				if(!$($containerClass+' .swiper-slide:nth-child('+ (currentSlide + 1) +')').find('.mejs-overlay.mejs-overlay-play').hasClass('playing') && $($containerClass+' .swiper-slide:nth-child('+ (currentSlide + 1) +')').find('.mejs-overlay.mejs-overlay-play').hasClass('mobile-played')) $($containerClass+' .swiper-slide:nth-child('+ (currentSlide + 1) +')').find('.mejs-overlay.mejs-overlay-play').addClass('playing');
				if(!$($containerClass+' .swiper-slide:nth-child('+ (currentSlide + 1) +')').find('.mejs-poster').hasClass('playing') && $($containerClass+' .swiper-slide:nth-child('+ (currentSlide + 1) +')').find('.mejs-poster').hasClass('mobile-played')) $($containerClass+' .swiper-slide:nth-child('+ (currentSlide + 1) +')').find('.mejs-poster').addClass('playing');
				
				var $that = $($containerClass+' .swiper-slide:nth-child('+ (currentSlide + 1) +')').find('.mejs-overlay.mejs-overlay-play');
				var $that2 = $($containerClass+' .swiper-slide:nth-child('+ (currentSlide + 1) +')').find('.mejs-poster');
				
				if($that.hasClass('playing') && $that.hasClass('mobile-played')) {
					setTimeout(function(){ $that.addClass('behind-buttons'); $that2.addClass('behind-buttons');},200);
				} else {
					$that.removeClass('behind-buttons'); $that2.removeClass('behind-buttons');
				}
			}
			
			//fadeIn active slide
			$($containerClass+' .swiper-slide:nth-child('+ (currentSlide + 1) +')').find('.content').children().each(function(i){
				$(this).delay(i*90).animate({
					'opacity' : 1,
					'padding-top' : 0
				},{ duration: 400, easing: 'easeOutQuad'});	
			});
			
			
			//light and dark controls
			if($($containerClass+' .swiper-slide:nth-child('+ (currentSlide + 1) +')').attr('data-color-scheme') == 'dark') {
				$($containerClass).find('.slider-pagination').addClass('dark-cs');
				$($containerClass).find('.slider-prev, .slider-next').addClass('dark-cs');
			} else {
				$($containerClass).find('.slider-pagination').removeClass('dark-cs');
				$($containerClass).find('.slider-prev, .slider-next').removeClass('dark-cs');
			}
	} 
	
	var $startingSlide = null;
	 
	
	//initial slide load 
	$('.nectar-slider-wrap').each(function(i){
		var $that = $(this);

		if($(this).find('.swiper-slide-active video').length > 0){
			
			$(this).find('.swiper-slide-active:first video').get(0).addEventListener('loadeddata',function(){
			
				captionTransition();
				showSliderControls();
				resizeToCover();
				sliderLoadIn($that);
			});
		} 
		else {

			var $firstBg = $(this).find('.swiper-slide-active').attr('style');
			
		    var pattern = /url\(["']?([^'")]+)['"]?\)/;
		    var match = pattern.exec($firstBg);
		    if (match) {        
		        var slideImg = new Image();
				slideImg.src = match[1];
				
				$(slideImg).load(function(){ 
					captionTransition();
					showSliderControls();
					sliderLoadIn($that);
				});
			}
		}
		
		//mobile check
		if(navigator.userAgent.match(/(Android|iPod|iPhone|iPad|IEMobile|Opera Mini)/)){
			captionTransition();
			showSliderControls();
			resizeToCover();
			$('.nectar-slider-wrap').find('.nectar-slider-loading').fadeOut(800,'easeInOutExpo');
			
			$('.nectar-slider-wrap .mobile-video-image').show();
			$('.nectar-slider-wrap .video-wrap').remove();
		}
		
	});

	
	function slideContentPos(){
		
		$('.swiper-wrapper').each(function(){
			
			//etxra space if first slider in section
			var $extraHeight = ($(this).parents('.nectar-slider-wrap').hasClass('first-section') || $(this).parents('.parallax_slider_outer').hasClass('first-section')) ? 30 : 0;

			var $sliderHeight = parseInt($(this).parents('.swiper-container').attr('data-height'));
			
			$(this).find('.swiper-slide').each(function(){
				
				var $contentHeight = $(this).find('.content').height();
				var $contentItems = $(this).find('.content > *').length;
				
				if($(this).find('.content > *').css('padding-top') == '25px') $contentHeight = $contentHeight - 25*$contentItems;
				
				if($(this).attr('data-y-pos') == 'top'){
					var $topHeight = ($contentHeight/2) < (($sliderHeight/4) - 30) ? (($sliderHeight/4) - ($contentHeight/2)) + 20 :  $sliderHeight/8;
					$(this).find('.content').css('top', $topHeight + 'px');
				} 
				else if($(this).attr('data-y-pos') == 'middle') {

					$(this).find('.content').css('top', ($sliderHeight/2) - ($contentHeight/2) + 'px');
				} 
				else {
					if($contentHeight > 180) { 
						$(this).find('.content').css('top', ($sliderHeight/2) - ($contentHeight/10) + 'px');
					} else {
						$(this).find('.content').css('top', ($sliderHeight/2) + ($contentHeight/9) + 'px');
					}
				}
			});
		});
	}
	
 
	
	function showSliderControls() {
		$('.swiper-container .slider-prev, .swiper-container .slider-next, .slider-pagination').animate({'opacity':1},550,'easeOutSine');
	}
	
	
	function sliderLoadIn(slider) { 
		
		slider.find('.nectar-slider-loading').fadeOut(800,'easeInOutExpo');
		
		///make sure to init smooth scrolling after slider height exists
		var $smoothActive = $('body').attr('data-smooth-scrolling'); 
		if( $smoothActive == 1 && $(window).width() > 690 && $('body').outerHeight(true) > $(window).height() && $('#ascrail2000').length == 0){ niceScrollInit(); resizeToCover(); }

	}
	
	
	//play video user is hovering over
	$('.swiper-slide').hover(function(){
		if($(this).find('video').length > 0 && $(this).find('video').get(0).paused){
			$(this).find('video').get(0).play();
		}
	});

	
	//mobile play event
	$('body').on('click', '.mejs-overlay.mejs-overlay-play',function(){
		$(this).toggleClass('playing');
		$(this).addClass('mobile-played');
		
		$(this).parent().find('.mejs-poster').toggleClass('playing');
		$(this).parent().find('.mejs-poster').addClass('mobile-played');
		
		var $that = $(this);
		var $that2 = $(this).parent().find('.mejs-poster');
		
		if($(this).hasClass('playing') && $(this).hasClass('mobile-played')) {
			
			setTimeout(function(){ $that.addClass('behind-buttons'); $that2.addClass('behind-buttons'); },200);
		} else {
			setTimeout(function(){ $that.removeClass('behind-buttons'); $that2.removeClass('behind-buttons'); },1);
		}
	}); 
	

	//autoplay
	var autoplay = [];
	var sliderAutoplayCount = -1;
	
	$('.nectar-slider-wrap').each(function(i){
		var $autoplayVal = $(this).attr('data-autorotate');
		var $that = $(this);
		var $sliderNum = i;
		
		if(typeof $autoplayVal !='undefined' && $autoplayVal.length != '0' && parseInt($autoplayVal)) { 
			nectarSlideRotateInit($that,$autoplayVal,$sliderNum);
		}	
	});
	
	function nectarSlideRotateInit(slider,interval,sliderNum){
		
		autoplay[sliderAutoplayCount] = setInterval(function(){ nectarSlideRotate(slider, sliderNum); } ,interval);
		
		$('#'+slider.attr('id')).attr('autoplay-id',sliderAutoplayCount);
		
		$('#'+slider.attr('id') + ' a.slider-prev, #'+slider.attr('id') + ' a.slider-next, #' + slider.attr('id') + ' .slider-pagination span').click(function(e){ 
			if(typeof e.clientY != 'undefined'){
				clearInterval(autoplay[$('#'+slider.attr('id')).attr('autoplay-id')]); 
			}
		});
		
		sliderAutoplayCount++;
	}
	
	function nectarSlideRotate(slider, sliderNum){

		if($nectarSliders[sliderNum].activeIndex + 1 < $(slider).find('.swiper-wrapper > div.swiper-slide').length){
			$nectarSliders[sliderNum].swipeNext();
		} else {
			$nectarSliders[sliderNum].swipeTo(0,800);
		}
	}
	
	function clearAutoplay(e){ 
		var $autoplayVal = $('#'+$(e.container).parent().attr('id')).attr('data-autorotate');

		if(typeof $autoplayVal !='undefined' && $autoplayVal.length != '0' && parseInt($autoplayVal)) {
			clearInterval(autoplay[$('#'+$(e.container).parent().attr('id')).attr('autoplay-id')]); 
		}
	}
	 
	
	function sliderArrowCount(e){
		//add slide counts
		$(e.container).find('.slider-prev .slide-count .slide-current').html( e.activeIndex + 1);
		$(e.container).find('.slider-next .slide-count .slide-current').html( e.activeIndex + 1);
		
		if(e.activeIndex >= 10) { $(e.container).find('.slider-next .slide-count .slide-current').addClass('double-digits'); } else {
			$(e.container).find('.slider-next .slide-count .slide-current').removeClass('double-digits');
		}
	}
	
	
	//functions to add or remove slider for webkit parallax fix
	function hideSlider() {
		if( $(window).scrollTop()/($sliderHeight + portfolioHeaderHeight + 90) >= 1){
			$('.parallax_slider_outer .nectar-slider-wrap, .project-title.parallax-effect').css('visibility','hidden').hide();
			
			$(window).bind('scroll',showSlider);
			$(window).unbind('scroll',hideSlider);
		}
	}
	
	function showSlider() {
		if( $(window).scrollTop()/($sliderHeight + portfolioHeaderHeight + 90) <= 1){
		
			$('.parallax_slider_outer .nectar-slider-wrap, .project-title.parallax-effect').css('visibility','visible').show();
			slideContentPos();
			resizeToCover();
			
			$(window).bind('scroll',hideSlider);
			$(window).unbind('scroll',showSlider);
				
		}
	} 
	 
	//parallax
	if($('.parallax_slider_outer').length > 0 && !navigator.userAgent.match(/(Android|iPod|iPhone|iPad|IEMobile|Opera Mini)/)){
		
		if($('#portfolio-extra').length > 0 && $('#full_width_portfolio').length == 0) { return false; }
		
		var $sliderHeight = parseInt($('.parallax_slider_outer.first-section .swiper-container').attr('data-height'));
		$(window).scroll(function(){
			
			if($('#boxed').length == 0){

				$('.parallax_slider_outer.first-section .nectar-slider-wrap[data-parallax="true"]').stop(true,true).transition({ y: $(window).scrollTop()*-.2 },0);
				$('.parallax_slider_outer.first-section .swiper-slide:not(".static") .content, .parallax_slider_outer.first-section .nectar-slider-wrap[data-parallax="true"] .swiper-container .slider-next, .parallax_slider_outer.first-section .nectar-slider-wrap[data-parallax="true"] .swiper-container .slider-prev').stop(true,true).transition({ y: $(window).scrollTop()*-.14 },0);
				
				$('#full_width_portfolio .project-title.parallax-effect').transition({ y: $(window).scrollTop()*-.2 },0);	
					
				$('.parallax_slider_outer.first-section .swiper-slide .content, .parallax_slider_outer.first-section .nectar-slider-wrap[data-parallax="true"] .swiper-container .slider-next, .parallax_slider_outer.first-section .nectar-slider-wrap[data-parallax="true"] .swiper-container .slider-prev').css('opacity', 1-($(window).scrollTop()/($sliderHeight-120)) );
			}
		}); 
		

		//hide slider to not mess up parallax section
		var portfolioHeaderHeight = ($('.project-title.parallax-effect').length > 0) ? 100 : 0;

    	if( $(window).scrollTop()/($sliderHeight + portfolioHeaderHeight + 90) >= 1){
	    	$(window).bind('scroll', hideSlider);
	    } else {
	    	$(window).bind('scroll', showSlider);
	    }
		
		
		 
		$('.page-header-no-bg, #page-header-wrap, #page-header-bg').remove();
		
		var $adminBarHeight = ($('#wpadminbar').length > 0) ? 28 : 0 ;
		
		$('.project-title').addClass('parallax-effect').css({
			'top': $('#header-space').outerHeight() + $adminBarHeight + 'px' 
		}); 
		
		//caption alignment if portfolio fullwidth parallax
		if($('.project-title.parallax-effect').length > 0) {
			$('.parallax_slider_outer.first-section .swiper-slide .content, .nectar-slider-wrap.first-section .swiper-slide .content').css('margin-top','0px');
			$('.swiper-container .slider-prev, .swiper-container .slider-next').css('margin-top','-28px');
		}
		
		//if using wooCommerce sitewide notice
		if($('.demo_store').length > 0) $('.project-title.parallax-effect').css('margin-top','-25px');
		
		if($('#full_width_portfolio').length > 0){
			$('.parallax_slider_outer.first-section').css('margin-top','93px');
		}
		
		$(window).resize(function(){
			$sliderHeight = parseInt($('.parallax_slider_outer.first-section .swiper-container').attr('data-height'));
			
			$('.project-title').css({
				'top': $('#header-space').outerHeight() + $adminBarHeight + 'px'
			}); 
		});
		
	} else if($('.parallax_slider_outer').length > 0 && navigator.userAgent.match(/(Android|iPod|iPhone|iPad|IEMobile|Opera Mini)/)) {
		$('.project-title').addClass('parallax-effect').css({
			'top': $('#header-space').outerHeight() + $adminBarHeight + 'px' 
		}); 
	}
	
	
	
	function niceScrollInit(){
		$("html").niceScroll({
			scrollspeed: 60,
			mousescrollstep: 40,
			cursorwidth: 15,
			cursorborder: 0,
			cursorcolor: '#2D3032',
			cursorborderradius: 6,
			autohidemode: false,
			horizrailenabled: false
		});
		
		if($('#boxed').length == 0){
			$('body, body #header-outer, body #header-secondary-outer, body #search-outer').css('padding-right','16px');
		}
		
		$('html').addClass('no-overflow-y');
	}
	
	
	

	

	
});
