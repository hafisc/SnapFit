<template>
  <div class="min-h-screen bg-white text-gray-900 font-sans selection:bg-orange-100 overflow-x-hidden">
    <!-- Navbar -->
    <Navbar
      :user="user"
      @logout="logout"
      @goToLogin="goToLogin"
      @goToProfile="goToProfile"
      @goToOrders="goToOrders"
    />

    <main class="pt-16">
      <!-- Hero Section -->
      <HeroSection />

      <!-- Features Section -->
      <!-- <FeaturesSection /> -->

      <!-- Marketplace / Product Grid -->
      <ProductGrid
        :products="products"
        :isLoading="isLoading"
      />

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

// Landing sections
import HeroSection     from '@/components/landing/HeroSection.vue';
import FeaturesSection from '@/components/landing/FeaturesSection.vue';
import ProductGrid     from '@/components/landing/ProductGrid.vue';
import StatsSection    from '@/components/landing/StatsSection.vue';

const router    = useRouter();
const user      = ref(null);
const products  = ref([]);
const isLoading = ref(false);

/* ── API ──────────────────────────────────────────────── */
const fetchProducts = async () => {
  isLoading.value = true;
  try {
    const res = await fetch('/api/v1/products', {
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
  } catch (err) {
    console.error('Fetch error:', err);
  } finally {
    isLoading.value = false;
  }
};

/* ── Navigation ───────────────────────────────────────── */
const goToLogin   = () => router.push('/login');
const goToProfile = () => console.log('Navigate to profile');
const goToOrders  = () => console.log('Navigate to orders');

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
