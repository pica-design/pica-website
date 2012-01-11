//Run our jQuery scripts
(function($){
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
	
////////Chloe is playing here.
	//Attach a click event handler to the .nav-trigger element
	$('.blog-roll-excerpt a').click(function(e){
		e.preventDefault()
		//Once clicked, determine if the element has the class inactive or active
		if ($(this).hasClass('inactive')) {
			//If the current element is inactive, let's slide our text down so it's visible
			$(this).parent().parent().parent().find('.blog-roll-text').slideDown('slow')
			//We also wanted to remove the inactive class and replace it with the active class (this changes the down arrow into an up arrow)
			$(this).removeClass('inactive').addClass('active')
			//Update the element title attribute to reflect the change
			$(this).attr('title', 'Tell Me Less')
		} else {
			//The element is not inactive, so it must be active - go ahead and scroll the text back up so it's hidden
			$(this).parent().parent().parent().find('.blog-roll-text').slideUp('slow')
			//..and we want to remove the active class and set it back to inactive
			$(this).removeClass('active').addClass('inactive')
			//Update the element title attribute to reflect the change
			$(this).attr('title', 'Tell Me More')
		}		
	})//end click event
///////	Chloe is done playing now.

	
	//Make sure we slideup the site controller pane when clicking the nav links
	$('nav ul li a, .pica-mark').click(function(e){
		$('nav').slideUp('medium')
	})
	
	//Use the jQuery Cycle Library to power our slideshow on the work page
	$('.gallery').cycle({
		fx: 'scrollHorz', // choose your transition type, ex: fade, scrollUp, shuffle, etc...
		speed:  'medium', 
		prev:   '.gallery-prev', 
		next:   '.gallery-next', 
		timeout: 0 
	})//end cycle
	
	//Initiate our font scaling script 'fitText' for dynamically sizing certain typography elements
	$(".scalable-text h1").fitText(1.55, { minFontSize: '10px', maxFontSize: '90px' });
	
	//Add a toggle trigger to our work items
	$('.gallery-item.in-grid').hover(function(){
		//Over
		$(this).find('img').fadeOut(300) ;
	}, function() {
		//Out
		$(this).find('img').fadeIn(600) ;
	})
})(jQuery)	

	