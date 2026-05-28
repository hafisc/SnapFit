<template>
  <div class="space-y-5 w-full">
    <!-- Period Selector -->
    <div class="flex items-center justify-between">
      <div class="flex bg-[#F8F1E7] rounded-xl p-1 border border-[#E8DCCB]/50">
        <button v-for="p in periods" :key="p" @click="activePeriod = p"
          class="px-3.5 py-2 text-[11px] font-bold rounded-lg transition-all cursor-pointer"
          :class="activePeriod === p ? 'bg-white text-[#2B1E16] shadow-sm' : 'text-[#8A7A6C] hover:text-[#2B1E16]'">
          {{ p }}
        </button>
      </div>
      <button @click="exportCSV" class="px-4 py-2 bg-white border border-[#E8DCCB] rounded-xl text-[11px] font-bold text-[#2B1E16] hover:bg-[#F8F1E7] transition-colors flex items-center gap-1.5 cursor-pointer">
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
        Ekspor CSV
      </button>
    </div>

    <!-- KPI Cards Row -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
      <div v-for="k in kpis" :key="k.label" class="bg-white rounded-2xl border border-[#E8DCCB]/60 p-5 shadow-sm">
        <p class="text-[10px] text-[#8A7A6C] font-bold uppercase tracking-wider mb-3">{{ k.label }}</p>
        <p class="text-[22px] font-bold text-[#2B1E16] leading-none mb-1">{{ k.value }}</p>
        <div class="flex items-center gap-1 mt-1">
          <span class="text-[10px] font-bold" :class="k.up ? 'text-[#0F8A4B]' : 'text-[#D94A38]'">
            {{ k.up ? '↑' : '↓' }} {{ k.change }}
          </span>
          <span class="text-[10px] text-[#8A7A6C]">vs periode lalu</span>
        </div>
      </div>
    </div>

    <!-- Charts Row (Even Height) -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 items-stretch">
      <!-- Revenue Card -->
      <div class="bg-white rounded-2xl border border-[#E8DCCB]/60 p-6 flex flex-col justify-between shadow-sm min-h-[340px]">
        <div>
          <h3 class="text-[14px] font-bold text-[#2B1E16] mb-1">Tren Pendapatan</h3>
          <p class="text-[11px] text-[#8A7A6C] font-medium mb-6">6 bulan terakhir (dalam Juta Rupiah)</p>
        </div>
        
        <!-- Premium Chart with Y-Axis and Grid alignment -->
        <div class="flex h-52 gap-4 items-stretch flex-1">
          <!-- Y-Axis Labels -->
          <div class="flex flex-col justify-between text-[9px] font-bold text-[#8A7A6C] text-right w-12 pb-6 select-none">
            <span>{{ yAxisLabels[0] }}</span>
            <span>{{ yAxisLabels[1] }}</span>
            <span>{{ yAxisLabels[2] }}</span>
            <span>{{ yAxisLabels[3] }}</span>
          </div>
          
          <!-- Chart Column area -->
          <div class="flex-1 relative h-full">
            <!-- Dashed background grid lines -->
            <div class="absolute inset-0 flex flex-col justify-between pointer-events-none pb-6">
              <div v-for="i in 4" :key="i" class="border-b border-dashed border-[#E8DCCB]/60 h-0 w-full"></div>
            </div>
            
            <!-- Bars -->
            <div class="relative h-full flex items-end gap-2 sm:gap-4 pb-6">
              <div v-for="(m, i) in revenueData" :key="i" class="h-full flex-1 flex flex-col justify-end group cursor-pointer">
                <div class="relative w-full h-full flex flex-col justify-end">
                  <!-- Hover tooltip -->
                  <div class="absolute -top-10 left-1/2 -translate-x-1/2 bg-[#2B1E16] text-white px-2.5 py-1.5 rounded-lg text-[10px] font-bold whitespace-nowrap z-20 opacity-0 group-hover:opacity-100 transition-opacity shadow-md">
                    Rp {{ m.value }}M
                  </div>
                  <!-- Rounded Bar with Gradient -->
                  <div class="w-full rounded-t-lg transition-all duration-300"
                    :class="i === revenueData.length - 1 ? 'bg-gradient-to-t from-[#B85C38] to-[#D4845A]' : 'bg-gradient-to-t from-[#E8DCCB] to-[#F0E6D8] group-hover:from-[#D4C4B0] group-hover:to-[#E8DCCB]'"
                    :style="{ height: (m.value / maxRevenueValue * 100) + '%', minHeight: '8px' }"></div>
                </div>
                <!-- X-Axis Label -->
                <p class="text-[10px] text-[#8A7A6C] text-center mt-2 font-bold absolute bottom-0 inset-x-0 h-4">{{ m.label }}</p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Product Performance Card -->
      <div class="bg-white rounded-2xl border border-[#E8DCCB]/60 p-6 flex flex-col justify-between shadow-sm min-h-[340px]">
        <div>
          <h3 class="text-[14px] font-bold text-[#2B1E16] mb-1">Performa Produk</h3>
          <p class="text-[11px] text-[#8A7A6C] font-medium mb-6">Tayangan vs Konversi per produk</p>
        </div>
        
        <div class="space-y-4 flex-1 flex flex-col justify-center">
          <div v-if="productPerf.length === 0" class="text-center py-10 text-xs text-[#8A7A6C]">
            Belum ada data produk terjual.
          </div>
          <div v-else v-for="p in productPerf" :key="p.name" class="space-y-1">
            <div class="flex items-center justify-between">
              <span class="text-[12px] font-semibold text-[#2B1E16] truncate max-w-[70%]">{{ p.name }}</span>
              <span class="text-[11px] font-bold text-[#2B1E16] bg-[#F8F1E7] px-2 py-0.5 rounded-md">{{ p.conversion }}% konversi</span>
            </div>
            <!-- Dynamic Progress bar -->
            <div class="h-2 bg-[#F8F1E7] rounded-full overflow-hidden">
              <div class="h-full rounded-full transition-all duration-700" :class="p.barClass" :style="{ width: p.conversion * 5 + '%' }"></div>
            </div>
            <div class="flex items-center justify-between text-[10px] text-[#8A7A6C] font-medium">
              <span>👁️ {{ p.views }} tayangan</span>
              <span>🛒 {{ p.orders }} pesanan</span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Bottom Row (Even Heights via items-stretch) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 items-stretch">
      <!-- Traffic Sources Card -->
      <div class="bg-white rounded-2xl border border-[#E8DCCB]/60 p-6 flex flex-col justify-between shadow-sm min-h-[320px]">
        <h3 class="text-[14px] font-bold text-[#2B1E16] mb-5">Sumber Traffic</h3>
        <div class="space-y-3.5 flex-1 flex flex-col justify-center">
          <div v-for="t in trafficSources" :key="t.name" class="flex items-center gap-3">
            <span class="w-8 h-8 rounded-xl flex items-center justify-center text-sm shadow-sm" :class="t.bgClass">{{ t.emoji }}</span>
            <div class="flex-1">
              <div class="flex items-center justify-between mb-1">
                <span class="text-[12px] font-semibold text-[#2B1E16]">{{ t.name }}</span>
                <span class="text-[11px] font-bold text-[#2B1E16]">{{ t.pct }}%</span>
              </div>
              <div class="h-1.5 bg-[#F8F1E7] rounded-full overflow-hidden">
                <div class="h-full rounded-full transition-all duration-700" :class="t.barClass" :style="{ width: t.pct + '%' }"></div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Customer Demographics Card -->
      <div class="bg-white rounded-2xl border border-[#E8DCCB]/60 p-6 flex flex-col justify-between shadow-sm min-h-[320px]">
        <h3 class="text-[14px] font-bold text-[#2B1E16] mb-5">Demografi Pembeli</h3>
        <div class="space-y-3.5 flex-1 flex flex-col justify-center">
          <div v-if="demographics.length === 0" class="text-center py-10 text-xs text-[#8A7A6C]">
            Belum ada data demografi pembeli.
          </div>
          <div v-else v-for="d in demographics" :key="d.city" class="space-y-1.5">
            <div class="flex items-center justify-between">
              <div class="flex items-center gap-2">
                <span class="w-2.5 h-2.5 rounded-full" :class="d.dotClass"></span>
                <span class="text-[12px] font-semibold text-[#2B1E16]">{{ d.city }}</span>
              </div>
              <div class="text-right">
                <span class="text-[11px] font-bold text-[#2B1E16]">{{ d.orders }}</span>
                <span class="text-[9px] text-[#8A7A6C] ml-1 font-medium">pesanan</span>
              </div>
            </div>
            <!-- Progress Bar proportional to total demographic orders -->
            <div class="h-1.5 bg-[#F8F1E7] rounded-full overflow-hidden">
              <div class="h-full rounded-full transition-all duration-700" 
                :class="d.dotClass" 
                :style="{ width: (totalDemographicOrders > 0 ? (d.orders / totalDemographicOrders) * 100 : 0) + '%' }"></div>
            </div>
          </div>
        </div>
      </div>

      <!-- AI Studio Stats Card -->
      <div class="bg-white rounded-2xl border border-[#E8DCCB]/60 p-6 flex flex-col justify-between shadow-sm min-h-[320px]">
        <h3 class="text-[14px] font-bold text-[#2B1E16] mb-5">Penggunaan AI Studio</h3>
        <div class="space-y-4 flex-1 flex flex-col justify-center">
          <div v-for="a in aiStats" :key="a.label">
            <div class="flex items-center justify-between mb-1.5">
              <span class="text-[12px] font-semibold text-[#6F6259]">{{ a.label }}</span>
              <span class="text-[12px] font-bold" :class="a.valueClass">{{ a.value }}</span>
            </div>
            <div class="h-1.5 bg-[#F8F1E7] rounded-full overflow-hidden">
              <div class="h-full rounded-full transition-all duration-500" :class="a.barClass" :style="{ width: a.pct + '%' }"></div>
            </div>
          </div>
          <div class="mt-4 p-3 rounded-xl bg-[#B85C38]/5 border border-[#B85C38]/15 flex items-center justify-center">
            <p class="text-[10.5px] text-[#B85C38] font-bold text-center">💡 Estimasi biaya dihemat bulan ini: Rp 2.500.000</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, watch } from 'vue';

const activePeriod = ref('Bulan Ini');
const periods = ['Minggu Ini', 'Bulan Ini', '3 Bulan', '1 Tahun'];

watch(activePeriod, () => {
  fetchAnalytics();
});

const loading = ref(true);
const kpis = ref([
  { label: 'Total Pendapatan', value: 'Rp 0', change: '0%', up: true },
  { label: 'Total Pesanan', value: '0', change: '0%', up: true },
  { label: 'Rata-rata Order', value: 'Rp 0', change: '0%', up: true },
  { label: 'Total Produk', value: '0', change: '0%', up: true },
]);
const revenueData = ref([]);
const productPerf = ref([]);
const demographics = ref([]);
const aiStats = ref([]);

const trafficSources = ref([
  { name: 'SnapFit Marketplace', pct: 52, emoji: '🏪', bgClass: 'bg-sand', barClass: 'bg-orange-400' },
  { name: 'Instagram', pct: 24, emoji: '📸', bgClass: 'bg-pink-50', barClass: 'bg-pink-400' },
  { name: 'Google Search', pct: 14, emoji: '🔍', bgClass: 'bg-blue-50', barClass: 'bg-blue-400' },
  { name: 'Direct / Lainnya', pct: 10, emoji: '🔗', bgClass: 'bg-slate-50', barClass: 'bg-slate-400' },
]);

// Compute total demographic orders to draw proportions
const totalDemographicOrders = computed(() => {
  return demographics.value.reduce((acc, d) => acc + d.orders, 0);
});

// Compute target maximum for Y-axis scale dynamically based on revenue max value
const maxRevenueValue = computed(() => {
  const vals = revenueData.value.map(r => r.value) || [];
  const max = vals.length > 0 ? Math.max(...vals) : 0;
  return max === 0 ? 10 : Math.ceil(max / 5) * 5;
});

// Compute dynamic Y-axis label steps
const yAxisLabels = computed(() => {
  const targetMax = maxRevenueValue.value;
  return [
    `Rp ${targetMax}M`,
    `Rp ${Math.round(targetMax * 0.66 * 10) / 10}M`,
    `Rp ${Math.round(targetMax * 0.33 * 10) / 10}M`,
    'Rp 0'
  ];
});

const fetchAnalytics = async () => {
  loading.value = true;
  try {
    const token = localStorage.getItem('token');
    const res = await fetch(`/api/v1/umkm/analytics?period=${encodeURIComponent(activePeriod.value)}`, {
      headers: {
        'Authorization': `Bearer ${token}`,
        'Accept': 'application/json',
      }
    });
    if (res.ok) {
      const data = await res.json();
      kpis.value = data.kpis;
      revenueData.value = data.revenue_trend;
      productPerf.value = data.product_perf;
      demographics.value = data.demographics;
      aiStats.value = data.ai_stats;
    }
  } catch (e) {
    console.error('Failed to fetch analytics:', e);
  } finally {
    loading.value = false;
  }
};

const exportCSV = () => {
  const sanitize = (val) => {
    const stringVal = String(val).replace(/"/g, '""');
    return stringVal.includes(',') || stringVal.includes('\n') || stringVal.includes('"')
      ? `"${stringVal}"`
      : stringVal;
  };

  const rows = [];
  
  // Title / Metadata
  rows.push([sanitize('LAPORAN ANALITIK SNAPFIT')]);
  rows.push([sanitize('Tanggal Ekspor:'), sanitize(new Date().toLocaleDateString('id-ID'))]);
  rows.push([sanitize('Periode:'), sanitize(activePeriod.value)]);
  rows.push([]); // empty line

  // KPI Metrik
  rows.push([sanitize('RINGKASAN METRIK')]);
  rows.push([sanitize('Metrik'), sanitize('Nilai'), sanitize('Perubahan')]);
  kpis.value.forEach(k => {
    const changeText = `${k.up ? '↑' : '↓'} ${k.change}`;
    rows.push([sanitize(k.label), sanitize(k.value), sanitize(changeText)]);
  });
  rows.push([]); // empty line

  // Revenue Trend
  rows.push([sanitize('TREN PENDAPATAN (6 BULAN TERAKHIR)')]);
  rows.push([sanitize('Bulan'), sanitize('Pendapatan (Juta Rp)')]);
  revenueData.value.forEach(r => {
    rows.push([sanitize(r.label), sanitize(r.value)]);
  });
  rows.push([]); // empty line

  // Product Performance
  rows.push([sanitize('PERFORMA PRODUK')]);
  rows.push([sanitize('Nama Produk'), sanitize('Konversi'), sanitize('Views'), sanitize('Orders')]);
  productPerf.value.forEach(p => {
    rows.push([sanitize(p.name), sanitize(`${p.conversion}%`), sanitize(p.views), sanitize(p.orders)]);
  });
  rows.push([]); // empty line

  // Traffic Sources
  rows.push([sanitize('SUMBER TRAFFIC')]);
  rows.push([sanitize('Sumber'), sanitize('Persentase')]);
  trafficSources.value.forEach(t => {
    rows.push([sanitize(t.name), sanitize(`${t.pct}%`)]);
  });
  rows.push([]); // empty line

  // Buyer Demographics
  rows.push([sanitize('DEMOGRAFI PEMBELI')]);
  rows.push([sanitize('Kota'), sanitize('Jumlah Pesanan')]);
  demographics.value.forEach(d => {
    rows.push([sanitize(d.city), sanitize(d.orders)]);
  });
  rows.push([]); // empty line

  // AI Studio Usage
  rows.push([sanitize('AI STUDIO USAGE')]);
  rows.push([sanitize('Fitur'), sanitize('Penggunaan')]);
  aiStats.value.forEach(a => {
    rows.push([sanitize(a.label), sanitize(a.value)]);
  });

  const csvContent = rows.map(r => r.join(',')).join('\n');
  const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
  const url = URL.createObjectURL(blob);
  const link = document.createElement('a');
  link.setAttribute('href', url);
  link.setAttribute('download', `Analitik_SnapFit_${new Date().toISOString().slice(0, 10)}.csv`);
  link.style.visibility = 'hidden';
  document.body.appendChild(link);
  link.click();
  document.body.removeChild(link);
};

onMounted(() => {
  fetchAnalytics();
});
</script>
