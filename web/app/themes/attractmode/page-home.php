<?php
/**
 *  Template Name: Home Page
 */

$context = Timber::get_context();
$post = Timber::get_post();
$context['post'] = $post;

$context['videos'] = Timber::get_posts(
	array(
		'post_type' => 'video',
		'posts_per_page' => 200
	),
	AmvConfig::$post_type_classes
);

Timber::render( array( 'page-' . $post->post_name . '.twig', 'page.twig' ), $context, false, TimberLoader::CACHE_NONE );