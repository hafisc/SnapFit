import { createApp } from 'vue'
import { createRouter, createWebHistory } from 'vue-router'

import App from './App.vue'
import Landing from './layouts/landing.vue'
import Auth from './layouts/auth.vue'

const routes = [
  { path: '/', component: Landing },
  { path: '/login', component: Auth }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

createApp(App)
  .use(router)
  .mount('#app')