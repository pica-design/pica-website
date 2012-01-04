//Run our jQuery scripts
(function($){
	//Attach a click event handler to the .nav-trigger element
	$('.site-controller-trigger').click(function(e){
		e.preventDefault()
		//Once clicked, determine if the element has the class inactive or active
		if ($(this).hasClass('inactive')) {
			//If the current element is inactive, let's slide our menu down so it's visible
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
	
	//Use the jQuery Cycle Library to power our slideshow on the work page
	$('.gallery').cycle({
		fx: 'scrollHorz', // choose your transition type, ex: fade, scrollUp, shuffle, etc...
		speed:  'medium', 
		prev:   '.gallery-prev', 
		next:   '.gallery-next', 
		timeout: 0 
	})//end cycle
	
	
	//Scale text with an em font size, for tailoring font size to various screen / browser sizes
	var $body = $('.scalable-text'); //Cache this for performance

	var setBodyScale = function() {	
		var scaleSource = $body.width(),
			scaleFactor = 0.35,                     
			maxScale = 600,
			minScale = 30; //Tweak these values to taste
		var fontSize = scaleSource * scaleFactor; //Multiply the width of the body by the scaling factor:
		if (fontSize > maxScale) fontSize = maxScale;
		if (fontSize < minScale) fontSize = minScale; //Enforce the minimum and maximums
		$body.css('font-size', fontSize + '%');
	}

	$(window).resize(function(){
		//We dont want to go too small - to hold the design integrity
		if ($body.width() > 850) {
			setBodyScale();
		}
	});
	
	//Fire it when the page first loads:
	setBodyScale();
})(jQuery)	