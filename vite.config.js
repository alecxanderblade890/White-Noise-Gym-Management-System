import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css', 
                'resources/js/app.js',
                'resources/js/components/dashboard.js',
                'resources/js/components/dailyLogs.js',
                'resources/js/components/registration.js',
                'resources/js/components/modals.js',
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
