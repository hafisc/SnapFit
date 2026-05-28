<template>
  <div class="min-h-screen snapfit-heritage-bg flex text-espresso font-sans">
    <!-- Mobile Overlay -->
    <Transition name="fade">
      <div v-if="sidebarOpen" class="fixed inset-0 bg-black/20 backdrop-blur-sm z-30 lg:hidden" @click="sidebarOpen = false"></div>
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
import Sidebar from '@/pages/admin/partials/Sidebar.vue';
import Header from '@/pages/admin/partials/Header.vue';

const sidebarOpen = ref(false);
const router = useRouter();
const route = useRoute();
const user = ref(null);

onMounted(async () => {
  const d = localStorage.getItem('user');
  if (d) user.value = JSON.parse(d);

  // Verifikasi token/sesi dengan backend
  const token = localStorage.getItem('token');
  if (token) {
    try {
      const res = await fetch('/api/v1/auth/me', {
        headers: {
          'Authorization': `Bearer ${token}`,
          'Accept': 'application/json'
        }
      });
      if (res.status === 401) {
        logout();
      }
    } catch (e) {
      console.error('Failed to verify session:', e);
    }
  }
});

const pageMap = {
  '/admin/dashboard': { title: 'Dasbor', desc: 'Ringkasan performa platform SnapFit' },
  '/admin/users': { title: 'Kelola Pengguna', desc: 'Manajemen semua pengguna platform' },
  '/admin/products': { title: 'Moderasi Produk', desc: 'Review dan moderasi produk UMKM' },
  '/admin/orders': { title: 'Kelola Pesanan', desc: 'Pantau seluruh transaksi marketplace' },
  '/admin/analytics': { title: 'Analitik Global', desc: 'Insight dan metrik performa platform' },
  '/admin/roles': { title: 'Peran & Izin', desc: 'Manajemen akses dan hak pengguna' },
};

const currentPageTitle = computed(() => {
  const m = Object.entries(pageMap).find(([p]) => route.path.startsWith(p));
  return m ? m[1].title : 'Konsol Admin';
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
