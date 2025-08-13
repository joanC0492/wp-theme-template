const esbuild = require("esbuild");
const fs = require("fs");
const path = require("path");

const args = process.argv.slice(2);
const isWatch = args.includes("--watch");
const isMinify = args.includes("--minify");

// Directorios de entrada y salida
const inputDir = path.resolve(__dirname, "assets/scripts"); // fuentes JS
const outputDir = path.resolve(__dirname, "dist/js"); // compilados JS

function getEntryPoints(dir, entryPoints = []) {
  const files = fs.readdirSync(dir);
  files.forEach((file) => {
    const fullPath = path.join(dir, file);
    const stat = fs.statSync(fullPath);
    if (stat.isDirectory()) {
      getEntryPoints(fullPath, entryPoints);
    } else if (file.endsWith(".js")) {
      const relative = path.relative(inputDir, fullPath);
      const outfile = path.join(outputDir, relative);
      entryPoints.push({ in: fullPath, out: outfile });
    }
  });
  return entryPoints;
}

// Crear carpeta dist/js si no existe
if (!fs.existsSync(outputDir)) {
  fs.mkdirSync(outputDir, { recursive: true });
}

const entries = getEntryPoints(inputDir);

(async () => {
  for (const entry of entries) {
    const config = {
      entryPoints: [entry.in],
      bundle: true,
      minify: isMinify,
      sourcemap: !isMinify, // solo en dev
      outfile: entry.out,
    };

    if (isWatch) {
      const ctx = await esbuild.context(config);
      await ctx.watch();
      console.log(`Watching: ${entry.in}`);
    } else {
      await esbuild.build(config);
      console.log(`Built: ${entry.out}`);
    }
  }
})();