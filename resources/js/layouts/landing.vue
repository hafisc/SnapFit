<template>
  <div class="min-h-screen bg-surface-950">
    <!-- Navbar -->
    <nav class="fixed top-0 left-0 right-0 z-50 transition-all duration-300"
         :class="scrolled ? 'glass-strong shadow-lg shadow-purple-950/20' : 'bg-transparent'">
      <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="flex items-center justify-between h-16 lg:h-20">
          <!-- Logo -->
          <RouterLink to="/" class="flex items-center gap-3 group">
            <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-fuchsia-500 to-purple-600 flex items-center justify-center shadow-lg shadow-purple-500/30 group-hover:shadow-purple-500/50 transition-shadow duration-300">
              <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
              </svg>
            </div>
            <span class="text-xl font-bold text-white tracking-tight">Kreati<span class="gradient-text-purple">Link</span></span>
          </RouterLink>

          <!-- Desktop Nav -->
          <div class="hidden lg:flex items-center gap-8">
            <a href="#features" class="text-sm text-gray-400 hover:text-white transition-colors duration-200">Fitur</a>
            <a href="#how-it-works" class="text-sm text-gray-400 hover:text-white transition-colors duration-200">Cara Kerja</a>
            <a href="#marketplace" class="text-sm text-gray-400 hover:text-white transition-colors duration-200">Produk</a>
            <a href="#about" class="text-sm text-gray-400 hover:text-white transition-colors duration-200">Tentang</a>
          </div>

          <!-- CTA Buttons -->
          <div class="flex items-center gap-3">
            <RouterLink to="/auth/login" class="hidden lg:inline-flex text-sm text-gray-300 hover:text-white transition-colors duration-200 font-medium">
              Masuk
            </RouterLink>
            <RouterLink to="/auth/register" class="btn-primary text-sm py-2 px-5">
              <span class="relative z-10">Daftar Gratis</span>
            </RouterLink>

            <!-- Mobile menu button -->
            <button @click="menuOpen = !menuOpen" class="lg:hidden p-2 rounded-lg glass text-gray-300 hover:text-white transition-colors">
              <svg v-if="!menuOpen" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
              </svg>
              <svg v-else class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
              </svg>
            </button>
          </div>
        </div>
      </div>

      <!-- Mobile Menu -->
      <Transition name="slide-down">
        <div v-if="menuOpen" class="lg:hidden glass-strong border-t border-white/5 px-6 py-4 space-y-3">
          <a href="#features" @click="menuOpen=false" class="block text-gray-300 hover:text-white py-2 transition-colors">Fitur</a>
          <a href="#how-it-works" @click="menuOpen=false" class="block text-gray-300 hover:text-white py-2 transition-colors">Cara Kerja</a>
          <a href="#marketplace" @click="menuOpen=false" class="block text-gray-300 hover:text-white py-2 transition-colors">Produk</a>
          <div class="pt-2 border-t border-white/5 flex gap-3">
            <RouterLink to="/auth/login" class="btn-secondary text-sm py-2 flex-1 justify-center">Masuk</RouterLink>
            <RouterLink to="/auth/register" class="btn-primary text-sm py-2 flex-1 justify-center"><span class="relative z-10">Daftar</span></RouterLink>
          </div>
        </div>
      </Transition>
    </nav>

    <!-- Page Content -->
    <RouterView />

    <!-- Footer -->
    <footer class="border-t border-white/5 py-12">
      <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row items-center justify-between gap-6">
          <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-fuchsia-500 to-purple-600 flex items-center justify-center">
              <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
              </svg>
            </div>
            <span class="font-bold text-white">KreatiLink</span>
          </div>
          <p class="text-sm text-gray-500 text-center">
            © 2026 KreatiLink. Platform kolaborasi UMKM Kreatif Malang.
            Dibuat dengan ❤️ untuk INTERCOMP 2026.
          </p>
          <div class="flex gap-4">
            <a href="#" class="text-gray-500 hover:text-fuchsia-400 transition-colors text-sm">Privasi</a>
            <a href="#" class="text-gray-500 hover:text-fuchsia-400 transition-colors text-sm">Syarat</a>
            <a href="#" class="text-gray-500 hover:text-fuchsia-400 transition-colors text-sm">Kontak</a>
          </div>
        </div>
      </div>
    </footer>
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import { RouterLink, RouterView } from 'vue-router';

const scrolled = ref(false);
const menuOpen = ref(false);

function onScroll() {
  scrolled.value = window.scrollY > 20;
}

onMounted(() => window.addEventListener('scroll', onScroll));
onUnmounted(() => window.removeEventListener('scroll', onScroll));
</script>

<style scoped>
.slide-down-enter-active, .slide-down-leave-active {
  transition: all 0.3s ease;
  overflow: hidden;
}
.slide-down-enter-from, .slide-down-leave-to {
  opacity: 0;
  max-height: 0;
}
.slide-down-enter-to, .slide-down-leave-from {
  opacity: 1;
  max-height: 300px;
}
</style>
