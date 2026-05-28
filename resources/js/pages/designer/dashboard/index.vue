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
            <span class="px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider bg-[#B85C38]/20 text-[#F0A882] rounded-lg border border-[#B85C38]/30">Desainer Terverifikasi</span>
            <span class="px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider bg-[#C9A45C]/20 text-[#E8C97A] rounded-lg border border-[#C9A45C]/30">Kolaborator Aktif</span>
          </div>
          <h1 class="text-2xl sm:text-3xl font-bold text-white mb-1.5">Selamat datang, {{ user?.name || 'Designer' }}</h1>
          <p class="text-[#C4B5A6] text-sm max-w-lg">Kelola kolaborasi dengan UMKM, bangun portofolio, dan tingkatkan karir desain Anda dari satu ruang kerja.</p>
        </div>
        <div class="flex flex-wrap gap-2.5">
          <router-link to="/designer/cocreate" class="px-5 py-2.5 bg-white text-[#2B1E16] rounded-xl font-semibold text-[13px] hover:shadow-lg hover:scale-[1.02] transition-all flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
            Lihat Undangan
          </router-link>
          <router-link to="/designer/portfolio" class="px-5 py-2.5 bg-white/10 backdrop-blur-sm text-white rounded-xl font-semibold text-[13px] border border-white/20 hover:bg-white/20 transition-all flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
            Portofolio Saya
          </router-link>
        </div>
      </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
      <div v-for="(stat, idx) in statCards" :key="idx" class="bg-white rounded-2xl p-5 border border-[#E8DCCB]/60 hover:shadow-md hover:border-[#E8DCCB] transition-all duration-200">
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
      <!-- Collaboration Chart -->
      <div class="lg:col-span-2 bg-white rounded-2xl border border-[#E8DCCB]/60 p-6">
        <div class="flex items-center justify-between mb-6">
          <div>
            <h3 class="text-[15px] font-bold text-[#2B1E16]">Aktivitas Kolaborasi</h3>
            <p class="text-[11px] text-[#8A7A6C] mt-0.5">Performa 6 bulan terakhir</p>
          </div>
          <div class="flex items-center gap-3">
            <div class="flex items-center gap-1.5">
              <div class="w-2.5 h-2.5 rounded-sm bg-[#B85C38]"></div>
              <span class="text-[10px] text-[#8A7A6C] font-medium">Selesai</span>
            </div>
            <div class="flex items-center gap-1.5">
              <div class="w-2.5 h-2.5 rounded-sm bg-[#E8DCCB]"></div>
              <span class="text-[10px] text-[#8A7A6C] font-medium">Progres</span>
            </div>
          </div>
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
                <div v-if="hoveredBar === idx" class="absolute -top-10 left-1/2 -translate-x-1/2 bg-[#2B1E16] text-white px-2.5 py-1.5 rounded-lg text-[10px] font-bold whitespace-nowrap z-10 shadow-md">
                  {{ bar.completed }} Selesai · {{ bar.inProgress }} Progres
                </div>
                <!-- Stacked bar -->
                <div class="w-full flex flex-col justify-end transition-all duration-200" :style="{ height: (bar.completedPct + bar.inProgressPct) + '%' }">
                  <div class="w-full bg-[#E8DCCB]/80 rounded-t-md transition-all" :style="{ height: (bar.inProgressPct / (bar.completedPct + bar.inProgressPct || 1) * 100) + '%' }"></div>
                  <div class="w-full bg-gradient-to-t from-[#B85C38] to-[#D4845A] rounded-b-md transition-all" :style="{ height: (bar.completedPct / (bar.completedPct + bar.inProgressPct || 1) * 100) + '%' }"></div>
                </div>
              </div>
              <p class="text-[10px] text-[#8A7A6C] text-center mt-2 font-medium">{{ bar.label }}</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Recent Invitations -->
      <div class="bg-white rounded-2xl border border-[#E8DCCB]/60 p-6">
        <div class="flex items-center justify-between mb-5">
          <h3 class="text-[15px] font-bold text-[#2B1E16]">Undangan Masuk</h3>
          <router-link to="/designer/cocreate" class="text-[11px] font-bold text-[#B85C38] hover:underline flex items-center gap-1">
            Lihat Semua
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg>
          </router-link>
        </div>

        <div class="space-y-2.5">
          <div v-if="invitations.length === 0" class="text-center py-10">
            <div class="w-14 h-14 mx-auto mb-3 rounded-2xl bg-[#F8F1E7] flex items-center justify-center">
              <svg class="w-6 h-6 text-[#B85C38]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" /></svg>
            </div>
            <p class="text-sm font-semibold text-[#2B1E16] mb-1">Belum ada undangan</p>
            <p class="text-[11px] text-[#8A7A6C] max-w-[200px] mx-auto">Undangan kolaborasi baru dari mitra UMKM akan muncul di sini.</p>
          </div>
          <div v-for="inv in invitations" :key="inv.id"
            class="flex items-center gap-3 p-3 rounded-xl hover:bg-[#FAF6F0] transition-colors group">
            <div class="w-9 h-9 rounded-xl bg-[#F8F1E7] flex items-center justify-center flex-shrink-0 group-hover:bg-[#B85C38]/10 transition-colors border border-[#E8DCCB]">
              <span class="text-xs font-bold text-[#B85C38]">{{ inv.umkmName.charAt(0) }}</span>
            </div>
            <div class="flex-1 min-w-0">
              <p class="text-[12px] font-semibold text-[#2B1E16] truncate">{{ inv.umkmName }}</p>
              <p class="text-[10px] text-[#8A7A6C] truncate">{{ inv.projectName }}</p>
            </div>
            <template v-if="inv.status === 'pending'">
              <button @click="acceptInvitation(inv.id)" class="px-3 py-1.5 bg-[#B85C38] hover:bg-[#B85C38]/90 text-white text-[10px] font-bold rounded-lg transition-colors whitespace-nowrap">
                Terima
              </button>
            </template>
            <span v-else class="text-[10px] font-semibold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full">Diterima</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Bottom Row Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
      <!-- Active Rooms -->
      <div class="bg-white rounded-2xl border border-[#E8DCCB]/60 p-6">
        <div class="flex items-center justify-between mb-5">
          <h3 class="text-[15px] font-bold text-[#2B1E16]">Ruang Aktif</h3>
          <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
        </div>
        <div class="space-y-3">
          <div v-if="activeRooms.length === 0" class="text-center py-10">
            <p class="text-sm font-semibold text-[#2B1E16] mb-1">Tidak ada ruang aktif</p>
            <p class="text-[11px] text-[#8A7A6C] max-w-[200px] mx-auto">Terima undangan kolaborasi untuk mulai mendesain bersama.</p>
          </div>
          <div v-for="room in activeRooms" :key="room.id" @click="goToRoom(room.id)" class="p-3.5 rounded-xl border border-[#E8DCCB] hover:border-[#B85C38]/30 hover:bg-[#FAF6F0]/50 transition-all cursor-pointer group">
            <div class="flex items-center justify-between mb-2">
              <h4 class="text-[12px] font-bold text-[#2B1E16] group-hover:text-[#B85C38] transition-colors truncate">{{ room.name }}</h4>
              <span class="text-[9px] font-bold text-emerald-600 bg-emerald-50 px-1.5 py-0.5 rounded-full">Aktif</span>
            </div>
            <div class="flex items-center justify-between mt-3">
              <div class="flex -space-x-1.5">
                <div v-for="(m, idx) in room.members.slice(0, 4)" :key="idx" class="w-6 h-6 rounded-full border-2 border-white flex items-center justify-center text-[8px] font-bold text-white shadow-sm" :class="m.color">
                  {{ m.name.charAt(0) }}
                </div>
              </div>
              <span class="text-[10px] text-[#8A7A6C] font-medium">{{ room.timeAgo }}</span>
            </div>
          </div>
        </div>
      </div>

      <!-- CTA Portfolio Upgrade -->
      <div class="bg-gradient-to-br from-[#B85C38] to-[#9E4B2E] rounded-2xl p-6 text-white relative overflow-hidden shadow-md flex flex-col justify-between">
        <div class="absolute -right-6 -top-6 w-24 h-24 bg-white/10 rounded-full blur-xl"></div>
        <div class="absolute -left-6 -bottom-6 w-32 h-32 bg-white/5 rounded-full blur-2xl"></div>
        <div class="relative z-10">
          <p class="text-3xl mb-3">✨</p>
          <h3 class="text-lg font-bold mb-2">Tingkatkan Portofolio!</h3>
          <p class="text-xs text-white/85 font-medium leading-relaxed mb-5">
            Kamu sudah menyelesaikan {{ stats.completedProjects }} proyek kolaborasi. Tambahkan karya baru ke portofolio untuk menarik lebih banyak mitra UMKM.
          </p>
        </div>
        <div class="relative z-10 mt-auto">
          <router-link to="/designer/portfolio" class="inline-block bg-white text-[#B85C38] font-bold text-[11px] uppercase tracking-wider px-5 py-3 rounded-xl hover:bg-[#F8F1E7] transition-all shadow-sm">
            Kelola Portofolio
          </router-link>
        </div>
      </div>

      <!-- Skills -->
      <div class="bg-white rounded-2xl border border-[#E8DCCB]/60 p-6">
        <div class="flex items-center justify-between mb-5">
          <h3 class="text-[15px] font-bold text-[#2B1E16]">Skill & Keahlian</h3>
          <router-link to="/designer/settings" class="text-[11px] font-bold text-[#B85C38] hover:underline">Edit</router-link>
        </div>
        <div class="flex flex-wrap gap-1.5">
          <span v-for="skill in skills" :key="skill" class="px-3 py-1.5 bg-[#FAF6F0]/60 text-[#6F6259] text-[11px] font-bold rounded-xl border border-[#E8DCCB]/60 hover:border-[#B85C38]/40 hover:text-[#B85C38] transition-all cursor-default">
            {{ skill }}
          </span>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, h, onMounted } from 'vue';
import { useRouter } from 'vue-router';

const router = useRouter();
const user = ref(JSON.parse(localStorage.getItem('user') || '{}'));
const hoveredBar = ref(null);

const stats = ref({ completedProjects: 0, activeRooms: 0, totalUMKMPartners: 0, portfolioViews: 0 });

const IconCheckCircle = () => h('svg', { fill: 'none', stroke: 'currentColor', viewBox: '0 0 24 24', 'stroke-width': '1.8' }, [
  h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', d: 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z' })
]);
const IconLink = () => h('svg', { fill: 'none', stroke: 'currentColor', viewBox: '0 0 24 24', 'stroke-width': '1.8' }, [
  h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', d: 'M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1' })
]);
const IconUsers = () => h('svg', { fill: 'none', stroke: 'currentColor', viewBox: '0 0 24 24', 'stroke-width': '1.8' }, [
  h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', d: 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z' })
]);
const IconEye = () => h('svg', { fill: 'none', stroke: 'currentColor', viewBox: '0 0 24 24', 'stroke-width': '1.8' }, [
  h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', d: 'M15 12a3 3 0 11-6 0 3 3 0 016 0z' }),
  h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', d: 'M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z' })
]);

const statCards = computed(() => [
  { label: 'Proyek Selesai', value: stats.value.completedProjects.toString(), icon: IconCheckCircle, iconBg: 'bg-emerald-50', iconColor: 'text-emerald-600', badgeClass: 'bg-emerald-50 text-emerald-700', change: 'Selesai' },
  { label: 'Ruang Aktif', value: stats.value.activeRooms.toString(), icon: IconLink, iconBg: 'bg-blue-50', iconColor: 'text-blue-600', badgeClass: 'bg-blue-50 text-blue-700', change: 'Aktif' },
  { label: 'Mitra UMKM', value: stats.value.totalUMKMPartners.toString(), icon: IconUsers, iconBg: 'bg-purple-50', iconColor: 'text-purple-600', badgeClass: 'bg-purple-50 text-purple-700', change: 'Mitra' },
  { label: 'Tayangan Portofolio', value: stats.value.portfolioViews.toString(), icon: IconEye, iconBg: 'bg-amber-50', iconColor: 'text-amber-600', badgeClass: 'bg-amber-50 text-amber-700', change: 'Total' },
]);

const chartData = ref([
  { label: 'Jan', completed: 0, inProgress: 0, completedPct: 0, inProgressPct: 0 },
  { label: 'Feb', completed: 0, inProgress: 0, completedPct: 0, inProgressPct: 0 },
  { label: 'Mar', completed: 0, inProgress: 0, completedPct: 0, inProgressPct: 0 },
  { label: 'Apr', completed: 0, inProgress: 0, completedPct: 0, inProgressPct: 0 },
  { label: 'Mei', completed: 0, inProgress: 0, completedPct: 0, inProgressPct: 0 },
  { label: 'Jun', completed: 0, inProgress: 0, completedPct: 0, inProgressPct: 0 },
]);

const invitations = ref([]);
const activeRooms = ref([]);
const skills = ref([]);

const fetchDashboardData = async () => {
  try {
    const token = localStorage.getItem('token');
    if (!token) return;

    const res = await fetch('/api/v1/designer/dashboard', {
      headers: {
        'Authorization': `Bearer ${token}`,
        'Accept': 'application/json'
      }
    });

    if (res.ok) {
      const data = await res.json();
      stats.value = data.stats || stats.value;
      chartData.value = data.chartData || chartData.value;
      invitations.value = data.invitations || [];
      activeRooms.value = data.activeRooms || [];
      skills.value = data.skills || [];
    }
  } catch (e) {
    console.error('Gagal mengambil data dashboard desainer:', e);
  }
};

const acceptInvitation = async (roomId) => {
  try {
    const token = localStorage.getItem('token');
    const res = await fetch(`/api/v1/cocreate/rooms/${roomId}/join`, {
      method: 'POST',
      headers: {
        'Authorization': `Bearer ${token}`,
        'Accept': 'application/json'
      }
    });
    if (res.ok) {
      router.push(`/designer/cocreate/${roomId}`);
    }
  } catch (e) {
    console.error('Gagal menerima undangan:', e);
  }
};

const goToRoom = (roomId) => {
  router.push(`/designer/cocreate/${roomId}`);
};

onMounted(() => {
  fetchDashboardData();
});
</script>

<style scoped>
.no-scrollbar::-webkit-scrollbar { display: none; }
.no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
</style>
