(() => {
  const toggleStickyHeader = () => {
    const header = document.querySelector("#header");
    if (!header) return; // Evita errores si no existe

    const isSticky = window.scrollY > 36;
    const alreadySticky = header.classList.contains("sticky-top");
    // Si el header esta scroll y no tiene class sticky, agregarlo
    if (isSticky && !alreadySticky) {
      header.classList.add("sticky-top", "shadow", "bg-white-1");
      header.classList.remove("position-relative");
    } else if (!isSticky && alreadySticky) {
      // Si el header no es sticky y ya tiene la clase, eliminarla
      header.classList.remove("sticky-top", "shadow", "bg-white-1");
      header.classList.add("position-relative");
    }
  };

  const initializeMainMenuToggles = () => {
    // No ejecutar en PC
    if (window.innerWidth >= 992) return;
    console.log("ESTOY EN MOBILE");

    const toggles = document.querySelectorAll("#menu-main .menu__toggle");

    toggles.forEach((toggle) => {
      toggle.addEventListener("click", () => {
        const parentItem = toggle.closest(".menu__item");
        const submenu = parentItem.querySelector(".menu__list--submenu");
        const isOpen = toggle.getAttribute("aria-expanded") === "true";
        toggle.setAttribute("aria-expanded", String(!isOpen));
        if (submenu) submenu.style.display = isOpen ? "none" : "block";
      });
    });

    // Extra: Detecta <a href="#0"> con submenús y actúa como si fuera un toggle
    const fakeLinks = document.querySelectorAll('.menu__link[href="#0"]');

    fakeLinks.forEach((link) => {
      const parentItem = link.closest(".menu__item");
      const toggle = parentItem.querySelector(".menu__toggle");
      const submenu = parentItem.querySelector(".menu__list--submenu");

      if (toggle && submenu) {
        link.addEventListener("click", (e) => {
          e.preventDefault(); // Evita el scroll al top
          const isOpen = toggle.getAttribute("aria-expanded") === "true";
          toggle.setAttribute("aria-expanded", String(!isOpen));
          submenu.style.display = isOpen ? "none" : "block";
        });
      }
    });
  };

  const initDOMReady = () => {
    console.log("DOM Ready!");
    toggleStickyHeader();
    // MENU MAIN
    initializeMainMenuToggles();
  };

  document.addEventListener("DOMContentLoaded", initDOMReady);
  window.addEventListener("resize", initializeMainMenuToggles);
  window.addEventListener("scroll", toggleStickyHeader);
})();
