<template>
  <div class="min-h-screen bg-white text-gray-900 font-sans selection:bg-orange-100 overflow-x-hidden">
    <header class="sticky top-0 z-50 bg-white/80 backdrop-blur-xl border-b border-orange-50">
      <nav class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 bg-gradient-to-br from-orange-600 to-amber-400 rounded-xl shadow-lg shadow-orange-200 flex items-center justify-center">
            <span class="text-white font-black text-xl italic">S</span>
          </div>
          <div>
            <h1 class="font-black text-xl tracking-tight text-gray-900 leading-none">SnapFit</h1>
            <p class="text-[8px] font-bold tracking-[0.3em] text-orange-500 uppercase mt-1">Creative Economy Hub</p>
          </div>
        </div>

        <div class="hidden md:flex gap-10 text-[11px] font-black uppercase tracking-[0.2em] text-gray-400">
          <a href="#marketplace" class="hover:text-orange-600 transition-colors">Marketplace</a>
          <a href="#features" class="hover:text-orange-600 transition-colors">AI Studio</a>
          <a href="#features" class="hover:text-orange-600 transition-colors">Co-Create</a>
          <a href="#features" class="hover:text-orange-600 transition-colors">AR Experience</a>
        </div>

        <div class="flex items-center gap-6">
          <template v-if="isLoggedIn">
            <div class="flex items-center gap-4 border-l pl-6 border-gray-100 relative user-menu">
              <div class="text-right hidden sm:block">
                <p class="text-xs font-black text-gray-900 leading-none">{{ user.name }}</p>
                <p class="text-[9px] text-orange-500 font-bold uppercase tracking-tighter mt-1">Premium Member</p>
              </div>
              
              <button 
                @click="toggleUserMenu" 
                class="w-10 h-10 rounded-full bg-gradient-to-tr from-orange-500 to-amber-400 flex items-center justify-center text-white font-bold shadow-md hover:scale-105 transition-transform"
              >
                {{ user.name.charAt(0).toUpperCase() }}
              </button>

              <div v-if="showUserMenu" class="absolute right-0 top-full mt-4 w-52 bg-white rounded-2xl shadow-2xl border border-gray-50 py-3 z-50 animate-in fade-in zoom-in duration-200">
                <div class="px-5 py-2 border-b border-gray-50 mb-2">
                  <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest leading-none">Account Settings</p>
                </div>
                <button @click="goToProfile" class="w-full text-left px-5 py-2.5 text-xs font-bold hover:bg-orange-50 transition">👤 User Profile</button>
                <button @click="goToOrders" class="w-full text-left px-5 py-2.5 text-xs font-bold hover:bg-orange-50 transition">📦 My History</button>
                <button @click="logout" class="w-full text-left px-5 py-2.5 text-xs font-black text-red-500 hover:bg-red-50 transition mt-2 border-t border-gray-50 pt-3">🚪 Sign Out</button>
              </div>
            </div>
          </template>
          
          <button v-else @click="goToLogin" class="bg-gray-900 text-white px-7 py-2.5 rounded-full text-xs font-black uppercase tracking-widest hover:bg-orange-600 transition-all shadow-xl shadow-gray-200">
            Sign In
          </button>
        </div>
      </nav>
    </header>

    <main>
      <section class="max-w-7xl mx-auto px-6 py-24">
        <div class="grid lg:grid-cols-2 gap-16 items-center">
          <div class="animate-in fade-in slide-in-from-left-8 duration-1000">
            <div class="inline-flex items-center gap-3 bg-orange-50 text-orange-600 px-5 py-2 rounded-full text-[10px] font-black uppercase tracking-[0.2em] mb-8">
              <span class="w-2 h-2 bg-orange-500 rounded-full animate-pulse"></span>
              Malang Local Innovation 4.0
            </div>
            
            <h1 class="text-6xl md:text-7xl font-black leading-[0.95] mb-8 text-gray-900 tracking-tighter">
              Empowering <br/>
              <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-600 to-amber-500">Malang Creative</span><br/>
              Legacy.
            </h1>
            
            <p class="text-gray-500 text-xl mb-10 max-w-lg leading-relaxed font-medium">
              SnapFit (KreatiLink) menjembatani pengrajin lokal Malang dengan teknologi <span class="text-gray-900 font-bold underline decoration-orange-300">AI, AR, dan Real-time Collaboration</span>. 
            </p>

            <div class="flex flex-wrap gap-5">
              <button class="bg-gray-900 text-white px-10 py-5 rounded-2xl shadow-2xl hover:bg-orange-600 hover:-translate-y-1 transition duration-300 font-black uppercase tracking-widest text-xs">
                Explore Marketplace
              </button>
              <button class="bg-white border-2 border-gray-100 text-gray-900 px-10 py-5 rounded-2xl hover:bg-gray-50 transition duration-300 font-black uppercase tracking-widest text-xs">
                Join as Creator
              </button>
            </div>
          </div>

          <div class="relative animate-in fade-in zoom-in duration-1000">
            <div class="aspect-square bg-gradient-to-br from-orange-50 to-amber-50 rounded-[4rem] border-2 border-white shadow-inner flex items-center justify-center relative overflow-hidden">
                <div class="absolute top-10 left-10 bg-white/90 backdrop-blur-md p-6 rounded-3xl shadow-xl border border-white z-20 animate-bounce-slow">
                   <div class="flex items-center gap-3 mb-3">
                     <div class="w-8 h-8 bg-orange-500 rounded-lg flex items-center justify-center text-white text-xs font-bold italic">AI</div>
                     <p class="text-[10px] font-black uppercase tracking-tighter">AI Studio Active</p>
                   </div>
                   <div class="w-32 h-2 bg-gray-100 rounded-full overflow-hidden">
                     <div class="w-2/3 h-full bg-orange-500"></div>
                   </div>
                </div>

                <div class="absolute bottom-20 right-10 bg-gray-900 text-white p-5 rounded-3xl shadow-2xl z-20">
                   <p class="text-[9px] font-bold text-orange-400 uppercase tracking-widest mb-1">Live Preview</p>
                   <p class="text-sm font-black italic">Web AR Try-On ✨</p>
                </div>

                <div class="w-64 h-64 bg-white rounded-[3rem] shadow-2xl flex items-center justify-center relative group overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1590736961958-51fd161031f3?q=80&w=1000&auto=format&fit=crop" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110 opacity-80" />
                    <div class="absolute inset-0 bg-orange-600/10 group-hover:bg-transparent transition-colors"></div>
                </div>
            </div>
          </div>
        </div>
      </section>

      <section id="features" class="py-24 bg-gray-50">
        <div class="max-w-7xl mx-auto px-6">
          <div class="grid md:grid-cols-3 gap-10">
            <div class="bg-white p-10 rounded-[3.5rem] shadow-sm hover:shadow-2xl transition-all group border border-transparent hover:border-orange-100">
               <div class="w-16 h-16 bg-orange-50 text-orange-600 rounded-2xl flex items-center justify-center mb-8 group-hover:bg-orange-600 group-hover:text-white transition-colors duration-500">
                 <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" stroke-width="2" /></svg>
               </div>
               <h3 class="text-2xl font-black mb-4 tracking-tighter">AI Product Studio</h3>
               <p class="text-gray-500 text-sm leading-relaxed mb-6">Ubah foto HP menjadi katalog studio profesional secara otomatis. AI kami menangani lighting, video 360°, dan copy marketing untuk Anda.</p>
               <span class="text-[10px] font-black text-orange-600 uppercase tracking-widest group-hover:underline">Launch Studio →</span>
            </div>

            <div class="bg-white p-10 rounded-[3.5rem] shadow-sm hover:shadow-2xl transition-all group border border-transparent hover:border-orange-100">
               <div class="w-16 h-16 bg-amber-50 text-amber-600 rounded-2xl flex items-center justify-center mb-8 group-hover:bg-amber-600 group-hover:text-white transition-colors duration-500">
                 <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" stroke-width="2" /><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" stroke-width="2" /></svg>
               </div>
               <h3 class="text-2xl font-black mb-4 tracking-tighter">Web AR Try-On</h3>
               <p class="text-gray-500 text-sm leading-relaxed mb-6">Tingkatkan kepercayaan pembeli. Mereka bisa mencoba batik atau aksesoris langsung lewat browser tanpa perlu instal aplikasi tambahan.</p>
               <span class="text-[10px] font-black text-amber-600 uppercase tracking-widest group-hover:underline">Try it now →</span>
            </div>

            <div class="bg-white p-10 rounded-[3.5rem] shadow-sm hover:shadow-2xl transition-all group border border-transparent hover:border-orange-100">
               <div class="w-16 h-16 bg-gray-900 text-white rounded-2xl flex items-center justify-center mb-8 group-hover:bg-orange-600 transition-colors duration-500">
                 <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" stroke-width="2" /></svg>
               </div>
               <h3 class="text-2xl font-black mb-4 tracking-tighter">Co-Create Room</h3>
               <p class="text-gray-500 text-sm leading-relaxed mb-6">Kolaborasi UMKM & Desainer Malang secara real-time. Seperti Figma, tapi didesain khusus untuk pengembangan produk fisik.</p>
               <span class="text-[10px] font-black text-gray-900 uppercase tracking-widest group-hover:underline">Enter Room →</span>
            </div>
          </div>
        </div>
      </section>

      <section id="marketplace" class="py-24 bg-white border-t border-gray-50">
        <div class="max-w-7xl mx-auto px-6">
          <div class="flex flex-col md:flex-row justify-between items-center mb-16 gap-8">
            <div>
              <h2 class="text-4xl font-black tracking-tighter uppercase">Malang Local Marketplace</h2>
              <p class="text-gray-400 font-medium mt-2 italic">Koleksi terkurasi dari pengrajin terbaik bumi Arema.</p>
            </div>
            
            <div class="flex gap-2 bg-gray-50 p-2 rounded-2xl border border-gray-100 overflow-x-auto max-w-full no-scrollbar">
              <button 
                v-for="cat in categories" :key="cat"
                @click="activeCategory = cat"
                :class="activeCategory === cat ? 'bg-gray-900 text-white shadow-lg' : 'text-gray-400 hover:text-gray-900'"
                class="px-5 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all whitespace-nowrap"
              >
                {{ cat }}
              </button>
            </div>
          </div>
          
          <div v-if="isLoading" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10">
            <div v-for="i in 4" :key="i" class="animate-pulse">
              <div class="aspect-[4/5] bg-gray-100 rounded-[3rem] mb-4"></div>
              <div class="h-4 bg-gray-100 rounded w-2/3 mb-2"></div>
              <div class="h-4 bg-gray-100 rounded w-1/2"></div>
            </div>
          </div>

          <div v-else class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10">
            <div v-for="product in filteredProducts" :key="product.id" class="group cursor-pointer">
              <div class="aspect-[4/5] bg-gray-50 rounded-[3rem] overflow-hidden relative mb-6 shadow-sm group-hover:shadow-2xl transition-all duration-700">
                 <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                 <div class="absolute top-6 left-6 bg-white/90 backdrop-blur px-4 py-2 rounded-full text-[9px] font-black uppercase tracking-widest shadow-sm z-10 border border-orange-50">
                   {{ product.category }}
                 </div>
                 
                 <button 
                    @click.stop="toggleWishlist(product)"
                    class="absolute top-6 right-6 w-11 h-11 bg-white/90 backdrop-blur-md rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all hover:bg-white active:scale-90 shadow-lg z-10"
                  >
                    <svg class="w-5 h-5" :class="product.inWishlist ? 'text-red-500 fill-current' : 'text-gray-900'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" stroke-width="2" />
                    </svg>
                  </button>

                 <img 
                    :src="product.images && product.images.length ? product.images[0] : 'https://images.unsplash.com/photo-1617627143750-d86bc21e42bb?q=80&w=1000'" 
                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-1000" 
                  />
              </div>
              <h3 class="font-black text-xl mb-1 group-hover:text-orange-600 transition-colors tracking-tighter uppercase italic">
                {{ product.name }}
              </h3>
              <div class="flex justify-between items-center">
                 <p class="text-orange-600 font-black">Rp {{ Number(product.price).toLocaleString('id-ID') }}</p>
                 <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Premium Craft</span>
              </div>
            </div>
          </div>

          <div v-if="!isLoading && filteredProducts.length === 0" class="py-20 text-center border-2 border-dashed border-gray-100 rounded-[3rem]">
            <p class="text-gray-400 font-bold italic">Belum ada koleksi yang dipublikasikan untuk kategori ini.</p>
          </div>
        </div>
      </section>

      <section class="py-24 bg-gray-50/50">
        <div class="max-w-7xl mx-auto px-6">
          <div class="text-center mb-16">
            <h2 class="text-4xl font-black text-gray-900 tracking-tighter mb-4 uppercase">Customer Stories</h2>
            <p class="text-gray-400 font-medium">Verified experiences from our gold members.</p>
          </div>
          <div class="grid md:grid-cols-3 gap-8">
            <div v-for="review in reviews" :key="review.name" class="bg-white p-10 rounded-[3.5rem] border border-gray-50 shadow-sm hover:shadow-xl transition-all group">
              <div class="flex items-center gap-4 mb-6">
                <div class="w-12 h-12 bg-orange-100 rounded-2xl flex items-center justify-center text-orange-600 font-black text-xl group-hover:bg-orange-600 group-hover:text-white transition-colors duration-500">
                  {{ review.name[0] }}
                </div>
                <div>
                  <p class="text-sm font-black text-gray-900">{{ review.name }}</p>
                  <div class="flex gap-0.5 text-amber-500 text-[10px]">★★★★★</div>
                </div>
              </div>
              <p class="text-sm text-gray-500 leading-relaxed italic">"{{ review.text }}"</p>
            </div>
          </div>
        </div>
      </section>

      <section class="m-8 bg-gray-900 rounded-[4rem] py-24 text-center relative overflow-hidden">
        <div class="absolute -top-20 -left-20 w-96 h-96 bg-orange-600/20 rounded-full blur-[100px]"></div>
        <h2 class="text-5xl font-black text-white mb-8 tracking-tighter">Ready to <span class="italic text-orange-500">Go Digital?</span></h2>
        <p class="text-gray-400 max-w-lg mx-auto mb-12 font-medium">Bawa UMKM Anda ke level selanjutnya dengan teknologi AI dan AR tercanggih di Malang.</p>
        <div class="flex flex-wrap justify-center gap-6">
          <button class="bg-white text-gray-900 px-12 py-5 rounded-2xl font-black uppercase tracking-widest text-xs hover:bg-orange-50 transition-all">Daftar UMKM Sekarang</button>
          <button class="bg-transparent border-2 border-white/20 text-white px-12 py-5 rounded-2xl font-black uppercase tracking-widest text-xs hover:bg-white/5 transition-all">Lihat Dokumentasi</button>
        </div>
      </section>
    </main>

    <footer class="py-16 text-center border-t border-gray-50">
       <div class="flex flex-col md:flex-row justify-center items-center gap-6 mb-8">
          <div class="flex items-center gap-2">
            <div class="w-6 h-6 bg-gray-900 rounded flex items-center justify-center"><span class="text-white text-[10px] font-black italic">S</span></div>
            <span class="font-black tracking-tighter text-gray-900">SnapFit Premium Hub</span>
          </div>
          <div class="hidden md:block w-px h-4 bg-gray-200"></div>
          <div class="flex gap-8 text-[10px] font-black text-gray-400 uppercase tracking-widest">
            <a href="#" class="hover:text-orange-500 transition-colors">Privacy</a>
            <a href="#" class="hover:text-orange-500 transition-colors">Terms</a>
            <a href="#" class="hover:text-orange-500 transition-colors">Support</a>
          </div>
       </div>
       <p class="text-[10px] font-black tracking-[0.5em] text-gray-300 uppercase italic">SnapFit x KreatiLink • Malang Creative Economy Hub © 2026</p>
    </footer>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, onBeforeUnmount } from "vue";

/* --- SYSTEM & USER STATE --- */
const user = ref(null);
const isLoggedIn = computed(() => !!user.value);
const showUserMenu = ref(false);

/* --- PRODUCTS & FILTER STATE --- */
const products = ref([]);
const isLoading = ref(false);
const activeCategory = ref('all');
const categories = ['all', 'batik', 'kerajinan', 'aksesoris', 'dekorasi', 'fashion'];

const reviews = [
  { name: 'Andi Pratama', text: 'Produk sangat berkualitas, pengiriman cepat dan packaging rapi. Sangat recommended!' },
  { name: 'Siti Rahma', text: 'Desain produk sangat modern, cocok untuk kemeja batik dan koleksi pribadi saya.' },
  { name: 'Budi Santoso', text: 'UI marketplace ini sangat premium, terasa seperti brand internasional berkelas.' }
];

/* --- API ACTIONS --- */

// Fetch data produk dari backend Laravel
const fetchProducts = async () => {
  isLoading.value = true;
  try {
    // Sesuaikan URL ini dengan route API Laravel kamu
    const response = await fetch('/api/v1/products', {
      method: 'GET',
      headers: { 'Accept': 'application/json' }
    });

    if (!response.ok) throw new Error('Gagal mengambil data produk');
    
    const data = await response.json();
    // Laravel biasanya mengembalikan data dalam properti 'data' jika menggunakan Resource
    const fetched = Array.isArray(data) ? data : (data.data || []);
    
    // Filter hanya yang is_published: true
    products.value = fetched
      .filter(p => p.is_published)
      .map(p => ({
        ...p,
        // Parsing images jika disimpan sebagai string JSON di DB
        images: typeof p.images === 'string' ? JSON.parse(p.images) : p.images,
        inWishlist: false 
      }));
  } catch (error) {
    console.error('Fetch error:', error);
  } finally {
    isLoading.value = false;
  }
};

/* --- NAVIGATION & UI HELPERS --- */
const toggleUserMenu = () => { showUserMenu.value = !showUserMenu.value; };
const goToLogin = () => { window.location.href = '/login'; };
const goToProfile = () => { showUserMenu.value = false; };
const goToOrders = () => { showUserMenu.value = false; };

const logout = async () => {
  // Logic logout kamu (clear localStorage, redirect, dll)
  localStorage.removeItem('user');
  user.value = null;
  window.location.reload();
};

const toggleWishlist = (product) => {
  product.inWishlist = !product.inWishlist;
};

// Logic filtering berdasarkan kategori aktif
const filteredProducts = computed(() => {
  if (activeCategory.value === 'all') return products.value;
  return products.value.filter(p => p.category === activeCategory.value);
});

/* --- LIFECYCLE --- */
onMounted(() => {
  // Simulasi restore session dari localStorage
  const userData = localStorage.getItem('user');
  if (userData) {
    user.value = JSON.parse(userData);
  }

  fetchProducts();

  // Handle klik di luar untuk menutup dropdown menu
  const handleClickOutside = (e) => {
    if (!e.target.closest('.user-menu')) {
      showUserMenu.value = false;
    }
  };
  document.addEventListener('click', handleClickOutside);
});

onBeforeUnmount(() => {
  document.removeEventListener('click', null);
});
</script>

<style scoped>
/* Scrollbar Hider */
.no-scrollbar::-webkit-scrollbar {
  display: none;
}
.no-scrollbar {
  -ms-overflow-style: none;
  scrollbar-width: none;
}

/* Bounce Animation */
@keyframes bounce-slow {
  0%, 100% { transform: translateY(-5%); }
  50% { transform: translateY(0); }
}
.animate-bounce-slow {
  animation: bounce-slow 4s infinite ease-in-out;
}

/* Tailwind Animate Fallbacks */
.animate-in {
  animation-duration: 0.8s;
  animation-fill-mode: both;
}
@keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
@keyframes slideInLeft { from { transform: translateX(-30px); opacity: 0; } to { transform: translateX(0); opacity: 1; } }
@keyframes zoomIn { from { transform: scale(0.95); opacity: 0; } to { transform: scale(1); opacity: 1; } }

.fade-in { animation-name: fadeIn; }
.slide-in-from-left-8 { animation-name: slideInLeft; }
.zoom-in { animation-name: zoomIn; }
</style>