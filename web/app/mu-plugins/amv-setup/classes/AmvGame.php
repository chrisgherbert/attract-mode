<?php

class AmvGame extends AmvGiantBombResource {

	public $custom_field_prefix = 'amv_game_';

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

	///////////////
	// Protected //
	///////////////

	protected static function get_gb_endpoint_base(){
		return 'https://www.giantbomb.com/api/game/';
	}

	protected static function get_gb_field_list(){
		return array(
			'date_added',
			'date_last_updated',
			'deck',
			'id',
			'image',
			'name',
			'original_release_date',
			'platforms',
			'site_detail_url',
			'images',
			'developers',
			'genres',
			'image',
			'original_game_rating',
			'publishers',
			'releases',
		);
	}

}