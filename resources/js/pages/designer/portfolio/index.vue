<template>
  <div class="space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-700 w-full">
    <!-- Header -->
    <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
      <div>
        <h2 class="text-2xl font-bold text-slate-800 tracking-tight">Portofolio Desain</h2>
        <p class="text-sm text-slate-500 font-medium mt-1">Showcase karya terbaik Anda kepada UMKM</p>
      </div>
      <button @click="showUploadModal = true" class="px-6 py-3.5 bg-orange-500 hover:bg-orange-600 text-white text-[10px] font-bold uppercase tracking-wider rounded-2xl transition-all shadow-sm flex items-center gap-2 active:scale-95">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
        Tambah Karya
      </button>
    </div>

    <!-- Stats Bar -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
      <div v-for="s in portfolioStats" :key="s.label" class="bg-white rounded-2xl border border-slate-200 p-4 flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl flex items-center justify-center text-lg" :class="s.bgClass">{{ s.emoji }}</div>
        <div>
          <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">{{ s.label }}</p>
          <p class="text-xl font-bold text-slate-800">{{ s.value }}</p>
        </div>
      </div>
    </div>

    <!-- Category Filter -->
    <div class="flex items-center gap-2 overflow-x-auto no-scrollbar pb-1">
      <button v-for="cat in categories" :key="cat" @click="activeCategory = cat"
        class="px-4 py-2.5 text-[10px] font-bold uppercase tracking-wider rounded-xl transition-all whitespace-nowrap border"
        :class="activeCategory === cat ? 'bg-orange-500 text-white border-orange-500 shadow-sm shadow-orange-500/20' : 'bg-white text-slate-500 border-slate-200 hover:border-orange-200 hover:text-orange-600'">
        {{ cat }}
      </button>
    </div>

    <!-- Portfolio Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
      <div v-for="item in filteredPortfolio" :key="item.id"
        class="bg-white rounded-2xl border border-slate-200/60 overflow-hidden group hover:shadow-lg transition-all duration-500 cursor-pointer">
        <!-- Image -->
        <div class="relative h-56 bg-slate-100 overflow-hidden">
          <img :src="item.image" :alt="item.title" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" />
          <!-- Overlay on Hover -->
          <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-5">
            <div class="flex items-center gap-3">
              <button class="w-10 h-10 bg-white/20 backdrop-blur-md rounded-xl flex items-center justify-center text-white hover:bg-white/30 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
              </button>
              <button class="w-10 h-10 bg-white/20 backdrop-blur-md rounded-xl flex items-center justify-center text-white hover:bg-white/30 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" /></svg>
              </button>
            </div>
          </div>
          <!-- Category Badge -->
          <span class="absolute top-4 left-4 px-3 py-1.5 bg-white/90 backdrop-blur-md text-[9px] font-bold uppercase tracking-wider text-orange-600 rounded-xl">{{ item.category }}</span>
        </div>
        <!-- Content -->
        <div class="p-5">
          <h3 class="text-base font-bold text-slate-800 mb-1 truncate group-hover:text-orange-600 transition-colors">{{ item.title }}</h3>
          <p class="text-xs text-slate-500 font-medium mb-4 line-clamp-2 leading-relaxed">{{ item.description }}</p>
          <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
              <div class="flex items-center gap-1 text-xs text-slate-400 font-medium">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                {{ item.views }}
              </div>
              <div class="flex items-center gap-1 text-xs text-slate-400 font-medium">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" /></svg>
                {{ item.likes }}
              </div>
            </div>
            <span class="text-[10px] font-medium text-slate-400">{{ item.date }}</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Upload Modal -->
    <Teleport to="body">
      <Transition name="fade">
        <div v-if="showUploadModal" class="fixed inset-0 bg-black/40 backdrop-blur-sm z-50 flex items-center justify-center p-4" @click.self="showUploadModal = false">
          <div class="bg-white rounded-2xl w-full max-w-lg p-8 shadow-2xl">
            <div class="flex items-center justify-between mb-6">
              <h3 class="text-lg font-bold text-slate-800">Tambah Karya Baru</h3>
              <button @click="showUploadModal = false" class="w-8 h-8 rounded-xl bg-slate-100 hover:bg-slate-200 flex items-center justify-center text-slate-500 transition-colors">✕</button>
            </div>
            <div class="space-y-5">
              <div>
                <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-2">Judul Karya</label>
                <input type="text" placeholder="Nama project / desain" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-3.5 text-sm font-medium text-slate-800 outline-none focus:ring-4 focus:ring-orange-500/10 focus:border-orange-500 transition-all" />
              </div>
              <div>
                <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-2">Kategori</label>
                <select class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-3.5 text-sm font-medium text-slate-800 outline-none focus:ring-4 focus:ring-orange-500/10 focus:border-orange-500 transition-all cursor-pointer">
                  <option v-for="c in categories.filter(c => c !== 'Semua')" :key="c">{{ c }}</option>
                </select>
              </div>
              <div>
                <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-2">Deskripsi</label>
                <textarea rows="3" placeholder="Ceritakan tentang karya ini..." class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-3.5 text-sm font-medium text-slate-800 outline-none focus:ring-4 focus:ring-orange-500/10 focus:border-orange-500 transition-all resize-none"></textarea>
              </div>
              <div>
                <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-2">Upload Gambar</label>
                <div class="border-2 border-dashed border-slate-200 rounded-2xl p-8 text-center hover:border-orange-300 transition-colors cursor-pointer">
                  <div class="text-3xl mb-2">🖼️</div>
                  <p class="text-sm font-bold text-slate-600">Drag & drop atau klik untuk upload</p>
                  <p class="text-xs text-slate-400 font-medium mt-1">PNG, JPG, WebP · Max 5MB</p>
                </div>
              </div>
              <button class="w-full bg-orange-500 text-white py-4 rounded-2xl text-[10px] font-bold uppercase tracking-wider hover:from-orange-700 hover:to-amber-600 transition-all shadow-sm active:scale-[0.98]">
                Simpan Karya
              </button>
            </div>
          </div>
        </div>
      </Transition>
    </Teleport>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';

const showUploadModal = ref(false);
const activeCategory = ref('Semua');
const categories = ['Semua', 'Packaging', 'Branding', 'Social Media', 'Logo', 'Illustration', 'Photo'];

const portfolioStats = [
  { label: 'Total Karya', value: 12, emoji: '🎨', bgClass: 'bg-orange-50' },
  { label: 'Total Views', value: '2.4K', emoji: '👁️', bgClass: 'bg-blue-50' },
  { label: 'Total Likes', value: 186, emoji: '❤️', bgClass: 'bg-pink-50' },
  { label: 'Rata-rata Rating', value: '4.8', emoji: '⭐', bgClass: 'bg-amber-50' },
];

const portfolio = ref([
  { id: 1, title: 'Packaging Batik Tulis Premium', description: 'Desain kemasan premium untuk Batik Sari Malang dengan sentuhan modern dan elegan.', category: 'Packaging', image: 'https://images.unsplash.com/photo-1636955816868-fcb881e57954?q=80&w=600&auto=format&fit=crop', views: 342, likes: 28, date: 'Mei 2026' },
  { id: 2, title: 'Brand Identity Rotan Craft', description: 'Logo, color palette, dan panduan visual untuk brand kerajinan rotan artisanal.', category: 'Branding', image: 'https://images.unsplash.com/photo-1558655146-9f40138edfeb?q=80&w=600&auto=format&fit=crop', views: 267, likes: 31, date: 'Apr 2026' },
  { id: 3, title: 'Instagram Kit Kopi Arjuno', description: 'Template visual untuk Instagram feed, story, dan carousel highlight brand kopi lokal.', category: 'Social Media', image: 'https://images.unsplash.com/photo-1611162617474-5b21e879e113?q=80&w=600&auto=format&fit=crop', views: 456, likes: 42, date: 'Apr 2026' },
  { id: 4, title: 'Logo Kampoeng Keramik', description: 'Redesign logo untuk sentra kerajinan keramik Dinoyo Malang.', category: 'Logo', image: 'https://images.unsplash.com/photo-1626785774573-4b799315345d?q=80&w=600&auto=format&fit=crop', views: 198, likes: 15, date: 'Mar 2026' },
  { id: 5, title: 'Product Catalog Digital', description: 'Katalog produk digital interaktif untuk Anyaman Bamboo Batu.', category: 'Branding', image: 'https://images.unsplash.com/photo-1586717799252-bd134571b7e0?q=80&w=600&auto=format&fit=crop', views: 312, likes: 24, date: 'Mar 2026' },
  { id: 6, title: 'Packaging Kripik Tempe', description: 'Kemasan standing pouch dengan desain vintage-modern untuk produk kripik tempe.', category: 'Packaging', image: 'https://images.unsplash.com/photo-1605000797499-95a51c5269ae?q=80&w=600&auto=format&fit=crop', views: 423, likes: 38, date: 'Feb 2026' },
]);

const filteredPortfolio = computed(() => {
  if (activeCategory.value === 'Semua') return portfolio.value;
  return portfolio.value.filter(p => p.category === activeCategory.value);
});
</script>

<style scoped>
.no-scrollbar::-webkit-scrollbar { display: none; }
.no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
.fade-enter-active, .fade-leave-active { transition: all 0.3s ease; }
.fade-enter-from, .fade-leave-to { opacity: 0; }
</style>
