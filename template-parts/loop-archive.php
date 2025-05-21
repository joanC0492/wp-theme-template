<?php
$archive_title = get_query_var('archive_title');
?>
<section class="search-results py-5">
  <div class="container">
    <div class="row">
      <div class="col-lg-8">
        <h1 class="mb-4 text-center"><?= esc_html($archive_title); ?></h1>
        <div class="search-results__container-cards d-grid gap-4 justify-content-center">
          <?php if (have_posts()): ?>
            <?php while (have_posts()):
              the_post(); ?>
              <article>
                <?php
                $data = [
                  'url' => get_permalink(),
                  'image_url' => has_post_thumbnail() ? get_the_post_thumbnail_url(get_the_ID(), 'medium') : '',
                  'title' => get_the_title(),
                  'excerpt' => get_the_excerpt(),
                ];
                set_query_var('card_data', $data);
                get_template_part('template-parts/card-blog');
                ?>
              </article>
            <?php endwhile; ?>
            <?php
            the_posts_pagination([
              'mid_size' => 2,
              'prev_text' => __('« Anterior', 'textdomain'),
              'next_text' => __('Siguiente »', 'textdomain'),
              'screen_reader_text' => 'Navegación de entradas',
            ]);
            ?>
          <?php else: ?>
            <div class="col-12 text-center">
              <p>No se encontraron resultados.</p>
            </div>
          <?php endif; ?>
        </div>
      </div>
      <div class="col-lg-4 mt-4 mt-lg-0">
        <?php get_sidebar(); ?>
      </div>
    </div>
  </div>
</section>