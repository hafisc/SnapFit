<template>
  <section id="marketplace" class="py-24 bg-white relative overflow-hidden">
    <!-- Background Decoration -->
    <div class="absolute top-0 right-0 w-96 h-96 bg-orange-50 rounded-full blur-[120px] opacity-40 -z-10"></div>
    <div class="absolute bottom-0 left-0 w-96 h-96 bg-orange-50 rounded-full blur-[120px] opacity-40 -z-10"></div>

    <div class="max-w-[1600px] mx-auto px-6">
      <!-- Header with Animation -->
      <div class="text-center mb-16 animate-fade-in">
       
        
        <h2 class="text-5xl md:text-6xl font-black tracking-tighter mb-4">
          <span class="text-gray-900">Indonesian Craft</span>
          <span class="block text-orange-600">Marketplace</span>
        </h2>
        <p class="text-gray-500 text-lg max-w-2xl mx-auto font-medium">
          Koleksi terkurasi dari pengrajin terbaik seluruh Indonesia. Setiap produk dibuat dengan cinta dan keahlian turun-temurun.
        </p>
      </div>

      <!-- Category Filter with Modern Design -->
      <div class="mb-12 flex justify-center">
        <div class="inline-flex flex-wrap gap-3 bg-white p-3 rounded-3xl border border-gray-200 shadow-lg">
          <button
            v-for="cat in categories"
            :key="cat"
            @click="activeCategory = cat"
            :class="[
              activeCategory === cat 
                ? 'bg-orange-600 text-white shadow-lg shadow-orange-200 scale-105' 
                : 'text-gray-600 hover:text-orange-600 hover:bg-orange-50'
            ]"
            class="px-6 py-2.5 rounded-2xl text-xs font-black uppercase tracking-wider transition-all duration-300 whitespace-nowrap"
          >
            <span class="flex items-center gap-2">
              <span v-if="activeCategory === cat" class="w-1.5 h-1.5 bg-white rounded-full animate-pulse"></span>
              {{ cat }}
            </span>
          </button>
        </div>
      </div>

      <!-- Loading State with Better Skeleton -->
      <div v-if="isLoading" class="grid grid-cols-2 lg:grid-cols-5 gap-6">
        <div v-for="i in 10" :key="i" class="animate-pulse">
          <div class="aspect-[3/4] bg-gray-200 rounded-3xl mb-4"></div>
          <div class="space-y-3">
            <div class="h-5 bg-gray-200 rounded-lg w-3/4"></div>
            <div class="h-4 bg-gray-100 rounded-lg w-1/2"></div>
            <div class="flex gap-2">
              <div class="h-8 bg-gray-200 rounded-lg w-24"></div>
              <div class="h-8 bg-gray-100 rounded-lg flex-1"></div>
            </div>
          </div>
        </div>
      </div>

      <!-- Products Grid with Enhanced Cards -->
      <div v-else class="grid grid-cols-2 lg:grid-cols-5 gap-6">
        <div
          v-for="product in filteredProducts"
          :key="product.id"
          class="group cursor-pointer transform hover:-translate-y-2 transition-all duration-500"
          @click="viewProductDetail(product)"
        >
          <!-- Product Card -->
          <div class="bg-white rounded-3xl overflow-hidden shadow-lg shadow-gray-200/50 hover:shadow-2xl hover:shadow-orange-200/50 transition-all duration-500 border border-gray-100">
            <!-- Image Container -->
            <div class="aspect-[3/4] bg-gray-100 overflow-hidden relative">
              <!-- Gradient Overlay -->
              <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-500 z-10"></div>

              <!-- Category Badge -->
              <div class="absolute top-4 left-4 z-20">
                <span class="inline-flex items-center gap-1.5 bg-white/95 backdrop-blur-md px-3 py-1.5 rounded-full text-[9px] font-black uppercase tracking-widest shadow-lg border border-orange-100">
                  <span class="w-1.5 h-1.5 bg-orange-500 rounded-full"></span>
                  {{ product.category }}
                </span>
              </div>

              <!-- Action Buttons -->
              <div class="absolute top-4 right-4 z-20 flex flex-col gap-2 opacity-0 group-hover:opacity-100 transition-all duration-300 translate-x-4 group-hover:translate-x-0">
                <!-- Wishlist -->
                <button
                  @click.stop="toggleWishlist(product)"
                  class="w-10 h-10 bg-white/95 backdrop-blur-md rounded-full flex items-center justify-center hover:bg-white hover:scale-110 active:scale-95 transition-all shadow-lg"
                  :class="product.inWishlist ? 'text-red-500' : 'text-gray-700'"
                >
                  <svg class="w-5 h-5" :class="product.inWishlist ? 'fill-current' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                  </svg>
                </button>

                <!-- Quick View -->
                <button
                  @click.stop="quickView(product)"
                  class="w-10 h-10 bg-white/95 backdrop-blur-md rounded-full flex items-center justify-center hover:bg-white hover:scale-110 active:scale-95 transition-all shadow-lg text-gray-700"
                >
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                  </svg>
                </button>
              </div>

              <!-- Product Image -->
              <img
                :src="product.images && product.images.length ? product.images[0] : 'https://images.unsplash.com/photo-1617627143750-d86bc21e42bb?q=80&w=1000'"
                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                :alt="product.name"
              />

              <!-- Quick Add to Cart (Bottom Overlay) -->
              <div class="absolute bottom-0 left-0 right-0 p-4 z-20 translate-y-full group-hover:translate-y-0 transition-transform duration-500">
                <button @click.stop="addToCart(product)" class="w-full bg-orange-600 text-white py-3 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-orange-700 hover:shadow-xl active:scale-95 transition-all flex items-center justify-center gap-2">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                  </svg>
                  Add to Cart
                </button>
              </div>
            </div>

            <!-- Product Info -->
            <div class="p-5">
              <!-- Product Name -->
              <h3 class="font-black text-lg mb-2 text-gray-900 group-hover:text-orange-600 transition-colors line-clamp-2 leading-tight">
                {{ product.name }}
              </h3>

              <!-- Rating & Reviews -->
              <div class="flex items-center gap-2 mb-3">
                <div class="flex items-center gap-0.5">
                  <svg v-for="i in 5" :key="i" class="w-3.5 h-3.5 text-amber-400 fill-current" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                  </svg>
                </div>
                <span class="text-xs font-bold text-gray-600">4.9</span>
                <span class="text-xs text-gray-400">(127)</span>
              </div>

              <!-- Price & Stock -->
              <div class="flex items-center justify-between">
                <div>
                  <p class="text-2xl font-black text-orange-600">
                    Rp {{ Number(product.price).toLocaleString('id-ID') }}
                  </p>
                  <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mt-0.5">Premium Quality</p>
                </div>
                
                <!-- Stock Badge -->
                <div class="flex items-center gap-1.5 bg-green-50 text-green-600 px-3 py-1.5 rounded-full">
                  <span class="w-1.5 h-1.5 bg-green-500 rounded-full animate-pulse"></span>
                  <span class="text-[9px] font-black uppercase tracking-wider">In Stock</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Empty State with Better Design -->
      <div v-if="!isLoading && filteredProducts.length === 0" class="py-32 text-center">
        <div class="max-w-md mx-auto">
          <div class="w-24 h-24 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="w-12 h-12 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
            </svg>
          </div>
          <h3 class="text-2xl font-black text-gray-900 mb-3">Belum Ada Produk</h3>
          <p class="text-gray-500 mb-6">Belum ada koleksi yang dipublikasikan untuk kategori <span class="font-bold text-orange-600">{{ activeCategory }}</span>.</p>
          <button @click="activeCategory = 'all'" class="inline-flex items-center gap-2 bg-orange-600 text-white px-6 py-3 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-orange-700 hover:shadow-xl transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
            </svg>
            Lihat Semua Produk
          </button>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, computed } from 'vue';
import { useRouter } from 'vue-router';
import { useCartStore } from '@/stores/cartStore';

const router = useRouter();
const cartStore = useCartStore();

const props = defineProps({
  products:  { type: Array,   default: () => [] },
  isLoading: { type: Boolean, default: false }
});

const activeCategory = ref('all');
const categories = ['all', 'batik', 'kerajinan', 'aksesoris', 'dekorasi', 'fashion'];

const addToCart = async (product) => {
  await cartStore.addItem(product);
};

const viewProductDetail = (product) => {
  router.push({ name: 'marketplace.product.detail', params: { id: product.id } });
};

const filteredProducts = computed(() => {
  if (activeCategory.value === 'all') return props.products;
  return props.products.filter(p => p.category === activeCategory.value);
});
</script>

<style scoped>
/* Scrollbar Hider */
.no-scrollbar::-webkit-scrollbar { display: none; }
.no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

/* Line Clamp */
.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

/* Fade In Animation */
@keyframes fadeIn {
  from { opacity: 0; transform: translateY(20px); }
  to { opacity: 1; transform: translateY(0); }
}

.animate-fade-in {
  animation: fadeIn 0.8s ease-out;
}

/* Smooth Hover Effects */
.group:hover .group-hover\:scale-110 {
  transform: scale(1.1);
}

/* Custom Gradient Text */
.bg-clip-text {
  -webkit-background-clip: text;
  background-clip: text;
}
</style>
