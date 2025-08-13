<!--
Páginas > Todas las páginas
-->
<?php get_header(); ?>

<?php if (have_posts()): ?>
  <?php while (have_posts()): ?>
    <?php the_post(); ?>
    <section class="py-5">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
              <div class="entry-content">
                <?php the_content(); ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  <?php endwhile; else: ?>
  <p><?php esc_html_e('Lo sentimos, no se encontraron publicaciones.'); ?></p>
<?php endif; ?>

<?php get_footer(); ?>