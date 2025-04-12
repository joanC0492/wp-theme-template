<?php
/**
 * Custom walker para personalizar la salida del menú en el header.
 * Extiende la clase Walker_Nav_Menu para controlar la estructura del HTML.
 */
class Custom_Header_Walker extends Walker_Nav_Menu
{
  /**
   * Inicia el nivel de submenú.
   *
   * @param string $output Salida HTML.
   * @param int $depth Nivel de profundidad.
   * @param stdClass|null $args Argumentos del menú.
   */
  public function start_lvl(&$output, $depth = 0, $args = null)
  {
    $indent = str_repeat("\t", $depth);
    $output .= "\n$indent<ul class=\"sub-menu\">\n";
  }

  /**
   * Finaliza el nivel de submenú.
   *
   * @param string $output Salida HTML.
   * @param int $depth Nivel de profundidad.
   * @param stdClass|null $args Argumentos del menú.
   */
  public function end_lvl(&$output, $depth = 0, $args = null)
  {
    $indent = str_repeat("\t", $depth);
    $output .= "$indent</ul>\n";
  }

  /**
   * Inicia un elemento del menú.
   *
   * @param string $output Salida HTML.
   * @param WP_Post $item Objeto del ítem del menú.
   * @param int $depth Nivel de profundidad.
   * @param stdClass|null $args Argumentos del menú.
   * @param int $id ID del ítem.
   */
  public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
  {
    // Clases CSS personalizadas
    $classes = empty($item->classes) ? [] : (array) $item->classes;
    $classes[] = 'nav-item'; // Clase general para cada <li>

    $class_names = join(' ', array_filter($classes));
    $class_attr = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

    // Determina si el ítem está activo
    $active_class = in_array('current-menu-item', $classes) ||
      in_array('current_page_item', $classes) ||
      in_array('current_page_parent', $classes)
      ? ' active' : '';

    // Atributos del <a>
    $attributes = '';
    $attributes .= !empty($item->url) ? ' href="' . esc_url($item->url) . '"' : '';
    $attributes .= ' class="nav-link' . $active_class . '"';

    // Abre el <li> y deja el cierre para end_el()
    $output .= sprintf(
      '<li%s><a%s>%s</a>',
      $class_attr,
      $attributes,
      esc_html($item->title)
    );
  }

  /**
   * Finaliza un elemento del menú.
   *
   * @param string $output Salida HTML.
   * @param WP_Post $item Objeto del ítem del menú.
   * @param int $depth Nivel de profundidad.
   * @param stdClass|null $args Argumentos del menú.
   */
  public function end_el(&$output, $item, $depth = 0, $args = null)
  {
    $output .= "</li>\n";
  }
}
