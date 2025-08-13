import defaultTheme from "tailwindcss/defaultTheme";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            colors: {
                primary: "#fffedd",
                secondary: "#557766",
                third: "#94C595",
                danger: "#ff5f3b",
                info: "#2596be",
                // info: "#41bffa",
                dark: "#3A2449",
            },
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
                montserrat: ["Montserrat", ...defaultTheme.fontFamily.sans],
                inter: ["Inter", ...defaultTheme.fontFamily.sans],
            },
        },
    },
    plugins: [],
};
