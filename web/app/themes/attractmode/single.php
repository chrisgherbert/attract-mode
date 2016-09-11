<?php
/**
 * The Template for displaying all single posts
 *
 * Methods for TimberHelper can be found in the /lib sub-directory
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since    Timber 0.1
 */

$context = Timber::get_context();

if ($post){
	$context['post'] = Timber::get_post($post->ID, AmvConfig::$post_type_classes);
}

// $post = Timber::query_post(false, AmvConfig::$post_type_classes);
// $context['post'] = $post;
$context['comment_form'] = TimberHelper::get_comment_form();

if ( post_password_required( $post->ID ) ) {
	Timber::render( 'single-password.twig', $context );
} else {
	Timber::render( array( 'single-' . $post->ID . '.twig', 'single-' . $post->post_type . '.twig', 'single.twig' ), $context );
}
