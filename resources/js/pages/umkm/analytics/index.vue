<template>
  <div class="space-y-5 max-w-[1400px]">
    <!-- Period Selector -->
    <div class="flex items-center justify-between">
      <div class="flex bg-slate-100 rounded-lg p-0.5">
        <button v-for="p in periods" :key="p" @click="activePeriod = p"
          class="px-3.5 py-2 text-[11px] font-semibold rounded-md transition-all"
          :class="activePeriod === p ? 'bg-surface text-espresso shadow-sm' : 'text-slate-400 hover:text-muted'">{{ p }}</button>
      </div>
      <button class="px-4 py-2 bg-surface border border-borderSoft/60 rounded-lg text-[11px] font-semibold text-muted hover:bg-slate-50 transition-colors flex items-center gap-1.5">
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
        Export
      </button>
    </div>

    <!-- KPI -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
      <div v-for="k in kpis" :key="k.label" class="bg-surface rounded-2xl border border-borderSoft/60 p-5">
        <p class="text-[10px] text-slate-400 font-medium uppercase tracking-wide mb-3">{{ k.label }}</p>
        <p class="text-[22px] font-bold text-espresso leading-none mb-1">{{ k.value }}</p>
        <div class="flex items-center gap-1 mt-1">
          <span class="text-[10px] font-semibold" :class="k.up ? 'text-emerald-500' : 'text-red-400'">{{ k.up ? '↑' : '↓' }} {{ k.change }}</span>
          <span class="text-[10px] text-slate-300">vs periode lalu</span>
        </div>
      </div>
    </div>

    <!-- Charts -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
      <!-- Revenue -->
      <div class="bg-surface rounded-2xl border border-borderSoft/60 p-6">
        <h3 class="text-[14px] font-bold text-espresso mb-1">Tren Pendapatan</h3>
        <p class="text-[11px] text-slate-400 font-medium mb-6">6 bulan terakhir</p>
        <div class="h-44 flex items-end gap-2">
          <div v-for="(m, i) in revenueData" :key="i" class="flex-1 rounded-t-md transition-all duration-500 cursor-pointer group relative"
            :class="i === revenueData.length - 1 ? 'bg-terracotta' : 'bg-orange-200 hover:bg-orange-300'" :style="{ height: m.pct + '%' }">
            <div class="absolute -top-8 left-1/2 -translate-x-1/2 bg-slate-800 text-white text-[10px] font-bold px-2 py-1 rounded-md opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap z-10">Rp {{ m.value }}M</div>
          </div>
        </div>
        <div class="flex justify-between mt-3 text-[10px] text-slate-400 font-medium">
          <span v-for="m in revenueData" :key="m.label">{{ m.label }}</span>
        </div>
      </div>

      <!-- Product Performance -->
      <div class="bg-surface rounded-2xl border border-borderSoft/60 p-6">
        <h3 class="text-[14px] font-bold text-espresso mb-1">Performa Produk</h3>
        <p class="text-[11px] text-slate-400 font-medium mb-6">Views vs Konversi per produk</p>
        <div class="space-y-4">
          <div v-for="p in productPerf" :key="p.name">
            <div class="flex items-center justify-between mb-1.5">
              <span class="text-[12px] font-semibold text-espresso truncate">{{ p.name }}</span>
              <span class="text-[11px] font-bold text-espresso">{{ p.conversion }}%</span>
            </div>
            <div class="h-1.5 bg-slate-100 rounded-full overflow-hidden">
              <div class="h-full rounded-full transition-all duration-700" :class="p.barClass" :style="{ width: p.conversion * 10 + '%' }"></div>
            </div>
            <div class="flex items-center justify-between mt-1">
              <span class="text-[10px] text-slate-400">{{ p.views }} views</span>
              <span class="text-[10px] text-slate-400">{{ p.orders }} orders</span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Bottom Row -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
      <!-- Traffic Sources -->
      <div class="bg-surface rounded-2xl border border-borderSoft/60 p-6">
        <h3 class="text-[14px] font-bold text-espresso mb-5">Sumber Traffic</h3>
        <div class="space-y-3">
          <div v-for="t in trafficSources" :key="t.name" class="flex items-center gap-3">
            <span class="w-8 h-8 rounded-lg flex items-center justify-center text-sm" :class="t.bgClass">{{ t.emoji }}</span>
            <div class="flex-1">
              <div class="flex items-center justify-between mb-1">
                <span class="text-[12px] font-semibold text-espresso">{{ t.name }}</span>
                <span class="text-[11px] font-bold text-espresso">{{ t.pct }}%</span>
              </div>
              <div class="h-1.5 bg-slate-100 rounded-full overflow-hidden">
                <div class="h-full rounded-full transition-all duration-700" :class="t.barClass" :style="{ width: t.pct + '%' }"></div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Customer Demographics -->
      <div class="bg-surface rounded-2xl border border-borderSoft/60 p-6">
        <h3 class="text-[14px] font-bold text-espresso mb-5">Demografi Pembeli</h3>
        <div class="space-y-3">
          <div v-for="d in demographics" :key="d.city" class="flex items-center justify-between py-2 border-b border-slate-50 last:border-0">
            <div class="flex items-center gap-2.5">
              <span class="w-2 h-2 rounded-full" :class="d.dotClass"></span>
              <span class="text-[12px] font-medium text-espresso">{{ d.city }}</span>
            </div>
            <div class="text-right">
              <span class="text-[12px] font-bold text-espresso">{{ d.orders }}</span>
              <span class="text-[10px] text-slate-400 ml-1">pesanan</span>
            </div>
          </div>
        </div>
      </div>

      <!-- AI Studio Stats -->
      <div class="bg-surface rounded-2xl border border-borderSoft/60 p-6">
        <h3 class="text-[14px] font-bold text-espresso mb-5">AI Studio Usage</h3>
        <div class="space-y-4">
          <div v-for="a in aiStats" :key="a.label">
            <div class="flex items-center justify-between mb-1.5">
              <span class="text-[12px] font-medium text-muted">{{ a.label }}</span>
              <span class="text-[12px] font-bold" :class="a.valueClass">{{ a.value }}</span>
            </div>
            <div class="h-1.5 bg-slate-100 rounded-full overflow-hidden">
              <div class="h-full rounded-full" :class="a.barClass" :style="{ width: a.pct + '%' }"></div>
            </div>
          </div>
        </div>
        <div class="mt-5 p-3 rounded-xl bg-sand border border-terracotta/20">
          <p class="text-[11px] text-orange-700 font-medium">💡 Estimasi biaya dihemat bulan ini: <span class="font-bold">Rp 2.500.000</span></p>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';

const activePeriod = ref('Bulan Ini');
const periods = ['Minggu Ini', 'Bulan Ini', '3 Bulan', '1 Tahun'];

const kpis = [
  { label: 'Total Pendapatan', value: 'Rp 12.5M', change: '14%', up: true },
  { label: 'Total Pesanan', value: '87', change: '8%', up: true },
  { label: 'Rata-rata Order', value: 'Rp 143K', change: '5%', up: true },
  { label: 'Produk Dilihat', value: '2.4K', change: '3%', up: false },
];

const revenueData = [
  { label: 'Jan', value: 8.2, pct: 55 },
  { label: 'Feb', value: 9.1, pct: 61 },
  { label: 'Mar', value: 7.8, pct: 52 },
  { label: 'Apr', value: 10.5, pct: 70 },
  { label: 'Mei', value: 11.2, pct: 75 },
  { label: 'Jun', value: 12.5, pct: 83 },
];

const productPerf = [
  { name: 'Kemeja Batik Modern', views: 1240, orders: 124, conversion: 10, barClass: 'bg-orange-400' },
  { name: 'Batik Cap Bunga Malang', views: 890, orders: 89, conversion: 10, barClass: 'bg-blue-400' },
  { name: 'Gelang Etnik Handmade', views: 720, orders: 56, conversion: 7.8, barClass: 'bg-emerald-400' },
  { name: 'Tas Anyaman Rotan', views: 560, orders: 34, conversion: 6.1, barClass: 'bg-violet-400' },
];

const trafficSources = [
  { name: 'SnapFit Marketplace', pct: 52, emoji: '🏪', bgClass: 'bg-sand', barClass: 'bg-orange-400' },
  { name: 'Instagram', pct: 24, emoji: '📸', bgClass: 'bg-pink-50', barClass: 'bg-pink-400' },
  { name: 'Google Search', pct: 14, emoji: '🔍', bgClass: 'bg-blue-50', barClass: 'bg-blue-400' },
  { name: 'Direct / Lainnya', pct: 10, emoji: '🔗', bgClass: 'bg-slate-50', barClass: 'bg-slate-400' },
];

const demographics = [
  { city: 'Kota Malang', orders: 42, dotClass: 'bg-terracotta' },
  { city: 'Surabaya', orders: 18, dotClass: 'bg-blue-500' },
  { city: 'Jakarta', orders: 12, dotClass: 'bg-emerald-500' },
  { city: 'Bandung', orders: 8, dotClass: 'bg-violet-500' },
  { city: 'Lainnya', orders: 7, dotClass: 'bg-slate-400' },
];

const aiStats = [
  { label: 'Studio Photo Generated', value: '12', pct: 60, valueClass: 'text-terracotta', barClass: 'bg-orange-400' },
  { label: 'Video 360° Created', value: '3', pct: 15, valueClass: 'text-blue-600', barClass: 'bg-blue-400' },
  { label: 'AI Captions Written', value: '24', pct: 80, valueClass: 'text-emerald-600', barClass: 'bg-emerald-400' },
  { label: 'Quota Tersisa', value: '61%', pct: 61, valueClass: 'text-amber-600', barClass: 'bg-amber-400' },
];
</script>
