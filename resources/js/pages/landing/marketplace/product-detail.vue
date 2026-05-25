<template>
  <section class="snapfit-heritage-bg min-h-screen text-espresso pb-0 lg:pb-10 relative overflow-hidden">
    <!-- Navbar -->
    <Navbar
      :user="user"
      @logout="logout"
      @goToLogin="goToLogin"
      @goToProfile="goToProfile"
      @goToOrders="goToOrders"
    />

    <!-- Main Content Container -->
    <div class="relative z-10 max-w-7xl mx-auto">

      <!-- DESKTOP VIEW (hidden on mobile, visible on lg and up) -->
      <div class="desktop-view-container hidden lg:block px-4 sm:px-6 lg:px-8 pt-16 sm:pt-24 pb-12">
        <!-- Back Button (Desktop only) -->
        <div class="flex mb-6 items-center gap-2 text-sm font-semibold text-muted">
          <button @click="router.push('/')" class="hover:text-espresso transition flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Beranda
          </button>
        </div>

        <div class="grid gap-8 grid-cols-[1.1fr_1fr] items-start">
          <!-- Left Column -->
          <div class="space-y-6">
            <div class="bg-surface rounded-3xl p-4 shadow-sm border border-borderSoft overflow-hidden">
              <div class="grid gap-4">
                <div class="relative overflow-hidden rounded-3xl bg-slate-100 aspect-square lg:aspect-[4/5]">
                  <img
                    v-if="activeImage"
                    :src="activeImage"
                    :alt="product?.name ?? 'Product image'"
                    class="w-full h-full object-cover transition duration-300 ease-out hover:scale-105"
                  />
                  <div class="absolute right-4 top-4 rounded-full bg-surface/85 px-3 py-1.5 text-xs font-semibold text-espresso backdrop-blur">
                    {{ currentImageLabel }}
                  </div>
                </div>

                <div class="flex flex-row gap-3 overflow-x-auto hide-scrollbar rounded-2xl bg-slate-50 p-2.5 border border-borderSoft">
                  <button
                    v-for="(image, index) in galleryImages"
                    :key="index"
                    type="button"
                    @click="activeImageIndex = index"
                    class="group flex-shrink-0 w-20 h-20 flex items-center justify-center overflow-hidden rounded-2xl border transition-all duration-200"
                    :class="index === activeImageIndex ? 'border-terracotta ring-2 ring-terracotta/20' : 'border-borderSoft hover:border-terracotta/50'"
                  >
                    <img :src="image" :alt="`Gallery ${index + 1}`" class="h-full w-full object-cover transition duration-300 group-hover:scale-105" />
                  </button>
                </div>
              </div>
            </div>

            <div class="grid gap-6 grid-cols-[1.5fr_1fr]">
              <!-- Product Story Tabs -->
              <div class="rounded-3xl bg-surface p-1 shadow-sm border border-borderSoft overflow-hidden flex flex-col">
                <div class="flex overflow-x-auto hide-scrollbar border-b border-borderSoft px-2 pt-2 gap-2">
                  <button v-for="tab in ['Deskripsi', 'Cerita Budaya', 'Material', 'Profil UMKM']" :key="tab"
                    @click="activeTab = tab"
                    class="px-4 py-3 text-sm font-bold whitespace-nowrap transition-colors border-b-2"
                    :class="activeTab === tab ? 'border-terracotta text-terracotta' : 'border-transparent text-muted hover:text-espresso'"
                  >
                    {{ tab }}
                  </button>
                </div>
                <div class="p-6 bg-white flex-1 rounded-b-3xl">
                  <div v-if="activeTab === 'Deskripsi'" class="animate-fade-in">
                    <p class="text-espresso text-sm leading-relaxed whitespace-pre-line">{{ product?.description }}</p>
                  </div>
                  <div v-if="activeTab === 'Cerita Budaya'" class="animate-fade-in space-y-6">
                    <div>
                      <h4 class="text-sm font-bold text-espresso mb-2">Filosofi Budaya</h4>
                      <p class="text-muted text-sm leading-relaxed">{{ product?.cultural_story }}</p>
                    </div>
                    <div>
                      <h4 class="text-sm font-bold text-espresso mb-2">Makna Motif</h4>
                      <p class="text-muted text-sm leading-relaxed">{{ product?.motif_meaning }}</p>
                    </div>
                  </div>
                  <div v-if="activeTab === 'Material'" class="animate-fade-in">
                    <p class="text-muted text-sm leading-relaxed whitespace-pre-line">{{ product?.material_care }}</p>
                  </div>
                  <div v-if="activeTab === 'Profil UMKM'" class="animate-fade-in">
                    <p class="text-muted text-sm leading-relaxed">{{ product?.artisan_info }}</p>
                  </div>
                </div>
              </div>

              <!-- Enhanced Seller Info -->
              <div class="rounded-3xl bg-surface p-6 shadow-sm border border-borderSoft flex flex-col">
                <h3 class="text-base font-bold tracking-tight text-espresso mb-4">Informasi Penjual</h3>
                <div class="flex items-center gap-4 mb-5">
                  <div class="w-14 h-14 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 overflow-hidden border border-borderSoft">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                  </div>
                  <div>
                    <h4 class="font-bold text-espresso text-base">{{ product?.seller?.name }}</h4>
                    <p class="text-xs text-muted flex items-center gap-1 mt-1">
                      <svg class="w-3 h-3 text-terracotta" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" /></svg>
                      {{ product?.seller?.location }}
                    </p>
                  </div>
                </div>
                
                <div class="grid grid-cols-2 gap-3 mb-6 bg-slate-50 rounded-2xl p-3 border border-borderSoft">
                  <div class="text-center">
                    <p class="text-[10px] uppercase font-bold text-slate-400 tracking-wider mb-1">Rating</p>
                    <p class="text-sm font-bold text-espresso flex items-center justify-center gap-1">
                      <svg class="w-4 h-4 text-amber-400" viewBox="0 0 20 20" fill="currentColor"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.95a1 1 0 00.95.69h4.18c.969 0 1.371 1.24.588 1.81l-3.388 2.46a1 1 0 00-.363 1.118l1.287 3.95c.3.921-.755 1.688-1.54 1.118l-3.388-2.46a1 1 0 00-1.175 0l-3.388 2.46c-.784.57-1.838-.197-1.539-1.118l1.287-3.95a1 1 0 00-.363-1.118L2.098 9.377c-.783-.57-.38-1.81.588-1.81h4.18a1 1 0 00.95-.69l1.286-3.95z"/></svg>
                      {{ product?.seller?.rating }}
                    </p>
                  </div>
                  <div class="text-center border-l border-borderSoft">
                    <p class="text-[10px] uppercase font-bold text-slate-400 tracking-wider mb-1">Terjual</p>
                    <p class="text-sm font-bold text-espresso">{{ product?.seller?.sold }}+</p>
                  </div>
                </div>

                <div class="mt-auto grid gap-2">
                  <button class="w-full py-2.5 rounded-xl border border-terracotta text-terracotta font-bold text-xs hover:bg-terracotta hover:text-white transition">Kunjungi Toko</button>
                  <button class="w-full py-2.5 rounded-xl bg-[#2B1E16] text-white font-bold text-xs hover:bg-black transition">Ajak Kolaborasi</button>
                </div>
              </div>
            </div>

            <!-- Related Products -->
            <div class="rounded-3xl bg-surface p-6 shadow-sm border border-borderSoft">
              <div class="flex items-center justify-between mb-4">
                <h3 class="text-base sm:text-lg font-bold tracking-tight text-espresso">Produk Terkait</h3>
                <button
                  type="button"
                  @click="refreshRelated"
                  class="text-sm font-semibold text-terracotta hover:text-orange-700"
                >Refresh</button>
              </div>
              <div v-if="relatedProducts.length" class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                <router-link
                  v-for="item in relatedProducts"
                  :key="item.id"
                  :to="{ name: 'product.detail', params: { id: item.id } }"
                  class="group block rounded-3xl border border-borderSoft bg-slate-50 p-4 transition hover:-translate-y-1 hover:shadow-lg"
                >
                  <img :src="item.images?.[0] ?? item.image_url" :alt="item.name" class="h-32 w-full rounded-3xl object-cover" />
                  <div class="mt-3">
                    <h4 class="text-sm font-semibold text-espresso line-clamp-2">{{ item.name }}</h4>
                    <p class="text-sm text-muted mt-2">Rp {{ formatCurrency(item.price) }}</p>
                  </div>
                </router-link>
              </div>
              <p v-else class="text-sm text-muted">Tidak ada produk terkait saat ini.</p>
            </div>
          </div>

          <!-- Right Column -->
          <div class="space-y-6">
            <div class="rounded-3xl bg-surface p-6 shadow-sm border border-borderSoft">
              <div class="mb-4">
                <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-terracotta">Marketplace</p>
                <h1 class="mt-2 text-xl sm:text-2xl lg:text-3xl font-black tracking-tight text-[#2B1E16] leading-tight">{{ product?.name ?? 'Loading produk...' }}</h1>
                
                <!-- Badges -->
                <div v-if="product?.badges?.length" class="mt-2.5 flex flex-wrap gap-1.5">
                  <span v-for="badge in product.badges" :key="badge" class="inline-flex items-center rounded-lg border border-terracotta/20 bg-[#F8F1E7]/60 px-2.5 py-0.5 text-[9px] font-bold text-terracotta uppercase tracking-wider leading-none">
                    {{ badge }}
                  </span>
                </div>

                <div class="mt-3 flex flex-wrap items-center gap-2 text-xs text-muted">
                  <div class="flex items-center gap-1">
                    <svg class="w-3.5 h-3.5 text-amber-400" viewBox="0 0 20 20" fill="currentColor"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.95a1 1 0 00.95.69h4.18c.969 0 1.371 1.24.588 1.81l-3.388 2.46a1 1 0 00-.363 1.118l1.287 3.95c.3.921-.755 1.688-1.54 1.118l-3.388-2.46a1 1 0 00-1.175 0l-3.388 2.46c-.784.57-1.838-.197-1.539-1.118l1.287-3.95a1 1 0 00-.363-1.118L2.098 9.377c-.783-.57-.38-1.81.588-1.81h4.18a1 1 0 00.95-.69l1.286-3.95z"/></svg>
                    <span class="font-bold text-espresso">{{ product?.rating?.toFixed(1) }}</span>
                  </div>
                  <span class="text-slate-300/60">•</span>
                  <span>{{ product?.seller?.sold }}+ terjual</span>
                  <span class="text-slate-300/60">•</span>
                  <span class="hover:text-espresso cursor-pointer underline-offset-4 hover:underline transition">{{ reviewCount }} ulasan</span>
                </div>
              </div>

              <div class="mb-5 flex flex-col gap-2.5 sm:flex-row sm:items-end sm:justify-between">
                <div>
                  <p class="text-[10px] font-bold uppercase tracking-wider text-muted/60 mb-0.5">Harga</p>
                  <p class="text-2xl sm:text-3xl font-extrabold tracking-tight text-terracotta">Rp {{ formatCurrency(displayPrice) }}</p>
                </div>
                <div class="self-start sm:self-auto rounded-xl bg-emerald-50/60 px-3 py-1.5 text-[11px] font-bold text-emerald-700 border border-emerald-500/10 shadow-sm">Stok: {{ selectedStock }}</div>
              </div>

              <div class="space-y-4">
                <div v-if="variantOptions.length" class="mb-4">
                  <label class="block text-[10px] font-bold uppercase tracking-wider text-muted/60 mb-2">Pilih Varian</label>
                  <div class="flex flex-wrap gap-1.5">
                    <button 
                      v-for="variant in variantOptions" 
                      :key="variant.value"
                      @click="selectedVariantId = variant.value"
                      class="px-4 py-2 rounded-xl border text-xs font-bold transition-all duration-200"
                      :class="selectedVariantId === variant.value ? 'border-terracotta bg-terracotta text-white shadow-sm' : 'border-borderSoft hover:border-terracotta/30 text-espresso bg-[#F8F1E7]/10'"
                    >
                      {{ variant.label }}
                    </button>
                  </div>
                </div>

                <!-- Quantity Selector -->
                <div class="flex flex-wrap items-center gap-3 pb-5">
                  <div>
                    <label class="block text-[10px] font-bold text-muted/60 mb-1.5 uppercase tracking-wider">Kuantitas</label>
                    <div class="w-fit flex items-center gap-1.5 rounded-xl border border-borderSoft bg-surface p-1 shadow-sm">
                      <button type="button" @click="decrementQuantity" class="w-8 h-8 flex items-center justify-center rounded-lg bg-slate-50 text-muted transition hover:bg-slate-100 font-medium">-</button>
                      <input type="number" v-model.number="quantity" min="1" :max="selectedStock" class="w-10 border-none bg-transparent text-center text-xs font-bold text-espresso p-0 focus:ring-0" />
                      <button type="button" @click="incrementQuantity" class="w-8 h-8 flex items-center justify-center rounded-lg bg-slate-50 text-muted transition hover:bg-slate-100 font-medium">+</button>
                    </div>
                  </div>
                  <div class="text-[10px] text-muted/50 pt-5">Max {{ selectedStock }} pcs</div>
                </div>

                <!-- Buy/Cart Buttons -->
                <div class="flex flex-col gap-2.5">
                  <div class="grid gap-2.5 sm:grid-cols-2">
                    <button
                      type="button"
                      @click="addToCart"
                      :disabled="!canAddToCart"
                      class="rounded-xl bg-[#2B1E16] px-5 py-3 text-xs font-bold text-white transition hover:bg-black disabled:cursor-not-allowed disabled:opacity-60 shadow-sm"
                    >
                      Tambah ke Keranjang
                    </button>
                    <button
                      type="button"
                      @click="buyNow"
                      :disabled="!canAddToCart"
                      class="rounded-xl bg-terracotta px-5 py-3 text-xs font-bold text-white transition hover:bg-terracottaDark disabled:cursor-not-allowed disabled:opacity-60 shadow-sm"
                    >
                      Beli Sekarang
                    </button>
                  </div>
                  
                  <button
                    type="button"
                    @click="toggleWishlist"
                    class="w-full rounded-xl border border-borderSoft bg-surface px-5 py-3 text-xs font-bold text-espresso transition hover:bg-slate-50 hover:border-slate-300"
                  >
                    <span class="flex items-center justify-center gap-2">
                      <svg class="w-3.5 h-3.5" :class="isWishlisted ? 'fill-red-500 text-red-500' : 'fill-none text-slate-400'" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                      {{ isWishlisted ? 'Tersimpan' : 'Wishlist' }}
                    </span>
                  </button>
                </div>

                <!-- AR Try-On Banner -->
                <button
                  type="button"
                  @click="openArModal"
                  class="w-full relative overflow-hidden rounded-xl bg-[#2B1E16] px-4 py-3.5 text-left transition hover:shadow-md hover:-translate-y-0.5 group mt-2"
                >
                  <div class="absolute right-0 top-0 bottom-0 w-32 bg-white/5 skew-x-12 -mr-10 group-hover:bg-white/10 transition"></div>
                  <div class="flex items-center justify-between relative z-10">
                    <div class="flex items-center gap-2.5">
                      <div class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center text-[#D4AF37]">
                        <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                      </div>
                      <div>
                        <p class="text-white font-bold text-xs">Coba dengan AR</p>
                        <p class="text-white/60 text-[9px] mt-0.5">Lihat produk secara virtual sebelum membeli</p>
                      </div>
                    </div>
                    <svg class="w-4 h-4 text-white/50 group-hover:text-white transition group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                  </div>
                </button>
              </div>
              
              <!-- Share Info -->
              <div class="mt-4 space-y-1.5 text-muted text-xs">
                <button type="button" @click="shareProduct" class="inline-flex items-center gap-1.5 text-espresso hover:text-espresso font-bold">
                  <svg class="w-3.5 h-3.5" viewBox="0 0 20 20" fill="currentColor"><path d="M15 8a3 3 0 10-2.83-4H7.83A3 3 0 105 8c0 .19.02.38.06.56L3.3 10.4a3 3 0 101.2 1.2l1.8-1.54A3.02 3.02 0 008 11a3 3 0 103 3 2.99 2.99 0 00-1.68-.57l-1.8 1.54a3 3 0 10.55 1.18l1.75-1.5a3.02 3.02 0 001.83.64A3 3 0 1015 8z"/></svg>
                  Bagikan produk
                </button>
              </div>
            </div>

            <!-- Reviews (Desktop only) -->
            <div class="rounded-3xl bg-surface p-6 shadow-sm border border-borderSoft">
              <div class="mb-5 flex items-center justify-between">
                <div>
                  <h3 class="text-base sm:text-lg font-bold tracking-tight text-espresso">Ulasan Pelanggan</h3>
                  <p class="text-sm text-muted mt-1">{{ reviewCount }} ulasan terverifikasi</p>
                </div>
                <div class="flex items-center gap-1 bg-amber-50 px-3 py-1.5 rounded-full border border-amber-100">
                  <svg class="w-4 h-4 text-amber-500" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.95a1 1 0 00.95.69h4.18c.969 0 1.371 1.24.588 1.81l-3.388 2.46a1 1 0 00-.363 1.118l1.287 3.95c.3.921-.755 1.688-1.54 1.118l-3.388-2.46a1 1 0 00-1.175 0l-3.388 2.46c-.784.57-1.838-.197-1.539-1.118l1.287-3.95a1 1 0 00-.363-1.118L2.098 9.377c-.783-.57-.38-1.81.588-1.81h4.18a1 1 0 00.95-.69l1.286-3.95z"/></svg>
                  <span class="font-bold text-amber-700 text-sm">{{ product?.rating?.toFixed(1) }}</span>
                </div>
              </div>
              <div v-if="reviews.length" class="space-y-4">
                <div v-for="review in reviews.slice(0, 3)" :key="review.id" class="rounded-2xl border border-borderSoft bg-slate-50 p-4">
                  <div class="flex items-center justify-between gap-4 mb-2">
                    <div class="flex items-center gap-2">
                      <div class="w-8 h-8 rounded-full bg-slate-200 flex items-center justify-center text-xs font-bold text-muted uppercase">
                        {{ (review.author ?? review.user_name ?? 'P')[0] }}
                      </div>
                      <div>
                        <p class="text-sm font-bold text-espresso">{{ review.author ?? review.user_name ?? 'Pembeli' }}</p>
                        <p class="text-[10px] text-slate-400">{{ formatDate(review.date ?? review.created_at) }}</p>
                      </div>
                    </div>
                    <div class="flex items-center gap-0.5 text-amber-400">
                      <template v-for="i in 5" :key="i">
                        <svg class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor" :class="i <= (review.rating ?? 0) ? 'text-amber-400' : 'text-slate-200'"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.95a1 1 0 00.95.69h4.18c.969 0 1.371 1.24.588 1.81l-3.388 2.46a1 1 0 00-.363 1.118l1.287 3.95c.3.921-.755 1.688-1.54 1.118l-3.388-2.46a1 1 0 00-1.175 0l-3.388 2.46c-.784.57-1.838-.197-1.539-1.118l1.287-3.95a1 1 0 00-.363-1.118L2.098 9.377c-.783-.57-.38-1.81.588-1.81h4.18a1 1 0 00.95-.69l1.286-3.95z"/></svg>
                      </template>
                    </div>
                  </div>
                  <p class="text-espresso text-sm">{{ review.comment ?? review.message ?? 'Ulasan tidak tersedia.' }}</p>
                </div>
              </div>
              <p v-else class="text-sm text-muted">Belum ada ulasan untuk produk ini.</p>
            </div>
          </div>
        </div>
      </div>

      <!-- MOBILE VIEW (visible on small screens, hidden on lg and up) -->
      <div class="mobile-view-container block lg:hidden relative pt-[40px]">

        <!-- Hero Carousel Swiper -->
        <div class="relative w-full aspect-[4/5] overflow-hidden bg-slate-100">
          <div class="flex overflow-x-auto snap-x snap-mandatory scroll-smooth hide-scrollbar w-full h-full" ref="mobileImageContainer" @scroll="onMobileScroll">
            <div v-for="(img, idx) in galleryImages" :key="idx" class="w-full h-full flex-shrink-0 snap-start">
              <img :src="img" class="w-full h-full object-cover" />
            </div>
          </div>
          <!-- Floating Back & Share Action Buttons -->
          <button @click="router.push('/')" class="absolute top-4 left-4 z-20 w-9 h-9 flex items-center justify-center rounded-full bg-white/90 backdrop-blur shadow-sm border border-borderSoft/60 text-espresso active:scale-95 transition" title="Kembali">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
          </button>
          <button @click="shareProduct" class="absolute top-4 right-4 z-20 w-9 h-9 flex items-center justify-center rounded-full bg-white/90 backdrop-blur shadow-sm border border-borderSoft/60 text-espresso active:scale-95 transition" title="Bagikan">
            <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 10.742l4.818-2.409m0 0a3 3 0 10-1.228-2.458l-4.818 2.409m1.228 2.458a3 3 0 11-1.228 2.458l4.818-2.409m-1.228-2.458a3 3 0 111.228 2.458"></path></svg>
          </button>
          <!-- Dot Indicators overlayed inside the image -->
          <div class="absolute bottom-6 left-0 right-0 flex justify-center gap-1.5 z-10">
            <button v-for="(img, idx) in galleryImages" :key="idx" 
              @click="scrollToImage(idx)"
              class="h-1.5 rounded-full transition-all duration-300 shadow-sm"
              :class="idx === activeImageIndex ? 'w-5 bg-terracotta' : 'w-1.5 bg-white/75'"
            ></button>
          </div>
          <!-- Image Counter Pill -->
          <div class="absolute bottom-4 right-4 rounded-full bg-slate-900/60 backdrop-blur-sm px-2.5 py-1 text-[9px] font-bold text-white tracking-wider z-10">
            {{ activeImageIndex + 1 }} / {{ galleryImages.length }}
          </div>
        </div>

        <!-- Main Product Card Sheet -->
        <div class="bg-white rounded-t-[2.25rem] -mt-6 relative z-20 px-5 pt-6 pb-28 shadow-[0_-12px_30px_rgba(0,0,0,0.04)] border-t border-borderSoft">
          <div class="space-y-4">
            <!-- Badges & Title -->
            <div>
              <div class="flex items-center gap-2 mb-2">
                <span class="px-2.5 py-0.5 text-[9px] font-bold text-terracotta bg-[#F8F1E7] border border-terracotta/20 rounded-md uppercase tracking-wider">
                  {{ product?.category }}
                </span>
                <span class="px-2.5 py-0.5 text-[9px] font-bold text-muted bg-slate-50 border border-slate-200/60 rounded-md uppercase tracking-wider">
                  {{ product?.origin }}
                </span>
              </div>
              <h1 class="text-xl font-black text-espresso leading-tight">{{ product?.name }}</h1>

              <!-- Star Rating Row -->
              <div class="flex items-center gap-2 mt-2.5">
                <div class="flex items-center gap-1 bg-amber-50 px-2 py-0.5 rounded-lg border border-amber-200/40">
                  <svg class="w-3.5 h-3.5 text-amber-500" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.95a1 1 0 00.95.69h4.18c.969 0 1.371 1.24.588 1.81l-3.388 2.46a1 1 0 00-.363 1.118l1.287 3.95c.3.921-.755 1.688-1.54 1.118l-3.388-2.46a1 1 0 00-1.175 0l-3.388 2.46c-.784.57-1.838-.197-1.539-1.118l1.287-3.95a1 1 0 00-.363-1.118L2.098 9.377c-.783-.57-.38-1.81.588-1.81h4.18a1 1 0 00.95-.69l1.286-3.95z"/></svg>
                  <span class="text-[11px] font-bold text-amber-700">{{ product?.rating?.toFixed(1) }}</span>
                </div>
                <span class="text-slate-200 text-xs">|</span>
                <span class="text-[11px] text-muted font-bold uppercase tracking-wider">{{ product?.seller?.sold }}+ Terjual</span>
                <span class="text-slate-200 text-xs">|</span>
                <span class="text-[11px] text-[#2B1E16] font-bold underline underline-offset-2">{{ reviewCount }} Ulasan</span>
              </div>
            </div>

            <!-- Price and Stock Row -->
            <div class="flex items-center justify-between py-3.5 border-t border-b border-slate-100">
              <div>
                <p class="text-[9px] uppercase font-bold text-slate-400 tracking-wider">Harga Utama</p>
                <p class="text-2xl font-black text-terracotta leading-none mt-1">Rp {{ formatCurrency(displayPrice) }}</p>
              </div>
              <div class="rounded-xl bg-emerald-50 px-3 py-1.5 text-[10px] font-bold text-emerald-700 border border-emerald-500/10">Stok: {{ selectedStock }}</div>
            </div>

            <!-- Glowing AR banner on Mobile -->
            <button @click="openArModal" class="w-full relative overflow-hidden rounded-2xl bg-gradient-to-br from-[#2B1E16] to-[#453124] p-4 text-left shadow-lg border border-amber-500/20 active:scale-[0.98] transition">
              <div class="absolute -right-6 -bottom-6 w-24 h-24 bg-amber-500/10 rounded-full blur-xl"></div>
              <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                  <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-[#D4AF37] to-[#F3E5AB] flex items-center justify-center text-espresso shadow">
                    <svg class="w-5 h-5 text-[#2B1E16]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                  </div>
                  <div>
                    <h4 class="text-xs font-bold text-white flex items-center gap-1.5">
                      AI AR Virtual Try-On 
                      <span class="inline-flex h-1.5 w-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                    </h4>
                    <p class="text-[9px] text-white/60 mt-0.5">Coba produk secara virtual langsung ke tubuh Anda</p>
                  </div>
                </div>
                <svg class="w-4 h-4 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
              </div>
            </button>

            <!-- Variant selector -->
            <div v-if="variantOptions.length" class="pt-2">
              <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-2">Pilih Ukuran / Varian</label>
              <div class="flex flex-wrap gap-2">
                <button 
                  v-for="variant in variantOptions" 
                  :key="variant.value"
                  @click="selectedVariantId = variant.value"
                  class="px-4 py-2.5 rounded-xl border text-xs font-bold transition-all duration-200 active:scale-95"
                  :class="selectedVariantId === variant.value ? 'border-terracotta bg-[#F8F1E7] text-terracotta shadow-sm' : 'border-slate-200 text-espresso bg-white'"
                >
                  {{ variant.label }}
                </button>
              </div>
            </div>

            <!-- Quantity stepper -->
            <div class="flex items-center justify-between pt-3 border-t border-slate-100 mt-2">
              <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Kuantitas</label>
              <div class="flex items-center gap-1.5 rounded-xl border border-slate-200 bg-white p-1 shadow-sm">
                <button type="button" @click="decrementQuantity" class="w-8 h-8 flex items-center justify-center rounded-lg bg-slate-50 text-muted transition hover:bg-slate-100 font-bold">-</button>
                <input type="number" v-model.number="quantity" min="1" :max="selectedStock" class="w-10 border-none bg-transparent text-center text-xs font-bold text-espresso p-0 focus:ring-0" />
                <button type="button" @click="incrementQuantity" class="w-8 h-8 flex items-center justify-center rounded-lg bg-slate-50 text-muted transition hover:bg-slate-100 font-bold">+</button>
              </div>
            </div>

            <!-- Collapsible Info Accordions -->
            <div class="space-y-2.5 pt-4">
              <!-- Description Accordion -->
              <div class="border border-slate-100 rounded-2xl overflow-hidden bg-slate-50/30">
                <button @click="toggleAccordion('description')" class="w-full px-4 py-3.5 flex items-center justify-between text-left font-bold text-xs text-espresso uppercase tracking-wider">
                  <span class="flex items-center gap-2">📝 Deskripsi Produk</span>
                  <svg class="w-4 h-4 text-muted transition-transform duration-300" :class="activeAccordion === 'description' ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                <div v-show="activeAccordion === 'description'" class="px-4 pb-4 pt-1 text-xs text-muted leading-relaxed whitespace-pre-line border-t border-slate-100/50">
                  {{ product?.description }}
                </div>
              </div>

              <!-- Cultural Story Accordion -->
              <div class="border border-slate-100 rounded-2xl overflow-hidden bg-slate-50/30">
                <button @click="toggleAccordion('culture')" class="w-full px-4 py-3.5 flex items-center justify-between text-left font-bold text-xs text-espresso uppercase tracking-wider">
                  <span class="flex items-center gap-2">📜 Cerita Budaya & Filosofi</span>
                  <svg class="w-4 h-4 text-muted transition-transform duration-300" :class="activeAccordion === 'culture' ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                <div v-show="activeAccordion === 'culture'" class="px-4 pb-4 pt-1.5 space-y-3.5 text-xs text-muted leading-relaxed border-t border-slate-100/50">
                  <div>
                    <h4 class="font-bold text-terracotta mb-1 uppercase tracking-wider text-[10px]">Filosofi Budaya</h4>
                    <p>{{ product?.cultural_story }}</p>
                  </div>
                  <div class="border-t border-slate-100/60 pt-2.5">
                    <h4 class="font-bold text-terracotta mb-1 uppercase tracking-wider text-[10px]">Makna Motif</h4>
                    <p>{{ product?.motif_meaning }}</p>
                  </div>
                </div>
              </div>

              <!-- Material Accordion -->
              <div class="border border-slate-100 rounded-2xl overflow-hidden bg-slate-50/30">
                <button @click="toggleAccordion('material')" class="w-full px-4 py-3.5 flex items-center justify-between text-left font-bold text-xs text-espresso uppercase tracking-wider">
                  <span class="flex items-center gap-2">👕 Material & Perawatan</span>
                  <svg class="w-4 h-4 text-muted transition-transform duration-300" :class="activeAccordion === 'material' ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                <div v-show="activeAccordion === 'material'" class="px-4 pb-4 pt-1 text-xs text-muted leading-relaxed whitespace-pre-line border-t border-slate-100/50">
                  {{ product?.material_care }}
                </div>
              </div>

              <!-- Seller Accordion -->
              <div class="border border-slate-100 rounded-2xl overflow-hidden bg-slate-50/30">
                <button @click="toggleAccordion('seller')" class="w-full px-4 py-3.5 flex items-center justify-between text-left font-bold text-xs text-espresso uppercase tracking-wider">
                  <span class="flex items-center gap-2">🏪 Informasi Pengrajin (UMKM)</span>
                  <svg class="w-4 h-4 text-muted transition-transform duration-300" :class="activeAccordion === 'seller' ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                <div v-show="activeAccordion === 'seller'" class="px-4 pb-4 pt-3.5 border-t border-slate-100/50 space-y-4">
                  <div class="flex items-center justify-between gap-2">
                    <div class="flex items-center gap-3">
                      <div class="w-11 h-11 rounded-full bg-slate-200 flex items-center justify-center text-slate-500 overflow-hidden border border-slate-300/40">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                      </div>
                      <div>
                        <h4 class="font-bold text-espresso text-xs flex items-center gap-1">
                          {{ product?.seller?.name }}
                          <svg class="w-3.5 h-3.5 text-blue-500 fill-current" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6.267 3.455a.75.75 0 00-.708-.523H4.5a2.5 2.5 0 00-2.5 2.5v1.07a.75.75 0 00.523.708L5.5 8.164v3.672L2.523 12.79A.75.75 0 002 13.5v1.07a2.5 2.5 0 002.5 2.5h1.059a.75.75 0 00.708-.523L8.164 14.5h3.672l.946 2.977a.75.75 0 00.708.523H14.5a2.5 2.5 0 002.5-2.5v-1.07a.75.75 0 00-.523-.708L14.5 11.836V8.164l2.977-.946a.75.75 0 00.523-.708V5.43a2.5 2.5 0 00-2.5-2.5h-1.059a.75.75 0 00-.708.523L11.836 5.5H8.164L7.218 2.523zM9 9.5a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0z" clip-rule="evenodd"/></svg>
                        </h4>
                        <p class="text-[10px] text-muted flex items-center gap-1 mt-0.5">
                          <svg class="w-3 h-3 text-terracotta" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" /></svg>
                          {{ product?.seller?.location }}
                        </p>
                      </div>
                    </div>
                    <button class="px-3.5 py-1.5 rounded-xl border border-terracotta text-terracotta font-bold text-[10px] active:bg-terracotta active:text-white transition">Kunjungi</button>
                  </div>
                </div>
              </div>
            </div>

            <!-- Customer Reviews on Mobile -->
            <div class="pt-6">
              <div class="flex items-center justify-between mb-3">
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400">Ulasan Pelanggan</h3>
                <div class="flex items-center gap-1 bg-amber-50 px-2 py-0.5 rounded-lg border border-amber-200/40">
                  <svg class="w-3.5 h-3.5 text-amber-500" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.95a1 1 0 00.95.69h4.18c.969 0 1.371 1.24.588 1.81l-3.388 2.46a1 1 0 00-.363 1.118l1.287 3.95c.3.921-.755 1.688-1.54 1.118l-3.388-2.46a1 1 0 00-1.175 0l-3.388 2.46c-.784.57-1.838-.197-1.539-1.118l1.287-3.95a1 1 0 00-.363-1.118L2.098 9.377c-.783-.57-.38-1.81.588-1.81h4.18a1 1 0 00.95-.69l1.286-3.95z"/></svg>
                  <span class="text-[10px] font-bold text-amber-700">{{ product?.rating?.toFixed(1) }}</span>
                </div>
              </div>
              <div v-if="reviews.length" class="space-y-3">
                <div v-for="review in reviews.slice(0, 2)" :key="review.id" class="rounded-xl border border-slate-100 bg-slate-50/50 p-3.5">
                  <div class="flex items-center justify-between gap-4 mb-1.5">
                    <div class="flex items-center gap-2">
                      <div class="w-6 h-6 rounded-full bg-slate-200 flex items-center justify-center text-[10px] font-bold text-muted uppercase">
                        {{ (review.author ?? review.user_name ?? 'P')[0] }}
                      </div>
                      <div>
                        <p class="text-xs font-bold text-espresso leading-none">{{ review.author ?? review.user_name ?? 'Pembeli' }}</p>
                        <p class="text-[8px] text-slate-400 mt-0.5">{{ formatDate(review.date ?? review.created_at) }}</p>
                      </div>
                    </div>
                    <div class="flex items-center gap-0.5 text-amber-400">
                      <template v-for="i in 5" :key="i">
                        <svg class="w-3 h-3" viewBox="0 0 20 20" fill="currentColor" :class="i <= (review.rating ?? 0) ? 'text-amber-400' : 'text-slate-200'"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.95a1 1 0 00.95.69h4.18c.969 0 1.371 1.24.588 1.81l-3.388 2.46a1 1 0 00-.363 1.118l1.287 3.95c.3.921-.755 1.688-1.54 1.118l-3.388-2.46a1 1 0 00-1.175 0l-3.388 2.46c-.784.57-1.838-.197-1.539-1.118l1.287-3.95a1 1 0 00-.363-1.118L2.098 9.377c-.783-.57-.38-1.81.588-1.81h4.18a1 1 0 00.95-.69l1.286-3.95z"/></svg>
                      </template>
                    </div>
                  </div>
                  <p class="text-espresso text-xs leading-normal">{{ review.comment ?? review.message }}</p>
                </div>
              </div>
              <p v-else class="text-xs text-muted">Belum ada ulasan untuk produk ini.</p>
            </div>

            <!-- Related Products on Mobile -->
            <div class="pt-6">
              <div class="flex items-center justify-between mb-3">
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400">Produk Terkait</h3>
                <button type="button" @click="refreshRelated" class="text-xs font-bold text-terracotta">Refresh</button>
              </div>
              <div v-if="relatedProducts.length" class="flex overflow-x-auto gap-3 py-1.5 hide-scrollbar -mx-5 px-5">
                <router-link
                  v-for="item in relatedProducts"
                  :key="item.id"
                  :to="{ name: 'product.detail', params: { id: item.id } }"
                  class="flex-shrink-0 w-36 block rounded-2xl border border-slate-100 bg-white p-3 transition active:scale-95 shadow-sm"
                >
                  <div class="aspect-square w-full rounded-xl overflow-hidden bg-slate-50">
                    <img :src="item.images?.[0] ?? item.image_url" :alt="item.name" class="h-full w-full object-cover" />
                  </div>
                  <div class="mt-2">
                    <h4 class="text-xs font-semibold text-espresso line-clamp-2 leading-tight h-8">{{ item.name }}</h4>
                    <p class="text-xs font-bold text-terracotta mt-1">Rp {{ formatCurrency(item.price) }}</p>
                  </div>
                </router-link>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>

    <div v-if="showArModal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/60 p-4 overflow-y-auto">
      <div class="w-full max-w-md rounded-[2rem] bg-surface shadow-2xl overflow-hidden flex flex-col p-6 relative">
        <!-- Close Button -->
        <button type="button" @click="closeArModal" class="absolute top-4 right-4 rounded-full bg-slate-100 p-2 text-espresso hover:bg-slate-200 transition z-30">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>

        <div class="mb-4 pr-10">
          <h2 class="text-xl font-black text-[#2B1E16] leading-none">AI AR Try-On</h2>
          <p class="text-muted text-xs mt-1.5 leading-relaxed">Posisikan tubuh Anda di depan kamera untuk melihat kemeja secara virtual.</p>
        </div>

        <!-- Camera & AR Canvas -->
        <div class="bg-slate-950 relative w-full aspect-[3/4] rounded-2xl overflow-hidden shadow-inner">
          <!-- Video Feed (Hidden, used as source for MediaPipe) -->
          <video ref="videoElement" autoplay playsinline class="hidden"></video>
          
          <!-- Canvas (Shows video + AR filter real-time) -->
          <canvas ref="canvasElement" class="absolute inset-0 w-full h-full object-cover"></canvas>

          <!-- Loading State -->
          <div v-if="isInitializingAR" class="absolute inset-0 z-20 flex flex-col items-center justify-center bg-black/70 backdrop-blur-sm text-white p-4 text-center">
            <svg class="w-10 h-10 animate-spin text-terracotta mb-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
            <p class="font-bold text-sm">Menyiapkan Fitur AR...</p>
            <p class="text-white/60 text-[10px] mt-1 leading-relaxed">Mengunduh aset model AI & mendeteksi postur tubuh Anda</p>
          </div>
          
          <div v-if="!isCameraReady && !isCameraDenied && !isInitializingAR" class="absolute inset-0 flex items-center justify-center z-10 bg-slate-955">
            <p class="text-white/80 text-xs font-semibold animate-pulse">Menghubungkan Kamera...</p>
          </div>
          
          <div v-if="isCameraDenied" class="absolute inset-0 flex flex-col items-center justify-center p-6 text-center z-20 bg-slate-950/95 text-white">
            <div class="w-10 h-10 rounded-full bg-red-500/20 flex items-center justify-center text-red-500 mb-3">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            </div>
            <p class="font-bold text-sm mb-1">Akses Kamera Ditolak</p>
            <p class="text-slate-400 text-[10px] leading-relaxed">Mohon izinkan akses kamera pada pengaturan browser Anda untuk mencoba fitur ini.</p>
          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- Mobile Sticky Bottom Bar (Visible only on mobile) -->
  <div class="lg:hidden fixed bottom-0 left-0 right-0 z-40 bg-surface/95 backdrop-blur-md border-t border-borderSoft p-4 pb-6 flex items-center gap-3 shadow-[0_-10px_30px_rgba(0,0,0,0.06)]">
    <!-- Wishlist Button -->
    <button
      type="button"
      @click="toggleWishlist"
      class="w-12 h-12 rounded-xl border border-borderSoft flex items-center justify-center transition active:scale-95 bg-surface text-espresso"
      :class="isWishlisted ? 'text-red-500 border-red-200 bg-red-50/50' : 'text-espresso'"
    >
      <svg class="w-5 h-5" :class="isWishlisted ? 'fill-current' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
      </svg>
    </button>

    <!-- Tambah ke Keranjang -->
    <button
      type="button"
      @click="addToCart"
      :disabled="!canAddToCart"
      class="flex-1 py-3 bg-[#2B1E16] text-white rounded-xl font-bold text-xs uppercase tracking-widest transition active:scale-95 disabled:opacity-50"
    >
      + Keranjang
    </button>

    <!-- Beli Sekarang -->
    <button
      type="button"
      @click="buyNow"
      :disabled="!canAddToCart"
      class="flex-1 py-3 bg-terracotta text-white rounded-xl font-bold text-xs uppercase tracking-widest transition active:scale-95 disabled:opacity-50 shadow-md shadow-terracotta/20"
    >
      Beli Sekarang
    </button>
  </div>

  <!-- Beli Sekarang (Buy Now) Variation Modal -->
  <div v-if="showBuyNowModal" class="fixed inset-0 z-50 flex items-end sm:items-center justify-center bg-espresso/40 backdrop-blur-sm p-0 sm:p-4">
    <!-- Backdrop Close Trigger -->
    <div class="absolute inset-0" @click="showBuyNowModal = false"></div>
    
    <!-- Modal Content -->
    <div class="relative w-full sm:max-w-md bg-surface rounded-t-[2rem] sm:rounded-[2rem] p-6 shadow-2xl border-t sm:border border-borderSoft overflow-hidden animate-slide-up sm:animate-fade-in flex flex-col max-h-[90vh]">
      <!-- Header -->
      <div class="flex items-center justify-between pb-4 border-b border-borderSoft mb-4">
        <h3 class="text-lg font-black text-espresso">Beli Sekarang</h3>
        <button @click="showBuyNowModal = false" class="w-8 h-8 rounded-full bg-slate-50 flex items-center justify-center text-slate-400 hover:text-espresso transition-colors">✕</button>
      </div>

      <!-- Product Preview -->
      <div class="flex gap-4 mb-6">
        <div class="w-20 h-20 bg-slate-100 rounded-2xl overflow-hidden flex-shrink-0">
          <img :src="product?.images?.[0] || '/images/placeholder-product.png'" class="w-full h-full object-cover" />
        </div>
        <div class="flex-1 min-w-0">
          <h4 class="font-bold text-espresso line-clamp-2 leading-snug">{{ product?.name }}</h4>
          <p class="text-lg font-black text-terracotta mt-2">Rp {{ formatCurrency(displayPrice) }}</p>
          <p class="text-[10px] font-semibold text-slate-400 mt-1">Stok: {{ selectedStock }}</p>
        </div>
      </div>

      <!-- Variant Selector -->
      <div v-if="variantOptions.length" class="mb-6">
        <label class="block text-xs font-black uppercase tracking-wider text-slate-400 mb-2.5">Pilih Ukuran / Varian</label>
        <div class="flex flex-wrap gap-2">
          <button 
            v-for="variant in variantOptions" 
            :key="variant.value"
            @click="selectedVariantId = variant.value"
            class="px-4 py-2.5 rounded-xl border text-xs font-bold transition-all duration-200 active:scale-95"
            :class="selectedVariantId === variant.value ? 'border-terracotta bg-[#F8F1E7] text-terracotta shadow-sm' : 'border-slate-200 text-espresso bg-white'"
          >
            {{ variant.label }}
          </button>
        </div>
      </div>

      <!-- Quantity Stepper -->
      <div class="flex items-center justify-between pb-6 border-b border-borderSoft mb-6">
        <span class="text-xs font-black uppercase tracking-wider text-slate-400">Jumlah</span>
        <div class="flex items-center gap-1.5 rounded-xl border border-slate-200 bg-white p-1 shadow-sm">
          <button type="button" @click="decrementQuantity" class="w-8 h-8 flex items-center justify-center rounded-lg bg-slate-50 text-muted transition hover:bg-slate-100 font-bold">-</button>
          <input type="number" v-model.number="quantity" min="1" :max="selectedStock" class="w-10 border-none bg-transparent text-center text-xs font-bold text-espresso p-0 focus:ring-0" />
          <button type="button" @click="incrementQuantity" class="w-8 h-8 flex items-center justify-center rounded-lg bg-slate-50 text-muted transition hover:bg-slate-100 font-bold">+</button>
        </div>
      </div>

      <!-- Action Button -->
      <button 
        @click="confirmBuyNow"
        :disabled="quantity > selectedStock"
        class="w-full rounded-2xl bg-terracotta text-white py-4 font-black text-xs uppercase tracking-widest hover:bg-terracottaDark transition active:scale-[0.98] disabled:opacity-50 disabled:cursor-not-allowed shadow-md shadow-terracotta/20"
      >
        Lanjutkan ke Checkout
      </button>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, watch } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { useCartStore } from '@/stores/cartStore';
import { useNotificationStore } from '@/stores/notificationStore';
import { useWishlistStore } from '@/stores/wishlistStore';
import Navbar from '@/pages/landing/partials/Navbar.vue';

const route = useRoute();
const router = useRouter();
const cartStore = useCartStore();
const notificationStore = useNotificationStore();
const wishlistStore = useWishlistStore();

const user = ref(null);
const product = ref(null);
const isLoading = ref(true);
const error = ref('');
const quantity = ref(1);
const activeImageIndex = ref(0);
const showArModal = ref(false);
const relatedProducts = ref([]);
const variantOptions = ref([]);
const selectedVariantId = ref(null);
const activeTab = ref('Cerita Budaya');
const activeAccordion = ref('description');
const toggleAccordion = (name) => {
  activeAccordion.value = activeAccordion.value === name ? '' : name;
};

const mobileImageContainer = ref(null);
const onMobileScroll = (e) => {
  const width = e.target.offsetWidth;
  const scrollLeft = e.target.scrollLeft;
  if (width > 0) {
    activeImageIndex.value = Math.round(scrollLeft / width);
  }
};
const scrollToImage = (idx) => {
  activeImageIndex.value = idx;
  if (mobileImageContainer.value) {
    const width = mobileImageContainer.value.offsetWidth;
    mobileImageContainer.value.scrollTo({
      left: idx * width,
      behavior: 'smooth'
    });
  }
};

// AR Try-On State
const videoElement = ref(null);
const canvasElement = ref(null);
const stream = ref(null);
const isCameraReady = ref(false);
const isCameraDenied = ref(false);
const isCapturing = ref(false);
const capturedImage = ref(null);
const isAnalyzing = ref(false);
const analysisResult = ref(null);
const isInitializingAR = ref(false);

// MediaPipe State
let pose = null;
let camera = null;
let productImgObj = null;

// Smoothing state untuk landmark tracking yang halus
let smoothedLandmarks = null;
const SMOOTH_FACTOR = 0.35; // 0 = no smoothing, 1 = full lag

const fetchJson = async (url) => {
  const res = await fetch(url, { headers: { 'Accept': 'application/json' } });
  if (!res.ok) throw new Error('Gagal memuat data');
  const payload = await res.json();
  return payload?.data ?? payload;
};

const safeParseArray = (value) => {
  if (!value) return [];
  if (Array.isArray(value)) return value;
  try {
    return JSON.parse(value);
  } catch {
    return [value];
  }
};

const normalizeProduct = (raw) => {
  const item = raw?.product ?? raw;
  const images = safeParseArray(item.images ?? item.gallery ?? item.image_url ?? []).filter(Boolean);
  
  const price = item.price ? Number(item.price) : 349000;
  const mockVariants = [
    { id: 1, name: 'S', price: price },
    { id: 2, name: 'M', price: price },
    { id: 3, name: 'L', price: price },
    { id: 4, name: 'XL', price: price }
  ];
  
  const variants = mockVariants;
  const reviews = Array.isArray(item.reviews) ? item.reviews : [];

  const dbName = item.name ?? '';
  const category = item.category ?? 'batik';

  // Dynamic cultural stories based on name & category
  let culturalStory = 'Karya seni warisan nusantara hasil kurasi UMKM lokal terpilih dengan standar kualitas tinggi.';
  let motifMeaning = 'Setiap produk membawa identitas budaya lokal yang membanggakan.';
  let materialCare = 'Perawatan:\nIkuti petunjuk perawatan khusus pada label kemasan produk.';

  if (category === 'batik') {
    if (dbName.includes('Parang')) {
      culturalStory = 'Motif Parang dikenal sebagai simbol kekuatan, keteguhan, dan semangat yang terus bergerak maju. Motif ini banyak digunakan dalam karya batik Yogyakarta dan Solo.';
      motifMeaning = 'Garis diagonal pada motif Parang menggambarkan kesinambungan dan perjuangan. Filosofinya cocok untuk pengguna yang ingin membawa kesan kuat, elegan, dan berkarakter.';
    } else if (dbName.includes('Mega Mendung') || dbName.includes('MegaMendung')) {
      culturalStory = 'Motif Mega Mendung merupakan ikon batik Cirebon yang melambangkan ketenangan, kesabaran, dan kebijaksanaan seperti awan mendung yang menyejukkan.';
      motifMeaning = 'Bentuk awan berlapis melambangkan dunia atas yang membawa hujan pembawa berkah, serta kesabaran dalam menahan amarah.';
    } else if (dbName.includes('Lasem')) {
      culturalStory = 'Batik Lasem sangat dipengaruhi oleh akulturasi budaya Tionghoa dan Jawa pesisir, menghasilkan warna merah khas (merah darah ayam) yang legendaris.';
      motifMeaning = 'Motif burung phoenix (lokcan) melambangkan keabadian dan keberuntungan, berpadu dengan motif tumbuhan khas Jawa.';
    } else {
      culturalStory = 'Batik tradisional nusantara yang dibuat oleh pengrajin berpengalaman dengan melestarikan keahlian tulis/cap turun-temurun.';
      motifMeaning = 'Tiap goresan lilin malam pada kain ini memiliki makna filosofis mendalam tentang keseimbangan hidup dan keselarasan dengan alam.';
    }
    materialCare = 'Material:\nKatun premium dengan tekstur lembut dan nyaman digunakan.\n\nPerawatan:\nCuci manual dengan air dingin, hindari pemutih, dan jemur di tempat teduh agar warna tetap awet.';
  } else if (category === 'kerajinan') {
    culturalStory = 'Karya tenun ikat tradisional yang ditenun secara manual menggunakan alat tenun bukan mesin (ATBM) serta benang dengan pewarnaan alami.';
    motifMeaning = 'Motif geometris khas suku nusantara yang menceritakan tentang hubungan harmonis manusia dengan leluhur dan alam sekitar.';
    materialCare = 'Material:\nBenang tenun katun premium dengan pewarna alami.\n\nPerawatan:\nDry clean sangat disarankan, atau cuci tangan perlahan tanpa diperas keras.';
  } else if (category === 'aksesoris') {
    culturalStory = 'Aksesoris tradisional hasil karya seniman logam Kotagede dan Celuk yang dipahat dan dibentuk secara manual dengan ketelitian tinggi.';
    motifMeaning = 'Sentuhan motif ukiran klasik khas kerajaan nusantara yang melambangkan kemewahan, kehormatan, dan keanggunan.';
    materialCare = 'Material:\nPerak murni 925 / Alpaka berkualitas.\n\nPerawatan:\nHindari kontak langsung dengan parfum, simpan di wadah kedap udara, dan bersihkan dengan kain microfiber.';
  } else if (category === 'dekorasi') {
    culturalStory = 'Elemen interior rumah yang menggabungkan motif batik klasik dengan desain fungsional modern untuk memperindah ruang tinggal Anda.';
    motifMeaning = 'Simbol kehangatan keluarga dan estetika warisan budaya yang membawa aura ketenangan di dalam rumah.';
    materialCare = 'Material:\nKain katun batik premium tebal.\n\nPerawatan:\nCuci dengan deterjen lembut tanpa pemutih, setrika dengan suhu sedang.';
  }

  const sellerName = item.umkm_name ?? item.owner?.profile?.business_name ?? item.owner?.name ?? 'Sanggar Batik Laras';
  const sellerLocation = item.origin ?? 'Yogyakarta, Indonesia';

  return {
    id: item.id,
    name: dbName || 'Kemeja Batik Parang Heritage',
    price: price,
    description: item.description ?? 'Kemeja batik premium dengan motif klasik, dirancang untuk tampilan formal maupun casual. Dibuat dari kain berkualitas tinggi.',
    category: category,
    sku: item.sku ?? item.code ?? 'N/A',
    rating: item.rating ?? item.average_rating ?? 4.8,
    average_rating: item.average_rating ?? item.rating ?? 4.8,
    reviews,
    seller: {
      name: sellerName,
      location: sellerLocation,
      rating: 4.9,
      sold: item.sold ?? 120,
    },
    cultural_story: culturalStory,
    motif_meaning: motifMeaning,
    material_care: materialCare,
    artisan_info: `Dibuat oleh ${sellerName}, UMKM asal ${sellerLocation} yang berfokus pada pelestarian kerajinan nusantara dengan sentuhan desain modern.`,
    badges: item.badges ? (typeof item.badges === 'string' ? safeParseArray(item.badges) : item.badges) : ['Handmade', 'Premium', 'AR Ready'],
    images: images.length ? [images[0], images[0], images[0], images[0]] : ['/images/placeholder-product.png'],
    stock: Math.max(1, item.stock ?? item.quantity ?? 999),
    variants,
  };
};

const loadProduct = async () => {
  isLoading.value = true;
  error.value = '';

  try {
    const id = route.params.id;
    const payload = await fetchJson(`/api/v1/products/${id}`);
    const normalized = normalizeProduct(payload);

    product.value = normalized;
    activeImageIndex.value = 0;
    variantOptions.value = normalized.variants.map((variant, idx) => {
      const labelParts = [variant.name, variant.size, variant.color].filter(Boolean);
      return {
        value: variant.id ?? idx,
        label: labelParts.length ? labelParts.join(' - ') : `Varian ${idx + 1}`,
        price: variant.price ?? normalized.price,
        stock: Math.max(1, variant.stock ?? normalized.stock ?? 999),
        raw: variant,
      };
    });

    if (variantOptions.value.length) {
      selectedVariantId.value = variantOptions.value[0].value;
    }

    const related = await fetchJson('/api/v1/products');
    const list = Array.isArray(related) ? related : related.data ?? [];
    const relatedNames = ['Outer Batik Mega Mendung', 'Kemeja Batik Kawung', 'Scarf Batik Cirebon', 'Blouse Batik Lasem'];

    relatedProducts.value = list
      .filter((item) => item?.id && item.id !== normalized.id)
      .slice(0, 4)
      .map((item, idx) => {
        const norm = normalizeProduct(item);
        norm.name = relatedNames[idx] || norm.name;
        return norm;
      });
  } catch (err) {
    console.error(err);
    error.value = 'Gagal memuat data produk. Silakan coba lagi.';
  } finally {
    isLoading.value = false;
  }
};

const galleryImages = computed(() => product.value?.images ?? []);
const activeImage = computed(() => galleryImages.value[activeImageIndex.value] ?? '');
const currentImageLabel = computed(() => `${activeImageIndex.value + 1}/${galleryImages.value.length}`);
const isWishlisted = computed(() => product.value ? wishlistStore.isWishlisted(product.value.id) : false);
const selectedVariant = computed(() => variantOptions.value.find((variant) => variant.value === selectedVariantId.value));
const displayPrice = computed(() => selectedVariant.value?.price ?? product.value?.price ?? 0);
const selectedStock = computed(() => {
  const stock = selectedVariant.value?.stock ?? product.value?.stock ?? 0;
  return Math.max(1, stock);
});
const reviews = computed(() => product.value?.reviews ?? []);
const reviewCount = computed(() => reviews.value.length);
const canAddToCart = computed(() => selectedStock.value > 0 && !isLoading.value);

const formatCurrency = (value) => {
  const number = Number(value ?? 0);
  return number.toLocaleString('id-ID');
};

const formatDate = (value) => {
  if (!value) return '-';
  const date = new Date(value);
  return date.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
};

const incrementQuantity = () => {
  const maxStock = selectedStock.value || product.value?.stock || 1;
  if (quantity.value < maxStock) {
    quantity.value += 1;
  }
};

const decrementQuantity = () => {
  if (quantity.value > 1) {
    quantity.value -= 1;
  }
};

const addToCart = async () => {
  if (!product.value) {
    notificationStore.error('Produk tidak ditemukan');
    return;
  }
  const variant = selectedVariant.value?.label ?? null;
  await cartStore.addItem(product.value, quantity.value, variant);
  notificationStore.success('Berhasil menambahkan ke keranjang', 3000, 'Success');
};

const showBuyNowModal = ref(false);

const buyNow = () => {
  if (!product.value) {
    notificationStore.error('Produk tidak ditemukan');
    return;
  }
  showBuyNowModal.value = true;
};

const confirmBuyNow = async () => {
  showBuyNowModal.value = false;
  
  const token = localStorage.getItem('token');
  const userStored = localStorage.getItem('user');
  const isAuthenticated = !!(token && userStored);

  const selectedVariantLabel = selectedVariant.value?.label ?? '';

  if (!isAuthenticated) {
    notificationStore.info('Silakan login terlebih dahulu untuk melakukan checkout.');
    router.push({ 
      name: 'login', 
      query: { 
        redirect: `/checkout?source=buy-now&product_id=${product.value.id}&qty=${quantity.value}&variant=${encodeURIComponent(selectedVariantLabel)}` 
      } 
    });
    return;
  }

  // Save the single checkout item in sessionStorage
  const buyNowItem = {
    id: product.value.id,
    product_id: product.value.id,
    name: product.value.name,
    image: product.value.images?.[0] ?? '',
    variant: selectedVariantLabel || null,
    quantity: quantity.value,
    price: selectedVariant.value?.price ?? product.value.price
  };
  sessionStorage.setItem('buy_now_item', JSON.stringify(buyNowItem));

  notificationStore.success('Membuka checkout...');
  setTimeout(() => router.push({ path: '/checkout', query: { source: 'buy-now' } }), 400);
};

const toggleWishlist = async () => {
  if (product.value) {
    await wishlistStore.toggleWishlist(product.value);
  }
};

const shareProduct = async () => {
  const shareData = {
    title: product.value.name,
    text: 'Lihat produk batik menarik di SnapFit Marketplace',
    url: window.location.href,
  };

  try {
    if (navigator.share) {
      await navigator.share(shareData);
      return;
    }
  } catch (err) {
    console.warn('Share API gagal:', err);
  }

  await navigator.clipboard.writeText(window.location.href);
  window.alert('Link produk berhasil disalin ke clipboard.');
};

const refreshRelated = async () => {
  await loadProduct();
};

/* ── Navigation ───────────────────────────────────────── */
const goToLogin   = () => router.push('/login');
const goToProfile = () => console.log('Navigate to profile');
const goToOrders  = () => router.push('/orders');

const logout = () => {
  localStorage.removeItem('user');
  localStorage.removeItem('token');
  user.value = null;
  router.push('/');
};

// AR Try-On Functions
const openArModal = async () => {
  showArModal.value = true;
  await initProductImage();
  await loadMediaPipe();
  await startCamera();
};

const closeArModal = () => {
  stopCamera();
  showArModal.value = false;
  capturedImage.value = null;
  analysisResult.value = null;
  isAnalyzing.value = false;
  isInitializingAR.value = false;
  smoothedLandmarks = null;
};

const initProductImage = () => {
  return new Promise((resolve) => {
    const imgUrl = product.value?.images?.[0];
    if (!imgUrl) { console.warn('[AR] Tidak ada gambar produk'); resolve(); return; }

    console.log('[AR] Memuat gambar produk:', imgUrl);

    // Coba load dengan crossOrigin untuk bisa processing pixel
    const img = new Image();
    img.crossOrigin = "anonymous";

    img.onload = () => {
      console.log('[AR] Gambar produk berhasil dimuat:', img.width, 'x', img.height);
      try {
        // Crop atas 15% untuk buang hanger
        const cropTop = Math.floor(img.height * 0.15);
        const croppedH = img.height - cropTop;

        const c = document.createElement('canvas');
        const ctx = c.getContext('2d');
        c.width = img.width;
        c.height = croppedH;
        ctx.drawImage(img, 0, cropTop, img.width, croppedH, 0, 0, img.width, croppedH);

        // Test apakah bisa getImageData (CORS check)
        ctx.getImageData(0, 0, 1, 1);

        // Berhasil — lakukan background removal sederhana
        const imageData = ctx.getImageData(0, 0, c.width, c.height);
        const d = imageData.data;
        for (let i = 0; i < d.length; i += 4) {
          const r = d[i], g = d[i+1], b = d[i+2];
          const brightness = (r + g + b) / 3;
          const saturation = Math.max(r, g, b) - Math.min(r, g, b);
          // Hapus pixel yang sangat terang dan tidak berwarna (putih/abu-abu muda)
          if (brightness > 200 && saturation < 30) {
            d[i+3] = 0;
          } else if (brightness > 170 && saturation < 20) {
            d[i+3] = 100;
          }
        }
        ctx.putImageData(imageData, 0, 0);
        productImgObj = c;
        console.log('[AR] Background removal berhasil');
      } catch(e) {
        console.warn('[AR] CORS issue, pakai gambar mentah (tanpa bg removal):', e.message);
        productImgObj = img;
      }
      resolve();
    };

    img.onerror = () => {
      console.warn('[AR] Gagal load dengan CORS, coba tanpa crossOrigin...');
      // Fallback: load tanpa crossOrigin — tidak bisa processing pixel, tapi bisa di-render
      const img2 = new Image();
      img2.onload = () => {
        console.log('[AR] Gambar berhasil dimuat tanpa CORS');
        productImgObj = img2;
        resolve();
      };
      img2.onerror = () => {
        console.error('[AR] Gambar produk gagal total dimuat');
        productImgObj = null;
        resolve();
      };
      img2.src = imgUrl;
    };

    img.src = imgUrl;
  });
};

const loadScript = (src) => {
  return new Promise((resolve, reject) => {
    if (document.querySelector(`script[src="${src}"]`)) {
      resolve();
      return;
    }
    const script = document.createElement('script');
    script.src = src;
    script.crossOrigin = 'anonymous';
    script.onload = resolve;
    script.onerror = reject;
    document.head.appendChild(script);
  });
};

const loadMediaPipe = async () => {
  isInitializingAR.value = true;
  try {
    await loadScript('https://cdn.jsdelivr.net/npm/@mediapipe/camera_utils/camera_utils.js');
    await loadScript('https://cdn.jsdelivr.net/npm/@mediapipe/pose/pose.js');
  } catch (err) {
    console.error('Failed to load MediaPipe:', err);
  }
};

const onPoseResults = (results) => {
  const canvas = canvasElement.value;
  if (!canvas || isCapturing.value || capturedImage.value) return;
  
  const ctx = canvas.getContext('2d');
  
  if (canvas.width !== results.image.width) {
    canvas.width = results.image.width;
    canvas.height = results.image.height;
  }
  
  ctx.save();
  ctx.clearRect(0, 0, canvas.width, canvas.height);
  
  // Mirror untuk selfie view
  ctx.translate(canvas.width, 0);
  ctx.scale(-1, 1);
  ctx.drawImage(results.image, 0, 0, canvas.width, canvas.height);
  
  // Overlay baju jika landmark terdeteksi
  if (!productImgObj) {
    // Log sekali saja per 60 frame supaya tidak spam
    if (Math.random() < 0.02) console.warn('[AR] productImgObj belum tersedia');
  }
  if (results.poseLandmarks && productImgObj) {
    const lm = results.poseLandmarks;
    const lShoulder = lm[11];
    const rShoulder = lm[12];
    const lHip = lm[23];
    const rHip = lm[24];
    
    const shouldersVisible = lShoulder.visibility > 0.4 && rShoulder.visibility > 0.4;
    const hipsVisible = lHip.visibility > 0.4 && rHip.visibility > 0.4;
    
    if (shouldersVisible) {
      const lSx = lShoulder.x * canvas.width;
      const lSy = lShoulder.y * canvas.height;
      const rSx = rShoulder.x * canvas.width;
      const rSy = rShoulder.y * canvas.height;
      
      let torsoH;
      if (hipsVisible) {
        // Hitung tinggi torso dari landmark pinggul
        const lHy = lHip.y * canvas.height;
        const rHy = rHip.y * canvas.height;
        torsoH = ((lHy - lSy) + (rHy - rSy)) / 2;
      } else {
        // Fallback: estimasi tinggi torso = 1.8x lebar bahu
        const shoulderW = Math.hypot(lSx - rSx, lSy - rSy);
        torsoH = shoulderW * 1.8;
      }
      
      // Raw coordinates
      const raw = { lSx, lSy, rSx, rSy, torsoH };
      
      // EMA Smoothing — anti goyang/jitter
      if (!smoothedLandmarks) {
        smoothedLandmarks = { ...raw };
      } else {
        for (const key in raw) {
          smoothedLandmarks[key] = smoothedLandmarks[key] * SMOOTH_FACTOR + raw[key] * (1 - SMOOTH_FACTOR);
        }
      }
      const s = smoothedLandmarks;
      
      // Hitung dimensi badan
      const shoulderW = Math.hypot(s.lSx - s.rSx, s.lSy - s.rSy);
      const centerX = (s.lSx + s.rSx) / 2;
      const shoulderY = (s.lSy + s.rSy) / 2;
      const angle = Math.atan2(s.lSy - s.rSy, s.lSx - s.rSx);
      
      // Baju lebih lebar dari bahu (menutupi lengan atas)
      const clothW = shoulderW * 2.2;
      // Tinggi baju dari torso
      const clothH = s.torsoH * 1.55;
      
      ctx.translate(centerX, shoulderY);
      ctx.rotate(angle * 0.4);
      
      // Posisi Y: mulai sedikit di atas bahu (kerah baju)
      const drawY = -clothH * 0.08;
      
      ctx.globalAlpha = 0.88;
      ctx.drawImage(productImgObj, -clothW / 2, drawY, clothW, clothH);
      ctx.globalAlpha = 1.0;
    }
  }
  
  ctx.restore();
};

const startCamera = async () => {
  isCameraReady.value = false;
  isCameraDenied.value = false;
  
  if (window.Pose && window.Camera) {
    try {
      if (!pose) {
        pose = new window.Pose({
          locateFile: (file) => {
            return `https://cdn.jsdelivr.net/npm/@mediapipe/pose/${file}`;
          }
        });
        pose.setOptions({
          modelComplexity: 0,
          smoothLandmarks: true,
          enableSegmentation: false,
          smoothSegmentation: false,
          minDetectionConfidence: 0.5,
          minTrackingConfidence: 0.5
        });
        pose.onResults(onPoseResults);
      }

      const video = videoElement.value;
      
      camera = new window.Camera(video, {
        onFrame: async () => {
          if (!isCapturing.value && !capturedImage.value) {
            await pose.send({image: video});
          }
        },
        width: 640,
        height: 480,
        facingMode: 'user'
      });
      
      await camera.start();
      isCameraReady.value = true;
      isInitializingAR.value = false;
    } catch (err) {
      console.error('Error starting AR Camera:', err);
      isCameraDenied.value = true;
      isInitializingAR.value = false;
      notificationStore.error('Gagal memulai modul AR.');
    }
  } else {
    // Fallback if MediaPipe failed to load
    try {
      const mediaStream = await navigator.mediaDevices.getUserMedia({ 
        video: { facingMode: 'user', width: 640, height: 480 } 
      });
      stream.value = mediaStream;
      if (videoElement.value) {
        videoElement.value.srcObject = mediaStream;
        videoElement.value.onplaying = () => {
          isCameraReady.value = true;
          isInitializingAR.value = false;
          
          // Simple loop to draw to canvas without AR if MediaPipe fails
          const drawFallback = () => {
            if (isCapturing.value || capturedImage.value) return;
            const canvas = canvasElement.value;
            const ctx = canvas.getContext('2d');
            canvas.width = videoElement.value.videoWidth;
            canvas.height = videoElement.value.videoHeight;
            ctx.save();
            ctx.translate(canvas.width, 0);
            ctx.scale(-1, 1);
            ctx.drawImage(videoElement.value, 0, 0, canvas.width, canvas.height);
            // Draw static product overlay
            if (productImgObj) {
              ctx.globalCompositeOperation = 'multiply';
              ctx.drawImage(productImgObj, canvas.width/4, canvas.height/4, canvas.width/2, (canvas.width/2) * (productImgObj.height/productImgObj.width));
            }
            ctx.restore();
            requestAnimationFrame(drawFallback);
          };
          drawFallback();
        };
      }
    } catch (err) {
      console.error('Error accessing camera:', err);
      isCameraDenied.value = true;
      isInitializingAR.value = false;
      notificationStore.error('Akses kamera ditolak atau perangkat tidak mendukung.');
    }
  }
};

const stopCamera = () => {
  if (camera) {
    camera.stop();
  }
  if (stream.value) {
    stream.value.getTracks().forEach(track => track.stop());
    stream.value = null;
  }
};

const retake = () => {
  capturedImage.value = null;
  analysisResult.value = null;
  smoothedLandmarks = null;
  startCamera();
};

const captureAndAnalyze = async () => {
  if (!canvasElement.value) return;
  
  isCapturing.value = true;
  const canvas = canvasElement.value;
  
  // Get base64 image (JPEG format)
  // The canvas already contains the mirrored video + multiply-blended clothing filter!
  const base64Image = canvas.toDataURL('image/jpeg', 0.8);
  capturedImage.value = base64Image;
  
  // Stop camera feed to freeze image
  stopCamera();
  isCapturing.value = false;
  
  // Send to AI
  await analyzeWithAI(base64Image);
};

const analyzeWithAI = async (base64Image) => {
  isAnalyzing.value = true;
  analysisResult.value = null;
  
  try {
    const token = localStorage.getItem('token');
    
    // We send base64 data to backend
    const response = await fetch('/api/v1/ar-try-on/analyze', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'Authorization': `Bearer ${token}`
      },
      body: JSON.stringify({
        user_photo: base64Image,
        product_name: product.value.name,
        product_category: product.value.category,
        product_description: product.value.description
      })
    });
    
    if (!response.ok) {
      throw new Error(`Terjadi kesalahan (${response.status})`);
    }
    
    const resData = await response.json();
    analysisResult.value = resData.analysis;
    notificationStore.success('Analisis selesai!');
  } catch (err) {
    console.error('AR Try-On Analysis error:', err);
    notificationStore.error('Gagal menganalisis gambar. Pastikan server AI berjalan.');
  } finally {
    isAnalyzing.value = false;
  }
};

watch(
  () => route.params.id,
  async () => {
    await loadProduct();
  }
);

onMounted(() => {
  const stored = localStorage.getItem('user');
  if (stored) user.value = JSON.parse(stored);
  loadProduct();
});
</script>

<style scoped>
.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
.hide-scrollbar::-webkit-scrollbar {
  display: none;
}
.hide-scrollbar {
  -ms-overflow-style: none;
  scrollbar-width: none;
}

@media (max-width: 1023px) {
  .desktop-view-container {
    display: none !important;
  }
  .mobile-view-container {
    display: block !important;
  }
}
@media (min-width: 1024px) {
  .desktop-view-container {
    display: block !important;
  }
  .mobile-view-container {
    display: none !important;
  }
}
</style>
