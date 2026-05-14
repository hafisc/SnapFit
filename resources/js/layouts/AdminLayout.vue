<template>
  <div class="min-h-screen bg-[#f4f5f7] flex text-slate-800 font-sans">
    <!-- Mobile Overlay -->
    <Transition name="fade">
      <div v-if="sidebarOpen" class="fixed inset-0 bg-black/20 backdrop-blur-sm z-30 lg:hidden" @click="sidebarOpen = false"></div>
    </Transition>

    <!-- Sidebar -->
    <aside
      :class="[
        'w-[260px] bg-[#1e1e2d] flex flex-col z-40 h-screen',
        'fixed lg:sticky top-0 transition-transform duration-300 lg:translate-x-0',
        sidebarOpen ? 'translate-x-0' : '-translate-x-full'
      ]"
    >
      <!-- Logo -->
      <div class="h-[72px] flex items-center px-7 border-b border-white/5">
        <div class="flex items-center gap-2.5">
          <div class="w-8 h-8 bg-orange-500 rounded-lg flex items-center justify-center overflow-hidden">
            <img src="/images/logo.png" alt="SnapFit Logo" class="w-full h-full object-contain p-1" />
          </div>
          <div>
            <span class="font-extrabold text-[15px] text-white tracking-tight">SnapFit</span>
            <span class="text-[10px] font-semibold text-slate-500 block -mt-0.5 tracking-wide">Management Console</span>
          </div>
        </div>
      </div>

      <!-- Nav -->
      <nav class="flex-1 overflow-y-auto py-5 px-3.5 no-scrollbar">
        <p class="px-3 text-[9px] font-bold uppercase tracking-[0.2em] text-slate-600 mb-3">Overview</p>
        <router-link v-for="item in mainMenu" :key="item.name" :to="item.path" @click="sidebarOpen = false"
          class="flex items-center gap-3 px-3.5 py-[10px] rounded-xl mb-0.5 transition-all duration-150 text-[13px] font-medium group"
          :class="[isActive(item.path) ? 'bg-orange-500/10 text-orange-400' : 'text-slate-400 hover:text-slate-200 hover:bg-white/[0.03]']">
          <div class="w-[34px] h-[34px] rounded-lg flex items-center justify-center transition-all"
            :class="[isActive(item.path) ? 'bg-orange-500 text-white shadow-md shadow-orange-500/30' : 'bg-white/5 text-slate-500 group-hover:text-slate-300']">
            <component :is="item.icon" class="w-[16px] h-[16px]" />
          </div>
          <span>{{ item.name }}</span>
          <span v-if="item.badge" class="ml-auto text-[10px] font-bold bg-orange-500 text-white px-2 py-0.5 rounded-md min-w-[20px] text-center">{{ item.badge }}</span>
        </router-link>

        <p class="px-3 text-[9px] font-bold uppercase tracking-[0.2em] text-slate-600 mb-3 mt-6">System</p>
        <router-link v-for="item in systemMenu" :key="item.name" :to="item.path" @click="sidebarOpen = false"
          class="flex items-center gap-3 px-3.5 py-[10px] rounded-xl mb-0.5 transition-all duration-150 text-[13px] font-medium group"
          :class="[isActive(item.path) ? 'bg-orange-500/10 text-orange-400' : 'text-slate-400 hover:text-slate-200 hover:bg-white/[0.03]']">
          <div class="w-[34px] h-[34px] rounded-lg flex items-center justify-center transition-all"
            :class="[isActive(item.path) ? 'bg-orange-500 text-white shadow-md shadow-orange-500/30' : 'bg-white/5 text-slate-500 group-hover:text-slate-300']">
            <component :is="item.icon" class="w-[16px] h-[16px]" />
          </div>
          <span>{{ item.name }}</span>
        </router-link>
      </nav>

      <!-- User Card -->
      <div class="p-3.5 border-t border-white/5">
        <div class="flex items-center gap-3 px-3 py-3 rounded-xl hover:bg-white/[0.03] transition-colors cursor-pointer group">
          <div class="w-9 h-9 bg-gradient-to-br from-orange-400 to-orange-600 rounded-lg flex items-center justify-center text-white text-sm font-bold shadow-sm">
            {{ user?.name ? user.name.charAt(0) : 'A' }}
          </div>
          <div class="flex-1 min-w-0">
            <p class="text-[13px] font-semibold text-slate-200 truncate">{{ user?.name || 'Administrator' }}</p>
            <p class="text-[11px] text-slate-500 truncate">{{ user?.email || 'admin@snapfit.id' }}</p>
          </div>
          <button @click="logout" class="w-8 h-8 flex items-center justify-center rounded-lg text-slate-600 hover:bg-red-500/10 hover:text-red-400 transition-all opacity-0 group-hover:opacity-100">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
          </button>
        </div>
      </div>
    </aside>

    <!-- Main -->
    <main class="flex-1 flex flex-col min-w-0">
      <!-- Header -->
      <header class="h-16 sm:h-[72px] bg-white border-b border-slate-200/60 sticky top-0 z-20 px-4 sm:px-6 lg:px-8 flex items-center justify-between">
        <div class="flex items-center gap-3 sm:gap-4 min-w-0">
          <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden w-9 h-9 rounded-lg bg-slate-100 flex items-center justify-center text-slate-500 flex-shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /></svg>
          </button>
          <div class="min-w-0">
            <h1 class="text-sm sm:text-[15px] font-bold text-slate-800 truncate">{{ currentPageTitle }}</h1>
            <p class="text-[10px] sm:text-[11px] text-slate-400 font-medium -mt-0.5 truncate hidden sm:block">{{ currentPageDesc }}</p>
          </div>
        </div>

        <div class="flex items-center gap-2">
          <!-- Search -->
          <div class="hidden md:flex items-center bg-slate-50 rounded-lg px-3.5 py-2 gap-2 border border-slate-100">
            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
            <input type="text" placeholder="Search anything..." class="bg-transparent outline-none text-[12px] font-medium text-slate-600 w-44 placeholder:text-slate-400" />
            <kbd class="text-[9px] font-bold text-slate-400 bg-white border border-slate-200 px-1.5 py-0.5 rounded">⌘K</kbd>
          </div>
          <!-- Notification -->
          <button class="w-9 h-9 rounded-lg bg-slate-50 flex items-center justify-center text-slate-400 hover:bg-slate-100 hover:text-slate-600 transition-colors relative border border-slate-100">
            <span class="absolute top-2 right-2 w-2 h-2 bg-orange-500 rounded-full"></span>
            <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" /></svg>
          </button>
        </div>
      </header>

      <!-- Content -->
      <div class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 no-scrollbar">
        <RouterView />
      </div>
    </main>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import { useRouter, useRoute } from 'vue-router';
import { h } from 'vue';

const sidebarOpen = ref(false);
const router = useRouter();
const route = useRoute();
const user = ref(JSON.parse(localStorage.getItem('user') || '{}'));

const IconGrid = () => h('svg', { fill: 'none', stroke: 'currentColor', viewBox: '0 0 24 24', 'stroke-width': '1.8' }, [h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', d: 'M4 5a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM14 5a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1V5zM4 15a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1v-4zM14 15a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4z' })]);
const IconUsers = () => h('svg', { fill: 'none', stroke: 'currentColor', viewBox: '0 0 24 24', 'stroke-width': '1.8' }, [h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', d: 'M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z' })]);
const IconBox = () => h('svg', { fill: 'none', stroke: 'currentColor', viewBox: '0 0 24 24', 'stroke-width': '1.8' }, [h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', d: 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4' })]);
const IconCart = () => h('svg', { fill: 'none', stroke: 'currentColor', viewBox: '0 0 24 24', 'stroke-width': '1.8' }, [h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', d: 'M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z' })]);
const IconChart = () => h('svg', { fill: 'none', stroke: 'currentColor', viewBox: '0 0 24 24', 'stroke-width': '1.8' }, [h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', d: 'M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z' })]);
const IconShield = () => h('svg', { fill: 'none', stroke: 'currentColor', viewBox: '0 0 24 24', 'stroke-width': '1.8' }, [h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', d: 'M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z' })]);

const mainMenu = [
  { name: 'Dashboard', path: '/admin/dashboard', icon: IconGrid },
  { name: 'Kelola User', path: '/admin/users', icon: IconUsers, badge: '' },
  { name: 'Moderasi Produk', path: '/admin/products', icon: IconBox },
  { name: 'Kelola Pesanan', path: '/admin/orders', icon: IconCart },
  { name: 'Analitik Global', path: '/admin/analytics', icon: IconChart },
];
const systemMenu = [
  { name: 'Role & Permission', path: '/admin/roles', icon: IconShield },
];

const isActive = (path) => route.path.startsWith(path);

const pageMap = {
  '/admin/dashboard': { title: 'Dashboard', desc: 'Ringkasan performa platform SnapFit' },
  '/admin/users': { title: 'Kelola User', desc: 'Manajemen semua pengguna platform' },
  '/admin/products': { title: 'Moderasi Produk', desc: 'Review dan moderasi produk UMKM' },
  '/admin/orders': { title: 'Kelola Pesanan', desc: 'Pantau seluruh transaksi marketplace' },
  '/admin/analytics': { title: 'Analitik Global', desc: 'Insight dan metrik performa platform' },
  '/admin/roles': { title: 'Role & Permission', desc: 'Manajemen akses dan hak pengguna' },
};
const currentPageTitle = computed(() => { const m = Object.entries(pageMap).find(([p]) => route.path.startsWith(p)); return m ? m[1].title : 'Admin'; });
const currentPageDesc = computed(() => { const m = Object.entries(pageMap).find(([p]) => route.path.startsWith(p)); return m ? m[1].desc : ''; });

const logout = () => { localStorage.removeItem('user'); localStorage.removeItem('token'); router.push('/login'); };
</script>

<style scoped>
.no-scrollbar::-webkit-scrollbar { display: none; }
.no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
.fade-enter-active, .fade-leave-active { transition: opacity 0.2s ease; }
.fade-enter-from, .fade-leave-to { opacity: 0; }
</style>
