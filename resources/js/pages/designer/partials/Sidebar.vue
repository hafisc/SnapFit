<template>
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
        <div class="w-8 h-8 bg-orange-500 rounded-lg flex items-center justify-center overflow-hidden">
          <img src="/images/logo.png" alt="SnapFit Logo" class="w-full h-full object-contain p-1" />
        </div>
        <div>
          <span class="font-extrabold text-[15px] text-slate-800 tracking-tight">SnapFit</span>
          <span class="text-[10px] font-semibold text-slate-400 block -mt-0.5 tracking-wide">Designer Studio</span>
        </div>
      </div>
    </div>

    <!-- Nav -->
    <nav class="flex-1 overflow-y-auto py-5 px-3.5 no-scrollbar">
      <p class="px-3 text-[9px] font-bold uppercase tracking-[0.2em] text-slate-400 mb-3">Menu Utama</p>
      <router-link v-for="item in menuItems" :key="item.name" :to="item.path" @click="$emit('close')"
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
      <router-link to="/designer/settings" @click="$emit('close')"
        class="flex items-center gap-3 px-3.5 py-[10px] rounded-xl mb-0.5 transition-all duration-150 text-[13px] font-medium group"
        :class="[isActive('/designer/settings') ? 'bg-orange-50 text-orange-600' : 'text-slate-500 hover:text-slate-800 hover:bg-slate-50']">
        <div class="w-[34px] h-[34px] rounded-lg flex items-center justify-center transition-all"
          :class="[isActive('/designer/settings') ? 'bg-orange-500 text-white shadow-sm shadow-orange-500/20' : 'bg-slate-100 text-slate-400 group-hover:text-slate-600']">
          <span class="text-sm">⚙️</span>
        </div>
        <span>Pengaturan Profil</span>
      </router-link>
    </nav>

    <!-- User -->
    <div class="p-3.5 border-t border-slate-100">
      <div class="flex items-center gap-3 px-3 py-3 rounded-xl hover:bg-slate-50 transition-colors cursor-pointer group">
        <div class="w-9 h-9 bg-orange-500 rounded-lg flex items-center justify-center text-white text-sm font-bold">
          {{ user?.name ? user.name.charAt(0) : 'D' }}
        </div>
        <div class="flex-1 min-w-0">
          <p class="text-[13px] font-semibold text-slate-800 truncate">{{ user?.name || 'Designer' }}</p>
          <p class="text-[11px] text-slate-400 truncate">{{ user?.email || 'designer@snapfit.id' }}</p>
        </div>
        <button @click="$emit('logout')" class="w-8 h-8 flex items-center justify-center rounded-lg text-slate-400 hover:bg-red-50 hover:text-red-500 transition-all opacity-0 group-hover:opacity-100">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
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
