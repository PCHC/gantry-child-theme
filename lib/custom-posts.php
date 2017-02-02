<?php
namespace PCHC\CustomPosts;
// Register Custom Post Type
function seaport_staff() {

	$labels = array(
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
	$args = array(
		'label'                 => 'Staff',
		'description'           => 'Seaport Staff',
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail', 'revisions', ),
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
	register_post_type( 'staff', $args );

}
add_action( 'init', __NAMESPACE__ . '\\seaport_staff', 0 );

function seaport_staff_query( $query ) {
    if ( is_admin() || ! $query->is_main_query() )
        return;

    if ( is_post_type_archive( 'staff' ) ) {
        // Display all posts for custom 'staff' post type
        $query->set( 'posts_per_page', -1 );
        $query->set( 'orderby', 'menu_order' );
        return;
    }
}
add_action( 'pre_get_posts', __NAMESPACE__ . '\\seaport_staff_query', 1 );
