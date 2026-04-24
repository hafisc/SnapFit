<template>
  <div class="min-h-screen bg-gray-50 text-gray-900">
    <!-- Top Navbar -->
    <header class="sticky top-0 z-50 bg-white shadow-sm border-b border-gray-100">
      <nav class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between gap-6">
        <div>
          <h1 class="text-3xl font-bold text-black">SnapFit</h1>
          <p class="text-xs uppercase tracking-[0.2em] text-gray-500">
            Next-Gen Creative Commerce
          </p>
        </div>

        <div class="flex-1 max-w-2xl">
          <div class="bg-gray-100 rounded-full px-5 py-3 flex items-center">
            <input
              type="text"
              placeholder="Cari batik premium, aksesoris, fashion lokal..."
              class="bg-transparent w-full outline-none text-sm"
            />
          </div>
        </div>

        <a
          href="/login"
          class="bg-black text-white px-6 py-3 rounded-full font-medium hover:scale-105 transition inline-block text-center"
        >
          Explore Store
        </a>
      </nav>
    </header>

    <!-- Hero Banner -->
    <section
      class="bg-gradient-to-r from-black via-gray-900 to-gray-800 text-white py-20"
    >
      <div class="max-w-7xl mx-auto px-6 grid lg:grid-cols-2 gap-10 items-center">
        <div>
          <p class="uppercase tracking-[0.2em] text-sm mb-4">Premium UMKM Marketplace</p>
          <h2 class="text-5xl font-bold leading-tight mb-6">
            Discover Premium Local Products With a Modern Luxury Experience
          </h2>
          <p class="text-lg mb-8 opacity-90">
            Marketplace modern untuk batik, fashion, kerajinan tangan, kuliner, dan
            aksesoris UMKM kreatif Malang dengan AI + AR + Realtime Collaboration.
          </p>

          <div class="flex gap-4 flex-wrap">
            <button class="bg-white text-black px-8 py-4 rounded-full font-bold">
              Explore Collection
            </button>
            <button class="border border-white px-8 py-4 rounded-full font-semibold">
              Try AR Experience
            </button>
          </div>
        </div>

        <div class="relative h-[360px]">
          <transition name="fade" mode="out-in">
            <div
              :key="currentFeature.title"
              class="bg-white/10 backdrop-blur-md rounded-3xl p-8 border border-white/20 h-full shadow-xl"
            >
              <p class="text-sm uppercase tracking-[0.2em] mb-3 opacity-80">
                Featured Innovation
              </p>

              <h3 class="text-3xl font-bold mb-6">
                {{ currentFeature.title }}
              </h3>

              <p class="text-lg leading-relaxed opacity-90 mb-8">
                {{ currentFeature.description }}
              </p>

              <div class="text-5xl">
                {{ currentFeature.icon }}
              </div>
            </div>
          </transition>
        </div>
      </div>
    </section>

    <!-- Category Menu -->
    <section class="py-10 bg-white">
      <div class="max-w-7xl mx-auto px-6">
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4 text-center">
          <div class="bg-gray-50 p-5 rounded-2xl">Batik</div>
          <div class="bg-gray-50 p-5 rounded-2xl">Fashion</div>
          <div class="bg-gray-50 p-5 rounded-2xl">Aksesoris</div>
          <div class="bg-gray-50 p-5 rounded-2xl">Kerajinan</div>
          <div class="bg-gray-50 p-5 rounded-2xl">Kuliner</div>
          <div class="bg-gray-50 p-5 rounded-2xl">Home Decor</div>
        </div>
      </div>
    </section>

    <!-- Trending Premium Collection Like Ecommerce -->
    <section class="py-20">
      <div class="max-w-7xl mx-auto px-6">
        <div class="flex items-center justify-between mb-10">
          <h2 class="text-4xl font-bold">Product Collection</h2>
          <button class="text-black font-semibold">Lihat Semua →</button>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
          <div
            class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden"
          >
            <div class="h-48 bg-gray-100"></div>
            <div class="p-5">
              <h3 class="font-bold mb-2">Luxury Batik Premium</h3>
              <p class="text-sm text-gray-500 mb-3">Batik modern eksklusif khas Malang</p>
              <div class="flex items-center justify-between">
                <span class="text-black font-bold">Rp 450.000</span>
                <button class="text-sm font-medium">Beli</button>
              </div>
            </div>
          </div>

          <div
            class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden"
          >
            <div class="h-48 bg-gray-100"></div>
            <div class="p-5">
              <h3 class="font-bold mb-2">Handmade Accessories</h3>
              <p class="text-sm text-gray-500 mb-3">Aksesoris artisan premium lokal</p>
              <div class="flex items-center justify-between">
                <span class="text-black font-bold">Rp 220.000</span>
                <button class="text-sm font-medium">Beli</button>
              </div>
            </div>
          </div>

          <div
            class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden"
          >
            <div class="h-48 bg-gray-100"></div>
            <div class="p-5">
              <h3 class="font-bold mb-2">Creative Home Decor</h3>
              <p class="text-sm text-gray-500 mb-3">Dekorasi rumah handmade premium</p>
              <div class="flex items-center justify-between">
                <span class="text-black font-bold">Rp 380.000</span>
                <button class="text-sm font-medium">Beli</button>
              </div>
            </div>
          </div>

          <div
            class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden"
          >
            <div class="h-48 bg-gray-100"></div>
            <div class="p-5">
              <h3 class="font-bold mb-2">Signature Culinary Box</h3>
              <p class="text-sm text-gray-500 mb-3">Gift box kuliner khas premium</p>
              <div class="flex items-center justify-between">
                <span class="text-black font-bold">Rp 175.000</span>
                <button class="text-sm font-medium">Beli</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Innovation Section -->
    <section class="py-20 bg-white">
      <div class="max-w-7xl mx-auto px-6">
        <h2 class="text-4xl font-bold text-center mb-14">
          Why Modern Brands Choose SnapFit
        </h2>

        <div class="grid lg:grid-cols-3 gap-8">
          <div class="p-8 rounded-3xl border border-gray-100 shadow-sm">
            <h3 class="text-xl font-bold mb-4">AI Product Studio</h3>
            <p class="text-gray-600">
              Foto biasa langsung menjadi studio profesional + video 360° + caption
              marketing.
            </p>
          </div>

          <div class="p-8 rounded-3xl border border-gray-100 shadow-sm">
            <h3 class="text-xl font-bold mb-4">Web AR Try-On</h3>
            <p class="text-gray-600">
              Pembeli bisa mencoba produk langsung lewat kamera browser tanpa install
              aplikasi.
            </p>
          </div>

          <div class="p-8 rounded-3xl border border-gray-100 shadow-sm">
            <h3 class="text-xl font-bold mb-4">Realtime Co-Create Room</h3>
            <p class="text-gray-600">
              UMKM dan desainer berkolaborasi live seperti Figma untuk produk fisik.
            </p>
          </div>
        </div>
      </div>
    </section>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-100 py-14">
      <div class="max-w-7xl mx-auto px-6 text-center">
        <h2 class="text-2xl font-bold mb-2">SnapFit</h2>
        <p class="text-gray-500 mb-3">Modern Marketplace for Premium Creative Brands</p>
        <p class="text-sm text-gray-400">
          © 2026 SnapFit — Built for the Future of Digital Commerce
        </p>
      </div>
    </footer>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, onBeforeUnmount } from "vue";

const features = [
  {
    icon: "✨",
    title: "AI Product Studio",
    description:
      "Upload foto produk biasa dan AI otomatis menghasilkan visual studio profesional, video 360°, serta caption marketing premium.",
  },
  {
    icon: "🪞",
    title: "Web AR Try-On",
    description:
      "Pembeli dapat mencoba batik, fashion, dan aksesoris langsung melalui kamera browser tanpa perlu install aplikasi tambahan.",
  },
  {
    icon: "🤝",
    title: "Realtime Co-Create Room",
    description:
      "UMKM dan desainer dapat berkolaborasi live seperti Figma untuk menciptakan produk fisik yang lebih bernilai tinggi.",
  },
  {
    icon: "📈",
    title: "Dashboard Analytics",
    description:
      "Pantau performa penjualan, tren produk, dan insight bisnis UMKM secara realtime melalui dashboard modern.",
  },
  {
    icon: "💳",
    title: "Midtrans Payment Gateway",
    description:
      "Checkout lebih aman dan profesional dengan sistem pembayaran digital modern yang cepat dan seamless.",
  },
];

const activeIndex = ref(0);
let interval = null;

const currentFeature = computed(() => features[activeIndex.value]);

onMounted(() => {
  interval = setInterval(() => {
    activeIndex.value = (activeIndex.value + 1) % features.length;
  }, 2500);
});

onBeforeUnmount(() => {
  clearInterval(interval);
});
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: all 0.5s ease;
}

.fade-enter-from {
  opacity: 0;
  transform: translateY(20px);
}

.fade-leave-to {
  opacity: 0;
  transform: translateY(-20px);
}
</style>

<style scoped>
html {
  scroll-behavior: smooth;
}
</style>