<!-- 
Entradas > Categorías > Posts individuales
https://avinka.local/category/${slug}
Ejemplo:
  https://avinka.local/category/categoria-01/
-->
<?php get_header(); ?>
<?php
$archive_title = 'Categoría: ' . single_cat_title('', false);
set_query_var('archive_title', $archive_title);
get_template_part('template-parts/loop-archive');
?>
<?php get_footer(); ?>