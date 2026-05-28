<template>
  <div class="space-y-6 w-full">
    <!-- Header + Filter -->
    <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
      <div>
        <h2 class="text-2xl font-bold text-[#2B1E16] tracking-tight">Ruang Co-Create</h2>
        <p class="text-sm text-[#8A7A6C] font-medium mt-1">Terima undangan dan kolaborasi bersama mitra UMKM</p>
      </div>
      <div class="flex items-center gap-3">
        <div class="flex bg-white rounded-2xl border border-[#E8DCCB]/60 overflow-hidden p-1 shadow-sm">
          <button v-for="tab in tabs" :key="tab.key" @click="activeTab = tab.key"
            class="px-5 py-2.5 text-[11px] font-bold uppercase tracking-wider rounded-xl transition-all flex items-center"
            :class="activeTab === tab.key ? 'bg-[#B85C38] text-white shadow-sm' : 'text-[#8A7A6C] hover:bg-slate-50 hover:text-[#2B1E16]'">
            {{ tab.label }}
            <span v-if="tab.count" class="ml-1.5 text-[9px] px-1.5 py-0.5 rounded-md font-extrabold" :class="activeTab === tab.key ? 'bg-white/20 text-white' : 'bg-[#B85C38]/10 text-[#B85C38]'">
              {{ tab.count }}
            </span>
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
          class="bg-white rounded-2xl border border-[#E8DCCB]/60 p-5 hover:shadow-md hover:border-[#E8DCCB] transition-all duration-300 group">
          <div class="flex flex-col lg:flex-row items-start lg:items-center gap-5 justify-between">
            <!-- Creator Info -->
            <div class="flex items-start gap-4 flex-1 min-w-0">
              <div class="w-12 h-12 rounded-xl bg-[#F8F1E7] border border-[#E8DCCB] flex items-center justify-center font-bold text-sm text-[#B85C38] flex-shrink-0 shadow-sm">
                {{ (inv.creator?.name || 'U').charAt(0).toUpperCase() }}
              </div>
              <div class="min-w-0">
                <div class="flex items-center gap-2 flex-wrap mb-1">
                  <h4 class="text-[14px] font-bold text-[#2B1E16] truncate">{{ inv.creator?.name || 'UMKM Partner' }}</h4>
                  <span class="px-2 py-0.5 text-[9px] font-bold uppercase tracking-wider rounded-full bg-[#B85C38]/10 text-[#B85C38] border border-[#B85C38]/20">Undangan</span>
                </div>
                <p class="text-xs text-[#8A7A6C] font-semibold truncate">{{ inv.name }}</p>
                <div class="flex items-center gap-1.5 mt-2 text-[10px] text-[#8A7A6C]/85 font-medium">
                  <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                  Dibuat pada: {{ inv.created_at }}
                </div>
              </div>
            </div>

            <!-- Description -->
            <div class="flex-1 min-w-0 bg-[#FAF6F0] p-3.5 rounded-xl border border-[#E8DCCB]/40 lg:my-0 my-2">
              <p class="text-xs text-[#6F6259] leading-relaxed line-clamp-3">{{ inv.description || 'Tidak ada deskripsi proyek.' }}</p>
            </div>

            <!-- Actions -->
            <div class="flex items-center gap-2 flex-shrink-0 w-full lg:w-auto justify-end">
              <button @click="acceptInvitation(inv.id)" class="flex-1 lg:flex-initial px-5 py-2.5 bg-[#B85C38] hover:bg-[#B85C38]/90 text-white text-[11px] font-bold rounded-lg transition-colors whitespace-nowrap shadow-sm">
                ✓ Terima
              </button>
              <button @click="declineInvitation(inv.id)" class="flex-1 lg:flex-initial px-5 py-2.5 bg-slate-50 hover:bg-red-50 text-[#8A7A6C] hover:text-red-600 text-[11px] font-bold rounded-lg transition-colors border border-slate-200 hover:border-red-200">
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
          class="bg-white rounded-2xl border border-[#E8DCCB]/60 p-5 hover:shadow-md hover:border-[#E8DCCB] transition-all duration-300 group">
          <div class="flex flex-col lg:flex-row items-start lg:items-center gap-5 justify-between">
            <!-- Invited User Info -->
            <div class="flex items-start gap-4 flex-1 min-w-0">
              <div class="w-12 h-12 rounded-xl bg-[#F8F1E7] border border-[#E8DCCB] flex items-center justify-center font-bold text-sm text-[#8A7A6C] flex-shrink-0 shadow-sm">
                {{ (inv.invited_user?.name || 'U').charAt(0).toUpperCase() }}
              </div>
              <div class="min-w-0">
                <div class="flex items-center gap-2 flex-wrap mb-1">
                  <h4 class="text-[14px] font-bold text-[#2B1E16] truncate">{{ inv.invited_user?.name || 'UMKM Partner' }}</h4>
                  <span class="px-2 py-0.5 text-[9px] font-bold uppercase tracking-wider rounded-full bg-slate-100 text-[#6F6259] border border-slate-200">Terkirim</span>
                </div>
                <p class="text-xs text-[#8A7A6C] font-semibold truncate">{{ inv.name }}</p>
                <div class="flex items-center gap-1.5 mt-2 text-[10px] text-[#8A7A6C]/85 font-medium">
                  <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                  Dikirim pada: {{ inv.created_at }}
                </div>
              </div>
            </div>

            <!-- Description -->
            <div class="flex-1 min-w-0 bg-[#FAF6F0] p-3.5 rounded-xl border border-[#E8DCCB]/40 lg:my-0 my-2">
              <p class="text-xs text-[#6F6259] leading-relaxed line-clamp-3">{{ inv.description || 'Tidak ada deskripsi proyek.' }}</p>
            </div>

            <!-- Status / Cancel -->
            <div class="flex items-center gap-3 flex-shrink-0 w-full lg:w-auto justify-end">
              <span class="text-[10px] font-bold text-orange-600 bg-orange-50 px-3 py-2 rounded-xl border border-orange-100 flex items-center gap-1.5 shadow-sm">
                <span class="w-1.5 h-1.5 bg-orange-500 rounded-full animate-pulse"></span> Menunggu Persetujuan
              </span>
              <button @click="declineInvitation(inv.id)" class="px-4 py-2 bg-red-50 hover:bg-red-100 text-red-600 text-[11px] font-bold rounded-lg transition-colors border border-red-200 shadow-sm">
                Batalkan
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- Empty State -->
      <div v-if="pendingInvitations.length === 0 && sentInvitations.length === 0" class="bg-white rounded-2xl border border-[#E8DCCB]/60 p-16 text-center shadow-sm">
        <div class="w-16 h-16 mx-auto mb-4 rounded-3xl bg-[#F8F1E7] flex items-center justify-center text-3xl">📭</div>
        <h3 class="text-base font-bold text-[#2B1E16] mb-1">Belum Ada Undangan</h3>
        <p class="text-xs text-[#8A7A6C] max-w-[280px] mx-auto leading-relaxed">Undangan masuk dan permintaan kolaborasi yang dikirim akan muncul di sini.</p>
      </div>
    </div>

    <!-- Active Rooms Section -->
    <div v-if="activeTab === 'active'">
      <div v-if="loadingRooms" class="grid grid-cols-1 md:grid-cols-2 gap-5">
        <div v-for="i in 2" :key="i" class="bg-white rounded-2xl border border-[#E8DCCB]/60 p-6 animate-pulse h-40"></div>
      </div>
      <div v-else-if="activeRooms.length === 0" class="bg-white rounded-2xl border border-[#E8DCCB]/60 p-16 text-center shadow-sm">
        <div class="w-16 h-16 mx-auto mb-4 rounded-3xl bg-[#F8F1E7] flex items-center justify-center text-3xl">🚪</div>
        <h3 class="text-base font-bold text-[#2B1E16] mb-1">Belum Ada Ruang Aktif</h3>
        <p class="text-xs text-[#8A7A6C] max-w-[280px] mx-auto leading-relaxed">Anda belum bergabung di ruangan kolaborasi aktif manapun saat ini.</p>
      </div>
      <div v-else class="grid grid-cols-1 md:grid-cols-2 gap-5">
        <div v-for="room in activeRooms" :key="room.id" @click="joinRoom(room.id)"
          class="bg-white rounded-2xl border border-[#E8DCCB]/60 p-5 hover:shadow-md hover:border-[#E8DCCB] transition-all duration-300 group cursor-pointer relative overflow-hidden flex flex-col justify-between min-h-[160px]">
          <div class="absolute top-0 right-0 w-32 h-32 bg-[#F8F1E7] rounded-full blur-3xl opacity-60 pointer-events-none"></div>
          <div class="relative z-10 w-full">
            <div class="flex items-center justify-between mb-3">
              <span class="px-2 py-0.5 bg-emerald-50 text-emerald-600 text-[9px] font-bold uppercase tracking-wider rounded-full flex items-center gap-1">
                <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full animate-pulse"></span> Aktif
              </span>
              <span class="text-[10px] font-semibold text-[#8A7A6C]">{{ room.timeAgo }}</span>
            </div>
            <h3 class="text-base font-bold text-[#2B1E16] mb-1.5 group-hover:text-[#B85C38] transition-colors truncate">{{ room.name }}</h3>
            <p class="text-xs text-[#8A7A6C] leading-relaxed line-clamp-2">{{ room.description || 'Tidak ada deskripsi ruang kolaborasi.' }}</p>
          </div>
          <div class="relative z-10 flex items-center justify-between mt-4 pt-3 border-t border-[#E8DCCB]/40 w-full">
            <div class="flex -space-x-1.5">
              <div class="w-7 h-7 rounded-xl border-2 border-white bg-[#F8F1E7] flex items-center justify-center text-[10px] font-bold text-[#B85C38] shadow-sm flex-shrink-0">
                {{ (room.creator?.name || 'U').charAt(0).toUpperCase() }}
              </div>
            </div>
            <button @click.stop="joinRoom(room.id)" class="px-4 py-2 bg-[#FAF6F0] hover:bg-[#B85C38]/10 text-[#B85C38] text-[11px] font-bold rounded-lg transition-colors border border-[#B85C38]/20 flex items-center gap-1">
              Masuk Room
              <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg>
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Completed Section -->
    <div v-if="activeTab === 'completed'" class="space-y-4">
      <div v-if="loadingRooms" class="space-y-3">
        <div v-for="i in 2" :key="i" class="bg-white rounded-2xl border border-[#E8DCCB]/60 p-6 animate-pulse h-16"></div>
      </div>
      <div v-else-if="completedRooms.length === 0" class="bg-white rounded-2xl border border-[#E8DCCB]/60 p-16 text-center shadow-sm">
        <div class="w-16 h-16 mx-auto mb-4 rounded-3xl bg-[#F8F1E7] flex items-center justify-center text-3xl">✅</div>
        <h3 class="text-base font-bold text-[#2B1E16] mb-1">Belum Ada Kolaborasi Selesai</h3>
        <p class="text-xs text-[#8A7A6C] max-w-[280px] mx-auto leading-relaxed">Kolaborasi yang telah diselesaikan akan tersimpan dan diarsipkan di sini.</p>
      </div>
      <div v-else v-for="room in completedRooms" :key="room.id" class="bg-white rounded-2xl border border-[#E8DCCB]/60 p-4 hover:shadow-md hover:border-[#E8DCCB] transition-all duration-300">
        <div class="flex items-center justify-between gap-4">
          <div class="flex items-center gap-3 min-w-0">
            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold text-sm shadow-sm flex-shrink-0">✓</div>
            <div class="min-w-0">
              <h4 class="text-[14px] font-bold text-[#2B1E16] truncate">{{ room.name }}</h4>
              <p class="text-xs text-[#8A7A6C] font-medium mt-0.5">Kolaborator: {{ room.creator?.name || 'Partner' }} · Selesai pada {{ room.created_at }}</p>
            </div>
          </div>
          <button @click="joinRoom(room.id)" class="px-4 py-2 bg-slate-50 hover:bg-[#B85C38]/10 text-[#8A7A6C] hover:text-[#B85C38] text-[11px] font-bold rounded-lg transition-colors border border-slate-200 hover:border-[#B85C38]/20 flex-shrink-0">
            Detail
          </button>
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
      headers: { 
        'Authorization': `Bearer ${token}`,
        'Accept': 'application/json'
      }
    });
    if (res.status === 401) {
      localStorage.removeItem('user');
      localStorage.removeItem('token');
      router.push('/login');
      return;
    }
    if (res.ok) {
      const data = await res.json();
      pendingInvitations.value = data.incoming || [];
      sentInvitations.value = data.outgoing || [];
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
      headers: { 
        'Authorization': `Bearer ${token}`,
        'Accept': 'application/json'
      }
    });
    if (activeRes.status === 401) {
      localStorage.removeItem('user');
      localStorage.removeItem('token');
      router.push('/login');
      return;
    }
    if (activeRes.ok) {
      const activeData = await activeRes.json();
      activeRooms.value = activeData.data || [];
    }

    // Fetch completed
    const completedRes = await fetch('/api/v1/cocreate/rooms?status=completed', {
      headers: { 
        'Authorization': `Bearer ${token}`,
        'Accept': 'application/json'
      }
    });
    if (completedRes.ok) {
      const completedData = await completedRes.json();
      completedRooms.value = completedData.data || [];
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
      headers: { 
        'Authorization': `Bearer ${token}`,
        'Accept': 'application/json'
      }
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

<style scoped>
.no-scrollbar::-webkit-scrollbar { display: none; }
.no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
</style>
