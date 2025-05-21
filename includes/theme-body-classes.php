<?php
/**
 * Añade clases CSS personalizadas al <body> de la página.
 * @param array $classes Clases actuales del body.
 * @return array Clases modificadas.
 */
function jc_custom_body_class($classes)
{
  // Array de páginas y sus respectivas clases
  $page_classes = [
    'home' => 'page-slug-home',
    'terminos-y-condiciones' => 'page-slug-terminos-y-condiciones',
  ];
  // Asignar clases según el slug de la página
  foreach ($page_classes as $slug => $class) {
    if (is_page($slug))
      $classes[] = $class;
  }

  if (is_home())
    $classes[] = 'page-slug-blog'; // Clase para la página de inicio del blog  
  if (is_single())
    $classes[] = 'single-slug-all'; // Clase para entradas individuales
  if (is_category())
    $classes[] = 'category-slug-all'; // Clase para páginas de categoría

  // Solo si tienes WooCommerce activo
  if (!function_exists('is_woocommerce'))
    return $classes;
  if (is_shop())
    $classes[] = 'woo-slug-shop';
  if (is_product_category())
    $classes[] = 'woo-slug-product-category';
  if (is_product())
    $classes[] = 'woo-slug-product';
  return $classes;
}
add_filter('body_class', 'jc_custom_body_class');