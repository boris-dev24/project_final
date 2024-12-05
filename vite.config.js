import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css', // Chemin correct pour ton fichier CSS
                'resources/js/app.js',   // Fichier JavaScript
            ],
            refresh: true,
        }),
    ],
});
