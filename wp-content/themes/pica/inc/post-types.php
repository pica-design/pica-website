<?php
	/*********************************************************
	WORK CPT
	*********************************************************/
	register_post_type( 'pica_work',
		array(
			'labels' => array(
				'name' => __( 'Work' ),
				'singular_name' => __( 'Work Item' ),
				'add_new_item' => 'Add New Work Item',
				'edit_item' => 'Edit Work Items',
				'new_item' => 'New Work Item',
				'search_items' => 'Search Work Items',
				'not_found' => 'No Work Items found',
				'not_found_in_trash' => 'No Work Items found in trash',
		   ),
			'public' => true,
			'hierarchical' => true,
			'supports' => array('title','editor','thumbnail','gallery'),
			'rewrite' => array('slug' => 'work', 'with_front' => false)
		)	
	);
				
	//Create the 'Type' taxonomy for the 'Work' post type
	register_taxonomy('pica_work_type', 'pica_work',
		array(
			'hierarchical' => true,
			'label' => 'Work Categories',	// the human-readable taxonomy name
			'query_var' => true,	// enable taxonomy-specific querying
			'rewrite' => array( 'slug' => 'work-categories', 'with_front' => false),	// pretty permalinks for your taxonomy?
		)
	);
	
	//Create a new column 'Type' on the admin 'Work' page to display the types of each work item
	add_filter('manage_edit-pica_work_columns', 'manage_pica_work_admin_columns');
	//Populate the contents of the new columns we just created
	add_action('manage_pica_work_posts_custom_column', 'manage_pica_work_admin_columns_content');
	//Tell WordPress those new columns can be sortable within the admin
	add_filter('manage_edit-pica_work_sortable_columns', 'pica_work_type_column_register_sortable' );
	//Allow taxonomy sorting for the pica work cpt
	add_action( 'restrict_manage_posts', 'pica_work_cpt_taxonomy_filters' );
	
	//We want to tap in and add a column for the location ID and a column for the location region taxonomy term
	function manage_pica_work_admin_columns ($columns) {
		$new_columns['cb'] = '<input type="checkbox" />';
		$new_columns['title'] = _x('Work Name', 'column name');
		$new_columns['pica_work_short_name'] = __('Short Name');			
		$new_columns['pica_work_type'] = __('Type');
		$new_columns['author'] = __('Author');
		$new_columns['date'] = _x('Date', 'column name');
		return $new_columns;
	}//end function manage_pica_work_admin_columns
	
	// Register the new 'Location' columns as sortable
	function pica_work_type_column_register_sortable( $columns ) {
		$columns['pica_work_type'] = 'pica_work_type';
		$columns['pica_work_short_name'] = 'pica_work_short_name';
		return $columns;
	}//end function pica_work_type_column_register_sortable
	
	//Create the contents of our new 'Location' columns
	function manage_pica_work_admin_columns_content ($column) {
		global $post;
		switch ($column) :
			case 'pica_work_type':
				$terms = get_the_terms( $post->ID, 'pica_work_type');
				if ($terms) :
					$count = 0;
					foreach ($terms as $term) :
						echo '<a href="'.get_bloginfo('url').'/wp-admin/edit-tags.php?action=edit&taxonomy=pica_work_type&post_type=pica_work&tag_ID='.$term->term_id.'">'.$term->name.'</a>';
						if ($count != (count($terms) - 1)) :
							echo ", ";
						endif;
						$count++;
					endforeach;
				endif;
			break;
			case 'pica_work_short_name':
				echo get_post_meta($post->ID, '_work_short_name', true);
			break;
		endswitch;
	}//end function manage_pica_work_admin_columns_content
	
	function pica_work_cpt_taxonomy_filters() {
		global $typenow;
		// an array of all the taxonomyies you want to display. Use the taxonomy name or slug
		$taxonomies = array('pica_work_type');
		// must set this to the post type you want the filter(s) displayed on
		if($typenow == 'pica_work') :
			foreach ($taxonomies as $tax_slug) :
				$tax_obj = get_taxonomy($tax_slug);
				$tax_name = $tax_obj->labels->name;
				$terms = get_terms($tax_slug);
				if(count($terms) > 0) :
					echo "<select name='$tax_slug' id='$tax_slug' class='postform'>";
					echo "<option value=''>Show All $tax_name</option>";
					foreach ($terms as $term) :
						echo '<option value='. $term->slug, $_GET[$tax_slug] == $term->slug ? ' selected="selected"' : '','>' . $term->name .' (' . $term->count .')</option>'; 
					endforeach;
					echo "</select>";
				endif;
			endforeach;
		endif;
	}//end function pica_work_cpt_taxonomy_filters
	
	/*********************************************************
	BRANDNEW CPT
	*********************************************************/
	register_post_type( 'pica_brandnew',
		array(
			'labels' => array(
				'name' => __( 'Brand New' ),
				'singular_name' => __( 'Brand New Item' ),
				'add_new_item' => 'Add New Brand New Item',
				'edit_item' => 'Edit Brand New Items',
				'new_item' => 'New Brand New Item',
				'search_items' => 'Search Brand New Items',
				'not_found' => 'No Brand New Items found',
				'not_found_in_trash' => 'No Brand New Items found in trash',
		   ),
			'public' => true,
			'hierarchical' => true,
			'supports' => array('title','editor','thumbnail','gallery'),
			'rewrite' => array('slug' => 'brandnew', 'with_front' => false)
		)	
	);
				
	//Create the 'Type' taxonomy for the 'Work' post type
	register_taxonomy('pica_brandnew_type', 'pica_brandnew',
		array(
			'hierarchical' => true,
			'label' => 'Brand New Categories',	// the human-readable taxonomy name
			'query_var' => true,	// enable taxonomy-specific querying
			'rewrite' => array( 'slug' => 'brandnew-categories', 'with_front' => false),	// pretty permalinks for your taxonomy?
		)
	);
	
	//Create a new column 'Type' on the admin 'Work' page to display the types of each work item
	add_filter('manage_edit-pica_brandnew_columns', 'manage_pica_brandnew_admin_columns');
	//Populate the contents of the new columns we just created
	add_action('manage_pica_brandnew_posts_custom_column', 'manage_pica_brandnew_admin_columns_content');
	//Tell WordPress those new columns can be sortable within the admin
	add_filter('manage_edit-pica_brandnew_sortable_columns', 'pica_brandnew_type_column_register_sortable' );
	//Allow taxonomy sorting for the pica brandnew cpt
	add_action( 'restrict_manage_posts', 'pica_brandnew_cpt_taxonomy_filters' );
	
	//The following function is triggered when the admin views the list of 'Location' posts 
	//We want to tap in and add a column for the location ID and a column for the location region taxonomy term
	function manage_pica_brandnew_admin_columns ($columns) {
		$new_columns['cb'] = '<input type="checkbox" />';
		$new_columns['title'] = _x('Brandnew Work Name', 'column name');
		$new_columns['pica_brandnew_type'] = __('Type');
		$new_columns['author'] = __('Author');
		$new_columns['date'] = _x('Date', 'column name');
		return $new_columns;
	}//end function manage_pica_brandnew_admin_columns
	
	// Register the new 'Location' columns as sortable
	function pica_brandnew_type_column_register_sortable( $columns ) {
		$columns['pica_work_type'] = 'pica_work_type';
		return $columns;
	}//end function pica_brandnew_type_column_register_sortable
	
	//Create the contents of our new 'Location' columns
	function manage_pica_brandnew_admin_columns_content ($column) {
		global $post;
		switch ($column) :
			case 'pica_brandnew_type':
				$terms = get_the_terms( $post->ID, 'pica_brandnew_type');
				if ($terms) :
					$count = 0;
					foreach ($terms as $term) :
						echo '<a href="'.get_bloginfo('url').'/wp-admin/edit-tags.php?action=edit&taxonomy=pica_brandnew_type&post_type=pica_brandnew&tag_ID='.$term->term_id.'">'.$term->name.'</a>';
						if ($count != (count($terms) - 1)) :
							echo ", ";
						endif;
						$count++;
					endforeach;
				endif;
			break;
		endswitch;
	}//end function manage_pica_brandnew_admin_columns_content
	
	function pica_brandnew_cpt_taxonomy_filters() {
		global $typenow;
		// an array of all the taxonomyies you want to display. Use the taxonomy name or slug
		$taxonomies = array('pica_brandnew_type');
		// must set this to the post type you want the filter(s) displayed on
		if($typenow == 'pica_brandnew') :
			foreach ($taxonomies as $tax_slug) :
				$tax_obj = get_taxonomy($tax_slug);
				$tax_name = $tax_obj->labels->name;
				$terms = get_terms($tax_slug);
				if(count($terms) > 0) :
					echo "<select name='$tax_slug' id='$tax_slug' class='postform'>";
					echo "<option value=''>Show All $tax_name</option>";
					foreach ($terms as $term) :
						echo '<option value='. $term->slug, $_GET[$tax_slug] == $term->slug ? ' selected="selected"' : '','>' . $term->name .' (' . $term->count .')</option>'; 
					endforeach;
					echo "</select>";
				endif;
			endforeach;
		endif;
	}//end function pica_brandnew_cpt_taxonomy_filters
?>