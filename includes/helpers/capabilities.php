<?php
/**
 * Plugin Name: is_page_X capability
 * Description: Grant the current user access to fields or groups based on the ID or slug of the current page being edited. Capability <code>is_page_contact-us</code> will be granted on page with slug <code>contact-us</code>. <code>is_page_123</code> will be granted on page with ID <code>123</code>.
 */
if (is_admin()) {
  /**
   * Para una capacidad que comienza con "is_page_", se le otorga esa capacidad al usuario actual
   * si el slug o ID de la página que se está editando coincide con lo que viene después del prefijo "is_page_".
   * 
   * Por ejemplo:
   *     "is_page_contact-us" se otorgará en la página con el slug "contact-us".
   *     "is_page_123" se otorgará en la página con el ID 123.
   * 
   * @see https://developer.wordpress.org/reference/hooks/map_meta_cap/
   */
  add_filter(
    'map_meta_cap',
    function ($caps, $cap, $user_id, $args) {
      $prefix = 'is_page_';
      $prefix_length = strlen($prefix);

      if (
        $prefix === substr($cap, 0, $prefix_length)
        && array_key_exists('post', $_GET) // Only applies once a new page has been saved and refreshed.
      ) {
        $post_object = get_post(intval($_GET['post']));

        if ('page' === $post_object->post_type) {
          $slug_or_id = substr($cap, $prefix_length);

          if (is_numeric($slug_or_id)) {
            // The capability is providing an ID in the form is_page_123.
            if ($post_object->ID !== intval($slug_or_id)) {
              // If is_page_123 does not match the current page ID being 123, don't allow.
              $caps = ['do_not_allow'];
            } else {
              // If the ID does match, require the user have the capability to edit pages.
              $caps = ['edit_pages'];
            }
          } else {
            // The capability is providing a slug in the form is_page_contact-us.
            if ($post_object->post_name !== $slug_or_id) {
              // If is_page_contact-us does not match the current page slug being contact-us, don't allow.
              $caps = ['do_not_allow'];
            } else {
              // If the slug does match, require the user have the capability to edit pages.
              $caps = ['edit_pages'];
            }
          }
        }
      }

      return $caps;
    },
    10,
    4
  );
  /**
   * Para una capacidad que comienza con "is_not_page_", se otorga la capacidad al usuario actual
   * si el slug o ID de la página que se está editando NO coincide con lo que viene después del prefijo.
   * 
   * Por ejemplo:
   *     "is_not_page_contact-us" se otorgará en todas las páginas EXCEPTO en la que tiene el slug "contact-us".
   *     "is_not_page_123" se otorgará en todas las páginas EXCEPTO en la que tiene el ID 123.
   *
   * Útil para mostrar grupos de campos condicionalmente (por ejemplo, con PODS) en todas las páginas menos una.
   */
  add_filter('map_meta_cap', function ($caps, $cap, $user_id, $args) {
    $prefix = 'is_not_page_';
    $prefix_length = strlen($prefix);

    if (
      $prefix === substr($cap, 0, $prefix_length)
      && array_key_exists('post', $_GET)
    ) {
      $post_object = get_post(intval($_GET['post']));

      if ('page' === $post_object->post_type) {
        $slug_or_id = substr($cap, $prefix_length);

        if (is_numeric($slug_or_id)) {
          if ($post_object->ID === intval($slug_or_id)) {
            $caps = ['do_not_allow'];
          } else {
            $caps = ['edit_pages'];
          }
        } else {
          if ($post_object->post_name === $slug_or_id) {
            $caps = ['do_not_allow'];
          } else {
            $caps = ['edit_pages'];
          }
        }
      }
    }

    return $caps;
  }, 10, 4);

}