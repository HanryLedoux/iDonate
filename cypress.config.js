import { defineConfig } from 'cypress';

export default defineConfig({
  e2e: {
    baseUrl: process.env.CYPRESS_BASE_URL || 'http://127.0.0.1:8000',
    setupNodeEvents(on, config) {
      return config;
    },
  },
});
