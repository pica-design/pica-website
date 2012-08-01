<?php get_header(); ?>
            
            <div id="content-wrapper">
                <nav>
                    <ul><?php 
                        //Grab our nav menu items
                        $menu_items = wp_get_nav_menu_items('Primary Navigation');
                        foreach ($menu_items as $menu_item) :
                            if (is_page($menu_item->object_id) || ($post->post_type == 'pica_work' && $menu_item->title == "work")) :
                                $active = " class='active'";
                            else :
                                $active = "";
                            endif; ?>
    
                        <li<?php echo $active ?>><a href="<?php echo $menu_item->url ?>" title="<?php echo $menu_item->title ?>"><?php echo $menu_item->title ?></a></li><?php endforeach; ?>
                    
                    </ul>	
                </nav>            
            </div>
                      
<?php get_footer(); ?>