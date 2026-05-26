<template>
  <div class="snapfit-heritage-bg min-h-screen text-espresso selection:bg-terracotta selection:text-white font-sans relative pb-20">
    
    <main class="max-w-6xl mx-auto px-4 py-8 md:py-12">
      <!-- Back button and title -->
      <div class="mb-8" data-aos="fade-down">
        <button 
          @click="goBack" 
          class="inline-flex items-center gap-2 px-4 py-2 rounded-full border border-borderSoft bg-surface hover:bg-slate-50 text-slate-500 hover:text-espresso transition-all duration-200 font-bold text-xs shadow-sm hover:shadow active:scale-95 mb-5"
        >
          <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" />
          </svg>
          Kembali ke Keranjang
        </button>
        <h1 class="text-3xl md:text-4xl font-bold text-espresso tracking-tight">Checkout Pembayaran</h1>
        <p class="text-slate-500 mt-2 text-xs md:text-sm max-w-xl leading-relaxed">
          Tinjau kembali rincian pemesanan Anda sebelum melakukan pembayaran menggunakan gerbang pembayaran aman Midtrans.
        </p>
      </div>

      <!-- Main Layout Grid -->
      <div class="grid gap-8 lg:grid-cols-[1.6fr_1fr] items-start">
        
        <!-- Left Column: Checkout Sections -->
        <div class="space-y-6" data-aos="fade-up">
          
          <!-- SECTION 1: SHIPPING ADDRESS -->
          <div class="rounded-3xl bg-surface p-6 md:p-8 shadow-md border border-borderSoft hover:shadow-lg transition-all duration-300">
            <div class="flex items-center justify-between mb-5 pb-4 border-b border-borderSoft/40">
              <h2 class="text-base font-bold text-espresso flex items-center gap-2.5">
                <span class="w-6 h-6 rounded-full bg-sand/60 flex items-center justify-center text-xs text-espresso font-semibold">1</span>
                Alamat Pengiriman
              </h2>
              <button 
                @click="openAddressModal"
                class="rounded-lg border border-borderSoft bg-cream/30 px-3.5 py-1 text-xs font-semibold text-espresso hover:bg-cream transition-all active:scale-95"
              >
                {{ selectedAddress ? 'Ubah Alamat' : 'Pilih Alamat' }}
              </button>
            </div>

            <!-- Address Display -->
            <div v-if="selectedAddress" class="rounded-2xl bg-gradient-to-br from-[#FDFBF7] to-[#F8F1E7]/20 p-6 border border-borderSoft shadow-sm relative overflow-hidden group">
              <!-- Accent border left -->
              <div class="absolute left-0 top-0 bottom-0 w-1 bg-terracotta"></div>
              <div class="flex items-start justify-between">
                <div class="flex gap-3">
                  <div class="w-8 h-8 rounded-full bg-orange-50 border border-orange-100 flex items-center justify-center text-orange-600 flex-shrink-0 mt-0.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                  </div>
                  <div>
                    <div class="flex items-center gap-2">
                      <p class="font-extrabold text-espresso text-base">{{ selectedAddress.name }}</p>
                      <span class="rounded-full bg-emerald-50 text-emerald-800 text-[9px] font-extrabold uppercase tracking-wider px-2.5 py-0.5 border border-emerald-200">Utama</span>
                    </div>
                    <p class="text-sm text-espresso/80 mt-2 font-medium leading-relaxed">{{ selectedAddress.address }}</p>
                    <div class="flex flex-wrap gap-x-4 gap-y-1 text-xs text-slate-400 mt-2.5 font-semibold">
                      <span class="flex items-center gap-1">📍 {{ selectedAddress.city }}, {{ selectedAddress.postal_code }}</span>
                      <span class="flex items-center gap-1">📞 {{ selectedAddress.phone }}</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            
            <div v-else class="text-center py-10 px-6 rounded-2xl border border-dashed border-slate-350 bg-[#FDFBF7]/60 hover:bg-[#FDFBF7] transition-all duration-300 flex flex-col items-center justify-center">
              <div class="w-12 h-12 rounded-full bg-orange-50 border border-orange-100 flex items-center justify-center text-orange-600 mb-3 shadow-inner">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
              </div>
              <p class="text-slate-500 text-xs font-semibold mb-4 leading-normal">Belum ada alamat pengiriman terpilih. Harap tentukan alamat tujuan untuk kalkulasi ongkos kirim.</p>
              <button 
                @click="openAddressModal" 
                class="rounded-xl bg-terracotta hover:bg-terracottaDark text-white px-6 py-2.5 text-xs font-bold uppercase tracking-wider shadow-md shadow-terracotta/10 hover:shadow-terracotta/25 active:scale-95 transition-all duration-200"
              >
                Pilih / Tambah Alamat
              </button>
            </div>
          </div>

          <!-- SECTION 2: PRODUCTS TO CHECKOUT -->
          <div class="rounded-2xl bg-surface p-6 shadow-sm border border-borderSoft/60">
            <h2 class="text-base font-bold text-espresso flex items-center gap-2.5 mb-5 pb-4 border-b border-borderSoft/40">
              <span class="w-6 h-6 rounded-full bg-sand/60 flex items-center justify-center text-xs text-espresso font-semibold">2</span>
              Detail Produk
            </h2>

            <div class="space-y-3">
              <div v-for="item in selectedItems" :key="`${item.id}-${item.variant}`" class="flex gap-4 p-4 rounded-xl bg-[#FDFBF7]/80 border border-borderSoft/40">
                <div class="w-16 h-16 bg-slate-50 rounded-lg overflow-hidden flex-shrink-0 border border-borderSoft/60">
                  <img :src="item.image" class="w-full h-full object-cover" :alt="item.name" />
                </div>
                <div class="flex-1 min-w-0 flex flex-col justify-between">
                  <div>
                    <h3 class="font-bold text-espresso text-xs md:text-sm line-clamp-2 leading-snug">{{ item.name }}</h3>
                    <div class="flex flex-wrap gap-2 items-center mt-1.5">
                      <span v-if="item.variant" class="inline-flex items-center text-[9px] font-semibold text-slate-400 bg-slate-100 rounded px-2 py-0.5">Varian: {{ item.variant }}</span>
                      <span class="text-[10px] text-slate-400 font-medium">{{ formatCurrency(item.price) }} / unit</span>
                    </div>
                  </div>
                  <div class="flex items-baseline justify-between mt-2 pt-1.5 border-t border-dashed border-borderSoft/30">
                    <p class="text-xs text-slate-400 font-medium">Jumlah: <span class="font-bold text-espresso">{{ item.quantity }}</span></p>
                    <p class="font-bold text-terracotta text-xs md:text-sm">{{ formatCurrency((item.price || 0) * (item.quantity || 1)) }}</p>
                  </div>
                </div>
              </div>
            </div>
          </          <!-- SECTION 3: SHIPPING METHODS -->
          <div class="rounded-2xl bg-surface p-6 shadow-sm border border-borderSoft/60">
            <h2 class="text-base font-bold text-espresso flex items-center gap-2.5 mb-5 pb-4 border-b border-borderSoft/40">
              <span class="w-6 h-6 rounded-full bg-sand/60 flex items-center justify-center text-xs text-espresso font-semibold">3</span>
              Metode Pengiriman
            </h2>

            <div class="space-y-5">
              <!-- Courier Selection -->
              <div>
                <label class="block text-xs font-semibold text-slate-400 mb-2 ml-1">Pilih Kurir Ekspedisi</label>
                <div class="grid gap-4 grid-cols-3">
                  <button 
                    v-for="courier in couriers" 
                    :key="courier.id"
                    type="button"
                    @click="selectCourierType(courier.id)"
                    class="text-center py-3.5 rounded-xl border transition-all duration-200"
                    :class="selectedCourier === courier.id ? 'border-terracotta bg-cream/30 text-terracotta font-semibold' : 'border-borderSoft/80 bg-surface text-espresso hover:border-slate-350'"
                  >
                    <span class="text-xs md:text-sm font-semibold">{{ courier.label }}</span>
                  </button>
                </div>
              </div>

              <!-- Service Selection -->
              <div>
                <label class="block text-xs font-semibold text-slate-400 mb-2 ml-1">Pilih Paket Layanan</label>
                <div class="grid gap-4 sm:grid-cols-3">
                  <button 
                    v-for="service in serviceOptions"
                    :key="service.id"
                    type="button"
                    @click="selectServiceOption(service.id)"
                    class="p-4 rounded-xl border text-left flex flex-col justify-between h-28 transition-all duration-200"
                    :class="selectedService === service.id ? 'border-terracotta bg-cream/30 shadow-sm' : 'border-borderSoft bg-surface hover:border-slate-300'"
                  >
                    <div>
                      <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">{{ service.id }}</span>
                      <p class="text-xs font-bold text-espresso mt-0.5 leading-tight">{{ service.name }}</p>
                    </div>
                    <div class="mt-2 flex items-end justify-between w-full pt-1.5 border-t border-dashed border-borderSoft/20 text-xs">
                      <span class="text-slate-550 font-normal">{{ service.duration }}</span>
                      <span class="font-bold text-terracotta">{{ formatCurrency(service.cost) }}</span>
                    </div>
                  </button>
                </div>
              </div>
            </div>    </div>
                  <!-- SECTION 4: PAYMENT SYSTEM -->
          <div class="rounded-2xl bg-surface p-6 shadow-sm border border-borderSoft/60">
            <h2 class="text-base font-bold text-espresso flex items-center gap-2.5 mb-5 pb-4 border-b border-borderSoft/40">
              <span class="w-6 h-6 rounded-full bg-sand/60 flex items-center justify-center text-xs text-espresso font-semibold">4</span>
              Metode Pembayaran
            </h2>

            <div class="rounded-xl border border-borderSoft/80 bg-slate-50/50 p-5 flex items-start gap-4">
              <div class="flex-1">
                <h4 class="font-bold text-espresso text-sm">Pembayaran Instan (Midtrans)</h4>
                <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                  Transaksi aman dan instan via Virtual Account Bank (BCA, Mandiri, BNI, dll), QRIS (GoPay/ShopeePay), atau Kartu Kredit. Anda akan diarahkan ke pop-up pembayaran aman Midtrans.
                </p>
                <!-- Payment Logos row -->
                <div class="flex items-center gap-3 mt-3 opacity-60">
                  <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wider mr-1">Didukung:</span>
                  <span class="px-2 py-0.5 bg-slate-100 rounded text-[9px] font-semibold text-slate-500 border border-slate-200">QRIS</span>
                  <span class="px-2 py-0.5 bg-slate-100 rounded text-[9px] font-semibold text-slate-500 border border-slate-200">GOPAY</span>
                  <span class="px-2 py-0.5 bg-slate-100 rounded text-[9px] font-semibold text-slate-500 border border-slate-200">VA BANK</span>
                  <span class="px-2 py-0.5 bg-slate-100 rounded text-[9px] font-semibold text-slate-500 border border-slate-200">DEBIT/CREDIT</span>
                </div>
              </div>
              <div class="flex items-center h-5">
                <input type="radio" checked disabled class="w-4 h-4 text-terracotta accent-terracotta border-slate-350" />
              </div>
            </div>
          </div>       </div>

        </div>

        <!-- Right Column: Sticky Sidebar Order Summary -->
        <aside class="sticky top-6 space-y-6" data-aos="fade-up" data-aos-delay="100">
          
          <div class="rounded-3xl bg-surface p-6 md:p-8 shadow-lg border border-borderSoft relative overflow-hidden">
            <!-- Top design accent line -->
            <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-terracotta via-gold to-olive"></div>
            
            <h3 class="text-lg font-black text-espresso mb-5 pb-4 border-b border-borderSoft">Ringkasan Belanja</h3>

            <div class="space-y-4 text-sm text-espresso/90 mb-6">
              <div class="flex justify-between font-medium">
                <span class="text-slate-400">Subtotal Barang</span>
                <span class="font-bold text-espresso">{{ formatCurrency(subtotal) }}</span>
              </div>
              <div class="flex justify-between font-medium">
                <span class="text-slate-400">Ongkos Kirim</span>
                <span v-if="shippingCost > 0" class="font-bold text-espresso">{{ formatCurrency(shippingCost) }}</span>
                <span v-else class="text-xs font-bold text-slate-400">Menunggu kalkulasi...</span>
              </div>
              <div class="flex justify-between font-medium">
                <span class="text-slate-400">Biaya Administrasi</span>
                <span class="font-bold text-espresso">Gratis (Rp 0)</span>
              </div>
              
              <div class="border-t border-dashed border-borderSoft pt-5 flex justify-between items-baseline">
                <span class="text-sm font-extrabold text-espresso">Total Tagihan</span>
                <span class="text-2xl font-black text-terracotta">{{ formatCurrency(totalPrice) }}</span>
              </div>
            </div>

            <!-- Error Guidance Helper (if button is disabled) -->
            <div v-if="!selectedAddress || shippingCost === 0" class="mb-4 p-3 bg-amber-50 border border-amber-100 rounded-xl flex items-start gap-2 text-[11px] text-amber-750 font-semibold leading-relaxed">
              <span class="text-sm">⚠️</span>
              <span>Lengkapi <strong>Alamat Pengiriman (1)</strong> dan <strong>Metode Pengiriman (3)</strong> terlebih dahulu untuk melakukan pembayaran.</span>
            </div>

            <!-- Pay Now Button -->
            <button 
              @click="payNow" 
              :disabled="!selectedAddress || shippingCost === 0 || isProcessingPayment" 
              class="w-full rounded-2xl bg-gradient-to-r from-terracotta to-terracottaDark hover:from-terracottaDark hover:to-espresso text-white py-4 font-black text-xs uppercase tracking-widest active:scale-[0.97] transition-all duration-300 disabled:opacity-40 disabled:cursor-not-allowed disabled:transform-none shadow-md shadow-terracotta/20 hover:shadow-terracotta/40 flex items-center justify-center gap-2 h-14"
            >
              <span v-if="isProcessingPayment" class="w-4.5 h-4.5 border-2 border-white border-t-transparent rounded-full animate-spin"></span>
              <span v-else class="text-sm">💳</span>
              {{ isProcessingPayment ? 'Memproses Transaksi...' : 'Bayar Sekarang' }}
            </button>
            
            <p class="text-[10px] text-center text-slate-400 mt-4 leading-normal">Pembayaran diproses secara instan melalui sistem Midtrans. Dengan melanjutkan, Anda menyetujui <span class="underline hover:text-espresso cursor-pointer">S&K Layanan</span> SnapFit.</p>
          </div>

          <!-- Extra Secure Shield Card -->
          <div class="rounded-3xl bg-gradient-to-br from-[#F4FDF9] to-[#ECFDF5] p-5 border border-emerald-200/80 shadow-sm flex items-start gap-3.5 relative overflow-hidden group">
            <div class="absolute right-0 bottom-0 text-emerald-100 opacity-20 transform translate-x-3 translate-y-3 group-hover:scale-110 transition-transform duration-500">
              <svg class="w-20 h-20" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M2.166 4.9L10 1.154l7.834 3.746A1 1 0 0118.5 5.793v5.305a8.978 8.978 0 01-3.072 6.757l-4.717 3.774a1 1 0 01-1.422 0l-4.717-3.774a8.978 8.978 0 01-3.072-6.757V5.793a1 1 0 01.734-.893zM9 13a1 1 0 011.707-.707L13 14.586l-2.293 2.293a1 1 0 01-1.414 0L8 15.586l1-1z" clip-rule="evenodd"/></svg>
            </div>
            <div class="w-9 h-9 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-650 flex-shrink-0 shadow-inner">
              🛡️
            </div>
            <div class="flex-1">
              <h4 class="text-xs font-black text-emerald-950 uppercase tracking-wider">Garansi Keamanan SnapFit</h4>
              <p class="text-[11px] text-emerald-800/90 mt-1.5 leading-relaxed">Seluruh pembayaran dilindungi enkripsi <strong>SSL 256-bit</strong> melalui server aman Midtrans. Dana akan didepositkan sementara dan hanya disalurkan ke UMKM/Pengrajin setelah barang dikonfirmasi sampai di tangan Anda.</p>
            </div>
          </div>
          
        </aside>

      </div>
    </main>

    <!-- ELEGANT ADDRESS MODAL (PILIH / TAMBAH ALAMAT) -->
    <div v-if="showAddressModal" class="fixed inset-0 z-50 flex items-end sm:items-center justify-center bg-espresso/50 backdrop-blur-sm p-0 sm:p-4">
      <div class="absolute inset-0" @click="closeAddressModal"></div>
      
      <div class="relative w-full sm:max-w-2xl bg-surface rounded-t-[2.5rem] sm:rounded-[2.5rem] shadow-2xl border border-borderSoft overflow-hidden flex flex-col max-h-[90vh]">
        <!-- Header -->
        <div class="flex items-center justify-between px-6 py-5 border-b border-borderSoft">
          <div>
            <h3 class="text-xl font-black text-espresso">Pilih Alamat Pengiriman</h3>
            <p class="text-xs text-slate-400 mt-1">Gunakan alamat yang sudah ada atau daftarkan alamat baru.</p>
          </div>
          <button @click="closeAddressModal" class="w-8 h-8 rounded-full bg-slate-50 flex items-center justify-center text-slate-400 hover:text-espresso transition-colors">✕</button>
        </div>

        <!-- Scrollable Modal Body -->
        <div class="overflow-y-auto p-6 flex-1 space-y-6">
          
          <!-- Address List -->
          <div v-if="!showAddressForm">
            <div class="flex items-center justify-between mb-4">
              <span class="text-xs font-black uppercase tracking-wider text-slate-400">Daftar Alamat Saya</span>
              <button 
                @click="showAddressForm = true"
                class="rounded-full bg-terracotta text-white px-4 py-1.5 text-xs font-black hover:bg-terracottaDark transition-all flex items-center gap-1 active:scale-95"
              >
                ➕ Tambah Alamat Baru
              </button>
            </div>

            <div v-if="addresses.length" class="grid gap-4 sm:grid-cols-2">
              <div 
                v-for="address in addresses" 
                :key="address.id"
                @click="selectAddress(address.id)"
                class="text-left rounded-2xl border p-5 transition-all duration-300 cursor-pointer relative flex flex-col justify-between min-h-[160px] group hover:shadow-md"
                :class="selectedAddressId === address.id ? 'border-terracotta bg-[#F8F1E7]/30 ring-2 ring-terracotta/10 shadow-sm' : 'border-borderSoft bg-surface hover:border-slate-350'"
              >
                <div>
                  <div class="flex justify-between items-start gap-2">
                    <p class="font-extrabold text-espresso text-sm flex items-center gap-1.5">
                      👤 {{ address.name }}
                    </p>
                    <span v-if="selectedAddressId === address.id" class="rounded-full bg-terracotta/10 text-terracotta text-[9px] font-black uppercase tracking-wider px-2.5 py-0.5 border border-terracotta/25">Terpilih</span>
                  </div>
                  <p class="text-xs text-espresso/70 mt-2.5 leading-relaxed font-semibold line-clamp-3">🏠 {{ address.address }}</p>
                  <p class="text-[11px] text-slate-400 mt-1 font-semibold pl-4">{{ address.city }} • {{ address.postal_code }}</p>
                </div>
                <div class="mt-4 pt-3 border-t border-borderSoft/40 flex justify-between items-center">
                  <p class="text-[11px] text-slate-400 font-bold">📞 {{ address.phone }}</p>
                  <button @click.stop="deleteAddress(address.id)" class="text-[10px] text-red-500 font-extrabold hover:underline uppercase tracking-wider flex items-center gap-1">
                    🗑️ Hapus
                  </button>
                </div>
              </div>
            </div>
            
            <div v-else class="text-center py-12 bg-slate-50/50 rounded-2xl border border-dashed border-slate-200">
              <p class="text-slate-500 text-sm mb-4">Anda belum mendaftarkan alamat.</p>
              <button @click="showAddressForm = true" class="rounded-full bg-terracotta text-white px-6 py-2.5 text-xs font-black uppercase tracking-widest hover:bg-terracottaDark transition-all">Tambah Alamat Pertama</button>
            </div>
          </div>

          <!-- Add Address Form -->
          <div v-else class="space-y-5">
            <h4 class="text-sm font-black text-espresso uppercase tracking-wider border-b border-borderSoft pb-2.5 flex items-center gap-2">
              <span class="inline-block w-1.5 h-4 bg-terracotta rounded-full"></span>
              Tambah Alamat Pengiriman Baru
            </h4>
            
            <div class="grid gap-4 sm:grid-cols-2">
              <label class="block">
                <span class="text-[10px] font-black uppercase tracking-wider text-slate-400 ml-1">Nama Penerima</span>
                <input v-model="addressForm.name" type="text" class="mt-2 w-full rounded-xl border border-borderSoft bg-[#FDFBF7]/40 px-4 py-3 text-sm font-semibold text-espresso outline-none focus:bg-white focus:border-terracotta focus:ring-4 focus:ring-terracotta/5 transition-all duration-200" placeholder="Contoh: Budi Santoso" />
              </label>
              <label class="block">
                <span class="text-[10px] font-black uppercase tracking-wider text-slate-400 ml-1">No. Handphone</span>
                <input v-model="addressForm.phone" type="tel" class="mt-2 w-full rounded-xl border border-borderSoft bg-[#FDFBF7]/40 px-4 py-3 text-sm font-semibold text-espresso outline-none focus:bg-white focus:border-terracotta focus:ring-4 focus:ring-terracotta/5 transition-all duration-200" placeholder="0812XXXXXXXX" />
              </label>
            </div>
            
            <label class="block">
              <span class="text-[10px] font-black uppercase tracking-wider text-slate-400 ml-1">Alamat Lengkap</span>
              <textarea v-model="addressForm.address" rows="3" class="mt-2 w-full rounded-xl border border-borderSoft bg-[#FDFBF7]/40 px-4 py-3 text-sm font-semibold text-espresso outline-none focus:bg-white focus:border-terracotta focus:ring-4 focus:ring-terracotta/5 transition-all duration-200 resize-none" placeholder="Tuliskan nama jalan, nomor rumah, RT/RW, kelurahan, dan kecamatan."></textarea>
            </label>
            
            <div class="grid gap-4 sm:grid-cols-2">
              <label class="block">
                <span class="text-[10px] font-black uppercase tracking-wider text-slate-400 ml-1">Kota / Kabupaten</span>
                <input v-model="addressForm.city" type="text" class="mt-2 w-full rounded-xl border border-borderSoft bg-[#FDFBF7]/40 px-4 py-3 text-sm font-semibold text-espresso outline-none focus:bg-white focus:border-terracotta focus:ring-4 focus:ring-terracotta/5 transition-all duration-200" placeholder="Yogyakarta" />
              </label>
              <label class="block">
                <span class="text-[10px] font-black uppercase tracking-wider text-slate-400 ml-1">Kode Pos</span>
                <input v-model="addressForm.postal_code" type="text" class="mt-2 w-full rounded-xl border border-borderSoft bg-[#FDFBF7]/40 px-4 py-3 text-sm font-semibold text-espresso outline-none focus:bg-white focus:border-terracotta focus:ring-4 focus:ring-terracotta/5 transition-all duration-200" placeholder="55123" />
              </label>
            </div>
            
            <div v-if="addressError" class="p-3 bg-red-50 border border-red-100 text-red-650 rounded-xl text-xs font-bold flex items-center gap-1.5">
              <span>⚠️</span> {{ addressError }}
            </div>
            
            <div class="flex gap-3 pt-3">
              <button @click="saveAddress" class="flex-1 rounded-xl bg-terracotta py-3.5 text-xs font-black uppercase tracking-widest text-white hover:bg-terracottaDark hover:shadow shadow-md shadow-terracotta/10 active:scale-[0.98] transition-all">Simpan & Gunakan</button>
              <button type="button" @click="showAddressForm = false" class="flex-1 rounded-xl border border-borderSoft bg-surface py-3.5 text-xs font-black uppercase tracking-widest text-espresso hover:bg-slate-50 active:scale-[0.98] transition-all">Batal</button>
            </div>
          </div>

        </div>
      </div>
    </div>

  </div>
</template>

<script setup>
import { ref, reactive, computed, onMounted } from 'vue';
import { useRouter, useRoute } from 'vue-router';
import { useCartStore } from '@/stores/cartStore';
import { useNotificationStore } from '@/stores/notificationStore';

const router = useRouter();
const route = useRoute();
const cartStore = useCartStore();
const notificationStore = useNotificationStore();

const isProcessingPayment = ref(false);
const showAddressModal = ref(false);
const showAddressForm = ref(false);

const apiHeaders = () => {
  const token = localStorage.getItem('token');
  const headers = {
    Accept: 'application/json',
    'Content-Type': 'application/json',
  };
  if (token) headers.Authorization = `Bearer ${token}`;
  return headers;
};

const source = ref(route.query.source || 'cart');
const addresses = ref([]);
const addressError = ref('');
const selectedAddressId = ref(null);

const addressForm = reactive({
  name: '',
  phone: '',
  address: '',
  city: '',
  postal_code: '',
});

const couriers = [
  { id: 'jne', label: 'JNE Express' },
  { id: 'jnt', label: 'J&T Express' },
  { id: 'sicepat', label: 'SiCepat Ekspres' },
];
const selectedCourier = ref('jne');
const selectedService = ref('REG');
const shippingCost = ref(0);
const shippingEstimate = ref('2-4 hari');

const serviceOptions = computed(() => {
  const courierRates = {
    jne: { REG: 15000, YES: 25000, OKE: 12000 },
    jnt: { REG: 14000, YES: 23000, OKE: 11000 },
    sicepat: { REG: 13000, YES: 22000, OKE: 10000 },
  };

  const duration = {
    REG: '2-4 hari',
    YES: '1-2 hari',
    OKE: '3-5 hari',
  };

  const serviceNames = {
    REG: 'Layanan Reguler',
    YES: 'Layanan Kilat (Express)',
    OKE: 'Layanan Hemat (Ekonomi)',
  };

  return ['REG', 'YES', 'OKE'].map(key => ({
    id: key,
    name: serviceNames[key],
    duration: duration[key],
    cost: courierRates[selectedCourier.value]?.[key] ?? 0
  }));
});

const selectServiceOption = (serviceId) => {
  selectedService.value = serviceId;
  calculateShipping();
};

const selectedItems = computed(() => {
  if (source.value === 'buy-now') {
    const buyNowItem = JSON.parse(sessionStorage.getItem('buy_now_item') ?? 'null');
    return buyNowItem ? [buyNowItem] : [];
  }
  return cartStore.selectedItems.length ? cartStore.selectedItems : cartStore.items;
});

const subtotal = computed(() => {
  return selectedItems.value.reduce((total, item) => total + (item.price || 0) * (item.quantity || 1), 0);
});

const totalPrice = computed(() => subtotal.value + shippingCost.value);

const selectedAddress = computed(() => {
  return addresses.value.find(address => address.id === selectedAddressId.value) || null;
});

const formatCurrency = (value) => {
  return new Intl.NumberFormat('id-ID', {
    style: 'currency',
    currency: 'IDR',
    minimumFractionDigits: 0,
  }).format(value);
};

const loadAddresses = () => {
  try {
    const saved = JSON.parse(localStorage.getItem('snapfit_addresses') || '[]');
    addresses.value = saved;
    if (!selectedAddressId.value && saved.length) {
      selectedAddressId.value = saved[0].id;
    }
  } catch {
    addresses.value = [];
  }
};

const saveAddresses = () => {
  localStorage.setItem('snapfit_addresses', JSON.stringify(addresses.value));
};

const resetAddressForm = () => {
  addressForm.name = '';
  addressForm.phone = '';
  addressForm.address = '';
  addressForm.city = '';
  addressForm.postal_code = '';
  addressError.value = '';
  showAddressForm.value = false;
};

const createAddressId = () => {
  return `address-${Date.now()}`;
};

const saveAddress = () => {
  addressError.value = '';

  if (!addressForm.name || !addressForm.phone || !addressForm.address || !addressForm.city || !addressForm.postal_code) {
    addressError.value = 'Lengkapi semua informasi alamat terlebih dahulu.';
    return;
  }

  const newAddress = {
    id: createAddressId(),
    ...addressForm,
  };

  addresses.value.push(newAddress);
  selectedAddressId.value = newAddress.id;
  saveAddresses();
  resetAddressForm();
  showAddressForm.value = false;
};

const selectAddress = (addressId) => {
  selectedAddressId.value = addressId;
  showAddressModal.value = false;
};

const openAddressModal = () => {
  showAddressModal.value = true;
  showAddressForm.value = false;
};

const closeAddressModal = () => {
  showAddressModal.value = false;
};

const deleteAddress = (addressId) => {
  addresses.value = addresses.value.filter(a => a.id !== addressId);
  saveAddresses();
  if (selectedAddressId.value === addressId) {
    selectedAddressId.value = addresses.value.length ? addresses.value[0].id : null;
  }
};

const selectCourierType = (courierId) => {
  selectedCourier.value = courierId;
  calculateShipping();
};

const calculateShipping = () => {
  const courierRates = {
    jne: { REG: 15000, YES: 25000, OKE: 12000 },
    jnt: { REG: 14000, YES: 23000, OKE: 11000 },
    sicepat: { REG: 13000, YES: 22000, OKE: 10000 },
  };

  const duration = {
    REG: '2-4 hari',
    YES: '1-2 hari',
    OKE: '3-5 hari',
  };

  shippingCost.value = courierRates[selectedCourier.value]?.[selectedService.value] ?? 0;
  shippingEstimate.value = duration[selectedService.value] || '2-4 hari';
};

const goBack = () => {
  if (source.value === 'cart') {
    router.push('/cart');
  } else {
    router.go(-1);
  }
};

const payNow = async () => {
  if (!selectedAddress.value) {
    notificationStore.error('Pilih alamat pengiriman terlebih dahulu.');
    return;
  }
  if (!selectedCourier.value) {
    notificationStore.error('Pilih kurir terlebih dahulu.');
    return;
  }

  isProcessingPayment.value = true;
  notificationStore.info('Sedang memproses pesanan Anda...');

  try {
    // 1. Sync address and phone to user profile on the backend
    const profileRes = await fetch('/api/v1/profile', {
      method: 'PUT',
      headers: apiHeaders(),
      body: JSON.stringify({
        full_name: selectedAddress.value.name,
        phone: selectedAddress.value.phone,
        address: `${selectedAddress.value.address}, ${selectedAddress.value.city} ${selectedAddress.value.postal_code}`
      })
    });
    if (!profileRes.ok) {
      console.warn('Gagal sinkronisasi alamat ke profil backend');
    }

    // 2. Create the order
    const orderItemsPayload = selectedItems.value.map(item => ({
      product_id: item.product_id,
      quantity: item.quantity,
      variant: item.variant || null
    }));

    const orderRes = await fetch('/api/v1/orders', {
      method: 'POST',
      headers: apiHeaders(),
      body: JSON.stringify({
        items: orderItemsPayload,
        shipping_courier: selectedCourier.value
      })
    });

    if (!orderRes.ok) {
      const errorData = await orderRes.json();
      throw new Error(errorData.message || 'Gagal membuat pesanan di server.');
    }

    const orderData = await orderRes.json();
    const order = orderData.data;

    // 3. Request Midtrans Snap Token
    const snapRes = await fetch(`/api/v1/payment/orders/${order.id}/snap-token`, {
      method: 'POST',
      headers: apiHeaders(),
    });

    if (!snapRes.ok) {
      throw new Error('Gagal mendapatkan token pembayaran Midtrans.');
    }

    const snapData = await snapRes.json();
    const snapToken = snapData.snap_token;

    // 4. Trigger Midtrans Snap Payment Popup
    if (typeof window.snap?.pay === 'function') {
      window.snap.pay(snapToken, {
        onSuccess: async (result) => {
          notificationStore.success('Pembayaran berhasil dikonfirmasi! 🎉');
          if (source.value === 'cart') {
            await cartStore.removeSelectedItems();
          } else {
            sessionStorage.removeItem('buy_now_item');
          }
          router.push({ name: 'order.detail', params: { id: order.id } });
        },
        onPending: (result) => {
          notificationStore.info('Menunggu pembayaran Anda...');
          if (source.value === 'cart') {
            cartStore.removeSelectedItems();
          } else {
            sessionStorage.removeItem('buy_now_item');
          }
          router.push({ name: 'order.detail', params: { id: order.id } });
        },
        onError: (result) => {
          notificationStore.error('Pembayaran gagal dilakukan. Silakan coba lagi.');
        },
        onClose: () => {
          if (source.value === 'cart') {
            cartStore.removeSelectedItems();
          } else {
            sessionStorage.removeItem('buy_now_item');
          }
          router.push({ name: 'order.detail', params: { id: order.id } });
        }
      });
    } else {
      // Fallback: Redirect to Midtrans Redirect URL
      notificationStore.info('Membuka halaman pembayaran...');
      window.location.href = snapData.redirect_url;
    }
  } catch (err) {
    console.error('Checkout error:', err);
    notificationStore.error(err.message || 'Terjadi kesalahan saat memproses pembayaran.');
  } finally {
    isProcessingPayment.value = false;
  }
};

onMounted(async () => {
  loadAddresses();
  calculateShipping();

  if (source.value === 'buy-now') {
    let buyNowItem = JSON.parse(sessionStorage.getItem('buy_now_item') ?? 'null');
    if (!buyNowItem && route.query.product_id) {
      // Re-construct the buy-now item from redirect query
      try {
        const res = await fetch(`/api/v1/products/${route.query.product_id}`);
        if (res.ok) {
          const payload = await res.json();
          const p = payload.product ?? payload;
          buyNowItem = {
            id: p.id,
            product_id: p.id,
            name: p.name,
            image: (typeof p.images === 'string' ? JSON.parse(p.images) : p.images)?.[0] ?? '',
            variant: route.query.variant || null,
            quantity: parseInt(route.query.qty || '1'),
            price: p.price
          };
          sessionStorage.setItem('buy_now_item', JSON.stringify(buyNowItem));
        }
      } catch (err) {
        console.error('Failed to restore buy-now item:', err);
      }
    }
  } else {
    await cartStore.loadCart();
    if (!cartStore.items.length) {
      router.push('/');
    }
  }
});
</script>

<style scoped>
.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
.line-clamp-3 {
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

/* Animations */
@keyframes slideUp {
  from {
    transform: translateY(100%);
  }
  to {
    transform: translateY(0);
  }
}
@keyframes fadeIn {
  from {
    opacity: 0;
  }
  to {
    opacity: 1;
  }
}

.animate-slide-up {
  animation: slideUp 0.3s ease-out forwards;
}

@media (min-width: 640px) {
  .sm\:animate-fade-in {
    animation: fadeIn 0.25s ease-out forwards;
  }
}
</style>
