<?php
/**
 * Template part for displaying FAQ section with an accordion.
 *
 * @package YourThemeName
 */
add_action('admin_enqueue_scripts', function ($hook) {
  if (strpos($hook, 'pods-settings-ajustes_del_sitio') === false)
    return;

  // CSS personalizado
  wp_enqueue_style(
    'custom-admin-style',
    get_template_directory_uri() . '/assets/css/admin/admin-style.css'
  );
  // JS para acordeones
  wp_enqueue_script(
    'custom-admin-js',
    get_template_directory_uri() . '/assets/js/admin/admin-script.js',
    ['jquery'],
    null,
    true
  );
});