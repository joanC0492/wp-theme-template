const fs = require("fs");
const path = require("path");
const sharp = require("sharp");

const srcDir = "assets/images";
const outDir = "dist/images";

// Formatos que vamos a procesar
const validExt = [".jpg", ".jpeg", ".png", ".webp", ".avif", ".svg"];

async function processFile(srcPath, destPath) {
  const ext = path.extname(srcPath).toLowerCase();

  try {
    if ([".jpg", ".jpeg", ".png"].includes(ext)) {
      // Convertir a webp
      const webpDest = destPath.replace(/\.(jpg|jpeg|png)$/i, ".webp");
      await sharp(srcPath).webp({ quality: 80 }).toFile(webpDest);
      console.log(`Converted to WebP: ${webpDest}`);

      // Opcional: optimizar original y copiar (puedes descomentar si quieres)
      /*
      await sharp(srcPath)
        .jpeg({ quality: 80, mozjpeg: true })
        .png({ quality: 80 })
        .toFile(destPath);
      console.log(`Optimized original: ${destPath}`);
      */
    } else if (ext === ".webp") {
      // Optimizar webp y copiar
      await sharp(srcPath).webp({ quality: 80 }).toFile(destPath);
      console.log(`Optimized WebP: ${destPath}`);
    } else if (ext === ".avif") {
      // Optimizar avif y copiar
      await sharp(srcPath).avif({ quality: 50 }).toFile(destPath);
      console.log(`Optimized AVIF: ${destPath}`);
    } else if (ext === ".svg") {
      // Para SVG simplemente copiar (puedes integrar svgo para optimizar si quieres)
      fs.copyFileSync(srcPath, destPath);
      console.log(`Copied SVG: ${destPath}`);
    } else {
      console.log(`Skipped (no soportado): ${srcPath}`);
    }
  } catch (error) {
    console.error(`Error procesando ${srcPath}:`, error.message);
  }
}

async function processDirectory(srcPath, destPath) {
  if (!fs.existsSync(destPath)) {
    fs.mkdirSync(destPath, { recursive: true });
  }

  const entries = fs.readdirSync(srcPath, { withFileTypes: true });

  // Procesar todos simultáneamente con Promise.all
  await Promise.all(
    entries.map(async (entry) => {
      const srcEntryPath = path.join(srcPath, entry.name);
      const destEntryPath = path.join(destPath, entry.name);

      if (entry.isDirectory()) {
        await processDirectory(srcEntryPath, destEntryPath);
      } else {
        const ext = path.extname(entry.name).toLowerCase();
        if (!validExt.includes(ext)) {
          console.log(`Skipped (ext no válida): ${srcEntryPath}`);
          return;
        }
        await processFile(srcEntryPath, destEntryPath);
      }
    })
  );
}

(async () => {
  await processDirectory(srcDir, outDir);
  console.log("✅ Todas las imágenes procesadas.");
})();

/*
- quality: 100 es la máxima calidad, menor compresión.
- quality: 0 es la mínima calidad, máxima compresión.
Entonces:
- quality: 80 significa calidad alta (muy buena imagen, buena nitidez) con compresión moderada.
- quality: 50 es calidad media, más compresión y puede notarse algo de pérdida visual.

Si las imágenes salen muy borrosas o con artefactos:
- Aumenta el valor de quality. Por ejemplo, prueba quality: 90 o incluso 95.
- Haz pruebas visuales para elegir el mejor equilibrio calidad/peso.
- Para WebP y AVIF, la calidad tiene mucho impacto, más que para JPG.
*/