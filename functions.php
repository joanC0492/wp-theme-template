<?php
/* Garantiza que el archivo solo pueda ser utilizado dentro del entorno de WordPress */
if (!defined('ABSPATH'))
  die();

/***************************EDITOR_CLASICO***************************/
// add_filter('use_block_editor_for_post', '__return_false', 10);

/***************************INCLUDES***************************/
/***************************SHORTCODES***************************/
// se ejecuta solo después de que el tema esté cargado
add_action('after_setup_theme', function () {
  require_once get_template_directory() . '/includes/index.php';
  require_once get_template_directory() . '/shortcodes/index.php';
});

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
  /* Swiper css */
  wp_enqueue_style(
    'swiper-11.2.7-style',
    get_template_directory_uri() . '/assets/css/swiper-bundle.min.css',
    array(), // Sin dependencias
    filemtime(get_template_directory() . '/assets/css/swiper-bundle.min.css') // Evita caché
  );
  /* Roboto font */
  wp_enqueue_style(
    'google-font-roboto-style',
    'https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap',
    array(),
    null
  );

  /* My css */
  $main_css = get_template_directory() . '/assets/css/main.css';
  wp_enqueue_style(
    'jc-main-style',
    get_template_directory_uri() . '/assets/css/main.css',
    array('bootstrap-5.3.5-style'), // Depende de Bootstrap
    file_exists($main_css) ? filemtime($main_css) : null // Evita caché
  );
  /*************************** JS ***************************/
  wp_enqueue_script(
    'bootstrap-5.3.5-bundle',
    'https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js',
    array(), // Sin dependencias (jQuery no es necesario en Bootstrap 5)
    '5.3.5', // Versión
    true // Cargar en el footer (antes de cerrar </body>)
  );

  /* Swiper js */
  wp_enqueue_script(
    'swiper-11.2.7-script',
    get_template_directory_uri() . '/assets/js/swiper-bundle.min.js',
    array("bootstrap-5.3.5-bundle"), // Sin dependencias
    filemtime(get_template_directory() . '/assets/js/swiper-bundle.min.js'),
    true // En el footer
  );

  /* My js */
  $main_js = get_template_directory() . '/assets/js/main.js';
  wp_enqueue_script(
    'jc-main-script',
    get_template_directory_uri() . '/assets/js/main.js',
    array('swiper-11.2.7-script'), // Depende de Swiper
    file_exists($main_js) ? filemtime($main_js) : null, // Evita caché
    true // En el footer
  );
}
add_action('wp_enqueue_scripts', 'theme_assets', 5);

function init_template()
{
  // WordPress maneja automáticamente la etiqueta <title>
  add_theme_support('title-tag');
  // Habilita imágenes destacadas en entradas y páginas
  add_theme_support('post-thumbnails');
  // Usa HTML5 limpio para formularios, comentarios, galerías, scripts, etc.
  add_theme_support(
    'html5',
    array(
      'search-form',
      'comment-form',
      'comment-list',
      'gallery',
      'caption',
      'script',
      'style'
    )
  );
  // ✅ Hace que videos y contenidos incrustados se adapten a móviles automáticamente.
  add_theme_support('responsive-embeds');


  // Habilita la opcion 'Menús'
  // Apariencia > Menús
  // En Apariencia > Menús podés crear un menú y asignarlo a “Menú Header”.
  register_nav_menus(
    array(
      'header_menu' => 'Menú Header',
    )
  );
}
add_action('after_setup_theme', 'init_template');


// Permite mostrar 3 Elementos en el home.php
function custom_posts_per_page_home($query)
{
  if ($query->is_home() && $query->is_main_query()) {
    $query->set('posts_per_page', 3);
  }
}
add_action('pre_get_posts', 'custom_posts_per_page_home');
// Permite mostrar 6 Elementos en el category y el search
function custom_posts_per_page_category($query)
{
  if (($query->is_category() || $query->is_search()) && $query->is_main_query()) {
    $query->set('posts_per_page', 6);
  }
}
add_action('pre_get_posts', 'custom_posts_per_page_category');
