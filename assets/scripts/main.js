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

  const initializeYouTubeLazyLoad = () => {
    // Click en cualquier parte de la pagina
    document.addEventListener("click", function (e) {
      const target = e.target.closest(".youtube-lazy");
      if (!target) return;

      const id = target.getAttribute("data-id");
      const iframe = document.createElement("iframe");
      iframe.setAttribute(
        "src",
        "https://www.youtube.com/embed/" + id + "?autoplay=1"
      );
      iframe.setAttribute("frameborder", "0");
      iframe.setAttribute("allowfullscreen", "1");
      iframe.setAttribute(
        "allow",
        "accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
      );
      iframe.classList.add("w-100", "h-100");
      target.innerHTML = "";
      target.appendChild(iframe);
    });
  };

  const filterTestimoniosAjax = () => {
    const filtro = document.getElementById("filtro-tipo-testimonio");
    const contenedor = document.getElementById(
      "contenedor-testimonios-filtrados"
    );
    const loader = document.querySelector("#loader-testimonios");

    if (!filtro || !contenedor) return; // Evita errores si no existen

    filtro.addEventListener("change", () => {
      const categoriaId = filtro.value;
      loader.classList.remove("d-none");
      contenedor.classList.add("d-none");
      fetch(frontend_ajax.url, {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded; charset=UTF-8",
        },
        body: new URLSearchParams({
          action: "filtrar_testimonios",
          categoria_id: categoriaId,
        }),
      })
        .then((response) => response.text())
        .then((html) => {
          contenedor.innerHTML = html;
        })
        .catch((error) => {
          console.error("Error en la petición AJAX:", error);
        })
        .finally(() => {
          loader.classList.add("d-none");
          contenedor.classList.remove("d-none");
        });
    });
  };

  const initDOMReady = () => {
    console.log("DOM Ready main.js!");
    // STICKY HEADER
    toggleStickyHeader();
    // MENU MAIN OPEN-CLOSE TOGGLES
    initializeMainMenuToggles();
    // YOUTUBE
    initializeYouTubeLazyLoad();
    // Testimonios AJAX
    filterTestimoniosAjax();
  };

  document.addEventListener("DOMContentLoaded", initDOMReady);
  window.addEventListener("resize", initializeMainMenuToggles);
  window.addEventListener("scroll", toggleStickyHeader);
})();
