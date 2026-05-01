import { createRouter, createWebHistory } from 'vue-router';

/**
 * SnapFit Router
 * ─────────────────────────────────────────────────
 * Menggunakan lazy-loading (dynamic import) pada setiap route
 * agar initial bundle kecil dan performa optimal.
 */
const routes = [
  // ─── PUBLIC ─────────────────────────────────────
  {
    path: '/',
    name: 'landing',
    component: () => import('@/pages/landing/index.vue'),
  },
  {
    path: '/login',
    name: 'login',
    component: () => import('@/pages/auth/login.vue'),
    meta: { guestOnly: true },
  },
  {
    path: '/register',
    name: 'register',
    component: () => import('@/pages/auth/register.vue'),
    meta: { guestOnly: true },
  },
  {
    path: '/marketplace',
    name: 'marketplace',
    component: () => import('@/pages/marketplace/index.vue'),
  },

  // ─── UMKM ───────────────────────────────────────
  {
    path: '/umkm',
    meta: { requiresAuth: true, role: 'umkm' },
    children: [
      {
        path: 'dashboard',
        name: 'umkm.dashboard',
        component: () => import('@/pages/umkm/dashboard.vue'),
      },
      {
        path: 'studio',
        name: 'umkm.studio',
        component: () => import('@/pages/umkm/studio.vue'),
      },
      {
        path: 'products',
        name: 'umkm.products',
        component: () => import('@/pages/umkm/products/index.vue'),
      },
      {
        path: 'products/create',
        name: 'umkm.products.create',
        component: () => import('@/pages/umkm/products/create.vue'),
      },
      {
        path: 'cocreate/:id',
        name: 'umkm.cocreate',
        component: () => import('@/pages/umkm/cocreate/[id].vue'),
      },
    ],
  },

  // ─── DESIGNER ───────────────────────────────────
  {
    path: '/designer',
    meta: { requiresAuth: true, role: 'desainer' },
    children: [
      {
        path: 'dashboard',
        name: 'designer.dashboard',
        component: () => import('@/pages/designer/dashboard.vue'),
      },
      {
        path: 'cocreate/:id',
        name: 'designer.cocreate',
        component: () => import('@/pages/designer/cocreate/[id].vue'),
      },
    ],
  },

  // ─── ADMIN ──────────────────────────────────────
  {
    path: '/admin',
    meta: { requiresAuth: true, role: 'admin' },
    children: [
      {
        path: 'dashboard',
        name: 'admin.dashboard',
        component: () => import('@/pages/admin/dashboard.vue'),
      },
      {
        path: 'users',
        name: 'admin.users',
        component: () => import('@/pages/admin/users.vue'),
      },
    ],
  },

  // ─── FALLBACK ───────────────────────────────────
  {
    path: '/:pathMatch(.*)*',
    redirect: '/',
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
  scrollBehavior(to, from, savedPosition) {
    if (savedPosition) return savedPosition;
    if (to.hash) return { el: to.hash, behavior: 'smooth' };
    return { top: 0, behavior: 'smooth' };
  },
});

/* ── Navigation Guard ─────────────────────────── */
router.beforeEach((to, from, next) => {
  const user  = JSON.parse(localStorage.getItem('user') ?? 'null');
  const token = localStorage.getItem('token');
  const isAuthenticated = !!(token && user);

  // Redirect logged-in user away from guest-only pages
  if (to.meta.guestOnly && isAuthenticated) {
    return next('/');
  }

  // Require authentication
  if (to.meta.requiresAuth && !isAuthenticated) {
    return next('/login');
  }

  // Require specific role
  if (to.meta.role && user?.role !== to.meta.role) {
    return next('/');
  }

  next();
});

export default router;
