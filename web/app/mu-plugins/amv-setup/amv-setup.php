<?php
/**
 * Plugin Name: Attract Mode Video Setup
 * Version: 1.0
 * Description: Custom Post Types, Taxonomies declarations, Timber classes for content types, etc
 * Author: Chris herbert
 * Author URI: http://chrisgherbert.com
 * Text Domain: bac-cpt
 * Domain Path: /languages
 * @package Bac-cpt
 */

if (!class_exists('Timber\Timber')){
	die("Timber is required for this plugin to work properly.");
}

function bac_cpt_load_files(){

	$files = array(
		'setup/content-creation-hooks.php',
		'setup/post-types.php',
		'setup/custom-fields.php',
		'setup/posts-to-posts.php',
		'setup/taxonomies.php',
		'classes/AmvConfig.php',
		'classes/AmvResource.php',
		'classes/AmvGiantBombResource.php',
		'classes/AmvGame.php',
		'classes/AmvSystem.php',
		'classes/AmvVideo.php',
		'classes/AmvRelease.php',
		'classes/AmvReleaseConnectionCreator.php',
	);

	if ($files) {
		foreach ($files as $file){
			require_once($file);
		}
	}

}

function bac_cpt_init(){

	if (file_exists('vendor/autoload.php')){
		require_once('vendor/autoload.php');
	}

	bac_cpt_load_files();

}

bac_cpt_init();