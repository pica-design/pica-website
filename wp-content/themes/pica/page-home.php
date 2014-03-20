<?php 
	//Include our theme header.php 
	get_header() ;

    the_post();
    
    global $site_url, $template_directory;
	
	//Gather this posts gallery items
	//$gallery = new Post_Gallery($post->ID) ;
   //print_r($post);

	//Create a random number between 0 and the count of the attachments in our gallery so we can show a random attachment
	$random_number = rand(0, (count($post->attachments) - 1));
	
	//Generate our random attachment image path for display
	//Try to use the 'homepage' filesize if there is one of that size available
	if (isset($post->attachments[$random_number]->meta_data['_wp_attachment_metadata']['sizes']['homepage'])) :
		$image_path = "http://images." . $site_url . 'wp-content/uploads/' . $post->attachments[$random_number]->meta_data['_wp_attachment_metadata']['sizes']['homepage']['file'];
	else :
		$image_path = $post->attachments[$random_number]->guid;
	endif;
?>

            <section class="focal-point single">
                <div class="focal-point-item">
                    <a href="<?php bloginfo('url') ?>/work-categories/featured/" title="View Pica's Work">
                        <?php echo $post->attachments[$random_number]->post_content ?>
                        <img src="<?php echo $image_path ?>" alt="<?php echo $post->attachments[$random_number]->post_title ?>" class="focal-point-image" />
                    </a>
                </div>
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
                                            //Gather the blog post featured images
                                            $image_attributes = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'blogroll', false ); ?>
                                        <img src="<?php echo $image_attributes[0] ?>" alt="<?php echo $post->post_title ?>" /><?php else : ?>

                                        <img src="http://images.<?php $template_directory ?>/images/content/blog-post-image-placeholder.png" alt="<?php echo $post->post_title ?>" /><?php endif ?>

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
                        $brandnew = new WP_Query(array(
                            'post_type' => array('pica_work', 'pica_brandnew'),
                            'posts_per_page' => -1,
                            'orderby' => 'modified'
                        ));
                        //Grab the first post returned out of the set
                        $brandnew = $brandnew->posts[0];

                        //Determine the brandnew item ID 
                            //The process below displays the most recently updated item - like an agregator of pica_work and pica_brandnew
                            //If a work item was just added it will be displayed
                                //If a work item was just updated it will be displayed
                                //If a work item just received a new image - it will be displayed
                            //The same goes for brand new items
                        if ($brandnew->post_type == "pica_brandnew") : 
                            //Grab the featured image id for the brandnew item
                            //$brandnew_thumbnail_id = get_post_thumbnail_id($brandnew->ID);

                            //If a work item has been updated most recently we display the most recent attachment - NOT the featured image
                            $brandnew_post_attachments = Post_Attachments::fetch($brandnew->ID, 'modified', 'DESC');

                            //If the brandnew item has been edited show the brandnew item featured image
                            if (strtotime($brandnew->post_modified) > strtotime($brandnew_post_attachments->attachments[0]->post_modified)) : 
                                $brandnew_thumbnail_id = get_post_thumbnail_id($brandnew->ID);
                            else : 
                                //However, if the brandnew item simply has a new image let's show that image instead of the featured
                                $brandnew_thumbnail_id = $brandnew_post_attachments->attachments[0]->ID;
                            endif;

                            //lastly, grab the url that the brandnew item will link too - in this case to the brandnew page with a hash to scroll to the correct location
                            $brandnew_page_id = 30; 
                            $brandnew_url = get_permalink($brandnew_page_id) . '#!' . $brandnew->post_name ;
                        else : 
                            //If a work item has been updated most recently we display the most recent attachment - NOT the featured image
                            $work_post_attachments = Post_Attachments::fetch($brandnew->ID, 'modified', 'DESC');

                            //If the work item has been edited show the work item featured image
                            if (strtotime($brandnew->post_modified) > strtotime($work_post_attachments->attachments[0]->post_modified)) : 
                                $brandnew_thumbnail_id = get_post_thumbnail_id($brandnew->ID);
                            else : 
                                //However, if the work item simply has a new image let's show that image instead of the featured
                                $brandnew_thumbnail_id = $work_post_attachments->attachments[0]->ID;
                            endif;

                            //lastly, grab the url that the brandnew item will link too - in this case to the recently updated work item
                            $brandnew_url = get_permalink($brandnew->ID);
                        endif;


                        //Try to grab the specific 359x266 size if it exists, if not just use the uploaded image and force the size with css
                        $brandnew_thumbnail_url = wp_get_attachment_image_src($brandnew_thumbnail_id, 'brandnew_callout');
                        if (!$brandnew_thumbnail_url) : 
                            $brandnew_thumbnail_url = wp_get_attachment_url($brandnew_thumbnail_id);
                        else :
                            $brandnew_thumbnail_url = $brandnew_thumbnail_url[0];
                        endif;

                        //If the image url is valid display the image
                        if ($brandnew_thumbnail_url != "") :
                    ?>
                        
                    <br />
                    <a href="<?php echo $brandnew_url ?>" title="<?php echo $brandnew->post_title ?>"><img src="<?php echo $brandnew_thumbnail_url ?>" alt="<?php echo $brandnew->post_title ?>" /></a><?php endif ?>
                        
                </div><!-- end .call-out-section --><?php
                    $twitter = new Twitter;
                    $twitter->perform_search("from:PicaDesign OR @picadesign OR @PicaDesign", 6);
                    
                    //We only want to show the social block if there are tweets to show
                    if (!empty($twitter->search->statuses)) : 
                ?>
                        
                <div id="resocial" class="call-out-section">
                    <div class="resocial-title"><h5 class="text-color-black intro">re:</h5><h5 class="text-color-lightgray">social</h5></div>
                    <div class="clear"></div>
                    <div class="twitter-tweets"><?php foreach ($twitter->search->statuses as $tweet) : //print_r($tweet) ?>
                    
                        <div class="tweet">
                            <img class="tweet-profile-image" src="<?php echo $tweet->user->profile_image_url ?>" alt="<?php echo $tweet->user->screen_name ?>" />
                            <div class="tweet-text">
                                <a href="http://www.twitter.com/<?php echo $tweet->user->screen_name ?>" class="tweet-by" target="_blank"><?php echo $tweet->user->screen_name ?></a> 
                                <em><?php echo $tweet->user->screen_name ?></em><?php
                                    //If there is a twitpic with this tweet, display a link and icon to it
                                    if (isset($tweet->entities)) :
                                        if (isset($tweet->entities->media)) :
                                            if (is_array($tweet->entities->media)) :
                                                //There is an uploaded image with this tweet
                                                ?>
                                                    <figure class="twitpic"><a href="http://<?php echo $tweet->entities->media[0]->display_url ?>" target="_blank"></a></figure>
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
                                ?><br />
                                <?php 
                                    //Output the tweet contents
                                    echo $tweet->text . "<br />";
                                    
                                    //Output the tweet date
                                    $tweet_created_at = new DateTime($tweet->created_at);
                                    $tweet_created_at->setTimezone(new DateTimeZone('America/New_York'));
                                    echo "<em>" . $tweet_created_at->format('d M') . "</em>";
                                ?>
                                
                            </div>
                        </div><?php endforeach ?>
                        
                    </div><!--end .twitter-tweets -->
                </div><!--end .social--><?php endif // end check for tweets ?>

            </section><!--end .sub-content-wrapper -->  
            <div class="page-horizontal-divider"><div class="inner-page-horizontal-divider"></div></div>
            
            <!--
            <section class="sub-content-wrapper homepage">
                
            </section>--><!--end .sub-content-wrapper -->  
            <div class="clear"></div>
<?php get_footer() ?>