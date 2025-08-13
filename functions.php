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
    'bootstrap-style',
    get_template_directory_uri() . '/assets/vendor/bootstrap/5.3.7/bootstrap.min.css',
    array(), // Sin dependencias
    '5.3.7' // Versión para caché
  );
  /* Swiper css */
  wp_enqueue_style(
    'swiper-bundle-style',
    get_template_directory_uri() . '/assets/vendor/swiper/11.2.7/swiper-bundle.min.css',
    array(), // Sin dependencias
    '11.2.7' // Versión para caché
  );
  /* Roboto font */
  wp_enqueue_style(
    'google-font-roboto-style',
    'https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap',
    array(),
    null
  );

  /* My css */
  $main_css = get_template_directory() . '/dist/css/main.css';
  wp_enqueue_style(
    'jc-main-style',
    get_template_directory_uri() . '/dist/css/main.css',
    array('bootstrap-style'), // Depende de Bootstrap
    file_exists($main_css) ? filemtime($main_css) : null // Evita caché
  );

  /*************************** JS ***************************/
  /* Bootstrap js */
  wp_enqueue_script(
    'bootstrap-bundle-script',
    get_template_directory_uri() . '/assets/vendor/bootstrap/5.3.7/bootstrap.bundle.min.js',
    array(), // Sin dependencias (jQuery no es necesario en Bootstrap 5)
    '5.3.7', // Versión
    true // Cargar en el footer (antes de cerrar </body>)
  );

  /* Swiper js */
  wp_enqueue_script(
    'swiper-bundle-script',
    get_template_directory_uri() . '/assets/vendor/swiper/11.2.7/swiper-bundle.min.js',
    array("bootstrap-bundle-script"), // Sin dependencias
    '11.2.7',
    true // En el footer
  );

  /* My js */
  $main_js = get_template_directory() . '/dist/js/main.js';
  wp_enqueue_script(
    'jc-main-script',
    get_template_directory_uri() . '/dist/js/main.js',
    array('swiper-bundle-script'), // Depende de Swiper
    file_exists($main_js) ? filemtime($main_js) : null, // Evita caché
    true // En el footer
  );

  // Habilita el uso de AJAX en el tema
  wp_localize_script(
    'jc-main-script',
    'frontend_ajax',
    l10n: [
      'url' => admin_url('admin-ajax.php'),
    ]
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


/* AJAX para filtrar testimonios */
function filtrar_testimonios_callback()
{
  // Verifica si la solicitud es AJAX
  $categoria_id = intval($_POST['categoria_id']);

  $args = [
    'post_type' => 'testimonio',
    'posts_per_page' => -1,
    'post_status' => 'publish',
    'orderby' => 'date',
    'order' => 'DESC',
  ];

  // Si es 0 esta seleccionado "Todos los testimonios"
  if ($categoria_id !== 0) {
    $args['tax_query'] = [
      [
        'taxonomy' => 'tipo_de_testimonios',
        'field' => 'term_id',
        'terms' => $categoria_id,
      ]
    ];
  }

  $query = new WP_Query($args);

  ob_start();
  if ($query->have_posts()):
    while ($query->have_posts()):
      $query->the_post();
      $card_youtube_data = get_card_youtube_data(get_the_ID());
      set_query_var('card_youtube_data', $card_youtube_data);
      ?>
      <div class="col-lg-4 mb-4 mb-lg-0 testimonials__video">
        <?php get_template_part('template-parts/card-youtube'); ?>
      </div>
      <?php
    endwhile;
    wp_reset_postdata();
  else:
    echo '<div class="col-12"><p>No se encontraron testimonios.</p></div>';
  endif;

  echo ob_get_clean();
  wp_die();
}
add_action('wp_ajax_filtrar_testimonios', 'filtrar_testimonios_callback');
add_action('wp_ajax_nopriv_filtrar_testimonios', 'filtrar_testimonios_callback');
