<template>
  <section class="max-w-7xl mx-auto px-6 py-24">
    <div class="grid lg:grid-cols-2 gap-16 items-center">
      <!-- Left Content -->
      <div class="animate-in fade-in slide-in-from-left-8 duration-1000">
        <div class="inline-flex items-center gap-3 bg-orange-50 text-orange-600 px-5 py-2 rounded-full text-[10px] font-black uppercase tracking-[0.2em] mb-8">
          <span class="w-2 h-2 bg-orange-500 rounded-full animate-pulse"></span>
          Indonesian Creative Economy 4.0
        </div>

        <h1 class="text-6xl md:text-7xl font-black leading-[0.95] mb-8 text-gray-900 tracking-tighter">
          Empowering <br/>
          <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-600 to-amber-500">Indonesian Artisans</span><br/>
          Nationwide.
        </h1>

        <p class="text-gray-500 text-xl mb-10 max-w-lg leading-relaxed font-medium">
          SnapFit menjembatani UMKM kreatif Malang dengan teknologi
          <span class="text-gray-900 font-bold underline decoration-orange-300">AI, AR, dan Real-time Collaboration</span>.
        </p>

        <div class="flex flex-wrap gap-5">
          <button class="bg-gray-900 text-white px-10 py-5 rounded-2xl shadow-2xl hover:bg-orange-600 hover:-translate-y-1 transition duration-300 font-black uppercase tracking-widest text-xs">
            Explore Marketplace
          </button>
          <button class="bg-white border-2 border-gray-100 text-gray-900 px-10 py-5 rounded-2xl hover:bg-gray-50 transition duration-300 font-black uppercase tracking-widest text-xs">
            Join as Creator
          </button>
        </div>
      </div>

      <!-- Right Visual -->
      <div class="relative animate-in fade-in zoom-in duration-1000">
        <div class="aspect-square bg-gradient-to-br from-orange-50 to-amber-50 rounded-[4rem] border-2 border-white shadow-inner flex items-center justify-center relative overflow-hidden">
          <!-- AI Studio Badge -->
          <div class="absolute top-10 left-10 bg-white/90 backdrop-blur-md p-6 rounded-3xl shadow-xl border border-white z-20 animate-bounce-slow">
            <div class="flex items-center gap-3 mb-3">
              <div class="w-8 h-8 bg-orange-500 rounded-lg flex items-center justify-center text-white text-xs font-bold italic">AI</div>
              <p class="text-[10px] font-black uppercase tracking-tighter">AI Studio Active</p>
            </div>
            <div class="w-32 h-2 bg-gray-100 rounded-full overflow-hidden">
              <div class="w-2/3 h-full bg-orange-500"></div>
            </div>
          </div>

          <!-- AR Badge -->
          <div class="absolute bottom-20 right-10 bg-gray-900 text-white p-5 rounded-3xl shadow-2xl z-20">
            <p class="text-[9px] font-bold text-orange-400 uppercase tracking-widest mb-1">Live Preview</p>
            <p class="text-sm font-black italic">Web AR Try-On ✨</p>
          </div>

          <!-- Main Image -->
          <div class="w-64 h-64 bg-white rounded-[3rem] shadow-2xl flex items-center justify-center relative group overflow-hidden">
            <img
              src="https://images.unsplash.com/photo-1590736961958-51fd161031f3?q=80&w=1000&auto=format&fit=crop"
              class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110 opacity-80"
              alt="SnapFit Product Preview"
            />
            <div class="absolute inset-0 bg-orange-600/10 group-hover:bg-transparent transition-colors"></div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
// Props can be added later for dynamic hero content
</script>

<style scoped>
@keyframes bounce-slow {
  0%, 100% { transform: translateY(-5%); }
  50%       { transform: translateY(0); }
}

.animate-bounce-slow {
  animation: bounce-slow 4s infinite ease-in-out;
}

.animate-in { animation-duration: 0.8s; animation-fill-mode: both; }

@keyframes fadeIn       { from { opacity: 0; } to { opacity: 1; } }
@keyframes slideInLeft  { from { transform: translateX(-30px); opacity: 0; } to { transform: translateX(0); opacity: 1; } }
@keyframes zoomIn       { from { transform: scale(0.95); opacity: 0; } to { transform: scale(1); opacity: 1; } }

.fade-in              { animation-name: fadeIn; }
.slide-in-from-left-8 { animation-name: slideInLeft; }
.zoom-in              { animation-name: zoomIn; }
</style>
