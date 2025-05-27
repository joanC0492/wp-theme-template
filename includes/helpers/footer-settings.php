<?php
function get_footer_settings_data()
{
  if (!function_exists('pods')) {
    return [
      'numero_whatsapp' => '',
      'mensaje_whatsapp' => '',
      'footer_logo' => [],
      'footer_descripcion' => '',
      'footer_columnas' => [],
    ];
  }

  $settings = pods('ajustes_del_sitio');

  if (empty($settings) || is_wp_error($settings)) {
    return [
      'numero_whatsapp' => '',
      'mensaje_whatsapp' => '',
      'footer_logo' => [],
      'footer_descripcion' => '',
      'footer_columnas' => [],
    ];
  }
  $footer_logo = $settings->field('footer_logo');
  return [
    'numero_whatsapp' => $settings->field('boton_whatsapp_cta') ?? '',
    'mensaje_whatsapp' => $settings->field('boton_whatsapp_texto') ?? '',
    'footer_logo' => [
      'post_title' => $footer_logo['post_title'] ?? '',
      'guid' => $footer_logo['guid'] ?? '',
    ],

    'footer_descripcion' => $settings->field('footer_descripcion') ?? '',
    'footer_columnas' => [
      'footer_columna1_tilde' => $settings->field('footer_columna1_tilde') ?? '',
      'footer_columna1_contenido' => $settings->field('footer_columna1_contenido') ?? ''
    ],
  ];
}
