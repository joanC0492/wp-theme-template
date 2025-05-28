<?php
if (!defined('ABSPATH'))
  exit;
/**
 * Devuelve un array con los datos necesarios para el card-blog.
 * @param int|null $post_id Si es null, usa el post actual en el loop.
 * @return array
 */
function get_card_blog_data($post_id = null)
{
  if (!$post_id) {
    $post_id = get_the_ID();
  }
  return [
    'url' => get_permalink($post_id),
    'image_url' => has_post_thumbnail($post_id) ? get_the_post_thumbnail_url($post_id, 'medium') : '',
    'title' => get_the_title($post_id),
    'excerpt' => get_the_excerpt($post_id),
  ];
}
