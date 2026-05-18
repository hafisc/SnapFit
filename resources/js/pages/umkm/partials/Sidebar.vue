<template>
  <aside
    :class="[
      'w-[280px] bg-surface flex flex-col z-40 h-screen border-r border-borderSoft/80 shadow-sm',
      'fixed lg:sticky top-0 transition-transform duration-300 lg:translate-x-0',
      sidebarOpen ? 'translate-x-0' : '-translate-x-full'
    ]"
  >
    <!-- Logo -->
    <div class="h-20 flex items-center px-6 border-b border-borderSoft">
      <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl flex items-center justify-center shadow-lg shadow-terracotta/50/25 overflow-hidden p-1.5">
          <img :src="logoUrl" alt="SnapFit Logo" class="w-full h-full object-contain" />
        </div>
        <div>
          <span class="font-bold text-[16px] text-espresso tracking-tight">SnapFit</span>
        </div>
      </div>
    </div>

    <!-- Nav -->
    <nav class="flex-1 overflow-y-auto py-6 px-4 no-scrollbar">
      <p class="px-3 text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-3">Menu Utama</p>
      <router-link
        v-for="item in menuItems"
        :key="item.name"
        :to="item.path"
        @click="$emit('close')"
        class="flex items-center gap-3.5 px-3.5 py-3 rounded-xl mb-1 transition-all duration-200 text-[13px] font-semibold group relative"
        :class="[isActive(item.path) ? 'bg-gradient-to-r from-orange-50 to-orange-50/50 text-terracotta shadow-sm' : 'text-muted hover:text-espresso hover:bg-slate-50']"
      >
        <div v-if="isActive(item.path)" class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-8 bg-terracotta rounded-r-full"></div>
        <component
          :is="item.icon"
          class="w-5 h-5 flex-shrink-0 transition-transform group-hover:scale-110"
          :class="[isActive(item.path) ? 'text-terracotta' : 'text-slate-400 group-hover:text-muted']"
        />
        <span class="flex-1">{{ item.name }}</span>
        <span v-if="item.badge" class="text-[10px] font-bold bg-terracotta text-white px-2 py-0.5 rounded-full shadow-sm">{{ item.badge }}</span>
      </router-link>

      <div class="h-px bg-slate-100 my-5 mx-3"></div>

      <p class="px-3 text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-3">Lainnya</p>
      <router-link
        to="/umkm/settings"
        @click="$emit('close')"
        class="flex items-center gap-3.5 px-3.5 py-3 rounded-xl mb-1 transition-all duration-200 text-[13px] font-semibold group relative"
        :class="[isActive('/umkm/settings') ? 'bg-gradient-to-r from-orange-50 to-orange-50/50 text-terracotta shadow-sm' : 'text-muted hover:text-espresso hover:bg-slate-50']"
      >
        <div v-if="isActive('/umkm/settings')" class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-8 bg-terracotta rounded-r-full"></div>
        <svg
          class="w-5 h-5 flex-shrink-0 transition-transform group-hover:rotate-90 duration-300"
          :class="[isActive('/umkm/settings') ? 'text-terracotta' : 'text-slate-400 group-hover:text-muted']"
          fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"
        >
          <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
          <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
        </svg>
        <span>Pengaturan</span>
      </router-link>

      <div class="h-px bg-slate-100 my-5 mx-3"></div>

      <router-link
        to="/profile"
        @click="$emit('close')"
        class="flex items-center gap-3.5 px-3.5 py-3 rounded-xl transition-all duration-200 text-[13px] font-semibold group text-muted hover:text-espresso hover:bg-slate-50"
      >
        <svg class="w-5 h-5 flex-shrink-0 text-slate-400 group-hover:text-muted transition-transform group-hover:-translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M11 17l-5-5m0 0l5-5m-5 5h12" />
        </svg>
        <span>Kembali ke Beranda</span>
      </router-link>
    </nav>

    <!-- User -->
    <div class="p-4 border-t border-borderSoft bg-slate-50/50">
      <div class="flex items-center gap-3 px-3 py-3 rounded-xl hover:bg-surface transition-all cursor-pointer group border border-transparent hover:border-borderSoft hover:shadow-sm">
        <div class="w-10 h-10 bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl flex items-center justify-center text-white text-sm font-bold shadow-md">
          {{ user?.name ? user.name.charAt(0) : 'U' }}
        </div>
        <div class="flex-1 min-w-0">
          <p class="text-[13px] font-bold text-espresso truncate">{{ user?.name || 'UMKM Kreator' }}</p>
          <p class="text-[11px] text-muted truncate">{{ user?.email || 'umkm@snapfit.id' }}</p>
        </div>
        <button
          @click="$emit('logout')"
          class="w-8 h-8 flex items-center justify-center rounded-lg text-slate-400 hover:bg-red-50 hover:text-red-500 transition-all opacity-0 group-hover:opacity-100"
        >
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
          </svg>
        </button>
      </div>
    </div>
  </aside>
</template>

<script setup>
import { h } from 'vue';
import { useRoute } from 'vue-router';

defineProps({
  sidebarOpen: {
    type: Boolean,
    default: false,
  },
  user: {
    type: Object,
    default: null,
  },
});

defineEmits(['close', 'logout']);

const route = useRoute();
const logoUrl = '/images/logo.png';

const isActive = (path) => route.path.startsWith(path);

// Icon Components
const IconDashboard = () => h('svg', { fill: 'none', stroke: 'currentColor', viewBox: '0 0 24 24', 'stroke-width': '2' }, [
  h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', d: 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6' }),
]);

const IconStudio = () => h('svg', { fill: 'none', stroke: 'currentColor', viewBox: '0 0 24 24', 'stroke-width': '2' }, [
  h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', d: 'M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z' }),
]);

const IconProducts = () => h('svg', { fill: 'none', stroke: 'currentColor', viewBox: '0 0 24 24', 'stroke-width': '2' }, [
  h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', d: 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4' }),
]);

const IconCoCreate = () => h('svg', { fill: 'none', stroke: 'currentColor', viewBox: '0 0 24 24', 'stroke-width': '2' }, [
  h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', d: 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z' }),
]);

const IconOrders = () => h('svg', { fill: 'none', stroke: 'currentColor', viewBox: '0 0 24 24', 'stroke-width': '2' }, [
  h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', d: 'M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z' }),
]);

const IconAnalytics = () => h('svg', { fill: 'none', stroke: 'currentColor', viewBox: '0 0 24 24', 'stroke-width': '2' }, [
  h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', d: 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z' }),
]);

const menuItems = [
  { name: 'Dashboard', path: '/umkm/dashboard', icon: IconDashboard },
  { name: 'AI Product Studio', path: '/umkm/studio', icon: IconStudio },
  { name: 'Produk Saya', path: '/umkm/products', icon: IconProducts },
  { name: 'Co-Create Room', path: '/umkm/cocreate', icon: IconCoCreate, badge: '2' },
  { name: 'Pesanan', path: '/umkm/orders', icon: IconOrders },
  { name: 'Analitik', path: '/umkm/analytics', icon: IconAnalytics },
];
</script>

<style scoped>
.no-scrollbar::-webkit-scrollbar { display: none; }
.no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
</style>
