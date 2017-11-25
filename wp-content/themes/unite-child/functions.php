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

function renderTaxonomy($v) {
    return sprintf('<span class="badge">%s</span>', $v->name);
}

function add_extra_stuff_to_film_post($content) {
    global $post;
    if ($post->post_type == 'films') {

        $genre     = array_map('renderTaxonomy', get_the_terms(get_the_ID(), "genre"));
        $countries = array_map('renderTaxonomy', get_the_terms(get_the_ID(), "country"));

        $content .= sprintf('<div><b>Genre: </b>%s</div>', implode("&nbsp;", $genre));
        $content .= sprintf('<div><b>Countries: </b>%s</div>', implode("&nbsp;", $countries));
        $content .= sprintf('<div><b>Ticket Price: </b>$%d</div>', get_post_custom_values('ticket_price', get_the_ID())[0]);
        $content .= sprintf('<div><b>Release Date: </b>%s', get_post_custom_values('release_date', get_the_ID())[0]);
    }
    return $content;
}
add_filter('the_content', 'add_extra_stuff_to_film_post');