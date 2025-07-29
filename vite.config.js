import { defineConfig } from 'vite';
import path from 'path';

export default defineConfig({
  root: 'resources',
  build: {
    outDir: '../public/assets',
    emptyOutDir: true,
    manifest: false,
    rollupOptions: {
        input: {
        app: path.resolve(__dirname, 'resources/js/app.js'),
        styles: path.resolve(__dirname, 'resources/css/app.css'),
        },
        output: {
        entryFileNames: '[name].js',
        assetFileNames: '[name].[ext]'
        }
    }
  }

});
