	/* ALL THE SCRIPTS BELOW THIS LINE ARE MADE BY KROWNTHEMES.COM AND ARE LICENSED UNDER ENVATO'S REGULAR/EXTENDED LICENSE --- REDISTRIBUTION IS NOT ALLOWED! */

	jQuery.noConflict();

	(function($) {

	    $(document).ready(function(){

	        "use strict";

	/* ----------------------------------------------------
	---------- !! GENERAL STUFF !! -----------------
	------------------------------------------------------- */

	    var $html = $('html'),
	        $body = $('body'),
	        $sidebar = $('#sidebar'),
	        $sidebarContent = $sidebar.children('.content').append('<span class="darken"></span>'),
	        $sidebarDarken = $sidebarContent.children('.darken'),
	        $content = $('#content'),
	        $loader = $('#loader'),
	        $contentFixed = null,
	        $glc = $body.hasClass('page-template-template-single-image-php') || $body.hasClass('page-template-template-single-video-php') || $body.hasClass('page-template-template-slideshow-php') ? $('.single-image-content').children('*') : null,
	        contentMoveObj = $body.hasClass('sidebar-hide') ? 'left' : 'paddingLeft',
	        
	        cssTransform = window.webkitRequestAnimationFrame != undefined ? '-webkit-transform' : 'transform',
	        touchM = "ontouchstart" in window,

	        disableParallax = themeObjects.disableParallax == 'parallax-enabled' ? false : true;

	    // I apologize for browser sniffing, but there is no other way :(

	    if (!($html.hasClass('ie9') || $html.hasClass('ie8')) && navigator.userAgent.toUpperCase().indexOf('TRIDENT') > 0) {
	        $html.addClass('ie10')
	    }
	    $('html').removeClass('no-js');

	    /* -------------------------------
	    -----   Sidebar  -----
	    ---------------------------------*/

	    var sidebarEaseIn = 'easeOutQuart',
	        sidebarTimeIn = .6,
	        sidebarEaseOut = 'easeOutBack',
	        sidebarTimeOut = .7,

	        sidebarStatus = $body.hasClass('s-opened-portfolio') ? 'opened' : 'closed';

	    function openSidebar(){

	        if(sidebarStatus == 'null' || sidebarStatus == 'closed') {

	            // Cookies and technical

	            sidebarStatus = 'opened'; 
	            $.cookie('sidebar_status', 's-opened', {path: '/'});

	            // Reposition loader perfectly

	            $loader.addClass('opened');
	            $loader.removeClass('closed');

	            // Function that opens the sidebar, animating everything in 

	            TweenMax.to($sidebar[0], sidebarTimeIn, {left: 0, ease: sidebarEaseIn, overwrite: 'all'});
	            TweenMax.to($sidebarDarken[0], sidebarTimeIn, {opacity: 0, ease: sidebarEaseIn, overwrite: 'all', onCompleteScope:$sidebarDarken, onComplete: function(){
	                $(this).css('display', 'none');
	               // att - bug: $(window).trigger('resize');
	            }});
	            
	            if(!$html.hasClass('no-csstransforms') && !$body.hasClass('sidebar-no3d')) {
	                TweenMax.to($sidebarContent[0], sidebarTimeIn, {rotationY: 0, transformOrigin: 'right top', ease: sidebarEaseIn, overwrite: 'all'});
	            }

	            if(contentMoveObj == 'paddingLeft') {
	                TweenMax.to([$content[0], $contentFixed], sidebarTimeIn, {paddingLeft: 300, ease: sidebarEaseIn, overwrite: 'all'});
	            } else {
	                var $msph = null;
	                if(projectType == 'modal' && $('#portfolio-detail').css('position') == 'fixed') {
	                    $msph = $('#portfolio-detail');
	                } else if($('.is-other.on').children('*').length > 0) {
	                    $msph = $('.is-other.on').children('*');
	                }
	                TweenMax.to([$content[0], $contentFixed, $msph, $glc], sidebarTimeIn, {left: 300, ease: sidebarEaseIn, overwrite: 'all'});
	            }

	        }

	    }

	    function closeSidebar(){

	        if(sidebarStatus == 'null' || sidebarStatus == 'opened') {
	            
	            // Cookies and technical

	            sidebarStatus = 'closed'; 
	            $.cookie('sidebar_status', 's-closed', {path: '/'});

	            // Reposition loader perfectly

	            $loader.removeClass('opened');
	            $loader.addClass('closed');

	            // Function that closes the sidebar, animating everything out

	            TweenMax.to($sidebar[0], sidebarTimeOut, {left: -260, ease: sidebarEaseOut, overwrite: 'all'});
	            $sidebarDarken.css('display', 'block');
	            TweenMax.to($sidebarDarken[0], sidebarTimeOut, {opacity: .5, ease: sidebarEaseOut, overwrite: 'all', onComplete: function(){
	               // att - bug: $(window).trigger('resize');
	            }});

	            if(!$html.hasClass('no-csstransforms') && !$body.hasClass('sidebar-no3d')) {
	                TweenMax.to($sidebarContent[0], sidebarTimeOut, {rotationY: -80, transformOrigin: 'right top', ease: sidebarEaseOut, overwrite: 'all'});
	            }

	            if(contentMoveObj == 'paddingLeft') {
	                TweenMax.to([$content[0], $contentFixed, $msph], sidebarTimeOut, {paddingLeft: 40, ease: sidebarEaseOut, overwrite: 'all'});
	            } else {
	                var $msph = null;
	                if(projectType == 'modal' && $('#portfolio-detail').css('position') == 'fixed') {
	                    $msph = $('#portfolio-detail');
	                } else if($('.is-other.on').children('*').length > 0) {
	                    $msph = $('.is-other.on').children('*');
	                }
	                TweenMax.to([$content[0], $contentFixed, $msph, $glc], sidebarTimeOut, {left: 40, ease: sidebarEaseOut, overwrite: 'all'});
	            }

	        }

	    }

	    // If the sidebar is set on "always autohide", bind the autohide event properly for all pages

	    if($body.hasClass('sidebar-hide') && !$body.hasClass('is-portfolio')) {

	        $(window).on('mousemove', function(event){
	            if(event.pageX < 40){
	                openSidebar();
	            } else if(event.pageX > 310) {
	                closeSidebar();
	            }
	        });

	    }

	    // If the sidebar is on it's "default behavior" we need to enable the button for pages (because it will autohide on portfolios). The button is also enabled when the sidebar is set on "always show"

	    var sidebarWasClicked = false;
	    
	    if(!$body.hasClass('is-portfolio')) {

	        $sidebar.find('.button').click(function(){

	            sidebarWasClicked = true;

	            if($body.hasClass('rooipn-opened')) {
	                closeSidebar();
	                $body.removeClass('rooipn-opened');
	                touchSidebar = true;
	            } else {
	                openSidebar();
	                $body.addClass('rooipn-opened');
	                touchSidebar = false;
	            }

	            if($body.hasClass('is-portfolio')) {
	                setTimeout(function(){
	                    resizeThumbs()
	                }, 300);
	            }


	        });

	    }

	    // Some touch considerations

	    var touchSidebar = false;

	    if(touchM) {

	        $sidebar.swipe({

	            swipe: function(e, dir) {

	                if(touchSidebar == false && dir == 'right') {

	                    openSidebar();
	                    $body.addClass('rooipn-opened');
	                    touchSidebar = true;
	                    e.preventDefault();

	                } else if(touchSidebar == true && dir == 'left'){
	 
	                    closeSidebar();
	                    $body.removeClass('rooipn-opened');
	                    touchSidebar = false;
	                    e.preventDefault();

	                }

	            },

	            treshold: 0

	        }).children('.button').on('touchstart', function(e){

	            sidebarWasClicked = true;

	            if (!touchSidebar) {

	                openSidebar();
	                $body.addClass('rooipn-opened');
	                touchSidebar = true;
	            
	            } else {

	                closeSidebar();
	                $body.removeClass('rooipn-opened');
	                touchSidebar = false;
	           
	            }

	            e.preventDefault();

	        });

	    }

	    /* -------------------------------
	    -----   Menu (responsive)  -----
	    ---------------------------------*/

	    var $menu = $('#menu'),
	        optionsString = '';

	    // Set sidebar cookie

	    $menu.find('a').click(function(){
	        if(!touchM)
	            $.cookie('sidebar_status', 's-opened-portfolio', {path: '/'});
	    });

	    $menu.children('.top-menu').children('li').each(function(){

	        // Create responsive navigaton

	        var $a = $(this).children('a');

	        optionsString += '<option data-href="' + $a.prop('href') + '"' + ($a.hasClass('filter') ? ' data-filter="' + $a.data('filter') + '"' : '') + ($a.hasClass('all-filter') ? ' class="all-filter"' : '') + ($a.prop('target') == 'blank' ? ' data-target="_blank"' : '') + '>' + $a.text() + '</option>';

	        if($(this).hasClass('parent') && $(this).hasClass('selected')) {
	            $(this).find('ul').find('a').each(function(){

	                optionsString += '<option data-href="' + $(this).prop('href') + '"' + ($(this).hasClass('filter') ? ' data-filter="' + $(this).data('filter') + '"' : '') + ($(this).hasClass('all-filter') ? ' class="all-filter"' : '') + ($(this).prop('target') == 'blank' ? ' data-target="_blank"' : '') + '> -- ' + $(this).text() + '</option>';

	            });

	        }

	    });

	    $menu.append('<div class="responsive-menu"><select><option data-href="#">' + $menu.data('responsive-title') + '</option>' + optionsString + '</select></div>');

	    $('.responsive-menu').children('select').on('change', function(){

	        var href = $(this).find('option:selected').data('href'),
	            target = $(this).find('option:selected').data('target'),
	            filter = $(this).find('option:selected').data('filter');

	        if(filter != undefined) {

	        	var cacheSelected = $(this).find('option:selected');

	            if($project != null){
	                closeProject();
	                setTimeout(function(){
	                    sortFolio(cacheSelected);
	                }, 500);
	            } else {
	                sortFolio(cacheSelected);
	            }

	        } else {
	            if(target == undefined) {
	                document.location.href = href;
	            } else {
	                window.open(href, '_blank');
	            }
	        }

	    });

	/* ----------------------------------------------------
	---------- !! MEDIA QUERIES !! -----------------
	------------------------------------------------------- */

	    // Because a lot of js is involved in this theme, we need to use js along with media queries in order to maximize the UX

	    $(body).append('<div id="media-queries" class="appended-via-jquery"><div id="p-1400"></div><div id="p-1200"></div><div id="p-1024"></div><div id="p-768"></div><div id="p-620"></div></div>');

	    var $p1400 = $('#p-1400'),
	        $p1200 = $('#p-1200'),
	        $p1024 = $('#p-1024'),
	        $p768 = $('#p-768'),
	        $p620 = $('#p-620'),

	        pWidth = 0,
	        qWidth = 0,
	        rWidth = 0,

	        fixedSidebar = $body.hasClass('sidebar-show') ? true : false,
	        fixedSidebarWidth = 260;

	    if(touchM) {
	        $body.removeClass('no-touch');
	    }

	    function resizeQueries(){

	        if($p1400.css('display') == 'block' && pWidth != 1400){
	            pWidth = 1400;
	            handleResize();     
	        } else if($p1200.css('display') == 'block' && pWidth != 1200){
	            pWidth = 1200;
	            handleResize();
	        } else if($p768.css('display') == 'block' && pWidth != 768){
	            pWidth = 768;
	            handleResize();
	        }

	        if($p620.css('display') == 'block' && rWidth != 620){
	            rWidth = 620;
	            handleResize();
	        } else if($p620.css('display') == 'none' && rWidth == 620){
	            rWidth = 0;
	            handleResize();
	        }

	        if($p1024.css('display') == 'block' && qWidth != 1024){
	            qWidth = 1024;
	            handleResize();
	        } else if($p1024.css('display') == 'none' && qWidth == 1024) {
	            qWidth = 0;
	            handleResize();
	        }

	    }

	    $(window).on('resize', resizeQueries);
	    resizeQueries();

	    function handleResize() {

	        if(((qWidth == 1024 && fixedSidebar) || pWidth == 768) && !(touchM || disableParallax)) {

	            if($postFormatHolder2) $postFormatHolder2.addClass('disable-parallax');
	            if($mapInsert) $mapInsert.addClass('disable-parallax');
	            $('.horizontal-gallery').addClass('disable-parallax');

	        } else if(((qWidth != 1024 && fixedSidebar) || pWidth != 768) && !(touchM || disableParallax)) {

	            if($postFormatHolder2) $postFormatHolder2.removeClass('disable-parallax');
	            if($mapInsert) $mapInsert.removeClass('disable-parallax');
	            $('.horizontal-gallery').removeClass('disable-parallax');

	        }

	        if(rWidth == 620 && projectType == 'vertical') {
	            $('#portfolio-detail').css('position', 'relative');
	        } else if(rWidth != 620 && projectType == 'vertical') {
	            $('#portfolio-detail').css('position', 'fixed');
	        }

	        if(qWidth == 1024 && fixedSidebar){
	            fixedSidebarWidth = 0;
	            modalQuery(false);
	           // $(window).trigger('resize');
	        } else if(qWidth != 1024 && fixedSidebar){
	            fixedSidebarWidth = 260;
	            modalQuery(false);
	           // $(window).trigger('resize');
	        }

	    }

	    // Add a media query to hide "footer" / show the responsive menu, if sidebar gets too crowded

	    $('head').append('<style id="sidebar-query" type="text/css">@media all and (max-height: ' + ($('#logo').height() + $('#menu').height() + $('#sidebar-widgets').height() + 40) + 'px) { #sidebar-widgets { display: none; }</style>');

	    // This function adds proper media queries for modal projects. These have all variabe sizes set by the user, so the query needs to be variable as well

	    var firstModalQuery = true;

	    function modalQuery(empty){

	        var projectWidth = $('.project-modal').data('project-width'),
	            sliderWidth = $('.project-modal').data('slider-width'),
	            sliderHeight = $('.project-modal').data('project-height'),
	            modalQueryString = '';

	        if(fixedSidebar){

	            modalQueryString = '@media all and (min-width: ' + (projectWidth+fixedSidebarWidth+100) + 'px) { .swiper-container { width: ' + sliderWidth + 'px !important; height:' + sliderHeight + 'px !important; } .project-modal { margin-left: ' + (-(projectWidth-fixedSidebarWidth)/2) + 'px !important; } } @media all and (max-height:' + (sliderHeight+100) + 'px) and (min-width: ' + (projectWidth-fixedSidebarWidth+100) + 'px) { #portfolio-detail { position: relative !important; padding: 50px 0 !important; } .project-modal { top: 0 !important; margin-top: 0 !important; margin-left: ' + (-projectWidth/2) + 'px !important; } } @media all and (max-width: ' + (projectWidth+fixedSidebarWidth+100) + 'px) { #portfolio-detail { position: relative !important; padding: 50px 0; } .project-modal { height: auto !important; width: ' + sliderWidth + 'px !important; margin-left: -' + (sliderWidth/2) + 'px !important; margin-top: 0 !important; top: 0 !important; } .project-modal .content { padding-right: 0 !important; padding-bottom:30px !important; width: 100% !important; height: auto; overflow: visible; float: left; top: -15px; } .project-modal .nav { position: relative; float: right; top: 45px; left: auto; right: 30px; } .project-modal h1 { width:80%; } } @media all and (max-width: ' + (sliderWidth+fixedSidebarWidth+100) + 'px) { #portfolio-detail { padding:0; } .project-modal { width: 100% !important; margin-left: 0 !important; left: 0 !important; float: left; } .modal.single { width: 100% !important; height: auto !important; } .modal.swiper-container { width: 100% !important; } .modal.swiper-container img, .modal.single img { width: 100% !important; height: auto !important; top: 0 !important; left: 0 !important; } #modal-test-query { display: block; } }';

	        } else {

	            modalQueryString = '@media all and (min-width: ' + (projectWidth+100) + 'px) { .swiper-container { width: ' + sliderWidth + 'px !important; height:' + sliderHeight + 'px !important; } } @media all and (max-height:' + (sliderHeight+100) + 'px) and (min-width: ' + (projectWidth+100) + 'px) { #portfolio-detail { position: relative !important; padding: 50px 0 !important; } .project-modal { top: 0 !important; margin-top: 0 !important; margin-left: ' + (-projectWidth/2) + 'px !important; } } @media all and (max-width: ' + (projectWidth+100) + 'px) { #portfolio-detail { position: relative !important; padding: 50px 0; } .project-modal { height: auto !important; width: ' + sliderWidth + 'px !important; margin-left: -' + (sliderWidth/2) + 'px !important; margin-top: 0 !important; top: 0 !important; } .project-modal .content { padding-right: 0 !important; padding-bottom:30px !important; width: 100% !important; height: auto; overflow: visible; float: left; top: -15px; } .project-modal .nav { position: relative; float: right; top: 45px; left: auto; right: 30px; } .project-modal h1 { width:80%; } } @media all and (max-width: ' + (sliderWidth+100) + 'px) { #portfolio-detail { padding:0; } .project-modal { width: 100% !important; margin-left: 0 !important; left: 0 !important; float: left; } .modal.single { width: 100% !important; height: auto !important; } .modal.swiper-container { width: 100% !important; } .modal.swiper-container img, .modal.single img { width: 100% !important; height: auto !important; top: 0 !important; left: 0 !important; } #modal-test-query { display: block; } }';

	        }

	        if(empty) {
	            modalQueryString = '';
	        }

	        if(firstModalQuery) {

	            firstModalQuery = false;
	            $('head').append('<style id="modal-query" type="text/css">' + modalQueryString + '</style>');

	        } else {
	            $('#modal-query').html(modalQueryString);

	        }

	    }

	    // Didn't know where to put this fail safe

	    function dbdBehavior(){

	        if(touchM) {

	            $('.me-buttons.nav, .me-buttons.btns-2.nav, .me-buttons.share').each(function(){

	                var $btn = $(this),
	                    $a = $btn.find('a');

	                $btn.on('touchstart', function(e){

	                    if(!$btn.hasClass('touched')) {

	                        $btn.addClass('touched');

	                        if($btn.hasClass('share')) {
	                            $btn.find('.front').css('opacity', '0 !important');
	                            $btn.find('.back').css('opacity', '1 !important');
	                        }

	                        e.preventDefault();

	                    } 

	                });

	            });

	        }

	    }

	    dbdBehavior();

	/* ----------------------------------------------------
	---------- !! RESIZE !! -----------------
	------------------------------------------------------- */

		// fail safe for mobile devices

		window.addEventListener('orientationchange', function(){
		    setTimeout(function(){
		    	$(window).trigger('resize');
		    }, 250);
		}, false);

	    // This function needs to be defined here (above the portfolio and the gallery scripts), since it will be used for both of them

	    // Gets the ratio based on the class

	    if($('.get-ratio').hasClass('ratio_16-9')) {
	        var imgRatio = [16, 9];
	    } else if($('.get-ratio').hasClass('ratio_16-10')) {
	        var imgRatio = [16, 10];
	    } else if($('.get-ratio').hasClass('ratio_1-1')) {
	        var imgRatio = [1, 1];
	    } else {
	        var imgRatio = [4, 3];
	    }

	    function resizeThumbs(){

	        // Gets the window size

	        var sW = $content.width()+3, 
	            sH = $(window).height();

	        if ( $folioContainer != undefined ) {
	    		$folioContainer.width(sW);
	        }

	        // Calculates the new size of the thumbs based on initial width and ratio

	        var oldWidth = Math.floor(sW/Math.ceil(sW/maxImgWidth)),
	            iH = Math.floor(oldWidth/imgRatio[0]*imgRatio[1]);

	        // Do the actual resize

	        $folioItems.addClass('disableResize')
	            .width(oldWidth)
	            .height(iH);

	        // Rewrite the css transforms

	        if(!$projectHolder.hasClass('no-3deffects') && !$html.hasClass('ie10')) {

	        	$folioCubes.stop().animate({'z': -iH/2}, 0);
	            $folioCubesFront.css(cssTransform, 'rotateY(0deg) translateZ(' + (iH/2) + 'px)');
	            $folioCubesBottom.css(cssTransform, 'rotateX(-90deg) translateZ(' + (iH/2) + 'px)');

	        }

	        // If isotope is initialized, refresh items

	        if($body.hasClass('is-portfolio') && $folioContainer.hasClass('isotope')) {
	            $folioContainer.isotope();
	        }

	    }

	/* ----------------------------------------------------
	---------- !! THE PORTFOLIO GRID !! -----------------
	------------------------------------------------------- */

	    if($body.hasClass('is-portfolio')) {

	        /* -------------------------------
	        -----   Variables  -----
	        ---------------------------------*/
	    
	        var $oMenu = $(menu).find('li.selected.parent').length > 0 ? $menu.find('li.selected.parent').children('ul') : null,

	            $projectHolder = $('#portfolio-holder'),
	            $folioContainer = $('.folio-grid'),
	            $folioItems = $('.folio-item'),
	            $folioCubes = $('.folio-cube'),
	            $folioCubesFront = $('.folio-cube').children('div.front'),
	            $folioCubesBottom = $('.folio-cube').children('div.bottom'),

	            $folioPagination = $('.blog-grid-nav').length > 0 ? $('.blog-grid-nav') : null,

	            $selectedFilter = $menu.find('a.all-filter').parent(),
	            $initFilter = null,
	            sortedFolio = null,

	            firstProject = true,

	            initHref = $folioContainer.data('url'),
	            initTitle = document.title,
	            historyChanged = false,

	            // The project variables are empty on init except when we are already on the single page   

	            $project = $('.project').length > 0 ? $('.project') : null,
	            $projectHorzHolder = $project != null && $project.find('.gallery-holder').length > 0 ? $project.find('.gallery-holder') : null,
	            $projectSlider = $('.swiper-container').length > 0 ? $('.swiper-container') : ($('.project-modal').length > 0 ? $('.project-modal') : null),
	            $projectContent = $('#project-content').length > 0 ? $('#project-content') : null,
	            $projectNav = null,
	            $projectCaption = null,
	            $projectCaptionDummy = null,
	            $projectHorzHead = $('.project-horizontal .head'),
	            projectType = $project != null ? $project.data('type') : '',
	            projectLoading = false,

	            // Other stuff

	            maxImgWidth = parseInt(themeObjects.folioWidth),
	            maxHorzContHeight = $('article.project').hasClass('project-gallery') || $body.hasClass('page-template-template-gallery-php') ? 0 : 190;

	            contentMoveObj = $body.hasClass('sidebar-default') || $body.hasClass('sidebar-hide') ? 'left' : 'paddingLeft';
	            $.cookie('sidebar_status', 's-opened', {path: '/'});

	        // The code below checks the hashtag and opens a single project (if the case) in browsers which don't support the History API. Also, check for a category now.

	        var category = checkInitCategory();

	        if (!history.pushState){

	            if(document.location.href.indexOf('#') > 0) {

	                if(!category){
	                    document.location.href = document.location.href.replace('#', '');
	                }
	            }

	        }

	        /* -------------------------------
	        -----   Loading  -----
	        ---------------------------------*/

	        if($folioContainer.length > 0) {

	            if($body.hasClass('s-opened-portfolio')) {
	                $(document).on('mousemove', function(event){
	                    if(event.pageX < 40){
	                        openSidebar();
	                    } else if(event.pageX > 310) {
	                        closeSidebar();
	                    }
	                });
	            }

	            $folioContainer.imagesLoaded(function(){

	                // When images are done loading, init the isotope plugin and set up it's options

	                $folioContainer.isotope({
	                    transformsEnabled: false,
	                    animationEngine: 'jquery',
	                    animationOptions: {
	                        duration: 500,
	                        easing: 'Quad.easeOut',
	                        queue: false
	                    },
	                    getSortData: {
	                        byFilter: function($elem){
	                            return parseInt($elem.data('custom-filter'));
	                        }
	                    },
	                    resizable: false,
	                    resizesContainer: true
	                });

	                // Run a sequence (delayed) animation on all thumbnails and apply the default opacity

	                $folioItems.each(function(){
	                    TweenMax.to($(this)[0], .2, {
	                        opacity: 1,
	                        delay: .2+$(this).index()*.1,
	                        onCompleteScope: $(this), 
	                        onComplete: function(){
	                            $(this).removeClass('isotope-hidden');
	                        }
	                    });

	                    $(this).find('.folio-cube').css('opacity', themeObjects.folioOpacity);

	                });

	                if($initFilter != null) {
	                    sortFolio($initFilter);
	                }

	                if($folioPagination != null) {
	                    $folioPagination.delay(300).fadeIn(200);
	                }

	                // Remove the preloader, animate the sidebar into the screen then enable mouse hovering actions

	                $loader.fadeOut(150, function(){
	                    $body.removeClass('thumbs-loading');
	                });

	                if(!$body.hasClass('sidebar-show')) {

	                    if(!$body.hasClass('s-opened-portfolio')) {  

	                        $sidebar.animate({
	                            'left': -260
	                        }, 200, function(){

	                            $(document).on('mousemove', function(event){
	                                if(event.pageX < 40){
	                                    openSidebar();
	                                } else if(event.pageX > 310) {
	                                    closeSidebar();
	                                }
	                            });

	                        });

	                    }

	                } else {
	                    openSidebar();
	                }

	            });

	        }

	        // Attach resize event and trigger it once

	        $(window).resize(function(){
	            resizeThumbs();
	        });

	        resizeThumbs();

	        /* -------------------------------
	        -----   Hover  -----
	        ---------------------------------*/

	        if($html.hasClass('no-csstransforms') || $projectHolder.hasClass('no-3deffects') || $html.hasClass('ie10')) {

	            if(!$projectHolder.hasClass('alt')) {

	                // non 3D - original

	                $folioItems.on('mouseenter', function(){

	                    var $this = $(this);
	                    setTimeout(function(){
	                        $this.addClass('hovered');
	                    }, 500);

	                    if(!$(this).hasClass('isotope-hidden')) {
	                        $(this).find('.folio-cube').stop().animate({'opacity': 1}, 300, 'easeInOutQuad');
	                        $(this).find('.bottom').stop().animate({'opacity': .95}, 300, 'easeInOutQuad');
	                        $(this).find('img').stop().animate({
	                            'width': '130%',
	                            'height': '130%',
	                            'left': '-15%',
	                            'top': '-15%'
	                        }, 200, 'easeInOutQuad');
	                        $(this).find('.folio-caption').stop().animate({'paddingTop': 0}, 200, 'easeInOutQuad');
	                    }

	                }).on('mouseleave', function(){

	                    $(this).removeClass('hovered');

	                    $(this).find('.folio-cube').stop().animate({'opacity': themeObjects.folioOpacity}, 300, 'easeInOutQuad');
	                    $(this).find('.bottom').stop().animate({'opacity': 0}, 300);
	                    $(this).find('img').stop().animate({
	                        'width': '100%',
	                        'height': '100%',
	                        'left': '0',
	                        'top': '0'
	                    }, 200, 'easeInOutQuad');
	                    $(this).find('.folio-caption').stop().animate({'paddingTop': 50}, 200, 'easeInOutQuad');

	                });

	            } else {

	                // non 3D - alternative

	                $folioItems.on('mouseenter', function(){

	                    var $this = $(this);
	                    setTimeout(function(){
	                        $this.addClass('hovered');
	                    }, 500);

	                    if(!$(this).hasClass('isotope-hidden')) {
	                        $(this).find('.folio-cube').stop().animate({'opacity': 1}, 300, 'easeInOutQuad');
	                        $(this).find('.bottom').stop().animate({'height': '100%'}, 300, 'easeInOutQuad');
	                        TweenMax.to($(this).find('.folio-caption')[0], .2, {
	                            opacity: 1,
	                            bottom: 0,
	                            delay: .1,
	                            overwrite: 'all',
	                            ease: 'easeInOutQuad'
	                        });
	                        TweenMax.to($(this).find('.plus')[0], .15, {
	                            opacity: 1,
	                            delay: .25,
	                            overwrite: 'all'
	                        });
	                    }

	                }).on('mouseleave', function(){

	                    $(this).removeClass('hovered');

	                    $(this).find('.folio-cube').stop().animate({'opacity': themeObjects.folioOpacity}, 250, 'easeInOutQuad');
	                    $(this).find('.bottom').stop().animate({'height': '0'}, 250, 'easeInOutQuad');
	                    TweenMax.to($(this).find('.folio-caption')[0], .15, {
	                        opacity: 0,
	                        bottom: 50,
	                        overwrite: 'all',
	                        ease: 'easeInOutQuad'
	                    });
	                    TweenMax.to($(this).find('.plus')[0], .1, {
	                        opacity: 0,
	                        overwrite: 'all'
	                    });

	                }).find('.bottom').append('<span class="plus">+</span>');

	            }

	        } else {

	            // 3D

	            $folioItems.on('mouseenter', function(){

	                var $this = $(this);
	                setTimeout(function(){
	                    $this.addClass('hovered');
	                }, 500);

	                if(!$(this).hasClass('isotope-hidden')) {
	                    $(this).find('.folio-cube').stop().animate({
	                        'rotationX': 90,
	                        'z': Math.ceil(-$(this).height()/2),
	                        'opacity': 1
	                    }, 300, 'easeInOutQuad');
	                }
	            }).on('mouseleave', function(){

	                $(this).removeClass('hovered');

	                $(this).find('.folio-cube').stop().animate({
	                    'rotationX': 0,
	                    'z': Math.ceil(-$(this).height()/2),
	                    'opacity': themeObjects.folioOpacity
	                }, 300);
	            });

	        }

	        // We need to combine the mouse / touch events in a good way, so that we always have both (useful for the case of touchscreen laptops with a mouse pointer). My first approach is to assume that the touch event will always fire before the click event --

	        var touched = false;

	        $folioItems.click(function(e){

	            if(!touched || (touched && $(this).hasClass('hovered'))) {

	                if($(this).data('custom-url') != 'yes') {
	                    preOpenProject($(this));
	                    e.preventDefault();
	                }

	                touched = false;

	            } else {
	                e.preventDefault();
	            }

	        });

	        $folioItems.on('touchstart', function(event){

	            touched = true;

	            //$(this).trigger('mouseover');

	        });

	        $selectedFilter.addClass('selected');

	    }    

	    /* -------------------------------
	    -----   Filter  -----
	    ---------------------------------*/

	    function sortFolio($this, option){

	        // Change the selected class in the menu

	        if(option == undefined) {

	            $selectedFilter.removeClass('selected');
	            $selectedFilter = $this.parent();
	            $selectedFilter.addClass('selected');

	        }

	        if(!$this.hasClass('all-filter')) {

	            var filter = $this.data('filter');
	            $folioItems.removeClass('disableResize');

	            sortedFolio = filter;
	            document.location.hash = filter;

	            $folioItems.each(function(){

	                if($(this).hasClass(filter)) {

	                    // The items which are filtered need to be shown and enabled

	                    $(this).data('custom-filter', '0');

	                    TweenMax.to($(this)[0], .3, {
	                        opacity: 1,
	                        overwrite: 'all',
	                        onCompleteScope: $(this), 
	                        onComplete: function(){
	                            $(this).removeClass('isotope-hidden');
	                        }
	                    });

	                } else {

	                    // The items which aren't filtered need to be hidden and disabled

	                    $(this).data('custom-filter', '1');

	                    TweenMax.to($(this)[0], .3, {
	                        opacity: .1,
	                        overwrite: 'all',
	                        onCompleteScope: $(this), 
	                        onComplete: function(){
	                            $(this).addClass('isotope-hidden');
	                        }
	                    });

	                }

	            });

	            // Update the sort data before each actual filtering, then do the sort

	            $folioContainer.isotope('updateSortData', $folioItems);
	            $folioContainer.isotope({
	                'sortBy': 'byFilter'
	            });

	        } else {

	            // Show all thumbnails

	            sortedFolio = null;
	            document.location.hash = '';

	            $folioItems.each(function(){

	                $(this).data('custom-filter', '0');

	                TweenMax.to($(this)[0], .3, {
	                    opacity: 1,
	                    overwrite: 'all',
	                    onCompleteScope: $(this), 
	                    onComplete: function(){
	                        $(this).removeClass('isotope-hidden');
	                    }
	                });

	            });

	            $folioContainer.isotope('updateSortData', $folioItems);
	            $folioContainer.isotope({
	                'sortBy': 'original-order'
	            });

	        }

	    }

	    $menu.find('a.filter').each(function(){

	        // Attach click event

	        $(this).click(function(e){

	            var $this = $(this);

	            if($project != null){
	                closeProject();
	                setTimeout(function(){
	                    sortFolio($this);
	                }, 500);
	            } else {
	                sortFolio($this);
	            }

	            e.preventDefault();

	        });

	    });

	    function checkInitCategory(){

	        var filter = document.location.hash.replace('#', ''),
	            returnV = false;

	        $menu.find('a.filter').each(function(){
	            if($(this).data('filter') == filter) {
	                $initFilter = $(this);
	                returnV = true;
	            }
	        });

	        return returnV;

	    }

	    /* -------------------------------
	    -----   Project Functions   -----
	    ---------------------------------*/

	    function preOpenProject($this){

	        // This function makes the initial animation before a project has been opened and it also creates the proper DOM elements

	       $folioContainer.css('top', -$(window).scrollTop());
	       $projectHolder.addClass('opened');
	       $body.addClass('opened');

	        projectType = $this.data('type');

	        setTimeout(function(){
	            $loader.fadeIn(150);
	            openProject($this);
	        }, fadeThumbs((projectType == 'modal' ? .1 : 0), .15, 'out'));

	        if(firstProject){

	            $('#content').append('<section id="portfolio-detail"></section>');

	            if($folioPagination != null) {
	                $folioPagination.stop().fadeOut(150);
	            }

	            firstProject = false;

	        }

	    }

	    function openProject($this){

	        // Do the actual AJAX request for the new project

	        if(!projectLoading) {

	            projectLoading = true;

	            $.ajax({

	                url: $this.prop('href'),
	                dataType: 'html',
	                success: function(data){

	                    projectLoading = false;

	                    // Get the title

	                    var matches = data.match(/<title>(.*?)<\/title>/);
	                    var title = matches[1];

	                    // Append the project object

	                    $('#portfolio-detail').append($(data).find('article'));

	                    // Refresh some variables & events

	                    $project = $('article.project');
	                    $projectSlider = $('.swiper-container').length > 0 ? $('.swiper-container') : ($('.project-modal').length > 0 ? $('.project-modal') : null);
	                    $projectHorzHolder = $project.find('.gallery-holder').length > 0 ? $project.find('.gallery-holder') : null;
	                    $projectHorzHead = $('.project-horizontal .head');
	                    $projectContent = $('#project-content');

	                    $(window).off('.removeLater');

	                    // Init all extra scripts and do a resize

	                    initFolioScripts();
	                    resizeThumbs();

	                    // Analytics integraton

	                    if(themeObjects.gAnalytics == 'enabled') {
	                        ga('send', 'pageview', {
	                            'page': document.location.href,
	                            'title': document.title
	                        });
	                    }

	                }

	            });

	            // Push new History state

	            History.pushState({projectType: $this.data('type')}, $this.data('title'), $this.prop('href').replace(document.location.protocol + '//' + document.location.hostname, ''));

	        }

	    }

	    function changeProject(e) {

	        var $this = $(this);

	        if(moveThroughSingles) {
	            $('#modal-dummy-background').animate({'opacity': 0}, 150);
	        }

	        // This function opens a project when an older one is already opened

	        $project.stop().fadeOut(400, function(){

	            // Fade thumbnails based on the next project's type

	            if($this.data('type') == 'modal' && projectType != 'modal'){
	                fadeThumbs(.1, .1, 'out');
	            } else if($this.data('type') != 'modal' && projectType == 'modal'){
	                fadeThumbs(0, .1, 'out');
	            }

	            // Refresh project content and append start new loading

	            $loader.delay(50).fadeIn(200);

	            $('#portfolio-detail').html('');

	            $(window).off('.removeLater');
	            
	            projectType = $this.data('type');
	            historyChanged = false;
	            openProject($this);

	        });

	        e.preventDefault();

	    }

	    function closeProject(e) {

	        // This function closes the projects window

	        $project.stop().fadeOut(400, function(){

	            // When the project is faded out, fade the thumbnails back in

	            fadeThumbs(1, .3, 'in');

	            // Remove opened classes and reset grid position

	            $projectHolder.removeClass('opened');
	            $body.removeClass('opened');
	            $(window).scrollTop($folioContainer.css('top'))
	                .css('top', 0);
	                $('#portfolio').css('top', 0);

	            // Remove project holder and reset all variables

	            $('#portfolio-detail').remove();

	            $project = null;
	            $projectSlider = null
	            $projectHorzHolder = null;
	            $projectHorzHead = null;
	            $projectContent = null;
	            projectType = null;
	            firstProject = true;

	            $(window).off('.removeLater');

	            if($folioPagination != null) {
	                $folioPagination.stop().fadeIn(150);
	            }

	            $loader.stop().fadeOut(150);

	        });

	        // Push new History state

	        historyChanged = false;
	        History.pushState({projectType: 'original'}, initTitle, initHref);

	        if(e) e.preventDefault();

	    }

	    /* -------------------------------
	    -----   Slider Functions (called in the scripts init)   -----
	    ---------------------------------*/

	    var touchHorz = false,  
	        touchHorzT = 0;

	    function moveHorizontalContent(){

	        // Moves the content in the Horizontal projects thus giving a parallax effect

	        if(pWidth != 768) {

	            $projectSlider.css('top', -Math.round($(window).scrollTop() / 2));

	            $projectHorzHead.css('marginTop', Math.min(30, $(window).scrollTop()/8));

	        }

	    }

	    function moveHCenable() {
	        touchHorzT = setTimeout(function(){
	            touchHorz = false;
	        }, 500)
	    }
	    function moveHCdisable() {
	        touchHorz = true;
	        clearTimeout(touchHorzT);
	    }

	    function resetHorizontalContent(){

	        // Resets the positions in the Horizontal projects after the parallax effect

	        $projectSlider.height($(window).height()-maxHorzContHeight);
	        $projectHorzHolder.css({
	            'height': $(window).height()-maxHorzContHeight,
	            'top': 0
	        }).find('.swiper-nav').css('bottom', 0);

	        if(fixedSidebar){
	            $projectSlider.width($(window).width()-fixedSidebarWidth);
	        }

	    }

	    var hResize = 40;

	    function resizeProjectCentered(){

	        // Reset the position of horizontal projects

	        if(projectType == 'horizontal')
	            resetHorizontalContent();

	        // Change the size of the images within the gallery. Resize them proportionally to fit the screen

	        $projectSlider.find('img').each(function(){

	        	if($(this)[0].naturalWidth > 0 || $(this)[0].complete) {

		            var $img = $(this);

		            var maxHeight = Math.min($img.data('max-height'), $projectSlider.height()-hResize),
		                maxWidth = Math.min($img.data('max-width'), $projectSlider.width()-100),
		                oldHeight = $img.height(),
		                oldWidth = $img.width(),
		                ratio = Math.max(oldWidth / oldHeight, oldHeight / oldWidth),
		                newHeight = 0,
		                newWidth = 0;

		            // Complex calculations to get the perfect size

		            if(oldWidth > oldHeight){

		                if(maxWidth / ratio > maxHeight){
		                    newHeight = maxHeight;
		                    newWidth = maxHeight * ratio;
		                } else {
		                    newWidth = maxWidth;
		                    newHeight = maxWidth / ratio;
		                }

		            } else {

		                if(maxHeight / ratio > maxWidth){
		                    newWidth = maxWidth;
		                    newHeight = maxWidth * ratio;
		                } else {
		                    newHeight = maxHeight;
		                    newWidth = maxHeight / ratio;
		                }

		            }

		            // Apply the correct size and reposition

		            $img.css({
		                'width': Math.ceil(newWidth),
		                'height': Math.ceil(newHeight),
		                'top': Math.round(($projectSlider.height()-newHeight)/2),
		                'left': Math.round(($projectSlider.width()-newWidth)/2)
		            });

		        }

	        });

	    }

	    function resizeProjectFull(){

	        // Reset the position of horizontal projects

	        if(projectType == 'horizontal')
	            resetHorizontalContent();

	        // Change the size of the images within the gallery. Resize them proportionally to fill the screen

	        $projectSlider.find('img').each(function(){

	        	if($(this)[0].naturalWidth > 0 || $(this)[0].complete) {

		            var $img = $(this);

		            var maxHeight = $projectSlider.height(),
		                maxWidth = $projectSlider.width(),
		                oldHeight = $img.height(),
		                oldWidth = $img.width(),
		                ratio = Math.max(oldWidth / oldHeight, oldHeight / oldWidth),
		                newHeight = 0,
		                newWidth = 0;

		            // Complex calculations to get the perfect size

		            if(oldWidth > oldHeight){

		                if(maxWidth / ratio < maxHeight){
		                    newHeight = maxHeight;
		                    newWidth = maxHeight * ratio;
		                } else {
		                    newWidth = maxWidth;
		                    newHeight = maxWidth / ratio;
		                }

		            } else {

		                if(maxHeight / ratio < maxWidth){
		                    newWidth = maxWidth;
		                    newHeight = maxWidth * ratio;
		                } else {
		                    newHeight = maxHeight;
		                    newWidth = maxHeight / ratio;
		                }

		            }

		            // Apply the correct size and reposition

		            $img.css({
		                'width': Math.ceil(newWidth),
		                'height': Math.ceil(newHeight),
		                'top': Math.round((maxHeight - newHeight)/2),
		                'left': Math.round((maxWidth - newWidth)/2)
		            });

		        }

	        });

	    }

	    function resizeModal(){

	        // When the modal project is opened and at 100% width, it needs some proper resizing
	        $projectSlider.height($projectSlider.find('img').height());

	    }

	    /* -------------------------------
	    -----   Additional Functions   -----
	    ---------------------------------*/

	    History.Adapter.bind(window, 'statechange', function(){ 

	        // History JS work

	        if(historyChanged && history.pushState) {

	            var state = History.getState(); 

	            if(state.data != undefined) {

	                if(state.data.projectType == 'original' || state.data.projectType == 'undefined') {

	                    // Back to grid

	                    if(moveThroughSingles) {
	                        document.location.href = state.url;
	                    } else {
	                        closeProject();
	                    }

	                } else {

	                    var pT = 0,
	                        mT = 0;

	                    // Open new project (code below is clone/combination from the changeProject() & preOpenProject() functions)

	                    if(firstProject){

	                        $folioContainer.css('top', -$(window).scrollTop());
	                        $projectHolder.addClass('opened');
	                        $body.addClass('opened');

	                        projectType = state.data.projectType;

	                        $loader.fadeIn(150);
	                        pT = fadeThumbs((projectType == 'modal' ? .1 : 0), .15, 'out');

	                        $('#content').append('<section id="portfolio-detail"></section>');

	                    }

	                    setTimeout(function(){

	                        if(moveThroughSingles) {
	                            $('#modal-dummy-background').animate({'opacity': 0}, 150);
	                        }

	                        // Project opening

	                        if(firstProject){
	                            firstProject = false;
	                        } else {
	                            if($project != null) $project.stop().fadeOut(400);
	                            mT = 400;
	                        }

	                        setTimeout(function(){

	                            // Fade thumbnails based on the next project's type

	                            if(state.data.projectType == 'modal' && projectType != 'modal'){
	                                fadeThumbs(.1, .1, 'out');
	                            } else if(state.data.projectType != 'modal' && projectType == 'modal'){
	                                fadeThumbs(0, .1, 'out');
	                            }

	                            // Refresh project content and append start new loading

	                            $loader.delay(50).fadeIn(200);

	                            $('#portfolio-detail').html('');

	                            $(window).off('.removeLater');
	                            
	                            projectType = state.data.projectType;
	                            openProject($('<a href="' + state.url + '" data-type="' + state.data.projectType + '" data-title="' + state.title + '"></a>'));

	                        }, mT);

	                    }, pT)

	                }

	            }

	        }
	            
	        historyChanged = true;

	    });

	    function fadeThumbs(o, speed, dir){

	        // This is the function which fades out all thumbs in a random order, overwritting any tween which may be already running. It goes boes directions (in/out)

	        var maxTimeout = 0,
	            filteredA = false,
	            o2 = o,
	            dir2 = dir;

	        if(sortedFolio != null && dir == 'in') {
	            filteredA = true;
	            document.location.hash = sortedFolio;
	        }

	        $folioItems.each(function(){

	            var delayT = .15+Math.random()*speed,
	                timeT = .15+Math.random()*speed;
	            if(maxTimeout < delayT+timeT) {
	                maxTimeout = delayT+timeT;
	            }

	            if(filteredA && $(this).hasClass(sortedFolio)) {
	                o2 = themeObjects.folioOpacity;
	                dir2 = 'in';
	            } else if(filteredA && !$(this).hasClass(sortedFolio)) {
	                o2 = .1;
	                dir2 = 'out';
	            } else {
	                o2 = o;
	                dir2 = dir;
	            }

	            TweenMax.to($(this)[0], timeT, {
	                opacity: o2,
	                delay: delayT,
	                overwrite: 'all',
	                onCompleteScope: {
	                    $item: $(this), 
	                    dir3: dir2
	                }, 
	                onComplete: function(){
	                    if(this.dir3 == 'out') {
	                        this.$item.addClass('isotope-hidden');
	                    } else { 
	                        this.$item.removeClass('isotope-hidden');
	                    }
	                }
	            });

	        });

	        return maxTimeout*1000;

	    }

	    function contentScrollbar(){

	        // Init custom scrollbars for content - http://manos.malihu.gr/jquery-custom-content-scroller/
	        
	        $projectContent.mCustomScrollbar({
	            scrollInertia: 400,
	            theme: "me-2",
	            autoDraggerLength: false,
	            autoHideScrollbar: true,
	            mouseWheelPixels: 100,
	                advanced: {
	                    updateOnContentResize: true
	                }
	        });

	    }

	    function initMedia(){

	        // Init media elements

	        $('audio,video').mediaelementplayer({
	            alwaysShowControls: false,
	            iPadUseNativeControls: false,
	            iPhoneUseNativeControls: false,
	            AndroidUseNativeControls: false,
	            enableKeyboard: false,
	            pluginPath: themeObjects.base + '/js/mediaelement/',
	            success: function() {
	                $(window).trigger('resize');
	            }
	        });

	        $('.video-embedded').append('<div class="mejs-overlay-play"><div class="mejs-overlay-button"></div></div>')
	            .find('.mejs-overlay-button').click(function(e){

	                var $this = $(this).closest('.video-embedded');

	                if(!$this.hasClass('loading')) {

	                    var href = $this.data('href'),
	                        id = $this.data('id');

	                    $this.append('<div class="css-loader"></div><a href="#" class="close-iframe close-btn-special"></a><iframe id="video-frame-' + id + '" frameborder="0" vspace="0" hspace="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen' + ($html.hasClass('ie') ? ' allowtransparency="true"' : '') + '></iframe>')

	                        .addClass('loading')

	                        .find('.close-iframe').click(function(){
	                            $(this).closest('.video-embedded')
	                                .removeClass('loading')
	                                .find('iframe, .close-iframe').remove();
	                        });

	                    $('#video-frame-' + id).prop('src', href)   
	                        .load(function(){
	                            $(this).animate({'opacity': 1}, 200)
	                                .siblings('.css-loader').remove();
	                        });

	                }     

	                e.preventDefault();

	            });
	    }

	    /* -------------------------------
	    -----   Init Scripts   -----
	    ---------------------------------*/

	    function initSwiperCustom(swiper, callback) {

	        var mainDelay = callback ? .5 : 0;

	        if($(swiper.container).hasClass('centered')) {

	            var imgFadeT = 250;

	            // If this slider has centered images we need to calculate the maximum height for each image

	            for (var i = 0; i < swiper.slides.length; i++) {
	                var $img = $(swiper.slides[i]).find('img');
	                $img.data({
	                    'max-width': $img.attr('width'),
	                    'max-height': $img.attr('height')
	                })
	            }

	            // Attach the proper resize event to the window and do one

	            if($('.project').hasClass('type-gallery')) {
	                hResize = 140;
	            }
	            $(window).on('resize.removeLater', resizeProjectCentered);
	            resizeProjectCentered();

	        } else {

	            var imgFadeT = 0;

	            // Attach the proper resize event to the window and do one

	            $(window).on('resize.removeLater', resizeProjectFull);
	            resizeProjectFull();

	        }

	        // Fade in images

	        $(swiper.slides).find('img').delay(imgFadeT+mainDelay*1000).animate({'opacity': 1}, 300);

	        // Animate the project based on it's type

	        if(projectType == 'horizontal') {
	                    
	            $projectSlider.css('position', 'fixed');
	            $(window).trigger('resize');
	            $projectSlider.css('left', 40);

	            TweenMax.to($project[0], .9, {
	                height: $(window).height(),
	                opacity: 1,
	                ease: 'Quart.easeOut',
	                delay: mainDelay,
	                onComplete: function(){
	                    $project.css('height', 'auto');
	                }
	            });

	            // If this isn't a gallery project, animate the content as well and add the parallax event

	            if(!$project.hasClass('project-gallery')) {

	                TweenMax.to(
	                    [$projectContent[0], $project.find('.nav')[0]], .3, {
	                        opacity: 1,
	                        delay: mainDelay+.5
	                    }
	                );

	                if(!(touchM || disableParallax)) {
	                    $(window).on('scroll.removeLater', moveHorizontalContent);
	                } else {
	                    $('.horizontal-gallery').addClass('disable-parallax');
	                }

	            } else {

	                // It this is a gallery project, we only need to animate the project navigation

	                TweenMax.to(
	                    $project.find('.nav')[0], .3, {
	                        opacity: 1,
	                        delay: mainDelay+.5
	                    }
	                );

	                // If captions are enabled, create the captions holder, append the first caption and animate them

	                if($project.hasClass('captions-show')) {

	                    $('body').append('<span class="gallery-caption-dummy"></span>');

	                    $projectCaption = $('.gallery-caption');
	                    $projectCaptionDummy = $('.gallery-caption-dummy');

	                    $projectCaptionDummy.html(swiper.activeSlide().data('title'));

	                    $projectCaption.css('marginRight', 1)
	                        .append('<h4>' + swiper.activeSlide().data('title') + '</h4>')
	                        .css('width', $projectCaptionDummy.outerWidth());

	                    $projectCaption = $projectCaption.children('h4');

	                    $glc = $('.gallery-meta');

	                    $('.gallery-meta').stop().delay(mainDelay*1000+500).animate({'opacity': 1}, 200);

	                }

	            }

	        } else if(projectType == 'modal') {

	            // Modal projects animations and events

	            TweenMax.to($project[0], .8, {
	                left: '50%',
	                opacity: 1,
	                delay: mainDelay,
	                ease: 'Quart.easeOut'
	            });

	            $(window).on('resize.removeLater', resizeModal);
	            resizeModal();

	        }

	        // Run callback if present

	        if(callback) {
	            callback();
	        } else {
	            $loader.stop().fadeOut(150);
	        }

	        if($projectNav != null) {
	            $projectNav.delay(mainDelay*1000+500).animate({'opacity': 1}, 200);
	        }


	    }
	    function initFolioScripts(callback){

	        // Vertical gallery init

	        if(projectType == 'vertical') {

	            $('#portfolio-detail').css('position', 'fixed');

	            // Init custom scrollbar for the images - http://manos.malihu.gr/jquery-custom-content-scroller/

	            if(!(touchM && rWidth == 620)) {

	                $('.vertical-gallery').mCustomScrollbar({
	                    scrollInertia: 500,
	                    theme: "me",
	                    autoDraggerLength: false,
	                    autoHideScrollbar: true,
	                    mouseWheelPixels: 500,
	                    advanced: {
	                        updateOnContentResize: true,
	                        autoScrollOnFocus: false
	                    }
	                });

	            }

	            // Animate the project, similar to the horizontal one (below)

	            setTimeout(function(){

	                TweenMax.to($project[0], .8, {
	                    width: '100%',
	                    ease: 'Quart.easeOut',
	                    delay: .2,
	                    overwrite: 'all',
	                    onComplete: function(){

	                        // When the project is shown, fade in the loaded images, or wait until loaded, then show..

	                        $('.vertical-gallery').find('img').each(function(){
	                            var $img = $(this);
	                            if($img[0].complete || $img[0].naturalWidth > 0) {
	                                $img.closest('li').animate({'opacity': 1}, 200);
	                            } else {
	                                $img.load(function(){
	                                    $img.closest('li').animate({'opacity': 1}, 200);
	                                });
	                            }
	                        }).end().find('video').each(function(){
	                            var $video = $(this);
	                            $video.closest('li').delay(150).animate({'opacity': 1}, 200);
	                        });

	                        // Content sidebar for vertical

	                        $contentFixed = $('.project-vertical');

	                        if(!(touchM && rWidth == 620)) {
	                            contentScrollbar();
	                        }

	                        // Most weird bug fix i have ever written

	                        if(rWidth == 620){
	                            handleResize();
	                            $(window).trigger('resize');
	                            $('.vertical-gallery li').css('marginBottom', 49);
	                            $('.nav.me-buttons').css('marginTop', 29);
	                        }

	                    }

	                });

	                TweenMax.to($projectContent[0], .3, {
	                    opacity: 1,
	                    delay: .9, 
	                    onComplete: function(){
	                        $(window).trigger('resize');
	                    }
	                });

	                $loader.stop().fadeOut(150);

	                // Init media elements

	                initMedia();
	                dbdBehavior();

	                // Run callback if present

	                if(callback) callback();

	                // Add a resize event for fixed sidebars

	                if(fixedSidebar){
	                    $(window).on('resize.removeLater', function(){
	                        $('#portfolio-detail').width($(window).width()-fixedSidebarWidth)
	                    }).trigger('resize');
	                }

	            }, 1500);

	        }

	        // Content sidebar for modal

	        if(projectType == 'modal') {
	        	
	        	if (!(touchM && rWidth == 620)){
	            	contentScrollbar();
	        	}

	            modalQuery(false);
	            $('#portfolio-detail').css({
	                'position': 'fixed',
	                'left': 40,
	                'marginLeft': -40
	            });

	            if(moveThroughSingles) {
	                $('#modal-dummy-background').animate({'opacity': 1}, 300);
	            }

	            $projectSlider.append('<div id="modal-test-query"></div>');

	            // Add modal close by click feature

	            if(themeObjects.modalCloseClick == 'true') {

	                if($('#modal-click').length <= 0 ){
	                    $('#portfolio-detail').append('<div id="modal-click"></div>');
	                    $('#modal-click').on('click', function(){
	                        $('.nav').find('.btn-close').trigger('click');
	                    });
	                }

	            }

	        } else {

	            modalQuery(true);

	        }

	        // Set Horizontal Slider's height 

	        if(projectType == 'horizontal') {
	            $projectSlider.height($(window).height()-maxHorzContHeight);
	            $projectHorzHolder.height($(window).height()-maxHorzContHeight);
	            $contentFixed = $projectSlider;
	            $('#portfolio-detail').css('position', 'relative');
	        }

	        // Init slider if present - http://www.idangero.us/sliders/swiper/
	        
	        if((projectType == 'modal' && !$('.modal').hasClass('single')) || projectType == 'horizontal') {

	            var firstImg = $('.swiper-container').find('img')[0];

	            var swiper = $projectSlider.swiper({

	                // Variables - they are pretty stable as defined :)

	                mode: 'horizontal',
	                loop: true,
	                calculateHeight: false,
	                grabCursor: true,
	                centeredSlides: true,
	                useCSS3Transforms: true,
	                resizeReInit: true,
	                updateOnImagesReady: false,
	                createPagination: true,
	                noSwiping: true,
	                noSwipingClass: 'no-swipe',
	                autoplay: 0,
	                speed: 300,
	                resistance: false,
	                keyboardControl: true,

	                onSwiperCreated: function(swiper) {

	                    // On the first init append the custom navigation (depending on the project type) and bind the proper events

	                    var $appendTo = projectType == 'horizontal' ? ($project.hasClass('project-gallery') ? $project : $projectContent) : $(swiper.container);

	                    if(swiper.slides.length-2 > 1) {
	                        $appendTo.append('<ul class="swiper-nav" style="opacity:0"><li><a class="swiper-no"><span class="cur">1</span><span class="tot">' + (swiper.slides.length-2) + '</span></a></li><li><a href="#" class="swiper-prev"></a></li><li><a href="#" class="swiper-next"></a></li></ul>');
	                    } else { 
	                        $appendTo.append('<ul style="pointer-events: none" class="swiper-nav single-nav" style="opacity:0"><li><a class="swiper-no"><span class="cur">1</span><span class="tot">' + (swiper.slides.length-2) + '</span></a></li></ul>');
	                        $(swiper.container).css('pointer-events', 'none');
	                    }

	                    $appendTo.find('.swiper-next').on('click', function(e){
	                        swiper.swipeNext();
	                        e.preventDefault();
	                    });
	                    $appendTo.find('.swiper-prev').on('click', function(e){
	                        swiper.swipePrev();
	                        e.preventDefault();
	                    });

	                    $projectNav = $('.swiper-nav');

	                    // Init media elements

	                    initMedia();
	                    dbdBehavior();

	                    // Search for images and load "load" the first one - when it's ready, continue with the initialization

	                    if(firstImg.complete || firstImg.naturalWidth > 0) {
	                        initSwiperCustom(swiper, callback);
	                    } else {

	                    	$(firstImg).attr('src', $(firstImg).attr('src'));

	                        $(firstImg).on('load', function(){
	                            initSwiperCustom(swiper, callback);
	                        });

	                    }

			            $projectSlider.find('img').on('load', function(){
			            	$(window).trigger('resize');
			            });

	                },

	                // The two functions below are for the customization of the grabbing mouse cursor

	                onTouchStart: function(swiper){
	                    $(swiper.container).addClass('grabbing');
	                },
	                onTouchEnd: function(swiper){
	                    $(swiper.container).removeClass('grabbing');
	                },

	                // Refresh the pagination in the custom navigation, change the captions for gallery projects and fix continuous video play bug

	                onSlideChangeStart: function(swiper){
	                    $projectNav.find('.cur').text(swiper.activeLoopIndex+1);
	                },

	                onSlideChangeEnd: function(swiper){

	                    if($project.hasClass('captions-show')) {

	                        $projectCaptionDummy.html(swiper.activeSlide().data('title'));

	                        TweenMax.to($projectCaption[0], .1, {
	                            opacity: 0,
	                            overwrite: 'all',
	                            onComplete: function(){

	                                TweenMax.to($projectCaption.parent()[0], .1, {
	                                    width: $projectCaptionDummy.outerWidth(),
	                                    overwrite: 'all',
	                                    onComplete: function(){

	                                        $projectCaption.html(swiper.activeSlide().data('title'));

	                                        TweenMax.to($projectCaption[0], .1, {
	                                        	opacity: 1,
	                                        	overwrite: 'all'
	                                        });

	                                    }
	                                });

	                            }
	                        });

	                    }

	                    if($(swiper.slides).eq(swiper.previousIndex).find('.video-hosted').length > 0) {
	                    }

	                    if($(swiper.slides).eq(swiper.previousIndex).find('.video-embedded').length > 0) {

	                        $(swiper.slides).eq(swiper.previousIndex).find('.video-embedded')
	                            .removeClass('loading')
	                            .find('iframe, close-iframe').remove();

	                    }


	                }

	            });

	        } else if(projectType == 'modal' && $('.modal').hasClass('single')) {

	            // Because our inits were tied to the modal project, when we have a single image in the modal project we need to have a different "init"

	            initMedia();
	            dbdBehavior();

	            $('.modal').imagesLoaded(function(){

	                TweenMax.to($project[0], .8, {
	                    left: '50%',
	                    opacity: 1,
	                    ease: 'Quart.easeOut'
	                });

	                $(window).on('resize.removeLater', resizeModal);
	                resizeModal();
		            $(window).trigger('resize');

	                $loader.stop().fadeOut(150);

	                if(callback) callback();

	            });

	        }

	        // Rerwite navigation links

	        $project.find('.btn-prev').on('click', changeProject);
	        $project.find('.btn-next').on('click', changeProject);

	        if(!$body.hasClass('single')) {
	            $project.find('.btn-close').on('click', closeProject);
	        } else {
	            $project.find('.btn-close').on('click', function(){
	                document.location.href = $(this).prop('href');
	            });
	        }

	        initDefShortcodes();

	    }

	    // A little something for when we view a single project item. Some things need to be initialized differently in order to ensure full AJAX compatibility

	    var moveThroughSingles = false;

	    if($body.hasClass('single') && $body.hasClass('is-portfolio')) {

	        moveThroughSingles = true;
	        $('#content').append('<div id="modal-dummy-background" style="background-image:url(' + themeObjects.modalDummyBackground + ')"></div>');

	        $('.project').wrap('<section id="portfolio-detail"></section>');
	        firstProject = false;

	        initFolioScripts(function(){

	            $loader.delay(150).fadeOut(150);

	            if(!$body.hasClass('sidebar-show')) {

	                $sidebar.delay(300).animate({
	                    'left': -260
	                }, 200, function(){
	                    $(document).on('mousemove', function(event){
	                        if(event.pageX < 40){
	                            openSidebar();
	                        } else if(event.pageX > 310) {
	                            closeSidebar();
	                        }
	                    });
	                });

	            } else {
	               // openSidebar();
	            }

	        });

	    }

	/* ----------------------------------------------------
	---------- !! SINGLE GALLERY !! -----------------
	------------------------------------------------------- */

	    var iLoaded = 0,
	        iTotal = 0;

	    if($body.hasClass('page-template-template-single-gallery-php')) {

	        // Redefine folio items and max width (used by the resize function), then attach the resize event and do one

	        $folioItems = $('.gallery-item');
	        $folioContainer = $('#gallery');
	        $projectHolder = $('<div class="no-3deffects"></div>');

	        maxImgWidth = 340;
	        iTotal = $folioItems.length;

	        $(window).on('resize', resizeThumbs);
	        resizeThumbs();

	        $folioItems.each(function(){

	            var $img = $(this).find('img');
	            if($img[0].complete || $img[0].naturalWidth > 0) {
	                iLoaded++;
	                checkLoading();
	            } else {

	                if($html.hasClass('ie10')) {
	                    $img.attr('src', $img.attr('src'));
	                }

	                $img.on('load', function(){
	                    iLoaded++;
	                    checkLoading();
	                });

	            }

	        });

	    }

	    // Load or check each image for loading, then animate it nicely into the screen

	    function checkLoading() {

	        if(iLoaded == iTotal){

	            $folioItems.each(function(){

	            TweenMax.to($(this)[0], .2, {
	                opacity: 1,
	                delay: .2+$(this).index()*.1,
	                onCompleteScope: $(this), 
	                onComplete: function(){
	                    $(this).removeClass('isotope-hidden');
	                }
	            });

	        });

	        $loader.fadeOut(150);

	        }

	    }

	/* ----------------------------------------------------
	---------- !! SINGLE IMAGE !! -----------------
	------------------------------------------------------- */

	    if($body.hasClass('page-template-template-single-image-php')) {

	        var $singleImage = $('.single-image'),
	            $singleImageLoader = $('#single-image-loader'),
	            $singleImageContent = $('.single-image-content');

	        // Load the background image, then load the other three objects (if present)

	        $loader.fadeIn(150);

	        $singleImageLoader

	            .append('<img style="display: none" src="' + $singleImage.data('background') + '" />')

	            .find('img').load(function(){

	                $loader.fadeOut(150);

	                $singleImage

	                    .css('backgroundImage', 'url(' + $singleImage.data('background') + ')')

	                    .animate({'opacity': 1}, 600, function(){

	                        var sio = 0;

	                        $singleImageContent.children('div').each(function(){

	                            $(this)
	                                .delay(500*sio++)
	                                .animate({
	                                    'top': 0,
	                                    'opacity': 1
	                                }, 600);

	                        });

	                    });

	            });

	    }

	/* ----------------------------------------------------
	---------- !! SINGLE VIDEO !! -----------------
	------------------------------------------------------- */

	    if($body.hasClass('page-template-template-single-video-php')) {

	        // Load the background image, then load the other three objects (if present)

	        $loader.fadeIn(150);

	        var globalME = null,
	            $poster = null;

	        $('#video-obj').mediaelementplayer({

	            alwaysShowControls: false,
	            iPadUseNativeControls: false,
	            iPhoneUseNativeControls: false,
	            AndroidUseNativeControls: false,
	            enableKeyboard: true,
	            pluginPath: themeObjects.base + '/js/mediaelement/',

	            success: function(mediaElement, domObject, player){

	                globalME = mediaElement;
	                mediaElement.play();

	                var origWidth = player.width,
	                    origHeight = player.height,
	                    ratio = Math.max(origWidth / origHeight, origHeight / origWidth);

	                $(window).on('resize', function(){

	                    var maxWidth = $(window).width() - (fixedSidebar ? fixedSidebarWidth : 0),
	                        maxHeight = $(window).height(),
	                        newHeight = 0,
	                        newWidth = 0;

	                    // Complex calculations to get the perfect size

	                    if(origWidth > origHeight){

	                        if(maxWidth / ratio < maxHeight){
	                            newHeight = maxHeight;
	                            newWidth = maxHeight * ratio;
	                        } else {
	                            newWidth = maxWidth;
	                            newHeight = maxWidth / ratio;
	                        }

	                    } else {

	                        if(maxHeight / ratio < maxWidth){
	                            newWidth = maxWidth;
	                            newHeight = maxWidth * ratio;
	                        } else {
	                            newHeight = maxHeight;
	                            newWidth = maxHeight / ratio;
	                        }

	                    }

	                    // Apply the correct size and reposition

	                    $('#' + player.media.id).css({
	                        'width': Math.ceil(newWidth),
	                        'height': Math.ceil(newHeight),
	                        'top': Math.round((maxHeight - newHeight)/2),
	                        'left': Math.round(($(window).width() - newWidth + (fixedSidebar ? fixedSidebarWidth : 0))/2)
	                    });

	                    if ( player.media.pluginType != 'native' ) {
	                    	globalME.setVideoSize(newWidth,newHeight);
						}

	                    if($poster != null){
	                        $poster.css({
	                            'width': Math.ceil(newWidth),
	                            'height': Math.ceil(newHeight),
	                            'top': Math.round((maxHeight - newHeight)/2),
	                            'left': Math.round(($(window).width() - newWidth + (fixedSidebar ? fixedSidebarWidth : 0))/2)
	                        });
	                    }

	                }).trigger('resize');

	                $loader.delay(100).fadeOut(150);
	                $(domObject).delay(300).animate({'opacity': 1}, 1000, function(){

	                    if(globalME.paused){
	                        $poster = $('.mejs-poster');
	                        $poster.addClass('noplay');
	                        $('.mejs-overlay-play').addClass('noplay');
	                        $(window).trigger('resize');
	                    }

	                    $('.single-image').click(function(){

	                        if(globalME.paused) {
	                            globalME.play();
	                        } else {
	                            globalME.pause();
	                        }

	                    });

	                    var sio = 0;

	                    $('.single-image-content').children('div').each(function(){

	                        $(this)
	                            .delay(500*sio++)
	                            .animate({
	                                'top': 0,
	                                'opacity': 1
	                            }, 600);

	                    });

	                });

	            },

	            error: function(){
	            	console.log('fsv error');
	            }

	        });

	    }

	/* ----------------------------------------------------
	---------- !! FULLSCREEN SLIDESHOW !! -----------------
	------------------------------------------------------- */

	    if($body.hasClass('page-template-template-slideshow-php')) {

	        var $slideshow = $('#slideshow');

	        $slideshow.swiper({

	            // Variables - they are pretty stable as defined :)

	            mode: 'horizontal',
	            loop: true,
	            calculateHeight: false,
	            grabCursor: true,
	            centeredSlides: true,
	            useCSS3Transforms: true,
	            resizeReInit: true,
	            updateOnImagesReady: true,
	            createPagination: false,
	            noSwiping: true,
	            noSwipingClass: 'no-swipe',
	            autoplay: 0,
	            speed: 800,
	            resistance: false,
	            keyboardControl: true,

	            onImagesReady: function(swiper){

	                // Fade in images

	                $(swiper.slides).find('img').delay(100).animate({'opacity': 1}, 600);

	                $loader.fadeOut(150);

	                // Show first html content

	                setTimeout(function(){

	                    var sio = 0;

	                    $(swiper.slides[swiper.activeIndex]).find('.single-image-content').children('span').each(function(){
	                        $(window).trigger('resize');
	                        TweenMax.to($(this)[0], .6, {
	                            delay: .5+.5*sio++,
	                            top: 0,
	                            opacity: 1,
	                            overwrite: 'all'
	                        });

	                    });

	                }, 500);

	                // Configure resize event

	                $(window).on('resize', function(){

	                    $slideshow.width($(window).width() - (fixedSidebar ? fixedSidebarWidth : 0));

	                    $slideshow.find('img').each(function(){

	                        var $img = $(this);

	                        var maxHeight = $(window).height(),
	                            maxWidth = $slideshow.width(),
	                            oldHeight = $img.height(),
	                            oldWidth = $img.width(),
	                            ratio = Math.max(oldWidth / oldHeight, oldHeight / oldWidth),
	                            newHeight = 0,
	                            newWidth = 0;

	                        // Complex calculations to get the perfect size

	                        if(oldWidth > oldHeight){

	                            if(maxWidth / ratio < maxHeight){
	                                newHeight = maxHeight;
	                                newWidth = maxHeight * ratio;
	                            } else {
	                                newWidth = maxWidth;
	                                newHeight = maxWidth / ratio;
	                            }

	                        } else {

	                            if(maxHeight / ratio < maxWidth){
	                                newWidth = maxWidth;
	                                newHeight = maxWidth * ratio;
	                            } else {
	                                newHeight = maxHeight;
	                                newWidth = maxHeight / ratio;
	                            }

	                        }

	                        // Apply the correct size and reposition

	                        $img.css({
	                            'width': Math.ceil(newWidth),
	                            'height': Math.ceil(newHeight),
	                            'top': Math.round((maxHeight - newHeight)/2),
	                            'left': Math.round((maxWidth - newWidth)/2)
	                        });

	                    });

	                }).trigger('resize');
	                
	                swiper.resizeFix();

	                // refresh GLC object

	                $glc = $('.single-image-content').children('*');

	            },

	            // The two functions below are for the customization of the grabbing mouse cursor

	            onTouchStart: function(swiper){
	                $(swiper.container).addClass('grabbing');
	            },
	            onTouchEnd: function(swiper){
	                $(swiper.container).removeClass('grabbing');
	            },

	            // Animate the html content blocks if present

	            onSlideChangeEnd: function(swiper){

	                var sio = 0;

	                // new blocks "in"

	                $(swiper.slides[swiper.activeIndex]).find('.single-image-content').children('span').each(function(){

	                    TweenMax.to($(this)[0], .6, {
	                        delay: .5*sio++,
	                        top: 0,
	                        opacity: 1,
	                        overwrite: 'all'
	                    });

	                });

	                // old blocks "out"

	                $(swiper.slides[swiper.previousIndex]).find('.single-image-content').children('span').css({
	                    'top': 50,
	                    'opacity': 0
	                });

	            }

	        });

	    }

	/* ----------------------------------------------------
	---------- !! CONTACT !! -----------------
	------------------------------------------------------- */

	    if($body.hasClass('page-template-template-contact-php') && $('.format-image').hasClass('a-map')) {

	        var $mapDataObj = $('.format-image.a-map'),
	            $mapInsert = $('#insert-map');

	        if (!window.addEventListener) {
	            window.onload = addMap;
	        } else { 
	            window.addEventListener('load', addMap, false);
	        }

	    }

	    // Configure the custom Google Maps API instance

	    function addMap(){

	        var map;

	        var stylez = [
	            {
	              featureType: "all",
	              elementType: "all",
	              stylers: [
	                { saturation: -100 }
	              ]
	            }
	        ];

	        var mapOptions = {
	            zoom: $mapDataObj.data('zoom'),
	            center: new google.maps.LatLng($mapDataObj.data('map-lat'), $mapDataObj.data('map-long')),
	            streetViewControl: true,
	            scrollwheel: false,
	            panControl: true,
	            mapTypeControl: false,
	            overviewMapControl: false,
	            zoomControl: true,
	            draggable: touchM ? false : true,
	            zoomControlOptions: {
	                style: google.maps.ZoomControlStyle.LARGE
	            },
	            mapTypeControlOptions: {
	                 mapTypeIds: [google.maps.MapTypeId.ROADMAP, 'krownMap']
	            }
	        };

	        map = new google.maps.Map(document.getElementById("insert-map"), mapOptions);

	        if($mapDataObj.data('greyscale') == 'd-true') {

	            var mapType = new google.maps.StyledMapType(stylez, { name:"Grayscale" });    
	            map.mapTypes.set('krownMap', mapType);
	            map.setMapTypeId('krownMap');

	        }

	        if($mapDataObj.data('marker') == 'd-true') {

	            var myLatLng = new google.maps.LatLng($mapDataObj.data('map-lat'), $mapDataObj.data('map-long'));
	            var beachMarker = new google.maps.Marker({
	                position: myLatLng,
	                map: map,
	                icon: $mapDataObj.data('marker-img')
	            });

	        }

	        //animations

	        setTimeout(function(){

	            $postFormatHolder.css({
	                'backgroundImage': 'none',
	                'height': 500
	            });

	            $mapInsert.delay(250).animate({'opacity': 1}, 300);

	            $mapDataObj.animate({'height': 500}, 300, function(){
	                
	                $postFormatHolder.addClass('on');

	                if(!(touchM || disableParallax)){
	                    $(window).on('scroll', function(){
	                        $mapInsert.css('top', -Math.round($(window).scrollTop()/2));
	                    });
	                }

	                if((touchM || disableParallax) || pWidth == 768 || (qWidth == 1024 && fixedSidebar)){
	                    $mapInsert.addClass('disable-parallax');
	                }

	            });


	        }, 1000);

	    }

	/* ----------------------------------------------------
	---------- !! BLOG SINGLE POSTS !! -----------------
	------------------------------------------------------- */

	    // With the risk of having duplicated code (several declarations of the swiper gallery and other popular snippets) i've decided to work with an "if case" for all single blog posts, for the sake of readibility and keeping all things really organized. So please forgive the extra 100 lines of code :)

	    if($body.hasClass('page') && $('article').hasClass('w-custom-header')) {

	        var $article = $('article'),
	        	$postFormatHolder = $('.is-other'),
	        	$postFormatHolder2 = null,
	        	$postFormatInstance = null;

	        // Until now all this was for the blog posts, but since we also have parallax effects for custom headers on regular pages, we need to do an if statement and initialize some of the functions above here as well

	        $('<img/>').prop('src', $postFormatHolder.data('background'))
	            .load(function(){

	                $(this).remove();
	                $postFormatHolder.append('<span class="post-format-image" style="background-image:url(' + $postFormatHolder.data('background') + ')"></span>');

	                $postFormatHolder2 = $postFormatHolder.children('*');
	                $postFormatInstance = $postFormatHolder.children('span');

	                initPostParallax();

	                $('.format-image').animate({
	                    'height': 300,
	                    'opacity': 1
	                }, 300, 'easeInQuad');

	            });

	    }

	    // Related functions (called above)

	    function initPostParallax(){

	        if(!(touchM || disableParallax)) {

	            $(window).on('scroll', function(){

	                if(pWidth != 768) {

	                    $postFormatHolder2.css('top', -Math.round($(window).scrollTop() / 2));

	                    if($article.hasClass('w-custom-header')) {

	                        $('h1').css('opacity', (300-$(window).scrollTop())/300);
	                    }

	                } else {

	                    $postFormatHolder2.addClass('disable-parallax');

	                }

	            });

	            handleResize();
	            $postFormatHolder.addClass('on');

	        } else {

	            $postFormatHolder2.addClass('disable-parallax');

	        }

	    }

	/* ----------------------------------------------------
	---------- !! BLOG GRID !! -----------------
	------------------------------------------------------- */

	    if(($body.hasClass('page-template-template-blog-php') || $body.hasClass('archive') || $body.hasClass('search') || $body.hasClass('blog')) && !($body.hasClass('blog-style-fixed') && $body.hasClass('alt'))) {

	        var $blogGrid = $('.blog-grid');

	        // Load blog grid, "isotope it", then fade in all posts

	        $blogGrid.imagesLoaded(function(){

	            $blogGrid.isotope({
	                itemSelector: 'article',
	                animationEngine: 'jquery'
	            });

	            $loader.fadeOut(150);

	            $body.find('article').each(function(){
	                $(this).delay(150+Math.random()*150)
	                    .css('visibility', 'visible')
	                    .animate({'opacity': 1}, 150+Math.random()*150, function(){
	                        $(this).removeClass('isotope-hidden');
	                    });
	            });

	            setTimeout(function(){
	                $('.blog-grid-nav').animate({'opacity': 1}, 200);
	            }, 1000);

	            setTimeout(function(){
	            	 $blogGrid.isotope();
	            	 $(window).trigger('resize');
	            }, 150);

	        });

	    }

	/* ----------------------------------------------------
	---------- !! DEFAULT SHORTCODES !! -----------------
	------------------------------------------------------- */

	    initDefShortcodes();

	    function initDefShortcodes(){

	        // Dirty but working

	        $('p:empty').remove();

	        /* -------------------------------
	        -----   Video / Audio Elements   -----
	        ---------------------------------*/

	        $('.page-content, .blog-grid, .blog-style-fixed .post-format-content').find('audio,video').each(function(){
	        	
	            $(this).mediaelementplayer({
	                alwaysShowControls: true,
	                iPadUseNativeControls: false,
	                iPhoneUseNativeControls: false,
	                AndroidUseNativeControls: false,
	                enableKeyboard: false,
	                pluginPath: themeObjects.base + '/js/mediaelement/'
	            });
	        });

	        /* -------------------------------
	        -----   Gallery Shortcode   -----
	        ---------------------------------*/

	        // Actually, this turned out to be used only in the blog grid, because the slider i used isn't as responsive as i wanted, so it threw a lot of bugs.

	        if($('.krown-gallery').length > 0) {

	            $('.krown-gallery').each(function(){

	                $(this).swiper({

	                    // Variables - they are pretty stable as defined :)

	                    mode: 'horizontal',
	                    loop: true,
	                    calculateHeight: false,
	                    grabCursor: true,
	                    centeredSlides: true,
	                    useCSS3Transforms: true,
	                    resizeReInit: false,
	                    updateOnImagesReady: true,
	                    createPagination: false,
	                    noSwiping: true,
	                    noSwipingClass: 'no-swipe',
	                    autoplay: 0,
	                    speed: 300,
	                    resistance: false,
	                    keyboardControl: false,

	                    onFirstInit: function(swiper) {

	                        // On the first init append the custom navigation (depending on the project type) and bind the proper events

	                        if(swiper.slides.length > 1) {
	                            $(swiper.container).append('<ul class="swiper-nav"><li><a class="swiper-no"><span class="cur">1</span><span class="tot">' + (swiper.slides.length-2) + '</span></a></li><li><a href="#" class="swiper-prev"></a></li><li><a href="#" class="swiper-next"></a></li></ul>');
	                        }

	                        $(swiper.container).find('.swiper-next').on('click', function(e){
	                            swiper.swipeNext();
	                            e.preventDefault();
	                        });
	                        $(swiper.container).find('.swiper-prev').on('click', function(e){
	                            swiper.swipePrev();
	                            e.preventDefault();
	                        });

	                    },

	                    onImagesReady: function(swiper){

	                        $(swiper.container).find('div').css('height', $(swiper.container).find('img').height());

	                        // Fade in images & navigation

	                        $(swiper.slides).find('img').delay(200).animate({'opacity': 1}, 300);

	                        if($body.hasClass('blog-style-fixed') && $body.hasClass('single')) {
	                            $(window).on('resize', function(){
	                                $(swiper.container).height($(swiper.container).find('img').height());
	                            });
	                        }

	                    },

	                    // The two functions below are for the customization of the grabbing mouse cursor

	                    onTouchStart: function(swiper){
	                        $(swiper.container).addClass('grabbing');
	                    },
	                    onTouchEnd: function(swiper){
	                        $(swiper.container).removeClass('grabbing');
	                    },

	                    // Refresh the pagination in the custom navigation and fix continuous video play

	                    onSlideChangeStart: function(swiper){
	                        $(swiper.container).find('.cur').text(swiper.activeLoopIndex+1);
	                    }

	                });

	            });

	        }

	        /* -------------------------------
	        -----   Accordions   -----
	        ---------------------------------*/

	        $('.krown-accordion').each(function(){

	            var toggle = $(this).hasClass('toggle') ? true : false,
	                $sections = $(this).children('section'),
	                $opened = $(this).data('opened') == '-1' ? null : $sections.eq(parseInt($(this).data('opened')));

	            if($opened != null){
	                $opened.addClass('opened');
	                $opened.children('div').slideDown(0);
	            }

	            $(this).children('section').children('h5').click(function(){

	                var $this = $(this).parent();

	                if(!toggle){
	                    if($opened != null){
	                        $opened.removeClass('opened');
	                        $opened.children('div').stop().slideUp(300);
	                    }
	                }

	                if($this.hasClass('opened') && toggle){
	                    $this.removeClass('opened');
	                    $this.children('div').stop().slideUp(300);
	                } else if(!$this.hasClass('opened')){
	                    $opened = $this;
	                    $this.addClass('opened');
	                    $this.children('div').stop().slideDown(300);
	                }

	            });

	        });

	        /* -------------------------------
	        -----   Tabs   -----
	        ---------------------------------*/

	        $('.krown-tabs').each(function(){

	            var $titles = $(this).children('.titles').children('li'),
	            $contents = $(this).children('.contents').children('div'),
	            $openedT = $titles.eq(0),
	            $openedC = $contents.eq(0);

	            $openedT.addClass('opened');

	            $titles.find('a').prop('href', '#').off('click');;

	            $titles.click(function(e){

	                $openedT.removeClass('opened');
	                $openedT = $(this);
	                $openedT.addClass('opened');

	                $openedC.stop().slideUp(200);
	                $openedC = $contents.eq($(this).index());
	                $openedC.stop().delay(200).slideDown(200);

	                e.preventDefault();

	            });

	        });

	        /* -------------------------------
	        -----   Fancybox   -----
	        ---------------------------------*/

	        $('img.alignleft, img.alignright, img.aligncenter').parent('a').each(function(){
	            $(this).attr('class', 'fancybox fancybox-thumb ' + $(this).children('img').attr('class'));
	        });

	        if($('.fancybox').length > 0 || $('div[id*="attachment"]').length > 0){

	            $('.fancybox, div[id*="attachment"] > a').fancybox({
	                padding: 0,
	                margin: 50,
	                aspectRatio: true,
	                scrolling: 'no',
	                mouseWheel: false,
	                openMethod: 'zoomIn',
	                closeMethod: 'zoomOut',
	                nextEasing: 'easeInQuad',
	                prevEasing: 'easeInQuad'
	            }).append('<span></span>');
	        }
	        
	    }

	    /* -------------------------------
	    -----   Style all selects   -----
	    ---------------------------------*/

	    $('select').styledSelect();

	    /* -------------------------------
	    -----   Go Top Button   -----
	    ---------------------------------*/

	    var $top = $('#top');

	    $top.click(function(e){
	        $('html,body').animate({scrollTop: 0}, 500, 'easeInQuad');
	        e.preventDefault();
	    });

	    $(window).scroll(function(){
	        if($(this).scrollTop() > 500) {
	            $top.stop(true, true).fadeIn();
	        } else {
	            $top.stop(true, true).fadeOut(200);
	        }
	    });

	    /* -------------------------------
	    -----   Contact Forms   -----
	    ---------------------------------*/

	    $('.krown-form').each(function(){

	        var $form = $(this).find('form'),
	        $name = $(this).find('.name'),
	        $email = $(this).find('.email'),
	        $subject = $(this).find('.subject'),
	        $message = $(this).find('.message'),
	        $success = $(this).find('.success-message'),
	        $error = $(this).find('.error-message');

	        $name.focus(function(){resetError($(this))});
	        $email.focus(function(){resetError($(this))});
	        $subject.focus(function(){resetError($(this))});
	        $message.focus(function(){resetError($(this))});

	        function resetError($input){
	            $input.removeClass('contact-error-border');
	            $error.fadeOut();
	        }

	        $form.submit(function(e){

	            var ok = true;
	            var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;

	            if($name.val().length < 3 || $name.val() == $name.data('value')){
	                showError($name);
	                ok = false;
	            }

	            if($email.val() == '' || $email.val() == $email.data('value') || !emailReg.test($email.val())){
	                showError($email);
	                ok = false;
	            }

	            if($message.val().length < 5 || $message.val() == $message.data('value')){
	                showError($message);
	                ok = false;
	            }

	            if($(this).hasClass('full') && ($subject.val().length < 3 || $subject.val() == $subject.data('value'))){
	                showError($subject);
	                ok = false;
	            }

	            function showError($input){
	                $input.val($input.data('value'));
	                $input.addClass('contact-error-border');
	                $error.fadeIn();
	            }

	            if(ok){

	                $form.fadeOut();

	                $.ajax({
	                    type: $form.prop('method'),
	                    url: $form.prop('action'),
	                    data: $form.serialize(),
	                    success: function(){
	                      $success.fadeIn();
	                  }
	              });

	            }

	            e.preventDefault();

	        });

	    });

	    /* -------------------------------
	    -----   DPI Cookie   -----
	    ---------------------------------*/

	    var retina = window.devicePixelRatio > 1;
	    $.cookie('dpi', retina, {expires: 365, path: '/'});

	    /* -------------------------------
	    -----   Input Trick   -----
	    ---------------------------------*/

	    $('input, textarea').each(function(){
	    
	        if($(this).attr('type') != 'submit'){

	            $(this)
	                .data('value', $(this).val())
	                .focus(function(){
	                    $(this).addClass('focusInput');
	                    if($(this).val() == $(this).data('value')){
	                      $(this).val('');
	                    } else {
	                      $(this).select();
	                    }
	                })
	                .blur(function(){
	                    $(this).removeClass('focusInput');
	                    if($(this).val() == ''){
	                      $(this).val($(this).data('value'));
	                    }
	                });
	        }
	      
	    });

	/* ----------------------------------------------------
	---------- !! THEME CUSTOMIZER !! -----------------
	------------------------------------------------------- */
		
		if(!$body.hasClass('sidebar-show')) {

		    $('.f-opacity').change(function(){
		        themeObjects.folioOpacity = $(this).find('option:selected').val();
		        $('.folio-cube').css('opacity', themeObjects.folioOpacity);
		    });

		    $('.folio-cube .bottom').each(function(){
		        $(this).data('bg-color', $(this).attr('style').replace('background-color: ', ''));
		    })

		    $('.f-color').change(function(){
		        if($(this).prop('checked')) {
		            $('.folio-cube .bottom').each(function(){
		                $(this).css('backgroundColor', $(this).data('bg-color'));
		            });
		        } else {
		            $('.folio-cube .bottom').css('backgroundColor', '');
		        }
		    });

		    $('.f-3d').change(function(){

		        if($(this).prop('checked')){

		            $projectHolder.removeClass('no-3deffects')
		                .addClass('3deffects');

		            check3D();

		        } else {

		            $projectHolder.removeClass('3deffects')
		                .addClass('no-3deffects');

		            check3D();

		        }
		    });

		}

	    function check3D(){

	        $folioItems.off('mouseenter')
	            .off('mouseleave');

	        if($html.hasClass('no-csstransforms') || $projectHolder.hasClass('no-3deffects') || $html.hasClass('ie10')) {

	            // non 3D

	            $folioItems.on('mouseenter', function(){

	                var $this = $(this);
	                setTimeout(function(){
	                    $this.addClass('hovered');
	                }, 500);

	                if(!$(this).hasClass('isotope-hidden')) {
	                    $(this).find('.folio-cube').stop().animate({'opacity': 1}, 300, 'easeInOutQuad');
	                    $(this).find('.bottom').stop().animate({'opacity': .95}, 300, 'easeInOutQuad');
	                    $(this).find('img').stop().animate({
	                        'width': '130%',
	                        'height': '130%',
	                        'left': '-15%',
	                        'top': '-15%'
	                    }, 200, 'easeInOutQuad');
	                    $(this).find('.folio-caption').stop().animate({'paddingTop': 0}, 200, 'easeInOutQuad');
	                }
	                
	            }).on('mouseleave', function(){

	                $(this).removeClass('hovered');

	                $(this).find('.folio-cube').stop().animate({'opacity': themeObjects.folioOpacity}, 300, 'easeInOutQuad');
	                $(this).find('.bottom').stop().animate({'opacity': 0}, 300);
	                $(this).find('img').stop().animate({
	                    'width': '100%',
	                    'height': '100%',
	                    'left': '0',
	                    'top': '0'
	                }, 200, 'easeInOutQuad');
	                $(this).find('.folio-caption').stop().animate({'paddingTop': 50}, 200, 'easeInOutQuad');

	            });

	            $folioCubes.css(cssTransform, '');
	            $folioCubesFront.css(cssTransform, '');
	            $folioCubesBottom.css(cssTransform, '');
	            $folioItems.find('.bottom').css('opacity', 0);

	        } else {

	            // 3D

	            $folioItems.on('mouseenter', function(){

	                var $this = $(this);
	                setTimeout(function(){
	                    $this.addClass('hovered');
	                }, 500);

	                if(!$(this).hasClass('isotope-hidden')) {
	                    $(this).find('.folio-cube').stop().animate({
	                        'rotationX': 90,
	                        'z': Math.ceil(-$(this).height()/2),
	                        'opacity': 1
	                    }, 300, 'easeInOutQuad');
	                }
	            }).on('mouseleave', function(){

	                $(this).removeClass('hovered');

	                $(this).find('.folio-cube').stop().animate({
	                    'rotationX': 0,
	                    'z': Math.ceil(-$(this).height()/2),
	                    'opacity': themeObjects.folioOpacity
	                }, 300);
	            });

	            resizeThumbs();
	            $folioItems.find('.bottom').css('opacity', 1);

	        }

	    }

	    //////////////////

	    });

	})(jQuery);