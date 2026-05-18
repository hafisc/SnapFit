<template>
  <div class="min-h-screen bg-[#f8f9fb] flex text-espresso font-sans">
    <!-- Mobile Overlay -->
    <Transition name="fade">
      <div v-if="sidebarOpen" class="fixed inset-0 bg-black/30 backdrop-blur-sm z-30 lg:hidden" @click="sidebarOpen = false"></div>
    </Transition>

    <!-- Sidebar -->
    <Sidebar :sidebar-open="sidebarOpen" :user="user" @close="sidebarOpen = false" @logout="logout" />

    <!-- Main -->
    <main class="flex-1 flex flex-col min-w-0">
      <!-- Header -->
      <Header :page-title="currentPageTitle" :page-desc="currentPageDesc" @toggle-sidebar="sidebarOpen = !sidebarOpen" />

      <!-- Content -->
      <div class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 no-scrollbar">
        <RouterView />
      </div>
    </main>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import { useRouter, useRoute } from 'vue-router';
import Sidebar from '@/pages/umkm/partials/Sidebar.vue';
import Header from '@/pages/umkm/partials/Header.vue';

const sidebarOpen = ref(false);
const router = useRouter();
const route = useRoute();
const user = ref(null);

onMounted(() => {
  const d = localStorage.getItem('user');
  if (d) user.value = JSON.parse(d);
});

const pageMap = {
  '/umkm/dashboard': { title: 'Dashboard', desc: 'Ringkasan performa toko dan penjualan' },
  '/umkm/studio': { title: 'AI Product Studio', desc: 'Generate foto produk, video 360°, dan caption AI' },
  '/umkm/products': { title: 'Produk Saya', desc: 'Kelola semua produk di toko Anda' },
  '/umkm/cocreate': { title: 'Co-Create Room', desc: 'Kolaborasi realtime dengan desainer' },
  '/umkm/orders': { title: 'Pesanan', desc: 'Kelola pesanan masuk dan pengiriman' },
  '/umkm/analytics': { title: 'Analitik & Insight', desc: 'Data penjualan dan performa produk' },
  '/umkm/settings': { title: 'Pengaturan', desc: 'Kelola profil toko dan preferensi akun' },
};

const currentPageTitle = computed(() => {
  const m = Object.entries(pageMap).find(([p]) => route.path.startsWith(p));
  return m ? m[1].title : 'Creator Hub';
});

const currentPageDesc = computed(() => {
  const m = Object.entries(pageMap).find(([p]) => route.path.startsWith(p));
  return m ? m[1].desc : '';
});

const logout = () => {
  localStorage.removeItem('user');
  localStorage.removeItem('token');
  router.push('/login');
};
</script>

<style scoped>
.no-scrollbar::-webkit-scrollbar { display: none; }
.no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
.fade-enter-active, .fade-leave-active { transition: opacity 0.2s ease; }
.fade-enter-from, .fade-leave-to { opacity: 0; }
</style>

