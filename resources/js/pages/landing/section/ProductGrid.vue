<template>
  <section id="marketplace" class="pt-10 pb-24 relative z-10">
    <!-- GRID BACKGROUND -->
    <!-- <div class="absolute inset-0 opacity-[0.03] z-0" style="
    background-image: 
      linear-gradient(to right, black 1px, transparent 1px),
      linear-gradient(to bottom, black 1px, transparent 1px);
    background-size: 40px 40px;
  ">
    </div> -->

    <!-- NOISE -->
    <div class="absolute inset-0 opacity-[0.02] mix-blend-multiply pointer-events-none" style="
    background-image: url('https://grainy-gradients.vercel.app/noise.svg');
  ">
    </div>
    <div
      class="absolute top-[-5%] right-[-5%] w-[500px] h-[500px] bg-orange-500/15 rounded-full blur-[120px] z-0 animate-pulse"
      style="animation-duration: 8s;"></div>
    <div class="absolute bottom-[10%] left-[-10%] w-[600px] h-[600px] bg-rose-400/10 rounded-full blur-[120px] z-0">
    </div>
    <div
      class="absolute top-[50%] left-[50%] w-[800px] h-[400px] bg-amber-200/10 rounded-full blur-[150px] z-0 -translate-x-1/2 -translate-y-1/2">
    </div>

    <div class="max-w-[1600px] mx-auto px-6 relative z-10">

      <!-- PROMO CAROUSEL -->
      <div class="mb-10 px-2 md:px-4" data-aos="fade-up">
        <div class="overflow-hidden rounded-3xl relative">
          <div class="flex transition-transform duration-700"
            :style="{ transform: `translateX(-${currentSlide * 100}%)` }">
            <div v-for="(slide, index) in promoSlides" :key="index"
              class="min-w-full h-[280px] md:h-[360px] lg:h-[420px] relative">
              <img :src="slide.image" class="absolute inset-0 w-full h-full object-cover" />
              <div class="absolute inset-0 bg-black/40"></div>
              <div class="relative z-10 h-full flex items-center">
                <div class="w-full max-w-[1400px] mx-auto px-6 md:px-12">
                  <div class="max-w-xl text-white">
                    <div
                      class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-xl border border-white/20 px-4 py-2 rounded-full mb-5">
                      <div class="w-2 h-2 bg-orange-400 rounded-full animate-pulse"></div>
                      <span class="text-xs font-bold uppercase tracking-[0.3em]">Limited Collection</span>
                    </div>
                    <h3 class="text-2xl md:text-4xl lg:text-5xl font-black mb-3 leading-tight">
                      {{ slide.title }}
                    </h3>
                    <p class="text-sm md:text-base text-white/90 mb-6">{{ slide.description }}</p>
                    <button
                      class="bg-orange-600 px-6 py-3 rounded-2xl font-bold text-xs uppercase tracking-widest hover:bg-orange-700 transition">
                      Shop Now
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex gap-2">
            <span v-for="(slide, index) in promoSlides" :key="index" @click="currentSlide = index"
              class="h-2 rounded-full cursor-pointer transition-all"
              :class="currentSlide === index ? 'bg-orange-600 w-6' : 'bg-white/50 w-2'"></span>
          </div>
        </div>
      </div>


      <!-- Category Filter -->
      <div class="mb-12 flex justify-center" data-aos="zoom-in" data-aos-delay="100">
        <div class="inline-flex flex-wrap gap- bg-white p-3 rounded-3xl border border-gray-200 shadow-lg">
          <button v-for="cat in categories" :key="cat" @click="activeCategory = cat" :class="[
            activeCategory === cat
              ? 'bg-orange-600 text-white shadow-lg shadow-orange-200 scale-105'
              : 'text-gray-600 hover:text-orange-600 hover:bg-orange-50'
          ]"
            class="px-6 py-2.5 rounded-2xl text-xs font-black uppercase tracking-wider transition-all duration-300 whitespace-nowrap">
            <span class="flex items-center gap-2">
              <span v-if="activeCategory === cat" class="w-1.5 h-1.5 bg-white rounded-full animate-pulse"></span>
              {{ cat }}
            </span>
          </button>
        </div>
      </div>
      <!-- ============================================================ -->
      <!-- FLASH SALE SECTION                                           -->
      <!-- ============================================================ -->
      <div class="mb-10" data-aos="fade-up" data-aos-delay="50">

        <!-- Header -->
        <div class="flex items-center justify-between mb-4">
          <div class="flex items-center gap-3">
            <span class="text-base font-black text-gray-900">⚡ Flash Sale</span>
            <!-- Countdown -->
            <div class="flex items-center gap-1">
              <template v-for="(unit, i) in countdown" :key="i">
                <div
                  class="bg-orange-600 text-white text-xs font-black px-2 py-1 rounded-md tabular-nums min-w-[28px] text-center">
                  {{ unit }}
                </div>
                <span v-if="i < countdown.length - 1" class="text-gray-400 font-bold text-sm">:</span>
              </template>
            </div>
          </div>
          <span class="text-xs text-orange-600 font-bold cursor-pointer hover:underline">Lihat Semua →</span>
        </div>

        <!-- Flash Sale Cards -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
          <div v-for="item in flashItems" :key="item.id"
            class="bg-white border border-gray-200 rounded-2xl overflow-hidden cursor-pointer hover:-translate-y-1 hover:shadow-lg hover:border-orange-300 transition-all duration-300">

            <!-- Image area -->
            <div class="relative h-[100px] flex items-center justify-center text-5xl"
              :style="{ background: item.bgColor }">
              {{ item.icon }}
              <!-- Discount badge -->
              <div
                class="absolute top-2 left-2 text-white text-[9px] font-extrabold px-2 py-0.5 rounded-full animate-flash-blink"
                :style="{ background: item.badgeColor }">
                -{{ item.discount }}%
              </div>
            </div>

            <!-- Info -->
            <div class="p-2.5 pb-3">
              <p class="text-[11px] font-bold text-gray-800 mb-1.5 leading-snug line-clamp-2">{{ item.name }}</p>
              <div class="flex items-baseline gap-1.5 mb-2">
                <span class="text-sm font-black text-orange-600">{{ formatPrice(item.salePrice) }}</span>
                <span class="text-[10px] text-gray-400 line-through">{{ formatPrice(item.origPrice) }}</span>
              </div>
              <!-- Stock progress bar -->
              <div class="bg-gray-100 rounded-full h-[4px] overflow-hidden">
                <div class="h-full bg-orange-500 rounded-full transition-all" :style="{ width: item.stockPct + '%' }">
                </div>
              </div>
              <p class="text-[9.5px] text-gray-400 mt-1">Sisa {{ item.remaining }} pcs</p>
            </div>
          </div>
        </div>
      </div>
      <!-- ============================================================ -->
      <!-- END FLASH SALE                                               -->
      <!-- ============================================================ -->

      <!-- Section Label -->
      <div class="flex items-center justify-between mb-3">
        <div class="flex items-center gap-2">
          <div class="w-1 h-[18px] bg-orange-600 rounded-full"></div>
          <span class="text-[14px] font-black text-gray-900">Terlaris Minggu Ini</span>
          <span
            class="bg-orange-50 text-orange-600 text-[9px] font-extrabold px-2 py-0.5 rounded-full border border-orange-200">🔥
            HOT</span>
        </div>
        <span class="text-[11px] text-orange-600 font-bold cursor-pointer">Lihat Semua →</span>
      </div>

      <!-- Loading Skeleton -->
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

      <!-- Products Grid -->
      <div v-else class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4 sm:gap-5">
        <div v-for="(product, index) in filteredProducts" :key="product.id" @click="viewProductDetail(product)"
          class="bg-white border border-gray-200 shadow-sm hover:border-orange-400 hover:shadow-xl transition-all duration-300 rounded-2xl group overflow-hidden flex flex-col h-full cursor-pointer hover:-translate-y-1 relative"
          data-aos="fade-up" :data-aos-delay="(index % 6) * 50">

          <!-- Image -->
          <div class="relative w-full aspect-square bg-gray-100 isolate overflow-hidden border-b border-gray-100">
            <div class="absolute top-2 left-2 z-20">
              <span
                class="inline-flex items-center gap-1.5 bg-white/95 backdrop-blur-md px-2 py-1 rounded-full text-[8px] font-black uppercase tracking-widest shadow-sm border border-orange-100">
                <span class="w-1.5 h-1.5 bg-orange-500 rounded-full"></span>
                {{ product.category }}
              </span>
            </div>
            <div
              class="absolute top-2 right-2 z-20 flex flex-col gap-2 opacity-0 group-hover:opacity-100 transition-all duration-300 translate-x-4 group-hover:translate-x-0">
              <button @click.stop="toggleWishlist(product)"
                class="w-8 h-8 bg-white/95 backdrop-blur-md rounded-full flex items-center justify-center hover:bg-white hover:scale-110 active:scale-95 transition-all shadow-sm"
                :class="isWishlisted(product.id) ? 'text-red-500' : 'text-gray-700'">
                <svg class="w-4 h-4" :class="isWishlisted(product.id) ? 'fill-current' : ''" fill="none"
                  stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                </svg>
              </button>
            </div>
            <img
              :src="product.images && product.images.length ? product.images[0] : 'https://images.unsplash.com/photo-1617627143750-d86bc21e42bb?q=80&w=1000'"
              :alt="product.name"
              class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" />
            <div class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity z-10"></div>
            <div
              class="absolute bottom-0 left-0 right-0 p-2 z-20 translate-y-full group-hover:translate-y-0 transition-transform duration-300">
              <button @click.stop="addToCart(product)"
                class="w-full bg-orange-600 text-white py-2 rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-orange-700 shadow-lg active:scale-95 transition-all flex items-center justify-center gap-1.5">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                + Keranjang
              </button>
            </div>
          </div>

          <!-- Product Info -->
          <div class="p-3 flex flex-col flex-1">
            <h3
              class="font-medium text-xs mb-1 text-gray-800 line-clamp-2 leading-tight group-hover:text-orange-600 transition-colors">
              {{ product.name }}
            </h3>
            <div class="flex items-center gap-2 mt-1">
              <div class="flex items-center gap-1">
                <svg class="w-3 h-3 text-yellow-400 fill-current" viewBox="0 0 20 20">
                  <path
                    d="M9.049 2.927C9.3 2.148 10.7 2.148 10.951 2.927L12.469 7.37H17.18C17.969 7.37 18.296 8.378 17.664 8.84L13.854 11.63L15.372 16.073C15.623 16.852 14.523 17.42 13.891 16.958L10.081 14.168L6.271 16.958C5.639 17.42 4.539 16.852 4.79 16.073L6.308 11.63L2.498 8.84C1.866 8.378 2.193 7.37 2.982 7.37H7.693L9.049 2.927Z" />
                </svg>
                <span class="text-[10px] font-semibold text-gray-600">4.9</span>
              </div>
              <span class="text-[10px] text-gray-400">• Bali</span>
            </div>
            <div class="flex-1"></div>
            <div class="flex items-center justify-between mt-auto pt-1">
              <p class="text-base font-bold text-orange-600 tracking-tight">
                <span class="text-[11px] font-semibold mr-0.5">Rp</span>{{ Number(product.price).toLocaleString('id-ID')
                }}
              </p>
              <p class="text-[10px] text-gray-500 font-medium ml-1 whitespace-nowrap">
                {{ (product.id * 15) % 100 + 1 }}RB+ terjual
              </p>
            </div>
          </div>
        </div>
      </div>

      <!-- Empty State -->
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

      <!-- Loading More -->
      <div v-if="isLoadingMore" class="flex justify-center items-center py-8">
        <div class="flex items-center gap-2 px-6 py-3 bg-white shadow-md rounded-full border border-orange-100">
          <div class="w-5 h-5 border-2 border-orange-500 border-t-transparent rounded-full animate-spin"></div>
          <span class="text-sm font-semibold text-orange-600">Memuat produk...</span>
        </div>
      </div>

      <!-- Load More Trigger -->
      <div ref="loadMoreTrigger" class="h-4 w-full"></div>
    </div>
  </section>
</template>

<script setup>
import { ref, computed, onMounted, onBeforeUnmount } from 'vue';
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
  products:      { type: Array,   default: () => [] },
  isLoading:     { type: Boolean, default: false },
  isLoadingMore: { type: Boolean, default: false },
  hasMore:       { type: Boolean, default: true },
});

const emit = defineEmits(['load-more']);

const loadMoreTrigger = ref(null);
let observer  = null;
let slideTimer = null;
let countTimer = null;

// ─── Category filter ─────────────────────────────────────────────────────────
const activeCategory = ref('all');
const categories = ['all', 'batik', 'kerajinan', 'aksesoris', 'dekorasi', 'fashion'];

const filteredProducts = computed(() => {
  if (activeCategory.value === 'all') return props.products;
  return props.products.filter(p => p.category === activeCategory.value);
});

// ─── Carousel ────────────────────────────────────────────────────────────────
const currentSlide = ref(0);

const promoSlides = [
  {
    title: "Diskon 50% Produk Batik",
    description: "Koleksi batik terbaik dari pengrajin lokal.",
    image: "https://plus.unsplash.com/premium_photo-1673429738990-2b85964723ad?q=80&w=1470&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
  },
  {
    title: "Kerajinan Handmade Premium",
    description: "Produk unik buatan tangan asli Indonesia.",
    image: "https://images.unsplash.com/photo-1506806732259-39c2d0268443?q=80&w=1172&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
  },
  {
    title: "Dekorasi Rumah Estetik",
    description: "Percantik rumah dengan sentuhan budaya.",
    image: "https://images.unsplash.com/photo-1600585154340-be6161a56a0c?q=80&w=1200"
  }
];

// ─── Flash Sale ───────────────────────────────────────────────────────────────
const countdown = ref(['03', '27', '14']);

const flashItems = [
  {
    id: 1,
    icon: '🎨',
    name: 'Batik Parang Premium',
    discount: 60,
    salePrice: 114000,
    origPrice: 285000,
    stockPct: 72,
    remaining: 28,
    bgColor: '#FFF0EB',
    badgeColor: '#E84B0E',
  },
  {
    id: 2,
    icon: '🏺',
    name: 'Anyaman Rotan Bali',
    discount: 45,
    salePrice: 107000,
    origPrice: 195000,
    stockPct: 55,
    remaining: 45,
    bgColor: '#ECFDF5',
    badgeColor: '#16A34A',
  },
  {
    id: 3,
    icon: '💍',
    name: 'Gelang Perak Ukir',
    discount: 30,
    salePrice: 87000,
    origPrice: 125000,
    stockPct: 88,
    remaining: 12,
    bgColor: '#F5F3FF',
    badgeColor: '#7C3AED',
  },
  {
    id: 4,
    icon: '🪴',
    name: 'Vas Keramik Jawa',
    discount: 50,
    salePrice: 160000,
    origPrice: 320000,
    stockPct: 40,
    remaining: 60,
    bgColor: '#FFF7ED',
    badgeColor: '#EA580C',
  },
];

const formatPrice = (n) => 'Rp' + Number(n).toLocaleString('id-ID');

// ─── Countdown timer ──────────────────────────────────────────────────────────
const startCountdown = () => {
  let secs = 3 * 3600 + 27 * 60 + 14;
  const pad = (n) => String(n).padStart(2, '0');
  countTimer = setInterval(() => {
    if (secs <= 0) { clearInterval(countTimer); return; }
    secs--;
    countdown.value = [
      pad(Math.floor(secs / 3600)),
      pad(Math.floor((secs % 3600) / 60)),
      pad(secs % 60),
    ];
  }, 1000);
};

// ─── Cart & Wishlist ──────────────────────────────────────────────────────────
const addToCart = async (product) => { await cartStore.addItem(product); };
const isWishlisted = (productId) => wishlistStore.isWishlisted(productId);
const toggleWishlist = async (product) => { await wishlistStore.toggleWishlist(product); };
const viewProductDetail = (product) => {
  router.push({ name: 'marketplace.product.detail', params: { id: product.id } });
};

// ─── Lifecycle ────────────────────────────────────────────────────────────────
onMounted(() => {
  // Auto-slide carousel
  slideTimer = setInterval(() => {
    currentSlide.value = (currentSlide.value + 1) % promoSlides.length;
  }, 4000);

  // Countdown
  startCountdown();

  // Infinite scroll observer
  observer = new IntersectionObserver((entries) => {
    if (entries[0].isIntersecting && props.hasMore && !props.isLoading && !props.isLoadingMore) {
      emit('load-more');
    }
  }, { rootMargin: '100px' });

  if (loadMoreTrigger.value) {
    observer.observe(loadMoreTrigger.value);
  }
});

onBeforeUnmount(() => {
  if (observer)    observer.disconnect();
  if (slideTimer)  clearInterval(slideTimer);
  if (countTimer)  clearInterval(countTimer);
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

/* Fade In */
@keyframes fadeIn {
  from { opacity: 0; transform: translateY(20px); }
  to   { opacity: 1; transform: translateY(0); }
}
.animate-fade-in { animation: fadeIn 0.8s ease-out; }

/* Flash badge blink — daftarkan juga di tailwind.config jika ingin pakai kelas */
@keyframes flash-blink {
  0%, 100% { opacity: 1; }
  50%       { opacity: 0.55; }
}
.animate-flash-blink { animation: flash-blink 1s ease-in-out infinite; }

/* Smooth hover */
.group:hover .group-hover\:scale-110 { transform: scale(1.1); }

/* Gradient text */
.bg-clip-text {
  -webkit-background-clip: text;
  background-clip: text;
}
</style>
