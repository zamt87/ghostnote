<?php

function ghost_note_post_types(){
    register_post_type('note',
        array(
            'supports' => array(
                'title',
                'editor',
                'author'
            ),
            'taxonomies' => array(
                'category'
            ),
            'public' => true,
            'labels' => array(
                'name' => 'Notes',
                'add_new_items' => 'Add New Notes',
                'edit_item' => 'Edit Note',
                'all_items' => 'All Notes',
                'singular_name' => 'Note'
            ),
            'menu_icon' => 'dashicons-welcome-write-blog'
        )
    );
}

add_action('init','ghost_note_post_types');