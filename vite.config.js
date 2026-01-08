import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/sass/app.scss",
                "resources/css/mainPortal.css",
                "resources/css/hostelPortal.css",
                "resources/js/app.js",
            ],
            refresh: true,
        }), 
    ],
});
