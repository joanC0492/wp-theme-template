<?php
/**
 * Crea la tabla personalizada para almacenar los IDs de formularios Ninja Forms.
 * Si la tabla ya existe, no realiza cambios.
 *
 * Estructura de la tabla:
 * - id: clave primaria autoincremental
 * - form_id: ID del formulario Ninja Forms
 * - entry_number: número de registro generado (ej: "Nº 000000001-2025")
 * - created_at: marca de tiempo de creación
 */
function create_custom_table()
{
  global $wpdb;
  $table_name = $wpdb->prefix . 'custom_ninja_forms_ids';

  $charset_collate = $wpdb->get_charset_collate();

  $sql = "CREATE TABLE IF NOT EXISTS $table_name (
        id INT AUTO_INCREMENT PRIMARY KEY,
        form_id INT NOT NULL,
        entry_number VARCHAR(20) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) $charset_collate;";

  require_once ABSPATH . 'wp-admin/includes/upgrade.php';
  dbDelta($sql);
}
add_action('init', 'create_custom_table');

/**
 * Genera un ID único para cada envío de formulario Ninja Forms.
 * El ID tiene el formato "Nº 000000001-2025".
 *
 * @param array $form_data Datos del formulario enviado.
 * @return array Datos del formulario con el nuevo ID asignado.
 */
function custom_ninja_forms_generate_id($form_data)
{
  global $wpdb;
  $table_name = $wpdb->prefix . 'custom_ninja_forms_ids';

  // Obtener form_id desde la clave correcta
  $form_id = isset($form_data['id']) ? intval($form_data['id']) : null;

  if (!$form_id) {
    error_log("Error: 'form_id' no está definido en el formulario.");
    return $form_data; // Salir sin modificar nada
  }

  $current_year = date('Y');

  // Obtener el último número registrado para este año y formulario
  $last_entry = $wpdb->get_var(
    $wpdb->prepare(
      "SELECT entry_number FROM $table_name WHERE form_id = %d AND entry_number LIKE %s ORDER BY id DESC LIMIT 1",
      $form_id,
      "%-$current_year"
    )
  );

  // Inicializar número
  $next_number = '000000001';

  if ($last_entry) {
    if (preg_match('/Nº (\d+)-(\d{4})/', $last_entry, $matches)) {
      $next_number = str_pad((int) $matches[1] + 1, 9, '0', STR_PAD_LEFT);
    }
  }

  $new_id = "Nº $next_number-$current_year";

  // Insertar en la base de datos
  $result = $wpdb->insert(
    $table_name,
    [
      'form_id' => $form_id,
      'entry_number' => $new_id,
      'created_at' => current_time('mysql')
    ]
  );
  if ($result === false) {
    error_log("Error en la inserción: " . $wpdb->last_error);
  }
  // Asignar el valor al campo oculto
  foreach ($form_data['fields'] as &$field) {
    if ($field['key'] === 'numero_registro') {
      $field['value'] = $new_id;
      break;
    }
  }
  return $form_data;
}
add_filter('ninja_forms_submit_data', 'custom_ninja_forms_generate_id');