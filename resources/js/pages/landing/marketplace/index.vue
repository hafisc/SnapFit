<template>
  <div class="snapfit-heritage-bg min-h-screen text-espresso overflow-x-hidden relative">
    <!-- Navbar -->
    <Navbar
      :user="user"
      @logout="logout"
      @goToLogin="goToLogin"
      @goToProfile="goToProfile"
      @goToOrders="goToOrders"
    />

    <main class="pt-16">
      <section class="bg-surface border-b border-borderSoft pt-6 pb-6 mt-2">
        <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8">
          <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-5">
            <div>
              <h1 class="text-2xl md:text-3xl font-black text-espresso mb-1.5">Katalog Produk Nusantara</h1>
              <p class="text-sm text-muted">Temukan batik, tenun, kerajinan, aksesoris, dan dekorasi lokal dari UMKM terkurasi.</p>
            </div>
            
            <div class="flex flex-wrap gap-2">
              <select class="py-2.5 px-4 rounded-xl border border-borderSoft bg-white text-xs font-bold text-espresso focus:outline-none focus:border-terracotta cursor-pointer hover:border-terracotta transition-colors shadow-sm">
                <option>Daerah Asal: Semua</option>
                <option>Yogyakarta</option>
                <option>Bali</option>
                <option>Jepara</option>
                <option>Sumba</option>
              </select>
              
              <select class="py-2.5 px-4 rounded-xl border border-borderSoft bg-white text-xs font-bold text-espresso focus:outline-none focus:border-terracotta cursor-pointer hover:border-terracotta transition-colors shadow-sm">
                <option>Urutkan: Terbaru</option>
                <option>Terlaris</option>
                <option>Harga Terendah</option>
                <option>Harga Tertinggi</option>
              </select>
            </div>
          </div>
          
          <div class="flex flex-wrap gap-2">
            <button class="px-4 py-1.5 rounded-full text-xs font-bold border transition-colors bg-terracotta border-terracotta text-white">Semua</button>
            <button v-for="cat in ['Batik', 'Tenun', 'Kerajinan', 'Aksesoris', 'Dekorasi', 'Fashion', 'AR Ready']" :key="cat" class="px-4 py-1.5 rounded-full text-xs font-bold border border-borderSoft bg-white text-muted hover:border-terracotta hover:text-terracotta transition-colors">
              {{ cat }}
            </button>
          </div>
        </div>
      </section>

      <section ref="productSection" class="bg-slate-50 pt-8 pb-24">
        <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8">
          <ProductGrid :products="products" :isLoading="isLoading" :isLoadingMore="isLoadingMore" :hasMore="hasMore" @load-more="fetchMore" :is-homepage="false" />
        </div>
      </section>
    </main>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import ProductGrid from '@/components/landing/ProductGrid.vue';
import Navbar from '@/pages/landing/partials/Navbar.vue';

const router = useRouter();
const user = ref(null);
const products = ref([]);
const isLoading = ref(true);
const productSection = ref(null);

const page = ref(1);
const hasMore = ref(true);
const isLoadingMore = ref(false);

const parseImages = (item) => {
  if (typeof item.images === 'string') {
    try {
      return JSON.parse(item.images);
    } catch {
      return [];
    }
  }
  return item.images || [];
};

const fetchProducts = async () => {
  isLoading.value = true;
  page.value = 1;
  try {
    const res = await fetch(`/api/v1/products?page=1&per_page=12`, {
      headers: { Accept: 'application/json' },
    });

    if (!res.ok) {
      products.value = [];
      return;
    }

    const data = await res.json();
    const fetched = Array.isArray(data) ? data : data.data || [];

    products.value = fetched
      .filter((product) => product.is_published)
      .map((product) => ({
        ...product,
        images: parseImages(product),
        inWishlist: false,
      }));

    if (data.pagination) {
      hasMore.value = data.pagination.current_page < data.pagination.last_page;
    } else {
      hasMore.value = fetched.length > 0;
    }
  } catch (error) {
    console.error('Failed to load marketplace products:', error);
    products.value = [];
  } finally {
    isLoading.value = false;
  }
};

const fetchMore = async () => {
  if (!hasMore.value || isLoadingMore.value) return;
  isLoadingMore.value = true;
  page.value++;

  try {
    const res = await fetch(`/api/v1/products?page=${page.value}&per_page=12`, {
      headers: { Accept: 'application/json' },
    });

    if (!res.ok) return;

    const data = await res.json();
    const fetched = Array.isArray(data) ? data : data.data || [];

    const newProducts = fetched
      .filter((product) => product.is_published)
      .map((product) => ({
        ...product,
        images: parseImages(product),
        inWishlist: false,
      }));

    products.value.push(...newProducts);

    if (data.pagination) {
      hasMore.value = data.pagination.current_page < data.pagination.last_page;
    } else {
      hasMore.value = fetched.length > 0;
    }
  } catch (error) {
    console.error('Failed to load more products:', error);
  } finally {
    isLoadingMore.value = false;
  }
};

const scrollToProducts = () => {
  productSection.value?.scrollIntoView({ behavior: 'smooth', block: 'start' });
};

/* ── Navigation ───────────────────────────────────────── */
const goToLogin   = () => router.push('/login');
const goToProfile = () => console.log('Navigate to profile');
const goToOrders  = () => router.push('/marketplace/orders');

const logout = () => {
  localStorage.removeItem('user');
  localStorage.removeItem('token');
  user.value = null;
  router.push('/');
};

onMounted(() => {
  const stored = localStorage.getItem('user');
  if (stored) user.value = JSON.parse(stored);
  fetchProducts();
});
</script>

<style scoped>
.scrollbar-hide::-webkit-scrollbar { display: none; }
.scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
</style>
