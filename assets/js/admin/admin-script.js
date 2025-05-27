// Función para filtrar los campos de Pods
jQuery(document).ready(function ($) {
  const searchInput = `
    <div style="margin: 20px 0;">
      <input type="text" id="pods-search" placeholder="Buscar campo..." style="padding: 8px; font-size: 16px;">
    </div>
  `;
  $("div[id^='pods-settings-group-']").first().before(searchInput);

  $("#pods-search").on("input", function () {
    const search = $(this).val().toLowerCase();

    $('div[id^="pods-settings-group-"]').each(function () {
      let group = $(this);
      let matched = false;

      group.find("tr.pods-field__container").each(function () {
        const label = $(this)
          .find("label.pods-form-ui-label")
          .text()
          .toLowerCase();
        if (label.includes(search)) {
          $(this).show();
          matched = true;
        } else {
          $(this).hide();
        }
      });

      // Mostrar u ocultar el grupo completo según si hay coincidencias
      if (search.length > 0) {
        group.find(".form-table").show(); // Mostrar tabla para mostrar campos encontrados
        group.show(); // Mostrar grupo
      } else {
        // Restaurar visibilidad según localStorage
        const groupId = group.attr("id");
        if (openGroups.includes(groupId)) {
          group.find(".form-table").show();
        } else {
          group.find(".form-table").hide();
        }
      }
    });
  });
});

// Accordeon para los grupos de Pods
jQuery(document).ready(function ($) {
  const storageKey = "podsGroupsOpen";
  let openGroups = JSON.parse(localStorage.getItem(storageKey)) || [];

  // Esconde todas las tablas por defecto
  $("div[id^='pods-settings-group-'] .form-table").each(function () {
    const groupId = $(this)
      .closest("div[id^='pods-settings-group-']")
      .attr("id");
    if (openGroups.includes(groupId)) {
      $(this).show();
    } else {
      $(this).hide();
    }
  });

  // Manejador de clic en los títulos de los grupos
  $("div[id^='pods-settings-group-'] > h2")
    .css("cursor", "pointer")
    .on("click", function () {
      const groupDiv = $(this).parent();
      const groupId = groupDiv.attr("id");
      const table = groupDiv.find(".form-table");

      table.toggle();

      // Actualizar localStorage
      if (table.is(":visible")) {
        if (!openGroups.includes(groupId)) {
          openGroups.push(groupId);
        }
      } else {
        openGroups = openGroups.filter((id) => id !== groupId);
      }
      localStorage.setItem(storageKey, JSON.stringify(openGroups));
    });
});
