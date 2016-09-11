<?php

class AmvSystem extends AmvGiantBombResource {

	public $custom_field_prefix = 'amv_system_';

	///////////////
	// Protected //
	///////////////

	protected static function get_gb_endpoint_base(){
		return 'https://www.giantbomb.com/api/platform/';
	}

	protected static function get_gb_field_list(){
		return array(
			'abbreviation',
			'company',
			'date_added',
			'date_last_updated',
			'deck',
			'description',
			'id',
			'image',
			'install_base',
			'name',
			'original_price',
			'release_date',
			'site_detail_url',
		);
	}

}