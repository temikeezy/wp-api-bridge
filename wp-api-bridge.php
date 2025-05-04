<?php
/**
 * Plugin Name: WP API Bridge
 * Plugin URI: https://github.com/temikolawole/wp-api-bridge
 * Description: Exposes a set of REST API endpoints to allow external frontend applications (such as React, Vue, Angular, static site generators, or mobile apps) to consume WordPress content.
 * Version: 1.0
 * Author: Temi Kolawole
 * Author URI: https://temikolawole.com
 * License: GPL2
 * Text Domain: wp-api-bridge
 * Requires at least: 5.0
 * Tested up to: 5.8
 * Requires PHP: 7.0
 * Stable tag: 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function wp_api_bridge_register_routes() {
    register_rest_route( 'wp-api-bridge/v1', '/posts', array(
        'methods' => 'GET',
        'callback' => 'wp_api_bridge_get_posts',
    ) );

    register_rest_route( 'wp-api-bridge/v1', '/post/(?P<slug>[a-zA-Z0-9_-]+)', array(
        'methods' => 'GET',
        'callback' => 'wp_api_bridge_get_single_post',
    ) );

    register_rest_route( 'wp-api-bridge/v1', '/pages', array(
        'methods' => 'GET',
        'callback' => 'wp_api_bridge_get_pages',
    ) );

    register_rest_route( 'wp-api-bridge/v1', '/page/(?P<slug>[a-zA-Z0-9_-]+)', array(
        'methods' => 'GET',
        'callback' => 'wp_api_bridge_get_single_page',
    ) );

    register_rest_route( 'wp-api-bridge/v1', '/cpt/(?P<custom_post_type>[a-zA-Z0-9_-]+)', array(
        'methods' => ' 'GET',
        'callback' => 'wp_api_bridge_get_custom_post_types',
    ) );

    register_rest_route( 'wp-api-bridge/v1', '/taxonomies', array(
        'methods' => 'GET',
        'callback' => 'wp_api_bridge_get_taxonomies',
    ) );

    register_rest_route( 'wp-api-bridge/v1', '/menus', array(
        'methods' => 'GET',
        'callback' => 'wp_api_bridge_get_menus',
    ) );
}
add_action( 'rest_api_init', 'wp_api_bridge_register_routes' );

function wp_api_bridge_get_posts() {
    $args = array('post_type' => 'post', 'posts_per_page' => -1);
    $query = new WP_Query( $args );
    $posts = array();
    while ( $query->have_posts() ) {
        $query->the_post();
        $posts[] = array(
            'id' => get_the_ID(),
            'slug' => get_post_field( 'post_name', get_the_ID() ),
            'title' => get_the_title(),
            'content' => get_the_content(),
            'excerpt' => get_the_excerpt(),
        );
    }
    return new WP_REST_Response( $posts, 200 );
}

function wp_api_bridge_get_single_post( $data ) {
    $post = get_post_by_slug( $data['slug'] );
    if ( ! $post ) return new WP_REST_Response( 'Post not found', 404 );
    return new WP_REST_Response(array(
        'id' => $post->ID,
        'slug' => $post->post_name,
        'title' => get_the_title($post->ID),
        'content' => get_the_content(null, false, $post),
        'excerpt' => get_the_excerpt($post->ID),
    ), 200 );
}

function wp_api_bridge_get_pages() {
    $args = array('post_type' => 'page', 'posts_per_page' => -1);
    $query = new WP_Query( $args );
    $pages = array();
    while ( $query->have_posts() ) {
        $query->the_post();
        $pages[] = array(
            'id' => get_the_ID(),
            'slug' => get_post_field( 'post_name', get_the_ID() ),
            'title' => get_the_title(),
            'content' => get_the_content(),
            'excerpt' => get_the_excerpt(),
        );
    }
    return new WP_REST_Response( $pages, 200 );
}

function wp_api_bridge_get_single_page( $data ) {
    $page = get_post_by_slug( $data['slug'] );
    if ( ! $page ) return new WP_REST_Response( 'Page not found', 404 );
    return new WP_REST_Response(array(
        'id' => $page->ID,
        'slug' => $page->post_name,
        'title' => get_the_title($page->ID),
        'content' => get_the_content(null, false, $page),
        'excerpt' => get_the_excerpt($page->ID),
    ), 200 );
}

function wp_api_bridge_get_custom_post_types( $data ) {
    $args = array('post_type' => $data['custom_post_type'], 'posts_per_page' => -1);
    $query = new WP_Query( $args );
    $cpts = array();
    while ( $query->have_posts() ) {
        $query->the_post();
        $cpts[] = array(
            'id' => get_the_ID(),
            'slug' => get_post_field( 'post_name', get_the_ID() ),
            'title' => get_the_title(),
            'content' => get_the_content(),
            'excerpt' => get_the_excerpt(),
        );
    }
    return new WP_REST_Response( $cpts, 200 );
}

function wp_api_bridge_get_taxonomies() {
    $taxonomies = get_taxonomies( array(), 'objects' );
    return new WP_REST_Response( $taxonomies, 200 );
}

function wp_api_bridge_get_menus() {
    $menus = wp_get_nav_menus();
    return new WP_REST_Response( $menus, 200 );
}

function get_post_by_slug( $slug ) {
    $args = array('name' => $slug, 'post_type' => 'any', 'post_status' => 'publish', 'numberposts' => 1);
    $posts = get_posts( $args );
    return ! empty( $posts ) ? $posts[0] : null;
}
