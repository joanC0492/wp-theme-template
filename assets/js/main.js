(() => {
  const setActiveMenuItem = () => {
    const links = document.querySelectorAll(
      ".menu-item-has-children > .nav-link"
    );
    links.forEach((link) => {
      // Inicializa atributos ARIA
      link.setAttribute("aria-expanded", "false");
      const submenu = link.nextElementSibling;
      if (submenu && submenu.classList.contains("sub-menu"))
        submenu.setAttribute("aria-hidden", "true");

      link.addEventListener("click", (e) => {
        // Solo prevenir el default si el href es #0
        if (link.getAttribute("href") === "#0") e.preventDefault();

        // link ---------> A.nav-link
        const parentItem = link.closest(".menu-item"); // LI
        const currentSubMenu = link.nextElementSibling; // UL.sub-menu

        // Si ya está abierto, lo cerramos
        const isOpen = currentSubMenu.classList.contains("open"); // FALSE

        // Cerrar otros submenús del mismo nivel
        const siblingItems = Array.from(parentItem.parentElement.children);
        siblingItems.forEach((item) => {
          // Si el "item" es disinto al padre que acabamos de clickear y el "item" tiene submenú
          if (
            item !== parentItem &&
            item.classList.contains("menu-item-has-children")
          ) {
            // Cerrar el submenú
            const sub = item.querySelector(".sub-menu");
            const toggleLink = item.querySelector(".nav-link");
            if (sub && sub.classList.contains("open")) {
              sub.classList.remove("open");
              toggleLink.setAttribute("aria-expanded", "false");
              sub.setAttribute("aria-hidden", "true");
            }
          }
        });

        // Alternar estado del actual
        if (!isOpen) {
          currentSubMenu.classList.add("open");
          link.setAttribute("aria-expanded", "true");
          currentSubMenu.setAttribute("aria-hidden", "false");
        } else {
          currentSubMenu.classList.remove("open");
          link.setAttribute("aria-expanded", "false");
          currentSubMenu.setAttribute("aria-hidden", "true");
        }
      });
    });
  };

  const initDOMReady = () => {
    console.log("DOM Ready!");
    setActiveMenuItem();
  };

  document.addEventListener("DOMContentLoaded", initDOMReady);
})();
