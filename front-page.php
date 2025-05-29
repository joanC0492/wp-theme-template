<?php get_header(); ?>
<?php if (have_posts()): ?>
  <?php while (have_posts()): ?>
    <?php the_post(); ?>
    <?php
    // Obtenemos el ID del post asignado al carousel
    $id = get_the_ID();
    // Obtenemos el ID del post asignado al carousel
    $carousel_id = get_post_meta($id, 'carousel', true);
    // Obtenemos el post del carousel
    $hero_post = !empty($carousel_id) ? get_post($carousel_id) : null;

    /* CPT testimonios */
    $args_testimonios = array(
      'post_type' => 'testimonio',
      'posts_per_page' => -1, // todos los testimonios
      'post_status' => 'publish',
      'orderby' => 'date',
      'order' => 'DESC',
    );
    $testimonios = new WP_Query($args_testimonios);

    /* Page Home - Campo Personalizado */
    $seccion_testimonios = get_post_meta($id, 'seccion_testimonios', false);

    /* Obtenemos las taxonomies tipo_de_testimonios*/
    $tipos_testimonios = get_terms([
      'taxonomy' => 'tipo_de_testimonios',
      'hide_empty' => false,
    ]);

    /* CPT Preguntas Frecuentes */
    $args_faq = array(
      'post_type' => 'preguntas_frecuentes',
      'posts_per_page' => -1, // todos los testimonios
      'post_status' => 'publish',
      'orderby' => 'date',
      'order' => 'DESC',
    );
    $faq = new WP_Query($args_faq);
    /* Page Home - Campo Personalizado */
    $seccion_faq = get_post_meta($id, 'seccion_faq', false);

    /* Últimos 3 posts */
    $args_posts = array(
      'post_type' => 'post',
      'posts_per_page' => 3, // Últimos 3 posts
      'orderby' => 'date',
      'order' => 'DESC',
    );
    $latest_posts = new WP_Query($args_posts);
    ?>

    <div class="front-page">
      <!-- Hero HOME -->
      <?php if ($hero_post): ?>
        <section class="" id="">
          <?php
          $data_carousel = get_hero_carousel_data($hero_post->ID, '_hero_carousel_home');
          set_query_var('data_carousel', $data_carousel);
          get_template_part('template-parts/carousel', 'swiper');
          ?>
        </section>
      <?php endif; ?>

      <!-- Testimonios ALL -->
      <?php if ($testimonios->have_posts()): ?>
        <section class="testimonios pt-5" id="testimonios">
          <div class="container">
            <div class="row">
              <div class="col-12">
                <h2 class="h1 text-center mb-5">Todos los testimonios</h2>
              </div>
              <?php $testimonio_index = 0; ?>
              <?php while ($testimonios->have_posts()): ?>
                <?php $testimonios->the_post(); ?>
                <?php
                $card_youtube_data = get_card_youtube_data(get_the_ID());
                set_query_var('card_youtube_data', $card_youtube_data);
                ?>
                <div class="col-lg-4 mb-4 mb-lg-0 testimonials__video <?= $testimonio_index++ > 0 ? 'mt-5 mt-lg-0' : '' ?>">
                  <?php get_template_part('template-parts/card-youtube'); ?>
                </div>
              <?php endwhile; ?>
            </div>
          </div>
        </section>
      <?php endif; ?>

      <!-- Testimonios HOME -->
      <?php if (!empty($seccion_testimonios) && is_array($seccion_testimonios)): ?>
        <section class="testimonios-seccion py-5" id="testimonios-seccion">
          <div class="container">
            <div class="row">
              <div class="col-12">
                <h2 class="h1 text-center mb-5">Todos los testimonios del Home</h2>
              </div>
              <?php foreach ($seccion_testimonios as $index => $testimonio): ?>
                <?php
                $testimonio_post = get_post($testimonio);
                if (!$testimonio_post)
                  continue;
                ?>
                <?php $card_youtube_data = get_card_youtube_data($testimonio_post->ID); ?>
                <?php set_query_var('card_youtube_data', $card_youtube_data); ?>
                <div class="col-lg-4 mb-4 mb-lg-0 testimonials__video <?= $index > 0 ? 'mt-5 mt-lg-0' : '' ?>">
                  <?php get_template_part('template-parts/card-youtube'); ?>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        </section>
      <?php endif; ?>

      <!-- Categorias Testimonios ALL -->
      <?php if (!empty($tipos_testimonios) && !is_wp_error($tipos_testimonios)): ?>
        <section class="tipos-testimonios py-5" id="tipos-testimonios">
          <div class="container">
            <div class="row">
              <div class="col-12">
                <h2 class="h1 text-center mb-5">Tipos de Testimonios</h2>
              </div>
              <?php foreach ($tipos_testimonios as $term): ?>
                <?php
                // Campos personalizados de la taxonomía
                $titulo = get_term_meta($term->term_id, 'titulo', true);
                $nueva_imagen_id = get_term_meta($term->term_id, 'nueva_imagen', true);
                $nuevo_carousel_ids = get_term_meta($term->term_id, 'nuevo_carousel', false);

                $nueva_imagen_url = '';
                if ($nueva_imagen_id) {
                  $nueva_imagen_src = wp_get_attachment_image_src($nueva_imagen_id, 'medium');
                  $nueva_imagen_url = $nueva_imagen_src ? $nueva_imagen_src[0] : '';
                }
                ?>
                <div class="col-md-6 col-lg-4 mb-4">
                  <div class="card h-100">
                    <?php if ($nueva_imagen_url): ?>
                      <img src="<?= esc_url($nueva_imagen_url); ?>" class="card-img-top" alt="<?= esc_attr($term->name); ?>">
                    <?php endif; ?>
                    <div class="card-body">
                      <h3 class="card-title"><?= esc_html($term->name); ?></h3>
                      <p class="card-text"><strong>Url:</strong> <?= esc_html(get_term_link($term)) ?></p>
                      <p class="card-text"><strong>Slug:</strong> <?= esc_html($term->slug); ?></p>
                      <?php if ($term->description): ?>
                        <p class="card-text"><?= esc_html($term->description); ?></p>
                      <?php endif; ?>
                      <?php if ($titulo): ?>
                        <p class="card-text"><strong>Título:</strong> <?php echo esc_html($titulo); ?></p>
                      <?php endif; ?>
                      <?php if (!empty($nuevo_carousel_ids)): ?>
                        <div class="carousel-gallery mb-2">
                          <strong>Galería:</strong>
                          <div class="d-flex flex-wrap gap-2 mt-2">
                            <?php foreach ($nuevo_carousel_ids as $nuevo_carousel_id): ?>
                              <?php
                              $carousel_imagen_src = wp_get_attachment_image_src($nuevo_carousel_id, 'thumbnail');
                              $carousel_url = $carousel_imagen_src ? $carousel_imagen_src[0] : '';
                              $carousel_title = get_the_title($nuevo_carousel_id);
                              ?>
                              <?php if (!empty($carousel_url)): ?>
                                <img src="<?= esc_url($carousel_url); ?>" alt="<?= esc_attr($carousel_title) ?>"
                                  style="max-width:70px;max-height:70px;object-fit:cover;">
                              <?php endif; ?>
                            <?php endforeach; ?>
                          </div>
                        </div>
                      <?php endif; ?>
                      <a href="<?= esc_url(get_term_link($term)); ?>" class="btn btn-primary mt-2">Ver más</a>
                    </div>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        </section>
      <?php endif; ?>


      <!-- Preguntas Frecuentes ALL -->
      <?php if ($faq->have_posts()): ?>
        <section id="preguntas-frecuentes" class="preguntas-frecuentes py-5">
          <div class="container">
            <div class="row">
              <div class="col-12">
                <h2 class="h1 text-center mb-5">Preguntas Frecuentes</h2>
              </div>
              <div class="col-12 col-lg-8 mx-auto">
                <?php
                $preguntas = [];
                while ($faq->have_posts()):
                  $faq->the_post();
                  $preguntas[] = get_the_ID();
                endwhile;
                wp_reset_postdata();
                set_query_var('preguntas', $preguntas);
                get_template_part('template-parts/faq-section');
                ?>
              </div>
            </div>
          </div>
        </section>
      <?php endif; ?>

      <!-- Preguntas Frecuentes del HOME -->
      <?php if (!empty($seccion_faq) && is_array($seccion_faq)): ?>
        <section id="preguntas-frecuentes-home" class="preguntas-frecuentes-home py-5">
          <div class="container">
            <div class="row">
              <div class="col-12">
                <h2 class="h1 text-center mb-5">Preguntas Frecuentes Home</h2>
              </div>

              <div class="col-12 col-lg-10 mx-auto">
                <?php set_query_var('preguntas', $seccion_faq); ?>
                <?php get_template_part('template-parts/faq-section'); ?>
              </div>

            </div>
          </div>
        </section>
      <?php endif; ?>

      <!-- POSTS -->
      <?php if ($latest_posts->have_posts()): ?>
        <section class="home-posts pt-5" id="home-posts">
          <div class="container">
            <div class="row">
              <div class="col-12">
                <h2 class="h1 text-center mb-5">Últimos 3 Posts</h2>
              </div>
              <div class="col-lg-10 mx-auto">
                <div class="row">
                  <?php while ($latest_posts->have_posts()): ?>
                    <?php $latest_posts->the_post(); ?>
                    <div class="col-lg-4 mb-4 mb-lg-0">
                      <article class="">
                        <?php $data = get_card_blog_data(); ?>
                        <?php set_query_var("card_data", $data); ?>
                        <?php get_template_part('template-parts/card-blog'); ?>
                      </article>
                    </div>
                  <?php endwhile; ?>
                </div>
              </div>
            </div>
          </div>
        </section>
      <?php endif; ?>

    </div>
  <?php endwhile; ?>
<?php endif; ?>
<?php get_footer(); ?>