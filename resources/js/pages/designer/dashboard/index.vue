<template>
  <div class="space-y-5 max-w-[1400px]">
    <!-- Welcome -->
    <div class="bg-surface rounded-2xl border border-borderSoft/60 p-6 flex flex-col md:flex-row items-start md:items-center justify-between gap-5 relative overflow-hidden">
      <div class="absolute right-0 top-0 w-64 h-full bg-gradient-to-l from-orange-50 to-transparent pointer-events-none"></div>
      <div class="relative z-10">
        <p class="text-[11px] font-semibold text-terracotta uppercase tracking-wider mb-1">Designer Studio</p>
        <h2 class="text-xl font-bold text-espresso mb-1">Selamat datang, {{ user?.name || 'Designer' }}!</h2>
        <p class="text-[13px] text-slate-400 font-medium max-w-md">Kelola kolaborasi dengan UMKM, bangun portofolio, dan tingkatkan karir desain Anda.</p>
      </div>
      <div class="relative z-10 flex gap-2.5 w-full md:w-auto">
        <router-link to="/designer/cocreate" class="flex-1 md:flex-initial bg-terracotta hover:bg-terracotta text-white px-5 py-2.5 rounded-lg text-[11px] font-bold transition-colors flex items-center justify-center gap-1.5 whitespace-nowrap">
          Lihat Undangan
        </router-link>
        <router-link to="/designer/portfolio" class="flex-1 md:flex-initial bg-surface hover:bg-slate-50 border border-borderSoft text-espresso px-5 py-2.5 rounded-lg text-[11px] font-bold transition-colors flex items-center justify-center whitespace-nowrap">
          Portofolio
        </router-link>
      </div>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
      <div v-for="(s, i) in statCards" :key="i" class="bg-surface rounded-2xl border border-borderSoft/60 p-5">
        <div class="flex items-center justify-between mb-4">
          <div class="w-10 h-10 rounded-xl flex items-center justify-center text-lg" :class="s.bgClass">{{ s.emoji }}</div>
          <span class="text-[10px] font-semibold px-2 py-0.5 rounded-md" :class="s.trendClass">{{ s.trend }}</span>
        </div>
        <p class="text-[22px] font-bold text-espresso leading-none mb-1">{{ s.value }}</p>
        <p class="text-[11px] text-slate-400 font-medium">{{ s.title }}</p>
      </div>
    </div>

    <!-- Main Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-4">
      <!-- Chart -->
      <div class="lg:col-span-3 bg-surface rounded-2xl border border-borderSoft/60 p-6">
        <div class="flex items-center justify-between mb-6">
          <div>
            <h3 class="text-[14px] font-bold text-espresso">Aktivitas Kolaborasi</h3>
            <p class="text-[11px] text-slate-400 font-medium">6 bulan terakhir</p>
          </div>
          <div class="flex items-center gap-3">
            <div class="flex items-center gap-1.5"><div class="w-2.5 h-2.5 rounded-sm bg-terracotta"></div><span class="text-[10px] text-slate-400 font-medium">Selesai</span></div>
            <div class="flex items-center gap-1.5"><div class="w-2.5 h-2.5 rounded-sm bg-orange-200"></div><span class="text-[10px] text-slate-400 font-medium">Progress</span></div>
          </div>
        </div>
        <div class="h-44 flex items-end gap-2 relative">
          <div class="absolute inset-0 flex flex-col justify-between pointer-events-none"><div v-for="i in 4" :key="i" class="w-full border-b border-dashed border-borderSoft"></div></div>
          <div v-for="(m, idx) in chartData" :key="idx" class="flex-1 flex flex-col items-center justify-end h-full gap-0.5 group cursor-pointer relative z-10">
            <div class="absolute -top-8 bg-slate-800 text-white text-[10px] font-bold px-2 py-1 rounded-md opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap z-20">{{ m.completed }} selesai · {{ m.inProgress }} aktif</div>
            <div class="w-full bg-orange-200 rounded-t-sm transition-colors group-hover:bg-orange-300" :style="{ height: m.inProgressPct + '%' }"></div>
            <div class="w-full bg-terracotta rounded-b-sm transition-colors group-hover:bg-terracotta" :style="{ height: m.completedPct + '%' }"></div>
          </div>
        </div>
        <div class="flex justify-between mt-3 text-[10px] text-slate-400 font-medium">
          <span v-for="m in chartData" :key="m.label">{{ m.label }}</span>
        </div>
      </div>

      <!-- Recent Invitations -->
      <div class="lg:col-span-2 bg-surface rounded-2xl border border-borderSoft/60 p-6">
        <div class="flex items-center justify-between mb-5">
          <h3 class="text-[14px] font-bold text-espresso">Undangan Masuk</h3>
          <router-link to="/designer/cocreate" class="text-[11px] font-semibold text-terracotta hover:text-terracotta">Lihat Semua</router-link>
        </div>
        <div class="space-y-3">
          <div v-for="inv in invitations" :key="inv.id" class="flex items-center gap-3 p-2.5 -mx-2.5 rounded-xl hover:bg-slate-50 transition-colors group">
            <div class="w-9 h-9 rounded-lg flex items-center justify-center font-bold text-[12px] text-white flex-shrink-0" :class="inv.avatarClass">{{ inv.umkmName.charAt(0) }}</div>
            <div class="flex-1 min-w-0">
              <p class="text-[12px] font-semibold text-espresso truncate">{{ inv.umkmName }}</p>
              <p class="text-[10px] text-slate-400 truncate">{{ inv.projectName }}</p>
            </div>
            <template v-if="inv.status === 'pending'">
              <button @click="acceptInvitation(inv.id)" class="px-2.5 py-1 bg-terracotta hover:bg-terracotta text-white text-[10px] font-bold rounded-md transition-colors">Terima</button>
            </template>
            <span v-else-if="inv.status === 'accepted'" class="text-[10px] font-semibold text-emerald-500">✓ Diterima</span>
            <span v-else class="text-[10px] font-semibold text-slate-400">Selesai</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Bottom Row -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
      <!-- Active Rooms -->
      <div class="bg-surface rounded-2xl border border-borderSoft/60 p-6">
        <div class="flex items-center justify-between mb-5">
          <h3 class="text-[14px] font-bold text-espresso">Room Aktif</h3>
          <span class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse"></span>
        </div>
        <div class="space-y-3">
          <div v-for="room in activeRooms" :key="room.id" @click="goToRoom(room.id)" class="p-3 rounded-xl border border-borderSoft hover:border-terracotta/30 hover:bg-sand/30 transition-all cursor-pointer group">
            <div class="flex items-center justify-between mb-2">
              <h4 class="text-[12px] font-semibold text-espresso group-hover:text-terracotta transition-colors truncate">{{ room.name }}</h4>
              <span class="text-[9px] font-bold text-emerald-500 bg-emerald-50 px-1.5 py-0.5 rounded">Live</span>
            </div>
            <div class="flex items-center justify-between">
              <div class="flex -space-x-1.5">
                <div v-for="(m, idx) in room.members.slice(0, 4)" :key="idx" class="w-6 h-6 rounded-full border-2 border-white flex items-center justify-center text-[8px] font-bold text-white" :class="m.color">{{ m.name.charAt(0) }}</div>
              </div>
              <span class="text-[10px] text-slate-400">{{ room.timeAgo }}</span>
            </div>
          </div>
        </div>
      </div>

      <!-- CTA -->
      <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl p-6 text-white relative overflow-hidden">
        <div class="absolute -right-6 -top-6 w-24 h-24 bg-surface/10 rounded-full blur-xl"></div>
        <div class="relative z-10">
          <p class="text-2xl mb-3">✨</p>
          <h3 class="text-[16px] font-bold mb-2">Level Up Portofolio!</h3>
          <p class="text-[12px] text-white/80 font-medium leading-relaxed mb-5">Kamu sudah menyelesaikan {{ stats.completedProjects }} proyek. Tambahkan ke portofolio untuk menarik lebih banyak UMKM.</p>
          <router-link to="/designer/portfolio" class="inline-block bg-surface text-terracotta font-bold text-[11px] px-4 py-2.5 rounded-lg hover:bg-sand transition-colors">Kelola Portofolio</router-link>
        </div>
      </div>

      <!-- Skills -->
      <div class="bg-surface rounded-2xl border border-borderSoft/60 p-6">
        <div class="flex items-center justify-between mb-5">
          <h3 class="text-[14px] font-bold text-espresso">Skill & Keahlian</h3>
          <button class="text-[11px] font-semibold text-terracotta hover:text-terracotta">Edit</button>
        </div>
        <div class="flex flex-wrap gap-1.5">
          <span v-for="skill in skills" :key="skill" class="px-2.5 py-1.5 bg-slate-50 text-muted text-[11px] font-medium rounded-lg border border-borderSoft hover:border-terracotta/30 hover:text-terracotta transition-colors cursor-default">{{ skill }}</span>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import { useRouter } from 'vue-router';

const router = useRouter();
const user = ref(JSON.parse(localStorage.getItem('user') || '{}'));
const stats = ref({ completedProjects: 0, activeRooms: 0, totalUMKMPartners: 0, portfolioViews: 0 });

const statCards = computed(() => [
  { title: 'Proyek Selesai', value: stats.value.completedProjects, emoji: '🎯', bgClass: 'bg-sand', trend: 'Selesai', trendClass: 'bg-emerald-50 text-emerald-600' },
  { title: 'Room Aktif', value: stats.value.activeRooms, emoji: '🔗', bgClass: 'bg-emerald-50', trend: 'Live', trendClass: 'bg-emerald-50 text-emerald-600' },
  { title: 'Mitra UMKM', value: stats.value.totalUMKMPartners, emoji: '🤝', bgClass: 'bg-blue-50', trend: 'Mitra', trendClass: 'bg-blue-50 text-blue-600' },
  { title: 'Views Portofolio', value: stats.value.portfolioViews, emoji: '👁️', bgClass: 'bg-amber-50', trend: 'Total', trendClass: 'bg-amber-50 text-amber-600' },
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
      invitations.value = data.invitations || invitations.value;
      activeRooms.value = data.activeRooms || activeRooms.value;
      skills.value = data.skills || skills.value;
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
