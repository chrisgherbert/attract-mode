<?php

/**
 * Posts 2 Posts Connections
 * 
 * Define connection types for the Posts 2 Posts WordPress plugin (https://wordpress.org/plugins/posts-to-posts/)
 */

////////////
// Sample //
////////////

// function site_connection_types(){

// 	p2p_register_connection_type(array(
// 		'name' => 'post_to_video',
// 		'from' => 'post',
// 		'to' => array('video'),
// 		'admin_box' => array(
// 			'context' => 'advanced'
// 		),
// 		'title' => array(
// 			'from' => 'Videos for this Post',
// 			'to' => 'Posts with this Video'
// 		)
// 	));

// }

// add_action('p2p_init', 'site_connection_types');

add_action('p2p_init', function(){
	p2p_register_connection_type(array(
		'name' => 'video_to_release',
		'from' => 'video',
		'to' => array('release'),
		'admin_column' => 'to',
		'admin_box' => array(
			'context' => 'advanced'
		)
	));
});

add_action('p2p_init', function(){
	p2p_register_connection_type(array(
		'name' => 'video_to_system',
		'from' => 'video',
		'to' => array('system'),
		'admin_box' => array(
			'context' => 'advanced'
		)
	));
});

add_action('p2p_init', function(){
	p2p_register_connection_type(array(
		'name' => 'video_to_game',
		'from' => 'video',
		'to' => array('game'),
		'admin_box' => array(
			'context' => 'advanced'
		)
	));
});

add_action('p2p_init', function(){
	p2p_register_connection_type(array(
		'name' => 'release_to_system',
		'from' => 'release',
		'to' => array('system'),
		'admin_column' => 'from',
		'admin_box' => array(
			'context' => 'advanced'
		)
	));
});

add_action('p2p_init', function(){
	p2p_register_connection_type(array(
		'name' => 'release_to_game',
		'from' => 'release',
		'to' => array('game'),
		'admin_box' => array(
			'context' => 'advanced'
		)
	));
});

//////////////////////
// Connection Hooks //
//////////////////////

function append_date_to_candidate_title( $title, $post, $ctype ) {

	if ( $ctype->name == 'video_to_release' && $post->post_type == 'release' ) {

		$release = new AmvRelease($post->ID);

		$title .= " (" . $release->get_gb_system_name() . ")";
	}

	return $title;

}

add_filter( 'p2p_candidate_title', 'append_date_to_candidate_title', 10, 3 );
add_filter( 'p2p_connected_title', 'append_date_to_candidate_title', 10, 3 );

function after_video_to_release($p2p_id){

	$connection = p2p_get_connection($p2p_id);

	if ($connection->p2p_type == 'video_to_release'){

		$video = new AmvVideo($connection->p2p_from);
		$release = new AmvRelease($connection->p2p_to);

		$games = $release->get_games();
		$systems = $release->get_systems();

		foreach ($games as $game){

			p2p_type('video_to_game')->connect(
				$video->ID,
				$game->ID,
				array(
					'date' => current_time('mysql')
				)
			);

		}

		foreach ($systems as $system){

			p2p_type('video_to_system')->connect(
				$video->ID,
				$system->ID,
				array(
					'date' => current_time('mysql')
				)
			);

		}

	}

}

add_action( 'p2p_created_connection', 'after_video_to_release' );


