<template>
  <div class="space-y-6 animate-in fade-in slide-in-from-bottom-4 duration-700">
    <div class="bg-gradient-to-br from-[#2B1E16] via-[#3D2B1F] to-[#4A3428] rounded-2xl p-8 text-white relative overflow-hidden shadow-lg flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
      <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIyMCIgaGVpZ2h0PSIyMCI+PGNpcmNsZSBjeD0iMiIgY3k9IjIiIHI9IjEiIGZpbGw9InJnYmEoMjU1LDI1NSwyNTUsMC4yKSIvPjwvc3ZnPg==')] opacity-30"></div>
      <div class="absolute -right-6 -top-6 w-24 h-24 bg-white/10 rounded-full blur-xl"></div>
      <div class="relative z-10">
        <h2 class="text-3xl font-bold tracking-tight mb-2">Co-Create Rooms 👥</h2>
        <p class="text-white/80 text-sm max-w-lg font-medium">Tempat kolaborasi real-time antara UMKM dan Desainer. Buat ruang diskusi untuk merancang produk unggulan bersama ahlinya.</p>
      </div>
      <button @click="showCreateModal = true" class="relative z-10 bg-white text-[#B85C38] hover:bg-[#F8F1E7] px-6 py-4 rounded-xl text-xs font-bold tracking-wider uppercase transition-all shadow-lg flex items-center gap-2 flex-shrink-0 cursor-pointer">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
        Buat Ruangan
      </button>
    </div>

    <!-- Tabs Filter -->
    <div class="flex justify-end">
      <div class="flex bg-white rounded-2xl border border-[#E8DCCB] overflow-hidden shadow-sm">
        <button v-for="tab in tabs" :key="tab.key" @click="activeTab = tab.key"
          class="px-5 py-3 text-[10px] font-bold uppercase tracking-wider transition-all cursor-pointer"
          :class="activeTab === tab.key ? 'bg-[#B85C38] text-white shadow-sm' : 'text-[#6F6259] hover:bg-slate-50'">
          {{ tab.label }}
          <span v-if="tab.count" class="ml-1.5 bg-white/20 text-[9px] px-1.5 py-0.5 rounded-md" :class="activeTab === tab.key ? '' : 'bg-[#F8F1E7] text-[#B85C38]'">{{ tab.count }}</span>
        </button>
      </div>
    </div>

    <!-- Pending & Sent Invitations Section -->
    <div v-if="activeTab === 'pending'" class="space-y-6">
      
      <!-- Undangan Masuk (Incoming) -->
      <div v-if="pendingInvitations.length > 0" class="space-y-4">
        <h3 class="text-[11px] font-black uppercase tracking-[0.2em] text-[#8A7A6C] mb-2 ml-1">Undangan Masuk</h3>
        <div v-for="inv in pendingInvitations" :key="inv.id"
          class="bg-white rounded-2xl border border-[#E8DCCB] p-6 md:p-8 hover:shadow-md transition-all duration-300 group">
          <div class="flex flex-col lg:flex-row items-start lg:items-center gap-6">
            <!-- Creator Info -->
            <div class="flex items-center gap-4 flex-1 min-w-0">
              <div class="w-14 h-14 rounded-2xl flex-shrink-0 flex items-center justify-center font-bold text-xl text-white shadow-md bg-gradient-to-br from-[#B85C38] to-orange-500">
                {{ (inv.creator?.name || 'U').charAt(0).toUpperCase() }}
              </div>
              <div class="min-w-0">
                <div class="flex items-center gap-2 mb-1">
                  <h3 class="text-lg font-bold text-[#2B1E16] truncate">{{ inv.creator?.name || 'Kolaborator' }}</h3>
                  <span class="flex-shrink-0 px-2.5 py-1 text-[9px] font-bold uppercase tracking-wider rounded-lg bg-[#F8F1E7] text-[#B85C38]">Undangan</span>
                </div>
                <p class="text-sm text-[#2B1E16] font-black truncate">{{ inv.name }}</p>
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
              <p class="text-xs text-[#6F6259] leading-relaxed line-clamp-3">{{ inv.description || 'Tidak ada deskripsi.' }}</p>
            </div>

            <!-- Actions -->
            <div class="flex items-center gap-2 flex-shrink-0">
              <button @click="acceptInvitation(inv.id)" class="px-6 py-3 bg-[#B85C38] hover:bg-[#9E4B2E] text-white text-[10px] font-bold uppercase tracking-wider rounded-2xl transition-all shadow-sm active:scale-95 cursor-pointer">
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
          class="bg-[#FAFAFA] rounded-2xl border border-[#E8DCCB] p-6 md:p-8 opacity-90 transition-all duration-300">
          <div class="flex flex-col lg:flex-row items-start lg:items-center gap-6">
            <!-- Invited User Info -->
            <div class="flex items-center gap-4 flex-1 min-w-0">
              <div class="w-14 h-14 rounded-2xl flex-shrink-0 flex items-center justify-center font-bold text-xl text-[#6F6259] bg-[#F8F1E7] border border-[#E8DCCB]">
                {{ (inv.invited_user?.name || 'U').charAt(0).toUpperCase() }}
              </div>
              <div class="min-w-0">
                <div class="flex items-center gap-2 mb-1">
                  <h3 class="text-lg font-bold text-[#2B1E16] truncate">{{ inv.invited_user?.name || 'Kolaborator' }}</h3>
                  <span class="flex-shrink-0 px-2.5 py-1 text-[9px] font-bold uppercase tracking-wider rounded-lg bg-[#F8F1E7] text-[#6F6259]">Terkirim</span>
                </div>
                <p class="text-sm text-[#2B1E16] font-black truncate">{{ inv.name }}</p>
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
              <p class="text-xs text-[#6F6259] leading-relaxed line-clamp-3">{{ inv.description || 'Tidak ada deskripsi.' }}</p>
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
      <div v-if="pendingInvitations.length === 0 && sentInvitations.length === 0" class="bg-white rounded-2xl border border-[#E8DCCB] p-16 text-center shadow-[0_8px_30px_rgb(0,0,0,0.02)]">
        <div class="text-6xl mb-4">📭</div>
        <h3 class="text-lg font-bold text-[#2B1E16] mb-2">Belum Ada Undangan</h3>
        <p class="text-sm text-[#8A7A6C] font-medium">Undangan masuk dan permintaan kolaborasi yang dikirim akan muncul di sini.</p>
      </div>
    </div>

    <!-- Active Rooms Section -->
    <div v-if="activeTab === 'active'">
      <div v-if="loadingRooms" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
        <div v-for="i in 3" :key="i" class="bg-white rounded-2xl border border-[#E8DCCB] animate-pulse h-48"></div>
      </div>
      <div v-else-if="activeRooms.length === 0" class="bg-white rounded-2xl border border-[#E8DCCB] p-16 text-center shadow-[0_8px_30px_rgb(0,0,0,0.02)]">
        <div class="w-20 h-20 bg-[#F8F1E7] text-orange-400 rounded-full flex items-center justify-center mx-auto mb-4 text-3xl">🪑</div>
        <h3 class="text-lg font-bold text-[#2B1E16] mb-2">Belum Ada Ruang Aktif</h3>
        <p class="text-sm text-[#8A7A6C] font-medium">Mulai kolaborasi pertamamu dengan desainer dengan mengajak kolaborasi dari halaman detail.</p>
      </div>
      <div v-else class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
        <div v-for="room in activeRooms" :key="room.id" class="bg-white rounded-2xl border border-[#E8DCCB] p-6 shadow-[0_8px_30px_rgb(0,0,0,0.02)] hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] transition-all flex flex-col justify-between group">
          <div>
            <div class="flex items-start justify-between mb-4">
              <div class="w-12 h-12 bg-[#F8F1E7] text-[#B85C38] rounded-2xl flex items-center justify-center text-xl group-hover:scale-110 transition-transform">
                {{ room.name.charAt(0).toUpperCase() }}
              </div>
              <span class="px-3 py-1 bg-emerald-50 text-emerald-600 text-[10px] font-bold uppercase tracking-wider rounded-full">Aktif</span>
            </div>
            <h3 class="font-bold text-[#2B1E16] text-lg mb-2 truncate">{{ room.name }}</h3>
            <p class="text-xs text-[#6F6259] line-clamp-2 mb-4">{{ room.description || 'Tidak ada deskripsi.' }}</p>
          </div>
          <div class="border-t border-[#E8DCCB]/40 pt-4 flex items-center justify-between mt-auto">
            <div class="flex -space-x-2">
              <div class="w-8 h-8 rounded-full border-2 border-white bg-[#E8DCCB] flex items-center justify-center text-xs font-bold text-[#6F6259]">
                 {{ (room.creator?.name || 'U').charAt(0).toUpperCase() }}
              </div>
            </div>
            <button @click="joinRoom(room.id)" class="text-xs font-bold uppercase tracking-wider text-[#B85C38] hover:text-orange-850 transition-colors cursor-pointer">
              Gabung &rarr;
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Completed Section -->
    <div v-if="activeTab === 'completed'">
      <div v-if="loadingRooms" class="space-y-4">
        <div v-for="i in 2" :key="i" class="bg-white rounded-2xl border border-[#E8DCCB] animate-pulse h-20"></div>
      </div>
      <div v-else-if="completedRooms.length === 0" class="bg-white rounded-2xl border border-[#E8DCCB] p-16 text-center shadow-[0_8px_30px_rgb(0,0,0,0.02)]">
        <div class="text-6xl mb-4">✅</div>
        <h3 class="text-lg font-bold text-[#2B1E16] mb-2">Belum Ada Kolaborasi Selesai</h3>
        <p class="text-sm text-[#8A7A6C] font-medium">Kolaborasi yang selesai akan tersimpan di sini.</p>
      </div>
      <div v-else class="space-y-4">
        <div v-for="room in completedRooms" :key="room.id" class="bg-white rounded-2xl border border-[#E8DCCB] p-6 hover:shadow-md transition-all duration-300 flex items-center justify-between">
          <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl flex-shrink-0 flex items-center justify-center text-xl bg-[#F8F1E7]">✅</div>
            <div class="flex-1 min-w-0">
              <h4 class="text-sm font-bold text-[#2B1E16] truncate">{{ room.name }}</h4>
              <p class="text-xs text-[#6F6259] font-medium">Partner: {{ room.creator?.name || 'Kolaborator' }} · Selesai pada {{ room.created_at }}</p>
            </div>
          </div>
          <button @click="joinRoom(room.id)" class="px-4 py-2 bg-slate-50 hover:bg-sand text-muted hover:text-terracotta text-[10px] font-bold uppercase tracking-wider rounded-xl transition-colors border border-borderSoft cursor-pointer">Detail</button>
        </div>
      </div>
    </div>

    <!-- Create Room Modal -->
    <div v-if="showCreateModal" class="fixed inset-0 z-50 flex items-center justify-center px-4">
      <div class="absolute inset-0 bg-[#2B1E16]/50 backdrop-blur-sm" @click="showCreateModal = false"></div>
      <div class="bg-white rounded-2xl shadow-2xl p-8 max-w-md w-full relative z-10 animate-in zoom-in-95 duration-200">
        <h3 class="text-xl font-bold text-[#2B1E16] mb-6">Buat Ruang Kolaborasi</h3>
        <form @submit.prevent="createRoom" class="space-y-4">
          <div>
            <label class="block text-[10px] font-bold uppercase tracking-wider text-[#8A7A6C] mb-2 ml-1">Nama Ruangan</label>
            <input v-model="form.name" type="text" required class="w-full bg-[#FFFCF7] border-none rounded-xl px-5 py-4 text-sm font-bold text-[#2B1E16] outline-none focus:ring-2 focus:ring-[#B85C38]/20 transition-all" placeholder="Contoh: Desain Batik Summer 2026" />
          </div>
          <div>
            <label class="block text-[10px] font-bold uppercase tracking-wider text-[#8A7A6C] mb-2 ml-1">Deskripsi & Tujuan</label>
            <textarea v-model="form.description" rows="3" required class="w-full bg-[#FFFCF7] border-none rounded-xl px-5 py-4 text-sm font-medium text-[#2B1E16] outline-none focus:ring-2 focus:ring-[#B85C38]/20 transition-all resize-none" placeholder="Mencari desainer untuk membuat pola baru..."></textarea>
          </div>
          <div class="flex gap-4 pt-4">
            <button type="button" @click="showCreateModal = false" class="flex-1 bg-[#F8F1E7] hover:bg-[#E8DCCB] text-[#6F6259] py-4 rounded-xl text-xs font-bold uppercase tracking-wider transition-colors">Batal</button>
            <button type="submit" :disabled="isCreating" class="flex-1 bg-[#B85C38] hover:bg-[#9E4B2E] text-white py-4 rounded-xl text-xs font-bold uppercase tracking-wider transition-colors disabled:opacity-50">
              {{ isCreating ? 'Membuat...' : 'Buat Sekarang' }}
            </button>
          </div>
        </form>
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

const showCreateModal = ref(false);
const isCreating = ref(false);

const form = ref({
  name: '',
  description: ''
});

const fetchInvitations = async () => {
  try {
    const token = localStorage.getItem('token');
    const res = await fetch('/api/v1/cocreate/rooms/invitations', {
      headers: {
        'Authorization': `Bearer ${token}`,
        'Accept': 'application/json'
      }
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
      headers: {
        'Authorization': `Bearer ${token}`,
        'Accept': 'application/json'
      }
    });
    if (activeRes.ok) {
      const activeData = await activeRes.json();
      activeRooms.value = activeData.data;
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

const createRoom = async () => {
  isCreating.value = true;
  try {
    const token = localStorage.getItem('token');
    const res = await fetch('/api/v1/cocreate/rooms', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'Authorization': `Bearer ${token}`
      },
      body: JSON.stringify(form.value)
    });
    
    if (res.ok) {
      const data = await res.json();
      showCreateModal.value = false;
      form.value.name = '';
      form.value.description = '';
      await fetchRooms();
      router.push(`/umkm/cocreate/${data.data.id}`);
    }
  } catch (error) {
    alert('Terjadi kesalahan jaringan');
  } finally {
    isCreating.value = false;
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
    router.push(`/umkm/cocreate/${roomId}`);
  } catch (error) {
    console.error(error);
  }
};

onMounted(() => {
  fetchInvitations();
  fetchRooms();
});
</script>
