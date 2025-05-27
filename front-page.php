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
    ?>

    <div class="front-page">
      <?php if ($hero_post): ?>
        <section class="" id="">
          <?php
          $data_carousel = get_hero_carousel_data($hero_post->ID, '_hero_carousel_home');
          set_query_var('data_carousel', $data_carousel);
          get_template_part('template-parts/carousel', 'swiper');
          ?>
        </section>
      <?php endif; ?>

      <section class="" id="">
        
      </section>
    </div>
  <?php endwhile; ?>
<?php endif; ?>
<?php get_footer(); ?>