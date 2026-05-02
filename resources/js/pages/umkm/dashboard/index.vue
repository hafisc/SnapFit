<template>
  <div class="space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-700 w-full">
    <!-- Header / Greeting -->
    <div class="bg-white rounded-[2rem] p-8 md:p-10 flex flex-col md:flex-row items-center justify-between border border-slate-200 shadow-sm relative overflow-hidden">
      <!-- Decorative Background Elements -->
      <div class="absolute inset-0 pointer-events-none">
        <div class="absolute right-0 top-0 w-64 h-full bg-gradient-to-l from-orange-50 to-transparent"></div>
        <div class="absolute -right-10 -top-10 w-40 h-40 bg-orange-100 rounded-full blur-3xl opacity-50"></div>
      </div>
      
      <div class="relative z-10 md:w-2/3">
        <h2 class="text-3xl font-black text-slate-800 mb-2 tracking-tighter">Halo, {{ user?.name || 'Kreator' }}! 👋</h2>
        <p class="text-slate-500 font-medium text-sm leading-relaxed max-w-lg">
          Selamat datang di Creator Hub. Kelola produk, berkolaborasi dengan desainer, dan manfaatkan AI Studio untuk visual yang profesional.
        </p>
      </div>
      
      <!-- Quick Actions (Responsive) -->
      <div class="relative z-10 flex flex-col sm:flex-row md:flex-col gap-3 w-full md:w-64 mt-8 md:mt-0">
        <router-link to="/umkm/studio" class="w-full bg-orange-500 hover:bg-orange-600 text-white px-6 py-4 rounded-2xl text-xs font-black tracking-widest uppercase transition-all shadow-lg shadow-orange-500/20 flex items-center justify-center gap-2">
          <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" /></svg>
          <span class="truncate">Buka AI Studio</span>
        </router-link>
        <router-link to="/umkm/products/create" class="w-full bg-slate-50 hover:bg-slate-100 border border-slate-100 text-slate-600 px-6 py-4 rounded-2xl text-xs font-black tracking-widest uppercase transition-colors flex items-center justify-center gap-2">
          <span class="truncate">Tambah Produk</span>
        </router-link>
      </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
      <div v-for="(stat, idx) in statCards" :key="idx" class="bg-white p-6 rounded-[2rem] border border-slate-200 shadow-sm hover:shadow-md transition-shadow">
        <div class="w-12 h-12 rounded-2xl flex items-center justify-center mb-6 text-xl" :class="stat.iconBgClass">
          <span :class="stat.iconColorClass">{{ stat.icon }}</span>
        </div>
        <h3 class="text-slate-400 text-[10px] font-black uppercase tracking-widest mb-1">{{ stat.title }}</h3>
        <p class="text-3xl font-black text-slate-800 tracking-tighter">
          <span v-if="loading" class="animate-pulse bg-slate-100 h-8 w-16 block rounded"></span>
          <span v-else>{{ stat.value }}</span>
        </p>
      </div>
    </div>

    <!-- Main Dashboard Content -->
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
      
      <!-- Kolom Kiri & Tengah (Grafik Penjualan & Pesanan) -->
      <div class="xl:col-span-2 space-y-8">
        
        <!-- Grafik Penjualan (CSS Mockup) -->
        <section class="bg-white rounded-[2rem] border border-slate-200 shadow-sm p-6 md:p-8">
          <div class="flex items-center justify-between mb-8">
            <div>
              <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest mb-1">Performa Penjualan</h3>
              <p class="text-xs text-slate-400 font-medium">Pendapatan kotor dalam 7 hari terakhir</p>
            </div>
            <select class="bg-slate-50 border border-slate-200 text-xs font-bold text-slate-600 rounded-xl px-4 py-2.5 outline-none cursor-pointer focus:border-orange-500 transition-colors hidden sm:block">
              <option>7 Hari Terakhir</option>
              <option>30 Hari Terakhir</option>
              <option>Bulan Ini</option>
            </select>
          </div>
          
          <div class="relative">
            <!-- Y-Axis Grid Lines -->
            <div class="absolute inset-0 flex flex-col justify-between pointer-events-none">
              <div class="w-full h-px bg-slate-100" v-for="i in 5" :key="i"></div>
            </div>
            
            <!-- Bars -->
            <div class="h-64 flex items-end justify-between gap-2 sm:gap-6 relative z-10 pb-1">
              <div v-for="(day, idx) in chartData" :key="idx" class="flex-1 flex flex-col items-center justify-end h-full group relative cursor-pointer">
                <!-- Tooltip -->
                <div class="absolute -top-10 bg-slate-800 text-white text-[10px] font-bold px-2 py-1 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">
                  Rp {{ (day.value * 100000).toLocaleString('id-ID') }}
                </div>
                <div 
                  class="w-full bg-orange-100 group-hover:bg-orange-200 rounded-t-xl transition-all duration-500 relative overflow-hidden"
                  :style="{ height: `${day.percentage}%` }"
                >
                  <div class="absolute bottom-0 w-full bg-orange-500 rounded-t-xl transition-all duration-500" :style="{ height: `${day.percentage - 20}%` }"></div>
                </div>
              </div>
            </div>
          </div>
          
          <!-- X-Axis Labels -->
          <div class="flex items-center justify-between mt-4 text-[10px] font-bold text-slate-400 uppercase">
            <span v-for="(day, idx) in chartData" :key="idx" class="flex-1 text-center truncate">{{ day.label }}</span>
          </div>
        </section>

        <!-- Pesanan Masuk -->
        <section class="bg-white rounded-[2rem] border border-slate-200 shadow-sm overflow-hidden">
          <div class="p-6 md:p-8 border-b border-slate-100 flex items-center justify-between">
            <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest">Pesanan Terbaru</h3>
            <button class="text-xs font-bold text-slate-400 hover:text-orange-500 transition-colors">Lihat Semua &rarr;</button>
          </div>
          
          <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse min-w-[500px]">
              <thead>
                <tr class="bg-slate-50/50">
                  <th class="py-4 px-6 md:px-8 text-[10px] font-black text-slate-400 uppercase tracking-widest">ID Pesanan</th>
                  <th class="py-4 px-6 md:px-8 text-[10px] font-black text-slate-400 uppercase tracking-widest">Pelanggan</th>
                  <th class="py-4 px-6 md:px-8 text-[10px] font-black text-slate-400 uppercase tracking-widest">Total</th>
                  <th class="py-4 px-6 md:px-8 text-[10px] font-black text-slate-400 uppercase tracking-widest">Status</th>
                </tr>
              </thead>
              <tbody class="text-sm">
                <tr v-for="order in recentOrders" :key="order.id" class="border-b border-slate-50 last:border-0 hover:bg-slate-50/50 transition-colors">
                  <td class="py-4 px-6 md:px-8 font-bold text-slate-800">#{{ order.id }}</td>
                  <td class="py-4 px-6 md:px-8 font-medium text-slate-600">{{ order.customer }}</td>
                  <td class="py-4 px-6 md:px-8 font-black text-slate-800">Rp {{ order.total.toLocaleString('id-ID') }}</td>
                  <td class="py-4 px-6 md:px-8">
                    <span class="px-3 py-1 text-[10px] font-black tracking-widest uppercase rounded-lg" 
                          :class="order.status === 'Selesai' ? 'bg-emerald-50 text-emerald-600' : 'bg-orange-50 text-orange-600'">
                      {{ order.status }}
                    </span>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </section>
      </div>

      <!-- Kolom Kanan (Produk Terlaris & Insight) -->
      <div class="xl:col-span-1 space-y-8">
        
        <!-- Insight Box (Call to Action AI) -->
        <section class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-[2rem] shadow-lg shadow-orange-500/20 p-8 text-white relative overflow-hidden">
          <div class="absolute -right-10 -top-10 w-40 h-40 bg-white rounded-full blur-3xl opacity-20"></div>
          <div class="relative z-10">
            <h3 class="text-xs font-black uppercase tracking-widest mb-2 text-orange-100 flex items-center gap-2">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
              AI Studio Insight
            </h3>
            <p class="text-sm font-medium leading-relaxed mb-6">
              Kamu telah menghemat estimasi biaya foto produk sebesar <span class="font-black">Rp 2.500.000</span> bulan ini dengan merender gambar menggunakan AI.
            </p>
            <router-link to="/umkm/studio" class="inline-block bg-white text-orange-600 hover:bg-orange-50 hover:scale-105 active:scale-95 transition-all font-bold text-xs px-5 py-3 rounded-xl uppercase tracking-widest shadow-sm">
              Buat Render Baru
            </router-link>
          </div>
        </section>

        <!-- Produk Terlaris -->
        <section class="bg-white rounded-[2rem] border border-slate-200 shadow-sm p-6 md:p-8">
          <div class="flex items-center justify-between mb-6">
            <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest">Produk Terlaris</h3>
            <svg class="w-5 h-5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 19a2 2 0 01-2-2V7a2 2 0 012-2h4l2 2h4a2 2 0 012 2v1M5 19h14a2 2 0 002-2v-5a2 2 0 00-2-2H9a2 2 0 00-2 2v5a2 2 0 01-2 2z" /></svg>
          </div>

          <div class="space-y-5">
            <div v-for="(product, idx) in topProducts" :key="idx" class="flex items-center gap-4 group cursor-pointer">
              <div class="w-14 h-14 bg-slate-50 rounded-xl overflow-hidden relative">
                <!-- Fake Image block -->
                <div class="absolute inset-0 bg-slate-200" v-if="!product.image"></div>
                <img v-else :src="product.image" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" />
                <div class="absolute -bottom-1 -right-1 w-6 h-6 bg-slate-800 text-white rounded-tl-lg rounded-br-xl text-[10px] font-black flex items-center justify-center border-2 border-white z-10">
                  {{ idx + 1 }}
                </div>
              </div>
              <div class="flex-1 min-w-0">
                <h4 class="text-sm font-bold text-slate-800 truncate group-hover:text-orange-500 transition-colors">{{ product.name }}</h4>
                <p class="text-xs font-medium text-slate-500">{{ product.sales }} Terjual</p>
              </div>
              <div class="text-right">
                <p class="text-xs font-black text-slate-800">Rp {{ (product.price / 1000).toLocaleString('id-ID') }}k</p>
                <p class="text-[10px] font-bold text-emerald-500 flex items-center justify-end gap-0.5">
                  <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" /></svg>
                  {{ product.growth }}%
                </p>
              </div>
            </div>
          </div>
          
          <router-link to="/umkm/products" class="mt-6 block w-full text-center py-3 bg-slate-50 hover:bg-slate-100 text-slate-600 text-xs font-bold rounded-xl transition-colors">
            Lihat Semua Produk
          </router-link>
        </section>

      </div>
      
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';

// Data User
const user = ref(JSON.parse(localStorage.getItem('user') || '{}'));
const loading = ref(false);

// Dummy Data untuk Chart Penjualan (Akan diganti API /orders/stats)
const chartData = ref([
  { label: 'Senin', value: 45, percentage: 45 },
  { label: 'Selasa', value: 30, percentage: 30 },
  { label: 'Rabu', value: 65, percentage: 65 },
  { label: 'Kamis', value: 50, percentage: 50 },
  { label: 'Jumat', value: 85, percentage: 85 },
  { label: 'Sabtu', value: 100, percentage: 100 },
  { label: 'Minggu', value: 70, percentage: 70 },
]);

// Dummy Data Pesanan Terbaru
const recentOrders = ref([
  { id: 'ORD-0091', customer: 'Budi Santoso', total: 450000, status: 'Diproses' },
  { id: 'ORD-0090', customer: 'Siti Aminah', total: 125000, status: 'Selesai' },
  { id: 'ORD-0089', customer: 'Rudi Hermawan', total: 850000, status: 'Selesai' },
  { id: 'ORD-0088', customer: 'Diana Putri', total: 200000, status: 'Selesai' },
]);

// Dummy Data Produk Terlaris
const topProducts = ref([
  { name: 'Kemeja Batik Modern Slim Fit', sales: 124, price: 420000, growth: 12, image: 'https://images.unsplash.com/photo-1598033129183-c4f50c736f10?q=80&w=300&auto=format&fit=crop' },
  { name: 'Batik Cap Bunga Malang', sales: 89, price: 185000, growth: 8, image: 'https://images.unsplash.com/photo-1605518216938-7c31b7b14ad0?q=80&w=300&auto=format&fit=crop' },
  { name: 'Aksesoris Gelang Etnik', sales: 56, price: 45000, growth: 4, image: 'https://images.unsplash.com/photo-1611591437281-460bfbe1220a?q=80&w=300&auto=format&fit=crop' },
]);

// State Statistik
const stats = ref({
  totalProducts: 24,
  totalAi: 12,
  activeRooms: 2,
  sales: '12.5M'
});

// Konfigurasi visual untuk stat cards
const statCards = computed(() => [
  { title: 'Total Produk', value: stats.value.totalProducts, icon: '📦', iconBgClass: 'bg-indigo-50', iconColorClass: 'text-indigo-500' },
  { title: 'AI Renderings', value: stats.value.totalAi, icon: '🤖', iconBgClass: 'bg-orange-50', iconColorClass: 'text-orange-500' },
  { title: 'Kolaborasi Aktif', value: stats.value.activeRooms, icon: '👥', iconBgClass: 'bg-emerald-50', iconColorClass: 'text-emerald-500' },
  { title: 'Total Penjualan', value: `Rp ${stats.value.sales}`, icon: '💳', iconBgClass: 'bg-blue-50', iconColorClass: 'text-blue-500' },
]);

// Dalam produksi nyata, panggil endpoint API di sini
onMounted(() => {
  // fetchDashboardAnalytics();
});
</script>
