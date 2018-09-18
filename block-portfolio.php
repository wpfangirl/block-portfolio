<?php
/*
Plugin Name:  Block-Based Portfolio
Plugin URI:   https://github.com/wpfangirl/block-portfolio
Description:  Gutenberg-compatible portfolio post type with block-based layout and custom taxonomies
Version:      0.6
Author:       WP Fangirl
Author URI:   https://www.wpfangirl.com/
License:      GPL2
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
Text Domain:  block-portfolio
Domain Path:  /languages
*/

/*
Block-Based Portfolio is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.
 
Block-Based Portfolio is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
 
You should have received a copy of the GNU General Public License
along with Block-Based Portfolio. If not, see https://www.gnu.org/licenses/gpl-2.0.html.
*/

//  Exit if accessed directly.
defined('ABSPATH') || exit;

/**
 * Check if Gutenberg is active.
 *
 * Cannot use `is_plugin_active()` as it loads late and only in wp-admin.
 *
 * @return bool Whether the Gutenberg plugin is active.
 */
function bbp_is_gutenberg_active() {
	if ( in_array( 'gutenberg/gutenberg.php', (array) get_option( 'active_plugins' ) ) ||
		( is_multisite() && array_key_exists( 'gutenberg/gutenberg.php', (array) get_site_option( 'active_sitewide_plugins' ) ) ) ) {

		return true;
	}

	return false;
}

if( !bbp_is_gutenberg_active() ) {
	echo '<p>This plugin requires Gutenberg to be active.</p>';
	exit;
}

// Register Portfolio Post Type
if ( ! function_exists('bbp_setup_post_type') ) {
	function bbp_setup_post_type() {

		$labels = array(
			'name'                  => _x( 'Portfolio', 'Post Type General Name', 'block-portfolio' ),
			'singular_name'         => _x( 'Portfolio Entry', 'Post Type Singular Name', 'block-portfolio' ),
			'menu_name'             => __( 'Portfolio', 'block-portfolio' ),
			'name_admin_bar'        => __( 'Portfolio Entry', 'block-portfolio' ),
			'archives'              => __( 'Portfolio Archives', 'block-portfolio' ),
			'attributes'            => __( 'Portfolio Attributes', 'block-portfolio' ),
			'parent_item_colon'     => __( 'Parent Entry:', 'block-portfolio' ),
			'all_items'             => __( 'All Portfolio Entries', 'block-portfolio' ),
			'add_new_item'          => __( 'Add New Portfolio Entry', 'block-portfolio' ),
			'add_new'               => __( 'Add New', 'block-portfolio' ),
			'new_item'              => __( 'New Portfolio Entry', 'block-portfolio' ),
			'edit_item'             => __( 'Edit Portfolio Entry', 'block-portfolio' ),
			'update_item'           => __( 'Update Portfolio Entry', 'block-portfolio' ),
			'view_item'             => __( 'View Portfolio Entry', 'block-portfolio' ),
			'view_items'            => __( 'View Portfolio Entries', 'block-portfolio' ),
			'search_items'          => __( 'Search Portfolio Entry', 'block-portfolio' ),
			'not_found'             => __( 'Not found', 'block-portfolio' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'block-portfolio' ),
			'featured_image'        => __( 'Featured Image', 'block-portfolio' ),
			'set_featured_image'    => __( 'Set featured image', 'block-portfolio' ),
			'remove_featured_image' => __( 'Remove featured image', 'block-portfolio' ),
			'use_featured_image'    => __( 'Use as featured image', 'block-portfolio' ),
			'insert_into_item'      => __( 'Insert into portfolio entry', 'block-portfolio' ),
			'uploaded_to_this_item' => __( 'Uploaded to this portfolio entry', 'block-portfolio' ),
			'items_list'            => __( 'Items list', 'block-portfolio' ),
			'items_list_navigation' => __( 'Items list navigation', 'block-portfolio' ),
			'filter_items_list'     => __( 'Filter portfolio entries', 'block-portfolio' ),
		);
		$rewrite = array(
			'slug'                  => 'portfolio',
			'with_front'            => false,
			'pages'                 => true,
			'feeds'                 => true,
		);
		$args = array(
			'label'                 => __( 'Portfolio Entry', 'block-portfolio' ),
			'description'           => __( 'Post type for portfolio and case study entries', 'block-portfolio' ),
			'labels'                => $labels,
			'supports'              => array( 'title', 'editor', 'excerpt', 'thumbnail', 'revisions' ),
			'taxonomies'            => array( 'bbp_project_type', 'bbp_client_type', 'bbp_tags' ),
			'hierarchical'          => false,
			'public'                => true,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'menu_position'         => 5,
			'menu_icon'             => 'dashicons-portfolio',
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => true,
			'can_export'            => true,
			'has_archive'           => 'portfolio',
			'exclude_from_search'   => false,
			'publicly_queryable'    => true,
			'rewrite'               => $rewrite,
			'capability_type'       => 'post',
			'show_in_rest'          => true,
			'rest_base'             => 'portfolio',
			'template' => array(
				array( 'core/heading', array(
					'placeholder' => 'Executive Summary',
					'level' => '2',
					) 
				),
				array( 'core/paragraph', array(
					'placeholder' => 'Put the problem and the results you got into about 160 characters, with keywords. Then you can use it for your meta description.',
					'customFontSize' => '24',
					) 
				),
				array( 'core/columns', 
					array(
						'align' => 'wide',
						'columns' => '2',
					), 
				array(
					array( 'core/column', array(), array(
						array( 'core/image', array() ),
					) ),
					array( 'core/column', array(), array(
						array( 'core/heading', array(
							'placeholder'=> 'Client Company Name',
							'level'	=> '3',
						) ),
						array( 'core/paragraph', array(
							'placeholder' => 'Describe your client: industry, company size, who their customer is, what they do.',
						) ),
					) ),
				) ),
				array('core/quote', array(
				) ),
				array( 'core/heading', array(
					'placeholder' => 'The Challenge',
					'level' => '2',
				) ),
				array( 'core/paragraph', array(
					'placeholder' => 'Why did your client need your services?',
				) ),
				array( 'core/image', array(
					'align' => 'wide',
				) ),
				array( 'core/heading', array(
					'placeholder' => 'Your Solution',
					'level' => '2',
				) ),
				array( 'core/paragraph', array(
					'placeholder' => 'Write two or three short paragraphs describing what you did to solve the problem.',
				) ),
				array( 'core/image', array(
					'align' => 'wide',
				) ),
				array( 'core/heading', array(
					'placeholder' => 'Results and ROI',
					'level' => '2',
				) ),
				array( 'core/paragraph', array(
					'placeholder' => 'You need a keyword-rich sound bite with numbers in it, e.g. tripled revenue or cut production time in half.',
					'customFontSize' => '20',
					'customTextColor' => '#FF6900',

				) ),
				array( 'core/paragraph', array(
					'placeholder' => 'Provide more detail about how happy the client is and why. You could put another quote here instead.',
				) ),
				array( 'core/image', array(
					'align' => 'wide',
				) ),
				array( 'core/paragraph', array(
					'placeholder' => 'Write your call to action here. Give it a large font size and a color background.',
					'customFontSize' => '28',
					'customTextColor' => '#ffffff',
					'customBackgroundColor' => '#313131',
				) ),
				array( 'core/button', array(
					'customBackgroundColor' => '#CF2E2E',
					'customTextColor' => '#ffffff',
				) ),
			),
		);
		register_post_type( 'bbp_portfolio', $args );
	}
	add_action( 'init', 'bbp_setup_post_type', 0 );
}

//Register Project Type Taxonomy
if ( ! function_exists( 'bbp_project_type_tax' ) ) {
	function bbp_project_type_tax() {

		$labels = array(
			'name'                       => _x( 'Project Types', 'Taxonomy General Name', 'block-portfolio' ),
			'singular_name'              => _x( 'Project Type', 'Taxonomy Singular Name', 'block-portfolio' ),
			'menu_name'                  => __( 'Project Types', 'block-portfolio' ),
			'all_items'                  => __( 'All Project Types', 'block-portfolio' ),
			'parent_item'                => __( 'Parent Project Type', 'block-portfolio' ),
			'parent_item_colon'          => __( 'Parent Project Type:', 'block-portfolio' ),
			'new_item_name'              => __( 'New Project Type', 'block-portfolio' ),
			'add_new_item'               => __( 'Add New Project Type', 'block-portfolio' ),
			'edit_item'                  => __( 'Edit Project Type', 'block-portfolio' ),
			'update_item'                => __( 'Update Project Type', 'block-portfolio' ),
			'view_item'                  => __( 'View Project Type', 'block-portfolio' ),
			'separate_items_with_commas' => __( 'Separate project types with commas', 'block-portfolio' ),
			'add_or_remove_items'        => __( 'Add or remove project types', 'block-portfolio' ),
			'choose_from_most_used'      => __( 'Choose from the most used project types', 'block-portfolio' ),
			'popular_items'              => __( 'Popular Project Types', 'block-portfolio' ),
			'search_items'               => __( 'Search Project Types', 'block-portfolio' ),
			'not_found'                  => __( 'Not Found', 'block-portfolio' ),
			'no_terms'                   => __( 'No project types found', 'block-portfolio' ),
			'items_list'                 => __( 'Project Type list', 'block-portfolio' ),
			'items_list_navigation'      => __( 'Project type list navigation', 'block-portfolio' ),
		);
		$rewrite = array(
			'slug'                       => 'portfolio/project-type',
			'with_front'                 => true,
			'hierarchical'               => true,
		);
		$args = array(
			'labels'                     => $labels,
			'hierarchical'               => true,
			'public'                     => true,
			'show_ui'                    => true,
			'show_admin_column'          => true,
			'show_in_nav_menus'          => true,
			'show_tagcloud'              => false,
			'rewrite'                    => $rewrite,
			'show_in_rest'               => true,
			'rest_base'                  => 'portfolio/project-type',
		);
		register_taxonomy( 'bbp_project_type', array( 'bbp_portfolio' ), $args );
	}
	add_action( 'init', 'bbp_project_type_tax', 0 );
}
 
// Register Client Type Taxonomy
if ( ! function_exists( 'bbp_client_type_tax' ) ) {
	function bbp_client_type_tax() {

		$labels = array(
			'name'                       => _x( 'Client Types', 'Taxonomy General Name', 'block-portfolio' ),
			'singular_name'              => _x( 'Client Type', 'Taxonomy Singular Name', 'block-portfolio' ),
			'menu_name'                  => __( 'Client Types', 'block-portfolio' ),
			'all_items'                  => __( 'All Client Types', 'block-portfolio' ),
			'parent_item'                => __( 'Parent Client Type', 'block-portfolio' ),
			'parent_item_colon'          => __( 'Parent Client Type:', 'block-portfolio' ),
			'new_item_name'              => __( 'New Client Type', 'block-portfolio' ),
			'add_new_item'               => __( 'Add New Client Type', 'block-portfolio' ),
			'edit_item'                  => __( 'Edit Client Type', 'block-portfolio' ),
			'update_item'                => __( 'Update Client Type', 'block-portfolio' ),
			'view_item'                  => __( 'View Client Type', 'block-portfolio' ),
			'separate_items_with_commas' => __( 'Separate client types with commas', 'block-portfolio' ),
			'add_or_remove_items'        => __( 'Add or remove client types', 'block-portfolio' ),
			'choose_from_most_used'      => __( 'Choose from the most used client types', 'block-portfolio' ),
			'popular_items'              => __( 'Popular Client Types', 'block-portfolio' ),
			'search_items'               => __( 'Search Client Types', 'block-portfolio' ),
			'not_found'                  => __( 'Not Found', 'block-portfolio' ),
			'no_terms'                   => __( 'No client types found', 'block-portfolio' ),
			'items_list'                 => __( 'Client Type list', 'block-portfolio' ),
			'items_list_navigation'      => __( 'Client type list navigation', 'block-portfolio' ),
		);
		$rewrite = array(
			'slug'                       => 'portfolio/client-type',
			'with_front'                 => true,
			'hierarchical'               => true,
		);
		$args = array(
			'labels'                     => $labels,
			'hierarchical'               => true,
			'public'                     => true,
			'show_ui'                    => true,
			'show_admin_column'          => true,
			'show_in_nav_menus'          => true,
			'show_tagcloud'              => false,
			'rewrite'                    => $rewrite,
			'show_in_rest'               => true,
			'rest_base'                  => 'portfolio/client-type',
		);
		register_taxonomy( 'bbp_client_type', array( 'bbp_portfolio' ), $args );
	}
	add_action( 'init', 'bbp_client_type_tax', 0 );
} 

// Register Portfolio Tag Taxonomy
if ( ! function_exists( 'bbp_portfolio_tags' ) ) {
	function bbp_portfolio_tags() {
		$labels = array(
			'name'                       => _x( 'Portfolio Tags', 'Taxonomy General Name', 'block-portfolio' ),
			'singular_name'              => _x( 'Portfolio Tag', 'Taxonomy Singular Name', 'block-portfolio' ),
			'menu_name'                  => __( 'Portfolio Tags', 'block-portfolio' ),
			'all_items'                  => __( 'All Portfolio Tags', 'block-portfolio' ),
			'parent_item'                => __( '', 'block-portfolio' ),
			'parent_item_colon'          => __( '', 'block-portfolio' ),
			'new_item_name'              => __( 'New Portfolio Tag', 'block-portfolio' ),
			'add_new_item'               => __( 'Add New Tag', 'block-portfolio' ),
			'edit_item'                  => __( 'Edit Tag', 'block-portfolio' ),
			'update_item'                => __( 'Update Tag', 'block-portfolio' ),
			'view_item'                  => __( 'View Tag', 'block-portfolio' ),
			'separate_items_with_commas' => __( 'Separate tags with commas', 'block-portfolio' ),
			'add_or_remove_items'        => __( 'Add or remove tags', 'block-portfolio' ),
			'choose_from_most_used'      => __( 'Choose from the most used portfolio tags', 'block-portfolio' ),
			'popular_items'              => __( 'Popular tags', 'block-portfolio' ),
			'search_items'               => __( 'Search tags', 'block-portfolio' ),
			'not_found'                  => __( 'Not Found', 'block-portfolio' ),
			'no_terms'                   => __( 'No tags', 'block-portfolio' ),
			'items_list'                 => __( 'Portfolio Tags list', 'block-portfolio' ),
			'items_list_navigation'      => __( 'Portfolio Tags list navigation', 'block-portfolio' ),
		);
		$rewrite = array(
			'slug'                       => 'portfolio/tag',
			'with_front'                 => true,
			'hierarchical'               => false,
		);
		$args = array(
			'labels'                     => $labels,
			'hierarchical'               => false,
			'public'                     => true,
			'show_ui'                    => true,
			'show_admin_column'          => true,
			'show_in_nav_menus'          => true,
			'show_tagcloud'              => true,
			'rewrite'                    => $rewrite,
			'show_in_rest'               => true,
			'rest_base'                  => 'portfolio/tag',
		);
		register_taxonomy( 'bbp_tags', array( 'bbp_portfolio' ), $args );
	}
	add_action( 'init', 'bbp_portfolio_tags', 0 );
}

function bbp_install() {
    // trigger our function that registers the custom post type
    bbp_setup_post_type();
    // trigger the function that registers the custom taxonomies
    bbp_project_type_tax();
    bbp_client_type_tax();
    bbp_portfolio_tags();
    // clear the permalinks after the post type has been registered
    flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'bbp_install' );

function bbp_deactivation() {
    // unregister the post type, so the rules are no longer in memory
    unregister_post_type( 'bbp_portfolio' );
    // unregister the taxonomies
    unregister_taxonomy('bbp_tags');
    unregister_taxonomy('bbp_client_type');
    unregister_taxonomy('bbp_project_type');
    // clear the permalinks to remove our post type's rules from the database
    flush_rewrite_rules();
}
register_deactivation_hook( __FILE__, 'bbp_deactivation' );