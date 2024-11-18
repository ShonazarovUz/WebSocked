import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',   // CSS fayllar
                'resources/sass/app.scss', // SCSS fayllar
                'resources/js/app.js',     // Asosiy JS fayl
            ],
            refresh: true, // HMR (Hot Module Replacement) imkoniyati
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
    resolve: {
        alias: {
            vue: 'vue/dist/vue.esm-bundler.js', // Vue-ning ESM versiyasi
        },
    },
    css: {
        preprocessorOptions: {
            scss: {
                additionalData: `@import "resources/sass/_variables.scss";`, // SCSS o'zgaruvchilar (agar kerak bo'lsa)
            },
        },
    },
    server: {
        host: '0.0.0.0', // Tashqi tarmoqqa ulanishni ruxsat berish
        port: 5173,      // Standart Vite porti
    },
});
