<template>
  <section id="marketplace" class="py-24 bg-white border-t border-gray-50">
    <div class="max-w-7xl mx-auto px-6">
      <!-- Header -->
      <div class="flex flex-col md:flex-row justify-between items-center mb-16 gap-8">
        <div>
          <h2 class="text-4xl font-black tracking-tighter uppercase">Indonesian Craft Marketplace</h2>
          <p class="text-gray-400 font-medium mt-2 italic">Koleksi terkurasi dari pengrajin terbaik Malang & sekitarnya.</p>
        </div>

        <!-- Category Filter -->
        <div class="flex gap-2 bg-gray-50 p-2 rounded-2xl border border-gray-100 overflow-x-auto max-w-full no-scrollbar">
          <button
            v-for="cat in categories"
            :key="cat"
            @click="activeCategory = cat"
            :class="activeCategory === cat ? 'bg-gray-900 text-white shadow-lg' : 'text-gray-400 hover:text-gray-900'"
            class="px-5 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all whitespace-nowrap"
          >
            {{ cat }}
          </button>
        </div>
      </div>

      <!-- Loading State -->
      <div v-if="isLoading" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10">
        <div v-for="i in 4" :key="i" class="animate-pulse">
          <div class="aspect-[4/5] bg-gray-100 rounded-[3rem] mb-4"></div>
          <div class="h-4 bg-gray-100 rounded w-2/3 mb-2"></div>
          <div class="h-4 bg-gray-100 rounded w-1/2"></div>
        </div>
      </div>

      <!-- Products Grid -->
      <div v-else class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10">
        <div
          v-for="product in filteredProducts"
          :key="product.id"
          class="group cursor-pointer"
        >
          <div class="aspect-[4/5] bg-gray-50 rounded-[3rem] overflow-hidden relative mb-6 shadow-sm group-hover:shadow-2xl transition-all duration-700">
            <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>

            <!-- Category Badge -->
            <div class="absolute top-6 left-6 bg-white/90 backdrop-blur px-4 py-2 rounded-full text-[9px] font-black uppercase tracking-widest shadow-sm z-10 border border-orange-50">
              {{ product.category }}
            </div>

            <!-- Wishlist Button -->
            <button
              @click.stop="toggleWishlist(product)"
              class="absolute top-6 right-6 w-11 h-11 bg-white/90 backdrop-blur-md rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all hover:bg-white active:scale-90 shadow-lg z-10"
            >
              <svg
                class="w-5 h-5"
                :class="product.inWishlist ? 'text-red-500 fill-current' : 'text-gray-900'"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
              >
                <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" stroke-width="2" />
              </svg>
            </button>

            <!-- Product Image -->
            <img
              :src="product.images && product.images.length ? product.images[0] : 'https://images.unsplash.com/photo-1617627143750-d86bc21e42bb?q=80&w=1000'"
              class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-1000"
              :alt="product.name"
            />
          </div>

          <!-- Product Info -->
          <h3 class="font-black text-xl mb-1 group-hover:text-orange-600 transition-colors tracking-tighter uppercase italic">
            {{ product.name }}
          </h3>
          <div class="flex justify-between items-center">
            <p class="text-orange-600 font-black">Rp {{ Number(product.price).toLocaleString('id-ID') }}</p>
            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Premium Craft</span>
          </div>
        </div>
      </div>

      <!-- Empty State -->
      <div v-if="!isLoading && filteredProducts.length === 0" class="py-20 text-center border-2 border-dashed border-gray-100 rounded-[3rem]">
        <p class="text-gray-400 font-bold italic">Belum ada koleksi yang dipublikasikan untuk kategori ini.</p>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, computed } from 'vue';

const props = defineProps({
  products:  { type: Array,   default: () => [] },
  isLoading: { type: Boolean, default: false }
});

const activeCategory = ref('all');
const categories = ['all', 'batik', 'kerajinan', 'aksesoris', 'dekorasi', 'fashion'];

const toggleWishlist = (product) => {
  product.inWishlist = !product.inWishlist;
};

const filteredProducts = computed(() => {
  if (activeCategory.value === 'all') return props.products;
  return props.products.filter(p => p.category === activeCategory.value);
});
</script>

<style scoped>
.no-scrollbar::-webkit-scrollbar { display: none; }
.no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
</style>
