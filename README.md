# JoanC Theme Template

![Vista previa del tema](screenshot.png)

Este es un tema base para WordPress pensado para crear blogs modernos y personalizables de forma rápida. Incluye buenas prácticas, estructura modular y herramientas para desarrollo ágil.

---

## Requisitos previos
- WordPress 6.0 o superior
- PHP 7.4 o superior
- Composer
- Sass (Dart Sass recomendado)

---

## Instalación rápida

1. **Clona o descarga este repositorio en tu carpeta de temas de WordPress.**

2. **Instala las dependencias de desarrollo:**

   ```bash
   composer install
   ```
   Esto instalará los stubs de WordPress para autocompletado y ayuda en el desarrollo PHP.

   Si no tienes los stubs, puedes instalarlos con:
   ```bash
   composer require --dev php-stubs/wordpress-stubs
   ```

3. **Compila los estilos SCSS:**

   ```bash
   sass --watch assets/scss:assets/css --style compressed
   ```
   Esto compilará automáticamente los archivos SCSS a CSS comprimido cada vez que guardes cambios. Es necesario para que los estilos personalizados del tema se apliquen correctamente.

---

## Estructura del proyecto
- `assets/`: Recursos estáticos (SCSS, CSS, JS, imágenes)
- `includes/`: Funciones y helpers PHP reutilizables
- `template-parts/`: Partes de plantilla reutilizables (cards, secciones, loops)
- `shortcodes/`: Shortcodes personalizados
- `pods/` y `ninja-forms/`: Integraciones y configuraciones de plugins

---

## Características principales
- Estructura lista para producción y desarrollo.
- Modularización en includes/ y template-parts/.
- Soporte para Bootstrap 5 y Swiper.js.
- Fácil de extender para nuevos blogs o sitios WordPress.
- Código limpio y buenas prácticas.

---

## Ejemplo: Añadir un nuevo template-part
1. Crea un archivo en `template-parts/`, por ejemplo `mi-bloque.php`.
2. Inclúyelo en tu plantilla con:
   ```php
   get_template_part('template-parts/mi-bloque');
   ```

---

## ¿Para qué sirve este tema?
Este tema está pensado como base para crear nuevos blogs WordPress de forma rápida, reutilizando componentes y estructura. Puedes personalizarlo fácilmente para tus futuros proyectos.

---

## Licencia
MIT

**¡Listo para crear tu próximo blog con WordPress!**