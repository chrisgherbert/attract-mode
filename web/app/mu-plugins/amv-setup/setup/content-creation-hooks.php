<?php

/**
 * Content Creation Hooks
 *
 * This is for code that does things like modify post titles based on data from
 * an API request, automatically set the featured image to be YouTube video thumbnail, etc.
 */

add_action('updated_post_meta', 'game_data_setup', 10, 4);
add_action('added_post_meta', 'game_data_setup', 10, 4);

function game_data_setup($meta_id, $post_id, $meta_key, $meta_value){

	if ($meta_key == 'amv_game_gb_url'){

		$messages = array();

		// Save the GiantBomb API data as metadata
		$data = AmvGame::fetch_api_data($meta_value);
		
		if (update_post_meta($post_id, 'amv_game_gb_data', $data)){
			$messages[] = 'Fetched GiantBomb API data';
		}

		$game = new AmvGame($post_id);

		// Set the post title, slug, and content using GB data
		if ($game->set_post_to_api_data()){
			$messages[] = 'Updated game title, slug, and content with GiantBomb data';
		}

		// Set the GB ID as metadata (easier to query it this way)
		if ($game->save_gb_id_as_meta()){
			$messages[] = 'Added GB ID as meta data';
		}

		// Set the featured image to the GB game image
		if ($game->set_api_image_as_featured_image()){
			$messages[] = 'Set GB image as the featured image';
		}

		if ($messages){

			add_action('admin_notices', function(){
				$class = 'notice notice-info';
				$message = implode('<p>', $messages);
				echo "<div class='$class'>$messages</div>";
			});

		}

	}

}

add_action('updated_post_meta', 'system_data_setup', 10, 4);
add_action('added_post_meta', 'system_data_setup', 10, 4);

function system_data_setup($meta_id, $post_id, $meta_key, $meta_value){

	if ($meta_key == 'amv_system_gb_url'){

		$messages = array();

		// Save the GiantBomb API data as metadata
		$data = AmvSystem::fetch_api_data($meta_value);
		
		if (update_post_meta($post_id, 'amv_system_gb_data', $data)){
			$messages[] = 'Fetched GiantBomb API data';
		}

		$system = new AmvSystem($post_id);

		// Set the post title, slug, and content using GB data
		if ($system->set_post_to_api_data()){
			$messages[] = 'Updated system title, slug, and content with GiantBomb data';
		}

		// Set the GB ID as metadata (easier to query it this way)
		if ($system->save_gb_id_as_meta()){
			$messages[] = 'Added GB ID as meta data';
		}

		// Set the featured image to the GB system image
		if ($system->set_api_image_as_featured_image()){
			$messages[] = 'Set GB image as the featured image';
		}

		if ($messages){

			add_action('admin_notices', function(){
				$class = 'notice notice-info';
				$message = implode('<p>', $messages);
				echo "<div class='$class'>$messages</div>";
			});

		}

	}

}

add_action('updated_post_meta', 'release_data_setup', 10, 4);
add_action('added_post_meta', 'release_data_setup', 10, 4);

function release_data_setup($meta_id, $post_id, $meta_key, $meta_value){

	if ($meta_key == 'amv_release_gb_url'){

		$messages = array();

		// Save the GiantBomb API data as metadata
		$data = AmvRelease::fetch_api_data($meta_value);
		
		if (update_post_meta($post_id, 'amv_release_gb_data', $data)){
			$messages[] = 'Fetched GiantBomb API data';
		}

		$release = new AmvRelease($post_id);

		// Set the post title, slug, and content using GB data
		if ($release->set_post_to_api_data()){
			$messages[] = 'Updated system title, slug, and content with GiantBomb data';
		}

		// Set the GB ID as metadata (easier to query it this way)
		if ($release->save_gb_id_as_meta()){
			$messages[] = 'Added GB ID as meta data';
		}

		// Set the featured image to the GB system image
		if ($release->set_api_image_as_featured_image()){
			$messages[] = 'Set GB image as the featured image';
		}

		// Check if the related game and system objects exist. If not, create them.

		$updated_release = new AmvRelease($post_id); // Not sure if the updated data (new title, etc) is available to the object without reinitializing it.  Probably isn't.

		$connection_creator = new AmvReleaseConnectionCreator($updated_release);

		$connection_creator->create_objects_and_connections_for_game();
		$connection_creator->create_objects_and_connections_for_system();

		if ($messages){

			add_action('admin_notices', function(){
				$class = 'notice notice-info';
				$message = implode('<p>', $messages);
				echo "<div class='$class'>$messages</div>";
			});

		}

	}

}

add_action('updated_post_meta', 'video_data_setup', 10, 4);
add_action('added_post_meta', 'video_data_setup', 10, 4);

function video_data_setup($meta_id, $post_id, $meta_key, $meta_value){

	if ($meta_key == 'amv_video_youtube_url'){

		$messages = array();

		// Save the YouTube api object as metadata
		$yt_object = AmvVideo::fetch_new_youtube_object($meta_value);

		if (update_post_meta($post_id, 'youtube_video_object', $yt_object)){
			$messages[] = 'Fetched YouTube API data';
		}

		$video = new AmvVideo($post_id);

		// Set the post title, slug, and content using GB data
		if ($video->set_post_to_api_data()){
			$messages[] = 'Updated system title, slug, and content with YouTube data';
		}

		// Set the featured image to the video thumbnail
		if ($video->set_api_image_as_featured_image()){
			$messages[] = 'Set video thumbnail as the featured image';
		}

		if ($messages){

			add_action('admin_notices', function(){
				$class = 'notice notice-info';
				$message = implode('<p>', $messages);
				echo "<div class='$class'>$messages</div>";
			});

		}

	}

}

