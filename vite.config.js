import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
      vue(),
      laravel({
        input: [
          'resources/js/app.js',
          'resources/css/app.css',
        ],
        refresh: true,
      }),
    ],
    build: {
      outDir: 'public/build', // Esta es la carpeta donde Vite debe colocar los archivos
    }
  })
  