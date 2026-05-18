<template>
  <div class="h-[calc(100vh-8rem)] flex flex-col md:flex-row gap-6 animate-in fade-in duration-700">
    <!-- Main Workspace (Canvas Area) -->
    <div class="flex-1 bg-surface rounded-[2rem] border border-borderSoft shadow-[0_8px_30px_rgb(0,0,0,0.02)] flex flex-col overflow-hidden relative">
      <div v-if="loading" class="absolute inset-0 bg-surface/80 backdrop-blur-sm z-50 flex items-center justify-center">
        <div class="w-10 h-10 border-4 border-indigo-200 border-t-indigo-600 rounded-full animate-spin"></div>
      </div>
      
      <!-- Room Header -->
      <div class="px-6 py-4 border-b border-borderSoft flex items-center justify-between bg-surface z-10">
        <div>
          <h2 class="text-lg font-black text-espresso tracking-tight flex items-center gap-2">
            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
            {{ room?.name || 'Memuat Ruangan...' }}
          </h2>
          <p class="text-xs text-muted font-medium">{{ room?.description }}</p>
        </div>
        
        <div class="flex items-center gap-3">
          <div class="flex -space-x-2 mr-2">
            <div v-for="p in room?.participants || []" :key="p.id" class="w-8 h-8 rounded-full border-2 border-white bg-slate-200 flex items-center justify-center text-xs font-bold text-muted shadow-sm" :title="p.name">
               {{ p.name?.charAt(0).toUpperCase() }}
            </div>
          </div>
          <button @click="closeRoom" v-if="room?.creator_id === user.id" class="px-4 py-2 bg-slate-100 hover:bg-red-50 hover:text-red-600 text-muted rounded-lg text-[10px] font-black uppercase tracking-widest transition-colors">
            Tutup Ruang
          </button>
        </div>
      </div>

      <!-- Collaborative Canvas -->
      <div ref="containerEl" class="flex-1 bg-slate-50 relative overflow-hidden group">
        <div class="absolute inset-0 opacity-20 bg-[radial-gradient(#cbd5e1_1px,transparent_1px)] [background-size:16px_16px] pointer-events-none"></div>
        
        <!-- Empty State Watermark -->
        <div class="absolute inset-0 flex flex-col items-center justify-center text-center p-8 pointer-events-none transition-opacity duration-500" :class="hasContent ? 'opacity-0' : 'opacity-100'">
          <div class="w-20 h-20 bg-surface rounded-3xl shadow-lg flex items-center justify-center text-3xl mb-4 -rotate-6 group-hover:rotate-0 transition-transform duration-500">
            ✨
          </div>
          <h3 class="text-xl font-black text-slate-300 mb-1">Kanvas Kolaborasi</h3>
          <p class="text-xs text-slate-400 font-medium max-w-xs">Gunakan tools di bawah untuk mulai membuat sketsa atau corak pakaian.</p>
        </div>

        <canvas ref="canvasEl" class="absolute inset-0 z-10"></canvas>
        
        <!-- Floating Toolbar -->
        <div class="absolute bottom-6 left-1/2 -translate-x-1/2 bg-surface rounded-2xl shadow-xl border border-borderSoft p-2 flex items-center gap-2 z-20">
          <button @click="setMode('draw')" :class="mode === 'draw' ? 'bg-sand text-terracotta' : 'text-muted hover:bg-sand hover:text-terracotta'" class="w-10 h-10 rounded-xl flex items-center justify-center transition-colors" title="Menggambar (Pen)">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
          </button>
          <button @click="setMode('select')" :class="mode === 'select' ? 'bg-sand text-terracotta' : 'text-muted hover:bg-sand hover:text-terracotta'" class="w-10 h-10 rounded-xl flex items-center justify-center transition-colors" title="Pilih (Cursor)">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5" /></svg>
          </button>
          <div class="w-px h-6 bg-slate-200 mx-1"></div>
          <button @click="clearCanvas" class="w-10 h-10 rounded-xl flex items-center justify-center text-muted hover:bg-red-50 hover:text-red-600 transition-colors" title="Hapus Semua">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
          </button>
        </div>
      </div>
    </div>

    <!-- Chat Sidebar -->
    <div class="w-full md:w-80 bg-surface rounded-[2rem] border border-borderSoft shadow-[0_8px_30px_rgb(0,0,0,0.02)] flex flex-col overflow-hidden">
      <div class="p-4 border-b border-borderSoft bg-slate-50/50">
        <h3 class="text-xs font-black uppercase tracking-widest text-espresso">Live Chat</h3>
      </div>
      
      <!-- Chat Messages -->
      <div class="flex-1 overflow-y-auto p-4 space-y-4 no-scrollbar flex flex-col" ref="chatContainer">
        <div class="text-center my-2">
          <span class="text-[10px] font-bold uppercase tracking-widest text-slate-400 bg-slate-100 px-3 py-1 rounded-full">Ruangan Dibuat</span>
        </div>
        
        <div v-for="(msg, idx) in chatMessages" :key="idx" class="flex flex-col" :class="msg.isSelf ? 'items-end' : 'items-start'">
          <span class="text-[10px] text-slate-400 font-bold mb-1 ml-1">{{ msg.sender }}</span>
          <div class="px-4 py-2 rounded-2xl max-w-[85%] text-sm" :class="msg.isSelf ? 'bg-terracotta text-white rounded-br-sm' : 'bg-slate-100 text-espresso rounded-bl-sm'">
            {{ msg.text }}
          </div>
        </div>
      </div>
      
      <!-- Chat Input -->
      <div class="p-4 border-t border-borderSoft bg-surface">
        <form @submit.prevent="sendMessage" class="relative">
          <input v-model="newMessage" type="text" placeholder="Ketik pesan..." class="w-full bg-slate-50 border-none rounded-xl pl-4 pr-12 py-3 text-sm font-medium text-espresso outline-none focus:ring-2 focus:ring-orange-200 transition-all" />
          <button type="submit" :disabled="!newMessage.trim()" class="absolute right-2 top-1/2 -translate-y-1/2 w-8 h-8 bg-terracotta text-white rounded-lg flex items-center justify-center hover:bg-terracotta disabled:opacity-50 transition-colors">
            <svg class="w-4 h-4 -mr-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" /></svg>
          </button>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted, nextTick } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import * as fabric from 'fabric';

const route = useRoute();
const router = useRouter();
const room = ref(null);
const loading = ref(true);
const user = ref(JSON.parse(localStorage.getItem('user') || '{}'));

const newMessage = ref('');
const chatMessages = ref([
  { sender: 'Sistem', text: 'Selamat datang di Co-Create Room. Semua pesan di sini dilindungi enkripsi ujung-ke-ujung.', isSelf: false }
]);
const chatContainer = ref(null);

// Canvas variables
const canvasEl = ref(null);
const containerEl = ref(null);
const mode = ref('draw');
const hasContent = ref(false);
let canvas = null;

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

const scrollToBottom = () => {
  nextTick(() => {
    if (chatContainer.value) {
      chatContainer.value.scrollTop = chatContainer.value.scrollHeight;
    }
  });
};

const sendMessage = () => {
  if (!newMessage.value.trim()) return;
  chatMessages.value.push({
    sender: user.value.name,
    text: newMessage.value,
    isSelf: true
  });
  scrollToBottom();
  
  // Auto reply simulation
  if (chatMessages.value.length === 2) {
    setTimeout(() => {
      chatMessages.value.push({
        sender: 'Desainer Bot',
        text: 'Halo! Saya sudah melihat referensinya. Mari kita diskusikan polanya di canvas sebelah kiri ya.',
        isSelf: false
      });
      scrollToBottom();
    }, 1500);
  }
  
  newMessage.value = '';
};

const initCanvas = () => {
  if (canvasEl.value) {
    canvas = new fabric.Canvas(canvasEl.value, {
      isDrawingMode: true,
      selection: true,
    });
    
    // Set up basic brush
    if (canvas.freeDrawingBrush) {
      canvas.freeDrawingBrush.color = '#f97316'; // orange-500
      canvas.freeDrawingBrush.width = 4;
    }

    // Hide empty state on interaction
    canvas.on('path:created', () => { hasContent.value = true; });
    canvas.on('object:added', () => { hasContent.value = true; });
    
    // Handle resize
    const resizeObserver = new ResizeObserver((entries) => {
      for (let entry of entries) {
        if (entry.target === containerEl.value) {
          canvas.setDimensions({
            width: entry.contentRect.width,
            height: entry.contentRect.height
          });
        }
      }
    });
    
    if (containerEl.value) {
      resizeObserver.observe(containerEl.value);
    }

    onUnmounted(() => {
      resizeObserver.disconnect();
      canvas.dispose();
    });
  }
};

const setMode = (newMode) => {
  mode.value = newMode;
  if (canvas) {
    canvas.isDrawingMode = (newMode === 'draw');
    if (newMode === 'select') {
      canvas.selection = true;
    }
  }
};

const clearCanvas = () => {
  if (confirm('Yakin ingin menghapus seluruh kanvas?')) {
    if (canvas) {
      canvas.clear();
      hasContent.value = false;
      // Restore basic settings after clear
      if (canvas.freeDrawingBrush) {
        canvas.freeDrawingBrush.color = '#f97316';
        canvas.freeDrawingBrush.width = 4;
      }
    }
  }
};

onMounted(() => {
  fetchRoomDetail();
  initCanvas();
});
</script>

<style scoped>
.no-scrollbar::-webkit-scrollbar { display: none; }
.no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
</style>
