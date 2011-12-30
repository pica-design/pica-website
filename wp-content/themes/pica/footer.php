		
        </section><!--End site wrapper--> 
        <script type="text/javascript"> 
			/*
			$(document).ready(function() {							
				
				var showText="<img src='Screenshot.jpg'>";
				var hideText="<img src='Screenshot.jpg'>";
					$("#hide_this").before("<p><a href='#' id='toggle_link'>"+showText+"</a>");								
					$('#hide_this').hide();
					$('a#toggle_link').click(function(e) {
						
						e.preventDefault()
					
						if ($('a#toggle_link').html()==showText) {
							$('a#toggle_link').html(hideText);
							}
						else {
							$('a#toggle_link').html(showText);
							}
							$('#hide_this').toggle('slow');
					
					// return false so any link destination is not followed
					return false;
				});
			});
			*/
			
			(function($){
				$('.nav-trigger').click(function(){
					if ($(this).hasClass('inactive')) {
						$('#menu-primary-navigation').slideDown('slow')
						$(this).removeClass('inactive').addClass('active')
					} else {
						$('#menu-primary-navigation').slideUp('slow')
						$(this).removeClass('active').addClass('inactive')
					}
				})
			})(jQuery)
		 </script>
	</body>
</html>