<?php 
	//Include our theme header.php 
	get_header() ;
?>
        
	        <div class="page-title">
                <h1><?php echo $post->post_title ?></h1>
            </div>
            <div class="focal-point">
                <div class="focal-point-item">
                    <img src="<?php bloginfo('template_directory') ?>/images/back-to-the-pica.jpg" alt="Old Tyme Photo of the Belfast Opera House" />
                </div>
                <div class="focal-point-item">
                	<a href="http://maps.google.com/maps?f=q&source=s_q&hl=en&geocode=&q=111+Church+St+Belfast+Maine+04915&ie=UTF8&hq=&hnear=111+Church+St+Belfast+Maine+04915&t=h&z=16" title="View full Map" target="_blank">
                        <img src="http://maps.google.com/maps/api/staticmap?center=111+Church+St+Belfast+Maine+04915&size=573x415&&sensor=false&markers=color:blue%7C111+Church+St+Belfast+Maine+04915&zoom=10" alt="Google Map showing Delaware Veterans Memorial Cemetery Bear" class="google-map" width="573" height="415" />
                    </a>
                </div>
           </div>   
           <div class="call-to-action">
				<div class="call-to-action-column" style="margin-right:50px;">
                	<p>
                    	<strong>address: </strong><br />
                        P.O. Box 225 <br />
                        111 Church Street <br />
                        Belfast, ME 04915-0225
					</p>
                </div>	
                
                <div class="call-to-action-column" style="margin-right:50px;">
                	<p>
                    	<strong>directions: </strong><br />
						get directions to our office be clicking on the map above. We are located directly across from the sheriffs office on Church street, in the 3 floor of the opera house.
                   	</p>
                </div>
                
                <div class="call-to-action-column">
                	<p>
                    	<strong>phone:</strong> 207. 338.1740 <br />
                        <strong>fax:</strong> 207.338.0899 <br />
                        <strong>email:</strong> info@picadesign.com
                    </p>
                </div>
           </div>     
<?php 
	//Include our theme footer.php
	get_footer() 
?>