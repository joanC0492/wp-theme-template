<!doctype html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="profile" href="https://gmpg.org/xfn/11">
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
  <?php wp_body_open(); ?>

  <!-- Header principal -->
  <header>
    <!-- <div class="container">
      <div class="row">
        <div class="col-12"> -->
    <nav class="navbar navbar-expand-lg py-0">
      <div class="container">
        <a class="navbar-brand" href="<?= esc_url(home_url('/')) ?>">
          <img src="https://avinkape.vtexassets.com/arquivos/logo.png" alt="Logo" width="161" height="46" />
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse pt-lg-2" id="navbarSupportedContent">
          <?php
          wp_nav_menu(
            array(
              'theme_location' => 'header_menu',
              'container' => false,
              'menu_class' => 'navbar-nav ms-auto mb-2 mb-lg-0 navbar-jc',
              'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
              'walker' => new Custom_Header_Walker()
            )
          );
          ?>
          <div class="d-flex"></div>
        </div>
      </div>
    </nav>
    <!-- </div>
      </div>
    </div> -->
  </header>
  <main id="app" class="app">