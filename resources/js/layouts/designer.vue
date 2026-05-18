<template>
  <div class="min-h-screen bg-[#f4f5f7] flex text-espresso font-sans">
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
      <div class="flex-1 overflow-y-auto p-6 lg:p-8 no-scrollbar">
        <RouterView />
      </div>
    </main>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import { useRouter, useRoute } from 'vue-router';
import Sidebar from '@/pages/designer/partials/Sidebar.vue';
import Header from '@/pages/designer/partials/Header.vue';

const sidebarOpen = ref(false);
const router = useRouter();
const route = useRoute();
const user = ref(null);

onMounted(() => {
  const d = localStorage.getItem('user');
  if (d) user.value = JSON.parse(d);
});

const pageMap = {
  '/designer/dashboard': { title: 'Dashboard', desc: 'Ringkasan aktivitas & kolaborasi Anda' },
  '/designer/cocreate': { title: 'Co-Create Room', desc: 'Kelola undangan & room kolaborasi bersama UMKM' },
  '/designer/portfolio': { title: 'Portofolio Desain', desc: 'Showcase desain terbaik Anda' },
  '/designer/history': { title: 'Riwayat Kolaborasi', desc: 'Riwayat semua kolaborasi yang pernah Anda ikuti' },
  '/designer/settings': { title: 'Pengaturan Profil', desc: 'Kelola informasi akun dan preferensi' },
};

const currentPageTitle = computed(() => {
  const m = Object.entries(pageMap).find(([p]) => route.path.startsWith(p));
  return m ? m[1].title : 'Designer Studio';
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
