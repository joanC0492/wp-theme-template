<pre>
<?php
$footer_s = get_footer_settings_data();
$numero_whatsapp = $footer_s['numero_whatsapp'];
$mensaje_whatsapp = $footer_s['mensaje_whatsapp'];
$footer_logo = $footer_s['footer_logo'];
$footer_descripcion = $footer_s['footer_descripcion'];
$footer_columnas = $footer_s['footer_columnas'];

$is_libro_reclamaciones = !empty(get_page_by_path('libro-de-reclamaciones'));
?>
</pre>
</main> <!-- -->
<footer id="footer" class="footer">
  <div class="container">
    <div class="row">
      <div class="col-lg-4">
        <div>
          <?php if (!empty($footer_logo['guid'])): ?>
            <a href="<?= esc_url(home_url('/')) ?>" class="footer__logo-figure">
              <img src="<?= esc_url($footer_logo['guid']) ?>" alt="<?= esc_attr($footer_logo['post_title']) ?>"
                width="229" height="99" class="footer__logo-img">
            </a>
          <?php endif; ?>
        </div>
        <?php if (!empty($footer_descripcion)): ?>
          <div class="footer__description lh-2 mt-1">
            <?= wpautop($footer_descripcion) ?>
          </div>
        <?php endif; ?>
      </div>
      <div class="col-lg-8">
        <div class="row">
          <div class="col-lg-3">
            <div class="footer__col footer__informacion text-white-1 acumin-variable-concept-thin lh-2 mt-4">
              <?php if (!empty($footer_columnas["footer_columna1_tilde"])): ?>
                <h4><?= $footer_columnas["footer_columna1_tilde"] ?></h4>
              <?php endif; ?>
              <?php if (!empty($footer_columnas["footer_columna1_contenido"])): ?>
                <?= wpautop($footer_columnas["footer_columna1_contenido"]) ?>
              <?php endif; ?>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="footer__col footer__cirugias text-white-1 acumin-variable-concept-thin lh-2 mt-4">
            </div>
          </div>
          <div class="col-lg-5">
            <div class="footer__col footer__contacto hide-br text-white-1 acumin-variable-concept-thin lh-2 mt-4">
              <?php if ($is_libro_reclamaciones): ?>
                <div class="mt-3">
                  <a href="<?= esc_url(home_url('/libro-de-reclamaciones')) ?>"
                    class="d-flex align-items-center text-decoration-none">
                    <span class="text-white me-1">Libro de reclamaciones</span>
                    <img src="<?= get_template_directory_uri() ?>/assets/images/libro-de-reclamaciones.webp"
                      alt="Icono del libro de reclamaciones" width="39" height="15" />
                  </a>
                </div>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="container text-center">
    <p>&copy; <?php echo date('Y'); ?> Mi sitio web. Todos los derechos reservados.</p>
  </div>
</footer>
<?php if (!empty($numero_whatsapp) || !empty($mensaje_whatsapp)): ?>
  <div class="whatsapp-button">
    <a href="https://api.whatsapp.com/send?phone=<?= esc_html($numero_whatsapp) ?>&text=<?= esc_html($mensaje_whatsapp) ?>"
      target="_blank" rel="noopener noreferrer" class="whatsapp-button__link">
      <svg width="127" height="127" class="whatsapp-button__icon">
        <use xlink:href="<?= esc_url(get_template_directory_uri() . '/assets/images/sprite.svg#whatsapp-float') ?>"></use>
      </svg>
      <div class="whatsapp-button__content text-white hide-br show-lg-br">
        <p class="whatsapp-button__text acumin-variable-concept-bold">¡Agenda tu<br> cita ahora!</p>
        <span class="whatsapp-button__line"></span>
      </div>
    </a>
  </div>
<?php endif; ?>
<?php wp_footer(); ?>
</body>

</html>