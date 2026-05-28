<template>
  <div class="w-full space-y-6">
    <!-- Welcome Hero -->
    <div class="relative bg-gradient-to-br from-[#2B1E16] via-[#3D2B1F] to-[#4A3428] rounded-2xl p-7 sm:p-8 overflow-hidden">
      <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-20 -right-20 w-80 h-80 bg-[#B85C38]/20 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-20 -left-20 w-60 h-60 bg-[#C9A45C]/10 rounded-full blur-3xl"></div>
        <div class="absolute top-0 right-0 w-full h-full opacity-[0.03]" style="background-image: url('data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%2260%22 height=%2260%22><circle cx=%2230%22 cy=%2230%22 r=%222%22 fill=%22white%22/></svg>');"></div>
      </div>

      <div class="relative z-10 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5">
        <div>
          <div class="flex items-center gap-2 mb-3">
            <span class="px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider bg-[#B85C38]/20 text-[#F0A882] rounded-lg border border-[#B85C38]/30">UMKM Terverifikasi</span>
            <span class="px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider bg-[#C9A45C]/20 text-[#E8C97A] rounded-lg border border-[#C9A45C]/30">AI Aktif</span>
          </div>
          <h1 class="text-2xl sm:text-3xl font-bold text-white mb-1.5">Selamat datang, {{ user?.name || 'Kreator' }}</h1>
          <p class="text-[#C4B5A6] text-sm max-w-lg">Kelola produk, visual katalog, pesanan, dan kolaborasi kreatif dari satu ruang kerja.</p>
        </div>
        <div class="flex flex-wrap gap-2.5">
          <router-link to="/umkm/products/create" class="px-5 py-2.5 bg-white text-[#2B1E16] rounded-xl font-semibold text-[13px] hover:shadow-lg hover:scale-[1.02] transition-all flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" /></svg>
            Tambah Produk
          </router-link>
          <router-link to="/umkm/studio" class="px-5 py-2.5 bg-white/10 backdrop-blur-sm text-white rounded-xl font-semibold text-[13px] border border-white/20 hover:bg-white/20 transition-all flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" /></svg>
            AI Studio
          </router-link>
          <router-link to="/umkm/cocreate" class="px-5 py-2.5 bg-white/10 backdrop-blur-sm text-white rounded-xl font-semibold text-[13px] border border-white/20 hover:bg-white/20 transition-all flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
            Kolaborasi
          </router-link>
        </div>
      </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
      <div v-for="(stat, idx) in stats" :key="idx" class="bg-white rounded-2xl p-5 border border-[#E8DCCB]/60 hover:shadow-md hover:border-[#E8DCCB] transition-all duration-200">
        <div class="flex items-center justify-between mb-3">
          <div class="w-10 h-10 rounded-xl flex items-center justify-center" :class="stat.iconBg">
            <component :is="stat.icon" class="w-5 h-5" :class="stat.iconColor" />
          </div>
          <span class="text-[10px] font-bold px-2 py-0.5 rounded-full" :class="stat.badgeClass">{{ stat.change }}</span>
        </div>
        <p class="text-2xl font-bold text-[#2B1E16] tracking-tight">{{ stat.value }}</p>
        <p class="text-[11px] text-[#8A7A6C] font-medium mt-0.5">{{ stat.label }}</p>
      </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
      <!-- Revenue Chart -->
      <div class="lg:col-span-2 bg-white rounded-2xl border border-[#E8DCCB]/60 p-6">
        <div class="flex items-center justify-between mb-5">
          <div>
            <h3 class="text-[15px] font-bold text-[#2B1E16]">Ringkasan Pendapatan</h3>
            <p class="text-[11px] text-[#8A7A6C] mt-0.5">Performa 7 hari terakhir</p>
          </div>
          <div class="flex items-center gap-1 bg-[#F8F1E7] rounded-xl p-1">
            <button v-for="period in ['7H','1B','3B']" :key="period" @click="activePeriod = period"
              class="px-3 py-1.5 text-[11px] font-bold rounded-lg transition-all"
              :class="activePeriod === period ? 'bg-white text-[#2B1E16] shadow-sm' : 'text-[#8A7A6C] hover:text-[#2B1E16]'">
              {{ period }}
            </button>
          </div>
        </div>

        <div class="mb-6">
          <p class="text-3xl font-bold text-[#2B1E16]">{{ formatCurrencyFull(totalRevenue) }}</p>
          <p class="text-xs font-semibold mt-1 flex items-center gap-1"
            :class="revenueGrowth >= 0 ? 'text-[#0F8A4B]' : 'text-red-500'">
            <svg v-if="revenueGrowth >= 0" class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd" /></svg>
            <svg v-else class="w-3 h-3 rotate-180" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd" /></svg>
            {{ revenueGrowth >= 0 ? '+' : '' }}{{ revenueGrowth }}% dari bulan lalu
          </p>
        </div>

        <!-- Chart -->
        <div class="relative h-48">
          <div class="absolute inset-0 flex flex-col justify-between pointer-events-none">
            <div v-for="i in 4" :key="i" class="border-b border-dashed border-[#E8DCCB]/60"></div>
          </div>
          <div class="relative h-full flex items-end gap-2 sm:gap-3">
            <div v-for="(bar, idx) in chartData" :key="idx" class="h-full flex-1 flex flex-col justify-end group cursor-pointer"
              @mouseenter="hoveredBar = idx" @mouseleave="hoveredBar = null">
              <div class="relative w-full h-[calc(100%-24px)] flex flex-col justify-end">
                <div v-if="hoveredBar === idx" class="absolute -top-10 left-1/2 -translate-x-1/2 bg-[#2B1E16] text-white px-2.5 py-1.5 rounded-lg text-[10px] font-bold whitespace-nowrap z-10">
                  Rp {{ bar.amount }}
                </div>
                <div class="w-full rounded-t-lg transition-all duration-200"
                  :class="idx === chartData.length - 1 ? 'bg-gradient-to-t from-[#B85C38] to-[#D4845A]' : 'bg-gradient-to-t from-[#E8DCCB] to-[#F0E6D8]'"
                  :style="{ height: bar.value + '%', minHeight: '8px' }"></div>
              </div>
              <p class="text-[10px] text-[#8A7A6C] text-center mt-2 font-medium">{{ bar.label }}</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Recent Orders -->
      <div class="bg-white rounded-2xl border border-[#E8DCCB]/60 p-6">
        <div class="flex items-center justify-between mb-5">
          <h3 class="text-[15px] font-bold text-[#2B1E16]">Pesanan Terbaru</h3>
          <router-link to="/umkm/orders" class="text-[11px] font-bold text-[#B85C38] hover:underline flex items-center gap-1">
            Lihat Semua
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg>
          </router-link>
        </div>

        <div class="space-y-2.5">
          <div v-if="recentOrders.length === 0" class="text-center py-10">
            <div class="w-14 h-14 mx-auto mb-3 rounded-2xl bg-[#F8F1E7] flex items-center justify-center">
              <svg class="w-6 h-6 text-[#B85C38]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg>
            </div>
            <p class="text-sm font-semibold text-[#2B1E16] mb-1">Belum ada pesanan</p>
            <p class="text-[11px] text-[#8A7A6C] max-w-[200px] mx-auto">Produk yang sudah dipublish akan muncul di marketplace.</p>
          </div>
          <div v-for="order in recentOrders.slice(0, 5)" :key="order.id"
            class="flex items-center gap-3 p-3 rounded-xl hover:bg-[#FAF6F0] transition-colors cursor-pointer group">
            <div class="w-9 h-9 rounded-xl bg-[#F8F1E7] flex items-center justify-center flex-shrink-0 group-hover:bg-[#B85C38]/10 transition-colors">
              <span class="text-xs font-bold text-[#B85C38]">{{ order.customer.charAt(0) }}</span>
            </div>
            <div class="flex-1 min-w-0">
              <p class="text-[12px] font-semibold text-[#2B1E16] truncate">{{ order.customer }}</p>
              <p class="text-[10px] text-[#8A7A6C]">{{ order.id }}</p>
            </div>
            <div class="text-right">
              <p class="text-[12px] font-bold text-[#2B1E16]">{{ formatCurrency(order.total) }}</p>
              <span class="text-[9px] font-bold px-1.5 py-0.5 rounded-full"
                :class="order.status === 'Selesai' ? 'bg-[#0F8A4B]/10 text-[#0F8A4B]' : 'bg-[#C98A1A]/10 text-[#C98A1A]'">
                {{ order.status }}
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Quick Actions -->
    <div>
      <h3 class="text-[15px] font-bold text-[#2B1E16] mb-3">Aksi Cepat</h3>
      <div class="grid grid-cols-2 lg:grid-cols-4 gap-3">
        <router-link v-for="action in quickActions" :key="action.title" :to="action.link"
          class="bg-white rounded-2xl p-5 border border-[#E8DCCB]/60 hover:border-[#B85C38]/30 hover:shadow-md transition-all group">
          <div class="w-10 h-10 rounded-xl flex items-center justify-center mb-3 transition-colors" :class="action.iconBg">
            <component :is="action.icon" class="w-5 h-5" :class="action.iconColor" />
          </div>
          <p class="text-[13px] font-bold text-[#2B1E16] group-hover:text-[#B85C38] transition-colors">{{ action.title }}</p>
          <p class="text-[11px] text-[#8A7A6C] mt-0.5">{{ action.desc }}</p>
        </router-link>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, h, onMounted } from 'vue';

const user = ref(JSON.parse(localStorage.getItem('user') || '{}'));
const activePeriod = ref('7H');
const hoveredBar = ref(null);
const totalRevenue = ref(0);
const revenueGrowth = ref(0);

const IconBox = () => h('svg', { fill: 'none', stroke: 'currentColor', viewBox: '0 0 24 24', 'stroke-width': '1.8' }, [
  h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', d: 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4' })
]);
const IconShoppingBag = () => h('svg', { fill: 'none', stroke: 'currentColor', viewBox: '0 0 24 24', 'stroke-width': '1.8' }, [
  h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', d: 'M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z' })
]);
const IconUsers = () => h('svg', { fill: 'none', stroke: 'currentColor', viewBox: '0 0 24 24', 'stroke-width': '1.8' }, [
  h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', d: 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z' })
]);
const IconCash = () => h('svg', { fill: 'none', stroke: 'currentColor', viewBox: '0 0 24 24', 'stroke-width': '1.8' }, [
  h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', d: 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z' })
]);
const IconPlus = () => h('svg', { fill: 'none', stroke: 'currentColor', viewBox: '0 0 24 24', 'stroke-width': '2' }, [
  h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', d: 'M12 4v16m8-8H4' })
]);
const IconLightbulb = () => h('svg', { fill: 'none', stroke: 'currentColor', viewBox: '0 0 24 24', 'stroke-width': '1.8' }, [
  h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', d: 'M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z' })
]);
const IconChart = () => h('svg', { fill: 'none', stroke: 'currentColor', viewBox: '0 0 24 24', 'stroke-width': '1.8' }, [
  h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', d: 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z' })
]);

const stats = ref([
  { label: 'Produk Aktif', value: '0', change: '+0', icon: IconBox, iconBg: 'bg-blue-50', iconColor: 'text-blue-600', badgeClass: 'bg-blue-50 text-blue-700' },
  { label: 'Pesanan Baru', value: '0', change: '+0', icon: IconShoppingBag, iconBg: 'bg-[#0F8A4B]/10', iconColor: 'text-[#0F8A4B]', badgeClass: 'bg-[#0F8A4B]/10 text-[#0F8A4B]' },
  { label: 'Kolaborasi Aktif', value: '0', change: 'Aktif', icon: IconUsers, iconBg: 'bg-purple-50', iconColor: 'text-purple-600', badgeClass: 'bg-purple-50 text-purple-700' },
  { label: 'Pendapatan', value: 'Rp 0', change: '↑ 0%', icon: IconCash, iconBg: 'bg-[#B85C38]/10', iconColor: 'text-[#B85C38]', badgeClass: 'bg-[#0F8A4B]/10 text-[#0F8A4B]' },
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

const quickActions = [
  { title: 'Tambah Produk', desc: 'Upload produk baru ke katalog', link: '/umkm/products/create', icon: IconPlus, iconBg: 'bg-blue-50', iconColor: 'text-blue-600' },
  { title: 'AI Studio', desc: 'Optimalkan visual produk', link: '/umkm/studio', icon: IconLightbulb, iconBg: 'bg-[#B85C38]/10', iconColor: 'text-[#B85C38]' },
  { title: 'Co-Create', desc: 'Kolaborasi dengan designer', link: '/umkm/cocreate', icon: IconUsers, iconBg: 'bg-purple-50', iconColor: 'text-purple-600' },
  { title: 'Analitik', desc: 'Lihat insight penjualan', link: '/umkm/analytics', icon: IconChart, iconBg: 'bg-[#0F8A4B]/10', iconColor: 'text-[#0F8A4B]' },
];

const formatCurrency = (value) => {
  if (value >= 1000000) return 'Rp ' + (value / 1000000).toFixed(1) + 'M';
  if (value >= 1000) return 'Rp ' + (value / 1000).toFixed(0) + 'K';
  return 'Rp ' + value;
};

const formatCurrencyFull = (value) => {
  return 'Rp ' + Number(value ?? 0).toLocaleString('id-ID');
};

const fetchDashboardData = async () => {
  try {
    const token = localStorage.getItem('token');
    if (!token) return;

    const response = await fetch('/api/v1/umkm/dashboard', {
      headers: { 'Authorization': `Bearer ${token}`, 'Accept': 'application/json' }
    });

    if (!response.ok) return;
    const data = await response.json();

    if (data.stats) {
      stats.value[0].value = data.stats.total_products?.toString() || '0';
      stats.value[0].change = `+${data.stats.new_products || 0}`;
      stats.value[1].value = data.stats.total_orders?.toString() || '0';
      stats.value[1].change = `+${data.stats.new_orders || 0}`;
      stats.value[2].value = data.stats.active_collaborations?.toString() || '0';
      const revenue = data.stats.total_revenue || 0;
      stats.value[3].value = revenue >= 1000000 ? `Rp ${(revenue / 1000000).toFixed(1)}M` : revenue >= 1000 ? `Rp ${(revenue / 1000).toFixed(0)}K` : `Rp ${revenue}`;
      stats.value[3].change = `↑ ${data.stats.revenue_growth || 0}%`;

      totalRevenue.value = data.stats.total_revenue || 0;
      revenueGrowth.value = data.stats.revenue_growth || 0;
    }

    if (data.recent_orders && Array.isArray(data.recent_orders)) {
      recentOrders.value = data.recent_orders.map(order => ({
        id: order.order_number || `#${order.id}`,
        customer: order.customer_name || order.user?.name || 'Pelanggan',
        total: order.total_amount || 0,
        status: order.status === 'completed' ? 'Selesai' : order.status === 'paid' ? 'Dibayar' : 'Diproses'
      }));
    }

    if (data.revenue_chart && Array.isArray(data.revenue_chart)) {
      chartData.value = data.revenue_chart.map((item) => ({
        label: item.day,
        value: item.percentage !== undefined ? item.percentage : 0,
        amount: item.amount >= 1000000 ? `${(item.amount / 1000000).toFixed(1)}M` : `${(item.amount / 1000).toFixed(0)}K`
      }));
    }
  } catch (error) {
    console.error('Error fetching dashboard:', error);
  }
};

onMounted(() => { fetchDashboardData(); });
</script>
