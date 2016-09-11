<?php

class AmvReleaseConnectionCreator {

	protected $release;

	public function __construct(AmvRelease $release){
		$this->release = $release;
	}

	public function create_objects_and_connections_for_game(){

		$game_gb_id = $this->release->get_gb_game_id();

		$game_post_id = $this->get_game_post($game_gb_id);

		if (!$game_post_id){
			$game_post_id = $this->create_game_post($game_gb_id);
		}

		$connection_id = $this->create_game_p2p_connection($game_post_id);

		return array(
			'game_post_id' => $game_post_id,
			'p2p_connection_id' => $connection_id
		);

	}

	public function create_objects_and_connections_for_system(){

		$system_gb_id = $this->release->get_gb_system_id();

		$system_post_id = $this->get_system_post($system_gb_id);

		if (!$system_post_id){
			$system_post_id = $this->create_system_post($system_gb_id);
		}

		$connection_id = $this->create_system_p2p_connection($system_post_id);

		return array(
			'system_post_id' => $system_post_id,
			'p2p_connection_id' => $connection_id
		);

	}

	///////////////
	// Protected //
	///////////////

	protected function get_game_post($game_id){
		return $this->get_resource_post_by_gb_id($game_id, 'game');
	}

	protected function get_system_post($system_id){
		return $this->get_resource_post_by_gb_id($system_id, 'system');
	}

	protected function create_game_post($game_gb_id){
		return $this->create_gb_resource_post($game_gb_id, 'game', 'game');
	}

	protected function create_system_post($system_gb_id){
		return $this->create_gb_resource_post($system_gb_id, 'system', 'platform');
	}

	protected function create_game_p2p_connection($game_post_id){

		$from_post_id = $this->release->ID;
		$to_post_id = $game_post_id;

		return p2p_type('release_to_game')->connect($from_post_id, $to_post_id, array(
			'date' => current_time('mysql')
		));

	}

	protected function create_system_p2p_connection($system_post_id){

		$from_post_id = $this->release->ID;
		$to_post_id = $system_post_id;

		return p2p_type('release_to_system')->connect($from_post_id, $to_post_id, array(
			'date' => current_time('mysql')
		));

	}

	protected function get_resource_post_by_gb_id($gb_id, $post_type){

		$query = array(
			'post_type' => $post_type,
			'post_status' => 'publish',
			'meta_query' => array(
				array(
					'key' => "amv_{$post_type}_gb_id",
					'value' => $gb_id,
					'compare' => '='
				)
			)
		);

		$matching_posts = get_posts($query);

		if (count($matching_posts) > 0){
			return $matching_posts[0]->ID;
		}
		else {
			return false;
		}

	}

	protected function create_gb_resource_post($gb_id, $post_type, $gb_resource_type){

		// Create a fake GB game URL.  This is pretty dumb but the new game 
		// post is actually expecting a URL rather than the ID.  Backwards but 
		// it works.
		$url = "http://giantbomb.com/$gb_resource_type/$gb_id";

		$new_post_id = wp_insert_post(array(
			'post_type' => $post_type,
			'post_status' => 'publish'
		));

		update_post_meta($new_post_id, "amv_{$post_type}_gb_url", $url);

		return $new_post_id;

	}

}

