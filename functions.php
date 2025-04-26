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

  /* My js */
  wp_enqueue_script(
    'jc-main-script',
    get_template_directory_uri() . '/assets/js/main.js',
    array('bootstrap-5.3.5-bundle'), // Depende de Bootstrap
    filemtime(get_template_directory() . '/assets/js/main.js'),
    true // En el footer
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



// 
// 
// 
/**
 * Plugin Name: is_page_X capability
 * Description: Grant the current user access to fields or groups based on the ID or slug of the current page being edited. Capability <code>is_page_contact-us</code> will be granted on page with slug <code>contact-us</code>. <code>is_page_123</code> will be granted on page with ID <code>123</code>.
 */

/**
 * For a capability starting with "is_page_", grant the capability to the current user
 * if the slug or ID of the currently viewed page is the same as whatever comes after the "is_page_" prefix.
 * 
 * For example:
 *     "is_page_contact-us" will be granted on page with slug "contact-us".
 *     "is_page_123" will be granted on page with ID 123.
 * 
 * @see https://developer.wordpress.org/reference/hooks/map_meta_cap/
 */
add_filter(
  'map_meta_cap',
  function ($caps, $cap, $user_id, $args) {
    $prefix = 'is_page_';
    $prefix_length = strlen($prefix);

    if (
      $prefix === substr($cap, 0, $prefix_length)
      && array_key_exists('post', $_GET) // Only applies once a new page has been saved and refreshed.
    ) {
      $post_object = get_post(intval($_GET['post']));

      if ('page' === $post_object->post_type) {
        $slug_or_id = substr($cap, $prefix_length);

        if (is_numeric($slug_or_id)) {
          // The capability is providing an ID in the form is_page_123.
          if ($post_object->ID !== intval($slug_or_id)) {
            // If is_page_123 does not match the current page ID being 123, don't allow.
            $caps = ['do_not_allow'];
          } else {
            // If the ID does match, require the user have the capability to edit pages.
            $caps = ['edit_pages'];
          }
        } else {
          // The capability is providing a slug in the form is_page_contact-us.
          if ($post_object->post_name !== $slug_or_id) {
            // If is_page_contact-us does not match the current page slug being contact-us, don't allow.
            $caps = ['do_not_allow'];
          } else {
            // If the slug does match, require the user have the capability to edit pages.
            $caps = ['edit_pages'];
          }
        }
      }
    }

    return $caps;
  },
  10,
  4
);