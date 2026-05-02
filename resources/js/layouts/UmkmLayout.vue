<template>
  <div class="min-h-screen bg-slate-100 flex text-slate-800 font-sans selection:bg-orange-100 selection:text-orange-900">
    <!-- Sidebar Utama -->
    <aside class="w-72 bg-white border-r border-slate-100 flex flex-col z-20 hidden md:flex sticky top-0 h-screen shadow-[4px_0_24px_rgba(0,0,0,0.02)]">
      <!-- Area Logo -->
      <div class="h-20 flex items-center px-8 border-b border-slate-100">
        <div class="flex items-center gap-3">
          <div class="w-8 h-8 bg-orange-500 rounded-xl flex items-center justify-center rotate-3 shadow-sm">
            <span class="text-white font-black text-sm italic">S</span>
          </div>
          <span class="font-black tracking-tighter text-xl italic text-slate-800">SnapFit<span class="text-orange-500">UMKM</span></span>
        </div>
      </div>

      <!-- Navigasi Utama -->
      <nav class="flex-1 overflow-y-auto py-6 px-4 space-y-1 no-scrollbar">
        <p class="px-4 text-[10px] font-black uppercase tracking-widest text-slate-400 mb-4">Menu Utama</p>

        <router-link
          v-for="item in menuItems"
          :key="item.name"
          :to="item.path"
          class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all duration-200 font-bold text-sm group"
          :class="[
            $route.path === item.path
              ? 'bg-orange-50 text-orange-600'
              : 'text-slate-500 hover:bg-slate-50 hover:text-slate-800'
          ]"
        >
          <div
            class="w-8 h-8 rounded-xl flex items-center justify-center transition-all duration-200"
            :class="[
              $route.path === item.path
                ? 'bg-orange-100 text-orange-600'
                : 'bg-slate-100 text-slate-400 group-hover:bg-slate-200 group-hover:text-slate-600'
            ]"
          >
            <component :is="item.icon" class="w-4 h-4" />
          </div>
          {{ item.name }}
        </router-link>
      </nav>

      <!-- Profil Pengguna -->
      <div class="p-4 border-t border-slate-100">
        <div class="bg-slate-50 rounded-[1.5rem] p-4 flex items-center gap-3 border border-slate-100 hover:border-orange-200 transition-colors cursor-pointer group">
          <div class="w-10 h-10 bg-white border border-slate-200 rounded-xl flex items-center justify-center font-black text-lg text-orange-500 uppercase shadow-sm">
            {{ user?.name ? user.name.charAt(0) : 'U' }}
          </div>
          <div class="flex-1 w-0">
            <p class="text-sm font-bold tracking-tight text-slate-800 truncate">{{ user?.name || 'UMKM Kreator' }}</p>
            <p class="text-[10px] text-slate-500 font-medium truncate">{{ user?.email || 'user@snapfit.id' }}</p>
          </div>
          <button @click="logout" class="w-8 h-8 flex items-center justify-center rounded-lg text-slate-400 hover:bg-red-50 hover:text-red-500 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
          </button>
        </div>
      </div>
    </aside>

    <!-- Konten Utama -->
    <main class="flex-1 flex flex-col min-w-0 overflow-hidden relative">
      <!-- Header Atas -->
      <header class="h-20 bg-white/80 backdrop-blur-md border-b border-slate-100 sticky top-0 z-50 px-8 flex items-center justify-between">
        <div>
          <h1 class="text-xl font-black tracking-tighter text-slate-800 capitalize">{{ currentRouteName }}</h1>
          
        </div>

        <div class="flex items-center gap-4">
          <!-- Notifikasi -->
          <button class="w-10 h-10 bg-slate-50 rounded-xl flex items-center justify-center text-slate-400 hover:bg-slate-100 hover:text-slate-600 transition-colors relative border border-slate-100">
            <span class="absolute top-2.5 right-2.5 w-2 h-2 bg-orange-500 rounded-full"></span>
            <span class="absolute top-2.5 right-2.5 w-2 h-2 bg-orange-500 rounded-full animate-ping"></span>
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" /></svg>
          </button>
        </div>
      </header>

      <!-- Slot Halaman -->
      <div class="flex-1 overflow-y-auto p-8 no-scrollbar relative">
        <RouterView />
      </div>
    </main>
  </div>
</template>

<script setup>
import { computed, ref, onMounted } from 'vue';
import { useRouter, useRoute } from 'vue-router';
import { h } from 'vue';

const IconDashboard = () => h('svg', { fill: 'none', stroke: 'currentColor', viewBox: '0 0 24 24', 'stroke-width': '2' }, [
  h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', d: 'M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z' })
]);
const IconStudio = () => h('svg', { fill: 'none', stroke: 'currentColor', viewBox: '0 0 24 24', 'stroke-width': '2' }, [
  h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', d: 'M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z' })
]);
const IconProducts = () => h('svg', { fill: 'none', stroke: 'currentColor', viewBox: '0 0 24 24', 'stroke-width': '2' }, [
  h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', d: 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4' })
]);
const IconCoCreate = () => h('svg', { fill: 'none', stroke: 'currentColor', viewBox: '0 0 24 24', 'stroke-width': '2' }, [
  h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', d: 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z' })
]);
const IconOrder = () => h('svg', { fill: 'none', stroke: 'currentColor', viewBox: '0 0 24 24', 'stroke-width': '2' }, [
  h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', d: 'M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z' })
]);
const IconAnalytics = () => h('svg', { fill: 'none', stroke: 'currentColor', viewBox: '0 0 24 24', 'stroke-width': '2' }, [
  h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', d: 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z' })
]);
const IconSettings = () => h('svg', { fill: 'none', stroke: 'currentColor', viewBox: '0 0 24 24', 'stroke-width': '2' }, [
  h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', d: 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z' }),
  h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', d: 'M15 12a3 3 0 11-6 0 3 3 0 016 0z' })
]);

const router = useRouter();
const route = useRoute();
const user = ref(null);

const menuItems = [
  { name: 'Dashboard', path: '/umkm/dashboard', icon: IconDashboard },
  { name: 'AI Product Studio', path: '/umkm/studio', icon: IconStudio },
  { name: 'Produk Saya', path: '/umkm/products', icon: IconProducts },
  { name: 'Co-Create Room', path: '/umkm/cocreate', icon: IconCoCreate },
  { name: 'Pesanan / Order', path: '/umkm/orders', icon: IconOrder },
  { name: 'Analitik & Insight', path: '/umkm/analytics', icon: IconAnalytics },
  { name: 'Pengaturan', path: '/umkm/settings', icon: IconSettings },
];

const currentRouteName = computed(() => {
  const match = menuItems.find(item => route.path.startsWith(item.path));
  return match ? match.name : 'Creator Hub';
});

const logout = () => {
  localStorage.removeItem('user');
  localStorage.removeItem('token');
  router.push('/login');
};

onMounted(() => {
  const userData = localStorage.getItem('user');
  if (userData) {
    user.value = JSON.parse(userData);
  }
});
</script>

<style scoped>
.no-scrollbar::-webkit-scrollbar { display: none; }
.no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
</style>
