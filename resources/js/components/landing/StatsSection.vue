<template>
  <!-- Testimonials -->
  <section class="py-24 bg-gray-50/50">
    <div class="max-w-7xl mx-auto px-6">
      <div class="text-center mb-16">
        <h2 class="text-4xl font-black text-gray-900 tracking-tighter mb-4 uppercase">Customer Stories</h2>
        <p class="text-gray-400 font-medium">Verified experiences from our gold members.</p>
      </div>

      <div class="grid md:grid-cols-3 gap-8 mb-24">
        <div
          v-for="review in reviews"
          :key="review.name"
          class="bg-white p-10 rounded-[3.5rem] border border-gray-50 shadow-sm hover:shadow-xl transition-all group"
        >
          <div class="flex items-center gap-4 mb-6">
            <div class="w-12 h-12 bg-orange-100 rounded-2xl flex items-center justify-center text-orange-600 font-black text-xl group-hover:bg-orange-600 group-hover:text-white transition-colors duration-500">
              {{ review.name[0] }}
            </div>
            <div>
              <p class="text-sm font-black text-gray-900">{{ review.name }}</p>
              <div class="flex gap-0.5 text-amber-500 text-[10px]">★★★★★</div>
            </div>
          </div>
          <p class="text-sm text-gray-500 leading-relaxed italic">"{{ review.text }}"</p>
        </div>
      </div>

      <!-- CTA Section -->
      <div class="bg-gray-900 rounded-[4rem] py-24 text-center relative overflow-hidden">
        <div class="absolute -top-20 -left-20 w-96 h-96 bg-orange-600/20 rounded-full blur-[100px]"></div>

        <h2 class="text-5xl font-black text-white mb-8 tracking-tighter relative z-10">
          Ready to <span class="italic text-orange-500">Go Digital?</span>
        </h2>

        <p class="text-gray-400 max-w-lg mx-auto mb-12 font-medium relative z-10">
          Bawa UMKM Anda ke level selanjutnya dengan teknologi AI dan AR tercanggih di Indonesia.
        </p>

        <div class="flex flex-wrap justify-center gap-6 relative z-10">
          <button class="bg-white text-gray-900 px-12 py-5 rounded-2xl font-black uppercase tracking-widest text-xs hover:bg-orange-50 transition-all shadow-xl hover:-translate-y-1">
            Daftar UMKM Sekarang
          </button>
          <button class="bg-transparent border-2 border-white/20 text-white px-12 py-5 rounded-2xl font-black uppercase tracking-widest text-xs hover:bg-white/5 transition-all">
            Lihat Dokumentasi
          </button>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref } from 'vue';

const reviews = ref([
  {
    name: 'Budi Santoso',
    text: 'Platform terbaik untuk UMKM Malang! Produk batik saya jadi lebih dikenal secara nasional.'
  },
  {
    name: 'Siti Nurhaliza',
    text: 'Fitur AR Try-On sangat membantu pembeli dari luar kota untuk yakin sebelum membeli kerajinan tangan saya.'
  },
  {
    name: 'Ahmad Rizki',
    text: 'Co-Create Room memudahkan kolaborasi dengan desainer dari Jakarta. Produk jadi lebih modern dan marketable!'
  }
]);
</script>

<style scoped>
/* Component-specific styles */
</style>
