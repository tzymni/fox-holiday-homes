import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'
import fs from 'fs'

export default defineConfig({
  plugins: [vue()],
  server: {
    host: true,
    port: 5173,
    https: {
      cert: fs.readFileSync('/etc/nginx/certs/fox-holiday-homes.test.pem'),
      key: fs.readFileSync('/etc/nginx/certs/fox-holiday-homes.test-key.pem'),
    },
    allowedHosts: ['fox-holiday-homes.test'],
    hmr: {
      protocol: 'wss', // secure websocket
      host: 'fox-holiday-homes.test'
    }
  }
})
