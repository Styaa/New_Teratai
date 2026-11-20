import { defineConfig } from 'astro/config';

export default defineConfig({
  site: 'https://terataicookies.com',
  trailingSlash: 'always',
  build: { inlineStylesheets: 'auto' },
  prefetch: { prefetchAll: false, defaultStrategy: 'hover' },
});
