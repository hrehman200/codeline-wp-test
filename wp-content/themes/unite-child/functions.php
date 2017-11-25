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