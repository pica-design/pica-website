<?php
	/*
		Template for comments and pingbacks.
	*/
	function pica_comment( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
		switch ( $comment->comment_type ) :
			case '' : ?>
                <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
                    <div id="comment-<?php comment_ID(); ?>">
                        <div class="comment-author">
                            <div class="comment-author-left-column">
								<?php echo get_avatar( $comment, 48 ); ?>
                            </div>
    						<div class="comment-author-right-column">                        
	                            <strong><a href="<?php echo comment_author_url() ?>" target="_blank" title="Website of <?php echo get_comment_author() ?>"><?php echo get_comment_author() ?></a></strong>
                            </div>
                            <br />
							<?php echo get_comment_date() ?>
							<br />
							<?php echo get_comment_time() ?>
                            <a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">#</a>
                        </div><!-- .comment-author .vcard -->
                        
                        <?php if ( $comment->comment_approved == '0' ) : ?>
                            <em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'pica' ); ?></em>
                            <br />
                        <?php endif; ?>
                        
                        <div class="comment-body"><?php comment_text(); ?></div>
                
                    </div><!-- #comment-##  -->
                <!--</li>-->
		<?php
			break;
			case 'pingback'  :
			case 'trackback' :
		?>
            <li class="post pingback">
                <p><?php _e( 'Pingback:', 'pica' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( '(Edit)', 'pica' ), ' ' ); ?></p>
            <!--</li>-->
		
		<?php
			break;
		endswitch;
		
	}//End function pica_comment
?>