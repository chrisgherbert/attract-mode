<?php

use bermanco\YouTubeVideo\YouTubeVideo;

class AmvVideo extends AmvResource {

	public $custom_field_prefix = 'amv_video_';
	protected $youtube_video_object;

	public function get_all_games(){

		$games = array();

		if ($connected_games = $this->get_games()){
			$games = array_merge($games, $connected_games);
		}

		if ($releases_games = $this->get_releases_games()){
			$games = array_merge($games, $releases_games);
		}

		$game_ids = array_map(function($item){
			return $item->ID;
		}, $games);

		return Timber::get_posts(
			array(
				'post_type' => 'game',
				'posts_per_page' => 50,
				'post__in' => $game_ids,
				'orderby' => 'name',
				'order' => 'ASC'
			),
			AmvConfig::$post_type_classes
		);

	}

	/**
	 * Combine directly p2p connected systems and those connected through connected releases
	 * @return array  Array of AmvSystem objects
	 */
	public function get_all_systems(){

		$systems = array_merge($this->get_releases_systems(), $this->get_systems());

		$system_ids = array_map(function($item){
			return $item->ID;
		}, $systems);

		return Timber::get_posts(
			array(
				'post_type' => 'system',
				'posts_per_page' => 50,
				'post__in' => $system_ids,
				'orderby' => 'name',
				'order' => 'ASC'
			),
			AmvConfig::$post_type_classes
		);

	}

	public function get_releases_systems(){

		$systems = array();

		$releases = $this->get_releases();

		foreach ($releases as $release){

			$systems = array_merge($systems, $release->get_systems());

		}

		return $systems;

	}

	public function get_systems(){

		return Timber::get_posts(
			array(
				'post_type' => 'system',
				'connected_type' => 'video_to_system',
				'connected_items' => $this->ID,
				'post_status' => 'publish',
				'posts_per_page' => 50
			),
			AmvConfig::$post_type_classes
		);

	}

	public function get_games(){

		return Timber::get_posts(
			array(
				'post_type' => 'game',
				'connected_type' => 'video_to_game',
				'connected_items' => $this->ID,
				'post_status' => 'publish',
				'posts_per_page' => 50
			),
			AmvConfig::$post_type_classes
		);

	}

	public function get_releases(){

		return Timber::get_posts(
			array(
				'post_type' => 'release',
				'connected_type' => 'video_to_release',
				'connected_items' => $this->ID,
				'post_status' => 'publish',
				'posts_per_page' => 50
			),
			AmvConfig::$post_type_classes
		);

	}

	public function get_youtube_url(){
		return $this->get_cmb2_meta('youtube_url');
	}

	public function get_api_resource_url(){
		return $this->get_youtube_url();
	}

	public function get_api_name(){

		$yt_object = $this->get_youtube_object();

		if ($yt_object && $data = $yt_object->get_data()){
			return $data->snippet->title;
		}

	}

	public function get_api_description(){

		$yt_object = $this->get_youtube_object();

		if ($yt_object && $data = $yt_object->get_data()){
			return $data->snippet->description;
		}

	}

	public function get_api_main_image(){
		$yt_object = $this->get_youtube_object();
		if ($yt_object){
			return $yt_object->get_largest_thumbnail_url();
		}
	}

	public function get_api_data_item($key){

		if ($this->youtube_video_object && isset($this->youtube_video_object->get_data()->$key)){
			return $this->youtube_video_object->$key;
		}

	}

	public function get_youtube_object(){

		if ($this->youtube_video_object){
			return $this->youtube_video_object;
		}

		$youtube_video_object = $$this->get_cmb2_meta('youtube_video_object');

		$this->youtube_video_object = $youtube_video_object;

		return $this->youtube_video_object;

	}

	////////////
	// Static //
	////////////

	public static function fetch_new_youtube_object($url){

		$api_key = getenv('YOUTUBE_API_KEY');

		if ($url && $api_key){
			$yt_video_object = YouTubeVideo::create(getenv('YOUTUBE_API_KEY'), $url);
			$yt_video_object->get_data();
			return $yt_video_object;
		}


	}

}