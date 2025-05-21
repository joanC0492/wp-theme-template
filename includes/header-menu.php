<?php
function render_bem_menu($menu_tree, $logo_header)
{
  function build_menu($parent_id, $menu, $depth = 0)
  {
    if (!isset($menu[$parent_id]))
      return '';

    $output = '<ul class="menu__list' . ($depth > 0 ? ' menu__list--submenu lvl-' . $depth : '') . '">';
    foreach ($menu[$parent_id] as $item) {
      $has_children = isset($menu[$item->ID]);
      $is_active = in_array('current-menu-item', $item->classes) ? ' menu__item--active' : '';
      $output .= '<li class="menu__item' . ' menu__item--lvl-' . ($depth + 1) . ($has_children ? ' menu__item--has-children' : '') . $is_active . '">';
      $output .= '<a href="' . esc_url($item->url) . '" class="menu__link">' . esc_html($item->title) . '</a>';

      if ($has_children) {
        $output .= '<button class="menu__toggle" aria-expanded="false" aria-label="Toggle submenu">';
        $output .= '  <svg width="28" height="28" class="d-lg-none">';
        $output .= '    <use xlink:href="' . get_template_directory_uri() . '/assets/images/sprite.svg#arrow-right"></use>';
        $output .= '  </svg>';
        $output .= '  <svg width="28" height="28" class="d-none d-lg-inline">';
        $output .= '    <use xlink:href="' . get_template_directory_uri() . '/assets/images/sprite.svg#arrow-down"></use>';
        $output .= '  </svg>';
        $output .= '</button>';

        $output .= build_menu($item->ID, $menu, $depth + 1);
      }
      $output .= '</li>';
    }
    $output .= '</ul>';
    return $output;
  }

  echo '<div id="menu-main">';
  echo '  <nav class="menu navbar navbar-expand-lg" aria-label="Main navigation">';
  echo '    <div class="container-xxl">';
  echo '      <a class="navbar-brand py-3" href="' . esc_url(home_url('/')) . '">';
  echo '        <img src="' . esc_url($logo_header['guid']) . '" alt="' . esc_attr($logo_header['post_title']) . '" class="img-fluid" width="156" />';
  echo '      </a>';
  echo '      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContentMobile" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>';
  echo '      <div class="collapse navbar-collapse" id="navbarSupportedContentMobile">';
  echo build_menu(0, $menu_tree); // Usa $menu_tree que ya tienes armado
  echo '      </div>';
  echo '    </div>';
  echo '  </nav>';
  echo '</div>';
}