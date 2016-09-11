<?php

//////////////////////
// Sample Post Type //
//////////////////////

// register_via_cpt_core(
// 	array(
// 		'Sample Post Type', // Singular name
// 		'Sample Post Types', // Plural name
// 		'sample-post-type' // Slug
// 	),
// 	array(
// 		'menu_icon' 	=> 'dashicons-clipboard',
// 		'supports' 		=> array( 'title', 'editor', 'thumbnail', 'excerpt', ),
// 		'taxonomies' 	=> array( 'category', 'sample_taxonomy' ),
// 		/* Uncomment the following to hide on front-end */
// 		// 'publicly_queryable' => false, // Don't allow url querying of this post type
// 		// 'exclude_from_search' => true, // Don't include posts in wordpress search
// 	)
// );

///////////
// Games //
///////////

register_via_cpt_core(
	array('Game', 'Games', 'game'),
	array(
		'menu_icon' => 'dashicons-desktop',
		'supports' => array('title', 'thumbnail', 'editor')
	)
);

////////////
// Videos //
////////////

register_via_cpt_core(
	array('Video', 'Videos', 'video'),
	array(
		'menu_icon' => 'dashicons-video-alt3',
		'supports' => array('title', 'thumbnail', 'editor')
	)
);

/////////////
// Systems //
/////////////

register_via_cpt_core(
	array('System', 'Systems', 'system'),
	array(
		'menu_icon' => 'dashicons-admin-settings',
		'supports' => array('title', 'thumbnail', 'editor')
	)
);

//////////////
// Releases //
//////////////

register_via_cpt_core(
	array('Release', 'Releases', 'release'),
	array(
		'supports' => array('title', 'thumbnail', 'editor')
	)
);