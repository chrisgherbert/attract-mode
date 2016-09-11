<?php

use \Curl\Curl;

abstract class AmvGiantBombResource extends AmvResource {

	///////////////////////////////////////////////
	// Defined abstract methods from AmvResource //
	///////////////////////////////////////////////

	public function get_api_resource_url(){
		return $this->get_gb_name();
	}

	public function get_api_description(){
		return $this->get_gb_short_description();
	}

	public function get_api_name(){
		return $this->get_gb_name();
	}

	public function get_api_main_image(){
		return $this->get_gb_image();
	}

	////////////////////
	// GiantBomb Data //
	////////////////////

	public function get_gb_short_description(){
		return $this->get_gb_data_item('deck');
	}

	public function get_gb_url(){
		return $this->get_cmb2_meta('gb_url');
	}

	public function get_gb_data(){
		return $this->get_cmb2_meta('gb_data');
	}

	public function get_gb_data_item($key){

		$data = $this->get_gb_data();

		if ($data && isset($data->$key)){
			return $data->$key;
		}

	}

	public function get_gb_id(){
		return $this->get_gb_data_item('id');
	}

	public function get_gb_name(){
		return $this->get_gb_data_item('name');
	}

	/**
	 * Get the highest quality version of a standard image for the game. Typically box art or a poster.
	 * @return string|null Image URL
	 */
	public function get_gb_image(){

		$image_keys_in_size_order = array(
			'super_url',
			'screen_url',
			'medium_url',
			'small_url',
			'thumb_url'
		);

		$image_obj = $this->get_gb_data_item('image');

		foreach ($image_keys_in_size_order as $size){
			if (isset($image_obj->{$size})){

				$image_url = $image_obj->{$size};

				// For some reason GiantBomb's images don't work correctly when accessed over HTTPS, even though the API is providing HTTPS URLs for images.  
				return str_replace('https', 'http', $image_url);

			}
		}

	}

	public function save_gb_id_as_meta(){

		$gb_id = $this->get_gb_id();

		if ($gb_id){

			$meta_key = $this->custom_field_prefix . 'gb_id';

			return update_post_meta($this->ID, $meta_key, $gb_id);

		}

	}

	///////////////
	// Protected //
	///////////////

	abstract protected static function get_gb_endpoint_base();

	abstract protected static function get_gb_field_list();

	////////////
	// Static //
	////////////

	protected static function extract_gb_id_from_url($gb_game_url){

		$url = trim($gb_game_url, '/ ');

		$exploded = explode('/', $url);

		$id = array_pop($exploded);

		return $id;

	}

	public static function fetch_api_data($resource_url){

		$id = static::extract_gb_id_from_url($resource_url);

		// Get API data
		$endpoint = static::get_gb_endpoint_base() . $id;

		$params = array(
			'api_key' => getenv('GIANTBOMB_API_KEY'),
			'format' => 'json',
			'field_list' => implode(',', static::get_gb_field_list())
		);

		$request_url = $endpoint . '?' . http_build_query($params);

		// file_get_contents() would be easy to use here but GiantBomb blocks API requests without a useragent, and setting one up with file_get_contents() is a pain.
		$curl = new Curl;
		$curl->setOpt(CURLOPT_FOLLOWLOCATION, true); // need to follow redirects
		$curl->setUserAgent('AttractModeBot/1.0'); // GiantBomb doesn't allow blank user agents
		$response = $curl->get($request_url);

		if (isset($response->results)){
			return $response->results;
		}

	}

}


