<?php

function ghost_note_files(){
    wp_enqueue_style('custom_google_fonts','https://fonts.googleapis.com/css2?family=Maven+Pro&display=swap');
    wp_enqueue_style('our-main-styles', get_template_directory_uri() . '/style.css');
    wp_enqueue_script('our-main-js', get_template_directory_uri() . '/index.js',array(jquery), null, true);
}

add_action('wp_enqueue_scripts','ghost_note_files');
