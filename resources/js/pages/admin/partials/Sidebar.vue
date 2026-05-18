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
          <img :src="'/images/logo.png'" alt="SnapFit Logo" class="w-full h-full object-contain" />
        </div>
        <div>
          <span class="font-bold text-[16px] text-espresso tracking-tight">SnapFit</span>
          <span class="text-[10px] font-semibold text-muted block -mt-0.5 tracking-wide">Management Console</span>
        </div>
      </div>
    </div>

    <!-- Nav -->
    <nav class="flex-1 overflow-y-auto py-6 px-4 no-scrollbar">
      <p class="px-3 text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-3">Overview</p>
      <router-link v-for="item in mainMenu" :key="item.name" :to="item.path" @click="$emit('close')"
        class="flex items-center gap-3.5 px-3.5 py-3 rounded-xl mb-1 transition-all duration-200 text-[13px] font-semibold group relative"
        :class="[isActive(item.path) ? 'bg-gradient-to-r from-orange-50 to-orange-50/50 text-terracotta shadow-sm' : 'text-muted hover:text-espresso hover:bg-slate-50']">
        <div v-if="isActive(item.path)" class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-8 bg-terracotta rounded-r-full"></div>
        <component :is="item.icon" class="w-5 h-5 flex-shrink-0 transition-transform group-hover:scale-110"
          :class="[isActive(item.path) ? 'text-terracotta' : 'text-slate-400 group-hover:text-muted']" />
        <span class="flex-1">{{ item.name }}</span>
        <span v-if="item.badge" class="text-[10px] font-bold bg-terracotta text-white px-2 py-0.5 rounded-full shadow-sm">{{ item.badge }}</span>
      </router-link>

      <div class="h-px bg-slate-100 my-5 mx-3"></div>

      <p class="px-3 text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-3">System</p>
      <router-link v-for="item in systemMenu" :key="item.name" :to="item.path" @click="$emit('close')"
        class="flex items-center gap-3.5 px-3.5 py-3 rounded-xl mb-1 transition-all duration-200 text-[13px] font-semibold group relative"
        :class="[isActive(item.path) ? 'bg-gradient-to-r from-orange-50 to-orange-50/50 text-terracotta shadow-sm' : 'text-muted hover:text-espresso hover:bg-slate-50']">
        <div v-if="isActive(item.path)" class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-8 bg-terracotta rounded-r-full"></div>
        <component :is="item.icon" class="w-5 h-5 flex-shrink-0 transition-transform group-hover:scale-110"
          :class="[isActive(item.path) ? 'text-terracotta' : 'text-slate-400 group-hover:text-muted']" />
        <span class="flex-1">{{ item.name }}</span>
      </router-link>
    </nav>

    <!-- User Card -->
    <div class="p-4 border-t border-borderSoft bg-slate-50/50">
      <div class="flex items-center gap-3 px-3 py-3 rounded-xl hover:bg-surface transition-all cursor-pointer group border border-transparent hover:border-borderSoft hover:shadow-sm">
        <div class="w-10 h-10 bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl flex items-center justify-center text-white text-sm font-bold shadow-md">
          {{ user?.name ? user.name.charAt(0) : 'A' }}
        </div>
        <div class="flex-1 min-w-0">
          <p class="text-[13px] font-bold text-espresso truncate">{{ user?.name || 'Administrator' }}</p>
          <p class="text-[11px] text-muted truncate">{{ user?.email || 'admin@snapfit.id' }}</p>
        </div>
        <button @click="$emit('logout')" class="w-8 h-8 flex items-center justify-center rounded-lg text-slate-400 hover:bg-red-50 hover:text-red-500 transition-all opacity-0 group-hover:opacity-100">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
        </button>
      </div>
    </div>
  </aside>
</template>

<script setup>
import { useRoute } from 'vue-router';
import { h } from 'vue';

defineProps({
  sidebarOpen: Boolean,
  user: Object
});

defineEmits(['close', 'logout']);

const route = useRoute();

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
</script>

<style scoped>
.no-scrollbar::-webkit-scrollbar { display: none; }
.no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
</style>
