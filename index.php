<!-- 
  All - plantilla "universal"
-->
<?php get_header(); ?>

<?php if (have_posts()):
  while (have_posts()):
    the_post(); ?>
    <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
      <header class="entry-header">
        <h1 class="entry-title"><?php the_title(); ?></h1>
      </header>
      <div class="entry-content">
        <?php the_content(); ?>
      </div>
    </div>
  <?php endwhile; else: ?>
  <p><?php esc_html_e('Lo sentimos, no se encontraron publicaciones.'); ?></p>
<?php endif; ?>

<?php get_footer(); ?>