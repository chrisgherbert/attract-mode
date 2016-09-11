<?php

/**
 * Define custom field prefix
 */
define( 'CPT_PREFIX', 'amv_' );

// add_action( 'cmb2_admin_init', 'sample_post_type_metabox' );

// function sample_post_type_metabox(){

// 	$prefix = CPT_PREFIX . 'sample_post_type_';

// 	$cmb2 = new_cmb2_box( array(
// 		'id' 						=> $prefix . 'fields',
// 		'title' 				=> 'Sample Post Type Fields',
// 		'object_types' 	=> array( 'sample-post-type', ),
// 	) );

// 	$cmb2->add_field( array(
// 		'id' 			=> $prefix . 'subtitle',
// 		'name' 		=> 'Subtitle',
// 		'desc' 		=> 'Add an option subtitle to this post',
// 		'type' 		=> 'text',
// 	) );

// 	$cmb2->add_field( array(
// 		'id' 				=> $prefix . 'icon',
// 		'name' 			=> 'Icon',
// 		'desc' 			=> 'Icon for this post',
// 		'type' 			=> 'file',
// 		'options' 	=> array(
// 			'url' => false
// 		)
// 	) );

// }

add_action('cmb2_admin_init', 'video_post_type_metabox');

function video_post_type_metabox(){

	$prefix = CPT_PREFIX . 'video_';

	$cmb2 = new_cmb2_box(array(
		'id' => $prefix . 'fields',
		'title' => 'Video Fields',
		'object_types' => array('video')
	));

	$cmb2->add_field(array(
		'id' => $prefix . 'youtube_url',
		'name' => 'YouTube video URL (not the embed code)',
		'type' => 'text_url'
	));

}

add_action('cmb2_admin_init', 'game_post_type_metabox');

function game_post_type_metabox(){

	$prefix = CPT_PREFIX . 'game_';

	$cmb2 = new_cmb2_box(array(
		'id' => $prefix . 'fields',
		'title' => 'Game Fields',
		'object_types' => array('game')
	));

	$cmb2->add_field(array(
		'id' => $prefix . 'gb_url',
		'name' => 'GiantBomb game URL',
		'type' => 'text_url'
	));

}

add_action('cmb2_admin_init', 'system_post_type_metabox');

function system_post_type_metabox(){

	$prefix = CPT_PREFIX . 'system_';

	$cmb2 = new_cmb2_box(array(
		'id' => $prefix . 'fields',
		'title' => 'System Fields',
		'object_types' => array('system')
	));

	$cmb2->add_field(array(
		'id' => $prefix . 'gb_url',
		'name' => 'GiantBomb system URL',
		'type' => 'text_url'
	));

}

add_action('cmb2_admin_init', 'release_post_type_metabox');

function release_post_type_metabox(){

	$prefix = CPT_PREFIX . 'release_';

	$cmb2 = new_cmb2_box(array(
		'id' => $prefix . 'fields',
		'title' => 'Release Fields',
		'object_types' => array('release')
	));

	$cmb2->add_field(array(
		'id' => $prefix . 'gb_url',
		'name' => 'GiantBomb release ID',
		'type' => 'text'
	));

}
