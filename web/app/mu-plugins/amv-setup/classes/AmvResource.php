<?php

/**
 * AMV Resource
 *
 * These are any post types that pull data from an API - such as GiantBomb or YouTube
 */

abstract class AmvResource extends bermanco\ExtendedTimberClasses\Post {

	abstract public function get_api_resource_url();

	abstract public function get_api_name();

	abstract public function get_api_description();

	abstract public function get_api_main_image();

	////////////////////////
	// Post Setup Methods //
	////////////////////////

	public function set_post_to_api_data(){

		$update_data = array(
			'ID' => $this->ID,
			'post_title' => $this->get_api_name(),
			'post_name' => $this->create_unique_post_slug()
		);

		// Set content to the api-provided description if there isn't already content 
		// for the post.  We don't want to overwrite any custom description 
		// that's been written.
		if (!$this->get_content()){
			$update_data['post_content'] = $this->get_api_description();
		}

		return wp_update_post($update_data);

	}

	public function set_api_image_as_featured_image(){

		$image = $this->get_api_main_image();

		if ($image){

			$attachment_sideloader = new bermanco\WordpressImageDownload\WordpressImageDownload($image);

			$attachment_sideloader->set_user_agent('AttractModeBot/1.1'); // GiantBomb doesn't allow the default WordPress user agent

			$attachment_id = $attachment_sideloader->create_media_attachment();

			return update_post_meta($this->ID, '_thumbnail_id', $attachment_id);

		}

	}

	///////////////
	// Protected //
	///////////////

	protected function create_unique_post_slug(){

		$slug = sanitize_title($this->get_api_name(), $this->ID);

		$unique_slug = wp_unique_post_slug(
			$slug,
			$this->ID,
			$this->post_status,
			$this->post_type,
			$this->post_parent
		);

		return $unique_slug;

	}

}