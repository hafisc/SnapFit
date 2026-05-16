<template>
  <aside
    :class="[
      'w-[280px] bg-white flex flex-col z-40 h-screen border-r border-slate-200/80 shadow-sm',
      'fixed lg:sticky top-0 transition-transform duration-300 lg:translate-x-0',
      sidebarOpen ? 'translate-x-0' : '-translate-x-full'
    ]"
  >
    <!-- Logo -->
    <div class="h-20 flex items-center px-6 border-b border-slate-100">
      <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl flex items-center justify-center shadow-lg shadow-orange-500/25 overflow-hidden p-1.5">
          <img :src="'/images/logo.png'" alt="SnapFit Logo" class="w-full h-full object-contain" />
        </div>
        <div>
          <span class="font-bold text-[16px] text-slate-800 tracking-tight">SnapFit</span>
          <span class="text-[10px] font-semibold text-slate-500 block -mt-0.5 tracking-wide">Designer Studio</span>
        </div>
      </div>
    </div>

    <!-- Nav -->
    <nav class="flex-1 overflow-y-auto py-6 px-4 no-scrollbar">
      <p class="px-3 text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-3">Menu Utama</p>
      <router-link v-for="item in menuItems" :key="item.name" :to="item.path" @click="$emit('close')"
        class="flex items-center gap-3.5 px-3.5 py-3 rounded-xl mb-1 transition-all duration-200 text-[13px] font-semibold group relative"
        :class="[isActive(item.path) ? 'bg-gradient-to-r from-orange-50 to-orange-50/50 text-orange-600 shadow-sm' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50']">
        <div v-if="isActive(item.path)" class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-8 bg-orange-500 rounded-r-full"></div>
        <div class="w-[28px] h-[28px] flex items-center justify-center transition-transform group-hover:scale-110"
          :class="[isActive(item.path) ? 'text-orange-500' : 'text-slate-400 group-hover:text-slate-600']">
          <span class="text-lg leading-none">{{ item.emoji }}</span>
        </div>
        <span class="flex-1">{{ item.name }}</span>
        <span v-if="item.badge" class="text-[10px] font-bold bg-orange-500 text-white px-2 py-0.5 rounded-full shadow-sm">{{ item.badge }}</span>
      </router-link>

      <div class="h-px bg-slate-100 my-5 mx-3"></div>

      <p class="px-3 text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-3">Lainnya</p>
      <router-link to="/designer/settings" @click="$emit('close')"
        class="flex items-center gap-3.5 px-3.5 py-3 rounded-xl mb-1 transition-all duration-200 text-[13px] font-semibold group relative"
        :class="[isActive('/designer/settings') ? 'bg-gradient-to-r from-orange-50 to-orange-50/50 text-orange-600 shadow-sm' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50']">
        <div v-if="isActive('/designer/settings')" class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-8 bg-orange-500 rounded-r-full"></div>
        <div class="w-[28px] h-[28px] flex items-center justify-center transition-transform group-hover:scale-110"
          :class="[isActive('/designer/settings') ? 'text-orange-500' : 'text-slate-400 group-hover:text-slate-600']">
          <span class="text-lg leading-none">⚙️</span>
        </div>
        <span class="flex-1">Pengaturan Profil</span>
      </router-link>
    </nav>

    <!-- User -->
    <div class="p-4 border-t border-slate-100 bg-slate-50/50">
      <div class="flex items-center gap-3 px-3 py-3 rounded-xl hover:bg-white transition-all cursor-pointer group border border-transparent hover:border-slate-200 hover:shadow-sm">
        <div class="w-10 h-10 bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl flex items-center justify-center text-white text-sm font-bold shadow-md">
          {{ user?.name ? user.name.charAt(0) : 'D' }}
        </div>
        <div class="flex-1 min-w-0">
          <p class="text-[13px] font-bold text-slate-800 truncate">{{ user?.name || 'Designer' }}</p>
          <p class="text-[11px] text-slate-500 truncate">{{ user?.email || 'designer@snapfit.id' }}</p>
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

defineProps({
  sidebarOpen: Boolean,
  user: Object
});

defineEmits(['close', 'logout']);

const route = useRoute();

const menuItems = [
  { name: 'Dashboard', path: '/designer/dashboard', emoji: '📊' },
  { name: 'Co-Create Room', path: '/designer/cocreate', emoji: '🤝', badge: '3' },
  { name: 'Portofolio Desain', path: '/designer/portfolio', emoji: '🖼️' },
  { name: 'Riwayat Kolaborasi', path: '/designer/history', emoji: '📋' },
];

const isActive = (path) => route.path.startsWith(path);
</script>
