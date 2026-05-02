<template>
  <Teleport to="body">
    <Transition
      enter-active-class="transition ease-out duration-300"
      enter-from-class="opacity-0"
      enter-to-class="opacity-100"
      leave-active-class="transition ease-in duration-200"
      leave-from-class="opacity-100"
      leave-to-class="opacity-0"
    >
      <div
        v-if="isOpen"
        class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm"
        @click="handleBackdropClick"
      >
        <!-- Modal Content -->
        <Transition
          enter-active-class="transition ease-out duration-300"
          enter-from-class="opacity-0 scale-95 translate-y-4"
          enter-to-class="opacity-100 scale-100 translate-y-0"
          leave-active-class="transition ease-in duration-200"
          leave-from-class="opacity-100 scale-100 translate-y-0"
          leave-to-class="opacity-0 scale-95 translate-y-4"
        >
          <div
            v-if="isOpen"
            class="relative bg-white rounded-[3rem] shadow-2xl max-w-4xl w-full overflow-hidden"
            @click.stop
          >
            <!-- Close Button -->
            <button
              @click="closeModal"
              class="absolute top-6 right-6 z-10 w-10 h-10 bg-gray-100 hover:bg-gray-200 rounded-full flex items-center justify-center transition-all hover:scale-110 active:scale-95"
            >
              <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>

            <!-- Content -->
            <div class="p-8 md:p-12">
             

              <!-- Headline -->
              <h2 class="text-4xl md:text-5xl font-black text-gray-900 mb-4 leading-tight">
                Selamat Datang di <span class="text-orange-600">SnapFit!</span>
              </h2>

              <!-- Description -->
              <p class="text-lg text-gray-600 mb-8 max-w-2xl leading-relaxed">
                Marketplace pertama di Indonesia yang menggabungkan teknologi <span class="font-black text-orange-600">AI</span>, 
                <span class="font-black text-orange-600">AR</span>, dan 
                <span class="font-black text-orange-600">Real-time Collaboration</span> untuk memberdayakan UMKM lokal.
              </p>

              <!-- Innovation Cards -->
              <div class="grid md:grid-cols-3 gap-6 mb-8">
                <!-- AI Studio -->
                <div class="group bg-orange-50 hover:bg-orange-100 rounded-2xl p-6 transition-all hover:scale-105 cursor-pointer border-2 border-transparent hover:border-orange-200">
                  <div class="w-14 h-14 bg-orange-600 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                    </svg>
                  </div>
                  <h3 class="text-lg font-black text-gray-900 mb-2">AI Product Studio</h3>
                  <p class="text-sm text-gray-600 leading-relaxed">Foto produk otomatis jadi katalog profesional dengan AI</p>
                </div>

                <!-- AR Try-On -->
                <div class="group bg-orange-50 hover:bg-orange-100 rounded-2xl p-6 transition-all hover:scale-105 cursor-pointer border-2 border-transparent hover:border-orange-200">
                  <div class="w-14 h-14 bg-orange-600 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                  </div>
                  <h3 class="text-lg font-black text-gray-900 mb-2">Web AR Try-On</h3>
                  <p class="text-sm text-gray-600 leading-relaxed">Coba produk virtual langsung di browser tanpa install app</p>
                </div>

                <!-- Co-Create -->
                <div class="group bg-orange-50 hover:bg-orange-100 rounded-2xl p-6 transition-all hover:scale-105 cursor-pointer border-2 border-transparent hover:border-orange-200">
                  <div class="w-14 h-14 bg-orange-600 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                  </div>
                  <h3 class="text-lg font-black text-gray-900 mb-2">Co-Create Room</h3>
                  <p class="text-sm text-gray-600 leading-relaxed">Kolaborasi UMKM & Desainer secara real-time</p>
                </div>
              </div>

              <!-- CTA Buttons -->
              <div class="flex flex-col sm:flex-row gap-4 mb-6">
                <button
                  @click="exploreProducts"
                  class="flex-1 bg-orange-600 text-white px-8 py-4 rounded-2xl font-black text-sm uppercase tracking-widest hover:bg-orange-700 transition-all shadow-lg hover:shadow-xl hover:-translate-y-0.5 flex items-center justify-center gap-2"
                >
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                  </svg>
                  <span>Jelajahi Produk</span>
                </button>

                <button
                  @click="learnMore"
                  class="flex-1 bg-white border-2 border-gray-200 text-gray-900 px-8 py-4 rounded-2xl font-black text-sm uppercase tracking-widest hover:border-orange-600 hover:text-orange-600 transition-all flex items-center justify-center gap-2"
                >
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                  <span>Pelajari Lebih Lanjut</span>
                </button>
              </div>

              <!-- Don't Show Again -->
              <label class="flex items-center gap-3 cursor-pointer group">
                <input
                  v-model="dontShowAgain"
                  type="checkbox"
                  class="w-5 h-5 rounded border-2 border-gray-300 text-orange-600 focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 cursor-pointer"
                />
                <span class="text-sm text-gray-600 font-bold group-hover:text-gray-900 transition-colors">
                  Jangan tampilkan lagi
                </span>
              </label>
            </div>

            <!-- Decorative Elements -->
            <div class="absolute -top-20 -right-20 w-64 h-64 bg-orange-200 rounded-full blur-[100px] opacity-20 pointer-events-none"></div>
            <div class="absolute -bottom-20 -left-20 w-64 h-64 bg-orange-100 rounded-full blur-[100px] opacity-20 pointer-events-none"></div>
          </div>
        </Transition>
      </div>
    </Transition>
  </Teleport>
</template>

<script setup>
import { ref, onMounted } from 'vue';

const emit = defineEmits(['close', 'explore', 'learnMore']);

const isOpen = ref(false);
const dontShowAgain = ref(false);

const STORAGE_KEY = 'snapfit_welcome_modal_dismissed';

// Check if modal should be shown
const shouldShowModal = () => {
  const dismissed = localStorage.getItem(STORAGE_KEY);
  return !dismissed;
};

// Close modal
const closeModal = () => {
  if (dontShowAgain.value) {
    localStorage.setItem(STORAGE_KEY, 'true');
  }
  isOpen.value = false;
  emit('close');
};

// Handle backdrop click
const handleBackdropClick = () => {
  closeModal();
};

// Explore products
const exploreProducts = () => {
  closeModal();
  emit('explore');
  // Scroll to marketplace section
  setTimeout(() => {
    const marketplace = document.getElementById('marketplace');
    if (marketplace) {
      marketplace.scrollIntoView({ behavior: 'smooth' });
    }
  }, 300);
};

// Learn more
const learnMore = () => {
  closeModal();
  emit('learnMore');
  // Scroll to features section
  setTimeout(() => {
    const features = document.getElementById('features');
    if (features) {
      features.scrollIntoView({ behavior: 'smooth' });
    }
  }, 300);
};

// Show modal on mount
onMounted(() => {
  if (shouldShowModal()) {
    // Delay untuk smooth entrance
    setTimeout(() => {
      isOpen.value = true;
    }, 500);
  }
});

// Expose method to manually open modal
defineExpose({
  open: () => {
    isOpen.value = true;
  },
  close: closeModal
});
</script>

<style scoped>
/* Prevent body scroll when modal is open */
body:has(.fixed.z-\[100\]) {
  overflow: hidden;
}
</style>
