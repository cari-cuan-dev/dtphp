import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/light-switch.css',
                'resources/js/app.js',
                'public/css/filament/filament/app.css'
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
