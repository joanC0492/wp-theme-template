<?php
$preguntas = get_query_var('preguntas', []);
if (empty($preguntas) || !is_array($preguntas))
  return;

// Generar un ID único para el acordeón
$accordion_id = 'accordionExample_' . uniqid();
?>

<div class="page-questions__accordion accordion mt-4" id="<?= esc_attr($accordion_id) ?>">
  <?php foreach ($preguntas as $index => $pregunta_id):
    $pregunta_post = get_post($pregunta_id);
    if (!$pregunta_post)
      continue;

    $titulo_pregunta = esc_html($pregunta_post->post_title);
    $contenido_pregunta = apply_filters('the_content', $pregunta_post->post_content);
    $collapse_id = 'collapse' . $index . '_' . $accordion_id;
    ?>
    <div class="page-questions__accordion-item accordion-item mt-3">
      <h2 class="page-questions__accordion-header accordion-header" id="heading<?= $index; ?>"
        style="border-top: 1px solid #00000012;">
        <button
          class="bg-gray-2 text-gray-1 acumin-variable-concept-medium page-questions__accordion-button accordion-button collapsed"
          type="button" data-bs-toggle="collapse" data-bs-target="#<?= $collapse_id ?>" aria-expanded="false"
          aria-controls="<?= $collapse_id ?>">
          <?= $titulo_pregunta ?>
        </button>
      </h2>
      <div id="<?= $collapse_id ?>" class="page-questions__accordion-collape accordion-collapse collapse"
        data-bs-parent="#<?= esc_attr($accordion_id) ?>">
        <div class="accordion-body text-gray-1 acumin-variable-concept"><?= $contenido_pregunta; ?></div>
      </div>
    </div>
  <?php endforeach; ?>
</div>