<template>
  <div class="space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-700 w-full">
    <!-- Header + Filter -->
    <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
      <div>
        <h2 class="text-2xl font-bold text-slate-800 tracking-tight">Co-Create Room</h2>
        <p class="text-sm text-slate-500 font-medium mt-1">Terima undangan dan kolaborasi bersama UMKM Malang</p>
      </div>
      <div class="flex items-center gap-3">
        <div class="flex bg-white rounded-2xl border border-slate-200 overflow-hidden">
          <button v-for="tab in tabs" :key="tab.key" @click="activeTab = tab.key"
            class="px-5 py-3 text-[10px] font-bold uppercase tracking-wider transition-all"
            :class="activeTab === tab.key ? 'bg-orange-500 text-white shadow-sm' : 'text-slate-500 hover:bg-slate-50'">
            {{ tab.label }}
            <span v-if="tab.count" class="ml-1.5 bg-white/20 text-[9px] px-1.5 py-0.5 rounded-md" :class="activeTab === tab.key ? '' : 'bg-orange-100 text-orange-600'">{{ tab.count }}</span>
          </button>
        </div>
      </div>
    </div>

    <!-- Pending Invitations Section -->
    <div v-if="activeTab === 'pending'" class="space-y-5">
      <div v-for="inv in pendingInvitations" :key="inv.id"
        class="bg-white rounded-2xl border border-slate-200/60 p-6 md:p-8 hover:shadow-md transition-all duration-300 group">
        <div class="flex flex-col lg:flex-row items-start lg:items-center gap-6">
          <!-- UMKM Info -->
          <div class="flex items-center gap-4 flex-1 min-w-0">
            <div class="w-14 h-14 rounded-2xl flex-shrink-0 flex items-center justify-center font-bold text-xl text-white shadow-md" :class="inv.avatarClass">
              {{ inv.umkmName.charAt(0) }}
            </div>
            <div class="min-w-0">
              <div class="flex items-center gap-2 mb-1">
                <h3 class="text-lg font-bold text-slate-800 truncate">{{ inv.umkmName }}</h3>
                <span class="flex-shrink-0 px-2.5 py-1 text-[9px] font-bold uppercase tracking-wider rounded-lg bg-orange-100 text-orange-600">{{ inv.category }}</span>
              </div>
              <p class="text-sm text-slate-500 font-medium truncate">{{ inv.projectName }}</p>
              <div class="flex items-center gap-4 mt-2 text-[11px] text-slate-400 font-medium">
                <span class="flex items-center gap-1">
                  <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                  {{ inv.timeAgo }}
                </span>
                <span class="flex items-center gap-1">
                  <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                  Deadline: {{ inv.deadline }}
                </span>
              </div>
            </div>
          </div>

          <!-- Description -->
          <div class="flex-1 min-w-0 hidden xl:block">
            <p class="text-xs text-slate-500 leading-relaxed line-clamp-3">{{ inv.description }}</p>
          </div>

          <!-- Budget & Actions -->
          <div class="flex items-center gap-4 flex-shrink-0">
            <div class="text-right hidden sm:block">
              <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Budget</p>
              <p class="text-lg font-bold text-slate-800">Rp {{ inv.budget.toLocaleString('id-ID') }}</p>
            </div>
            <div class="flex items-center gap-2">
              <button @click="acceptInvitation(inv.id)" class="px-6 py-3 bg-orange-500 hover:bg-orange-600 text-white text-[10px] font-bold uppercase tracking-wider rounded-2xl transition-all shadow-sm shadow-orange-500/20 hover:shadow-md active:scale-95">
                ✓ Terima
              </button>
              <button @click="declineInvitation(inv.id)" class="px-6 py-3 bg-slate-100 hover:bg-red-50 text-slate-500 hover:text-red-500 text-[10px] font-bold uppercase tracking-wider rounded-2xl transition-all">
                ✕ Tolak
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- Empty State -->
      <div v-if="pendingInvitations.length === 0" class="bg-white rounded-2xl border border-slate-200 p-16 text-center">
        <div class="text-6xl mb-4">📭</div>
        <h3 class="text-lg font-bold text-slate-800 mb-2">Belum Ada Undangan Baru</h3>
        <p class="text-sm text-slate-500 font-medium">Undangan dari UMKM akan muncul di sini.</p>
      </div>
    </div>

    <!-- Active Rooms Section -->
    <div v-if="activeTab === 'active'" class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <div v-for="room in activeRooms" :key="room.id"
        class="bg-white rounded-2xl border border-slate-200/60 p-6 hover:shadow-md transition-all duration-300 group cursor-pointer relative overflow-hidden">
        <div class="absolute top-0 right-0 w-32 h-32 bg-orange-50 rounded-full blur-3xl opacity-50 pointer-events-none"></div>
        <div class="relative z-10">
          <div class="flex items-center justify-between mb-4">
            <span class="px-3 py-1.5 bg-emerald-50 text-emerald-600 text-[10px] font-bold uppercase tracking-wider rounded-xl flex items-center gap-1.5">
              <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full animate-pulse"></span> Live
            </span>
            <span class="text-[10px] font-medium text-slate-400">{{ room.timeAgo }}</span>
          </div>
          <h3 class="text-lg font-bold text-slate-800 mb-2 group-hover:text-orange-600 transition-colors">{{ room.name }}</h3>
          <p class="text-xs text-slate-500 font-medium mb-4 leading-relaxed">{{ room.description }}</p>
          <div class="flex items-center justify-between">
            <div class="flex -space-x-2">
              <div v-for="(m, mIdx) in room.members.slice(0, 5)" :key="mIdx" class="w-8 h-8 rounded-full border-2 border-white flex items-center justify-center text-[9px] font-bold text-white shadow-sm" :class="m.color">{{ m.name.charAt(0) }}</div>
              <div v-if="room.members.length > 5" class="w-8 h-8 rounded-full border-2 border-white bg-slate-200 flex items-center justify-center text-[10px] font-bold text-slate-500">+{{ room.members.length - 5 }}</div>
            </div>
            <button class="px-4 py-2.5 bg-orange-50 hover:bg-orange-100 text-orange-600 text-[10px] font-bold uppercase tracking-wider rounded-xl transition-colors border border-orange-100">
              Masuk Room →
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Completed Section -->
    <div v-if="activeTab === 'completed'" class="space-y-4">
      <div v-for="room in completedRooms" :key="room.id" class="bg-white rounded-2xl border border-slate-200/60 p-6 hover:shadow-md transition-all duration-300">
        <div class="flex items-center gap-4">
          <div class="w-12 h-12 rounded-xl flex-shrink-0 flex items-center justify-center text-xl bg-slate-100">✅</div>
          <div class="flex-1 min-w-0">
            <h4 class="text-sm font-bold text-slate-800 truncate">{{ room.name }}</h4>
            <p class="text-xs text-slate-500 font-medium">{{ room.umkmName }} · Selesai {{ room.completedDate }}</p>
          </div>
          <div class="flex items-center gap-3">
            <div class="text-right hidden sm:block">
              <div class="flex items-center gap-1 text-amber-500 text-sm">
                <span v-for="i in 5" :key="i">{{ i <= room.rating ? '★' : '☆' }}</span>
              </div>
              <p class="text-[10px] text-slate-400 font-medium mt-0.5">{{ room.rating }}/5 rating</p>
            </div>
            <button class="px-4 py-2 bg-slate-50 hover:bg-orange-50 text-slate-500 hover:text-orange-600 text-[10px] font-bold uppercase tracking-wider rounded-xl transition-colors border border-slate-100">Detail</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';

const activeTab = ref('pending');
const tabs = computed(() => [
  { key: 'pending', label: 'Undangan', count: pendingInvitations.value.length },
  { key: 'active', label: 'Aktif', count: activeRooms.value.length },
  { key: 'completed', label: 'Selesai', count: completedRooms.value.length },
]);

const pendingInvitations = ref([
  { id: 1, umkmName: 'Batik Sari Malang', projectName: 'Redesign Label & Packaging Batik Tulis Premium', category: 'Packaging', timeAgo: '2 jam lalu', deadline: '15 Jun 2026', budget: 2500000, description: 'Kami membutuhkan desainer kreatif untuk memperbarui label kemasan batik tulis premium. Harus mencerminkan warisan budaya Malang dengan sentuhan modern.', avatarClass: 'bg-gradient-to-br from-orange-400 to-red-400' },
  { id: 2, umkmName: 'Rotan Craft Arjosari', projectName: 'Branding Identity & Product Catalog', category: 'Branding', timeAgo: '5 jam lalu', deadline: '20 Jun 2026', budget: 3000000, description: 'Membangun brand identity lengkap meliputi logo, color palette, typography, dan product catalog digital.', avatarClass: 'bg-gradient-to-br from-emerald-400 to-teal-500' },
  { id: 3, umkmName: 'Keramik Dinoyo Craft', projectName: 'Social Media Content Design', category: 'Social Media', timeAgo: '1 hari lalu', deadline: '10 Jul 2026', budget: 1500000, description: 'Desain konten visual untuk Instagram dan TikTok. Template story, feed post, dan carousel yang konsisten.', avatarClass: 'bg-gradient-to-br from-blue-400 to-indigo-500' },
]);

const activeRooms = ref([
  { id: 1, name: 'Packaging Batik Tulis Premium', description: 'Kolaborasi desain packaging premium untuk Batik Sari Malang. Sedang dalam tahap mockup 3D.', timeAgo: '5 min lalu', members: [{ name: 'Sari', color: 'bg-orange-400' }, { name: 'Reza', color: 'bg-orange-500' }, { name: 'Andi', color: 'bg-blue-400' }] },
  { id: 2, name: 'Branding Rotan Craft', description: 'Brand identity dan panduan visual untuk Rotan Craft Arjosari.', timeAgo: '1 jam lalu', members: [{ name: 'Budi', color: 'bg-emerald-500' }, { name: 'Reza', color: 'bg-orange-500' }] },
  { id: 3, name: 'Visual Kit Kopi Arjuno', description: 'Konten sosial media Instagram & TikTok untuk brand kopi lokal.', timeAgo: '3 jam lalu', members: [{ name: 'Dewi', color: 'bg-amber-500' }, { name: 'Reza', color: 'bg-orange-500' }, { name: 'Fajar', color: 'bg-pink-400' }, { name: 'Gita', color: 'bg-teal-400' }, { name: 'Heru', color: 'bg-indigo-400' }, { name: 'Indah', color: 'bg-red-400' }] },
  { id: 4, name: 'Product Photography Keramik', description: 'Style guide foto produk untuk marketplace online.', timeAgo: '6 jam lalu', members: [{ name: 'Lina', color: 'bg-cyan-500' }, { name: 'Reza', color: 'bg-orange-500' }, { name: 'Maya', color: 'bg-rose-400' }] },
]);

const completedRooms = ref([
  { id: 1, name: 'Logo Redesign Tempe Malang', umkmName: 'Tempe Sanan Craft', completedDate: '28 Apr 2026', rating: 5 },
  { id: 2, name: 'Packaging Kripik Tempe', umkmName: 'Tempe Sanan Craft', completedDate: '20 Apr 2026', rating: 4 },
  { id: 3, name: 'Instagram Feed Template', umkmName: 'Kopi Gunung Arjuno', completedDate: '15 Apr 2026', rating: 5 },
  { id: 4, name: 'Banner Marketplace', umkmName: 'Batik Cap Malangan', completedDate: '8 Apr 2026', rating: 4 },
  { id: 5, name: 'Product Catalog Digital', umkmName: 'Anyaman Bamboo Batu', completedDate: '1 Apr 2026', rating: 5 },
]);

const acceptInvitation = (id) => { pendingInvitations.value = pendingInvitations.value.filter(i => i.id !== id); };
const declineInvitation = (id) => { pendingInvitations.value = pendingInvitations.value.filter(i => i.id !== id); };
</script>
