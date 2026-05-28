<template>
  <div class="space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-700 w-full">
    <!-- Header -->
    <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
      <div>
        <h2 class="text-2xl font-bold text-espresso tracking-tight">Riwayat Kolaborasi</h2>
        <p class="text-sm text-muted font-medium mt-1">Semua proyek kolaborasi yang pernah Anda kerjakan</p>
      </div>
      <!-- Search & Filter -->
      <div class="flex items-center gap-3">
        <div class="flex items-center bg-surface rounded-2xl border border-borderSoft px-4 py-2.5 gap-2">
          <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
          <input v-model="searchQuery" type="text" placeholder="Cari kolaborasi..." class="bg-transparent outline-none text-xs font-medium text-muted w-40 placeholder:text-slate-400" />
        </div>
        <select v-model="filterYear" class="bg-surface border border-borderSoft rounded-2xl px-4 py-2.5 text-xs font-bold text-muted outline-none cursor-pointer focus:border-orange-500 transition-colors">
          <option value="all">Semua Tahun</option>
          <option value="2026">2026</option>
          <option value="2025">2025</option>
        </select>
      </div>
    </div>

    <!-- Summary Stats -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
      <div class="bg-surface rounded-2xl border border-borderSoft p-5 text-center">
        <p class="text-3xl font-bold text-terracotta">{{ summaryStats.totalProjects }}</p>
        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mt-1">Total Proyek</p>
      </div>
      <div class="bg-surface rounded-2xl border border-borderSoft p-5 text-center">
        <p class="text-3xl font-bold text-emerald-600">{{ summaryStats.umkmPartners }}</p>
        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mt-1">Mitra UMKM</p>
      </div>
      <div class="bg-surface rounded-2xl border border-borderSoft p-5 text-center">
        <p class="text-3xl font-bold text-amber-500">{{ summaryStats.avgRating }}</p>
        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mt-1">Rata-rata Rating</p>
      </div>
      <div class="bg-surface rounded-2xl border border-borderSoft p-5 text-center">
        <p class="text-3xl font-bold text-blue-600">Rp {{ summaryStats.totalEarnings }}</p>
        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mt-1">Total Pendapatan</p>
      </div>
    </div>

    <!-- Timeline -->
    <div class="space-y-6">
      <div v-for="(group, gIdx) in groupedHistory" :key="gIdx">
        <!-- Month Label -->
        <div class="flex items-center gap-3 mb-4">
          <span class="text-xs font-bold text-terracotta uppercase tracking-wider bg-sand px-4 py-2 rounded-xl border border-terracotta/20">{{ group.month }}</span>
          <div class="flex-1 h-px bg-slate-200"></div>
          <span class="text-[10px] font-bold text-slate-400">{{ group.items.length }} proyek</span>
        </div>

        <!-- Cards -->
        <div class="space-y-4">
          <div v-for="item in group.items" :key="item.id"
            class="bg-surface rounded-2xl border border-borderSoft/60 p-6 hover:shadow-md transition-all duration-300 group">
            <div class="flex flex-col lg:flex-row items-start lg:items-center gap-5">
              <!-- Thumbnail -->
              <div class="w-full lg:w-20 h-32 lg:h-20 rounded-2xl overflow-hidden flex-shrink-0 bg-slate-100">
                <img :src="item.thumbnail" :alt="item.projectName" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" />
              </div>

              <!-- Info -->
              <div class="flex-1 min-w-0">
                <div class="flex flex-wrap items-center gap-2 mb-1">
                  <h3 class="text-base font-bold text-espresso truncate group-hover:text-terracotta transition-colors">{{ item.projectName }}</h3>
                  <span class="px-2.5 py-1 text-[9px] font-bold uppercase tracking-wider rounded-lg" :class="item.categoryClass">{{ item.category }}</span>
                </div>
                <p class="text-xs text-muted font-medium mb-2">{{ item.umkmName }}</p>
                <div class="flex flex-wrap items-center gap-4 text-[11px] text-slate-400 font-medium">
                  <span class="flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                    {{ item.startDate }} — {{ item.endDate }}
                  </span>
                  <span class="flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    {{ item.duration }}
                  </span>
                </div>
              </div>

              <!-- Rating & Earnings -->
              <div class="flex items-center gap-6 flex-shrink-0">
                <div class="text-center">
                  <div class="flex items-center gap-0.5 text-amber-400 mb-1">
                    <span v-for="i in 5" :key="i" class="text-sm">{{ i <= item.rating ? '★' : '☆' }}</span>
                  </div>
                  <p class="text-[10px] text-slate-400 font-medium">{{ item.rating }}/5</p>
                </div>
                <div class="text-right hidden sm:block">
                  <p class="text-lg font-bold text-espresso">Rp {{ item.earnings.toLocaleString('id-ID') }}</p>
                  <p class="text-[10px] text-slate-400 font-medium">Pendapatan</p>
                </div>
                <span class="px-3 py-1.5 text-[10px] font-bold uppercase tracking-wider rounded-xl" :class="item.statusClass">{{ item.statusLabel }}</span>
              </div>
            </div>

            <!-- Expandable Feedback -->
            <div v-if="item.feedback" class="mt-4 pt-4 border-t border-borderSoft">
              <div class="bg-sand rounded-xl p-4 border border-terracotta/20">
                <p class="text-[10px] font-bold text-terracotta uppercase tracking-wider mb-1.5">💬 Feedback dari UMKM</p>
                <p class="text-xs text-muted font-medium leading-relaxed italic">"{{ item.feedback }}"</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';

const searchQuery = ref('');
const filterYear = ref('all');

const summaryStats = { totalProjects: 18, umkmPartners: 12, avgRating: '4.8', totalEarnings: '28.5M' };

const historyItems = ref([
  { id: 1, projectName: 'Packaging Batik Tulis Premium', umkmName: 'Batik Sari Malang', category: 'Packaging', categoryClass: 'bg-sand text-terracotta', startDate: '1 Mei', endDate: '15 Mei', month: 'Mei 2026', duration: '15 hari', rating: 5, earnings: 2500000, statusLabel: 'Selesai', statusClass: 'bg-emerald-50 text-emerald-600', thumbnail: '/images/products/batik_pekalongan.png', feedback: 'Desainnya luar biasa! Sangat merepresentasikan identitas batik Malang dengan sentuhan modern.' },
  { id: 2, projectName: 'Branding Identity Rotan Craft', umkmName: 'Rotan Craft Arjosari', category: 'Branding', categoryClass: 'bg-sand text-terracotta', startDate: '10 Apr', endDate: '28 Apr', month: 'April 2026', duration: '18 hari', rating: 5, earnings: 3000000, statusLabel: 'Selesai', statusClass: 'bg-emerald-50 text-emerald-600', thumbnail: '/images/products/tas_goni.png', feedback: 'Profesional dan kreatif. Brand identity yang dihasilkan sangat membantu positioning produk kami.' },
  { id: 3, projectName: 'Social Media Visual Kit', umkmName: 'Kopi Gunung Arjuno', category: 'Social Media', categoryClass: 'bg-blue-50 text-blue-600', startDate: '5 Apr', endDate: '15 Apr', month: 'April 2026', duration: '10 hari', rating: 4, earnings: 1500000, statusLabel: 'Selesai', statusClass: 'bg-emerald-50 text-emerald-600', thumbnail: '/images/products/kopi_arjuno.png', feedback: 'Template-nya bagus dan mudah digunakan.' },
  { id: 4, projectName: 'Logo Redesign Keramik Dinoyo', umkmName: 'Kampoeng Keramik', category: 'Logo', categoryClass: 'bg-pink-50 text-pink-600', startDate: '15 Mar', endDate: '25 Mar', month: 'Maret 2026', duration: '10 hari', rating: 5, earnings: 2000000, statusLabel: 'Selesai', statusClass: 'bg-emerald-50 text-emerald-600', thumbnail: '/images/products/keramik_dinoyo.png', feedback: null },
  { id: 5, projectName: 'Packaging Kripik Tempe', umkmName: 'Tempe Sanan Craft', category: 'Packaging', categoryClass: 'bg-sand text-terracotta', startDate: '1 Mar', endDate: '12 Mar', month: 'Maret 2026', duration: '12 hari', rating: 4, earnings: 1800000, statusLabel: 'Selesai', statusClass: 'bg-emerald-50 text-emerald-600', thumbnail: '/images/products/kripik_tempe.png', feedback: 'Desain packaging-nya menarik dan meningkatkan penjualan 25%!' },
]);

const groupedHistory = computed(() => {
  const filtered = historyItems.value.filter(item => {
    const matchSearch = !searchQuery.value || item.projectName.toLowerCase().includes(searchQuery.value.toLowerCase()) || item.umkmName.toLowerCase().includes(searchQuery.value.toLowerCase());
    const matchYear = filterYear.value === 'all' || item.month.includes(filterYear.value);
    return matchSearch && matchYear;
  });
  const groups = {};
  filtered.forEach(item => {
    if (!groups[item.month]) groups[item.month] = [];
    groups[item.month].push(item);
  });
  return Object.entries(groups).map(([month, items]) => ({ month, items }));
});
</script>
