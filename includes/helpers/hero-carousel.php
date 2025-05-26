<?php
function get_hero_carousel_data($hero_post_id, $class_suffix)
{
  $hero_title = get_the_title($hero_post_id);
  $hero_carousel = get_post_meta($hero_post_id, 'hero_carousel', false);
  $image_data = [];
  if (is_array($hero_carousel)) {
    foreach ($hero_carousel as $img_id) {
      $url = wp_get_attachment_image_url($img_id, 'full');
      $title = get_the_title($img_id);
      if ($url) {
        $image_data[] = [
          'url' => $url,
          'title' => $title,
        ];
      }
    }
  }
  return [
    'hero_title' => $hero_title,
    'image_data' => $image_data,
    'class_suffix' => $class_suffix
  ];
}