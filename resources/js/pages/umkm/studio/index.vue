<template>
  <div class="space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-700">
    <!-- Header -->
    <div class="bg-gradient-to-r from-orange-500 to-amber-500 rounded-[2rem] p-8 text-white relative overflow-hidden shadow-xl shadow-orange-500/20">
      <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIyMCIgaGVpZ2h0PSIyMCI+PGNpcmNsZSBjeD0iMiIgY3k9IjIiIHI9IjEiIGZpbGw9InJnYmEoMjU1LDI1NSwyNTUsMC4yKSIvPjwvc3ZnPg==')] opacity-30"></div>
      <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
          <h2 class="text-3xl font-black tracking-tighter mb-2">AI Product Studio ✨</h2>
          <p class="text-orange-100 text-sm max-w-lg font-medium">Ubah foto produk biasamu menjadi luar biasa. Cukup unggah foto mentah, masukkan gaya yang kamu inginkan, dan biarkan AI bekerja.</p>
        </div>
      </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
      <!-- Workspace Form -->
      <div class="lg:col-span-1 space-y-6">
        <form @submit.prevent="generateAI" class="bg-white rounded-[2rem] border border-slate-100 p-6 shadow-[0_8px_30px_rgb(0,0,0,0.02)] space-y-6">
          
          <!-- Image Upload Area -->
          <div>
            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2 ml-1">Foto Asli</label>
            <div class="border-2 border-dashed border-slate-200 rounded-2xl p-6 text-center hover:border-orange-400 hover:bg-orange-50 transition-colors cursor-pointer" @click="$refs.fileInput.click()">
              <input type="file" ref="fileInput" @change="handleFileChange" accept="image/*" class="hidden" />
              <div v-if="previewUrl" class="relative">
                <img :src="previewUrl" class="w-full h-40 object-cover rounded-xl" />
                <button @click.stop="previewUrl = null" class="absolute top-2 right-2 w-8 h-8 bg-slate-900/50 backdrop-blur-sm text-white rounded-lg flex items-center justify-center hover:bg-red-500 transition-colors">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
              </div>
              <div v-else class="space-y-2 py-4">
                <div class="w-12 h-12 bg-orange-100 text-orange-600 rounded-full flex items-center justify-center mx-auto">
                  <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                </div>
                <p class="text-sm font-bold text-slate-600">Klik untuk unggah foto</p>
                <p class="text-[10px] text-slate-400 uppercase tracking-widest">JPG, PNG, WEBP (Max 5MB)</p>
              </div>
            </div>
            
            <div class="mt-4">
               <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2 ml-1">Atau Gunakan URL Gambar Asli</label>
               <input v-model="form.original_image_url" type="url" placeholder="https://contoh.com/foto.jpg" class="w-full bg-slate-50 border-none rounded-xl px-4 py-3 text-sm font-bold text-slate-800 outline-none focus:ring-2 focus:ring-orange-200 transition-all" />
            </div>
          </div>

          <!-- Prompt Input -->
          <div>
            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2 ml-1">Prompt Gaya Visual</label>
            <textarea v-model="form.prompt" rows="3" placeholder="Contoh: Jadikan tas ini berada di atas batu marmer dengan latar belakang pantai sunset yang estetik..." class="w-full bg-slate-50 border-none rounded-xl px-4 py-3 text-sm font-medium text-slate-800 outline-none focus:ring-2 focus:ring-orange-200 transition-all resize-none"></textarea>
            
            <!-- Quick Prompts -->
            <div class="flex flex-wrap gap-2 mt-3">
              <button type="button" @click="form.prompt = 'Studio lighting, minimal white background, 8k resolution, photorealistic'" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-lg text-[10px] font-bold transition-colors">Minimalis</button>
              <button type="button" @click="form.prompt = 'Cyberpunk 2077 style, neon lights, dark alley, glowing reflections'" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-lg text-[10px] font-bold transition-colors">Cyberpunk</button>
              <button type="button" @click="form.prompt = 'Warm sunlight coming from window, morning aesthetic, wooden table'" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-lg text-[10px] font-bold transition-colors">Aesthetic Pagi</button>
            </div>
          </div>

          <!-- Submit Button -->
          <button type="submit" :disabled="isGenerating || (!previewUrl && !form.original_image_url)" class="w-full bg-slate-900 hover:bg-black text-white px-6 py-4 rounded-xl text-xs font-black tracking-widest uppercase transition-all shadow-lg shadow-slate-900/20 disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2">
            <svg v-if="isGenerating" class="animate-spin w-4 h-4 text-orange-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
            {{ isGenerating ? 'AI Sedang Merender...' : 'Mulai Render AI' }}
          </button>
        </form>
      </div>

      <!-- Generated Results Gallery -->
      <div class="lg:col-span-2">
        <div class="bg-white rounded-[2rem] border border-slate-100 p-6 shadow-[0_8px_30px_rgb(0,0,0,0.02)] min-h-full">
          <div class="flex items-center justify-between mb-6">
            <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest">Riwayat Generasi AI</h3>
            <button @click="fetchHistory" class="text-slate-400 hover:text-orange-500 transition-colors">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>
            </button>
          </div>

          <div v-if="loadingHistory" class="flex items-center justify-center py-20 text-slate-400">
            <svg class="animate-spin w-8 h-8 text-orange-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
          </div>
          
          <div v-else-if="history.length === 0" class="flex flex-col items-center justify-center py-20 text-center">
            <div class="w-24 h-24 bg-slate-50 text-slate-300 rounded-full flex items-center justify-center text-4xl mb-4">🪄</div>
            <p class="text-slate-500 font-bold mb-1">Belum Ada Hasil AI</p>
            <p class="text-xs text-slate-400 max-w-xs">Gunakan panel di sebelah kiri untuk mulai menghasilkan foto produk yang menakjubkan.</p>
          </div>

          <div v-else class="space-y-8">
            <div v-for="item in history" :key="item.id" class="border-b border-slate-100 pb-8 last:border-0 relative group">
              <button @click="deleteHistory(item.id)" class="absolute top-0 right-0 w-8 h-8 bg-red-50 text-red-500 rounded-lg flex items-center justify-center hover:bg-red-500 hover:text-white transition-colors opacity-0 group-hover:opacity-100 z-10">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
              </button>
              
              <div class="flex items-start gap-4 mb-4">
                <img :src="item.original_image_url" class="w-16 h-16 rounded-xl object-cover bg-slate-100 border border-slate-200" />
                <div>
                  <p class="text-[10px] text-slate-400 uppercase tracking-widest font-bold">{{ formatDate(item.created_at) }}</p>
                  <p class="text-sm font-bold text-slate-700 italic mt-1 line-clamp-2">"{{ item.prompt }}"</p>
                </div>
              </div>
              
              <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div v-for="(img, idx) in item.generated_images" :key="idx" class="relative aspect-square rounded-2xl overflow-hidden group/img cursor-pointer">
                  <img :src="img" class="w-full h-full object-cover group-hover/img:scale-110 transition-transform duration-700" />
                  <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 to-transparent opacity-0 group-hover/img:opacity-100 transition-opacity flex items-end p-4">
                    <button class="bg-white text-slate-900 text-[10px] font-black uppercase tracking-widest px-3 py-1.5 rounded-lg w-full hover:bg-orange-500 hover:text-white transition-colors">Gunakan Ini</button>
                  </div>
                </div>
              </div>
            </div>
            
            <div v-if="pagination.last_page > 1" class="flex justify-center pt-4">
              <button v-if="pagination.current_page < pagination.last_page" @click="fetchHistory(pagination.current_page + 1)" class="text-xs font-bold text-orange-600 hover:text-orange-700 uppercase tracking-widest">
                Muat Lebih Banyak...
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';

const previewUrl = ref(null);
const fileInput = ref(null);
const isGenerating = ref(false);
const loadingHistory = ref(true);
const history = ref([]);
const pagination = ref({ current_page: 1, last_page: 1 });

const form = ref({
  original_image_url: '',
  prompt: ''
});

// Mock simulation for image upload
const handleFileChange = (e) => {
  const file = e.target.files[0];
  if (file) {
    previewUrl.value = URL.createObjectURL(file);
    // Di aplikasi aslinya, kita akan upload ke storage (seperti S3) lalu ambil URL aslinya.
    // Di sini kita simulasi pakai gambar statis dari unsplash agar tidak error validasi URL dari backend.
    form.value.original_image_url = `https://images.unsplash.com/photo-1542291026-7eec264c27ff?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80`;
  }
};

const fetchHistory = async (page = 1) => {
  if (page === 1) loadingHistory.value = true;
  try {
    const token = localStorage.getItem('token');
    const res = await fetch(`/api/v1/umkm/ai-generations?page=${page}`, {
      headers: { 'Authorization': `Bearer ${token}` }
    });
    if (res.ok) {
      const data = await res.json();
      if (page === 1) {
        history.value = data.data;
      } else {
        history.value = [...history.value, ...data.data];
      }
      pagination.value = data.pagination;
    }
  } finally {
    loadingHistory.value = false;
  }
};

const generateAI = async () => {
  if (!form.value.original_image_url) {
    alert('Harap unggah atau masukkan URL gambar asli.');
    return;
  }
  
  isGenerating.value = true;
  
  // Simulasi proses AI rendering (delay 3 detik)
  setTimeout(async () => {
    // Generate mock images array
    const mockGeneratedImages = [
      `https://images.unsplash.com/photo-1505740420928-5e560c06d30e?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80&sig=${Math.random()}`,
      `https://images.unsplash.com/photo-1523275335684-37898b6baf30?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80&sig=${Math.random()}`,
      `https://images.unsplash.com/photo-1542291026-7eec264c27ff?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80&sig=${Math.random()}`,
      `https://images.unsplash.com/photo-1608231387042-66d1773070a5?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80&sig=${Math.random()}`
    ];
    
    try {
      const token = localStorage.getItem('token');
      const res = await fetch('/api/v1/umkm/ai-generations', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'Authorization': `Bearer ${token}`
        },
        body: JSON.stringify({
          original_image_url: form.value.original_image_url,
          prompt: form.value.prompt || 'Professional product photography studio lighting',
          generated_images: mockGeneratedImages
        })
      });
      
      if (res.ok) {
        // Reset form
        previewUrl.value = null;
        form.value.original_image_url = '';
        form.value.prompt = '';
        
        // Reload history
        fetchHistory(1);
      } else {
        alert('Gagal menyimpian riwayat generasi AI.');
      }
    } catch (e) {
      console.error(e);
      alert('Terjadi kesalahan jaringan.');
    } finally {
      isGenerating.value = false;
    }
  }, 3000);
};

const deleteHistory = async (id) => {
  if (!confirm('Hapus riwayat AI ini?')) return;
  try {
    const token = localStorage.getItem('token');
    const res = await fetch(`/api/v1/umkm/ai-generations/${id}`, {
      method: 'DELETE',
      headers: { 'Authorization': `Bearer ${token}` }
    });
    if (res.ok) {
      fetchHistory(1);
    }
  } catch (error) {
    console.error(error);
  }
};

const formatDate = (dateString) => {
  if (!dateString) return '-';
  const date = new Date(dateString);
  return new Intl.DateTimeFormat('id-ID', { day: '2-digit', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit' }).format(date);
};

onMounted(() => {
  fetchHistory();
});
</script>
