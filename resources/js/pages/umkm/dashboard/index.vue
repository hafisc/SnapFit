<template>
  <div class="space-y-5 max-w-[1400px]">
    <!-- Welcome -->
    <div class="bg-white rounded-2xl border border-slate-200/60 p-6 flex flex-col md:flex-row items-start md:items-center justify-between gap-5 relative overflow-hidden">
      <div class="absolute right-0 top-0 w-64 h-full bg-gradient-to-l from-orange-50 to-transparent pointer-events-none"></div>
      <div class="relative z-10">
        <p class="text-[11px] font-semibold text-orange-500 uppercase tracking-wider mb-1">Creator Hub</p>
        <h2 class="text-xl font-bold text-slate-800 mb-1">Halo, {{ user?.name || 'Kreator' }}!</h2>
        <p class="text-[13px] text-slate-400 font-medium max-w-md">Kelola produk, kolaborasi dengan desainer, dan manfaatkan AI Studio untuk visual profesional.</p>
      </div>
      <div class="relative z-10 flex gap-2.5 w-full md:w-auto">
        <router-link to="/umkm/studio" class="flex-1 md:flex-initial bg-orange-500 hover:bg-orange-600 text-white px-5 py-2.5 rounded-lg text-[11px] font-bold transition-colors flex items-center justify-center gap-1.5 whitespace-nowrap">
          🤖 Buka AI Studio
        </router-link>
        <router-link to="/umkm/products/create" class="flex-1 md:flex-initial bg-white hover:bg-slate-50 border border-slate-200 text-slate-700 px-5 py-2.5 rounded-lg text-[11px] font-bold transition-colors flex items-center justify-center whitespace-nowrap">
          + Tambah Produk
        </router-link>
      </div>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
      <div v-for="(s, i) in statCards" :key="i" class="bg-white rounded-2xl border border-slate-200/60 p-5">
        <div class="flex items-center justify-between mb-4">
          <div class="w-10 h-10 rounded-xl flex items-center justify-center text-lg" :class="s.bgClass">{{ s.emoji }}</div>
          <span class="text-[10px] font-semibold px-2 py-0.5 rounded-md" :class="s.trendClass">{{ s.trend }}</span>
        </div>
        <p class="text-[22px] font-bold text-slate-800 leading-none mb-1">{{ s.value }}</p>
        <p class="text-[11px] text-slate-400 font-medium">{{ s.title }}</p>
      </div>
    </div>

    <!-- Main Row -->
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-4">
      <!-- Sales Chart -->
      <div class="lg:col-span-3 bg-white rounded-2xl border border-slate-200/60 p-6">
        <div class="flex items-center justify-between mb-6">
          <div>
            <h3 class="text-[14px] font-bold text-slate-800">Performa Penjualan</h3>
            <p class="text-[11px] text-slate-400 font-medium">Pendapatan 7 hari terakhir</p>
          </div>
          <div class="flex bg-slate-100 rounded-lg p-0.5">
            <button v-for="p in ['7D','1M','3M']" :key="p" @click="activePeriod = p"
              class="px-3 py-1.5 text-[10px] font-bold rounded-md transition-all"
              :class="activePeriod === p ? 'bg-white text-slate-800 shadow-sm' : 'text-slate-400 hover:text-slate-600'">{{ p }}</button>
          </div>
        </div>

        <div class="mb-4">
          <p class="text-[24px] font-bold text-slate-800 tracking-tight leading-none">Rp 12.500.000</p>
          <p class="text-[11px] text-emerald-500 font-semibold mt-1">↑ 14% dari minggu lalu</p>
        </div>

        <div class="h-40 flex items-end gap-[3px] relative">
          <div class="absolute inset-0 flex flex-col justify-between pointer-events-none"><div v-for="i in 4" :key="i" class="w-full border-b border-dashed border-slate-100"></div></div>
          <div v-for="(b, i) in barData" :key="i" class="flex-1 rounded-t-md transition-all duration-500 hover:opacity-80 cursor-pointer relative z-10"
            :class="i === barData.length - 1 ? 'bg-orange-500' : 'bg-orange-200 hover:bg-orange-300'" :style="{ height: b + '%' }"></div>
        </div>
        <div class="flex justify-between mt-3 text-[10px] text-slate-400 font-medium">
          <span v-for="d in ['Sen','Sel','Rab','Kam','Jum','Sab','Min']" :key="d">{{ d }}</span>
        </div>
      </div>

      <!-- Recent Orders -->
      <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200/60 p-6">
        <div class="flex items-center justify-between mb-5">
          <h3 class="text-[14px] font-bold text-slate-800">Pesanan Terbaru</h3>
          <router-link to="/umkm/orders" class="text-[11px] font-semibold text-orange-500 hover:text-orange-600">Lihat Semua</router-link>
        </div>
        <div class="space-y-3">
          <div v-for="o in recentOrders" :key="o.id" class="flex items-center gap-3 p-2.5 -mx-2.5 rounded-xl hover:bg-slate-50 transition-colors">
            <div class="w-9 h-9 rounded-lg bg-slate-100 flex items-center justify-center text-[11px] font-bold text-slate-500 flex-shrink-0">{{ o.customer.charAt(0) }}</div>
            <div class="flex-1 min-w-0">
              <p class="text-[12px] font-semibold text-slate-700 truncate">{{ o.customer }}</p>
              <p class="text-[10px] text-slate-400">{{ o.id }}</p>
            </div>
            <div class="text-right">
              <p class="text-[12px] font-bold text-slate-800">Rp {{ o.total.toLocaleString('id-ID') }}</p>
              <span class="text-[9px] font-bold uppercase px-1.5 py-0.5 rounded" :class="o.status === 'Selesai' ? 'bg-emerald-50 text-emerald-600' : 'bg-amber-50 text-amber-600'">{{ o.status }}</span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Bottom Row -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
      <!-- Top Products -->
      <div class="bg-white rounded-2xl border border-slate-200/60 p-6">
        <div class="flex items-center justify-between mb-5">
          <h3 class="text-[14px] font-bold text-slate-800">Produk Terlaris</h3>
          <router-link to="/umkm/products" class="text-[11px] font-semibold text-orange-500 hover:text-orange-600">Semua</router-link>
        </div>
        <div class="space-y-3">
          <div v-for="(p, i) in topProducts" :key="i" class="flex items-center gap-3 p-2 -mx-2 rounded-xl hover:bg-slate-50 transition-colors">
            <span class="w-6 h-6 rounded-md bg-slate-100 flex items-center justify-center text-[10px] font-bold text-slate-400 flex-shrink-0">{{ i + 1 }}</span>
            <div class="w-9 h-9 rounded-lg bg-slate-100 overflow-hidden flex-shrink-0">
              <img :src="p.image" :alt="p.name" class="w-full h-full object-cover" />
            </div>
            <div class="flex-1 min-w-0">
              <p class="text-[12px] font-semibold text-slate-700 truncate">{{ p.name }}</p>
              <p class="text-[10px] text-slate-400">{{ p.sales }} terjual</p>
            </div>
            <span class="text-[11px] font-semibold text-emerald-500">↑ {{ p.growth }}%</span>
          </div>
        </div>
      </div>

      <!-- AI Studio CTA -->
      <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl p-6 text-white relative overflow-hidden">
        <div class="absolute -right-6 -top-6 w-24 h-24 bg-white/10 rounded-full blur-xl"></div>
        <div class="relative z-10">
          <p class="text-2xl mb-3">⚡</p>
          <h3 class="text-[16px] font-bold mb-2">AI Studio Insight</h3>
          <p class="text-[12px] text-white/80 font-medium leading-relaxed mb-5">Kamu sudah menghemat estimasi <span class="font-bold text-white">Rp 2.500.000</span> bulan ini dengan AI rendering.</p>
          <router-link to="/umkm/studio" class="inline-block bg-white text-orange-600 font-bold text-[11px] px-4 py-2.5 rounded-lg hover:bg-orange-50 transition-colors">Buat Render Baru</router-link>
        </div>
      </div>

      <!-- Co-Create Summary -->
      <div class="bg-white rounded-2xl border border-slate-200/60 p-6">
        <div class="flex items-center justify-between mb-5">
          <h3 class="text-[14px] font-bold text-slate-800">Kolaborasi Aktif</h3>
          <span class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse"></span>
        </div>
        <div class="space-y-3">
          <div v-for="room in activeRooms" :key="room.id" class="p-3 rounded-xl border border-slate-100 hover:border-orange-200 hover:bg-orange-50/30 transition-all cursor-pointer group">
            <div class="flex items-center justify-between mb-2">
              <h4 class="text-[12px] font-semibold text-slate-700 group-hover:text-orange-600 transition-colors truncate">{{ room.name }}</h4>
              <span class="text-[9px] font-bold text-emerald-500 bg-emerald-50 px-1.5 py-0.5 rounded">Live</span>
            </div>
            <div class="flex items-center justify-between">
              <p class="text-[10px] text-slate-400">{{ room.designer }}</p>
              <span class="text-[10px] text-slate-400">{{ room.updated }}</span>
            </div>
          </div>
        </div>
        <router-link to="/umkm/cocreate" class="mt-4 block w-full text-center py-2.5 bg-slate-50 hover:bg-slate-100 text-slate-600 text-[11px] font-semibold rounded-lg transition-colors">Kelola Room</router-link>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';

const user = ref(JSON.parse(localStorage.getItem('user') || '{}'));
const activePeriod = ref('7D');
const barData = [45, 30, 65, 50, 85, 100, 70];

const statCards = [
  { title: 'Total Produk', value: '24', emoji: '📦', bgClass: 'bg-blue-50', trend: '+3 baru', trendClass: 'bg-blue-50 text-blue-600' },
  { title: 'AI Renderings', value: '12', emoji: '🤖', bgClass: 'bg-orange-50', trend: '3 hari ini', trendClass: 'bg-orange-50 text-orange-600' },
  { title: 'Kolaborasi Aktif', value: '2', emoji: '🤝', bgClass: 'bg-emerald-50', trend: 'Live', trendClass: 'bg-emerald-50 text-emerald-600' },
  { title: 'Penjualan Bulan Ini', value: 'Rp 12.5M', emoji: '💰', bgClass: 'bg-violet-50', trend: '↑ 14%', trendClass: 'bg-emerald-50 text-emerald-600' },
];

const recentOrders = [
  { id: '#ORD-0091', customer: 'Budi Santoso', total: 450000, status: 'Diproses' },
  { id: '#ORD-0090', customer: 'Siti Aminah', total: 125000, status: 'Selesai' },
  { id: '#ORD-0089', customer: 'Rudi Hermawan', total: 850000, status: 'Selesai' },
  { id: '#ORD-0088', customer: 'Diana Putri', total: 200000, status: 'Diproses' },
  { id: '#ORD-0087', customer: 'Ahmad Fauzi', total: 375000, status: 'Selesai' },
];

const topProducts = [
  { name: 'Kemeja Batik Modern Slim', sales: 124, price: 420000, growth: 12, image: 'https://images.unsplash.com/photo-1598033129183-c4f50c736f10?w=80&fit=crop' },
  { name: 'Batik Cap Bunga Malang', sales: 89, price: 185000, growth: 8, image: 'https://images.unsplash.com/photo-1605518216938-7c31b7b14ad0?w=80&fit=crop' },
  { name: 'Gelang Etnik Handmade', sales: 56, price: 45000, growth: 4, image: 'https://images.unsplash.com/photo-1611591437281-460bfbe1220a?w=80&fit=crop' },
];

const activeRooms = [
  { id: 1, name: 'Packaging Batik Tulis Premium', designer: 'Desainer: Reza F.', updated: '5 min lalu' },
  { id: 2, name: 'Branding Kerajinan Rotan', designer: 'Desainer: Andi W.', updated: '2 jam lalu' },
];
</script>
