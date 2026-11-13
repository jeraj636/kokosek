import { defineConfig } from "vite";
import tailwindcss from "@tailwindcss/vite";
import { resolve } from "node:path";

export default defineConfig({
  plugins: [tailwindcss()],
  server: {
    port: 8080,
    strictPort: true,
  },
  base: "/",
  build: {
    outDir: "dist",
    emptyOutDir: true,
    rollupOptions: {
      input: {
        main: resolve(import.meta.dirname, "index.html"),
        jakobThoughts: resolve(
          import.meta.dirname,
          "jakob_thoughts/index.html",
        ),
        misel: resolve(
          import.meta.dirname,
          "jakob_thoughts/thought/index.html",
        ),
        knjige: resolve(import.meta.dirname, "knjige/index.html"),
        prijava: resolve(import.meta.dirname, "prijava/index.html"),
        registracija: resolve(import.meta.dirname, "registracija/index.html"),
        krokyReview: resolve(import.meta.dirname, "kroky_review/index.html"),
        krokyReviewMisel: resolve(
          import.meta.dirname,
          "kroky_review/review/index.html",
        ),
      },
    },
  },
});
