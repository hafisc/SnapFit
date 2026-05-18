<template>
  <div class="space-y-5 max-w-[1400px]">
    <!-- Period Selector -->
    <div class="flex items-center justify-between">
      <div class="flex bg-slate-100 rounded-lg p-0.5">
        <button v-for="p in periods" :key="p" @click="activePeriod = p"
          class="px-3.5 py-2 text-[11px] font-semibold rounded-md transition-all"
          :class="activePeriod === p ? 'bg-surface text-espresso shadow-sm' : 'text-slate-400 hover:text-muted'">
          {{ p }}
        </button>
      </div>
      <button class="px-4 py-2 bg-surface border border-borderSoft/60 rounded-lg text-[11px] font-semibold text-muted hover:bg-slate-50 transition-colors flex items-center gap-1.5">
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
        Export CSV
      </button>
    </div>

    <!-- KPI Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-5 gap-4">
      <div v-for="k in kpis" :key="k.label" class="bg-surface rounded-2xl border border-borderSoft/60 p-5">
        <p class="text-[10px] text-slate-400 font-medium uppercase tracking-wide mb-3">{{ k.label }}</p>
        <p class="text-[22px] font-bold leading-none mb-1" :class="k.valueClass || 'text-espresso'">{{ k.value }}</p>
        <div class="flex items-center gap-1 mt-1">
          <span class="text-[10px] font-semibold" :class="k.up ? 'text-emerald-500' : 'text-red-400'">{{ k.up ? '↑' : '↓' }} {{ k.change }}</span>
          <span class="text-[10px] text-slate-300">vs bulan lalu</span>
        </div>
      </div>
    </div>

    <!-- Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
      <!-- Revenue Trend -->
      <div class="bg-surface rounded-2xl border border-borderSoft/60 p-6">
        <h3 class="text-[14px] font-bold text-espresso mb-1">Tren Revenue</h3>
        <p class="text-[11px] text-slate-400 font-medium mb-6">6 bulan terakhir</p>
        <div class="h-48 flex items-end gap-2">
          <div v-for="(m, i) in revenueData" :key="i" class="flex-1 flex flex-col items-center gap-1 group cursor-pointer relative">
            <div class="absolute -top-8 bg-slate-800 text-white text-[10px] font-bold px-2.5 py-1 rounded-md opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap z-10">Rp {{ m.value }}M</div>
            <div class="w-full rounded-t-md transition-all duration-500" :class="i === revenueData.length - 1 ? 'bg-terracotta' : 'bg-orange-200 group-hover:bg-orange-300'" :style="{ height: m.pct + '%' }"></div>
          </div>
        </div>
        <div class="flex justify-between mt-3 text-[10px] text-slate-400 font-medium">
          <span v-for="m in revenueData" :key="m.label">{{ m.label }}</span>
        </div>
      </div>

      <!-- User Growth -->
      <div class="bg-surface rounded-2xl border border-borderSoft/60 p-6">
        <h3 class="text-[14px] font-bold text-espresso mb-1">Pertumbuhan User</h3>
        <p class="text-[11px] text-slate-400 font-medium mb-6">Registrasi baru per bulan</p>
        <div class="h-48 flex items-end gap-2">
          <div v-for="(m, i) in userGrowth" :key="i" class="flex-1 flex flex-col items-center gap-0.5 group cursor-pointer relative">
            <div class="absolute -top-8 bg-slate-800 text-white text-[10px] font-bold px-2 py-1 rounded-md opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap z-10">{{ m.umkm + m.designer }} user</div>
            <div class="w-full bg-blue-200 rounded-t-sm group-hover:bg-blue-300 transition-colors" :style="{ height: m.dPct + '%' }"></div>
            <div class="w-full bg-blue-500 rounded-b-sm group-hover:bg-blue-600 transition-colors" :style="{ height: m.uPct + '%' }"></div>
          </div>
        </div>
        <div class="flex justify-between mt-3 text-[10px] text-slate-400 font-medium">
          <span v-for="m in userGrowth" :key="m.label">{{ m.label }}</span>
        </div>
        <div class="flex items-center gap-4 mt-3">
          <div class="flex items-center gap-1.5"><div class="w-2.5 h-2.5 rounded-sm bg-blue-500"></div><span class="text-[10px] text-slate-400 font-medium">UMKM</span></div>
          <div class="flex items-center gap-1.5"><div class="w-2.5 h-2.5 rounded-sm bg-blue-200"></div><span class="text-[10px] text-slate-400 font-medium">Desainer</span></div>
        </div>
      </div>
    </div>

    <!-- Bottom Row -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
      <!-- Top Categories -->
      <div class="bg-surface rounded-2xl border border-borderSoft/60 p-6">
        <h3 class="text-[14px] font-bold text-espresso mb-5">Kategori Populer</h3>
        <div class="space-y-3">
          <div v-for="c in topCategories" :key="c.name" class="flex items-center gap-3">
            <span class="w-8 h-8 rounded-lg flex items-center justify-center text-sm" :class="c.bgClass">{{ c.emoji }}</span>
            <div class="flex-1">
              <div class="flex items-center justify-between mb-1">
                <span class="text-[12px] font-semibold text-espresso">{{ c.name }}</span>
                <span class="text-[11px] font-bold text-espresso">{{ c.pct }}%</span>
              </div>
              <div class="h-1.5 bg-slate-100 rounded-full overflow-hidden">
                <div class="h-full rounded-full transition-all duration-700" :class="c.barClass" :style="{ width: c.pct + '%' }"></div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Geographic -->
      <div class="bg-surface rounded-2xl border border-borderSoft/60 p-6">
        <h3 class="text-[14px] font-bold text-espresso mb-5">Distribusi Wilayah</h3>
        <div class="space-y-3">
          <div v-for="r in regions" :key="r.name" class="flex items-center justify-between py-2 border-b border-slate-50 last:border-0">
            <div class="flex items-center gap-2.5">
              <span class="w-2 h-2 rounded-full" :class="r.dotClass"></span>
              <span class="text-[12px] font-medium text-espresso">{{ r.name }}</span>
            </div>
            <div class="text-right">
              <span class="text-[12px] font-bold text-espresso">{{ r.users }}</span>
              <span class="text-[10px] text-slate-400 ml-1">user</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Platform Health -->
      <div class="bg-surface rounded-2xl border border-borderSoft/60 p-6">
        <h3 class="text-[14px] font-bold text-espresso mb-5">Platform Health</h3>
        <div class="space-y-4">
          <div v-for="m in healthMetrics" :key="m.label">
            <div class="flex items-center justify-between mb-1.5">
              <span class="text-[12px] font-medium text-muted">{{ m.label }}</span>
              <span class="text-[12px] font-bold" :class="m.valueClass">{{ m.value }}</span>
            </div>
            <div class="h-1.5 bg-slate-100 rounded-full overflow-hidden">
              <div class="h-full rounded-full" :class="m.barClass" :style="{ width: m.pct + '%' }"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';

const activePeriod = ref('Bulan Ini');
const periods = ['Hari Ini', 'Minggu Ini', 'Bulan Ini', '3 Bulan', '1 Tahun'];

const kpis = [
  { label: 'Gross Revenue', value: 'Rp 47.8M', change: '18%', up: true },
  { label: 'Total Orders', value: '1,284', change: '12%', up: true },
  { label: 'Conversion Rate', value: '3.2%', change: '0.4%', up: true },
  { label: 'Avg Order Value', value: 'Rp 187K', change: '8%', up: true },
  { label: 'Active Users', value: '892', change: '5%', up: false },
];

const revenueData = [
  { label: 'Jan', value: 28, pct: 45 },
  { label: 'Feb', value: 32, pct: 52 },
  { label: 'Mar', value: 35, pct: 56 },
  { label: 'Apr', value: 41, pct: 66 },
  { label: 'Mei', value: 44, pct: 71 },
  { label: 'Jun', value: 47.8, pct: 77 },
];

const userGrowth = [
  { label: 'Jan', umkm: 18, designer: 8, uPct: 36, dPct: 16 },
  { label: 'Feb', umkm: 22, designer: 12, uPct: 44, dPct: 24 },
  { label: 'Mar', umkm: 28, designer: 10, uPct: 56, dPct: 20 },
  { label: 'Apr', umkm: 35, designer: 15, uPct: 70, dPct: 30 },
  { label: 'Mei', umkm: 25, designer: 14, uPct: 50, dPct: 28 },
  { label: 'Jun', umkm: 14, designer: 8, uPct: 28, dPct: 16 },
];

const topCategories = [
  { name: 'Batik', emoji: '🎨', pct: 38, bgClass: 'bg-sand', barClass: 'bg-orange-400' },
  { name: 'Kerajinan', emoji: '🪴', pct: 26, bgClass: 'bg-emerald-50', barClass: 'bg-emerald-400' },
  { name: 'Aksesoris', emoji: '💍', pct: 18, bgClass: 'bg-blue-50', barClass: 'bg-blue-400' },
  { name: 'Fashion', emoji: '👕', pct: 12, bgClass: 'bg-violet-50', barClass: 'bg-violet-400' },
  { name: 'Dekorasi', emoji: '🏡', pct: 6, bgClass: 'bg-amber-50', barClass: 'bg-amber-400' },
];

const regions = [
  { name: 'Kota Malang', users: 142, dotClass: 'bg-terracotta' },
  { name: 'Kabupaten Malang', users: 68, dotClass: 'bg-blue-500' },
  { name: 'Kota Batu', users: 34, dotClass: 'bg-emerald-500' },
  { name: 'Pasuruan', users: 8, dotClass: 'bg-violet-500' },
  { name: 'Lainnya', users: 5, dotClass: 'bg-slate-400' },
];

const healthMetrics = [
  { label: 'Uptime', value: '99.9%', pct: 99.9, valueClass: 'text-emerald-600', barClass: 'bg-emerald-400' },
  { label: 'Response Time', value: '142ms', pct: 85, valueClass: 'text-emerald-600', barClass: 'bg-emerald-400' },
  { label: 'Error Rate', value: '0.3%', pct: 3, valueClass: 'text-emerald-600', barClass: 'bg-emerald-400' },
  { label: 'Disk Usage', value: '62%', pct: 62, valueClass: 'text-amber-600', barClass: 'bg-amber-400' },
];
</script>
