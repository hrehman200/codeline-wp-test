<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 25/11/2017
 * Time: 2:35 PM
 */

add_action( 'wp_enqueue_scripts', 'enqueue_parent_styles' );

function enqueue_parent_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );
}

function getLatestFilms() {
    $films = get_posts([
        'post_type' => 'films',
        'post_status' => 'publish',
        'numberposts' => 5,
        'order'    => 'DESC'
    ]);

    $html = '<ul>';

    foreach($films as $film) {
        $html .= sprintf('<li><a href="%s">%s</a></li>', get_post_permalink($film->ID), $film->post_title);
    }
    $html .= '</ul>';

    return $html;
}
add_shortcode('latestfilms', 'getLatestFilms');