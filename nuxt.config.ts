export default {
  css: ['/assets/css/main.css'],
  devtools: { enabled: true },
  postcss: {
    plugins: {
      tailwindcss: {},
      autoprefixer: {},
    },
  },
  ssr: true,
  // Ensure the router settings are default or correct if overridden
  router: {
    // Custom settings here if any
  },
}
