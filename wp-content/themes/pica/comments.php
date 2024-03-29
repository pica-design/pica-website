<div id="comments">
    <?php if ( have_comments() ) : ?>
    <br /><br />
    <h3 id="comments-title"><?php
    printf( _n( 'One Response to %2$s', '%1$s Responses to %2$s', get_comments_number(), 'twentyten' ),
    number_format_i18n( get_comments_number() ), '<em>' . get_the_title() . '</em>' );
    ?></h3>
	<br />
    <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
        <div class="navigation">
            <div class="nav-previous"><?php previous_comments_link( __( '<span class="meta-nav">&larr;</span> Older Comments', 'twentyten' ) ); ?></div>
            <div class="nav-next"><?php next_comments_link( __( 'Newer Comments <span class="meta-nav">&rarr;</span>', 'twentyten' ) ); ?></div>
        </div> <!-- .navigation -->
    <?php endif; // check for comment navigation ?>

    <ol class="commentlist">
        <?php
            /* Loop through and list the comments. Tell wp_list_comments()
             * to use twentyten_comment() to format the comments.
             * If you want to overload this in a child theme then you can
             * define twentyten_comment() and that will be used instead.
             * See twentyten_comment() in twentyten/functions.php for more.
             */
            wp_list_comments( array( 'callback' => 'pica_comment' ) );
        ?>
    </ol>

    <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
    <div class="navigation">
        <div class="nav-previous"><?php previous_comments_link( __( '<span class="meta-nav">&larr;</span> Older Comments', 'twentyten' ) ); ?></div>
        <div class="nav-next"><?php next_comments_link( __( 'Newer Comments <span class="meta-nav">&rarr;</span>', 'twentyten' ) ); ?></div>
    </div><!-- .navigation -->
    <?php endif; // check for comment navigation ?>

    <?php else : if ( ! comments_open() ) : ?>
        <p class="nocomments"><?php _e( 'Comments are closed.', 'twentyten' ); ?></p>
    <?php endif; // end ! comments_open() ?>
    
    <?php endif; // end have_comments() ?>
    
    <?php comment_form(); ?>
</div><!-- #comments -->