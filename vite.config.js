import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/admin.css',
                'resources/css/contact.css',
                'resources/css/contact-form.css',
                'resources/css/contact-options.css',
                'resources/css/dashboard.css',
                'resources/css/contact-messages-show.css',
                'resources/css/dashboard-detail.css',
                'resources/js/app.js',
                'resources/js/global.js',
                'resources/js/team.js',
                'resources/js/contact.js',
                'resources/js/contact-form.js',
                'resources/js/contact-options.js',
                'resources/js/dashboard.js',
                'resources/js/process.js',
                'resources/js/home.js',
                'resources/js/contact-page.js'
            ],
            refresh: true,
        }),
    ],
});
