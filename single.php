<!-- 
Entradas > Todas las entradas > Posts individuales
https://avinka.local/${slug}
Ejemplo: https://avinka.local/cupiditate-placeat-ad-id-et-quaerat/
-->
<?php get_header(); ?>

<section class="single-post py-5">
  <div class="container">
    <div class="row">
      <div class="col-lg-8">
        <article>
          <h1 class="mb-4 text-center"><?= get_the_title(); ?></h1>
          <?php if (has_post_thumbnail()): ?>
            <div class="row">
              <div class="col-lg-12 mx-auto">
                <img src="<?= get_the_post_thumbnail_url(get_the_ID(), 'full'); ?>" class="w-100 img-fluid mb-4"
                  alt="<?= esc_attr(get_the_title()); ?>">
              </div>
            </div>
          <?php endif; ?>

          <div class="content">
            <?= apply_filters('the_content', get_the_content()); ?>
          </div>
        </article>
      </div>
      <div class="col-lg-4 mt-4 mt-lg-0">
        <?php get_sidebar(); ?>
      </div>
    </div>
  </div>
</section>

<?php get_footer(); ?>