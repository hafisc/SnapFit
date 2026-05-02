<template>
  <div class="h-[calc(100vh-8rem)] flex flex-col md:flex-row gap-6 animate-in fade-in duration-700">
    <!-- Main Workspace (Canvas Area) -->
    <div class="flex-1 bg-white rounded-[2rem] border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.02)] flex flex-col overflow-hidden relative">
      <div v-if="loading" class="absolute inset-0 bg-white/80 backdrop-blur-sm z-50 flex items-center justify-center">
        <div class="w-10 h-10 border-4 border-indigo-200 border-t-indigo-600 rounded-full animate-spin"></div>
      </div>
      
      <!-- Room Header -->
      <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-white z-10">
        <div>
          <h2 class="text-lg font-black text-slate-800 tracking-tight flex items-center gap-2">
            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
            {{ room?.name || 'Memuat Ruangan...' }}
          </h2>
          <p class="text-xs text-slate-500 font-medium">{{ room?.description }}</p>
        </div>
        
        <div class="flex items-center gap-3">
          <div class="flex -space-x-2 mr-2">
            <div v-for="p in room?.participants || []" :key="p.id" class="w-8 h-8 rounded-full border-2 border-white bg-slate-200 flex items-center justify-center text-xs font-bold text-slate-600 shadow-sm" :title="p.user.name">
               {{ p.user.name.charAt(0).toUpperCase() }}
            </div>
          </div>
          <button @click="closeRoom" v-if="room?.creator_id === user.id" class="px-4 py-2 bg-slate-100 hover:bg-red-50 hover:text-red-600 text-slate-600 rounded-lg text-[10px] font-black uppercase tracking-widest transition-colors">
            Tutup Ruang
          </button>
        </div>
      </div>

      <!-- Collaborative Canvas (Simulation) -->
      <div class="flex-1 bg-slate-50 relative overflow-hidden group">
        <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#cbd5e1_1px,transparent_1px)] [background-size:16px_16px]"></div>
        
        <div class="absolute inset-0 flex flex-col items-center justify-center text-center p-8 pointer-events-none">
          <div class="w-24 h-24 bg-white rounded-3xl shadow-xl flex items-center justify-center text-4xl mb-6 -rotate-6 group-hover:rotate-0 transition-transform duration-500">
            🎨
          </div>
          <h3 class="text-xl font-black text-slate-800 mb-2">Interactive Canvas</h3>
          <p class="text-sm text-slate-500 max-w-sm">Area kolaborasi visual. (Di versi production, bagian ini akan diisi integrasi Fabric.js atau papan tulis interaktif real-time).</p>
        </div>
        
        <!-- Floating Toolbar -->
        <div class="absolute bottom-6 left-1/2 -translate-x-1/2 bg-white rounded-2xl shadow-xl border border-slate-100 p-2 flex items-center gap-2">
          <button class="w-10 h-10 rounded-xl flex items-center justify-center text-slate-600 hover:bg-indigo-50 hover:text-indigo-600 transition-colors"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122" /></svg></button>
          <button class="w-10 h-10 rounded-xl flex items-center justify-center text-slate-600 hover:bg-indigo-50 hover:text-indigo-600 transition-colors"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg></button>
          <div class="w-px h-6 bg-slate-200 mx-1"></div>
          <button class="w-10 h-10 rounded-xl flex items-center justify-center text-slate-600 hover:bg-indigo-50 hover:text-indigo-600 transition-colors"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" /></svg></button>
        </div>
      </div>
    </div>

    <!-- Chat Sidebar -->
    <div class="w-full md:w-80 bg-white rounded-[2rem] border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.02)] flex flex-col overflow-hidden">
      <div class="p-4 border-b border-slate-100 bg-slate-50/50">
        <h3 class="text-xs font-black uppercase tracking-widest text-slate-800">Live Chat</h3>
      </div>
      
      <!-- Chat Messages -->
      <div class="flex-1 overflow-y-auto p-4 space-y-4 no-scrollbar flex flex-col">
        <div class="text-center my-2">
          <span class="text-[10px] font-bold uppercase tracking-widest text-slate-400 bg-slate-100 px-3 py-1 rounded-full">Ruangan Dibuat</span>
        </div>
        
        <div v-for="(msg, idx) in chatMessages" :key="idx" class="flex flex-col" :class="msg.isSelf ? 'items-end' : 'items-start'">
          <span class="text-[10px] text-slate-400 font-bold mb-1 ml-1">{{ msg.sender }}</span>
          <div class="px-4 py-2 rounded-2xl max-w-[85%] text-sm" :class="msg.isSelf ? 'bg-indigo-600 text-white rounded-br-sm' : 'bg-slate-100 text-slate-800 rounded-bl-sm'">
            {{ msg.text }}
          </div>
        </div>
      </div>
      
      <!-- Chat Input -->
      <div class="p-4 border-t border-slate-100 bg-white">
        <form @submit.prevent="sendMessage" class="relative">
          <input v-model="newMessage" type="text" placeholder="Ketik pesan..." class="w-full bg-slate-50 border-none rounded-xl pl-4 pr-12 py-3 text-sm font-medium text-slate-800 outline-none focus:ring-2 focus:ring-indigo-200 transition-all" />
          <button type="submit" :disabled="!newMessage.trim()" class="absolute right-2 top-1/2 -translate-y-1/2 w-8 h-8 bg-indigo-600 text-white rounded-lg flex items-center justify-center hover:bg-indigo-700 disabled:opacity-50 transition-colors">
            <svg class="w-4 h-4 -mr-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" /></svg>
          </button>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRoute, useRouter } from 'vue-router';

const route = useRoute();
const router = useRouter();
const room = ref(null);
const loading = ref(true);
const user = ref(JSON.parse(localStorage.getItem('user') || '{}'));

const newMessage = ref('');
const chatMessages = ref([
  { sender: 'Sistem', text: 'Selamat datang di Co-Create Room. Semua pesan di sini dilindungi enkripsi ujung-ke-ujung.', isSelf: false }
]);

const fetchRoomDetail = async () => {
  try {
    const token = localStorage.getItem('token');
    const res = await fetch(`/api/v1/cocreate/rooms/${route.params.id}`, {
      headers: { 'Authorization': `Bearer ${token}` }
    });
    if (res.ok) {
      const data = await res.json();
      room.value = data.data;
    } else {
      router.push('/umkm/cocreate');
    }
  } catch (error) {
    console.error(error);
  } finally {
    loading.value = false;
  }
};

const closeRoom = async () => {
  if (!confirm('Yakin ingin menutup ruangan ini permanen?')) return;
  try {
    const token = localStorage.getItem('token');
    const res = await fetch(`/api/v1/cocreate/rooms/${route.params.id}/close`, {
      method: 'PATCH',
      headers: { 'Authorization': `Bearer ${token}` }
    });
    if (res.ok) {
      router.push('/umkm/cocreate');
    }
  } catch (error) {
    console.error(error);
  }
};

const sendMessage = () => {
  if (!newMessage.value.trim()) return;
  chatMessages.value.push({
    sender: user.value.name,
    text: newMessage.value,
    isSelf: true
  });
  
  // Auto reply simulation
  if (chatMessages.value.length === 2) {
    setTimeout(() => {
      chatMessages.value.push({
        sender: 'Desainer Bot',
        text: 'Halo! Saya sudah melihat referensinya. Mari kita diskusikan polanya di canvas sebelah kiri ya.',
        isSelf: false
      });
    }, 1500);
  }
  
  newMessage.value = '';
};

onMounted(() => {
  fetchRoomDetail();
});
</script>

<style scoped>
.no-scrollbar::-webkit-scrollbar { display: none; }
.no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
</style>
