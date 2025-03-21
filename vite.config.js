import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue'; // Import the Vue plugin
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/js/app.js' , 'resources/css/app.css', ], // Entry point for your application
            refresh: true,
        }),
        tailwindcss(),
        vue(), // Add the Vue plugin here
    ],
});