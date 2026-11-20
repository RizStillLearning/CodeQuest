import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig(({ command }) => ({
    // Relative asset URLs in the built CSS (fonts, icons), so the site also works
    // from a subfolder such as http://localhost/CodeQuest/public/.
    base: command === 'build' ? './' : undefined,
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
}));
