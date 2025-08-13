<!--
Se buscas en las entradas: (Entradas > Todas las entradas)
https://avinka.local/?s=cupiditate
-->
<?php get_header(); ?>
<?php
$archive_title = 'Resultados de búsqueda: "' . get_search_query() . '"';
set_query_var('archive_title', $archive_title);
get_template_part('template-parts/loop-archive');
?>
<?php get_footer(); ?>