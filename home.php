<?php get_header(); ?>


<!-- Busqueda -->
<div id="blog-search" class="blog-search mt-4 mb-5">
  <form role="search" method="get" action="<?= esc_url(home_url('/')); ?>"
    class="d-flex justify-content-center mx-4 mx-md-0">
    <div class="blog-search__container input-group input-group-lg">
      <button class="blog-search__btn">
        <svg width="30" height="50" class="svg-icon-search">
          <use xlink:href="<?= get_template_directory_uri() ?>/assets/images/sprite.svg#search-glas"></use>
        </svg>
      </button>
      <input type="search" class="blog-search__input form-control" placeholder="Buscar..."
        value="<?= get_search_query(); ?>" name="s" />
    </div>
  </form>
</div>
<section class="blog-posts mt-5">
  <div class="container">
    <div class="blog-posts__container-cards d-grid gap-4 justify-content-center mt-5">
      <?php if (have_posts()): ?>
        <?php while (have_posts()): ?>
          <?php the_post(); ?>
          <article class="">
            <?php
            $data = [
              'url' => get_permalink(),
              'image_url' => has_post_thumbnail() ? get_the_post_thumbnail_url(get_the_ID(), 'medium') : '',
              'title' => get_the_title(),
              'excerpt' => get_the_excerpt(),
            ];
            // Lo incluís y pasás las variables
            set_query_var('card_data', $data);
            get_template_part('template-parts/card-blog');
            ?>
          </article>
        <?php endwhile; ?>
        <?php the_posts_pagination([
          'mid_size' => 2,
          'prev_text' => __('« Anterior', 'textdomain'),
          'next_text' => __('Siguiente »', 'textdomain'),
        ]); ?>
      <?php else: ?>
        <div class="col-12">
          <p>No hay entradas disponibles.</p>
        </div>
      <?php endif; ?>
    </div>
  </div>
</section>

<?php get_footer(); ?>