<template>
  <section id="marketplace" class="pt-10 pb-24 relative overflow-hidden bg-transparent">
    <!-- Clean background, elements removed to keep it simple -->

    <div class="max-w-[1360px] mx-auto px-6 relative z-10">
      <!-- PROMO CAROUSEL -->
      <div v-if="isHomepage" class="mb-7 px-2 md:px-0" data-aos="fade-up">
        <div class="overflow-hidden rounded-3xl relative">

          <!-- Slides -->
          <div class="flex transition-transform duration-700"
            :style="{ transform: `translateX(-${currentSlide * 100}%)` }">
            <div v-for="(slide, index) in promoSlides" :key="index"
              class="min-w-full h-[180px] md:h-[220px] lg:h-[240px] relative rounded-[24px] overflow-hidden bg-[#9a948c]">
              <!-- Background -->
              <img :src="slide.image" class="absolute inset-0 w-full h-full object-cover opacity-80 mix-blend-overlay" @error="$event.target.style.display='none'" />

              <!-- Overlay -->
              <div class="absolute inset-0 bg-black/20"></div>

              <!-- Content Wrapper (BIAR TIDAK NEMPEL) -->
              <div class="relative z-10 h-full flex items-center">
                <div class="w-full max-w-[1360px] mx-auto px-6 md:px-10">

                  <div class="max-w-2xl text-white">
                    <span v-if="slide.tag" class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-black/30 backdrop-blur-sm border border-white/20 text-[10px] font-black uppercase tracking-[0.2em] mb-3">
                      <span class="w-1.5 h-1.5 bg-orange-400 rounded-full"></span>
                      {{ slide.tag }}
                    </span>
                    
                    <h3 class="text-2xl md:text-3xl font-black mb-3 leading-tight tracking-tight">
                      {{ slide.title }}
                    </h3>

                    <p class="text-sm md:text-base text-white/90 mb-6 max-w-lg leading-relaxed">
                      {{ slide.description }}
                    </p>

                    <button
                      class="bg-terracotta px-6 py-3 rounded-xl font-bold text-xs uppercase tracking-widest hover:bg-terracottaDark transition-all shadow-lg hover:shadow-terracotta/30">
                      Jelajahi Koleksi
                    </button>
                  </div>

                </div>
              </div>
            </div>
          </div>

          <!-- Indicator -->
          <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex gap-2">
            <span v-for="(slide, index) in promoSlides" :key="index" @click="currentSlide = index"
              class="h-2 rounded-full cursor-pointer transition-all"
              :class="currentSlide === index ? 'bg-terracotta w-6' : 'bg-surface/50 w-2'"></span>
          </div>

        </div>
      </div>
      <!-- Header with Animation
      <div class="text-center mb-16 animate-fade-in">


        <h2 class="text-5xl md:text-6xl font-black tracking-tighter mb-4">
          <span class="text-espresso">Indonesian Craft</span>
          <span class="block text-terracotta">Marketplace</span>
        </h2>
        <p class="text-muted text-lg max-w-2xl mx-auto font-medium">
          Koleksi terkurasi dari pengrajin terbaik seluruh Indonesia. Setiap produk dibuat dengan cinta dan keahlian
          turun-temurun.
        </p>
      </div> -->

      <!-- INNOVATION FEATURES SECTION (Only for Homepage) -->
      <div v-if="isHomepage" class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-9" data-aos="fade-up" data-aos-delay="50">
        
        <!-- AI Studio -->
        <div class="bg-surface border border-borderSoft min-h-[82px] p-4 rounded-2xl shadow-sm hover:shadow-md hover:border-terracotta transition-all duration-300 flex items-center gap-4 cursor-pointer">
          <div class="w-10 h-10 rounded-xl bg-terracotta/10 flex items-center justify-center shrink-0">
            <svg class="w-5 h-5 text-terracotta" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
            </svg>
          </div>
          <div>
            <h3 class="text-sm font-black text-espresso mb-0.5">AI Product Studio</h3>
            <p class="text-[11px] text-muted leading-tight">Analisis tren & optimasi metadata otomatis untuk UMKM.</p>
          </div>
        </div>

        <!-- AR Try-On -->
        <div class="bg-surface border border-borderSoft min-h-[82px] p-4 rounded-2xl shadow-sm hover:shadow-md hover:border-indigo transition-all duration-300 flex items-center gap-4 cursor-pointer">
          <div class="w-10 h-10 rounded-xl bg-indigo/10 flex items-center justify-center shrink-0">
            <svg class="w-5 h-5 text-indigo" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            </svg>
          </div>
          <div>
            <h3 class="text-sm font-black text-espresso mb-0.5">AR Try-On</h3>
            <p class="text-[11px] text-muted leading-tight">Visualisasikan kerajinan & dekorasi langsung di ruanganmu.</p>
          </div>
        </div>

        <!-- Co-Create Room -->
        <div class="bg-surface border border-borderSoft min-h-[82px] p-4 rounded-2xl shadow-sm hover:shadow-md hover:border-olive transition-all duration-300 flex items-center gap-4 cursor-pointer">
          <div class="w-10 h-10 rounded-xl bg-olive/10 flex items-center justify-center shrink-0">
            <svg class="w-5 h-5 text-olive" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
          </div>
          <div>
            <h3 class="text-sm font-black text-espresso mb-0.5">Co-Create Room</h3>
            <p class="text-[11px] text-muted leading-tight">Kolaborasi desain custom langsung dengan pengrajin lokal.</p>
          </div>
        </div>

      </div>

      <!-- Section Title -->
      <div class="flex items-center justify-between mb-4 mt-8">
        <h2 class="text-xl md:text-2xl font-black text-espresso flex items-center gap-3">
          <span class="w-1.5 h-6 bg-terracotta rounded-full"></span>
          Koleksi Pilihan Nusantara
        </h2>
        <a href="#" class="text-xs font-bold text-terracotta hover:text-terracottaDark transition-colors flex items-center gap-1">
          Lihat Semua
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
        </a>
      </div>



      <!-- Loading State with Better Skeleton -->
      <div v-if="isLoading" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
        <div v-for="i in 10" :key="i" class="animate-pulse">
          <div class="h-[180px] bg-gray-200 rounded-3xl mb-4"></div>
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
      <div v-else class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
        <div v-for="(product, index) in filteredProducts" :key="product.id" @click="viewProductDetail(product)" class="bg-surface border border-borderSoft shadow-sm hover:border-terracotta hover:shadow-xl transition-all duration-300 rounded-3xl group overflow-hidden flex flex-col h-full cursor-pointer hover:-translate-y-1 relative" data-aos="fade-up" :data-aos-delay="(index % 6) * 50">
          
          <!-- Image Section -->
          <div class="relative w-full h-[180px] bg-gray-100 isolate overflow-hidden border-b border-borderSoft">
            <!-- Category Badge -->
            <div class="absolute top-2 left-2 z-20">
              <span class="inline-flex items-center gap-1.5 bg-surface/95 backdrop-blur-md px-2 py-1 rounded-full text-[8px] font-black uppercase tracking-widest shadow-sm border border-terracotta/20">
                <span class="w-1.5 h-1.5 bg-terracotta rounded-full"></span>
                {{ product.category }}
              </span>
            </div>

            <!-- Action Buttons (from incoming) -->
            <div class="absolute top-2 right-2 z-20 flex flex-col gap-2 opacity-0 group-hover:opacity-100 transition-all duration-300 translate-x-4 group-hover:translate-x-0">
              <!-- Wishlist -->
              <button @click.stop="toggleWishlist(product)" class="w-8 h-8 bg-surface/95 backdrop-blur-md rounded-full flex items-center justify-center hover:bg-surface hover:scale-110 active:scale-95 transition-all shadow-sm" :class="isWishlisted(product.id) ? 'text-red-500' : 'text-espresso'">
                <svg class="w-4 h-4" :class="isWishlisted(product.id) ? 'fill-current' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                </svg>
              </button>
            </div>

            <img :src="product.images && product.images.length ? product.images[0] : 'https://images.unsplash.com/photo-1617627143750-d86bc21e42bb?q=80&w=1000'" :alt="product.name" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" />
            
            <!-- Hover Overlay -->
            <div class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity z-10"></div>

            <!-- Quick Add to Cart (Bottom Overlay) -->
            <div class="absolute bottom-0 left-0 right-0 p-2 z-20 translate-y-full group-hover:translate-y-0 transition-transform duration-300">
              <button @click.stop="addToCart(product)" class="w-full bg-terracotta text-white py-2 rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-terracottaDark shadow-lg active:scale-95 transition-all flex items-center justify-center gap-1.5">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                + Keranjang
              </button>
            </div>
          </div>

          <!-- Product Info -->
          <div class="p-3 flex flex-col flex-1">
            <h3 class="font-medium text-xs mb-1 text-espresso line-clamp-2 leading-tight group-hover:text-terracotta transition-colors">
              {{ product.name }}
            </h3>
            
            <p v-if="product.umkm_name" class="text-[10px] text-muted mb-1.5 flex items-center gap-1">
              <svg class="w-3 h-3 text-terracotta" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
              {{ product.umkm_name }}
            </p>

            <div class="flex items-center gap-1 mb-2">
              <svg class="w-3 h-3 text-gold fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" /></svg>
              <span class="text-[10px] font-bold text-espresso">{{ product.rating || '4.8' }}</span>
              <span class="text-[10px] text-muted">• {{ product.sold || '120' }} terjual</span>
            </div>
            
            <p v-if="product.origin" class="text-[10px] text-muted flex items-center gap-1 mb-2">
              <svg class="w-3 h-3 text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
              {{ product.origin }}
            </p>

            <!-- Spacer -->
            <div class="flex-1"></div>

            <div v-if="product.badges && product.badges.length" class="flex flex-wrap gap-1 mb-2">
              <span v-for="badge in product.badges.slice(0,2)" :key="badge" class="text-[8px] px-1.5 py-0.5 border border-terracotta/30 text-terracotta rounded bg-terracotta/5 font-semibold">
                {{ badge }}
              </span>
            </div>

            <!-- Price & Sold -->
            <div class="flex items-center justify-between mt-auto pt-1">
              <p class="text-base font-bold text-terracotta tracking-tight">
                <span class="text-[11px] font-semibold mr-0.5">Rp</span>{{ Number(product.price).toLocaleString('id-ID') }}
              </p>
            </div>
          </div>
        </div>
      </div>

      <!-- Empty State with Better Design -->
      <div v-if="!isLoading && filteredProducts.length === 0" class="py-32 text-center">
        <div class="max-w-md mx-auto">
          <div class="w-24 h-24 bg-sand rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="w-12 h-12 text-terracotta" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
            </svg>
          </div>
          <h3 class="text-2xl font-black text-espresso mb-3">Belum Ada Produk</h3>
          <p class="text-muted mb-6">Belum ada koleksi yang dipublikasikan untuk kategori <span
              class="font-bold text-terracotta">{{ activeCategory }}</span>.</p>
          <button @click="activeCategory = 'all'"
            class="inline-flex items-center gap-2 bg-terracotta text-white px-6 py-3 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-terracottaDark hover:shadow-xl transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
            </svg>
            Lihat Semua Produk
          </button>
        </div>
      </div>
      <!-- Loading More State -->
      <div v-if="isLoadingMore" class="flex justify-center items-center py-8">
        <div class="flex items-center gap-2 px-6 py-3 bg-surface shadow-md rounded-full border border-terracotta/20">
          <div class="w-5 h-5 border-2 border-orange-500 border-t-transparent rounded-full animate-spin"></div>
          <span class="text-sm font-semibold text-terracotta">Memuat produk...</span>
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
  products: { type: Array, default: () => [] },
  isLoading: { type: Boolean, default: false },
  isLoadingMore: { type: Boolean, default: false },
  hasMore: { type: Boolean, default: true },
  isHomepage: { type: Boolean, default: false }
});

const emit = defineEmits(['load-more']);

const loadMoreTrigger = ref(null);
let observer = null;

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

const currentSlide = ref(0);

const promoSlides = [
  {
    title: "Sentuhan Tradisional, Kualitas Internasional",
    description: "Setiap produk adalah hasil kurasi ketat dari pengrajin maestro, memadukan teknik warisan leluhur dengan estetika kontemporer.",
    image: "/assets/banner1.png",
    tag: "LIMITED COLLECTION"
  },
  {
    title: "Karya Tangan Terbaik Pengrajin Lokal",
    description: "Dukung perekonomian lokal dengan membeli produk langsung dari pembuatnya.",
    image: "/assets/banner2.png",
    tag: "BANGGA BUATAN INDONESIA"
  },
  {
    title: "Dekorasi Rumah Berbalut Budaya",
    description: "Percantik ruangan Anda dengan sentuhan estetika tradisional yang tak lekang oleh waktu.",
    image: "/assets/banner3.png",
    tag: "NEW ARRIVALS"
  }
];

onMounted(() => {
  setInterval(() => {
    currentSlide.value =
      (currentSlide.value + 1) % promoSlides.length;
  }, 4000);

  // Intersection Observer for Infinite Scroll
  observer = new IntersectionObserver((entries) => {
    if (entries[0].isIntersecting && props.hasMore && !props.isLoading && !props.isLoadingMore) {
      emit('load-more');
    }
  }, {
    rootMargin: '100px',
  });

  if (loadMoreTrigger.value) {
    observer.observe(loadMoreTrigger.value);
  }
});

onBeforeUnmount(() => {
  if (observer) {
    observer.disconnect();
  }
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
  line-clamp: 2;
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
