
            <footer>
            	&copy; 2012 Pica Design, LLC &#149; Careers &#149; RSS &#149; Downloads
            </footer>
        </section><!--End site wrapper--> 
        <!-- include jQuery library -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
        <!-- include Cycle plugin -->
        <script type="text/javascript" src="http://cloud.github.com/downloads/malsup/cycle/jquery.cycle.all.latest.js"></script>
		<script type="text/javascript"> 
			//Run our jQuery scripts
			(function($){
				//Attach a click event handler to the .nav-trigger element
				$('.site-controller-trigger').click(function(){
					//Once clicked, determine if the element has the class inactive or active
					if ($(this).hasClass('inactive')) {
						//If the current element is inactive, let's slide our menu down so it's visible
						$('nav').slideDown('slow')
						//We also wanted to remove the inactive class and replace it with the active class (this changes the down arrow into an up arrow)
						$(this).removeClass('inactive').addClass('active')
					} else {
						//The element is not inactive, so it must be active - go ahead and scroll the nav back up so it's hidden
						$('nav').slideUp('slow')
						//..and we want to remove the active class and set it back to inactive
						$(this).removeClass('active').addClass('inactive')
					}
				})//end click event
				
				//Use the jQuery Cycle Library to power our slideshow on the work page
				$('.workgallery').cycle({
					fx: 'scrollHorz', // choose your transition type, ex: fade, scrollUp, shuffle, etc...
					speed:  'fast', 
					prev:   '#prev', 
					next:   '#next', 
					timeout: 0 
				})//end cycle
			})(jQuery)
		 </script>
	</body>
</html>