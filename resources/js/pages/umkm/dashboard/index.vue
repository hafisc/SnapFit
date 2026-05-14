<template>
  <div class="max-w-[1400px] mx-auto space-y-6">
    <!-- Welcome Hero -->
    <div class="relative bg-gradient-to-br from-orange-500 via-orange-600 to-orange-700 rounded-2xl p-8 overflow-hidden">
      <!-- Animated Background Elements -->
      <div class="absolute inset-0 overflow-hidden">
        <div class="absolute -top-24 -right-24 w-96 h-96 bg-white/10 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-orange-800/20 rounded-full blur-3xl"></div>
      </div>
      
      <div class="relative z-10 flex items-center justify-between">
        <div>
          <p class="text-orange-100 text-sm font-medium mb-2">Selamat datang kembali 👋</p>
          <h1 class="text-3xl font-bold text-white mb-2">{{ user?.name || 'Kreator' }}</h1>
          <p class="text-orange-100 text-sm max-w-md">Kelola toko dan produk Anda dengan mudah. Lihat performa penjualan real-time.</p>
        </div>
        <div class="flex gap-3">
          <router-link to="/umkm/products/create" 
            class="group relative px-6 py-3 bg-white text-orange-600 rounded-xl font-semibold text-sm hover:shadow-xl hover:scale-105 transition-all duration-200">
            <span class="relative z-10 flex items-center gap-2">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
              </svg>
              Tambah Produk
            </span>
          </router-link>
          <router-link to="/umkm/studio" 
            class="group relative px-6 py-3 bg-white/10 backdrop-blur-sm text-white rounded-xl font-semibold text-sm border border-white/20 hover:bg-white/20 hover:scale-105 transition-all duration-200">
            <span class="relative z-10 flex items-center gap-2">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
              </svg>
              AI Studio
            </span>
          </router-link>
        </div>
      </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
      <div v-for="(stat, idx) in stats" :key="idx" 
        class="group relative bg-white rounded-2xl p-6 border border-slate-200/60 hover:border-slate-300 hover:shadow-xl transition-all duration-300 cursor-pointer overflow-hidden">
        <!-- Gradient Overlay on Hover -->
        <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none" 
          :class="stat.gradientOverlay"></div>
        
        <div class="relative z-10">
          <div class="flex items-start justify-between mb-4">
            <div class="p-3 rounded-xl transition-all duration-300 group-hover:scale-110" :class="stat.iconBg">
              <component :is="stat.icon" class="w-6 h-6" :class="stat.iconColor" />
            </div>
            <span class="px-3 py-1 text-xs font-bold rounded-full" :class="stat.badgeClass">
              {{ stat.change }}
            </span>
          </div>
          <div>
            <p class="text-sm font-medium text-slate-600 mb-1">{{ stat.label }}</p>
            <p class="text-3xl font-bold text-slate-900 tracking-tight">{{ stat.value }}</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Main Content -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
      <!-- Revenue Chart -->
      <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200/60 p-6 hover:shadow-lg transition-shadow duration-300">
        <div class="flex items-center justify-between mb-6">
          <div>
            <h3 class="text-lg font-bold text-slate-900 flex items-center gap-2">
              Ringkasan Pendapatan
              <span class="inline-flex items-center px-2 py-0.5 text-xs font-semibold text-emerald-700 bg-emerald-50 rounded-full">
                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd" />
                </svg>
                +14%
              </span>
            </h3>
            <p class="text-sm text-slate-500 mt-1">Performa 7 hari terakhir</p>
          </div>
          <div class="flex items-center gap-1 bg-slate-100 rounded-xl p-1">
            <button v-for="period in ['7H','1B','3B','1T']" :key="period" @click="activePeriod = period"
              class="px-4 py-2 text-xs font-bold rounded-lg transition-all duration-200"
              :class="activePeriod === period 
                ? 'bg-white text-slate-900 shadow-sm' 
                : 'text-slate-600 hover:text-slate-900 hover:bg-white/50'">
              {{ period }}
            </button>
          </div>
        </div>

        <div class="mb-8">
          <p class="text-4xl font-bold text-slate-900 mb-1">Rp 12.500.000</p>
          <p class="text-sm text-slate-500">Total pendapatan periode ini</p>
        </div>

        <div class="relative h-64">
          <!-- Grid Lines -->
          <div class="absolute inset-0 flex flex-col justify-between">
            <div v-for="i in 5" :key="i" class="flex items-center">
              <span class="text-xs text-slate-400 w-20 text-right pr-4">{{ formatChartValue(i) }}</span>
              <div class="flex-1 border-b border-dashed border-slate-200"></div>
            </div>
          </div>
          
          <!-- Chart Bars -->
          <div class="relative h-full flex items-end gap-3 pl-20 pt-4">
            <div v-for="(bar, idx) in chartData" :key="idx" 
              class="flex-1 group cursor-pointer"
              @mouseenter="hoveredBar = idx"
              @mouseleave="hoveredBar = null">
              <div class="relative">
                <!-- Tooltip -->
                <div v-if="hoveredBar === idx" 
                  class="absolute -top-12 left-1/2 -translate-x-1/2 bg-slate-900 text-white px-3 py-2 rounded-lg text-xs font-semibold whitespace-nowrap z-10 animate-fade-in">
                  Rp {{ bar.amount }}
                  <div class="absolute -bottom-1 left-1/2 -translate-x-1/2 w-2 h-2 bg-slate-900 rotate-45"></div>
                </div>
                
                <!-- Bar -->
                <div class="w-full rounded-t-xl transition-all duration-300 relative overflow-hidden"
                  :class="[
                    hoveredBar === idx ? 'opacity-100 scale-105' : 'opacity-90',
                    idx === chartData.length - 1 
                      ? 'bg-gradient-to-t from-orange-600 to-orange-500' 
                      : 'bg-gradient-to-t from-slate-300 to-slate-200'
                  ]"
                  :style="{ height: bar.value + '%' }">
                  <!-- Shine Effect -->
                  <div class="absolute inset-0 bg-gradient-to-t from-transparent via-white/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                </div>
              </div>
              <p class="text-xs text-slate-600 text-center mt-3 font-medium">{{ bar.label }}</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Recent Orders -->
      <div class="bg-white rounded-2xl border border-slate-200/60 p-6 hover:shadow-lg transition-shadow duration-300">
        <div class="flex items-center justify-between mb-6">
          <h3 class="text-lg font-bold text-slate-900">Pesanan Terbaru</h3>
          <router-link to="/umkm/orders" 
            class="text-sm font-semibold text-orange-500 hover:text-orange-600 transition-colors flex items-center gap-1 group">
            Lihat Semua
            <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
            </svg>
          </router-link>
        </div>
        
        <div class="space-y-3">
          <div v-if="recentOrders.length === 0" class="text-center py-8">
            <div class="w-16 h-16 mx-auto mb-3 rounded-full bg-slate-100 flex items-center justify-center">
              <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
              </svg>
            </div>
            <p class="text-sm text-slate-500 font-medium">Belum ada pesanan</p>
          </div>
          <div v-for="order in recentOrders" :key="order.id" 
            class="group flex items-center gap-3 p-3 rounded-xl hover:bg-gradient-to-r hover:from-orange-50 hover:to-transparent border border-transparent hover:border-orange-100 transition-all duration-200 cursor-pointer">
            <div class="relative flex-shrink-0">
              <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-slate-100 to-slate-50 flex items-center justify-center group-hover:scale-110 transition-transform duration-200">
                <span class="text-sm font-bold text-slate-700">{{ order.customer.charAt(0) }}</span>
              </div>
              <div class="absolute -bottom-1 -right-1 w-4 h-4 rounded-full border-2 border-white shadow-sm" 
                :class="order.status === 'Selesai' ? 'bg-emerald-500' : 'bg-amber-500'"></div>
            </div>
            <div class="flex-1 min-w-0">
              <p class="text-sm font-semibold text-slate-900 truncate group-hover:text-orange-600 transition-colors">
                {{ order.customer }}
              </p>
              <p class="text-xs text-slate-500">{{ order.id }}</p>
            </div>
            <div class="text-right">
              <p class="text-sm font-bold text-slate-900">{{ formatCurrency(order.total) }}</p>
              <span class="inline-block text-xs font-semibold px-2 py-0.5 rounded-full mt-1" 
                :class="order.status === 'Selesai' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700'">
                {{ order.status }}
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Top Products & Quick Actions -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
      <!-- Top Products -->
      <div class="bg-white rounded-2xl border border-slate-200/60 p-6 hover:shadow-lg transition-shadow duration-300">
        <div class="flex items-center justify-between mb-6">
          <h3 class="text-lg font-bold text-slate-900">Produk Terlaris</h3>
          <router-link to="/umkm/products" 
            class="text-sm font-semibold text-orange-500 hover:text-orange-600 transition-colors flex items-center gap-1 group">
            Lihat Semua
            <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
            </svg>
          </router-link>
        </div>
        
        <div class="space-y-4">
          <div v-if="topProducts.length === 0" class="text-center py-8">
            <div class="w-16 h-16 mx-auto mb-3 rounded-full bg-slate-100 flex items-center justify-center">
              <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
              </svg>
            </div>
            <p class="text-sm text-slate-500 font-medium">Belum ada data penjualan</p>
          </div>
          <div v-for="(product, idx) in topProducts" :key="idx" 
            class="group flex items-center gap-4 p-3 rounded-xl hover:bg-slate-50 border border-transparent hover:border-slate-200 transition-all duration-200 cursor-pointer">
            <div class="relative flex-shrink-0">
              <img :src="product.image" :alt="product.name" 
                class="w-14 h-14 rounded-xl object-cover group-hover:scale-105 transition-transform duration-200" />
              <div class="absolute -top-2 -left-2 w-6 h-6 rounded-full bg-gradient-to-br from-orange-500 to-orange-600 text-white text-xs font-bold flex items-center justify-center shadow-lg">
                {{ idx + 1 }}
              </div>
            </div>
            <div class="flex-1 min-w-0">
              <p class="text-sm font-semibold text-slate-900 truncate group-hover:text-orange-600 transition-colors">
                {{ product.name }}
              </p>
              <p class="text-xs text-slate-500 mt-0.5">{{ product.sales }} terjual</p>
            </div>
            <div class="flex items-center gap-1 px-2 py-1 rounded-lg bg-emerald-50">
              <svg class="w-3 h-3 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd" />
              </svg>
              <span class="text-xs font-bold text-emerald-700">{{ product.growth }}%</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Quick Actions -->
      <div class="bg-white rounded-2xl border border-slate-200/60 p-6 hover:shadow-lg transition-shadow duration-300">
        <h3 class="text-lg font-bold text-slate-900 mb-6">Aksi Cepat</h3>
        <div class="grid grid-cols-2 gap-4">
          <router-link v-for="(action, idx) in quickActions" :key="idx" :to="action.link"
            class="group relative p-5 rounded-xl border-2 border-slate-200 hover:border-transparent transition-all duration-300 overflow-hidden">
            <!-- Gradient Background on Hover -->
            <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-300" 
              :class="action.gradientBg"></div>
            
            <div class="relative z-10">
              <div class="w-12 h-12 rounded-xl mb-4 flex items-center justify-center transition-all duration-300" 
                :class="action.iconBg">
                <component :is="action.icon" class="w-6 h-6 transition-colors duration-300" :class="action.iconColor" />
              </div>
              <h4 class="text-sm font-bold text-slate-900 group-hover:text-white transition-colors duration-300 mb-1">
                {{ action.title }}
              </h4>
              <p class="text-xs text-slate-500 group-hover:text-white/80 transition-colors duration-300">
                {{ action.desc }}
              </p>
            </div>
          </router-link>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, h, onMounted } from 'vue';

const user = ref(JSON.parse(localStorage.getItem('user') || '{}'));
const activePeriod = ref('7H');
const hoveredBar = ref(null);
const loading = ref(true);

// Icons
const IconBox = () => h('svg', { fill: 'none', stroke: 'currentColor', viewBox: '0 0 24 24', 'stroke-width': '2' }, [
  h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', d: 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4' })
]);

const IconShoppingBag = () => h('svg', { fill: 'none', stroke: 'currentColor', viewBox: '0 0 24 24', 'stroke-width': '2' }, [
  h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', d: 'M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z' })
]);

const IconUsers = () => h('svg', { fill: 'none', stroke: 'currentColor', viewBox: '0 0 24 24', 'stroke-width': '2' }, [
  h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', d: 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z' })
]);

const IconCash = () => h('svg', { fill: 'none', stroke: 'currentColor', viewBox: '0 0 24 24', 'stroke-width': '2' }, [
  h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', d: 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z' })
]);

const IconPlus = () => h('svg', { fill: 'none', stroke: 'currentColor', viewBox: '0 0 24 24', 'stroke-width': '2.5' }, [
  h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', d: 'M12 4v16m8-8H4' })
]);

const IconLightbulb = () => h('svg', { fill: 'none', stroke: 'currentColor', viewBox: '0 0 24 24', 'stroke-width': '2' }, [
  h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', d: 'M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z' })
]);

const IconChart = () => h('svg', { fill: 'none', stroke: 'currentColor', viewBox: '0 0 24 24', 'stroke-width': '2' }, [
  h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', d: 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z' })
]);

const stats = ref([
  { label: 'Total Produk', value: '0', change: '+0', icon: IconBox, iconBg: 'bg-blue-50', iconColor: 'text-blue-600', badgeClass: 'bg-blue-100 text-blue-700', gradientOverlay: 'bg-gradient-to-br from-blue-50/50 to-transparent' },
  { label: 'Pesanan', value: '0', change: '+0', icon: IconShoppingBag, iconBg: 'bg-emerald-50', iconColor: 'text-emerald-600', badgeClass: 'bg-emerald-100 text-emerald-700', gradientOverlay: 'bg-gradient-to-br from-emerald-50/50 to-transparent' },
  { label: 'Kolaborasi', value: '0', change: 'Live', icon: IconUsers, iconBg: 'bg-purple-50', iconColor: 'text-purple-600', badgeClass: 'bg-purple-100 text-purple-700', gradientOverlay: 'bg-gradient-to-br from-purple-50/50 to-transparent' },
  { label: 'Pendapatan', value: 'Rp 0', change: '↑ 0%', icon: IconCash, iconBg: 'bg-orange-50', iconColor: 'text-orange-600', badgeClass: 'bg-emerald-100 text-emerald-700', gradientOverlay: 'bg-gradient-to-br from-orange-50/50 to-transparent' },
]);

const chartData = ref([
  { label: 'Sen', value: 45, amount: '1.8M' },
  { label: 'Sel', value: 52, amount: '2.1M' },
  { label: 'Rab', value: 38, amount: '1.5M' },
  { label: 'Kam', value: 65, amount: '2.6M' },
  { label: 'Jum', value: 58, amount: '2.3M' },
  { label: 'Sab', value: 82, amount: '3.3M' },
  { label: 'Min', value: 95, amount: '3.8M' },
]);

const recentOrders = ref([]);
const topProducts = ref([]);

const quickActions = [
  { title: 'Tambah Produk', desc: 'Upload produk baru', link: '/umkm/products/create', icon: IconPlus, iconBg: 'bg-blue-100 group-hover:bg-white', iconColor: 'text-blue-600 group-hover:text-white', gradientBg: 'bg-gradient-to-br from-blue-500 to-blue-600' },
  { title: 'AI Studio', desc: 'Generate visual AI', link: '/umkm/studio', icon: IconLightbulb, iconBg: 'bg-orange-100 group-hover:bg-white', iconColor: 'text-orange-600 group-hover:text-white', gradientBg: 'bg-gradient-to-br from-orange-500 to-orange-600' },
  { title: 'Co-Create', desc: 'Kolaborasi sekarang', link: '/umkm/cocreate', icon: IconUsers, iconBg: 'bg-purple-100 group-hover:bg-white', iconColor: 'text-purple-600 group-hover:text-white', gradientBg: 'bg-gradient-to-br from-purple-500 to-purple-600' },
  { title: 'Analitik', desc: 'Lihat insight', link: '/umkm/analytics', icon: IconChart, iconBg: 'bg-emerald-100 group-hover:bg-white', iconColor: 'text-emerald-600 group-hover:text-white', gradientBg: 'bg-gradient-to-br from-emerald-500 to-emerald-600' },
];

const formatCurrency = (value) => {
  if (value >= 1000000) return 'Rp ' + (value / 1000000).toFixed(1) + 'M';
  return 'Rp ' + (value / 1000).toFixed(0) + 'K';
};

const formatChartValue = (index) => {
  const values = ['4M', '3M', '2M', '1M', '0'];
  return values[index - 1] || '';
};

// Fetch dashboard data from API
const fetchDashboardData = async () => {
  try {
    loading.value = true;
    const token = localStorage.getItem('token');
    
    if (!token) {
      console.error('No token found');
      return;
    }

    const response = await fetch('/api/v1/umkm/dashboard', {
      headers: {
        'Authorization': `Bearer ${token}`,
        'Accept': 'application/json',
      }
    });

    if (!response.ok) {
      throw new Error('Failed to fetch dashboard data');
    }

    const data = await response.json();
    
    // Update stats
    if (data.stats) {
      stats.value[0].value = data.stats.total_products?.toString() || '0';
      stats.value[0].change = `+${data.stats.new_products || 0}`;
      
      stats.value[1].value = data.stats.total_orders?.toString() || '0';
      stats.value[1].change = `+${data.stats.new_orders || 0}`;
      
      stats.value[2].value = data.stats.active_collaborations?.toString() || '0';
      
      const revenue = data.stats.total_revenue || 0;
      stats.value[3].value = revenue >= 1000000 
        ? `Rp ${(revenue / 1000000).toFixed(1)}M` 
        : `Rp ${(revenue / 1000).toFixed(0)}K`;
      stats.value[3].change = `↑ ${data.stats.revenue_growth || 0}%`;
    }

    // Update recent orders
    if (data.recent_orders && Array.isArray(data.recent_orders)) {
      recentOrders.value = data.recent_orders.map(order => ({
        id: order.order_number || order.id,
        customer: order.customer_name || order.user?.name || 'Customer',
        total: order.total_amount || 0,
        status: order.status === 'completed' ? 'Selesai' : 'Diproses'
      }));
    }

    // Update top products
    if (data.top_products && Array.isArray(data.top_products)) {
      topProducts.value = data.top_products.map(product => ({
        name: product.name,
        sales: product.sales_count || 0,
        growth: product.growth_percentage || 0,
        image: product.image_url || product.images?.[0] || 'https://images.unsplash.com/photo-1598033129183-c4f50c736f10?w=80&fit=crop'
      }));
    }

    // Update chart data if available
    if (data.revenue_chart && Array.isArray(data.revenue_chart)) {
      const days = ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'];
      chartData.value = data.revenue_chart.map((item, idx) => ({
        label: days[idx] || item.day,
        value: item.percentage || 50,
        amount: item.amount >= 1000000 
          ? `${(item.amount / 1000000).toFixed(1)}M` 
          : `${(item.amount / 1000).toFixed(0)}K`
      }));
    }

  } catch (error) {
    console.error('Error fetching dashboard data:', error);
  } finally {
    loading.value = false;
  }
};

// Fetch data on component mount
onMounted(() => {
  fetchDashboardData();
});
</script>

<style scoped>
@keyframes fade-in {
  from {
    opacity: 0;
    transform: translateY(-10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.animate-fade-in {
  animation: fade-in 0.2s ease-out;
}
</style>
