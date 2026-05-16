<template>
  <div class="space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-700">
    <!-- Header -->
    <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl p-6 text-white relative overflow-hidden">
      <div class="absolute -right-6 -top-6 w-24 h-24 bg-white/10 rounded-full blur-xl"></div>
      <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-5">
        <div>
          <h2 class="text-xl font-bold tracking-tight mb-1">AI Product Studio ✨</h2>
          <p class="text-white/80 text-[13px] max-w-lg font-medium">Ubah foto produk biasamu menjadi luar biasa. Cukup unggah foto mentah, masukkan instruksi, dan biarkan AI memberikan analisis & referensi profesional.</p>
        </div>
      </div>
    </div>

    <!-- API Status Notice -->
    <div class="bg-emerald-50 border-l-4 border-emerald-500 rounded-xl p-4 flex items-start gap-3">
      <svg class="w-5 h-5 text-emerald-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
      </svg>
      <div>
        <p class="text-sm font-bold text-emerald-900 mb-1">✨ AI Aktif - Siap Menganalisis & Mengarahkan Gaya Produk Anda</p>
        <p class="text-xs text-emerald-700 mb-2">Sistem terhubung dengan <strong>OpenRouter AI (Gemini Vision)</strong>. AI akan menganalisis produk Anda secara visual dan memberikan rekomendasi serta caption profesional.</p>
        <div class="flex items-center gap-2 text-xs text-emerald-600">
          <span class="flex items-center gap-1">
            <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
            OpenRouter Active
          </span>
        </div>
      </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
      <!-- Workspace Form -->
      <div class="lg:col-span-1 space-y-6">
        <form @submit.prevent="generateAI" class="bg-white rounded-2xl border border-slate-100 p-6 shadow-[0_8px_30px_rgb(0,0,0,0.02)] space-y-6">
          
          <!-- Image Upload Area -->
          <div>
            <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-2 ml-1">Foto Asli Produk</label>
            <div class="border-2 border-dashed border-slate-200 rounded-2xl p-6 text-center hover:border-orange-400 hover:bg-orange-50 transition-colors cursor-pointer" @click="$refs.fileInput.click()">
              <input type="file" ref="fileInput" @change="handleFileChange" accept="image/*" class="hidden" />
              <div v-if="previewUrl" class="relative">
                <img :src="previewUrl" class="w-full h-40 object-cover rounded-xl" />
                <button @click.stop="clearFile" class="absolute top-2 right-2 w-8 h-8 bg-slate-900/50 backdrop-blur-sm text-white rounded-lg flex items-center justify-center hover:bg-red-500 transition-colors">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
              </div>
              <div v-else class="space-y-2 py-4">
                <div class="w-12 h-12 bg-orange-100 text-orange-600 rounded-full flex items-center justify-center mx-auto">
                  <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                </div>
                <p class="text-sm font-bold text-slate-600">Klik untuk unggah foto</p>
                <p class="text-[10px] text-slate-400 uppercase tracking-wider">JPG, PNG, WEBP (Max 5MB)</p>
              </div>
            </div>
            
            <div class="mt-4 flex items-center gap-3 before:flex-1 before:h-px before:bg-slate-100 after:flex-1 after:h-px after:bg-slate-100">
               <span class="text-[10px] font-bold text-slate-300 uppercase tracking-widest">ATAU</span>
            </div>

            <div class="mt-4">
               <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-2 ml-1">Gunakan URL Gambar</label>
               <input v-model="form.original_image_url" type="url" placeholder="https://contoh.com/foto.jpg" class="w-full bg-slate-50 border-none rounded-xl px-4 py-3 text-sm font-bold text-slate-800 outline-none focus:ring-2 focus:ring-orange-200 transition-all" />
            </div>
          </div>

          <!-- Prompt Input -->
          <div>
            <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-2 ml-1">Kebutuhan / Konsep (Opsional)</label>
            <textarea v-model="form.prompt" rows="3" placeholder="Contoh: Tolong buatkan konsep foto yang elegan untuk tas kulit ini agar cocok diposting di Instagram saat Hari Raya..." class="w-full bg-slate-50 border-none rounded-xl px-4 py-3 text-sm font-medium text-slate-800 outline-none focus:ring-2 focus:ring-orange-200 transition-all resize-none"></textarea>
            
            <!-- Quick Prompts -->
            <div class="flex flex-wrap gap-2 mt-3">
              <button type="button" @click="form.prompt = 'Tolong berikan arahan gaya foto minimalis dan elegan'" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-lg text-[10px] font-bold transition-colors">Minimalis</button>
              <button type="button" @click="form.prompt = 'Tolong buatkan konsep foto yang ceria, terang, dan menonjolkan warna produk'" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-lg text-[10px] font-bold transition-colors">Vibrant</button>
              <button type="button" @click="form.prompt = 'Tolong berikan referensi gaya foto aesthetic hangat (warm tone)'" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-lg text-[10px] font-bold transition-colors">Aesthetic Hangat</button>
            </div>
          </div>

          <!-- Submit Button -->
          <button type="submit" :disabled="isGenerating || (!selectedFile && !form.original_image_url)" class="w-full bg-slate-900 hover:bg-black text-white px-6 py-4 rounded-xl text-xs font-bold tracking-wider uppercase transition-all shadow-lg shadow-slate-900/20 disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2">
            <svg v-if="isGenerating" class="animate-spin w-4 h-4 text-orange-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
            {{ isGenerating ? 'AI Sedang Menganalisis...' : 'Mulai Analisis AI' }}
          </button>
        </form>
      </div>

      <!-- Generated Results Gallery -->
      <div class="lg:col-span-2">
        <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-[0_8px_30px_rgb(0,0,0,0.02)] min-h-full">
          <div class="flex items-center justify-between mb-6">
            <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider">Riwayat Analisis AI</h3>
            <button @click="fetchHistory(1)" class="text-slate-400 hover:text-orange-500 transition-colors">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>
            </button>
          </div>

          <div v-if="loadingHistory" class="flex items-center justify-center py-20 text-slate-400">
            <svg class="animate-spin w-8 h-8 text-orange-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
          </div>
          
          <div v-else-if="history.length === 0" class="flex flex-col items-center justify-center py-20 text-center">
            <div class="w-24 h-24 bg-slate-50 text-slate-300 rounded-full flex items-center justify-center text-4xl mb-4">🪄</div>
            <p class="text-slate-500 font-bold mb-1">Belum Ada Analisis AI</p>
            <p class="text-xs text-slate-400 max-w-xs">Gunakan panel di sebelah kiri untuk mulai mendapatkan analisis dan arahan kreatif untuk produk Anda.</p>
          </div>

          <div v-else class="space-y-12">
            <div v-for="item in history" :key="item.id" class="border-b border-slate-100 pb-12 last:border-0 relative group">
              <button @click="deleteHistory(item.id)" class="absolute top-0 right-0 w-8 h-8 bg-red-50 text-red-500 rounded-lg flex items-center justify-center hover:bg-red-500 hover:text-white transition-colors opacity-0 group-hover:opacity-100 z-10" title="Hapus riwayat">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
              </button>
              
              <div class="flex flex-col sm:flex-row items-start gap-6 mb-6">
                <!-- Original Image -->
                <div class="w-full sm:w-48 shrink-0 relative rounded-xl overflow-hidden border border-slate-200 bg-slate-50">
                  <div class="absolute top-2 left-2 bg-black/60 backdrop-blur-md text-white text-[9px] font-bold uppercase px-2 py-1 rounded-md">Original</div>
                  <img :src="item.original_image_url" class="w-full h-auto aspect-square object-contain" />
                </div>
                
                <!-- Content -->
                <div class="flex-1 w-full min-w-0">
                  <div class="flex items-center gap-3 mb-2">
                    <span class="bg-orange-100 text-orange-700 px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider">Report</span>
                    <span class="text-[10px] text-slate-400 uppercase tracking-wider font-bold">{{ formatDate(item.created_at) }}</span>
                  </div>
                  
                  <p v-if="item.prompt" class="text-sm font-bold text-slate-700 italic mb-4 bg-slate-50 p-3 rounded-lg border border-slate-100 border-l-4 border-l-orange-400">
                    "{{ item.prompt }}"
                  </p>
                  
                  <!-- Markdown Analysis -->
                  <div class="prose prose-sm max-w-none prose-orange prose-headings:font-bold prose-a:text-orange-600 prose-img:rounded-xl">
                    <div v-html="renderMarkdown(item.ai_analysis || '*Tidak ada analisis dari AI.*')"></div>
                  </div>
                  
                  <!-- Mock image inspirations (if they exist) -->
                  <div v-if="item.generated_images && item.generated_images.length > 0" class="mt-8">
                     <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-3">Contoh Referensi Hasil</h4>
                     <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div v-for="(img, idx) in item.generated_images" :key="idx" class="relative aspect-square rounded-xl overflow-hidden group/img cursor-pointer border border-slate-100">
                           <img :src="img" class="w-full h-full object-cover group-hover/img:scale-110 transition-transform duration-700" />
                        </div>
                     </div>
                  </div>
                </div>
              </div>
            </div>
            
            <div v-if="pagination.last_page > 1" class="flex justify-center pt-4">
              <button v-if="pagination.current_page < pagination.last_page" @click="fetchHistory(pagination.current_page + 1)" class="text-xs font-bold text-orange-600 hover:text-orange-700 uppercase tracking-wider">
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
import { marked } from 'marked';

const previewUrl = ref(null);
const fileInput = ref(null);
const selectedFile = ref(null);
const isGenerating = ref(false);
const loadingHistory = ref(true);
const history = ref([]);
const pagination = ref({ current_page: 1, last_page: 1 });

const form = ref({
  original_image_url: '',
  prompt: ''
});

// Setup marked options for safe rendering
marked.setOptions({
  gfm: true,
  breaks: true
});

const renderMarkdown = (text) => {
  return marked.parse(text || '');
};

const handleFileChange = (e) => {
  const file = e.target.files[0];
  if (file) {
    if (file.size > 5 * 1024 * 1024) {
      alert('Ukuran file terlalu besar. Maksimal 5MB.');
      return;
    }
    selectedFile.value = file;
    previewUrl.value = URL.createObjectURL(file);
    form.value.original_image_url = ''; // reset URL if file is selected
  }
};

const clearFile = () => {
  selectedFile.value = null;
  previewUrl.value = null;
  if (fileInput.value) {
    fileInput.value.value = '';
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

const uploadFile = async () => {
  const token = localStorage.getItem('token');
  const formData = new FormData();
  formData.append('image', selectedFile.value);
  
  const res = await fetch('/api/v1/upload/ai-source', {
    method: 'POST',
    headers: {
      'Authorization': `Bearer ${token}`,
      'Accept': 'application/json'
    },
    body: formData
  });
  
  if (!res.ok) {
    const error = await res.json();
    throw new Error(error.message || 'Gagal mengupload gambar');
  }
  
  const data = await res.json();
  // Karena return dari controller berupa url absolute yang benar, kita bisa pakai ini
  return window.location.origin + data.url; 
};

const generateAI = async () => {
  if (!selectedFile.value && !form.value.original_image_url) {
    alert('Harap unggah atau masukkan URL gambar asli.');
    return;
  }
  
  isGenerating.value = true;
  
  try {
    let finalImageUrl = form.value.original_image_url;
    
    // Upload if there's a file selected
    if (selectedFile.value) {
      finalImageUrl = await uploadFile();
    }
    
    const token = localStorage.getItem('token');
    const res = await fetch('/api/v1/umkm/ai-generations/generate', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'Authorization': `Bearer ${token}`
      },
      body: JSON.stringify({
        original_image_url: finalImageUrl,
        prompt: form.value.prompt || 'Tolong analisis produk ini dan berikan arahan fotografi yang bagus.'
      })
    });
    
    if (res.ok) {
      // Reset form
      clearFile();
      form.value.original_image_url = '';
      form.value.prompt = '';
      
      // Reload history
      await fetchHistory(1);
    } else {
      const error = await res.json();
      alert('Gagal menghasilkan analisis: ' + (error.message || 'Unknown error'));
    }
  } catch (e) {
    console.error(e);
    alert(e.message || 'Terjadi kesalahan saat memproses data.');
  } finally {
    isGenerating.value = false;
  }
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

<style>
/* Prose overrides for better markdown styling */
.prose h1, .prose h2, .prose h3 {
  margin-top: 1.5em;
  margin-bottom: 0.5em;
  line-height: 1.3;
}
.prose p {
  margin-top: 0.5em;
  margin-bottom: 0.5em;
}
.prose ul, .prose ol {
  margin-top: 0.5em;
  margin-bottom: 0.5em;
  padding-left: 1.5em;
}
.prose li {
  margin-top: 0.25em;
  margin-bottom: 0.25em;
}
.prose strong {
  color: #334155;
}
</style>
