<template>
  <div class="space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-700 w-full">
    <!-- Header + Filter -->
    <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
      <div>
        <h2 class="text-2xl font-bold text-espresso tracking-tight">Co-Create Room</h2>
        <p class="text-sm text-muted font-medium mt-1">Terima undangan dan kolaborasi bersama UMKM Partner</p>
      </div>
      <div class="flex items-center gap-3">
        <div class="flex bg-surface rounded-2xl border border-borderSoft overflow-hidden">
          <button v-for="tab in tabs" :key="tab.key" @click="activeTab = tab.key"
            class="px-5 py-3 text-[10px] font-bold uppercase tracking-wider transition-all"
            :class="activeTab === tab.key ? 'bg-terracotta text-white shadow-sm' : 'text-muted hover:bg-slate-50'">
            {{ tab.label }}
            <span v-if="tab.count" class="ml-1.5 bg-surface/20 text-[9px] px-1.5 py-0.5 rounded-md" :class="activeTab === tab.key ? '' : 'bg-sand text-terracotta'">{{ tab.count }}</span>
          </button>
        </div>
      </div>
    </div>

    <!-- Pending & Sent Invitations Section -->
    <div v-if="activeTab === 'pending'" class="space-y-6">
      
      <!-- Undangan Masuk (Incoming) -->
      <div v-if="pendingInvitations.length > 0" class="space-y-4">
        <h3 class="text-[11px] font-black uppercase tracking-[0.2em] text-[#8A7A6C] mb-2 ml-1">Undangan Masuk</h3>
        <div v-for="inv in pendingInvitations" :key="inv.id"
          class="bg-surface rounded-2xl border border-borderSoft/60 p-6 md:p-8 hover:shadow-md transition-all duration-300 group">
          <div class="flex flex-col lg:flex-row items-start lg:items-center gap-6">
            <!-- Creator Info -->
            <div class="flex items-center gap-4 flex-1 min-w-0">
              <div class="w-14 h-14 rounded-2xl flex-shrink-0 flex items-center justify-center font-bold text-xl text-white shadow-md bg-gradient-to-br from-terracotta to-orange-500">
                {{ (inv.creator?.name || 'U').charAt(0).toUpperCase() }}
              </div>
              <div class="min-w-0">
                <div class="flex items-center gap-2 mb-1">
                  <h3 class="text-lg font-bold text-espresso truncate">{{ inv.creator?.name || 'Kolaborator' }}</h3>
                  <span class="flex-shrink-0 px-2.5 py-1 text-[9px] font-bold uppercase tracking-wider rounded-lg bg-sand text-terracotta">Undangan</span>
                </div>
                <p class="text-sm text-espresso font-black truncate">{{ inv.name }}</p>
                <div class="flex items-center gap-4 mt-2 text-[11px] text-slate-400 font-medium">
                  <span class="flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    Dibuat pada: {{ inv.created_at }}
                  </span>
                </div>
              </div>
            </div>

            <!-- Description -->
            <div class="flex-1 min-w-0">
              <p class="text-xs text-muted leading-relaxed line-clamp-3">{{ inv.description || 'Tidak ada deskripsi.' }}</p>
            </div>

            <!-- Actions -->
            <div class="flex items-center gap-2 flex-shrink-0">
              <button @click="acceptInvitation(inv.id)" class="px-6 py-3 bg-terracotta hover:bg-orange-850 text-white text-[10px] font-bold uppercase tracking-wider rounded-2xl transition-all shadow-sm active:scale-95 cursor-pointer">
                ✓ Terima
              </button>
              <button @click="declineInvitation(inv.id)" class="px-6 py-3 bg-slate-100 hover:bg-red-50 text-muted hover:text-red-500 text-[10px] font-bold uppercase tracking-wider rounded-2xl transition-all cursor-pointer">
                ✕ Tolak
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- Undangan Dikirim (Outgoing) -->
      <div v-if="sentInvitations.length > 0" class="space-y-4">
        <h3 class="text-[11px] font-black uppercase tracking-[0.2em] text-[#8A7A6C] mb-2 ml-1">Permintaan Dikirim</h3>
        <div v-for="inv in sentInvitations" :key="inv.id"
          class="bg-surface rounded-2xl border border-borderSoft/60 p-6 md:p-8 opacity-90 transition-all duration-300">
          <div class="flex flex-col lg:flex-row items-start lg:items-center gap-6">
            <!-- Invited User Info -->
            <div class="flex items-center gap-4 flex-1 min-w-0">
              <div class="w-14 h-14 rounded-2xl flex-shrink-0 flex items-center justify-center font-bold text-xl text-[#6F6259] bg-[#F8F1E7] border border-borderSoft">
                {{ (inv.invited_user?.name || 'U').charAt(0).toUpperCase() }}
              </div>
              <div class="min-w-0">
                <div class="flex items-center gap-2 mb-1">
                  <h3 class="text-lg font-bold text-espresso truncate">{{ inv.invited_user?.name || 'UMKM Partner' }}</h3>
                  <span class="flex-shrink-0 px-2.5 py-1 text-[9px] font-bold uppercase tracking-wider rounded-lg bg-[#F8F1E7] text-[#6F6259]">Terkirim</span>
                </div>
                <p class="text-sm text-espresso font-black truncate">{{ inv.name }}</p>
                <div class="flex items-center gap-4 mt-2 text-[11px] text-slate-400 font-medium">
                  <span class="flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    Dikirim pada: {{ inv.created_at }}
                  </span>
                </div>
              </div>
            </div>

            <!-- Description -->
            <div class="flex-1 min-w-0">
              <p class="text-xs text-muted leading-relaxed line-clamp-3">{{ inv.description || 'Tidak ada deskripsi.' }}</p>
            </div>

            <!-- Status / Cancel -->
            <div class="flex items-center gap-4 flex-shrink-0">
              <span class="text-xs font-bold text-orange-600 animate-pulse bg-orange-50 px-3 py-1.5 rounded-xl border border-orange-100 flex items-center gap-1.5">
                <span class="w-1.5 h-1.5 bg-orange-500 rounded-full"></span> Menunggu Persetujuan...
              </span>
              <button @click="declineInvitation(inv.id)" class="px-5 py-3 bg-red-50 hover:bg-red-100 text-red-600 text-[10px] font-bold uppercase tracking-wider rounded-2xl transition-all cursor-pointer">
                Batalkan
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- Empty State -->
      <div v-if="pendingInvitations.length === 0 && sentInvitations.length === 0" class="bg-surface rounded-2xl border border-borderSoft p-16 text-center">
        <div class="text-6xl mb-4">📭</div>
        <h3 class="text-lg font-bold text-espresso mb-2">Belum Ada Undangan</h3>
        <p class="text-sm text-muted font-medium">Undangan masuk dan permintaan kolaborasi yang dikirim akan muncul di sini.</p>
      </div>
    </div>

    <!-- Active Rooms Section -->
    <div v-if="activeTab === 'active'">
      <div v-if="loadingRooms" class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div v-for="i in 2" :key="i" class="bg-surface rounded-2xl border border-borderSoft/60 p-6 animate-pulse h-44"></div>
      </div>
      <div v-else-if="activeRooms.length === 0" class="bg-surface rounded-2xl border border-borderSoft p-16 text-center">
        <div class="text-6xl mb-4">🚪</div>
        <h3 class="text-lg font-bold text-espresso mb-2">Belum Ada Ruang Aktif</h3>
        <p class="text-sm text-muted font-medium">Anda belum bergabung di ruangan kolaborasi manapun.</p>
      </div>
      <div v-else class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div v-for="room in activeRooms" :key="room.id" @click="joinRoom(room.id)"
          class="bg-surface rounded-2xl border border-borderSoft/60 p-6 hover:shadow-md transition-all duration-300 group cursor-pointer relative overflow-hidden">
          <div class="absolute top-0 right-0 w-32 h-32 bg-sand rounded-full blur-3xl opacity-50 pointer-events-none"></div>
          <div class="relative z-10">
            <div class="flex items-center justify-between mb-4">
              <span class="px-3 py-1.5 bg-emerald-50 text-emerald-600 text-[10px] font-bold uppercase tracking-wider rounded-xl flex items-center gap-1.5">
                <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full animate-pulse"></span> Live
              </span>
              <span class="text-[10px] font-medium text-slate-400">Aktif</span>
            </div>
            <h3 class="text-lg font-bold text-espresso mb-2 group-hover:text-terracotta transition-colors">{{ room.name }}</h3>
            <p class="text-xs text-muted font-medium mb-4 leading-relaxed line-clamp-2">{{ room.description || 'Tidak ada deskripsi.' }}</p>
            <div class="flex items-center justify-between">
              <div class="flex -space-x-2">
                <div class="w-8 h-8 rounded-full border-2 border-white bg-[#E8DCCB] flex items-center justify-center text-xs font-bold text-[#6F6259]">
                  {{ (room.creator?.name || 'U').charAt(0).toUpperCase() }}
                </div>
              </div>
              <button @click.stop="joinRoom(room.id)" class="px-4 py-2.5 bg-sand hover:bg-sand text-terracotta text-[10px] font-bold uppercase tracking-wider rounded-xl transition-colors border border-terracotta/20">
                Masuk Room →
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Completed Section -->
    <div v-if="activeTab === 'completed'" class="space-y-4">
      <div v-if="loadingRooms" class="space-y-4">
        <div v-for="i in 2" :key="i" class="bg-surface rounded-2xl border border-borderSoft/60 p-6 animate-pulse h-16"></div>
      </div>
      <div v-else-if="completedRooms.length === 0" class="bg-surface rounded-2xl border border-borderSoft p-16 text-center">
        <div class="text-6xl mb-4">✅</div>
        <h3 class="text-lg font-bold text-espresso mb-2">Belum Ada Kolaborasi Selesai</h3>
        <p class="text-sm text-muted font-medium">Kolaborasi yang selesai akan tersimpan di sini.</p>
      </div>
      <div v-else v-for="room in completedRooms" :key="room.id" class="bg-surface rounded-2xl border border-borderSoft/60 p-6 hover:shadow-md transition-all duration-300">
        <div class="flex items-center gap-4">
          <div class="w-12 h-12 rounded-xl flex-shrink-0 flex items-center justify-center text-xl bg-slate-100">✅</div>
          <div class="flex-1 min-w-0">
            <h4 class="text-sm font-bold text-espresso truncate">{{ room.name }}</h4>
            <p class="text-xs text-muted font-medium">Kolaborator: {{ room.creator?.name || 'Partner' }} · Selesai pada {{ room.created_at }}</p>
          </div>
          <div class="flex items-center gap-3">
            <button @click="joinRoom(room.id)" class="px-4 py-2 bg-slate-50 hover:bg-sand text-muted hover:text-terracotta text-[10px] font-bold uppercase tracking-wider rounded-xl transition-colors border border-borderSoft">Detail</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import { useRouter } from 'vue-router';

const router = useRouter();
const activeTab = ref('pending');
const tabs = computed(() => [
  { key: 'pending', label: 'Undangan', count: pendingInvitations.value.length },
  { key: 'active', label: 'Aktif', count: activeRooms.value.length },
  { key: 'completed', label: 'Selesai', count: completedRooms.value.length },
]);

const pendingInvitations = ref([]);
const sentInvitations = ref([]);
const activeRooms = ref([]);
const completedRooms = ref([]);
const loadingRooms = ref(true);

const fetchInvitations = async () => {
  try {
    const token = localStorage.getItem('token');
    const res = await fetch('/api/v1/cocreate/rooms/invitations', {
      headers: { 'Authorization': `Bearer ${token}` }
    });
    if (res.ok) {
      const data = await res.json();
      pendingInvitations.value = data.incoming;
      sentInvitations.value = data.outgoing;
    }
  } catch (e) {
    console.error('Failed to fetch invitations:', e);
  }
};

const fetchRooms = async () => {
  loadingRooms.value = true;
  try {
    const token = localStorage.getItem('token');
    
    // Fetch active
    const activeRes = await fetch('/api/v1/cocreate/rooms?status=active', {
      headers: { 'Authorization': `Bearer ${token}` }
    });
    if (activeRes.ok) {
      const activeData = await activeRes.json();
      activeRooms.value = activeData.data;
    }

    // Fetch completed
    const completedRes = await fetch('/api/v1/cocreate/rooms?status=completed', {
      headers: { 'Authorization': `Bearer ${token}` }
    });
    if (completedRes.ok) {
      const completedData = await completedRes.json();
      completedRooms.value = completedData.data;
    }
  } catch (e) {
    console.error('Failed to fetch rooms:', e);
  } finally {
    loadingRooms.value = false;
  }
};

const acceptInvitation = async (roomId) => {
  try {
    const token = localStorage.getItem('token');
    const res = await fetch(`/api/v1/cocreate/rooms/${roomId}/accept`, {
      method: 'POST',
      headers: {
        'Accept': 'application/json',
        'Authorization': `Bearer ${token}`
      }
    });
    if (res.ok) {
      await fetchInvitations();
      await fetchRooms();
      activeTab.value = 'active';
    } else {
      const data = await res.json();
      alert(data.message || 'Gagal menyetujui undangan.');
    }
  } catch (e) {
    console.error('Accept invitation error:', e);
  }
};

const declineInvitation = async (roomId) => {
  try {
    const token = localStorage.getItem('token');
    const res = await fetch(`/api/v1/cocreate/rooms/${roomId}/decline`, {
      method: 'POST',
      headers: {
        'Accept': 'application/json',
        'Authorization': `Bearer ${token}`
      }
    });
    if (res.ok) {
      await fetchInvitations();
      await fetchRooms();
    } else {
      const data = await res.json();
      alert(data.message || 'Gagal menolak/membatalkan undangan.');
    }
  } catch (e) {
    console.error('Decline invitation error:', e);
  }
};

const joinRoom = async (roomId) => {
  try {
    const token = localStorage.getItem('token');
    await fetch(`/api/v1/cocreate/rooms/${roomId}/join`, {
      method: 'POST',
      headers: { 'Authorization': `Bearer ${token}` }
    });
    router.push(`/designer/cocreate/${roomId}`);
  } catch (error) {
    console.error('Failed to join room:', error);
  }
};

onMounted(() => {
  fetchInvitations();
  fetchRooms();
});
</script>
