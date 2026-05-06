<template>
  <div class="min-h-screen bg-[#f4f5f7] flex text-slate-800 font-sans">
    <!-- Mobile Overlay -->
    <Transition name="fade">
      <div v-if="sidebarOpen" class="fixed inset-0 bg-black/20 backdrop-blur-sm z-30 lg:hidden" @click="sidebarOpen = false"></div>
    </Transition>

    <!-- Sidebar -->
    <aside
      :class="[
        'w-[260px] bg-white flex flex-col z-40 h-screen border-r border-slate-200/60',
        'fixed lg:sticky top-0 transition-transform duration-300 lg:translate-x-0',
        sidebarOpen ? 'translate-x-0' : '-translate-x-full'
      ]"
    >
      <!-- Logo -->
      <div class="h-[72px] flex items-center px-7 border-b border-slate-100">
        <div class="flex items-center gap-2.5">
          <div class="w-8 h-8 bg-orange-500 rounded-lg flex items-center justify-center">
            <span class="text-white font-extrabold text-sm">S</span>
          </div>
          <div>
            <span class="font-extrabold text-[15px] text-slate-800 tracking-tight">SnapFit</span>
            <span class="text-[10px] font-semibold text-slate-400 block -mt-0.5 tracking-wide">Creator Hub</span>
          </div>
        </div>
      </div>

      <!-- Nav -->
      <nav class="flex-1 overflow-y-auto py-5 px-3.5 no-scrollbar">
        <p class="px-3 text-[9px] font-bold uppercase tracking-[0.2em] text-slate-400 mb-3">Menu Utama</p>
        <router-link v-for="item in menuItems" :key="item.name" :to="item.path" @click="sidebarOpen = false"
          class="flex items-center gap-3 px-3.5 py-[10px] rounded-xl mb-0.5 transition-all duration-150 text-[13px] font-medium group"
          :class="[isActive(item.path) ? 'bg-orange-50 text-orange-600' : 'text-slate-500 hover:text-slate-800 hover:bg-slate-50']">
          <div class="w-[34px] h-[34px] rounded-lg flex items-center justify-center transition-all"
            :class="[isActive(item.path) ? 'bg-orange-500 text-white shadow-sm shadow-orange-500/20' : 'bg-slate-100 text-slate-400 group-hover:text-slate-600']">
            <span class="text-sm">{{ item.emoji }}</span>
          </div>
          <span>{{ item.name }}</span>
          <span v-if="item.badge" class="ml-auto text-[10px] font-bold bg-orange-500 text-white px-2 py-0.5 rounded-md">{{ item.badge }}</span>
        </router-link>

        <p class="px-3 text-[9px] font-bold uppercase tracking-[0.2em] text-slate-400 mb-3 mt-6">Lainnya</p>
        <router-link to="/umkm/settings" @click="sidebarOpen = false"
          class="flex items-center gap-3 px-3.5 py-[10px] rounded-xl mb-0.5 transition-all duration-150 text-[13px] font-medium group"
          :class="[isActive('/umkm/settings') ? 'bg-orange-50 text-orange-600' : 'text-slate-500 hover:text-slate-800 hover:bg-slate-50']">
          <div class="w-[34px] h-[34px] rounded-lg flex items-center justify-center transition-all"
            :class="[isActive('/umkm/settings') ? 'bg-orange-500 text-white shadow-sm shadow-orange-500/20' : 'bg-slate-100 text-slate-400 group-hover:text-slate-600']">
            <span class="text-sm">⚙️</span>
          </div>
          <span>Pengaturan</span>
        </router-link>
      </nav>

      <!-- User -->
      <div class="p-3.5 border-t border-slate-100">
        <div class="flex items-center gap-3 px-3 py-3 rounded-xl hover:bg-slate-50 transition-colors cursor-pointer group">
          <div class="w-9 h-9 bg-orange-500 rounded-lg flex items-center justify-center text-white text-sm font-bold">
            {{ user?.name ? user.name.charAt(0) : 'U' }}
          </div>
          <div class="flex-1 min-w-0">
            <p class="text-[13px] font-semibold text-slate-800 truncate">{{ user?.name || 'UMKM Kreator' }}</p>
            <p class="text-[11px] text-slate-400 truncate">{{ user?.email || 'umkm@snapfit.id' }}</p>
          </div>
          <button @click="logout" class="w-8 h-8 flex items-center justify-center rounded-lg text-slate-400 hover:bg-red-50 hover:text-red-500 transition-all opacity-0 group-hover:opacity-100">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
          </button>
        </div>
      </div>
    </aside>

    <!-- Main -->
    <main class="flex-1 flex flex-col min-w-0">
      <!-- Header -->
      <header class="h-[72px] bg-white border-b border-slate-200/60 sticky top-0 z-20 px-6 lg:px-8 flex items-center justify-between">
        <div class="flex items-center gap-4">
          <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden w-9 h-9 rounded-lg bg-slate-100 flex items-center justify-center text-slate-500">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /></svg>
          </button>
          <div>
            <h1 class="text-[15px] font-bold text-slate-800">{{ currentPageTitle }}</h1>
            <p class="text-[11px] text-slate-400 font-medium -mt-0.5">{{ currentPageDesc }}</p>
          </div>
        </div>

        <div class="flex items-center gap-2">
          <div class="hidden md:flex items-center bg-slate-50 rounded-lg px-3.5 py-2 gap-2 border border-slate-100">
            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
            <input type="text" placeholder="Cari sesuatu..." class="bg-transparent outline-none text-[12px] font-medium text-slate-600 w-40 placeholder:text-slate-400" />
          </div>
          <button class="w-9 h-9 rounded-lg bg-slate-50 flex items-center justify-center text-slate-400 hover:bg-slate-100 hover:text-slate-600 transition-colors relative border border-slate-100">
            <span class="absolute top-2 right-2 w-2 h-2 bg-orange-500 rounded-full"></span>
            <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" /></svg>
          </button>
        </div>
      </header>

      <!-- Content -->
      <div class="flex-1 overflow-y-auto p-6 lg:p-8 no-scrollbar">
        <RouterView />
      </div>
    </main>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import { useRouter, useRoute } from 'vue-router';

const sidebarOpen = ref(false);
const router = useRouter();
const route = useRoute();
const user = ref(null);

onMounted(() => { const d = localStorage.getItem('user'); if (d) user.value = JSON.parse(d); });

const menuItems = [
  { name: 'Dashboard', path: '/umkm/dashboard', emoji: '📊' },
  { name: 'AI Product Studio', path: '/umkm/studio', emoji: '🤖' },
  { name: 'Produk Saya', path: '/umkm/products', emoji: '📦' },
  { name: 'Co-Create Room', path: '/umkm/cocreate', emoji: '🤝', badge: '2' },
  { name: 'Pesanan', path: '/umkm/orders', emoji: '🛍️' },
  { name: 'Analitik', path: '/umkm/analytics', emoji: '📈' },
];

const isActive = (path) => route.path.startsWith(path);

const pageMap = {
  '/umkm/dashboard': { title: 'Dashboard', desc: 'Ringkasan performa toko dan penjualan' },
  '/umkm/studio': { title: 'AI Product Studio', desc: 'Generate foto produk, video 360°, dan caption AI' },
  '/umkm/products': { title: 'Produk Saya', desc: 'Kelola semua produk di toko Anda' },
  '/umkm/cocreate': { title: 'Co-Create Room', desc: 'Kolaborasi realtime dengan desainer' },
  '/umkm/orders': { title: 'Pesanan', desc: 'Kelola pesanan masuk dan pengiriman' },
  '/umkm/analytics': { title: 'Analitik & Insight', desc: 'Data penjualan dan performa produk' },
  '/umkm/settings': { title: 'Pengaturan', desc: 'Kelola profil toko dan preferensi akun' },
};
const currentPageTitle = computed(() => { const m = Object.entries(pageMap).find(([p]) => route.path.startsWith(p)); return m ? m[1].title : 'Creator Hub'; });
const currentPageDesc = computed(() => { const m = Object.entries(pageMap).find(([p]) => route.path.startsWith(p)); return m ? m[1].desc : ''; });

const logout = () => { localStorage.removeItem('user'); localStorage.removeItem('token'); router.push('/login'); };
</script>

<style scoped>
.no-scrollbar::-webkit-scrollbar { display: none; }
.no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
.fade-enter-active, .fade-leave-active { transition: opacity 0.2s ease; }
.fade-enter-from, .fade-leave-to { opacity: 0; }
</style>
