<?php
/* Garantiza que el archivo solo pueda ser utilizado dentro del entorno de WordPress */
if (!defined('ABSPATH'))
  die();

/***************************EDITOR_CLASICO***************************/
// add_filter('use_block_editor_for_post', '__return_false', 10);

/***************************INCLUDES***************************/
require_once get_template_directory() . '/includes/index.php';
/***************************SHORTCODES***************************/
// require_once get_template_directory() . '/shortcodes/index.php';

function theme_assets()
{
  /***************************CSS***************************/
  /* Bootstrap css */
  wp_enqueue_style(
    'bootstrap-5.3.5-style',
    'https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css',
    array(), // Sin dependencias
    '5.3.5' // Versión para caché
  );

  /* My css */
  wp_enqueue_style(
    'jc-main-style',
    get_template_directory_uri() . '/assets/css/main.css',
    array('bootstrap-5.3.5-style'), // Depende de Bootstrap
    filemtime(get_template_directory() . '/assets/css/main.css') // Evita caché
  );
  /*************************** JS ***************************/
  wp_enqueue_script(
    'bootstrap-5.3.5-bundle',
    'https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js',
    array(), // Sin dependencias (jQuery no es necesario en Bootstrap 5)
    '5.3.5', // Versión
    true // Cargar en el footer (antes de cerrar </body>)
  );

}
add_action('wp_enqueue_scripts', 'theme_assets', 5);



// // JS
// wp_enqueue_script(
//   'script',
//   get_stylesheet_directory_uri() . '/assets/js/script.js',
//   array('jquery'),
//   '1.0.0',
//   true
// );
// // Font Awesome
// wp_enqueue_style(
//   'font-awesome',
//   'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css',
//   array(),
//   '6.0.0-beta3',
//   'all'
// );
// // Google Fonts
// wp_enqueue_style(
//   'google-fonts',
//   'https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap',
//   array(),
//   null,
//   'all'
// );


function init_template()
{
  // Agrega el titulo desde el admin wordpress
  add_theme_support('title-tag');
  // Agrega la opcion de imagen destacada
  add_theme_support('post-thumbnails');

  // Habilita la opcion 'Menús'
  // Apariencia > Menús
  register_nav_menus(
    array(
      'header_menu' => 'Menú Header',
    )
  );
}
add_action('after_setup_theme', 'init_template');