<template>
  <div class="min-h-screen bg-slate-50 text-slate-900 font-sans selection:bg-orange-500 selection:text-white overflow-x-hidden relative">
    
    <!-- Premium Ambient Background -->
    <div class="fixed inset-0 pointer-events-none z-0">
      <!-- Soft Orange/Amber Glows -->
      <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(251,146,60,0.08),transparent_50%),radial-gradient(circle_at_bottom_left,rgba(251,191,36,0.08),transparent_60%)]"></div>
      <!-- Subtle Grid Pattern fading out at the bottom -->
      <div class="absolute inset-0 bg-[linear-gradient(to_right,#e2e8f0_1px,transparent_1px),linear-gradient(to_bottom,#e2e8f0_1px,transparent_1px)] bg-[size:32px_32px] [mask-image:radial-gradient(ellipse_80%_60%_at_50%_0%,#000_40%,transparent_100%)] opacity-50"></div>
    </div>

    <!-- Navbar -->
    <Navbar
      :user="user"
      @logout="logout"
      @goToLogin="goToLogin"
      @goToProfile="goToProfile"
      @goToOrders="goToOrders"
    />

    <main class="pt-16">
      <!-- Marketplace / Product Grid -->
      <ProductGrid
        :products="products"
        :isLoading="isLoading"
        :isLoadingMore="isLoadingMore"
        :hasMore="hasMore"
        @load-more="fetchMore"
      />
        

    </main>


  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';

// Layout components
import Navbar   from '@/components/common/Navbar.vue';

// Landing sections
import ProductGrid     from '@/components/landing/ProductGrid.vue';

const router    = useRouter();
const user      = ref(null);
const products  = ref([]);
const isLoading = ref(false);

const page = ref(1);
const hasMore = ref(true);
const isLoadingMore = ref(false);

const fetchProducts = async () => {
  isLoading.value = true;
  page.value = 1;
  try {
    const res = await fetch(`/api/v1/products?page=1&per_page=12`, {
      headers: { 'Accept': 'application/json' }
    });
    if (!res.ok) throw new Error('Gagal mengambil data produk');

    const data = await res.json();
    const fetched = Array.isArray(data) ? data : (data.data ?? []);

    products.value = fetched
      .filter(p => p.is_published)
      .map(p => ({
        ...p,
        images: typeof p.images === 'string' ? JSON.parse(p.images) : p.images,
        inWishlist: false
      }));

    if (data.pagination) {
      hasMore.value = data.pagination.current_page < data.pagination.last_page;
    } else {
      hasMore.value = fetched.length > 0;
    }
  } catch (err) {
    console.error('Fetch error:', err);
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
      headers: { 'Accept': 'application/json' }
    });
    if (!res.ok) throw new Error('Gagal mengambil data produk');

    const data = await res.json();
    const fetched = Array.isArray(data) ? data : (data.data ?? []);

    const newProducts = fetched
      .filter(p => p.is_published)
      .map(p => ({
        ...p,
        images: typeof p.images === 'string' ? JSON.parse(p.images) : p.images,
        inWishlist: false
      }));

    products.value.push(...newProducts);

    if (data.pagination) {
      hasMore.value = data.pagination.current_page < data.pagination.last_page;
    } else {
      hasMore.value = fetched.length > 0;
    }
  } catch (err) {
    console.error('Fetch more error:', err);
  } finally {
    isLoadingMore.value = false;
  }
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

/* ── Lifecycle ────────────────────────────────────────── */
onMounted(() => {
  const stored = localStorage.getItem('user');
  if (stored) user.value = JSON.parse(stored);
  fetchProducts();
});
</script>

<style scoped>
/* Page-level styles */
</style>
