<template>
  <section class="relative bg-white border-b border-gray-100 pt-20">
    <!-- Compact Hero Banner -->
    <div class="max-w-[1600px] mx-auto px-6 py-8">
      <div class="bg-orange-600 rounded-3xl overflow-hidden shadow-xl relative">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-10">
          <div class="absolute top-0 right-0 w-64 h-64 bg-white rounded-full blur-3xl"></div>
          <div class="absolute bottom-0 left-0 w-48 h-48 bg-white rounded-full blur-2xl"></div>
        </div>

        <div class="relative grid lg:grid-cols-2 gap-8 items-center p-8 lg:p-12">
          <!-- Left: Main Message -->
          <div class="text-white space-y-4">
            <div class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-sm px-4 py-2 rounded-full">
              <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
              </svg>
              <span class="text-xs font-black uppercase tracking-wider">Platform Inovatif untuk UMKM Indonesia</span>
            </div>

            <h1 class="text-4xl lg:text-5xl font-black leading-tight">
              Marketplace Batik & Kerajinan Lokal dengan Teknologi AI & AR
            </h1>

            <p class="text-lg text-white/90 font-medium max-w-xl">
              Temukan produk batik, kerajinan tangan, dan karya UMKM Indonesia dengan pengalaman belanja yang diperkaya teknologi modern.
            </p>

            <div class="flex flex-wrap gap-3 pt-2">
              <button class="bg-white text-orange-600 px-6 py-3 rounded-xl font-black text-sm uppercase tracking-wider hover:bg-orange-50 transition-all shadow-lg flex items-center gap-2">
                <span>Belanja Sekarang</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                </svg>
              </button>
            </div>
          </div>

          <!-- Right: Innovation Badges -->
          <div class="grid grid-cols-3 gap-4">
            <!-- AI Studio -->
            <div class="bg-white/10 backdrop-blur-md rounded-2xl p-4 border border-white/20 hover:bg-white/20 transition-all">
              <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center mb-3">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                </svg>
              </div>
              <p class="text-white font-black text-sm mb-1">AI Studio</p>
              <p class="text-white/70 text-xs font-bold">Foto Produk Otomatis</p>
            </div>

            <!-- AR Try-On -->
            <div class="bg-white/10 backdrop-blur-md rounded-2xl p-4 border border-white/20 hover:bg-white/20 transition-all">
              <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center mb-3">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
              </div>
              <p class="text-white font-black text-sm mb-1">AR Try-On</p>
              <p class="text-white/70 text-xs font-bold">Coba Virtual</p>
            </div>

            <!-- Co-Create -->
            <div class="bg-white/10 backdrop-blur-md rounded-2xl p-4 border border-white/20 hover:bg-white/20 transition-all">
              <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center mb-3">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
              </div>
              <p class="text-white font-black text-sm mb-1">Co-Create</p>
              <p class="text-white/70 text-xs font-bold">Kolaborasi Real-time</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
// Compact hero banner for e-commerce style
</script>

<style scoped>
/* Minimal animations */
</style>
