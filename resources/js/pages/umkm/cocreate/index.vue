<template>
  <div class="space-y-6 animate-in fade-in slide-in-from-bottom-4 duration-700">
    <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl p-8 text-white relative overflow-hidden shadow-xl shadow-terracotta/50/20 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
      <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIyMCIgaGVpZ2h0PSIyMCI+PGNpcmNsZSBjeD0iMiIgY3k9IjIiIHI9IjEiIGZpbGw9InJnYmEoMjU1LDI1NSwyNTUsMC4yKSIvPjwvc3ZnPg==')] opacity-30"></div>
      <div class="absolute -right-6 -top-6 w-24 h-24 bg-surface/10 rounded-full blur-xl"></div>
      <div class="relative z-10">
        <h2 class="text-3xl font-bold tracking-tight mb-2">Co-Create Rooms 👥</h2>
        <p class="text-white/80 text-sm max-w-lg font-medium">Tempat kolaborasi real-time antara UMKM dan Desainer. Buat ruang diskusi untuk merancang produk unggulan bersama ahlinya.</p>
      </div>
      <button @click="showCreateModal = true" class="relative z-10 bg-surface text-terracotta hover:bg-sand px-6 py-4 rounded-xl text-xs font-bold tracking-wider uppercase transition-all shadow-lg flex items-center gap-2 flex-shrink-0">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
        Buat Ruangan
      </button>
    </div>

    <!-- Active Rooms Grid -->
    <div v-if="loading" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
      <div v-for="i in 3" :key="i" class="bg-surface rounded-3xl p-6 border border-borderSoft animate-pulse h-48"></div>
    </div>
    
    <div v-else-if="rooms.length === 0" class="bg-surface rounded-2xl border border-borderSoft shadow-[0_8px_30px_rgb(0,0,0,0.02)] py-20 text-center">
      <div class="w-20 h-20 bg-sand text-orange-400 rounded-full flex items-center justify-center mx-auto mb-4 text-3xl">🪑</div>
      <h3 class="text-lg font-bold text-espresso mb-1">Belum Ada Ruang Aktif</h3>
      <p class="text-slate-400 text-sm font-medium mb-6">Mulai kolaborasi pertamamu dengan membuat ruangan baru.</p>
    </div>

    <div v-else class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
      <div v-for="room in rooms" :key="room.id" class="bg-surface rounded-2xl border border-borderSoft p-6 shadow-[0_8px_30px_rgb(0,0,0,0.02)] hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] transition-all flex flex-col justify-between group">
        <div>
          <div class="flex items-start justify-between mb-4">
            <div class="w-12 h-12 bg-sand text-terracotta rounded-2xl flex items-center justify-center text-xl group-hover:scale-110 transition-transform">
              {{ room.name.charAt(0).toUpperCase() }}
            </div>
            <span class="px-3 py-1 bg-emerald-50 text-emerald-600 text-[10px] font-bold uppercase tracking-wider rounded-full">Aktif</span>
          </div>
          <h3 class="font-bold text-espresso text-lg mb-2 truncate">{{ room.name }}</h3>
          <p class="text-xs text-muted line-clamp-2 mb-4">{{ room.description || 'Tidak ada deskripsi.' }}</p>
        </div>
        
        <div class="border-t border-slate-50 pt-4 flex items-center justify-between mt-auto">
          <div class="flex -space-x-2">
            <div v-for="i in Math.min(room.participants_count || 1, 3)" :key="i" class="w-8 h-8 rounded-full border-2 border-white bg-slate-200 flex items-center justify-center text-xs font-bold text-muted z-10 relative">
               {{ i === 1 ? room.creator?.name?.charAt(0) : 'D' }}
            </div>
            <div v-if="(room.participants_count || 1) > 3" class="w-8 h-8 rounded-full border-2 border-white bg-slate-100 flex items-center justify-center text-[10px] font-bold text-muted z-0 relative">
              +{{ (room.participants_count || 1) - 3 }}
            </div>
          </div>
          <button @click="joinRoom(room.id)" class="text-xs font-bold uppercase tracking-wider text-terracotta hover:text-orange-800 transition-colors">
            Gabung &rarr;
          </button>
        </div>
      </div>
    </div>

    <!-- Create Room Modal -->
    <div v-if="showCreateModal" class="fixed inset-0 z-50 flex items-center justify-center px-4">
      <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm" @click="showCreateModal = false"></div>
      <div class="bg-surface rounded-2xl shadow-2xl p-8 max-w-md w-full relative z-10 animate-in zoom-in-95 duration-200">
        <h3 class="text-xl font-bold text-espresso mb-6">Buat Ruang Kolaborasi</h3>
        <form @submit.prevent="createRoom" class="space-y-4">
          <div>
            <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-2 ml-1">Nama Ruangan</label>
            <input v-model="form.name" type="text" required class="w-full bg-slate-50 border-none rounded-xl px-5 py-4 text-sm font-bold text-espresso outline-none focus:ring-2 focus:ring-orange-200 transition-all" placeholder="Contoh: Desain Batik Summer 2026" />
          </div>
          <div>
            <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-2 ml-1">Deskripsi & Tujuan</label>
            <textarea v-model="form.description" rows="3" required class="w-full bg-slate-50 border-none rounded-xl px-5 py-4 text-sm font-medium text-espresso outline-none focus:ring-2 focus:ring-orange-200 transition-all resize-none" placeholder="Mencari desainer untuk membuat pola baru..."></textarea>
          </div>
          <div class="flex gap-4 pt-4">
            <button type="button" @click="showCreateModal = false" class="flex-1 bg-slate-100 hover:bg-slate-200 text-muted py-4 rounded-xl text-xs font-bold uppercase tracking-wider transition-colors">Batal</button>
            <button type="submit" :disabled="isCreating" class="flex-1 bg-terracotta hover:bg-terracotta text-white py-4 rounded-xl text-xs font-bold uppercase tracking-wider transition-colors disabled:opacity-50">
              {{ isCreating ? 'Membuat...' : 'Buat Sekarang' }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';

const router = useRouter();
const rooms = ref([]);
const loading = ref(true);
const showCreateModal = ref(false);
const isCreating = ref(false);

const form = ref({
  name: '',
  description: ''
});

const fetchRooms = async () => {
  try {
    const token = localStorage.getItem('token');
    const res = await fetch('/api/v1/cocreate/rooms', {
      headers: { 'Authorization': `Bearer ${token}` }
    });
    if (res.ok) {
      const data = await res.json();
      rooms.value = data.data;
    }
  } finally {
    loading.value = false;
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
    // Attempt to join API, ignore error if already joined
    await fetch(`/api/v1/cocreate/rooms/${roomId}/join`, {
      method: 'POST',
      headers: { 'Authorization': `Bearer ${token}` }
    });
    router.push(`/umkm/cocreate/${roomId}`);
  } catch (error) {
    console.error(error);
  }
};

onMounted(() => {
  fetchRooms();
});
</script>
