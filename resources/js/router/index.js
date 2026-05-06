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
    component: () => import('@/layouts/UmkmLayout.vue'),
    meta: { requiresAuth: true, role: 'umkm' },
    children: [
      {
        path: 'dashboard',
        name: 'umkm.dashboard',
        component: () => import('@/pages/umkm/dashboard/index.vue'),
      },
      {
        path: 'studio',
        name: 'umkm.studio',
        component: () => import('@/pages/umkm/studio/index.vue'),
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
        path: 'products/edit/:id',
        name: 'umkm.products.edit',
        component: () => import('@/pages/umkm/products/edit/[id].vue'),
      },
      {
        path: 'cocreate',
        name: 'umkm.cocreate.index',
        component: () => import('@/pages/umkm/cocreate/index.vue'),
      },
      {
        path: 'cocreate/:id',
        name: 'umkm.cocreate',
        component: () => import('@/pages/umkm/cocreate/[id].vue'),
      },
      {
        path: 'orders',
        name: 'umkm.orders',
        component: () => import('@/pages/umkm/orders/index.vue'),
      },
      {
        path: 'analytics',
        name: 'umkm.analytics',
        component: () => import('@/pages/umkm/analytics/index.vue'),
      },
      {
        path: 'settings',
        name: 'umkm.settings',
        component: () => import('@/pages/umkm/settings/index.vue'),
      },
    ],
  },

  // ─── DESIGNER ───────────────────────────────────
  {
    path: '/designer',
    component: () => import('@/layouts/DesignerLayout.vue'),
    meta: { requiresAuth: true, role: 'desainer' },
    children: [
      {
        path: 'dashboard',
        name: 'designer.dashboard',
        component: () => import('@/pages/designer/dashboard/index.vue'),
      },
      {
        path: 'cocreate',
        name: 'designer.cocreate.index',
        component: () => import('@/pages/designer/cocreate/index.vue'),
      },
      {
        path: 'cocreate/:id',
        name: 'designer.cocreate.detail',
        component: () => import('@/pages/designer/cocreate/[id].vue'),
      },
      {
        path: 'portfolio',
        name: 'designer.portfolio',
        component: () => import('@/pages/designer/portfolio/index.vue'),
      },
      {
        path: 'history',
        name: 'designer.history',
        component: () => import('@/pages/designer/history/index.vue'),
      },
      {
        path: 'settings',
        name: 'designer.settings',
        component: () => import('@/pages/designer/settings/index.vue'),
      },
    ],
  },

  // ─── ADMIN ──────────────────────────────────────
  {
    path: '/admin',
    component: () => import('@/layouts/AdminLayout.vue'),
    meta: { requiresAuth: true, role: 'admin' },
    children: [
      {
        path: 'dashboard',
        name: 'admin.dashboard',
        component: () => import('@/pages/admin/dashboard/index.vue'),
      },
      {
        path: 'users',
        name: 'admin.users',
        component: () => import('@/pages/admin/users/index.vue'),
      },
      {
        path: 'users/create',
        name: 'admin.users.create',
        component: () => import('@/pages/admin/users/create.vue'),
      },
      {
        path: 'users/edit/:id',
        name: 'admin.users.edit',
        component: () => import('@/pages/admin/users/edit/[id].vue'),
      },
      {
        path: 'products',
        name: 'admin.products',
        component: () => import('@/pages/admin/products/index.vue'),
      },
      {
        path: 'orders',
        name: 'admin.orders',
        component: () => import('@/pages/admin/orders/index.vue'),
      },
      {
        path: 'reviews',
        name: 'admin.reviews',
        component: () => import('@/pages/admin/reviews/index.vue'),
      },
      {
        path: 'analytics',
        name: 'admin.analytics',
        component: () => import('@/pages/admin/analytics/index.vue'),
      },
      {
        path: 'roles',
        name: 'admin.roles',
        component: () => import('@/pages/admin/roles/index.vue'),
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
router.beforeEach((to, from) => {
  const user  = JSON.parse(localStorage.getItem('user') ?? 'null');
  const token = localStorage.getItem('token');
  const isAuthenticated = !!(token && user);

  // Redirect logged-in user away from guest-only pages
  if (to.meta.guestOnly && isAuthenticated) {
    return '/';
  }

  // Require authentication
  if (to.meta.requiresAuth && !isAuthenticated) {
    return '/login';
  }

  // Require specific role
  if (to.meta.role && user?.role !== to.meta.role) {
    return '/';
  }

  return true;
});

export default router;
