<template>
  <div class="min-h-screen bg-[#FFF8F0] text-slate-900 font-sans selection:bg-orange-500 selection:text-white overflow-x-hidden relative">
    
    <!-- ═══ HIGH-END INTERNATIONAL BACKGROUND SYSTEM ═══ -->
    <div class="fixed inset-0 pointer-events-none z-0 overflow-hidden bg-[#FAFAFA]">
      
      <!-- 1) Complex Liquid Mesh Gradient (CSS-only volumetric lighting) -->
      <div class="absolute inset-0 opacity-60 mix-blend-multiply" 
           style="background-image: 
             radial-gradient(at 40% 20%, hsla(28,100%,74%,1) 0px, transparent 50%),
             radial-gradient(at 80% 0%, hsla(189,100%,56%,0.2) 0px, transparent 50%),
             radial-gradient(at 0% 50%, hsla(355,100%,93%,1) 0px, transparent 50%),
             radial-gradient(at 80% 50%, hsla(340,100%,76%,0.4) 0px, transparent 50%),
             radial-gradient(at 0% 100%, hsla(22,100%,77%,1) 0px, transparent 50%),
             radial-gradient(at 80% 100%, hsla(242,100%,70%,0.2) 0px, transparent 50%),
             radial-gradient(at 0% 0%, hsla(343,100%,76%,0.3) 0px, transparent 50%);
             filter: blur(80px);">
      </div>

      <!-- 2) Breathing Ambient Orbs (Animated) -->
      <div class="absolute top-[-10%] right-[-10%] w-[60vw] h-[60vw] rounded-full bg-gradient-to-br from-orange-200/40 to-rose-200/20 blur-[120px] animate-breathe-slow mix-blend-overlay"></div>
      <div class="absolute bottom-[-20%] left-[-10%] w-[70vw] h-[70vw] rounded-full bg-gradient-to-tr from-amber-100/50 to-orange-100/30 blur-[140px] animate-breathe-slow-delayed mix-blend-overlay"></div>

      <!-- 3) Technical Blueprint Grid (Ultra Subtle) -->
      <div class="absolute inset-0" 
           style="background-image: 
             linear-gradient(to right, rgba(15, 23, 42, 0.02) 1px, transparent 1px),
             linear-gradient(to bottom, rgba(15, 23, 42, 0.02) 1px, transparent 1px);
           background-size: 40px 40px;
           mask-image: radial-gradient(ellipse at center, black 20%, transparent 80%);
           -webkit-mask-image: radial-gradient(ellipse at center, black 20%, transparent 80%);">
      </div>

      <!-- 4) Fine Film Grain / Noise Texture (Crucial for premium feel) -->
      <div class="absolute inset-0 opacity-[0.05] mix-blend-overlay pointer-events-none" 
           style="background-image: url('data:image/svg+xml,%3Csvg viewBox=%220 0 200 200%22 xmlns=%22http://www.w3.org/2000/svg%22%3E%3Cfilter id=%22noiseFilter%22%3E%3CfeTurbulence type=%22fractalNoise%22 baseFrequency=%220.85%22 numOctaves=%223%22 stitchTiles=%22stitch%22/%3E%3C/filter%3E%3Crect width=%22100%25%22 height=%22100%25%22 filter=%22url(%23noiseFilter)%22/%3E%3C/svg%3E');">
      </div>
      
      <!-- 5) Glassmorphism Frosted Layer Overlay -->
      <div class="absolute inset-0 backdrop-blur-[1px] bg-white/10"></div>
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
import Navbar from '@/pages/landing/partials/Navbar.vue';

// Landing sections
import ProductGrid     from './section/ProductGrid.vue';

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
  // Check for token in URL (from Google OAuth redirect)
  const urlParams = new URLSearchParams(window.location.search);
  const token = urlParams.get('token');
  
  if (token) {
    // Save token to localStorage
    localStorage.setItem('token', token);
    
    // Fetch user data with the token
    fetch('/api/v1/auth/me', {
      headers: {
        'Authorization': `Bearer ${token}`,
        'Accept': 'application/json'
      }
    })
    .then(res => res.json())
    .then(data => {
      if (data.user) {
        localStorage.setItem('user', JSON.stringify(data.user));
        user.value = data.user;
      }
      // Clean URL (remove token from query params)
      window.history.replaceState({}, document.title, window.location.pathname);
    })
    .catch(err => {
      console.error('Failed to fetch user:', err);
      // Clean URL even on error
      window.history.replaceState({}, document.title, window.location.pathname);
    });
  } else {
    // Load user from localStorage if no token in URL
    const stored = localStorage.getItem('user');
    if (stored) user.value = JSON.parse(stored);
  }
  
  fetchProducts();
});
</script>

<style scoped>
/* ═══ High-End Background Animations ═══ */
@keyframes breathe-slow {
  0%, 100% { 
    transform: translate(0, 0) scale(1) rotate(0deg); 
    opacity: 0.8;
  }
  33% { 
    transform: translate(3vw, -4vh) scale(1.05) rotate(2deg); 
    opacity: 0.95;
  }
  66% { 
    transform: translate(-2vw, 3vh) scale(0.95) rotate(-1deg); 
    opacity: 0.85;
  }
}

.animate-breathe-slow {
  animation: breathe-slow 24s ease-in-out infinite;
}

.animate-breathe-slow-delayed {
  animation: breathe-slow 28s ease-in-out infinite;
  animation-delay: -12s; /* Start halfway through to offset */
}
</style>
