<?php
$card_youtube_data = get_query_var('card_youtube_data', []);
$video_id = $card_youtube_data['video_id'] ?? '';
$thumbnail = $card_youtube_data['thumbnail'] ?? '';
$testimonio_titulo = $card_youtube_data['testimonio_titulo'] ?? '';
$testimonio_descripcion = $card_youtube_data['testimonio_descripcion'] ?? '';
if (empty($video_id))
  return;
?>
<div class="card-youtube testimonials__card">
  <div class="card-youtube__video youtube-lazy" data-id="<?= esc_attr($video_id); ?>">
    <img src="<?= esc_url($thumbnail) ?>" class="card-youtube__thumbnail img-fluid" loading="lazy"
      alt="Video testimonial" />
    <div class="card-youtube__play play-button">
      <img src="<?= get_template_directory_uri() . '/assets/images/icon-button-testimonio.webp' ?>"
        alt="Icono de Boton Play" width="104" height="104" class="card-youtube__play-button">
    </div>
  </div>
  <div class=" card-youtube__info lh-sm mt-2">
    <?php if (!empty($testimonio_titulo)): ?>
      <p class="card-youtube__title acumin-variable-concept-bold text-blue-1"><?= esc_html($testimonio_titulo) ?></p>
    <?php endif; ?>
    <?php if (!empty($testimonio_descripcion)): ?>
      <p class="card-youtube__desc acumin-variable-concept-bold"><?= esc_html($testimonio_descripcion) ?></p>
    <?php endif; ?>
  </div>
</div>