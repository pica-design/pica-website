		
        </section><!--End site wrapper--> 
        <script type="text/javascript"> 
			//Run our jQuery scripts
			(function($){
				//Attach a click event handler to the .nav-trigger element
				$('.nav-trigger').click(function(){
					//Once clicked, determine if the element has the class inactive or active
					if ($(this).hasClass('inactive')) {
						//If the current element is inactive, let's slide our menu down so it's visible
						$('#menu-primary-navigation').slideDown('slow')
						//We also wanted to remove the inactive class and replace it with the active class (this changes the down arrow into an up arrow)
						$(this).removeClass('inactive').addClass('active')
					} else {
						//The element is not inactive, so it must be active
						$('#menu-primary-navigation').slideUp('slow')
						$(this).removeClass('active').addClass('inactive')
					}
				})
			})(jQuery)
		 </script>
	</body>
</html>