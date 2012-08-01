/* HOVERINTENT */
(function(a){a.fn.hoverIntent=function(l,j){var m={sensitivity:7,interval:100,timeout:0};m=a.extend(m,j?{over:l,out:j}:l);var o,n,h,d;var e=function(f){o=f.pageX;n=f.pageY};var c=function(g,f){f.hoverIntent_t=clearTimeout(f.hoverIntent_t);if((Math.abs(h-o)+Math.abs(d-n))<m.sensitivity){a(f).unbind("mousemove",e);f.hoverIntent_s=1;return m.over.apply(f,[g])}else{h=o;d=n;f.hoverIntent_t=setTimeout(function(){c(g,f)},m.interval)}};var i=function(g,f){f.hoverIntent_t=clearTimeout(f.hoverIntent_t);f.hoverIntent_s=0;return m.out.apply(f,[g])};var b=function(q){var f=this;var g=(q.type=="mouseover"?q.fromElement:q.toElement)||q.relatedTarget;while(g&&g!=this){try{g=g.parentNode}catch(q){g=this}}if(g==this){if(a.browser.mozilla){if(q.type=="mouseout"){f.mtout=setTimeout(function(){k(q,f)},30)}else{if(f.mtout){f.mtout=clearTimeout(f.mtout)}}}return}else{if(f.mtout){f.mtout=clearTimeout(f.mtout)}k(q,f)}};var k=function(p,f){var g=jQuery.extend({},p);if(f.hoverIntent_t){f.hoverIntent_t=clearTimeout(f.hoverIntent_t)}if(p.type=="mouseover"){h=g.pageX;d=g.pageY;a(f).bind("mousemove",e);if(f.hoverIntent_s!=1){f.hoverIntent_t=setTimeout(function(){c(g,f)},m.interval)}}else{a(f).unbind("mousemove",e);if(f.hoverIntent_s==1){f.hoverIntent_t=setTimeout(function(){i(g,f)},m.timeout)}}};return this.mouseover(b).mouseout(b)}})(jQuery);


/*global jQuery */
/*!	
* FitText.js 1.0
*
* Copyright 2011, Dave Rupert http://daverupert.com
* Released under the WTFPL license 
* http://sam.zoy.org/wtfpl/
*
* Date: Thu May 05 14:23:00 2011 -0600
*/
(function(a){a.fn.fitText=function(d,b){var c={minFontSize:Number.NEGATIVE_INFINITY,maxFontSize:Number.POSITIVE_INFINITY};return this.each(function(){var e=a(this);var g=d||1;if(b){a.extend(c,b)}var f=function(){e.css("font-size",Math.max(Math.min(e.width()/(g*10),parseFloat(c.maxFontSize)),parseFloat(c.minFontSize)))};f();a(window).resize(f)})}})(jQuery);


/*
	Slimbox v2.04 - The ultimate lightweight Lightbox clone for jQuery
	(c) 2007-2010 Christophe Beyls <http://www.digitalia.be>
	MIT-style license.
*/
(function(w){var E=w(window),u,f,F=-1,n,x,D,v,y,L,r,m=!window.XMLHttpRequest,s=[],l=document.documentElement,k={},t=new Image(),J=new Image(),H,a,g,p,I,d,G,c,A,K;w(function(){w("body").append(w([H=w('<div id="lbOverlay" />')[0],a=w('<div id="lbCenter" />')[0],G=w('<div id="lbBottomContainer" />')[0]]).css("display","none"));g=w('<div id="lbImage" />').appendTo(a).append(p=w('<div style="position: relative;" />').append([I=w('<a id="lbPrevLink" href="#" />').click(B)[0],d=w('<a id="lbNextLink" href="#" />').click(e)[0]])[0])[0];c=w('<div id="lbBottom" />').appendTo(G).append([w('<a id="lbCloseLink" href="#" />').add(H).click(C)[0],A=w('<div id="lbCaption" />')[0],K=w('<div id="lbNumber" />')[0],w('<div style="clear: both;" />')[0]])[0]});w.slimbox=function(O,N,M){u=w.extend({loop:false,overlayOpacity:0.8,overlayFadeDuration:400,resizeDuration:400,resizeEasing:"swing",initialWidth:250,initialHeight:250,imageFadeDuration:400,captionAnimationDuration:400,counterText:"Image {x} of {y}",closeKeys:[27,88,67],previousKeys:[37,80],nextKeys:[39,78]},M);if(typeof O=="string"){O=[[O,N]];N=0}y=E.scrollTop()+(E.height()/2);L=u.initialWidth;r=u.initialHeight;w(a).css({top:Math.max(0,y-(r/2)),width:L,height:r,marginLeft:-L/2}).show();v=m||(H.currentStyle&&(H.currentStyle.position!="fixed"));if(v){H.style.position="absolute"}w(H).css("opacity",u.overlayOpacity).fadeIn(u.overlayFadeDuration);z();j(1);f=O;u.loop=u.loop&&(f.length>1);return b(N)};w.fn.slimbox=function(M,P,O){P=P||function(Q){return[Q.href,Q.title]};O=O||function(){return true};var N=this;return N.unbind("click").click(function(){var S=this,U=0,T,Q=0,R;T=w.grep(N,function(W,V){return O.call(S,W,V)});for(R=T.length;Q<R;++Q){if(T[Q]==S){U=Q}T[Q]=P(T[Q],Q)}return w.slimbox(T,U,M)})};function z(){var N=E.scrollLeft(),M=E.width();w([a,G]).css("left",N+(M/2));if(v){w(H).css({left:N,top:E.scrollTop(),width:M,height:E.height()})}}function j(M){if(M){w("object").add(m?"select":"embed").each(function(O,P){s[O]=[P,P.style.visibility];P.style.visibility="hidden"})}else{w.each(s,function(O,P){P[0].style.visibility=P[1]});s=[]}var N=M?"bind":"unbind";E[N]("scroll resize",z);w(document)[N]("keydown",o)}function o(O){var N=O.keyCode,M=w.inArray;return(M(N,u.closeKeys)>=0)?C():(M(N,u.nextKeys)>=0)?e():(M(N,u.previousKeys)>=0)?B():false}function B(){return b(x)}function e(){return b(D)}function b(M){if(M>=0){F=M;n=f[F][0];x=(F||(u.loop?f.length:0))-1;D=((F+1)%f.length)||(u.loop?0:-1);q();a.className="lbLoading";k=new Image();k.onload=i;k.src=n}return false}function i(){a.className="";w(g).css({backgroundImage:"url("+n+")",visibility:"hidden",display:""});w(p).width(k.width);w([p,I,d]).height(k.height);w(A).html(f[F][1]||"");w(K).html((((f.length>1)&&u.counterText)||"").replace(/{x}/,F+1).replace(/{y}/,f.length));if(x>=0){t.src=f[x][0]}if(D>=0){J.src=f[D][0]}L=g.offsetWidth;r=g.offsetHeight;var M=Math.max(0,y-(r/2));if(a.offsetHeight!=r){w(a).animate({height:r,top:M},u.resizeDuration,u.resizeEasing)}if(a.offsetWidth!=L){w(a).animate({width:L,marginLeft:-L/2},u.resizeDuration,u.resizeEasing)}w(a).queue(function(){w(G).css({width:L,top:M+r,marginLeft:-L/2,visibility:"hidden",display:""});w(g).css({display:"none",visibility:"",opacity:""}).fadeIn(u.imageFadeDuration,h)})}function h(){if(x>=0){w(I).show()}if(D>=0){w(d).show()}w(c).css("marginTop",-c.offsetHeight).animate({marginTop:0},u.captionAnimationDuration);G.style.visibility=""}function q(){k.onload=null;k.src=t.src=J.src=n;w([a,g,c]).stop(true);w([I,d,g,G]).hide()}function C(){if(F>=0){q();F=x=D=-1;w(a).hide();w(H).stop().fadeOut(u.overlayFadeDuration,j)}return false}})(jQuery);

// AUTOLOAD CODE BLOCK (MAY BE CHANGED OR REMOVED)
if (!/android|iphone|ipod|series60|symbian|windows ce|blackberry/i.test(navigator.userAgent)) {
	jQuery(function($) {
		$("a[rel^='lightbox']").slimbox({/* Put custom options here */}, null, function(el) {
			return (this == el) || ((this.rel.length > 8) && (this.rel == el.rel));
		});
	});
}


//Run our jQuery scripts once the web page has loaded
(function($){
	
	//Scroll to an element
	$.fn.scrollHere = function (adjustment) {
		var offset = $(this).offset().top;
		$('html, body').animate({scrollTop:offset + adjustment}, 500);
	}
	
	/**************************************************
		HEADER SCRIPTS
	**************************************************/
	
	//Determine if the website is being viewed with an iOS device (we need to do some things a little differently in this case)
	var ua = navigator.userAgent,
    event = (ua.match(/iPad/i)) ? "touchstart" : "click";
	
	//This will not be needed once the mobile website is catching these devices
	if (event == "click") { event = (ua.match(/iPhone/i)) ? "touchstart" : "click"; }
	
	if (event == "click") {
		//Attach a click event handler to the .nav-trigger element
		$('#site-controller').hoverIntent(function(e) {
			//e.preventDefault()
			//Once clicked, determine if the element has the class inactive or active
			//if ($(this).find('.site-controller-trigger').hasClass('inactive')) {
				//If the current element is inactive, let's slide our menu down so it's visible
				$('nav').slideDown('slow').css('display', 'block')
				//We also wanted to remove the inactive class and replace it with the active class (this changes the down arrow into an up arrow)
				$(this).find('.site-controller-trigger').removeClass('inactive').addClass('active')
				//Update the element title attribute to reflect the change
				$(this).find('.site-controller-trigger').attr('title', 'Close Page Menu')
				//If an iOS device is viewing the website we need to display the site slogan upon opening the control panel
				//if (event == "touchstart") { $('.site-slogan').fadeIn(500) }
				
		}, function() {
			//The element is not inactive, so it must be active - go ahead and scroll the nav back up so it's hidden
				$('nav').slideUp('normal')
				//..and we want to remove the active class and set it back to inactive
				$(this).find('.site-controller-trigger').removeClass('active').addClass('inactive')
				//Update the element title attribute to reflect the change
				$(this).find('.site-controller-trigger').attr('title', 'Open Page Menu')
				//If an iOS device is viewing the website we need to display the site slogan upon closing the control panel
				//if (event == "touchstart") { $('.site-slogan').fadeOut(700) }
		})//end click event
	}

		//Attach a click event handler to the .nav-trigger element
	$('.site-controller-trigger').click(function(e) {
		e.preventDefault()
		//Once clicked, determine if the element has the class inactive or active
		if ($(this).hasClass('inactive')) {
			//If the current element is inactive, let's slide our menu down so it's visible
			$('nav').slideDown('slow').css('display', 'block')
			//We also wanted to remove the inactive class and replace it with the active class (this changes the down arrow into an up arrow)
			$(this).removeClass('inactive').addClass('active')
			//Update the element title attribute to reflect the change
			$(this).attr('title', 'Close Page Menu')
			//If an iOS device is viewing the website we need to display the site slogan upon opening the control panel
			if (event == "touchstart") { $('.site-slogan').fadeIn(500) }
		} else {
			//The element is not inactive, so it must be active - go ahead and scroll the nav back up so it's hidden
			$('nav').slideUp('normal')
			//..and we want to remove the active class and set it back to inactive
			$(this).removeClass('active').addClass('inactive')
			//Update the element title attribute to reflect the change
			$(this).attr('title', 'Open Page Menu')
			//If an iOS device is viewing the website we need to display the site slogan upon closing the control panel
			if (event == "touchstart") { $('.site-slogan').fadeOut(700) }
		}		
	})//end click event


	//We don't want to use any hovers on the page if it's being viewed with a iOS device
	/*
	if (event != "touchstart") {
		$('#site-controller').hoverIntent(function(){
			$('.site-slogan').fadeIn(500)
		}, function() {
			$('.site-slogan').fadeOut(700)
		})
	}
	*/
	
	//Make sure we slideup the site controller pane when clicking the nav links
	$('nav ul li a, .pica-mark').click(function(e){
		$('nav').slideUp('normal')
	})
	
	/**************************************************
		FOOTER SCRIPTS
	**************************************************/
	
	//Our footer grows horizontally when hovered on screen, and when clicked on with iOS
	if (event != 'touchstart') {
		$('footer').hoverIntent(function(){
			//Over	
			$('footer .footer-copy').animate({
				width: 620
			}, 1500, 'swing', function() {
				//slide complete
				$('footer').removeClass().addClass('active')
			})
		}, function() {
			//and Out
			$('footer .footer-copy').animate({
				width: 0
			}, 900, 'swing', function() {
				//slide complete
				$('footer').removeClass()
			})
		})
	} else {
		$('footer').bind(event, function(){
			if (!$(this).hasClass('active')) {
				//Over	
				$('footer .footer-copy').animate({
					width: 620
				}, 1500, 'swing', function() {
					//slide complete
					$('footer').removeClass().addClass('active')
				})
			} else {
				$('footer .footer-copy').animate({
					width: 0
				}, 900, 'swing', function() {
					//slide complete
					$('footer').removeClass()
				})
			}
		})
	}
	
	
	
	//Bind an event listener to the window scroll event (when a user scrolls on the website)
	$(window).scroll(function () {
		if ($(this).scrollTop() > 500) {
			//Enable our 'Back to Top' button if the user has scrolled down 500+ pixels
			$('.back-to-top').fadeIn(400)
		} else {
			//And hide the button if the user has scrolled up to within 500 pixels from the top
			$('.back-to-top').fadeOut(400)
		}
	});

	//Scroll back to the top of the page
	$('.back-to-top').click(function(){
		//Scroll back to the top over 800 milliseconds 
		$('html, body').animate({scrollTop: 0 }, 800);
	})
	
	
	/**************************************************
		HOME PAGE SCRIPTS
	**************************************************/
	
	//Initiate our font scaling script 'fitText' for dynamically sizing certain typography elements
	$(".scalable-text h1").fitText(1.55, { minFontSize: '10px', maxFontSize: '90px' })
	
	////////Displaying blog posts on the main page
	//Attach a click event handler to the .nav-trigger element
	$('.blog-roll-toggle').click(function(event){
		event.preventDefault()
		//Once clicked, determine if the element has the class inactive or active
		if ($(this).hasClass('inactive')) {
			//If the current element is inactive, let's slide our text down so it's visible
			$(this).parent().parent().parent().find('.blog-roll-text').slideDown('slow')
			//We also wanted to remove the inactive class and replace it with the active class (this changes the down arrow into an up arrow)
			$(this).removeClass('inactive').addClass('active')
			//Update the element text attribute to reflect the change
			$(this).find('.text').text('get this outta my face!')
			//Scroll the window to frame the opened story			
			if ($(this).hasClass('post-0')) {
				$('#renews').scrollHere(-15)
			} else {
				$('.' + $(this).attr('id')).scrollHere(-15)
			}
		} else {
			//The element is not inactive, so it must be active - go ahead and scroll the text back up so it's hidden
			$(this).parent().parent().parent().find('.blog-roll-text').slideUp('slow')
			//and we want to remove the active class and set it back to inactive
			$(this).removeClass('active').addClass('inactive')
			//Update the element text attribute to reflect the change
			$(this).find('.text').text('tell me more')
		}
	})//end click event
	
	//Fade the homepage in on load
	$('.focal-point, .sub-content-wrapper.homepage').animate({
		opacity: 1
	}, 800, 'swing', function() {
	})
	
	/**************************************************
		TAXONOMY 'TYPE' PAGE SCRIPTS
	**************************************************/
	
	//Add a toggle trigger on hover 
	$('.gallery-item.in-grid').hoverIntent(function(){
		//Over
		$(this).find('img.work-item-image').fadeOut(300) 
	}, function() {
		//Out
		$(this).find('img.work-item-image').fadeIn(600) 
	})

	//We need to set the category inner wrapper container to the width of it's anchor child
	$('.work-category-inner-wrapper').each(function(i){
		$(this).width($(this).find('a').width() + 50)
	})

	if (event == 'touchstart') {
		//Work Category link display
		$('.work-category-wrapper').not('.active').click(function(){
			//Over	
			if (!$(this).hasClass('open')) {			  
				$(this).animate({
					width: $(this).find('a').width() + 37,
				}, 500, 'swing', function() {$(this).addClass('open')})
			} else {
				//Out
				$(this).animate({
					width: 25
				}, 500, 'swing', function() {})
				$(this).removeClass('open')
			}
		})
	} else {
		//Work Category link display
		$('.work-category-wrapper').not('.active').hoverIntent(function(){							
			//Over	
			$(this).animate({
				width: $(this).find('a').width() + 37,
			}, 500, 'swing', function() {})
		}, function () {
			//Out
			$(this).animate({
				width: 25
			}, 500, 'swing', function() {})
		})
	}
	
	//Fade in the grid images as they are loaded
	$('.gallery-item.in-grid img').each(function(i){
		var oThis = $(this)
		var img = new Image()
		$(img).load(function(){
			oThis.delay(800).fadeIn(400)
		}).attr('src', oThis.attr('src'))
	})
	
	/**************************************************
		SINGLE WORK PAGE SCRIPTS
	**************************************************/
	
	if (post_type == "pica_work") {
		//This applies to both the taxonomy overview page and the single post type page
		$('.page-title h1').scrollHere(-50)
		if (single) {
			
			function SetHeightToTallestChild(i) {
				//Grab the height of the first gallery item with an image child (the height should be correct)
				imageParent = $(i).find('figure.gallery-item:first')
				
				//console.log(imageParent.height())
				
				//Cycle sets the display inline to block, so we can't get the .height() without setting display back to block
				
				
				
				imageParent.css({ display: "block" })
				
				imageHeight = imageParent.find('img').height()
				
				//console.log(imageParent)
				//console.log(imageParent.height())
				
				//Apply the height to the text slide (so it's the same height at the image slides) 
				$(i).height(imageHeight)
					.children('.gallery-item.large').height(imageHeight)
					.children('.gallery-item.large.text-slide div').height(imageHeight - 100)	
			}
			
			//Ensure we reset the slide heights after the page has completely loaded
			$(window).load(function() { SetHeightToTallestChild('.gallery') });
			
			//Bind the same slide resize function to the window resize event - to create a liquid slideshow
			$(window).resize(function() { SetHeightToTallestChild('.gallery') });
			
			
			
			//Initiate our font scaling script 'fitText' for dynamically sizing certain typography elements
			$(".gallery-item.large.text-slide").fitText(2.3, { minFontSize: '30px', maxFontSize: '48px' })
			
			
			if ($('.gallery').children().length > 0) {
				//Fade in the slideshow controls once the page has loaded the slide images 
				$('.gallery-item').not('.text-slide').each(function(i){
					var oThis = $(this)
					var img = new Image()
					$(img).load(function(){
						//Display the slideshow navigation
						$('.gallery-prev, .gallery-next').delay(500).fadeIn(500) 
					}).attr('src', oThis.find('img').attr('src'))
				})
				
				//Use the jQuery Cycle Library to power our slideshow on the work page
				$('.gallery').cycle({
					fx: 			'scrollHorz', 
					speed:  		'medium', 
					prev:   		'.gallery-prev', 
					next:   		'.gallery-next', 
					slideResize: 	0,
					timeout: 		0,
					before: function (currSlideElement, nextSlideElement, options, forwardFlag) {
						//We need to remove the width that cycle adds to each slide in order to have a liquid gallery
						$('.gallery').children().each(function(i){ $(this).css({'width': ''}) })
					}
				})
				
			}
			
			//Display our testmonial when clicking the testimonial trigger icon
			$('#work-testimonial-trigger a.link-fill-container').click(function(e){
				e.preventDefault()
				//Cache the testimonial container
				var testimonialCopy = $(this).parent().parent().find('#work-testimonial-copy')
				//Make a toggle system for clickng on and off
				if (!testimonialCopy.hasClass('active')) {
					//show the copy
					testimonialCopy.fadeIn(400).addClass('active')
					//Update the trigger 
					$(this).html('-')
					$(this).parent().addClass('active')
				} else {
					//When clicking the trigger a second time let's close the testimonials
					testimonialCopy.fadeOut(600).removeClass('active')
					//Update the trigger
					$(this).parent().removeClass('active')
					$('#work-testimonial-trigger a.link-fill-container').html('+')
				}
			})
			
			//Create a sudo-blur function by binding a click event to the dom
			$(document).bind('click', function(e) {
				//Only blur the testimonial if we're not clicking on the testimonial or the trigger
				if (!$(e.target).is('.active, #work-testimonial-trigger a.link-fill-container')){
					$('#work-testimonial-copy').fadeOut(600).removeClass('active')
					$('#work-testimonial-trigger a.link-fill-container').html('+').parent().removeClass('active')
				}
			})
			
		}//END if single
	}//END if post_type == work
	
	
	if (post_type == "pica_brandnew") {
		//The url hash is set in the link on the homepage, by adding ! after the hash we can stop it and run our own smooth scroll to
		if ($('a[name="' + window.location.hash + '"]').length == 1) {
			$('a[name="' + window.location.hash + '"]').scrollHere(-40)
		} else {
			$('.page-title h1').scrollHere(-50)
		}
	}
})(jQuery)