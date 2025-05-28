<?php
/**
 * Extrae el ID de un video de YouTube a partir de su URL.
 *
 * @param string $url La URL del video de YouTube.
 * @return string|null El ID del video o null si no se encuentra.
 */
function get_youtube_id($url)
{
  preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $url, $matches);
  return $matches[1] ?? null;
}