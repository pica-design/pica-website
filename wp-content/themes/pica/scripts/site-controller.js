//Run our jQuery scripts once the web page has loaded
(function($){
	
	/**************************************************
		HEADER SCRIPTS
	**************************************************/
	
	//Attach a click event handler to the .nav-trigger element
	$('.site-controller-trigger').click(function(e){
		e.preventDefault()
		//Once clicked, determine if the element has the class inactive or active
		if ($(this).hasClass('inactive')) {
			//If the current element is inactive, let's slide our menu down so it's visible
			//$('nav').slideDown('slow')
			$('nav').slideDown('slow')
			//We also wanted to remove the inactive class and replace it with the active class (this changes the down arrow into an up arrow)
			$(this).removeClass('inactive').addClass('active')
			//Update the element title attribute to reflect the change
			$(this).attr('title', 'Close Page Menus')
			$('.picamarketing').fadeIn(300)
		} else {
			//The element is not inactive, so it must be active - go ahead and scroll the nav back up so it's hidden
			$('nav').slideUp('slow')
			//..and we want to remove the active class and set it back to inactive
			$(this).removeClass('active').addClass('inactive')
			//Update the element title attribute to reflect the change
			$(this).attr('title', 'Display Page Menus')
			$('.picamarketing').fadeOut(300)
		}		
	})//end click event

	//Make sure we slideup the site controller pane when clicking the nav links
	$('nav ul li a, .pica-mark').click(function(e){
		$('nav').slideUp('medium')
	})
	
	/**************************************************
		HOME PAGE SCRIPTS
	**************************************************/
	
	//Initiate our font scaling script 'fitText' for dynamically sizing certain typography elements
	$(".scalable-text h1").fitText(1.55, { minFontSize: '10px', maxFontSize: '90px' })
	
	////////Displaying blog posts on the main page
	//Attach a click event handler to the .nav-trigger element
	$('.blog-roll-toggle').click(function(e){
		e.preventDefault()
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
				$('a[name=renews]').scrollHere()
			} else {
				$('a[name=' + $(this).attr('id') + ']').scrollHere()
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
	
	//Scroll to an element
	$.fn.scrollHere = function () {
		var offset = $(this).offset().top;
	    $('html, body').animate({scrollTop:offset}, 500);
	}
	
	//Load our twitter feed
	$(".tweet").tweet({
		query: 'from:PicaDesign OR @picadesign',
		join_text: "<br />",
		avatar_size: 50,
		count: 4,
		auto_join_text_default: "we said,", 
		auto_join_text_ed: "we",
		auto_join_text_ing: "we were",
		auto_join_text_reply: "we replied to",
		auto_join_text_url: "we were checking out",
		loading_text: "loading tweets...",
		retweets: true,
		template: "{avatar}{user}{join}{text}{join}{join}{time}"
	}).bind("loaded",function(){
		$(this).find("a").attr("target","_blank")
	})
	
	/**************************************************
		TAXONOMY 'TYPE' PAGE SCRIPTS
	**************************************************/
	
	//Add a toggle trigger on hover 
	$('.gallery-item.in-grid').hover(function(){
		//Over
		$(this).find('img').fadeOut(300) 
	}, function() {
		//Out
		$(this).find('img').fadeIn(600) 
	})
	
	$('#work-type-filter-options').change(function(){
		window.location.href = $(this).val()
	})
	
	/**************************************************
		SINGLE WORK PAGE SCRIPTS
	**************************************************/
	
	if (post_type == "work") {
		if (single) {
			function SetHeightToTallestChild(i) {
				imageHeight = $(i).find('.gallery-item img')[0].height
				$(i).height(imageHeight)
					.children('.gallery-item.large').height(imageHeight)
					.children('.gallery-item.large.text-slide div').height(imageHeight)	
			}
			SetHeightToTallestChild('.gallery')
			$(window).resize(function() { SetHeightToTallestChild('.gallery') });
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
		}//END if single
	}//END if post_type == work
})(jQuery)