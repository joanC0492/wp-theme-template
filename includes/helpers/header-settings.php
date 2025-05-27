<?php
function get_header_settings_data()
{
  if (!function_exists('pods')) {
    return [
      'header_logo' => [],
    ];
  }

  $settings = pods('ajustes_del_sitio');

  if (empty($settings) || is_wp_error($settings)) {
    return [
      'header_logo' => [],
    ];
  }
  $header_logo = $settings->field('header_logo');
  return [
    'header_logo' => [
      'post_title' => $header_logo['post_title'] ?? '',
      'guid' => $header_logo['guid'] ?? '',
    ],
  ];
}