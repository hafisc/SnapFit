<template>
  <div class="space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-700">
    <!-- Top Stats Row -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
      <!-- Total UMKM -->
      <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.02)] hover:shadow-[0_8px_30px_rgb(0,0,0,0.06)] transition-all group relative overflow-hidden">
        <div class="absolute -right-4 -top-4 w-24 h-24 bg-indigo-50 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-700"></div>
        <div class="relative z-10">
          <div class="flex justify-between items-start mb-6">
            <div class="w-12 h-12 bg-indigo-100 text-indigo-600 rounded-2xl flex items-center justify-center shadow-inner">
              <span class="font-black text-xl">🏪</span>
            </div>
            <span class="px-3 py-1 bg-indigo-50 text-indigo-600 rounded-full text-[10px] font-black tracking-widest">REALTIME</span>
          </div>
          <h3 class="text-slate-400 text-xs font-bold uppercase tracking-widest mb-1">Total UMKM</h3>
          <p class="text-3xl font-black text-slate-800 tracking-tighter">
            <span v-if="isLoading" class="animate-pulse bg-slate-200 h-8 w-16 block rounded"></span>
            <span v-else>{{ statsData.users?.umkm || 0 }}</span>
          </p>
        </div>
      </div>

      <!-- Total Desainer -->
      <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.02)] hover:shadow-[0_8px_30px_rgb(0,0,0,0.06)] transition-all group relative overflow-hidden">
        <div class="absolute -right-4 -top-4 w-24 h-24 bg-purple-50 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-700"></div>
        <div class="relative z-10">
          <div class="flex justify-between items-start mb-6">
            <div class="w-12 h-12 bg-purple-100 text-purple-600 rounded-2xl flex items-center justify-center shadow-inner">
              <span class="font-black text-xl">🎨</span>
            </div>
            <span class="px-3 py-1 bg-purple-50 text-purple-600 rounded-full text-[10px] font-black tracking-widest">REALTIME</span>
          </div>
          <h3 class="text-slate-400 text-xs font-bold uppercase tracking-widest mb-1">Total Desainer</h3>
          <p class="text-3xl font-black text-slate-800 tracking-tighter">
            <span v-if="isLoading" class="animate-pulse bg-slate-200 h-8 w-16 block rounded"></span>
            <span v-else>{{ statsData.users?.desainer || 0 }}</span>
          </p>
        </div>
      </div>

      <!-- AI Renderings -->
      <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.02)] hover:shadow-[0_8px_30px_rgb(0,0,0,0.06)] transition-all group relative overflow-hidden">
        <div class="absolute -right-4 -top-4 w-24 h-24 bg-orange-50 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-700"></div>
        <div class="relative z-10">
          <div class="flex justify-between items-start mb-6">
            <div class="w-12 h-12 bg-orange-100 text-orange-600 rounded-2xl flex items-center justify-center shadow-inner">
              <span class="font-black text-xl">🤖</span>
            </div>
            <span class="px-3 py-1 bg-orange-50 text-orange-600 rounded-full text-[10px] font-black tracking-widest">REALTIME</span>
          </div>
          <h3 class="text-slate-400 text-xs font-bold uppercase tracking-widest mb-1">AI Renderings</h3>
          <p class="text-3xl font-black text-slate-800 tracking-tighter">
            <span v-if="isLoading" class="animate-pulse bg-slate-200 h-8 w-16 block rounded"></span>
            <span v-else>{{ statsData.ai_generations?.total || 0 }}</span>
          </p>
        </div>
      </div>

      <!-- Total Revenue -->
      <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.02)] hover:shadow-[0_8px_30px_rgb(0,0,0,0.06)] transition-all group relative overflow-hidden">
        <div class="absolute -right-4 -top-4 w-24 h-24 bg-emerald-50 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-700"></div>
        <div class="relative z-10">
          <div class="flex justify-between items-start mb-6">
            <div class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-2xl flex items-center justify-center shadow-inner">
              <span class="font-black text-xl">💰</span>
            </div>
            <span class="px-3 py-1 bg-emerald-50 text-emerald-600 rounded-full text-[10px] font-black tracking-widest">REALTIME</span>
          </div>
          <h3 class="text-slate-400 text-xs font-bold uppercase tracking-widest mb-1">Total Revenue</h3>
          <p class="text-3xl font-black text-slate-800 tracking-tighter">
            <span v-if="isLoading" class="animate-pulse bg-slate-200 h-8 w-24 block rounded"></span>
            <span v-else>Rp {{ Number(statsData.orders?.revenue || 0).toLocaleString('id-ID') }}</span>
          </p>
        </div>
      </div>
    </div>

    <!-- Charts & Activity Row -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
      <!-- Main Chart (Placeholder) -->
      <div class="lg:col-span-2 bg-white p-8 rounded-[2rem] border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.02)]">
        <div class="flex justify-between items-center mb-8">
          <div>
            <h3 class="text-lg font-black text-slate-800 tracking-tight">Revenue Overview</h3>
            <p class="text-xs text-slate-400 font-medium">Platform fees (5%) from marketplace transactions</p>
          </div>
          <select class="bg-slate-50 border-none text-xs font-bold text-slate-600 rounded-xl px-4 py-2 outline-none focus:ring-2 focus:ring-indigo-100">
            <option>This Month</option>
            <option>Last Month</option>
            <option>This Year</option>
          </select>
        </div>

        <div class="h-64 flex items-end justify-between gap-2 relative">
          <!-- Fake Grid Lines -->
          <div class="absolute inset-0 flex flex-col justify-between pointer-events-none">
            <div class="border-b border-slate-50 border-dashed w-full h-0"></div>
            <div class="border-b border-slate-50 border-dashed w-full h-0"></div>
            <div class="border-b border-slate-50 border-dashed w-full h-0"></div>
            <div class="border-b border-slate-50 border-dashed w-full h-0"></div>
            <div class="border-b border-slate-100 w-full h-0"></div>
          </div>

          <!-- Fake Bars -->
          <div v-for="bar in [40, 70, 45, 90, 60, 100, 80]" :key="bar" class="w-full relative group">
            <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 bg-slate-800 text-white text-[10px] font-bold px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity">
              Rp {{ bar }}M
            </div>
            <div class="bg-indigo-100 rounded-t-xl w-full mx-1 transition-all duration-1000 group-hover:bg-indigo-500" :style="`height: ${bar}%`"></div>
          </div>
        </div>
        <div class="flex justify-between mt-4 text-[10px] font-bold text-slate-400 uppercase">
          <span>Mon</span><span>Tue</span><span>Wed</span><span>Thu</span><span>Fri</span><span>Sat</span><span>Sun</span>
        </div>
      </div>

      <!-- Recent Activity -->
      <div class="bg-white p-8 rounded-[2rem] border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.02)]">
        <h3 class="text-lg font-black text-slate-800 tracking-tight mb-8">System Activity</h3>

        <div class="space-y-6">
          <div v-for="activity in activities" :key="activity.id" class="flex gap-4 relative">
            <div class="w-10 h-10 rounded-full flex-shrink-0 flex items-center justify-center text-white" :class="activity.colorClass">
              {{ activity.icon }}
            </div>
            <div>
              <p class="text-sm font-bold text-slate-700">{{ activity.title }}</p>
              <p class="text-xs text-slate-400">{{ activity.desc }}</p>
              <span class="text-[9px] font-black text-slate-300 tracking-widest uppercase mt-1 block">{{ activity.time }}</span>
            </div>
          </div>
        </div>

        <button class="w-full mt-8 py-3 bg-slate-50 hover:bg-slate-100 text-slate-600 font-bold text-xs rounded-xl transition-colors">
          View All Logs
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';

const isLoading = ref(true);
const statsData = ref({
  users: { umkm: 0, desainer: 0 },
  ai_generations: { total: 0 },
  orders: { revenue: 0 },
});

const fetchStats = async () => {
  try {
    const token = localStorage.getItem('token');
    if (!token) return;

    const res = await fetch('/api/v1/admin/stats', {
      headers: {
        'Accept': 'application/json',
        'Authorization': `Bearer ${token}`
      }
    });

    if (res.ok) {
      const data = await res.json();
      statsData.value = data;
    }
  } catch (error) {
    console.error('Failed to fetch stats:', error);
  } finally {
    isLoading.value = false;
  }
};

onMounted(() => {
  fetchStats();
});

const activities = [
  { id: 1, title: 'New UMKM Registered', desc: 'Batik Tulis Budi registered an account.', time: '2 mins ago', icon: 'U', colorClass: 'bg-indigo-500 shadow-indigo-500/30 shadow-lg' },
  { id: 2, title: 'AI Studio Limit Reached', desc: 'User #402 hit daily rate limit.', time: '15 mins ago', icon: '!', colorClass: 'bg-orange-500 shadow-orange-500/30 shadow-lg' },
  { id: 3, title: 'Withdrawal Processed', desc: 'Rp 5.000.000 sent to Designer #12.', time: '1 hour ago', icon: '$', colorClass: 'bg-emerald-500 shadow-emerald-500/30 shadow-lg' },
  { id: 4, title: 'Co-Create Room Active', desc: 'Room #892 has 5 active participants.', time: '2 hours ago', icon: '👥', colorClass: 'bg-blue-500 shadow-blue-500/30 shadow-lg' },
];
</script>

<style scoped>
.animate-in { animation-duration: 0.7s; animation-fill-mode: both; }
@keyframes slideInUp { from { transform: translateY(20px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
.slide-in-from-bottom-4 { animation-name: slideInUp; }
@keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
.fade-in { animation-name: fadeIn; }
</style>
