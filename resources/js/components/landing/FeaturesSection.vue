<template>
  <section id="features" class="py-32 bg-gradient-to-b from-gray-50 to-white relative overflow-hidden">
    <!-- Background Decoration -->
    <div class="absolute top-0 left-1/4 w-96 h-96 bg-orange-100/30 rounded-full blur-3xl"></div>
    <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-amber-100/30 rounded-full blur-3xl"></div>

    <div class="max-w-7xl mx-auto px-6 relative z-10">
      <!-- Section Header -->
      <div class="text-center mb-20">
        <div class="inline-flex items-center gap-2 bg-orange-50 text-orange-600 px-5 py-2 rounded-full text-[10px] font-black uppercase tracking-[0.2em] mb-6">
          <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
          </svg>
          <span>Fitur Unggulan</span>
        </div>
        <h2 class="text-5xl md:text-6xl font-black tracking-tighter mb-6 text-gray-900">
          Teknologi <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-600 to-amber-500">Terdepan</span>
        </h2>
        <p class="text-gray-500 text-lg max-w-2xl mx-auto">
          Solusi digital lengkap untuk mengangkat bisnis UMKM Anda ke level internasional
        </p>
      </div>

      <div class="grid md:grid-cols-3 gap-8">
        <!-- AI Product Studio -->
        <div class="group relative bg-white p-10 rounded-[2.5rem] shadow-sm hover:shadow-2xl transition-all duration-500 border border-gray-100 hover:border-orange-200 overflow-hidden">
          <div class="absolute inset-0 bg-gradient-to-br from-orange-50/0 to-orange-50/0 group-hover:from-orange-50/50 group-hover:to-amber-50/30 transition-all duration-500 rounded-[2.5rem]"></div>

          <div class="relative z-10">
            <div class="w-20 h-20 bg-gradient-to-br from-orange-100 to-orange-50 text-orange-600 rounded-3xl flex items-center justify-center mb-8 group-hover:scale-110 group-hover:rotate-3 transition-all duration-500 shadow-lg shadow-orange-100/50">
              <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
              </svg>
            </div>

            <h3 class="text-2xl font-black mb-4 tracking-tighter text-gray-900 group-hover:text-orange-600 transition-colors">
              AI Product Studio
            </h3>
            <p class="text-gray-600 text-sm leading-relaxed mb-6">
              Ubah foto HP menjadi katalog studio profesional secara otomatis. AI kami menangani lighting, video 360°, dan copy marketing untuk Anda.
            </p>

            <ul class="space-y-2 mb-6">
              <li v-for="item in aiFeatures" :key="item" class="flex items-center gap-2 text-xs text-gray-600">
                <svg class="w-4 h-4 text-orange-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                <span>{{ item }}</span>
              </li>
            </ul>

            <button class="group/btn flex items-center gap-2 text-xs font-black text-orange-600 uppercase tracking-widest hover:gap-3 transition-all">
              <span>Launch Studio</span>
              <svg class="w-4 h-4 group-hover/btn:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
              </svg>
            </button>
          </div>
        </div>

        <!-- Web AR Try-On -->
        <div class="group relative bg-white p-10 rounded-[2.5rem] shadow-sm hover:shadow-2xl transition-all duration-500 border border-gray-100 hover:border-amber-200 overflow-hidden">
          <div class="absolute inset-0 bg-gradient-to-br from-amber-50/0 to-amber-50/0 group-hover:from-amber-50/50 group-hover:to-orange-50/30 transition-all duration-500 rounded-[2.5rem]"></div>

          <div class="relative z-10">
            <div class="w-20 h-20 bg-gradient-to-br from-amber-100 to-amber-50 text-amber-600 rounded-3xl flex items-center justify-center mb-8 group-hover:scale-110 group-hover:rotate-3 transition-all duration-500 shadow-lg shadow-amber-100/50">
              <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
              </svg>
            </div>

            <h3 class="text-2xl font-black mb-4 tracking-tighter text-gray-900 group-hover:text-amber-600 transition-colors">
              Web AR Try-On
            </h3>
            <p class="text-gray-600 text-sm leading-relaxed mb-6">
              Tingkatkan kepercayaan pembeli. Mereka bisa mencoba batik atau aksesoris langsung lewat browser tanpa perlu instal aplikasi tambahan.
            </p>

            <ul class="space-y-2 mb-6">
              <li v-for="item in arFeatures" :key="item" class="flex items-center gap-2 text-xs text-gray-600">
                <svg class="w-4 h-4 text-amber-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                <span>{{ item }}</span>
              </li>
            </ul>

            <button class="group/btn flex items-center gap-2 text-xs font-black text-amber-600 uppercase tracking-widest hover:gap-3 transition-all">
              <span>Try it now</span>
              <svg class="w-4 h-4 group-hover/btn:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
              </svg>
            </button>
          </div>
        </div>

        <!-- Co-Create Room -->
        <div class="group relative bg-white p-10 rounded-[2.5rem] shadow-sm hover:shadow-2xl transition-all duration-500 border border-gray-100 hover:border-gray-300 overflow-hidden">
          <div class="absolute inset-0 bg-gradient-to-br from-gray-50/0 to-gray-50/0 group-hover:from-gray-50/50 group-hover:to-orange-50/30 transition-all duration-500 rounded-[2.5rem]"></div>

          <div class="relative z-10">
            <div class="w-20 h-20 bg-gradient-to-br from-gray-900 to-gray-800 text-white rounded-3xl flex items-center justify-center mb-8 group-hover:scale-110 group-hover:rotate-3 transition-all duration-500 shadow-lg shadow-gray-200/50 group-hover:shadow-orange-200/50">
              <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
              </svg>
            </div>

            <h3 class="text-2xl font-black mb-4 tracking-tighter text-gray-900 group-hover:text-orange-600 transition-colors">
              Co-Create Room
            </h3>
            <p class="text-gray-600 text-sm leading-relaxed mb-6">
              Kolaborasi UMKM & Desainer Indonesia secara real-time. Seperti Figma, tapi didesain khusus untuk pengembangan produk fisik.
            </p>

            <ul class="space-y-2 mb-6">
              <li v-for="item in coCreateFeatures" :key="item" class="flex items-center gap-2 text-xs text-gray-600">
                <svg class="w-4 h-4 text-orange-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                <span>{{ item }}</span>
              </li>
            </ul>

            <button class="group/btn flex items-center gap-2 text-xs font-black text-gray-900 uppercase tracking-widest hover:gap-3 transition-all">
              <span>Enter Room</span>
              <svg class="w-4 h-4 group-hover/btn:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
              </svg>
            </button>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
const aiFeatures      = ['Auto Background Removal', '360° Product View', 'AI Product Description'];
const arFeatures      = ['Real-time Virtual Try-On', 'No App Installation', 'Mobile & Desktop Ready'];
const coCreateFeatures = ['Real-time Collaboration', 'Design Feedback System', 'Version Control'];
</script>

<style scoped>
/* Component-specific styles */
</style>
