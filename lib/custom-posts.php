<?php
namespace PCHC\CustomPosts;
// Register Custom Post Type
function seaport_staff() {

	$staff_labels = array(
		'name'                  => 'Staff',
		'singular_name'         => 'Staff',
		'menu_name'             => 'Staff',
		'name_admin_bar'        => 'Staff',
		'archives'              => 'Staff Archives',
		'attributes'            => 'Staff Attributes',
		'parent_item_colon'     => 'Parent Staff:',
		'all_items'             => 'All Staff',
		'add_new_item'          => 'Add New Staff',
		'add_new'               => 'Add New',
		'new_item'              => 'New Staff',
		'edit_item'             => 'Edit Staff',
		'update_item'           => 'Update Staff',
		'view_item'             => 'View Staff',
		'view_items'            => 'View Staff',
		'search_items'          => 'Search Staff',
		'not_found'             => 'Not found',
		'not_found_in_trash'    => 'Not found in Trash',
		'featured_image'        => 'Featured Image',
		'set_featured_image'    => 'Set featured image',
		'remove_featured_image' => 'Remove featured image',
		'use_featured_image'    => 'Use as featured image',
		'insert_into_item'      => 'Insert into staff',
		'uploaded_to_this_item' => 'Uploaded to this staff',
		'items_list'            => 'Staff list',
		'items_list_navigation' => 'Staff list navigation',
		'filter_items_list'     => 'Filter staff list',
	);
	$staff_args = array(
		'label'                 => 'Staff',
		'description'           => 'Seaport Staff',
		'labels'                => $staff_labels,
		'supports'              => array( 'title', 'editor', 'thumbnail', 'revisions', ),
    'taxonomies'            => array( 'staff_role' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 20,
		'menu_icon'             => 'dashicons-nametag',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => 'staff',
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
		'show_in_rest'          => true,
	);
	register_post_type( 'staff', $staff_args );


  $staff_role_labels = array(
		'name'                       => 'Staff Roles',
		'singular_name'              => 'Staff Role',
		'menu_name'                  => 'Staff Roles',
		'all_items'                  => 'All Staff Roles',
		'parent_item'                => 'Parent Item',
		'parent_item_colon'          => 'Parent Item:',
		'new_item_name'              => 'New Item Name',
		'add_new_item'               => 'Add New Item',
		'edit_item'                  => 'Edit Item',
		'update_item'                => 'Update Item',
		'view_item'                  => 'View Item',
		'separate_items_with_commas' => 'Separate items with commas',
		'add_or_remove_items'        => 'Add or remove items',
		'choose_from_most_used'      => 'Choose from the most used',
		'popular_items'              => 'Popular Items',
		'search_items'               => 'Search Items',
		'not_found'                  => 'Not Found',
		'no_terms'                   => 'No items',
		'items_list'                 => 'Items list',
		'items_list_navigation'      => 'Items list navigation',
	);
	$staff_role_rewrite = array(
		'slug'                       => 'role',
		'with_front'                 => true,
		'hierarchical'               => true,
	);
	$staff_role_args = array(
		'labels'                     => $staff_role_labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
		'rewrite'                    => $staff_role_rewrite,
	);
	register_taxonomy( 'staff_role', array( 'staff' ), $staff_role_args );

}
add_action( 'init', __NAMESPACE__ . '\\seaport_staff', 0 );

function order_by_lastname( $orderby ) {
  global $wpdb;

  $orderby_statement = "SUBSTR( LTRIM({$wpdb->posts}.post_title), LOCATE(' ',LTRIM({$wpdb->posts}.post_title)))";
  return $orderby_statement;
}

function seaport_staff_query( $query ) {
    if ( is_admin() || ! $query->is_main_query() )
        return;

    if ( is_post_type_archive( 'staff' ) ) {
        // Display all posts for custom 'staff' post type
        add_filter( 'posts_orderby', __NAMESPACE__ . '\\order_by_lastname' );
        $query->set( 'posts_per_page', -1 );
        $query->set( 'order', 'ASC' );
        return;
    }
}
add_action( 'pre_get_posts', __NAMESPACE__ . '\\seaport_staff_query', 1 );
