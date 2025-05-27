<!doctype html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="profile" href="https://gmpg.org/xfn/11">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <?php wp_head(); ?>
</head>

<body <?php body_class("font-roboto-400"); ?>>
  <?php wp_body_open(); ?>

  <?php
  $header_s = get_header_settings_data();
  // Si no se obtiene el logo, se usa un array vacío
  $header_logo = $header_s['header_logo'];

  $locations = get_nav_menu_locations(); // Obtiene todas las ubicaciones
  $menu_id = $locations['header_menu'];  // Obtiene el ID del menú asignado a 'header_menu'
  $menu_items = wp_get_nav_menu_items($menu_id); // Ahora sí, trae los ítems  
  $menu_tree = [];
  foreach ($menu_items as $item)
    $menu_tree[$item->menu_item_parent][] = $item;
  ?>

  <!-- Header principal -->
  <header id="header" class="header position-relative">
    <?php
    render_bem_menu(
      $menu_tree,
      $header_logo
    );
    ?>
  </header>
  <main id="app" class="app">