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
</aside>