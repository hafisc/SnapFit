<template>
  <div class="min-h-screen bg-white text-gray-900 font-sans selection:bg-orange-100 overflow-x-hidden">
    <!-- Welcome Modal -->
    <!-- <WelcomeModal /> -->

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

      <!-- Features Section (Innovation Showcase) -->
      <!-- <FeaturesSection /> -->

      <!-- Testimonials + CTA -->
      <!-- <StatsSection /> -->
    </main>

    <!-- Footer -->
    <!-- <Footer /> -->
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';

// Layout components
import Navbar   from '@/components/common/Navbar.vue';
import Footer   from '@/components/common/Footer.vue';
import WelcomeModal from '@/components/common/WelcomeModal.vue';

// Landing sections
import FeaturesSection from '@/components/landing/FeaturesSection.vue';
import ProductGrid     from '@/components/landing/ProductGrid.vue';
import StatsSection    from '@/components/landing/StatsSection.vue';

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
