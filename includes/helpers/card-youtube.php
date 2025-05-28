<?php
function get_card_youtube_data($post_id)
{
  $titulo = get_post_meta($post_id, 'titulo', true);
  $descripcion = get_post_meta($post_id, 'descripcion', true);
  $video = get_post_meta($post_id, 'video', true);
  $video_id = get_youtube_id($video);
  $thumbnail = $video_id ? "https://img.youtube.com/vi/{$video_id}/hqdefault.jpg" : '';
  return [
    'video_id' => $video_id,
    'thumbnail' => $thumbnail,
    'testimonio_titulo' => $titulo,
    'testimonio_descripcion' => $descripcion
  ];
}