<template>
  <div class="min-h-screen bg-slate-50 flex text-slate-900 font-sans">
    <!-- Sidebar -->
    <aside class="w-72 bg-white border-r border-slate-100 flex flex-col transition-all duration-300 z-20 shadow-[4px_0_24px_rgba(0,0,0,0.02)] hidden md:flex sticky top-0 h-screen">
      <!-- Logo Area -->
      <div class="h-20 flex items-center px-8 border-b border-slate-50">
        <div class="flex items-center gap-3">
          <div class="w-8 h-8 bg-gradient-to-br from-indigo-600 to-blue-500 rounded-xl shadow-lg shadow-indigo-500/30 flex items-center justify-center">
            <span class="text-white font-black text-sm italic">S</span>
          </div>
          <span class="font-black tracking-tighter text-xl italic text-slate-800">SnapFit<span class="text-indigo-600">Admin</span></span>
        </div>
      </div>

      <!-- Navigation -->
      <nav class="flex-1 overflow-y-auto py-6 px-4 space-y-1 no-scrollbar">
        <p class="px-4 text-[10px] font-black uppercase tracking-widest text-slate-400 mb-4">Menu Utama</p>

        <router-link
          v-for="item in menuItems"
          :key="item.name"
          :to="item.path"
          class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all duration-300 font-bold text-sm group"
          :class="[
            $route.path === item.path
              ? 'bg-indigo-50 text-indigo-600 shadow-sm shadow-indigo-100/50'
              : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900'
          ]"
        >
          <div
            class="w-8 h-8 rounded-xl flex items-center justify-center transition-all duration-300"
            :class="[
              $route.path === item.path
                ? 'bg-white shadow-sm text-indigo-600'
                : 'bg-slate-100 text-slate-400 group-hover:bg-white group-hover:shadow-sm group-hover:text-slate-600'
            ]"
          >
            <component :is="item.icon" class="w-4 h-4" />
          </div>
          {{ item.name }}
        </router-link>
      </nav>

      <!-- User Profile Profile -->
      <div class="p-4 border-t border-slate-100">
        <div class="bg-slate-900 rounded-[1.5rem] p-4 flex items-center gap-3 text-white relative overflow-hidden group cursor-pointer hover:shadow-xl hover:shadow-slate-900/20 transition-all">
          <div class="absolute inset-0 bg-gradient-to-r from-indigo-500/20 to-purple-500/20 opacity-0 group-hover:opacity-100 transition-opacity"></div>
          <div class="w-10 h-10 bg-slate-800 rounded-xl flex items-center justify-center font-black text-lg relative z-10">
            A
          </div>
          <div class="flex-1 relative z-10">
            <p class="text-sm font-bold tracking-tight">Administrator</p>
            <p class="text-[10px] text-slate-400 font-medium">admin@snapfit.id</p>
          </div>
          <button @click="logout" class="relative z-10 w-8 h-8 flex items-center justify-center rounded-lg hover:bg-red-500/20 hover:text-red-400 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
          </button>
        </div>
      </div>
    </aside>

    <!-- Main Content Wrapper -->
    <main class="flex-1 flex flex-col min-w-0 overflow-hidden relative">
      <!-- Top Header -->
      <header class="h-20 bg-white/80 backdrop-blur-md border-b border-slate-100 sticky top-0 z-10 px-8 flex items-center justify-between shadow-[0_4px_24px_rgba(0,0,0,0.02)]">
        <div>
          <h1 class="text-xl font-black tracking-tighter text-slate-800 capitalize">{{ currentRouteName }}</h1>
          <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">SnapFit Management Portal</p>
        </div>

        <div class="flex items-center gap-4">
          <!-- Notification Bell -->
          <button class="w-10 h-10 bg-slate-50 rounded-xl flex items-center justify-center text-slate-500 hover:bg-slate-100 transition-colors relative">
            <span class="absolute top-2.5 right-2.5 w-2 h-2 bg-red-500 rounded-full animate-ping"></span>
            <span class="absolute top-2.5 right-2.5 w-2 h-2 bg-red-500 rounded-full border-2 border-white"></span>
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" /></svg>
          </button>
        </div>
      </header>

      <!-- Page Content Slot -->
      <div class="flex-1 overflow-y-auto p-8 no-scrollbar relative">
        <!-- Background Decoration -->
        <div class="absolute top-0 right-0 w-96 h-96 bg-indigo-50 rounded-full blur-[100px] opacity-50 pointer-events-none"></div>

        <div class="relative z-10">
          <RouterView />
        </div>
      </div>
    </main>
  </div>
</template>

<script setup>
import { computed } from 'vue';
import { useRouter, useRoute } from 'vue-router';

// Simple Icons Components (using SVG strings for now to avoid extra dependencies)
import { h } from 'vue';
const IconDashboard = () => h('svg', { fill: 'none', stroke: 'currentColor', viewBox: '0 0 24 24', 'stroke-width': '2' }, [
  h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', d: 'M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z' })
]);
const IconUsers = () => h('svg', { fill: 'none', stroke: 'currentColor', viewBox: '0 0 24 24', 'stroke-width': '2' }, [
  h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', d: 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z' })
]);
const IconProducts = () => h('svg', { fill: 'none', stroke: 'currentColor', viewBox: '0 0 24 24', 'stroke-width': '2' }, [
  h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', d: 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4' })
]);
const IconOrders = () => h('svg', { fill: 'none', stroke: 'currentColor', viewBox: '0 0 24 24', 'stroke-width': '2' }, [
  h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', d: 'M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z' })
]);
const IconReviews = () => h('svg', { fill: 'none', stroke: 'currentColor', viewBox: '0 0 24 24', 'stroke-width': '2' }, [
  h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', d: 'M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z' })
]);

const router = useRouter();
const route = useRoute();

const menuItems = [
  { name: 'Dashboard', path: '/admin/dashboard', icon: IconDashboard },
  { name: 'Data Pengguna', path: '/admin/users', icon: IconUsers },
  { name: 'Data Produk', path: '/admin/products', icon: IconProducts },
  { name: 'Data Transaksi', path: '/admin/orders', icon: IconOrders },
  { name: 'Data Ulasan', path: '/admin/reviews', icon: IconReviews },
];

const currentRouteName = computed(() => {
  const match = menuItems.find(item => route.path.startsWith(item.path));
  return match ? match.name : 'Admin Panel';
});

const logout = () => {
  localStorage.removeItem('user');
  localStorage.removeItem('token');
  router.push('/login');
};
</script>

<style scoped>
.no-scrollbar::-webkit-scrollbar { display: none; }
.no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
</style>
