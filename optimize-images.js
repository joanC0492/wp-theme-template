const fs = require("fs");
const path = require("path");
const sharp = require("sharp");

const srcDir = "assets/images";
const outDir = "dist/images";

const validExt = [".jpg", ".jpeg", ".png"];

function processDirectory(srcPath, destPath) {
  fs.mkdirSync(destPath, { recursive: true });

  fs.readdirSync(srcPath, { withFileTypes: true }).forEach((entry) => {
    const srcEntryPath = path.join(srcPath, entry.name);
    const destEntryPath = path.join(destPath, entry.name);

    if (entry.isDirectory()) {
      // Recursivo para subcarpetas
      processDirectory(srcEntryPath, destEntryPath);
    } else {
      const ext = path.extname(entry.name).toLowerCase();
      if (!validExt.includes(ext)) {
        console.log(`Skipped (unsupported): ${srcEntryPath}`);
        return;
      }

      const outputPath = destEntryPath.replace(/\.(jpg|jpeg|png)$/i, ".webp");

      sharp(srcEntryPath)
        .webp({ quality: 80 })
        .toFile(outputPath)
        .then(() => console.log(`Optimized: ${srcEntryPath}`))
        .catch((err) =>
          console.error(`Error optimizing ${srcEntryPath}:`, err.message)
        );
    }
  });
}

processDirectory(srcDir, outDir);