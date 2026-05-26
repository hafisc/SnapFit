<template>
  <div class="snapfit-heritage-bg min-h-screen font-sans">
    <Navbar :user="user" />

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8 pt-28">
      <!-- Header -->
      <div class="text-center mb-12 relative">
        <div class="absolute inset-0 flex justify-center -top-12 -z-10">
          <div class="w-72 h-72 bg-gradient-to-tr from-amber-200/20 to-terracotta/20 rounded-full blur-3xl"></div>
        </div>
        <div class="inline-flex items-center justify-center p-4 bg-white/80 border border-[#F2EADA] rounded-3xl shadow-sm mb-4 backdrop-blur-sm">
          <svg class="w-8 h-8 text-terracotta" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
        </div>
        <h1 class="text-3xl sm:text-4xl font-black text-[#2B1E16] tracking-tight">Daftar sebagai UMKM</h1>
        <p class="text-sm text-slate-500 mt-2.5 max-w-md mx-auto leading-relaxed">
          Tingkatkan skala bisnis kerajinan, batik, atau fashion lokal Anda dengan bergabung di ekosistem digital SnapFit.
        </p>
      </div>

      <!-- Visual Stepper Guide (User Friendly Tracker) -->
      <div v-if="!verificationResult && !isVerifying" class="hidden md:flex justify-between max-w-4xl mx-auto mb-10 bg-white/60 backdrop-blur-md border border-[#F2EADA] p-4 rounded-2xl shadow-sm">
        <div class="flex items-center gap-2.5 px-3">
          <div class="w-8 h-8 bg-terracotta text-white rounded-xl flex items-center justify-center font-bold text-sm shadow-md shadow-terracotta/20">1</div>
          <div>
            <p class="text-xs font-black text-[#2B1E16] leading-none">Informasi Toko</p>
            <p class="text-[9px] text-slate-400 mt-0.5">Identitas brand & lokasi</p>
          </div>
        </div>
        <div class="flex items-center text-slate-300"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg></div>
        <div class="flex items-center gap-2.5 px-3">
          <div class="w-8 h-8 bg-terracotta text-white rounded-xl flex items-center justify-center font-bold text-sm shadow-md shadow-terracotta/20">2</div>
          <div>
            <p class="text-xs font-black text-[#2B1E16] leading-none">Deskripsi Usaha</p>
            <p class="text-[9px] text-slate-400 mt-0.5">Filosofi & produk unik</p>
          </div>
        </div>
        <div class="flex items-center text-slate-300"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg></div>
        <div class="flex items-center gap-2.5 px-3">
          <div class="w-8 h-8 bg-terracotta text-white rounded-xl flex items-center justify-center font-bold text-sm shadow-md shadow-terracotta/20">3</div>
          <div>
            <p class="text-xs font-black text-[#2B1E16] leading-none">Dokumen & Media</p>
            <p class="text-[9px] text-slate-400 mt-0.5">Verifikasi foto & KTP</p>
          </div>
        </div>
        <div class="flex items-center text-slate-300"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg></div>
        <div class="flex items-center gap-2.5 px-3">
          <div class="w-8 h-8 bg-terracotta text-white rounded-xl flex items-center justify-center font-bold text-sm shadow-md shadow-terracotta/20">4</div>
          <div>
            <p class="text-xs font-black text-[#2B1E16] leading-none">Sosial Media</p>
            <p class="text-[9px] text-slate-400 mt-0.5">Integrasi akun opsional</p>
          </div>
        </div>
      </div>

      <!-- AI Verification Result -->
      <div v-if="verificationResult" class="mb-8 animate-fade-in max-w-3xl mx-auto">
        <div class="bg-white/95 backdrop-blur-md rounded-3xl p-8 border shadow-xl transition-all duration-300"
             :class="{
               'border-green-200 shadow-green-500/5': verificationResult.status === 'approved',
               'border-amber-200 shadow-amber-500/5': verificationResult.status === 'need_review',
               'border-red-200 shadow-red-500/5': verificationResult.status === 'rejected'
             }">
          
          <!-- Status Header -->
          <div class="flex items-center gap-4 mb-6">
            <div class="w-14 h-14 rounded-2xl flex items-center justify-center shadow-sm"
                 :class="{
                   'bg-green-55 bg-emerald-50 text-emerald-600': verificationResult.status === 'approved',
                   'bg-amber-50 text-amber-600': verificationResult.status === 'need_review',
                   'bg-red-50 text-red-600': verificationResult.status === 'rejected'
                 }">
              <svg v-if="verificationResult.status === 'approved'" class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
              <svg v-else-if="verificationResult.status === 'need_review'" class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
              <svg v-else class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
            </div>
            <div>
              <h3 class="text-lg font-black text-[#2B1E16]">
                {{ verificationResult.status === 'approved' ? 'Pengajuan Verifikasi Disetujui' : verificationResult.status === 'need_review' ? 'Perlu Melengkapi Berkas' : 'Pengajuan Belum Memenuhi Kriteria' }}
              </h3>
              <p class="text-xs text-slate-400 font-bold uppercase tracking-wider mt-0.5">Hasil Analisis AI SnapFit</p>
            </div>
          </div>

          <!-- Score Card -->
          <div class="mb-6 bg-slate-50/50 p-5 rounded-2xl border border-slate-100/80">
            <div class="flex justify-between items-end mb-2.5">
              <div>
                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest block">Metrik Penilaian</span>
                <span class="text-sm font-bold text-[#2B1E16] mt-0.5 block">Skor Kelayakan Usaha</span>
              </div>
              <span class="text-3xl font-black tracking-tight" :class="{
                'text-emerald-600': verificationResult.ai_score >= 75,
                'text-amber-600': verificationResult.ai_score >= 50 && verificationResult.ai_score < 75,
                'text-rose-600': verificationResult.ai_score < 50
              }">{{ verificationResult.ai_score }}<span class="text-xs text-slate-400 font-bold">/100</span></span>
            </div>
            <div class="w-full h-3 bg-slate-200/60 rounded-full overflow-hidden relative shadow-inner">
              <div class="h-full rounded-full transition-all duration-1000 ease-out shadow-sm"
                   :class="{
                     'bg-gradient-to-r from-emerald-400 to-emerald-500': verificationResult.ai_score >= 75,
                     'bg-gradient-to-r from-amber-400 to-amber-500': verificationResult.ai_score >= 50 && verificationResult.ai_score < 75,
                     'bg-gradient-to-r from-rose-400 to-rose-500': verificationResult.ai_score < 50
                   }"
                   :style="{ width: verificationResult.ai_score + '%' }"></div>
            </div>
          </div>

          <!-- Summary -->
          <div class="bg-[#FCFBF9] rounded-2xl p-5 border border-[#EBE3D5]/60 mb-6">
            <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 flex items-center gap-1.5">
              <svg class="w-4 h-4 text-terracotta" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
              Ulasan Penilai AI
            </h4>
            <p class="text-sm text-[#2B1E16] leading-relaxed italic">"{{ verificationResult.ai_summary }}"</p>
          </div>

          <!-- Issues -->
          <div v-if="verificationResult.ai_issues?.length" class="mb-5 bg-rose-50/50 p-5 rounded-2xl border border-rose-100/60">
            <h4 class="text-xs font-bold text-rose-600 uppercase tracking-wider mb-3 flex items-center gap-1.5">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
              Yang Perlu Diperbaiki
            </h4>
            <ul class="space-y-2">
              <li v-for="issue in verificationResult.ai_issues" :key="issue" class="flex items-start gap-2.5 text-xs text-rose-700 leading-normal">
                <span class="w-1.5 h-1.5 bg-rose-500 rounded-full mt-1.5 flex-shrink-0"></span>
                {{ issue }}
              </li>
            </ul>
          </div>

          <!-- Recommendations -->
          <div v-if="verificationResult.ai_recommendations?.length" class="mb-8 bg-blue-50/30 p-5 rounded-2xl border border-blue-100/60">
            <h4 class="text-xs font-bold text-blue-600 uppercase tracking-wider mb-3 flex items-center gap-1.5">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 01-2 2h0a2 2 0 01-2-2v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" /></svg>
              Rekomendasi Optimal
            </h4>
            <ul class="space-y-2">
              <li v-for="rec in verificationResult.ai_recommendations" :key="rec" class="flex items-start gap-2.5 text-xs text-blue-700 leading-normal">
                <span class="w-1.5 h-1.5 bg-blue-500 rounded-full mt-1.5 flex-shrink-0"></span>
                {{ rec }}
              </li>
            </ul>
          </div>

          <!-- Actions -->
          <div class="flex flex-col sm:flex-row gap-3">
            <button v-if="verificationResult.status === 'approved'" @click="router.push('/umkm/dashboard')" class="flex-1 bg-[#2B1E16] hover:bg-black text-white font-bold py-3.5 px-6 rounded-xl transition-all duration-300 hover:shadow-lg hover:shadow-[#2B1E16]/10 active:scale-[0.98]">
              Buka Dashboard UMKM
            </button>
            <button v-if="verificationResult.status === 'need_review'" @click="verificationResult = null" class="flex-1 bg-amber-500 hover:bg-amber-600 text-white font-bold py-3.5 px-6 rounded-xl transition-all duration-300 hover:shadow-lg hover:shadow-amber-500/10 active:scale-[0.98]">
              Perbaiki Berkas Data
            </button>
            <button v-if="verificationResult.status === 'rejected'" @click="verificationResult = null" class="flex-1 bg-red-500 hover:bg-red-600 text-white font-bold py-3.5 px-6 rounded-xl transition-all duration-300 hover:shadow-lg hover:shadow-red-500/10 active:scale-[0.98]">
              Ulangi Pengajuan
            </button>
            <button @click="router.push('/profile')" class="px-6 py-3.5 bg-slate-100 hover:bg-slate-200 text-[#2B1E16] font-bold rounded-xl transition-all">
              Kembali ke Profil
            </button>
          </div>
        </div>
      </div>

      <!-- AI Processing Animation -->
      <div v-else-if="isVerifying" class="bg-white/80 backdrop-blur-md rounded-3xl p-10 border border-[#F2EADA] shadow-xl text-center max-w-xl mx-auto animate-fade-in relative overflow-hidden">
        <!-- Progress Bar Indicator -->
        <div class="absolute inset-x-0 top-0 h-1 bg-gradient-to-r from-transparent via-terracotta to-transparent animate-pulse"></div>
        
        <div class="w-24 h-24 mx-auto mb-8 relative">
          <!-- Pulse rings -->
          <div class="absolute inset-0 bg-terracotta/10 rounded-full animate-ping"></div>
          <div class="absolute -inset-2 bg-orange-100/30 rounded-full animate-pulse"></div>
          <div class="absolute inset-0 border-4 border-slate-100 rounded-full"></div>
          <div class="absolute inset-0 border-4 border-t-terracotta rounded-full animate-spin"></div>
          <div class="absolute inset-3 bg-gradient-to-tr from-orange-50 to-amber-50 rounded-full flex items-center justify-center shadow-inner">
            <span class="text-3xl">🤖</span>
          </div>
        </div>
        
        <h3 class="text-2xl font-black text-[#2B1E16] mb-2 tracking-tight">AI Agent Verification</h3>
        <p class="text-xs text-slate-400 mb-8 max-w-xs mx-auto">Kami sedang menganalisis dokumen dan kelayakan usaha Anda secara real-time.</p>
        
        <div class="space-y-4 max-w-sm mx-auto bg-slate-50/80 rounded-2xl p-6 border border-slate-100 text-left">
          <!-- Step 1 -->
          <div class="flex items-center justify-between text-sm">
            <span class="text-slate-500 flex items-center gap-2">
              <span class="w-5 h-5 rounded-full flex items-center justify-center text-xs font-bold" :class="verifyStep >= 1 ? 'bg-green-100 text-green-600' : 'bg-slate-200 text-slate-500'">1</span>
              Menganalisis kelengkapan data
            </span>
            <span class="font-bold text-xs" :class="verifyStep >= 1 ? 'text-green-600' : 'text-slate-400 animate-pulse'">{{ verifyStep >= 1 ? 'Selesai' : 'Memproses...' }}</span>
          </div>
          <!-- Step 2 -->
          <div class="flex items-center justify-between text-sm border-t border-slate-100/60 pt-3">
            <span class="text-slate-500 flex items-center gap-2">
              <span class="w-5 h-5 rounded-full flex items-center justify-center text-xs font-bold" :class="verifyStep >= 2 ? 'bg-green-100 text-green-600' : 'bg-slate-200 text-slate-500'">2</span>
              Memeriksa kesesuaian kategori
            </span>
            <span class="font-bold text-xs" :class="verifyStep >= 2 ? 'text-green-600' : verifyStep === 1 ? 'text-terracotta animate-pulse' : 'text-slate-400'">{{ verifyStep >= 2 ? 'Selesai' : verifyStep === 1 ? 'Memproses...' : 'Menunggu' }}</span>
          </div>
          <!-- Step 3 -->
          <div class="flex items-center justify-between text-sm border-t border-slate-100/60 pt-3">
            <span class="text-slate-500 flex items-center gap-2">
              <span class="w-5 h-5 rounded-full flex items-center justify-center text-xs font-bold" :class="verifyStep >= 3 ? 'bg-green-100 text-green-600' : 'bg-slate-200 text-slate-500'">3</span>
              Mengevaluasi kredibilitas profil
            </span>
            <span class="font-bold text-xs" :class="verifyStep >= 3 ? 'text-green-600' : verifyStep === 2 ? 'text-terracotta animate-pulse' : 'text-slate-400'">{{ verifyStep >= 3 ? 'Selesai' : verifyStep === 2 ? 'Memproses...' : 'Menunggu' }}</span>
          </div>
          <!-- Step 4 -->
          <div class="flex items-center justify-between text-sm border-t border-slate-100/60 pt-3">
            <span class="text-slate-500 flex items-center gap-2">
              <span class="w-5 h-5 rounded-full flex items-center justify-center text-xs font-bold" :class="verifyStep >= 4 ? 'bg-green-100 text-green-600' : 'bg-slate-200 text-slate-500'">4</span>
              Menyimpan hasil verifikasi
            </span>
            <span class="font-bold text-xs" :class="verifyStep >= 4 ? 'text-green-600' : verifyStep === 3 ? 'text-terracotta animate-pulse' : 'text-slate-400'">{{ verifyStep >= 4 ? 'Selesai' : verifyStep === 3 ? 'Memproses...' : 'Menunggu' }}</span>
          </div>
        </div>
      </div>

      <!-- Registration Form -->
      <form v-else @submit.prevent="submitForm" class="bg-white/90 backdrop-blur-md rounded-3xl p-6 sm:p-10 border border-[#F2EADA] shadow-[0_24px_60px_rgba(43,30,22,0.06)]">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
        
          <!-- LEFT COLUMN -->
          <div class="space-y-8">
            <!-- Section: Informasi Toko -->
            <div>
              <h3 class="text-base font-black text-[#2B1E16] mb-5 flex items-center gap-3 pb-2.5 border-b border-[#F2EADA]">
                <span class="w-8 h-8 rounded-xl bg-orange-50 border border-orange-100 flex items-center justify-center text-xs font-black text-terracotta">1</span>
                Informasi Toko
              </h3>
              <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                  <label class="block text-[10px] font-bold text-slate-400 mb-1.5 uppercase tracking-wider">Nama Toko / Brand <span class="text-terracotta">*</span></label>
                  <input v-model="form.store_name" type="text" required placeholder="Contoh: Batik Nusantara" class="w-full bg-[#FCFBF9] border border-[#EBE3D5] rounded-xl px-4 py-3 text-sm text-[#2B1E16] placeholder-slate-400 focus:outline-none focus:bg-white focus:border-terracotta focus:ring-4 focus:ring-terracotta/10 transition-all duration-200" />
                </div>
                <div>
                  <label class="block text-[10px] font-bold text-slate-400 mb-1.5 uppercase tracking-wider">Nama Pemilik <span class="text-terracotta">*</span></label>
                  <input v-model="form.owner_name" type="text" required placeholder="Nama lengkap pemilik" class="w-full bg-[#FCFBF9] border border-[#EBE3D5] rounded-xl px-4 py-3 text-sm text-[#2B1E16] placeholder-slate-400 focus:outline-none focus:bg-white focus:border-terracotta focus:ring-4 focus:ring-terracotta/10 transition-all duration-200" />
                </div>
                <div>
                  <label class="block text-[10px] font-bold text-slate-400 mb-1.5 uppercase tracking-wider">Kategori Usaha <span class="text-terracotta">*</span></label>
                  <div class="relative">
                    <select v-model="form.category" required class="w-full bg-[#FCFBF9] border border-[#EBE3D5] rounded-xl px-4 py-3 text-sm text-[#2B1E16] focus:outline-none focus:bg-white focus:border-terracotta focus:ring-4 focus:ring-terracotta/10 transition-all duration-200 appearance-none">
                      <option value="">Pilih kategori</option>
                      <option value="Batik & Tenun">Batik & Tenun</option>
                      <option value="Kerajinan Tangan">Kerajinan Tangan</option>
                      <option value="Fashion Lokal">Fashion Lokal</option>
                      <option value="Aksesoris">Aksesoris</option>
                      <option value="Makanan & Minuman">Makanan & Minuman</option>
                      <option value="Dekorasi & Interior">Dekorasi & Interior</option>
                      <option value="Seni & Lukisan">Seni & Lukisan</option>
                      <option value="Produk Eco-Friendly">Produk Eco-Friendly</option>
                      <option value="Lainnya">Lainnya</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-400">
                      <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                    </div>
                  </div>
                </div>
                <div>
                  <label class="block text-[10px] font-bold text-slate-400 mb-1.5 uppercase tracking-wider">Asal Kota / Daerah <span class="text-terracotta">*</span></label>
                  <input v-model="form.origin_city" type="text" required placeholder="Contoh: Yogyakarta" class="w-full bg-[#FCFBF9] border border-[#EBE3D5] rounded-xl px-4 py-3 text-sm text-[#2B1E16] placeholder-slate-400 focus:outline-none focus:bg-white focus:border-terracotta focus:ring-4 focus:ring-terracotta/10 transition-all duration-200" />
                </div>
              </div>
              <div class="mt-4">
                <label class="block text-[10px] font-bold text-slate-400 mb-1.5 uppercase tracking-wider">Alamat Usaha <span class="text-terracotta">*</span></label>
                <input v-model="form.address" type="text" required placeholder="Alamat lengkap tempat usaha" class="w-full bg-[#FCFBF9] border border-[#EBE3D5] rounded-xl px-4 py-3 text-sm text-[#2B1E16] placeholder-slate-400 focus:outline-none focus:bg-white focus:border-terracotta focus:ring-4 focus:ring-terracotta/10 transition-all duration-200" />
              </div>
              <div class="mt-4">
                <label class="block text-[10px] font-bold text-slate-400 mb-1.5 uppercase tracking-wider">Nomor WhatsApp <span class="text-terracotta">*</span></label>
                <input v-model="form.whatsapp" type="text" required placeholder="08xxxxxxxxxx" class="w-full bg-[#FCFBF9] border border-[#EBE3D5] rounded-xl px-4 py-3 text-sm text-[#2B1E16] placeholder-slate-400 focus:outline-none focus:bg-white focus:border-terracotta focus:ring-4 focus:ring-terracotta/10 transition-all duration-200" />
              </div>
            </div>

            <!-- Section: Deskripsi Usaha -->
            <div>
              <h3 class="text-base font-black text-[#2B1E16] mb-5 flex items-center gap-3 pb-2.5 border-b border-[#F2EADA]">
                <span class="w-8 h-8 rounded-xl bg-orange-50 border border-orange-100 flex items-center justify-center text-xs font-black text-terracotta">2</span>
                Deskripsi Usaha
              </h3>
              <div class="space-y-4">
                <div>
                  <label class="block text-[10px] font-bold text-slate-400 mb-1.5 uppercase tracking-wider">Deskripsi Usaha <span class="text-terracotta">*</span></label>
                  <textarea v-model="form.description" required rows="4" placeholder="Ceritakan tentang usaha Anda, produk apa yang dijual, dan apa yang membuat produk Anda unik..." class="w-full bg-[#FCFBF9] border border-[#EBE3D5] rounded-xl px-4 py-3 text-sm text-[#2B1E16] placeholder-slate-400 focus:outline-none focus:bg-white focus:border-terracotta focus:ring-4 focus:ring-terracotta/10 transition-all duration-200 resize-none"></textarea>
                  <p class="text-[10px] text-slate-400 mt-1.5 italic">Minimal 50 karakter. Deskripsi detail sangat membantu mempercepat peninjauan verifikasi oleh AI.</p>
                </div>
                <div>
                  <label class="block text-[10px] font-bold text-slate-400 mb-1.5 uppercase tracking-wider">Cerita Brand (Opsional)</label>
                  <textarea v-model="form.brand_story" rows="3" placeholder="Bagaimana brand ini dimulai? Apa visi dan misi Anda?" class="w-full bg-[#FCFBF9] border border-[#EBE3D5] rounded-xl px-4 py-3 text-sm text-[#2B1E16] placeholder-slate-400 focus:outline-none focus:bg-white focus:border-terracotta focus:ring-4 focus:ring-terracotta/10 transition-all duration-200 resize-none"></textarea>
                </div>
              </div>
            </div>
          </div>

          <!-- RIGHT COLUMN -->
          <div class="space-y-8">
            <!-- Section: Dokumen & Media -->
            <div>
              <h3 class="text-base font-black text-[#2B1E16] mb-5 flex items-center gap-3 pb-2.5 border-b border-[#F2EADA]">
                <span class="w-8 h-8 rounded-xl bg-orange-50 border border-orange-100 flex items-center justify-center text-xs font-black text-terracotta">3</span>
                Dokumen & Media
              </h3>
              <div class="space-y-4">
                <!-- Logo Toko -->
                <div>
                  <label class="block text-[10px] font-bold text-slate-400 mb-1.5 uppercase tracking-wider">Logo Toko</label>
                  <input type="file" accept="image/*" @change="(e) => handleFileUpload(e, 'logo')" class="hidden" id="upload-logo" />
                  
                  <!-- File Uploading State -->
                  <div v-if="uploads.logo.uploading" class="flex flex-col items-center justify-center border border-[#EBE3D5] bg-[#FCFBF9] rounded-2xl p-6 text-center">
                    <span class="w-6 h-6 border-2 border-slate-200 border-t-terracotta rounded-full animate-spin"></span>
                    <p class="text-xs text-[#2B1E16] font-bold mt-2">Mengunggah logo...</p>
                  </div>

                  <!-- File Uploaded State -->
                  <div v-else-if="uploads.logo.url" class="relative overflow-hidden border border-[#EBE3D5] bg-[#FCFBF9] rounded-2xl p-4 flex items-center gap-4 animate-fade-in shadow-inner">
                    <div class="w-14 h-14 rounded-xl overflow-hidden bg-slate-200 border border-slate-100 flex-shrink-0">
                      <img :src="uploads.logo.url" class="w-full h-full object-cover" />
                    </div>
                    <div class="flex-1 min-w-0">
                      <p class="text-xs font-bold text-[#2B1E16] truncate">{{ uploads.logo.name }}</p>
                      <p class="text-[10px] text-green-600 font-semibold flex items-center gap-1 mt-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
                        Berhasil diunggah
                      </p>
                    </div>
                    <button type="button" @click="removeUpload('logo')" class="w-8 h-8 rounded-lg bg-red-50 hover:bg-red-100 flex items-center justify-center text-red-500 hover:text-red-700 active:scale-95 transition-all" title="Hapus berkas">
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                    </button>
                  </div>

                  <!-- Empty State -->
                  <label v-else for="upload-logo" class="flex flex-col items-center justify-center border-2 border-dashed border-[#EBE3D5] hover:border-terracotta bg-[#FCFBF9] hover:bg-orange-50/20 rounded-2xl p-5 cursor-pointer transition-all duration-300 group text-center">
                    <div class="w-10 h-10 rounded-full bg-orange-50/60 flex items-center justify-center text-terracotta group-hover:scale-110 transition duration-300 mb-2">
                      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                    </div>
                    <p class="text-xs font-bold text-[#2B1E16] group-hover:text-terracotta transition-colors">Pilih Logo Toko</p>
                    <p class="text-[9px] text-slate-400 mt-0.5">Format: JPG, PNG, WebP (maks 5MB)</p>
                  </label>
                </div>

                <!-- Foto Produk -->
                <div>
                  <label class="block text-[10px] font-bold text-slate-400 mb-1.5 uppercase tracking-wider">Foto Produk Contoh</label>
                  <input type="file" accept="image/*" @change="(e) => handleFileUpload(e, 'product_sample')" class="hidden" id="upload-product" />
                  
                  <!-- File Uploading State -->
                  <div v-if="uploads.product_sample.uploading" class="flex flex-col items-center justify-center border border-[#EBE3D5] bg-[#FCFBF9] rounded-2xl p-6 text-center">
                    <span class="w-6 h-6 border-2 border-slate-200 border-t-terracotta rounded-full animate-spin"></span>
                    <p class="text-xs text-[#2B1E16] font-bold mt-2">Mengunggah foto produk...</p>
                  </div>

                  <!-- File Uploaded State -->
                  <div v-else-if="uploads.product_sample.url" class="relative overflow-hidden border border-[#EBE3D5] bg-[#FCFBF9] rounded-2xl p-4 flex items-center gap-4 animate-fade-in shadow-inner">
                    <div class="w-14 h-14 rounded-xl overflow-hidden bg-slate-200 border border-slate-100 flex-shrink-0">
                      <img :src="uploads.product_sample.url" class="w-full h-full object-cover" />
                    </div>
                    <div class="flex-1 min-w-0">
                      <p class="text-xs font-bold text-[#2B1E16] truncate">{{ uploads.product_sample.name }}</p>
                      <p class="text-[10px] text-green-600 font-semibold flex items-center gap-1 mt-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
                        Berhasil diunggah
                      </p>
                    </div>
                    <button type="button" @click="removeUpload('product_sample')" class="w-8 h-8 rounded-lg bg-red-50 hover:bg-red-100 flex items-center justify-center text-red-500 hover:text-red-700 active:scale-95 transition-all" title="Hapus berkas">
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                    </button>
                  </div>

                  <!-- Empty State -->
                  <label v-else for="upload-product" class="flex flex-col items-center justify-center border-2 border-dashed border-[#EBE3D5] hover:border-terracotta bg-[#FCFBF9] hover:bg-orange-50/20 rounded-2xl p-5 cursor-pointer transition-all duration-300 group text-center">
                    <div class="w-10 h-10 rounded-full bg-orange-50/60 flex items-center justify-center text-terracotta group-hover:scale-110 transition duration-300 mb-2">
                      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                    </div>
                    <p class="text-xs font-bold text-[#2B1E16] group-hover:text-terracotta transition-colors">Pilih Foto Produk Contoh</p>
                    <p class="text-[9px] text-slate-400 mt-0.5">Format: JPG, PNG, WebP (maks 5MB)</p>
                  </label>
                </div>

                <!-- Dokumen KTP -->
                <div>
                  <label class="block text-[10px] font-bold text-slate-400 mb-1.5 uppercase tracking-wider">Dokumen Usaha / KTP</label>
                  <input type="file" accept="image/*,.pdf" @change="(e) => handleFileUpload(e, 'identity_document')" class="hidden" id="upload-doc" />
                  
                  <!-- File Uploading State -->
                  <div v-if="uploads.identity_document.uploading" class="flex flex-col items-center justify-center border border-[#EBE3D5] bg-[#FCFBF9] rounded-2xl p-6 text-center">
                    <span class="w-6 h-6 border-2 border-slate-200 border-t-terracotta rounded-full animate-spin"></span>
                    <p class="text-xs text-[#2B1E16] font-bold mt-2">Mengunggah dokumen usaha...</p>
                  </div>

                  <!-- File Uploaded State -->
                  <div v-else-if="uploads.identity_document.url" class="relative overflow-hidden border border-[#EBE3D5] bg-[#FCFBF9] rounded-2xl p-4 flex items-center gap-4 animate-fade-in shadow-inner">
                    <div class="w-14 h-14 rounded-xl bg-orange-50 flex items-center justify-center text-terracotta flex-shrink-0">
                      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                    </div>
                    <div class="flex-1 min-w-0">
                      <p class="text-xs font-bold text-[#2B1E16] truncate">{{ uploads.identity_document.name }}</p>
                      <p class="text-[10px] text-green-600 font-semibold flex items-center gap-1 mt-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
                        Berhasil diunggah
                      </p>
                    </div>
                    <button type="button" @click="removeUpload('identity_document')" class="w-8 h-8 rounded-lg bg-red-50 hover:bg-red-100 flex items-center justify-center text-red-500 hover:text-red-700 active:scale-95 transition-all" title="Hapus berkas">
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                    </button>
                  </div>

                  <!-- Empty State -->
                  <label v-else for="upload-doc" class="flex flex-col items-center justify-center border-2 border-dashed border-[#EBE3D5] hover:border-terracotta bg-[#FCFBF9] hover:bg-orange-50/20 rounded-2xl p-5 cursor-pointer transition-all duration-300 group text-center">
                    <div class="w-10 h-10 rounded-full bg-orange-50/60 flex items-center justify-center text-terracotta group-hover:scale-110 transition duration-300 mb-2">
                      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                    </div>
                    <p class="text-xs font-bold text-[#2B1E16] group-hover:text-terracotta transition-colors">Pilih Dokumen KTP</p>
                    <p class="text-[9px] text-slate-400 mt-0.5">Format: JPG, PNG, PDF (maks 5MB)</p>
                  </label>
                </div>

                <!-- NIK -->
                <div>
                  <label class="block text-[10px] font-bold text-slate-400 mb-1.5 uppercase tracking-wider">NIK / Nomor Identitas</label>
                  <input v-model="form.identity_number" type="text" placeholder="16 digit NIK" maxlength="16" class="w-full bg-[#FCFBF9] border border-[#EBE3D5] rounded-xl px-4 py-3 text-sm text-[#2B1E16] placeholder-slate-400 focus:outline-none focus:bg-white focus:border-terracotta focus:ring-4 focus:ring-terracotta/10 transition-all duration-200" />
                </div>
              </div>
            </div>

            <!-- Section: Sosial Media -->
            <div>
              <h3 class="text-base font-black text-[#2B1E16] mb-5 flex items-center gap-3 pb-2.5 border-b border-[#F2EADA]">
                <span class="w-8 h-8 rounded-xl bg-orange-50 border border-orange-100 flex items-center justify-center text-xs font-black text-terracotta">4</span>
                Sosial Media (Opsional)
              </h3>
              <div class="space-y-4">
                <div>
                  <label class="block text-[10px] font-bold text-slate-400 mb-1.5 uppercase tracking-wider">Instagram</label>
                  <div class="relative flex items-center">
                    <span class="absolute left-4 text-sm font-bold text-[#2B1E16]/60">@</span>
                    <input v-model="form.instagram" type="text" placeholder="username" class="w-full bg-[#FCFBF9] border border-[#EBE3D5] rounded-xl pl-9 pr-4 py-3 text-sm text-[#2B1E16] placeholder-slate-400 focus:outline-none focus:bg-white focus:border-terracotta focus:ring-4 focus:ring-terracotta/10 transition-all duration-200" />
                  </div>
                </div>
                <div>
                  <label class="block text-[10px] font-bold text-slate-400 mb-1.5 uppercase tracking-wider">Website</label>
                  <input v-model="form.website" type="text" placeholder="https://..." class="w-full bg-[#FCFBF9] border border-[#EBE3D5] rounded-xl px-4 py-3 text-sm text-[#2B1E16] placeholder-slate-400 focus:outline-none focus:bg-white focus:border-terracotta focus:ring-4 focus:ring-terracotta/10 transition-all duration-200" />
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Submit Buttons -->
        <div class="pt-6 mt-8 border-t border-[#F2EADA] flex flex-col sm:flex-row gap-3 justify-between items-center">
          <button type="button" @click="router.push('/profile')" class="w-full sm:w-auto px-6 py-3.5 bg-slate-100 hover:bg-slate-200 text-[#2B1E16] font-bold rounded-xl transition-all duration-200 text-sm order-2 sm:order-1 flex items-center justify-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            Kembali
          </button>
          <button type="submit" :disabled="isVerifying" class="w-full sm:w-auto min-w-[200px] bg-[#2B1E16] hover:bg-terracotta text-white font-bold py-3.5 px-8 rounded-xl transition-all duration-300 shadow-md shadow-slate-900/5 hover:shadow-lg hover:shadow-terracotta/10 active:scale-[0.98] disabled:opacity-50 disabled:cursor-not-allowed text-sm order-1 sm:order-2">
            Kirim & Verifikasi Data
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import Navbar from '@/pages/landing/partials/Navbar.vue';

const router = useRouter();
const token = localStorage.getItem('token');
const user = ref(JSON.parse(localStorage.getItem('user') || 'null'));

const form = ref({
  store_name: '',
  owner_name: '',
  category: '',
  origin_city: '',
  address: '',
  whatsapp: '',
  description: '',
  brand_story: '',
  logo_url: '',
  sample_product_image: '',
  identity_number: '',
  identity_document_url: '',
  instagram: '',
  website: '',
});

const uploads = ref({
  logo: { url: '', name: '', uploading: false },
  product_sample: { url: '', name: '', uploading: false },
  identity_document: { url: '', name: '', uploading: false },
});

const isVerifying = ref(false);
const verifyStep = ref(0);
const verificationResult = ref(null);

const removeUpload = (type) => {
  uploads.value[type] = { url: '', name: '', uploading: false };
  if (type === 'logo') form.value.logo_url = '';
  if (type === 'product_sample') form.value.sample_product_image = '';
  if (type === 'identity_document') form.value.identity_document_url = '';
};

const handleFileUpload = async (event, type) => {
  const file = event.target.files[0];
  if (!file) return;

  uploads.value[type].uploading = true;
  uploads.value[type].name = file.name;

  const formData = new FormData();
  formData.append('file', file);
  formData.append('type', type);

  try {
    const res = await fetch('/api/v1/upload/role-document', {
      method: 'POST',
      headers: {
        'Authorization': `Bearer ${token}`,
        'Accept': 'application/json',
      },
      body: formData,
    });

    if (res.ok) {
      const data = await res.json();
      uploads.value[type].url = data.url;

      // Map to form fields
      if (type === 'logo') form.value.logo_url = data.url;
      if (type === 'product_sample') form.value.sample_product_image = data.url;
      if (type === 'identity_document') form.value.identity_document_url = data.url;
    } else {
      uploads.value[type].name = 'Gagal upload, coba lagi';
    }
  } catch (e) {
    console.error('Upload error', e);
    uploads.value[type].name = 'Error, coba lagi';
  } finally {
    uploads.value[type].uploading = false;
  }
};

const submitForm = async () => {
  if (!token) return router.push('/login');

  isVerifying.value = true;
  verifyStep.value = 0;

  // Animate verification steps
  const stepInterval = setInterval(() => {
    if (verifyStep.value < 4) {
      verifyStep.value++;
    }
  }, 1200);

  try {
    const res = await fetch('/api/v1/role-applications/umkm', {
      method: 'POST',
      headers: {
        'Authorization': `Bearer ${token}`,
        'Content-Type': 'application/json',
        'Accept': 'application/json',
      },
      body: JSON.stringify(form.value),
    });

    clearInterval(stepInterval);
    verifyStep.value = 4;

    // Small delay to show final step
    await new Promise(r => setTimeout(r, 800));

    const data = await res.json();

    if (res.ok) {
      verificationResult.value = data.application;
    } else {
      alert(data.message || 'Terjadi kesalahan saat mengirim data.');
    }
  } catch (err) {
    clearInterval(stepInterval);
    console.error('Submit error', err);
    alert('Terjadi kesalahan jaringan.');
  } finally {
    isVerifying.value = false;
  }
};

// Check if user already has a pending application
onMounted(async () => {
  if (!token) return router.push('/login');

  try {
    const res = await fetch('/api/v1/role-applications/status/umkm', {
      headers: { 'Authorization': `Bearer ${token}`, 'Accept': 'application/json' },
    });
    if (res.ok) {
      const data = await res.json();
      if (data.application && ['approved', 'need_review', 'rejected'].includes(data.application.status)) {
        verificationResult.value = data.application;
      }
    }
  } catch (e) {
    console.error('Failed to check status', e);
  }
});
</script>
