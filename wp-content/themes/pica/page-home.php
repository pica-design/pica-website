<?php 
	//Include our theme header.php 
	get_header() ;
	
	//Gather this posts gallery items
	$gallery = new Post_Gallery($post->ID) ;

	//Create a random number between 0 and the count of the attachments in our gallery
	$random_number = rand(0, (count($gallery->attachments) - 1));

	//Check MIME types of attachments and output accordingly
		//Image - display with the html <img> tag
			//Patterns? 
		//Video - HTML5? YouTube? <embed> flv?
	
	//Generate our random attachment image path for display
	//Try to use the 'homepage' filesize if there is one of that size available
	if (isset($gallery->attachments[$random_number]->meta_data['_wp_attachment_metadata']['sizes']['homepage'])) :
		$image_path = get_bloginfo('url') . '/wp-content/uploads/' . $gallery->attachments[$random_number]->meta_data['_wp_attachment_metadata']['sizes']['homepage']['file'];
	else :
		$image_path = $gallery->attachments[$random_number]->guid;
	endif;
?>

            <section class="focal-point single">
                <div class="focal-point-item"><a href="<?php bloginfo('url') ?>/work-categories/featured/" title="View Pica's Work"><?php echo $gallery->attachments[$random_number]->post_content ?><img src="<?php echo $image_path ?>" alt="<?php echo $gallery->attachments[$random_number]->post_title ?>" class="focal-point-image" /></a></div>
            </section>
            <br /><br />
            <section class="sub-content-wrapper homepage">
                <div id="renews" class="call-out-section">
                    <div class="renews-title"><h5 class="text-color-black intro">re:</h5><h5 class="text-color-lightgray"><a href="<?php bloginfo('url') ?>/blog" title="View Pica Design blog posts">news</a></h5></div>
                    <br />
                    <div id="blog-feed"><?php					
                            global $post;
                            $args = array( 'numberposts' => 2, 'offset'=> 0, 'category' => 0 );
                            $myposts = get_posts( $args );
                            foreach( $myposts as $key => $post ) : setup_postdata($post) ?>
                                 
                         <div class="blog-roll-container post-toggle-<?php echo $post->ID ?>">
                            <div class="blog-roll-preview">
                                <div class="blog-roll-thumbnail">
                                    <a href="<?php the_permalink() ?>" title="<?php the_title() ?>"><?php 
                                            if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())) : 
                                                the_post_thumbnail('blogroll');
                                            else :
                                        ?><img src="<?php bloginfo('template_directory') ?>/images/content/blog-post-image-placeholder.png" alt="<?php echo $post->post_title ?>" /><?php endif ?>
                                    </a>
                                </div><!--end blogrollthumbnail-->
                                <div class="blog-roll-excerpt">
                                    <h1>
                                    	<a href="<?php the_permalink() ?>" title="<?php the_title() ?>">
											<?php 
												echo substr(get_the_title($post->ID), 0, 23) ;
												if (strlen(get_the_title($post->ID)) > 23) :
													echo "...";
												endif;
											?>
                                        </a>
                                    </h1>
                                    <p>
									<?php 
										echo substr(get_the_excerpt(), 0, 60) ;
										if (strlen(get_the_excerpt()) > 60) :
											echo "...";
										endif; 
									?>
                                    </p>
                                    <br />
                                    <div class="blog-roll-toggle inactive post-<?php echo $key ?>" id="post-toggle-<?php echo $post->ID ?>">
                                        <div class="arrow"><div></div></div>
                                        <div class="text">tell me more</div>
                                    </div>
                                </div><!--end blogrollexcerpt-->
                            </div><!--end blogrollpreview-->   
                            <div class="blog-roll-text">
                                <br />
                                <?php the_excerpt('<p>', '</p>') ?> <a href="<?php the_permalink() ?>" title="<?php the_title() ?>">View the full article</a>
                            </div><!--end blogrolltext-->
                         </div><!--end blogrollcontainer--><?php endforeach; wp_reset_postdata(); ?>
                         
                    </div><!-- end #blog-feed -->
                </div><!--end renews-->
                <div id="brandnew-callout" class="call-out-section">
                    <div class="renews-title"><h5 class="text-color-black intro">re:</h5><h5 class="text-color-lightgray"><a href="<?php bloginfo('url') ?>/brand-new" title="View Brand New Pica Design Work">brand new</a></h5></div>
                    <br /><?php
                        $brandnew_page_id = 30;
                        $brandnew = new WP_Query('post_type=pica_brandnew&posts_per_page=1');
                        $brandnew = $brandnew->posts[0];
                        $brandnew_thumbnail_id = get_post_thumbnail_id($brandnew->ID);
                        $brandnew_thumbnail_url = wp_get_attachment_url($brandnew_thumbnail_id);
                        if ($brandnew_thumbnail_url != "") :
                    ?>
                        
                    <br />
                    <a href="<?php echo get_permalink($brandnew_page_id) ?>#!<?php echo $brandnew->post_name ?>" title="<?php echo $brandnew->post_title ?>"><img src="<?php echo $brandnew_thumbnail_url ?>" alt="BrandNew" /></a><?php endif ?>
                        
                </div><!-- end .call-out-section -->
            </section><!--end .sub-content-wrapper -->  
            <div class="page-horizontal-divider"><div class="inner-page-horizontal-divider"></div></div>
            <section class="sub-content-wrapper homepage"><?php
                    $twitter = new Twitter;
                    $twitter->perform_search("from:PicaDesign OR @picadesign OR @PicaDesign", 6);
					
                    //We only want to show the social block if there are tweets to show
                    if (!empty($twitter->search->results)) : 
                ?>
                        
                <div id="resocial">
                    <div class="resocial-title"><h5 class="text-color-black intro">re:</h5><h5 class="text-color-lightgray">social</h5></div>
                    <div class="clear"></div>
                    <div class="twitter-tweets"><?php foreach ($twitter->search->results as $tweet) : ?>
                    
                        <div class="tweet">
                            <img class="tweet-profile-image" src="<?php echo $tweet->profile_image_url ?>" alt="<?php echo $tweet->from_user_name ?>" />
                            <p class="tweet-text"><a href="http://www.twitter.com/<?php echo $tweet->from_user ?>" class="tweet-by" target="_blank"><?php echo $tweet->from_user ?></a> <em><?php echo $tweet->from_user_name ?></em><?php
                                    //If there is a twitpic with this tweet, display a link and icon to it
                                    if (isset($tweet->entities)) :
                                        if (isset($tweet->entities->media)) :
                                            if (is_array($tweet->entities->media)) :
                                                //There is an uploaded image with this tweet
                                                ?>
                                                    <a href="<?php echo $tweet->entities->media[0]->media_url ?>" target="_blank">
                                                        <figure class="twitpic"></figure>
                                                    </a>
                                                <?php
                                            endif;
                                        endif;
                                    endif;
                                    
                                    if (strpos($tweet->text, 'RT') !== false) :
                                        //This is a retweet
                                        ?>
                                            <figure class="retweet"></figure>
                                        <?php
                                    endif;
                                ?>
                                <br /><?php 
                                    //Output the tweet contents
                                    echo $tweet->text . "<br />";
                                    
                                    //Output the tweet date
                                    $tweet_created_at = new DateTime($tweet->created_at);
                                    $tweet_created_at->setTimezone(new DateTimeZone('America/New_York'));
                                    echo "<em>" . $tweet_created_at->format('d M') . "</em>";
                                ?>
                                
                            </p>
                        </div><?php endforeach ?>
                        
                    </div><!--end .twitter-tweets -->
                </div><!--end .social--><?php endif // end check for tweets ?>
                
            </section><!--end .sub-content-wrapper -->  
            <div class="clear"></div>
<?php get_footer() ?>