<?php

class Site extends TimberSite {

	function __construct()
	{
		add_theme_support( 'post-formats' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'menus' );
		add_filter( 'timber_context', array( $this, 'add_to_context' ) );
		add_filter( 'get_twig', array( $this, 'add_to_twig' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_javascript' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_stylesheets' ) );
		parent::__construct();
	}

	/**
	 * Add global template variables
	 * @param [array] $context [Global template variables array]
	 */
	public function add_to_context( $context )
	{
		// Add menu to context
		$context['main_menu'] = new TimberMenu('Main Navigation Menu');
		$context['footer_menu'] = new TimberMenu('Main Footer Menu');

		$context['site'] = $this;

		return $context;
	}

	/**
	 * Add custom functions to Twig
	 */
	public function add_to_twig( $twig )
	{
		$twig->addExtension( new Twig_Extension_StringLoader() );
		$twig->addFilter( 'myfoo', new Twig_Filter_Function( 'myfoo' ) );
		return $twig;
	}

	/**
	 * Enqueue the site scripts
	 */
	public function enqueue_javascript()
	{
		wp_register_script( 'main', get_template_directory_uri() . '/theme_dist/main.js', array('jquery'), '', true );
		wp_localize_script( 'main', 'wpObject', array(
			'ajaxUrl' => admin_url('admin-ajax.php'),
			'themeDir' => get_template_directory_uri(),
		) );
		wp_enqueue_script( 'main' );
	}

	/**
	 * Enqueue the site styles
	 */
	public function enqueue_stylesheets()
	{
		wp_enqueue_style( 'main', get_template_directory_uri() . '/theme_dist/main.css' );
	}

}