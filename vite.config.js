import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import path from 'path';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
    build: {
        // Specify the output directory
        outDir: path.resolve(__dirname, 'public/build'),
    },
    resolve: {
        // Setup an alias if needed, this is optional
        alias: {
            '@': path.resolve(__dirname, 'resources/js'),
        },
    },
});
