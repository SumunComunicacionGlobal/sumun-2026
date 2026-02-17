<?php
// Enqueue script into block editor
function smn_hybrid_enqueue_scripts() {
  wp_enqueue_script(
    'sumun-scripts',
    get_template_directory_uri() . '/assets/js/sumun.js',
    array( 'wp-blocks', 'wp-dom-ready', 'wp-edit-post' ),
    null,
    true
  );
}
add_action( 'enqueue_block_editor_assets', 'smn_hybrid_enqueue_scripts' );
 
// Enqueue styles in block editor and front end
function smn_hybrid_enqueue_styles() {
  wp_enqueue_style(
    'sumun-styles',
    get_template_directory_uri() . '/assets/css/sumun.css',
    array(),
    filemtime( get_template_directory() . '/assets/css/sumun.css' )
  );
  add_editor_style( 'assets/css/sumun.css' );
}
add_action( 'enqueue_block_assets', 'smn_hybrid_enqueue_styles' );
