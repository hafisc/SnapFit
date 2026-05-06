<template>
  <section id="marketplace" class="py-12 bg-gray-50 min-h-screen">
    <div class="max-w-[1400px] mx-auto px-4 sm:px-6">

            <!-- Loading State with Shopee Skeleton -->
      <div v-if="isLoading" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-2 sm:gap-3">
        <div v-for="i in 12" :key="i" class="bg-white border border-gray-200 rounded-sm p-2 animate-pulse">
          <div class="aspect-square bg-gray-200 mb-2"></div>
          <div class="h-3 bg-gray-200 w-full mb-1"></div>
          <div class="h-3 bg-gray-200 w-3/4 mb-4"></div>
          <div class="flex justify-between items-center mt-2">
            <div class="h-4 bg-gray-200 w-1/3"></div>
            <div class="h-3 bg-gray-200 w-1/4"></div>
          </div>
        </div>
      </div>

      <!-- Products Grid -->
      <div v-else class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4 sm:gap-5">
        <div v-for="product in filteredProducts" :key="product.id" @click="viewProductDetail(product)" class="bg-white border border-gray-200 shadow-sm hover:border-orange-400 hover:shadow-xl transition-all duration-300 rounded-2xl group overflow-hidden flex flex-col h-full cursor-pointer hover:-translate-y-1 relative">
          
          <!-- Image Section -->
          <div class="relative w-full aspect-square bg-gray-100 isolate overflow-hidden border-b border-gray-100">
            <img :src="product.images && product.images.length ? product.images[0] : 'https://images.unsplash.com/photo-1617627143750-d86bc21e42bb?q=80&w=1000'" :alt="product.name" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" />
            
            <!-- Hover Overlay -->
            <div class="absolute inset-0 bg-black/5 opacity-0 group-hover:opacity-100 transition-opacity"></div>
          </div>

          <!-- Product Details -->
          <div class="p-3.5 flex flex-col flex-1">
            <!-- Title -->
            <h3 class="text-[13px] text-gray-800 line-clamp-2 leading-snug mb-2 font-medium group-hover:text-orange-600 transition-colors">
              {{ product.name }}
            </h3>

            <!-- Spacer -->
            <div class="flex-1"></div>

            <!-- Price & Sold -->
            <div class="flex items-center justify-between mt-auto pt-1">
              <p class="text-base font-bold text-orange-600 tracking-tight">
                <span class="text-[11px] font-semibold mr-0.5">Rp</span>{{ Number(product.price).toLocaleString('id-ID') }}
              </p>
              <p class="text-[10px] text-gray-500 font-medium ml-1">
                {{ (product.id * 15) % 100 + 1 }}RB+ terjual
              </p>
            </div>
          </div>
        </div>
      </div>

      <!-- Empty State with Better Design -->
      <div v-if="!isLoading && filteredProducts.length === 0" class="py-32 text-center">
        <div class="max-w-md mx-auto">
          <div class="w-24 h-24 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="w-12 h-12 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
            </svg>
          </div>
          <h3 class="text-2xl font-black text-gray-900 mb-3">Belum Ada Produk</h3>
          <p class="text-gray-500 mb-6">Belum ada koleksi yang dipublikasikan untuk kategori <span
              class="font-bold text-orange-600">{{ activeCategory }}</span>.</p>
          <button @click="activeCategory = 'all'"
            class="inline-flex items-center gap-2 bg-orange-600 text-white px-6 py-3 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-orange-700 hover:shadow-xl transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
            </svg>
            Lihat Semua Produk
          </button>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import { useCartStore } from '@/stores/cartStore';
import { useWishlistStore } from '@/stores/wishlistStore';

const router = useRouter();
const cartStore = useCartStore();
const wishlistStore = useWishlistStore();

onMounted(() => {
  wishlistStore.loadWishlist();
});

const props = defineProps({
  products: { type: Array, default: () => [] },
  isLoading: { type: Boolean, default: false }
});

const activeCategory = ref('all');
const categories = ['all', 'batik', 'kerajinan', 'aksesoris', 'dekorasi', 'fashion'];

const addToCart = async (product) => {
  await cartStore.addItem(product);
};

const isWishlisted = (productId) => {
  return wishlistStore.isWishlisted(productId);
};

const toggleWishlist = async (product) => {
  await wishlistStore.toggleWishlist(product);
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
.no-scrollbar::-webkit-scrollbar {
  display: none;
}

.no-scrollbar {
  -ms-overflow-style: none;
  scrollbar-width: none;
}

/* Line Clamp */
.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

/* Fade In Animation */
@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(20px);
  }

  to {
    opacity: 1;
    transform: translateY(0);
  }
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
