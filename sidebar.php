<aside class="sidebar">
  <div class="card mb-4 p-3">
    <h5 class="mb-3 acumin-variable-concept">Buscar</h5>
    <?php get_search_form(); ?>
  </div>

  <div class="card mb-4 p-3">
    <h5 class="mb-3">Categorías</h5>
    <ul class="list-unstyled">
      <?php wp_list_categories(['title_li' => '']); ?>
    </ul>
  </div>

  <div class="card mb-4 p-3">
    <h5 class="mb-3">Últimos artículos</h5>
    <ul class="list-unstyled">
      <?php
      $recent_posts = wp_get_recent_posts([
        'numberposts' => 3,
        'post_status' => 'publish',
      ]);

      foreach ($recent_posts as $post): ?>
        <!-- Obtenemos el ID del POST -->
        <?php $post_id = $post['ID']; ?>
        <li class="mb-2">
          <a href="<?php echo get_permalink($post_id); ?>" class="d-flex align-items-center text-decoration-none">
            <?php echo get_the_post_thumbnail($post_id, 'thumbnail', ['class' => 'me-2', 'style' => 'width: 52px; height: auto;']); ?>
            <span><?php echo esc_html($post['post_title']); ?></span>
          </a>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>

</aside>