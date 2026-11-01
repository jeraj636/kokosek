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
        main: resolve(__dirname, "index.html"),
        jakobThoughts: resolve(__dirname, "jakob_thoughts/index.html"),
        misel: resolve(__dirname, "jakob_thoughts/thought/index.html"),
        knjige: resolve(__dirname, "knjige/index.html"),
        krokyReview: resolve(__dirname, "kroky_review/index.html"),
      },
    },
  },
});
