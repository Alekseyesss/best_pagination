<?php
get_template_part('Pagination');
add_action('wp_enqueue_scripts', 'add_pag_scripts');

function add_pag_scripts()
{
  wp_enqueue_script('newscript', get_stylesheet_directory_uri() . '/main.js');
  wp_localize_script('newscript', 'pag_obj_js', [
    'admin_url' => admin_url('admin-ajax.php'),
    'nonce' => wp_create_nonce('text-nonce-text'),
  ]);
}
