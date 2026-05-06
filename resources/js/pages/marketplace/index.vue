<template>
  <div class="min-h-screen bg-slate-50 text-slate-900 overflow-x-hidden">
    <!-- Navbar -->
    <Navbar
      :user="user"
      @logout="logout"
      @goToLogin="goToLogin"
      @goToProfile="goToProfile"
      @goToOrders="goToOrders"
    />

    <main class="pt-16">
      <section class="relative overflow-hidden bg-white pb-16">
      <div class="absolute inset-x-0 top-0 h-80 bg-orange-50"></div>
      <div class="relative max-w-[1400px] mx-auto px-6 py-16 lg:py-24">
        <div class="grid gap-10 lg:grid-cols-[1.2fr_0.8fr] items-center">
          <div class="space-y-6 max-w-2xl">
            <span class="inline-flex items-center gap-2 rounded-full bg-orange-100 px-4 py-2 text-sm font-black uppercase tracking-[0.2em] text-orange-700">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18M3 17h18" />
              </svg>
              Authentic Indonesian Crafts
            </span>
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black tracking-tight text-slate-900">
              Discover handmade fashion, accessories, and home decor from local artisans.
            </h1>
            <p class="text-lg leading-8 text-slate-600 max-w-xl">
              SnapFit brings curated local products to your fingertips. Browse premium collections, compare trusted sellers, and shop with confidence.
            </p>
            <div class="flex flex-col sm:flex-row gap-3">
              <router-link to="/marketplace" class="inline-flex items-center justify-center rounded-3xl bg-orange-600 px-6 py-3 text-sm font-black uppercase tracking-[0.16em] text-white shadow-lg shadow-orange-200/50 hover:bg-orange-700 transition-all">
                Browse Marketplace
              </router-link>
              <button @click="scrollToProducts" class="inline-flex items-center justify-center rounded-3xl border border-slate-200 bg-white px-6 py-3 text-sm font-black uppercase tracking-[0.16em] text-slate-900 hover:border-orange-400 hover:text-orange-600 transition-all">
                Explore Collections
              </button>
            </div>
          </div>
          <div class="grid gap-6 sm:grid-cols-2">
            <div class="rounded-[2rem] bg-white p-6 shadow-xl border border-slate-200">
              <p class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-400 mb-4">Trusted Sellers</p>
              <h2 class="text-3xl font-black text-slate-900">500+</h2>
              <p class="mt-3 text-slate-600">Verified creative businesses across Indonesia selling premium handcrafted goods.</p>
            </div>
            <div class="rounded-[2rem] bg-white p-6 shadow-xl border border-slate-200">
              <p class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-400 mb-4">Fast Shipping</p>
              <h2 class="text-3xl font-black text-slate-900">Next-day delivery</h2>
              <p class="mt-3 text-slate-600">Enjoy fast shipping with trusted couriers and live tracking for every order.</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section ref="productSection" class="bg-slate-50 pt-12 pb-24">
      <div class="max-w-[1400px] mx-auto px-6">
        <div class="mb-10 text-center">
          <p class="text-sm font-black uppercase tracking-[0.25em] text-orange-600 mb-3">Marketplace</p>
          <h2 class="text-4xl font-black text-slate-900">Featured Products</h2>
          <p class="mt-3 text-slate-600 max-w-2xl mx-auto">Browse best-selling items, curated collections, and the latest arrivals from our UMKM partners.</p>
        </div>

        <ProductGrid :products="products" :isLoading="isLoading" />
      </div>
    </section>
    </main>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import ProductGrid from '@/components/landing/ProductGrid.vue';
import Navbar from '@/components/common/Navbar.vue';

const router = useRouter();
const user = ref(null);
const products = ref([]);
const isLoading = ref(true);
const productSection = ref(null);

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
  try {
    const res = await fetch('/api/v1/products', {
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
  } catch (error) {
    console.error('Failed to load marketplace products:', error);
    products.value = [];
  } finally {
    isLoading.value = false;
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
