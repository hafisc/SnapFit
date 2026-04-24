import { createApp } from 'vue';
import { createRouter, createWebHistory } from 'vue-router';
import App from './App.vue';

// Layouts
import LandingLayout from './layouts/landing.vue';
import AuthLayout from './layouts/auth.vue';
import AdminLayout from './layouts/admin.vue';

// Landing pages
import LandingPage from './landing/index.vue';

// Auth pages
import LoginPage from './auth/login.vue';
import RegisterPage from './auth/register.vue';

const routes = [
    // Landing (public)
    {
        path: '/',
        component: LandingLayout,
        children: [
            { path: '', component: LandingPage, name: 'home' },
        ],
    },
    // Auth
    {
        path: '/auth',
        component: AuthLayout,
        children: [
            { path: 'login', component: LoginPage, name: 'login' },
            { path: 'register', component: RegisterPage, name: 'register' },
        ],
    },
    // Admin
    {
        path: '/admin',
        component: AdminLayout,
        children: [],
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
    scrollBehavior() {
        return { top: 0 };
    },
});

const app = createApp(App);
app.use(router);
app.mount('#app');
