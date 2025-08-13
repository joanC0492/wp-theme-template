<!-- 
 https://avinka.local/tipo-de-testimonios/${slug}

 -->
<?php get_header(); ?>
<?php
$archive_title = 'Taxonomy: ' . single_cat_title('', false);
set_query_var('archive_title', $archive_title);
get_template_part('template-parts/loop-archive');
?>
<?php get_footer(); ?>