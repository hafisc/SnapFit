<template>
  <div class="min-h-screen bg-white text-gray-900 font-sans selection:bg-orange-100">
    <header class="sticky top-0 z-50 bg-white/80 backdrop-blur-xl border-b border-orange-50">
      <nav class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 bg-gradient-to-br from-orange-600 to-amber-400 rounded-xl shadow-lg shadow-orange-200 flex items-center justify-center">
            <span class="text-white font-black text-xl italic">S</span>
          </div>
          <div>
            <h1 class="font-black text-xl tracking-tight text-gray-900">SnapFit</h1>
            <p class="text-[9px] font-bold tracking-[0.2em] text-orange-500 uppercase">Premium Edge</p>
          </div>
        </div>

        <div class="hidden md:flex gap-10 text-sm font-semibold text-gray-500">
          <a href="#" class="hover:text-orange-600 transition-colors">Collections</a>
          <a href="#" class="hover:text-orange-600 transition-colors">Marketplace</a>
          <template v-if="isLoggedIn">
            <a href="#" @click.prevent="goToWishlist" class="hover:text-orange-600 transition-colors">Wishlist</a>
            <a href="#" @click.prevent="goToOrders" class="hover:text-orange-600 transition-colors">History</a>
          </template>
        </div>

        <div class="flex items-center gap-6">
          <template v-if="isLoggedIn">
            <div class="flex items-center gap-4 border-l pl-6 border-gray-100 relative user-menu">
              <div class="text-right hidden sm:block">
                <p class="text-xs font-bold text-gray-900">{{ user.name }}</p>
                <p class="text-[10px] text-gray-400 uppercase tracking-tighter">Premium Member</p>
              </div>
              
              <button 
                @click="toggleUserMenu" 
                class="w-10 h-10 rounded-full bg-gradient-to-tr from-orange-500 to-amber-400 flex items-center justify-center text-white font-bold shadow-md hover:scale-105 transition-transform"
              >
                {{ user.name.charAt(0).toUpperCase() }}
              </button>

              <div v-if="showUserMenu" class="absolute right-0 top-full mt-4 w-48 bg-white rounded-2xl shadow-2xl border border-gray-50 py-2 z-50 animate-in fade-in zoom-in duration-200">
                <div class="px-4 py-2 border-b border-gray-50 mb-1">
                  <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Account</p>
                </div>
                <button @click="goToProfile" class="w-full text-left px-4 py-2 text-sm font-medium hover:bg-orange-50 transition">👤 Profile</button>
                <button @click="goToOrders" class="w-full text-left px-4 py-2 text-sm font-medium hover:bg-orange-50 transition">📦 My Orders</button>
                <button @click="logout" class="w-full text-left px-4 py-2 text-sm font-bold text-red-500 hover:bg-red-50 transition mt-1">🚪 Logout</button>
              </div>
            </div>
          </template>
          
          <button v-else @click="goToLogin" class="bg-gray-900 text-white px-7 py-2.5 rounded-full text-sm font-bold hover:bg-orange-600 transition-all shadow-xl shadow-gray-200">
            Sign In
          </button>
        </div>
      </nav>
    </header>

    <main>
      <section class="max-w-7xl mx-auto px-6 py-20">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
          
          <div class="animate-in fade-in slide-in-from-left-8 duration-1000">
            <div v-if="isLoggedIn" class="flex items-center gap-2 bg-orange-50 text-orange-600 px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-[0.2em] mb-6 w-fit">
              <span class="relative flex h-2 w-2">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-orange-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-orange-500"></span>
              </span>
              Member Exclusive Access
            </div>
            <p v-else class="text-sm tracking-[0.2em] text-orange-500 font-bold mb-4 uppercase">
              Premium UMKM Marketplace
            </p>

            <h1 class="text-5xl md:text-6xl font-black leading-[1.1] mb-6 text-gray-900 tracking-tighter">
              <template v-if="isLoggedIn">
                Welcome Back, <br/>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-600 to-amber-500 italic">
                  {{ user.name.split(' ')[0] }}
                </span>
              </template>
              <template v-else>
                Discover Premium Local Products with <span class="italic text-orange-600">Modern Experience</span>
              </template>
            </h1>

            <p class="text-gray-500 text-lg mb-8 max-w-lg leading-relaxed">
              {{ isLoggedIn 
                ? 'Senang melihat Anda kembali. Jelajahi koleksi terbaru yang dikurasi khusus untuk melengkapi gaya hidup premium Anda.' 
                : 'Marketplace modern dengan AI, AR, dan sistem e-commerce profesional untuk mendukung produk lokal terbaik.' 
              }}
            </p>

            <div class="flex flex-wrap gap-4">
              <button class="bg-gray-900 text-white px-10 py-4 rounded-full shadow-xl hover:bg-orange-600 hover:-translate-y-1 transition duration-300 font-bold">
                {{ isLoggedIn ? 'Start Shopping' : 'Explore Collection' }}
              </button>
              <button v-if="isLoggedIn" @click="goToWishlist" class="bg-white border border-gray-100 text-gray-900 px-8 py-4 rounded-full shadow-sm hover:bg-gray-50 transition duration-300 font-bold">
                My Wishlist
              </button>
            </div>
          </div>

          <div class="grid grid-cols-2 gap-4 relative animate-in fade-in zoom-in duration-1000">
            <div v-if="isLoggedIn" class="absolute -top-6 -right-2 bg-white p-5 rounded-3xl shadow-2xl border border-orange-50 z-10 hidden md:block animate-bounce-slow">
              <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest">Points</p>
              <p class="text-2xl font-black text-orange-600">1,240</p>
            </div>

            <div class="bg-orange-50 h-64 rounded-[2.5rem] border border-orange-100 shadow-sm flex items-center justify-center group overflow-hidden">
               <svg class="w-12 h-12 text-orange-200 group-hover:scale-125 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" stroke-width="2" /></svg>
            </div>
            <div class="bg-amber-100 h-64 rounded-[2.5rem] mt-10 border border-orange-200 shadow-sm overflow-hidden relative group">
              <div class="absolute inset-0 bg-gradient-to-br from-white/20 to-transparent"></div>
              <div class="w-full h-full bg-orange-200/20 group-hover:scale-110 transition-transform duration-700"></div>
            </div>
            <div class="bg-orange-100 h-64 rounded-[2.5rem] -mt-10 border border-orange-200 shadow-sm overflow-hidden relative group">
               <div class="w-full h-full bg-amber-200/20 group-hover:scale-110 transition-transform duration-700"></div>
            </div>
            <div class="bg-orange-50 h-64 rounded-[2.5rem] border border-orange-100 shadow-sm flex items-center justify-center">
              <div class="w-12 h-12 rounded-full border-4 border-orange-100 border-t-orange-300 animate-spin"></div>
            </div>
          </div>
        </div>
      </section>

      <section v-if="isLoggedIn" class="max-w-7xl mx-auto px-6 mb-16">
        <div class="bg-white border border-gray-100 rounded-[2.5rem] p-8 flex flex-wrap justify-around items-center shadow-sm relative overflow-hidden">
          <div class="absolute top-0 left-0 w-1 h-full bg-orange-500"></div>
          <div class="text-center px-4">
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-2">Active Orders</p>
            <p class="text-2xl font-black text-gray-900">08</p>
          </div>
          <div class="h-10 w-px bg-gray-100 hidden md:block"></div>
          <div class="text-center px-4">
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-2">Saved Items</p>
            <p class="text-2xl font-black text-gray-900">{{ products.filter(p => p.inWishlist).length }}</p>
          </div>
          <div class="h-10 w-px bg-gray-100 hidden md:block"></div>
          <div class="text-center px-4">
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-2">Wallet Balance</p>
            <p class="text-2xl font-black text-orange-600">Rp 2.450k</p>
          </div>
          <div class="h-10 w-px bg-gray-100 hidden md:block"></div>
          <button class="bg-orange-50 text-orange-600 px-6 py-3 rounded-2xl text-xs font-black uppercase tracking-widest hover:bg-orange-600 hover:text-white transition-all">
            Top Up Wallet
          </button>
        </div>
      </section>

      <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-6">
          <div class="flex flex-col md:flex-row justify-between items-end mb-12 gap-4">
            <div>
              <h2 class="text-4xl font-black text-gray-900 tracking-tighter">
                {{ isLoggedIn ? '🧠 Curated For You' : '✨ New Arrivals' }}
              </h2>
              <p class="text-gray-400 font-medium mt-2">Quality over quantity, always premium selections.</p>
            </div>
            <button @click="showAll = !showAll" class="text-sm font-bold text-orange-600 hover:underline underline-offset-8 decoration-orange-200">
              {{ showAll ? "Close View" : "View All Collection →" }}
            </button>
          </div>

          <div v-if="isLoading" class="flex flex-col items-center py-20">
            <div class="w-12 h-12 border-4 border-orange-100 border-t-orange-500 rounded-full animate-spin mb-4"></div>
            <p class="text-gray-400 font-medium animate-pulse text-sm uppercase tracking-widest">Loading Premium Goods</p>
          </div>

          <div v-else-if="products.length === 0" class="text-center py-20 border-2 border-dashed border-gray-100 rounded-[3rem]">
            <p class="text-gray-400 font-bold italic">Belum ada koleksi yang dipublikasikan.</p>
          </div>

          <div v-else :class="showAll ? 'grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-8' : 'grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8'">
            <div v-for="product in visibleProducts" :key="product.id" class="group cursor-pointer">
              <div class="aspect-[4/5] bg-gray-50 rounded-[2.5rem] overflow-hidden relative mb-5 shadow-sm group-hover:shadow-2xl group-hover:shadow-orange-100 transition-all duration-700">
                <img 
                  v-if="product.images?.length" 
                  :src="product.images[0]" 
                  class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-1000"
                />
                <div v-else class="w-full h-full flex items-center justify-center text-gray-300 font-black uppercase text-[10px] tracking-widest">No Image</div>
                
                <div v-if="isLoggedIn && product.price < 1000000" class="absolute top-6 left-6 bg-white/90 backdrop-blur-md px-3 py-1 rounded-full text-[9px] font-black text-orange-600 uppercase tracking-tighter shadow-sm">
                  Exclusive Deal
                </div>

                <button 
                  v-if="isLoggedIn" 
                  @click.stop="toggleWishlist(product)" 
                  class="absolute top-6 right-6 w-11 h-11 bg-white/90 backdrop-blur-md rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all hover:bg-white active:scale-90 shadow-lg"
                >
                  <svg class="w-5 h-5" :class="product.inWishlist ? 'text-red-500 fill-current' : 'text-gray-900'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" stroke-width="2" />
                  </svg>
                </button>
              </div>
              
              <div class="px-2">
                <h3 class="font-bold text-gray-900 text-lg truncate tracking-tight group-hover:text-orange-600 transition-colors">{{ product.name }}</h3>
                <div class="flex justify-between items-center mt-1">
                  <p class="text-orange-600 font-black">Rp {{ Number(product.price).toLocaleString('id-ID') }}</p>
                  <span class="text-[9px] font-bold text-gray-300 uppercase tracking-widest">Premium</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <section class="py-24 bg-gray-50/50 border-t border-gray-100">
        <div class="max-w-7xl mx-auto px-6">
          <div class="text-center mb-16">
            <h2 class="text-4xl font-black text-gray-900 tracking-tighter mb-4">Customer Stories</h2>
            <p class="text-gray-400 font-medium">Verified experiences from our gold members.</p>
          </div>
          <div class="grid md:grid-cols-3 gap-8">
            <div v-for="review in reviews" :key="review.name" class="bg-white p-8 rounded-[2.5rem] border border-gray-50 shadow-sm hover:shadow-xl transition-all group">
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

    </main>

    <footer class="py-16 text-center border-t border-gray-50">
      <div class="max-w-7xl mx-auto px-6">
        <div class="flex justify-center items-center gap-2 mb-8">
          <div class="w-6 h-6 bg-gray-900 rounded flex items-center justify-center">
            <span class="text-white text-[10px] font-black italic">S</span>
          </div>
          <span class="font-black tracking-tighter text-gray-900">SnapFit Premium</span>
        </div>
        <p class="text-[10px] font-black tracking-[0.5em] text-gray-300 uppercase">
          SnapFit Marketplace © 2026 • Crafted with Excellence
        </p>
      </div>
    </footer>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, onBeforeUnmount } from "vue";
import { useRouter } from 'vue-router';

/* --- SYSTEM & USER STATE --- */
const router = useRouter();
const user = ref(null);
const isLoggedIn = computed(() => !!user.value);
const showUserMenu = ref(false);

/* --- PRODUCTS & UI STATE --- */
const showAll = ref(false);
const products = ref([]);
const isLoading = ref(false);
const carouselIndex = ref(0); // Digunakan jika ingin fitur auto-rotate produk

const reviews = [
  { name: 'Andi Pratama', text: 'Produk sangat berkualitas, pengiriman cepat dan packaging rapi. Sangat recommended!' },
  { name: 'Siti Rahma', text: 'Desain produk sangat modern, cocok untuk gift dan koleksi pribadi.' },
  { name: 'Budi Santoso', text: 'UI marketplace ini sangat premium, terasa seperti brand internasional.' }
];

/* --- API ACTIONS --- */

// Fetch data produk dari backend Laravel
const fetchProducts = async () => {
  isLoading.value = true;
  try {
    const response = await fetch('/api/v1/products', {
      method: 'GET',
      headers: { 'Accept': 'application/json' }
    });

    if (!response.ok) throw new Error('Gagal mengambil data produk');
    
    const data = await response.json();
    const fetched = Array.isArray(data) ? data : (data.data || []);
    
    products.value = fetched.map(p => ({
      ...p,
      images: typeof p.images === 'string' ? JSON.parse(p.images) : p.images,
      inWishlist: false 
    }));
  } catch (error) {
    console.error('Fetch error:', error);
  } finally {
    isLoading.value = false;
  }
};

// Logout Action
const logout = async () => {
  try {
    const token = localStorage.getItem('token');
    if (token) {
      await fetch('/api/v1/auth/logout', {
        method: 'POST',
        headers: {
          'Authorization': `Bearer ${token}`,
          'Accept': 'application/json'
        }
      });
    }
  } catch (err) {
    console.error('Logout failed:', err);
  } finally {
    localStorage.removeItem('user');
    localStorage.removeItem('token');
    user.value = null;
    showUserMenu.value = false;
    router.push('/login');
  }
};

/* --- NAVIGATION & UI HELPERS --- */
const toggleUserMenu = () => { showUserMenu.value = !showUserMenu.value; };
const goToLogin = () => router.push('/login');
const goToProfile = () => { alert('Profile Page coming soon!'); showUserMenu.value = false; };
const goToOrders = () => { alert('Order History coming soon!'); showUserMenu.value = false; };
const goToWishlist = () => { alert('Your Wishlist is empty!'); };

const toggleWishlist = (product) => {
  product.inWishlist = !product.inWishlist;
  // Di sini kamu bisa tambahkan API call untuk simpan ke database
};

// Logic untuk membatasi jumlah produk yang tampil di landing
const visibleProducts = computed(() => {
  if (showAll.value) return products.value;
  if (products.value.length === 0) return [];
  return products.value.slice(0, 4); // Tampilkan 4 teratas
});

/* --- LIFECYCLE --- */
onMounted(() => {
  // Restore user session
  const userData = localStorage.getItem('user');
  if (userData) {
    user.value = JSON.parse(userData);
  }

  fetchProducts();

  // Close dropdown if clicked outside
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

<style>
/* Animasi custom tambahan */
@keyframes bounce-slow {
  0%, 100% { transform: translateY(-5%); }
  50% { transform: translateY(0); }
}
.animate-bounce-slow {
  animation: bounce-slow 3s infinite ease-in-out;
}

/* Tailwind Animate Plugin Shorthand (Jika tidak install pluginnya) */
.animate-in {
  animation-duration: 0.7s;
  animation-fill-mode: both;
}
@keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
@keyframes slideInLeft { from { transform: translateX(-20px); opacity: 0; } to { transform: translateX(0); opacity: 1; } }
@keyframes zoomIn { from { transform: scale(0.95); opacity: 0; } to { transform: scale(1); opacity: 1; } }

.fade-in { animation-name: fadeIn; }
.slide-in-from-left-8 { animation-name: slideInLeft; }
.zoom-in { animation-name: zoomIn; }
</style>