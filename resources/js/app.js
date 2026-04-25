import { createApp } from 'vue'
import { createRouter, createWebHistory } from 'vue-router'

import App from './App.vue'
import Landing from './layouts/landing.vue'
import Auth from './layouts/auth.vue'
import Admin from './layouts/admin.vue'

const routes = [
  { path: '/', component: Landing },
  { path: '/login', component: Auth },
  { path: '/admin', component: Admin, meta: { requiresAuth: true, role: 'admin' } },
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

router.beforeEach((to, from, next) => {
  const user = JSON.parse(localStorage.getItem('user'))
  const token = localStorage.getItem('token')

  // cek login
  if (to.meta.requiresAuth) {
    if (!token || !user) {
      return next('/login')
    }
  }

  // cek role
  if (to.meta.role) {
    if (!user || user.role !== to.meta.role) {
      return next('/') // bisa juga /403
    }
  }

  next()
})
createApp(App)
  .use(router)
  .mount('#app')