<?php

class AmvRelease extends AmvGiantBombResource {

	public $custom_field_prefix = 'amv_release_';

	public function get_game(){
		$games = $this->get_games();
		if (count($games) > 0){
			return $games[0];
		}
	}

	public function get_system(){
		$systems = $this->get_systems();
		if (count($systems) > 0){
			return $systems[0];
		}
	}

	/**
	 * Get the connected game (this uses p2p connection)
	 * @return AmvGame Game Post object
	 */
	public function get_games(){

		$query =  array(
			'connected_type' => 'release_to_game',
			'connected_items' => $this->ID
		);

		return Timber\Timber::get_posts($query, 'AmvGame');

	}

	/**
	 * Get the connected system (uses p2p connection)
	 * @return AmvSystem System Post object
	 */
	public function get_systems(){

		$query =  array(
			'connected_type' => 'release_to_system',
			'connected_items' => $this->ID
		);

		return Timber\Timber::get_posts($query, 'AmvSystem');

	}

	public function get_gb_deck(){
		return $this->get_gb_data_item('deck');
	}

	public function get_gb_site_detail_url(){
		return $this->get_gb_data_item('site_detail_url');
	}

	public function get_gb_developers(){
		return $this->get_gb_data_item('developers');
	}

	public function get_gb_genres(){
		return $this->get_gb_data_item('genres');
	}

	public function get_gb_game_id(){
		$game = $this->get_gb_data_item('game');
		if (isset($game->id)){
			return $game->id;
		}
	}

	public function get_gb_system_name(){
		$system = $this->get_gb_data_item('platform');
		if (isset($system->name)){
			return $system->name;
		}
	}

	public function get_gb_system_id(){
		$system = $this->get_gb_data_item('platform');
		if (isset($system->id)){
			return $system->id;
		}
	}

	///////////////
	// Protected //
	///////////////

	protected static function extract_gb_id_from_url($gb_release_url){

		$url = trim($gb_release_url, '/ ');

		$exploded = explode('#toc-release-', $url);

		$id = array_pop($exploded);

		return $id;

	}

	protected static function get_gb_endpoint_base(){
		return 'https://www.giantbomb.com/api/release/';
	}

	protected static function get_gb_field_list(){
		return array(
			'api_detail_url',
			'date_added',
			'date_last_updated',
			'deck',
			'description',
			'game',
			'game_rating',
			'id',
			'image',
			'maximum_players',
			'minimum_players',
			'name',
			'platform',
			'region',
			'release_date',
			'site_detail_url',
			'widescreen_support',
			'images',
			'developers',
			'publishers',
			'sound_systems'
		);
	}

}