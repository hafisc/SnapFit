<template>
  <aside
    :class="[
      'w-[272px] bg-[#FFFCF7] flex flex-col z-40 h-screen border-r border-[#E8DCCB]/80',
      'fixed lg:sticky top-0 transition-transform duration-300 lg:translate-x-0',
      sidebarOpen ? 'translate-x-0' : '-translate-x-full'
    ]"
  >
    <!-- Brand Area -->
    <div class="px-6 pt-6 pb-5 border-b border-[#E8DCCB]/60">
      <div class="flex items-center gap-3">
        <div class="w-9 h-9 rounded-xl overflow-hidden flex items-center justify-center bg-white border border-[#E8DCCB]/60 shadow-sm p-1">
          <img :src="logoUrl" alt="SnapFit" class="w-full h-full object-contain" />
        </div>
        <div>
          <span class="font-bold text-[15px] text-[#2B1E16] tracking-tight leading-none">SnapFit</span>
        </div>
      </div>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 overflow-y-auto py-5 px-4 no-scrollbar">
      <!-- Overview -->
      <div class="mb-6">
        <p class="px-3 text-[10px] font-bold uppercase tracking-[0.08em] text-[#8A7A6C]/70 mb-2">Overview</p>
        <router-link
          v-for="item in overviewItems"
          :key="item.name"
          :to="item.path"
          @click="$emit('close')"
          class="flex items-center gap-3 px-3 py-2.5 rounded-xl mb-1 transition-all duration-200 text-[13px] font-medium group relative"
          :class="[isActive(item.path) ? 'bg-[#B85C38]/10 text-[#2B1E16] font-semibold' : 'text-[#6F6259] hover:bg-[#F8F1E7] hover:text-[#2B1E16]']"
        >
          <div v-if="isActive(item.path)" class="absolute left-0 top-1/2 -translate-y-1/2 w-[3px] h-7 bg-[#B85C38] rounded-r-full"></div>
          <component :is="item.icon" class="w-[18px] h-[18px] flex-shrink-0 transition-colors" :class="[isActive(item.path) ? 'text-[#B85C38]' : 'text-[#8A7A6C] group-hover:text-[#B85C38]']" />
          <span class="flex-1">{{ item.name }}</span>
        </router-link>
      </div>

      <!-- Creative Tools -->
      <div class="mb-6">
        <p class="px-3 text-[10px] font-bold uppercase tracking-[0.08em] text-[#8A7A6C]/70 mb-2">Creative Tools</p>
        <router-link
          v-for="item in creativeItems"
          :key="item.name"
          :to="item.path"
          @click="$emit('close')"
          class="flex items-center gap-3 px-3 py-2.5 rounded-xl mb-1 transition-all duration-200 text-[13px] font-medium group relative"
          :class="[isActive(item.path) ? 'bg-[#B85C38]/10 text-[#2B1E16] font-semibold' : 'text-[#6F6259] hover:bg-[#F8F1E7] hover:text-[#2B1E16]']"
        >
          <div v-if="isActive(item.path)" class="absolute left-0 top-1/2 -translate-y-1/2 w-[3px] h-7 bg-[#B85C38] rounded-r-full"></div>
          <component :is="item.icon" class="w-[18px] h-[18px] flex-shrink-0 transition-colors" :class="[isActive(item.path) ? 'text-[#B85C38]' : 'text-[#8A7A6C] group-hover:text-[#B85C38]']" />
          <span class="flex-1">{{ item.name }}</span>
          <span v-if="item.badge" class="text-[9px] font-bold bg-[#B85C38] text-white w-5 h-5 rounded-full flex items-center justify-center shadow-sm">{{ item.badge }}</span>
        </router-link>
      </div>

      <!-- Commerce -->
      <div class="mb-6">
        <p class="px-3 text-[10px] font-bold uppercase tracking-[0.08em] text-[#8A7A6C]/70 mb-2">Commerce</p>
        <router-link
          v-for="item in commerceItems"
          :key="item.name"
          :to="item.path"
          @click="$emit('close')"
          class="flex items-center gap-3 px-3 py-2.5 rounded-xl mb-1 transition-all duration-200 text-[13px] font-medium group relative"
          :class="[isActive(item.path) ? 'bg-[#B85C38]/10 text-[#2B1E16] font-semibold' : 'text-[#6F6259] hover:bg-[#F8F1E7] hover:text-[#2B1E16]']"
        >
          <div v-if="isActive(item.path)" class="absolute left-0 top-1/2 -translate-y-1/2 w-[3px] h-7 bg-[#B85C38] rounded-r-full"></div>
          <component :is="item.icon" class="w-[18px] h-[18px] flex-shrink-0 transition-colors" :class="[isActive(item.path) ? 'text-[#B85C38]' : 'text-[#8A7A6C] group-hover:text-[#B85C38]']" />
          <span class="flex-1">{{ item.name }}</span>
        </router-link>
      </div>

      <!-- Insights -->
      <div class="mb-6">
        <p class="px-3 text-[10px] font-bold uppercase tracking-[0.08em] text-[#8A7A6C]/70 mb-2">Insights</p>
        <router-link
          to="/umkm/analytics"
          @click="$emit('close')"
          class="flex items-center gap-3 px-3 py-2.5 rounded-xl mb-1 transition-all duration-200 text-[13px] font-medium group relative"
          :class="[isActive('/umkm/analytics') ? 'bg-[#B85C38]/10 text-[#2B1E16] font-semibold' : 'text-[#6F6259] hover:bg-[#F8F1E7] hover:text-[#2B1E16]']"
        >
          <div v-if="isActive('/umkm/analytics')" class="absolute left-0 top-1/2 -translate-y-1/2 w-[3px] h-7 bg-[#B85C38] rounded-r-full"></div>
          <IconAnalytics class="w-[18px] h-[18px] flex-shrink-0 transition-colors" :class="[isActive('/umkm/analytics') ? 'text-[#B85C38]' : 'text-[#8A7A6C] group-hover:text-[#B85C38]']" />
          <span class="flex-1">Analitik</span>
        </router-link>
      </div>

      <!-- Account -->
      <div>
        <p class="px-3 text-[10px] font-bold uppercase tracking-[0.08em] text-[#8A7A6C]/70 mb-2">Account</p>
        <router-link
          to="/umkm/settings"
          @click="$emit('close')"
          class="flex items-center gap-3 px-3 py-2.5 rounded-xl mb-1 transition-all duration-200 text-[13px] font-medium group relative"
          :class="[isActive('/umkm/settings') ? 'bg-[#B85C38]/10 text-[#2B1E16] font-semibold' : 'text-[#6F6259] hover:bg-[#F8F1E7] hover:text-[#2B1E16]']"
        >
          <div v-if="isActive('/umkm/settings')" class="absolute left-0 top-1/2 -translate-y-1/2 w-[3px] h-7 bg-[#B85C38] rounded-r-full"></div>
          <IconSettings class="w-[18px] h-[18px] flex-shrink-0 transition-colors" :class="[isActive('/umkm/settings') ? 'text-[#B85C38]' : 'text-[#8A7A6C] group-hover:text-[#B85C38]']" />
          <span class="flex-1">Pengaturan</span>
        </router-link>

        <router-link
          to="/profile"
          @click="$emit('close')"
          class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 text-[13px] font-medium text-[#8A7A6C] hover:bg-[#F8F1E7] hover:text-[#2B1E16] group"
        >
          <svg class="w-[18px] h-[18px] flex-shrink-0 text-[#8A7A6C] group-hover:text-[#B85C38] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
            <path stroke-linecap="round" stroke-linejoin="round" d="M11 17l-5-5m0 0l5-5m-5 5h12" />
          </svg>
          <span class="flex-1">Kembali ke Beranda</span>
        </router-link>
      </div>
    </nav>

    <!-- User Card -->
    <div class="p-4 border-t border-[#E8DCCB]/60 bg-[#FAF6F0]">
      <div class="flex items-center gap-3 px-3 py-2.5 rounded-xl bg-white/60 border border-[#E8DCCB]/50">
        <div class="w-9 h-9 bg-gradient-to-br from-[#B85C38] to-[#D4845A] rounded-xl flex items-center justify-center text-white text-xs font-bold shadow-sm">
          {{ user?.name ? user.name.charAt(0) : 'U' }}
        </div>
        <div class="flex-1 min-w-0">
          <p class="text-[12px] font-bold text-[#2B1E16] truncate">{{ user?.name || 'UMKM Kreator' }}</p>
          <p class="text-[10px] text-[#8A7A6C] truncate">UMKM Aktif</p>
        </div>
        <button
          @click="$emit('logout')"
          class="w-7 h-7 flex items-center justify-center rounded-lg text-[#8A7A6C] hover:bg-red-50 hover:text-red-500 transition-all"
          title="Keluar"
        >
          <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
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
  sidebarOpen: { type: Boolean, default: false },
  user: { type: Object, default: null },
});

defineEmits(['close', 'logout']);

const route = useRoute();
const logoUrl = '/images/logo_snapfit.png';
const isActive = (path) => route.path.startsWith(path);

// Icons as render functions
const IconDashboard = () => h('svg', { fill: 'none', stroke: 'currentColor', viewBox: '0 0 24 24', 'stroke-width': '1.8' }, [
  h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', d: 'M4 5a1 1 0 011-1h4a1 1 0 011 1v5a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM14 5a1 1 0 011-1h4a1 1 0 011 1v2a1 1 0 01-1 1h-4a1 1 0 01-1-1V5zM4 15a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1v-4zM14 12a1 1 0 011-1h4a1 1 0 011 1v7a1 1 0 01-1 1h-4a1 1 0 01-1-1v-7z' }),
]);

const IconStudio = () => h('svg', { fill: 'none', stroke: 'currentColor', viewBox: '0 0 24 24', 'stroke-width': '1.8' }, [
  h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', d: 'M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z' }),
]);

const IconCoCreate = () => h('svg', { fill: 'none', stroke: 'currentColor', viewBox: '0 0 24 24', 'stroke-width': '1.8' }, [
  h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', d: 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z' }),
]);

const IconProducts = () => h('svg', { fill: 'none', stroke: 'currentColor', viewBox: '0 0 24 24', 'stroke-width': '1.8' }, [
  h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', d: 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4' }),
]);

const IconOrders = () => h('svg', { fill: 'none', stroke: 'currentColor', viewBox: '0 0 24 24', 'stroke-width': '1.8' }, [
  h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', d: 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01' }),
]);

const IconAnalytics = () => h('svg', { fill: 'none', stroke: 'currentColor', viewBox: '0 0 24 24', 'stroke-width': '1.8' }, [
  h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', d: 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z' }),
]);

const IconSettings = () => h('svg', { fill: 'none', stroke: 'currentColor', viewBox: '0 0 24 24', 'stroke-width': '1.8' }, [
  h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', d: 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z' }),
  h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', d: 'M15 12a3 3 0 11-6 0 3 3 0 016 0z' }),
]);

const overviewItems = [
  { name: 'Dashboard', path: '/umkm/dashboard', icon: IconDashboard },
];

const creativeItems = [
  { name: 'AI Product Studio', path: '/umkm/studio', icon: IconStudio },
  { name: 'Co-Create Room', path: '/umkm/cocreate', icon: IconCoCreate, badge: '2' },
];

const commerceItems = [
  { name: 'Produk Saya', path: '/umkm/products', icon: IconProducts },
  { name: 'Pesanan', path: '/umkm/orders', icon: IconOrders },
];
</script>

<style scoped>
.no-scrollbar::-webkit-scrollbar { display: none; }
.no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
</style>
