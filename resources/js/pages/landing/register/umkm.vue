<template>
  <div class="snapfit-heritage-bg min-h-screen font-sans">
    <Navbar :user="user" />

    <div class="max-w-6xl mx-auto px-4 sm:px-6 py-8 pt-28">
      <!-- Header -->
      <div class="text-center mb-10">
        <div class="w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4">
          <span class="text-3xl">🏪</span>
        </div>
        <h1 class="text-3xl font-black text-espresso">Daftar sebagai UMKM</h1>
        <p class="text-muted mt-2 max-w-md mx-auto">Bergabunglah dengan ribuan UMKM kreatif Indonesia di SnapFit.</p>
      </div>

      <!-- AI Verification Result (shown after submit) -->
      <div v-if="verificationResult" class="mb-8 animate-fade-in">
        <div class="bg-surface rounded-3xl p-8 border shadow-lg"
             :class="{
               'border-green-200 shadow-green-500/10': verificationResult.status === 'approved',
               'border-amber-200 shadow-amber-500/10': verificationResult.status === 'need_review',
               'border-red-200 shadow-red-500/10': verificationResult.status === 'rejected'
             }">
          
          <!-- Status Header -->
          <div class="flex items-center gap-4 mb-6">
            <div class="w-14 h-14 rounded-full flex items-center justify-center"
                 :class="{
                   'bg-green-100 text-green-600': verificationResult.status === 'approved',
                   'bg-amber-100 text-amber-600': verificationResult.status === 'need_review',
                   'bg-red-100 text-red-600': verificationResult.status === 'rejected'
                 }">
              <svg v-if="verificationResult.status === 'approved'" class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
              <svg v-else-if="verificationResult.status === 'need_review'" class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
              <svg v-else class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
            </div>
            <div>
              <h3 class="text-lg font-black text-espresso">
                {{ verificationResult.status === 'approved' ? 'Verifikasi Berhasil!' : verificationResult.status === 'need_review' ? 'Perlu Dilengkapi' : 'Pengajuan Ditolak' }}
              </h3>
              <p class="text-sm text-muted">Verifikasi</p>
            </div>
          </div>

          <!-- Score Bar -->
          <div class="mb-6">
            <div class="flex justify-between items-center mb-2">
              <span class="text-xs font-bold text-muted uppercase tracking-wider">Skor Kelayakan</span>
              <span class="text-lg font-black" :class="{
                'text-green-600': verificationResult.ai_score >= 75,
                'text-amber-600': verificationResult.ai_score >= 50 && verificationResult.ai_score < 75,
                'text-red-600': verificationResult.ai_score < 50
              }">{{ verificationResult.ai_score }}/100</span>
            </div>
            <div class="w-full h-3 bg-slate-100 rounded-full overflow-hidden">
              <div class="h-full rounded-full transition-all duration-1000 ease-out"
                   :class="{
                     'bg-green-500': verificationResult.ai_score >= 75,
                     'bg-amber-500': verificationResult.ai_score >= 50 && verificationResult.ai_score < 75,
                     'bg-red-500': verificationResult.ai_score < 50
                   }"
                   :style="{ width: verificationResult.ai_score + '%' }"></div>
            </div>
          </div>

          <!-- Summary -->
          <div class="bg-slate-50 rounded-2xl p-4 mb-4">
            <p class="text-sm text-espresso leading-relaxed">{{ verificationResult.ai_summary }}</p>
          </div>

          <!-- Issues -->
          <div v-if="verificationResult.ai_issues?.length" class="mb-4">
            <h4 class="text-xs font-bold text-red-600 uppercase tracking-wider mb-2">Yang Perlu Diperbaiki</h4>
            <ul class="space-y-1.5">
              <li v-for="issue in verificationResult.ai_issues" :key="issue" class="flex items-start gap-2 text-sm text-red-700">
                <svg class="w-4 h-4 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01" /></svg>
                {{ issue }}
              </li>
            </ul>
          </div>

          <!-- Recommendations -->
          <div v-if="verificationResult.ai_recommendations?.length" class="mb-6">
            <h4 class="text-xs font-bold text-blue-600 uppercase tracking-wider mb-2">Rekomendasi</h4>
            <ul class="space-y-1.5">
              <li v-for="rec in verificationResult.ai_recommendations" :key="rec" class="flex items-start gap-2 text-sm text-blue-700">
                <svg class="w-4 h-4 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                {{ rec }}
              </li>
            </ul>
          </div>

          <!-- Actions -->
          <div class="flex gap-3">
            <button v-if="verificationResult.status === 'approved'" @click="router.push('/umkm/dashboard')" class="flex-1 bg-green-600 hover:bg-green-700 text-white font-bold py-3.5 px-6 rounded-xl transition-colors shadow-lg shadow-green-500/20">
              Buka Dashboard UMKM
            </button>
            <button v-if="verificationResult.status === 'need_review'" @click="verificationResult = null" class="flex-1 bg-amber-500 hover:bg-amber-600 text-white font-bold py-3.5 px-6 rounded-xl transition-colors shadow-lg shadow-amber-500/20">
              Perbaiki Data
            </button>
            <button v-if="verificationResult.status === 'rejected'" @click="verificationResult = null" class="flex-1 bg-red-500 hover:bg-red-600 text-white font-bold py-3.5 px-6 rounded-xl transition-colors shadow-lg shadow-red-500/20">
              Coba Lagi
            </button>
            <button @click="router.push('/profile')" class="px-6 py-3.5 bg-slate-100 hover:bg-slate-200 text-espresso font-bold rounded-xl transition-colors">
              Kembali
            </button>
          </div>
        </div>
      </div>

      <!-- AI Processing Animation -->
      <div v-else-if="isVerifying" class="bg-surface rounded-3xl p-10 border border-borderSoft shadow-lg text-center animate-fade-in">
        <div class="w-20 h-20 mx-auto mb-6 relative">
          <div class="absolute inset-0 border-4 border-slate-200 rounded-full"></div>
          <div class="absolute inset-0 border-4 border-t-terracotta rounded-full animate-spin"></div>
          <div class="absolute inset-3 bg-orange-50 rounded-full flex items-center justify-center">
            <span class="text-2xl">🤖</span>
          </div>
        </div>
        <h3 class="text-xl font-black text-espresso mb-3">AI Sedang Memverifikasi</h3>
        <div class="space-y-2 max-w-sm mx-auto">
          <p class="text-sm text-muted animate-pulse" :class="{ 'text-green-600 font-semibold': verifyStep >= 1 }">
            {{ verifyStep >= 1 ? '✓' : '⏳' }} Menganalisis kelengkapan data...
          </p>
          <p class="text-sm text-muted" :class="{ 'animate-pulse': verifyStep === 1, 'text-green-600 font-semibold': verifyStep >= 2 }">
            {{ verifyStep >= 2 ? '✓' : '⏳' }} Memeriksa kesesuaian kategori...
          </p>
          <p class="text-sm text-muted" :class="{ 'animate-pulse': verifyStep === 2, 'text-green-600 font-semibold': verifyStep >= 3 }">
            {{ verifyStep >= 3 ? '✓' : '⏳' }} Mengevaluasi kredibilitas profil...
          </p>
          <p class="text-sm text-muted" :class="{ 'animate-pulse': verifyStep === 3, 'text-green-600 font-semibold': verifyStep >= 4 }">
            {{ verifyStep >= 4 ? '✓' : '⏳' }} Menyimpan hasil verifikasi...
          </p>
        </div>
      </div>

      <!-- Registration Form -->
      <form v-else @submit.prevent="submitForm" class="bg-surface rounded-3xl p-6 sm:p-10 border border-borderSoft shadow-sm">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
          <!-- LEFT COLUMN -->
          <div class="space-y-6">
            <!-- Section: Informasi Toko -->
            <div>
              <h3 class="text-lg font-bold text-espresso mb-4 flex items-center gap-2">
                <span class="w-7 h-7 bg-orange-100 rounded-full flex items-center justify-center text-xs font-black text-terracotta">1</span>
                Informasi Toko
              </h3>
              <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                  <label class="block text-xs font-bold text-slate-500 mb-1.5 uppercase tracking-wider">Nama Toko / Brand *</label>
                  <input v-model="form.store_name" type="text" required placeholder="Contoh: Batik Nusantara" class="w-full bg-slate-50 border border-borderSoft rounded-xl px-4 py-3 text-sm text-espresso focus:outline-none focus:border-terracotta focus:ring-2 focus:ring-terracotta/20 transition-all" />
                </div>
                <div>
                  <label class="block text-xs font-bold text-slate-500 mb-1.5 uppercase tracking-wider">Nama Pemilik *</label>
                  <input v-model="form.owner_name" type="text" required placeholder="Nama lengkap pemilik" class="w-full bg-slate-50 border border-borderSoft rounded-xl px-4 py-3 text-sm text-espresso focus:outline-none focus:border-terracotta focus:ring-2 focus:ring-terracotta/20 transition-all" />
                </div>
                <div>
                  <label class="block text-xs font-bold text-slate-500 mb-1.5 uppercase tracking-wider">Kategori Usaha *</label>
                  <select v-model="form.category" required class="w-full bg-slate-50 border border-borderSoft rounded-xl px-4 py-3 text-sm text-espresso focus:outline-none focus:border-terracotta focus:ring-2 focus:ring-terracotta/20 transition-all">
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
                </div>
                <div>
                  <label class="block text-xs font-bold text-slate-500 mb-1.5 uppercase tracking-wider">Asal Kota / Daerah *</label>
                  <input v-model="form.origin_city" type="text" required placeholder="Contoh: Yogyakarta" class="w-full bg-slate-50 border border-borderSoft rounded-xl px-4 py-3 text-sm text-espresso focus:outline-none focus:border-terracotta focus:ring-2 focus:ring-terracotta/20 transition-all" />
                </div>
              </div>
              <div class="mt-4">
                <label class="block text-xs font-bold text-slate-500 mb-1.5 uppercase tracking-wider">Alamat Usaha *</label>
                <input v-model="form.address" type="text" required placeholder="Alamat lengkap tempat usaha" class="w-full bg-slate-50 border border-borderSoft rounded-xl px-4 py-3 text-sm text-espresso focus:outline-none focus:border-terracotta focus:ring-2 focus:ring-terracotta/20 transition-all" />
              </div>
              <div class="mt-4">
                <label class="block text-xs font-bold text-slate-500 mb-1.5 uppercase tracking-wider">Nomor WhatsApp *</label>
                <input v-model="form.whatsapp" type="text" required placeholder="08xxxxxxxxxx" class="w-full bg-slate-50 border border-borderSoft rounded-xl px-4 py-3 text-sm text-espresso focus:outline-none focus:border-terracotta focus:ring-2 focus:ring-terracotta/20 transition-all" />
              </div>
            </div>

            <!-- Section: Deskripsi Usaha -->
            <div>
              <h3 class="text-lg font-bold text-espresso mb-4 flex items-center gap-2">
                <span class="w-7 h-7 bg-orange-100 rounded-full flex items-center justify-center text-xs font-black text-terracotta">2</span>
                Deskripsi Usaha
              </h3>
              <div class="space-y-4">
                <div>
                  <label class="block text-xs font-bold text-slate-500 mb-1.5 uppercase tracking-wider">Deskripsi Usaha *</label>
                  <textarea v-model="form.description" required rows="4" placeholder="Ceritakan tentang usaha Anda, produk apa yang dijual, dan apa yang membuat produk Anda unik..." class="w-full bg-slate-50 border border-borderSoft rounded-xl px-4 py-3 text-sm text-espresso focus:outline-none focus:border-terracotta focus:ring-2 focus:ring-terracotta/20 transition-all resize-none"></textarea>
                  <p class="text-xs text-muted mt-1">Minimal 50 karakter. Semakin detail, skor AI semakin tinggi.</p>
                </div>
                <div>
                  <label class="block text-xs font-bold text-slate-500 mb-1.5 uppercase tracking-wider">Cerita Brand (Opsional)</label>
                  <textarea v-model="form.brand_story" rows="3" placeholder="Bagaimana brand ini dimulai? Apa visi dan misi Anda?" class="w-full bg-slate-50 border border-borderSoft rounded-xl px-4 py-3 text-sm text-espresso focus:outline-none focus:border-terracotta focus:ring-2 focus:ring-terracotta/20 transition-all resize-none"></textarea>
                </div>
              </div>
            </div>
          </div>

          <!-- RIGHT COLUMN -->
          <div class="space-y-6">
            <!-- Section: Dokumen & Media -->
            <div>
              <h3 class="text-lg font-bold text-espresso mb-4 flex items-center gap-2">
                <span class="w-7 h-7 bg-orange-100 rounded-full flex items-center justify-center text-xs font-black text-terracotta">3</span>
                Dokumen & Media
              </h3>
              <div class="space-y-4">
                <!-- Logo Toko -->
                <div>
                  <label class="block text-xs font-bold text-slate-500 mb-1.5 uppercase tracking-wider">Logo Toko</label>
                  <input type="file" accept="image/*" @change="(e) => handleFileUpload(e, 'logo')" class="hidden" id="upload-logo" />
                  <label for="upload-logo" class="flex items-center gap-3 w-full bg-slate-50 border-2 border-dashed border-borderSoft rounded-xl px-4 py-3 cursor-pointer hover:border-terracotta hover:bg-orange-50/50 transition-all">
                    <div v-if="uploads.logo.url" class="w-10 h-10 rounded-lg overflow-hidden bg-slate-200 flex-shrink-0"><img :src="uploads.logo.url" class="w-full h-full object-cover" /></div>
                    <div v-else class="w-10 h-10 rounded-lg bg-slate-100 flex items-center justify-center flex-shrink-0"><svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg></div>
                    <div class="flex-1 min-w-0">
                      <p class="text-xs font-semibold text-espresso truncate">{{ uploads.logo.name || 'Pilih file gambar' }}</p>
                      <p class="text-[10px] text-muted">JPG, PNG, WebP (maks 5MB)</p>
                    </div>
                    <span v-if="uploads.logo.uploading" class="w-5 h-5 border-2 border-slate-200 border-t-terracotta rounded-full animate-spin flex-shrink-0"></span>
                    <svg v-else-if="uploads.logo.url" class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
                  </label>
                </div>

                <!-- Foto Produk -->
                <div>
                  <label class="block text-xs font-bold text-slate-500 mb-1.5 uppercase tracking-wider">Foto Produk Contoh</label>
                  <input type="file" accept="image/*" @change="(e) => handleFileUpload(e, 'product_sample')" class="hidden" id="upload-product" />
                  <label for="upload-product" class="flex items-center gap-3 w-full bg-slate-50 border-2 border-dashed border-borderSoft rounded-xl px-4 py-3 cursor-pointer hover:border-terracotta hover:bg-orange-50/50 transition-all">
                    <div v-if="uploads.product_sample.url" class="w-10 h-10 rounded-lg overflow-hidden bg-slate-200 flex-shrink-0"><img :src="uploads.product_sample.url" class="w-full h-full object-cover" /></div>
                    <div v-else class="w-10 h-10 rounded-lg bg-slate-100 flex items-center justify-center flex-shrink-0"><svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg></div>
                    <div class="flex-1 min-w-0">
                      <p class="text-xs font-semibold text-espresso truncate">{{ uploads.product_sample.name || 'Pilih file gambar' }}</p>
                      <p class="text-[10px] text-muted">JPG, PNG, WebP (maks 5MB)</p>
                    </div>
                    <span v-if="uploads.product_sample.uploading" class="w-5 h-5 border-2 border-slate-200 border-t-terracotta rounded-full animate-spin flex-shrink-0"></span>
                    <svg v-else-if="uploads.product_sample.url" class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
                  </label>
                </div>

                <!-- Dokumen KTP -->
                <div>
                  <label class="block text-xs font-bold text-slate-500 mb-1.5 uppercase tracking-wider">Dokumen Usaha / KTP</label>
                  <input type="file" accept="image/*,.pdf" @change="(e) => handleFileUpload(e, 'identity_document')" class="hidden" id="upload-doc" />
                  <label for="upload-doc" class="flex items-center gap-3 w-full bg-slate-50 border-2 border-dashed border-borderSoft rounded-xl px-4 py-3 cursor-pointer hover:border-terracotta hover:bg-orange-50/50 transition-all">
                    <div class="w-10 h-10 rounded-lg bg-slate-100 flex items-center justify-center flex-shrink-0">
                      <svg v-if="!uploads.identity_document.url" class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                      <svg v-else class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
                    </div>
                    <div class="flex-1 min-w-0">
                      <p class="text-xs font-semibold text-espresso truncate">{{ uploads.identity_document.name || 'Upload KTP / dokumen usaha' }}</p>
                      <p class="text-[10px] text-muted">JPG, PNG, PDF (maks 5MB)</p>
                    </div>
                    <span v-if="uploads.identity_document.uploading" class="w-5 h-5 border-2 border-slate-200 border-t-terracotta rounded-full animate-spin flex-shrink-0"></span>
                  </label>
                </div>

                <!-- NIK -->
                <div>
                  <label class="block text-xs font-bold text-slate-500 mb-1.5 uppercase tracking-wider">NIK / Nomor Identitas</label>
                  <input v-model="form.identity_number" type="text" placeholder="16 digit NIK" maxlength="16" class="w-full bg-slate-50 border border-borderSoft rounded-xl px-4 py-3 text-sm text-espresso focus:outline-none focus:border-terracotta focus:ring-2 focus:ring-terracotta/20 transition-all" />
                </div>
              </div>
            </div>

            <!-- Section: Sosial Media -->
            <div>
              <h3 class="text-lg font-bold text-espresso mb-4 flex items-center gap-2">
                <span class="w-7 h-7 bg-orange-100 rounded-full flex items-center justify-center text-xs font-black text-terracotta">4</span>
                Sosial Media (Opsional)
              </h3>
              <div class="space-y-4">
                <div>
                  <label class="block text-xs font-bold text-slate-500 mb-1.5 uppercase tracking-wider">Instagram</label>
                  <input v-model="form.instagram" type="text" placeholder="@username" class="w-full bg-slate-50 border border-borderSoft rounded-xl px-4 py-3 text-sm text-espresso focus:outline-none focus:border-terracotta focus:ring-2 focus:ring-terracotta/20 transition-all" />
                </div>
                <div>
                  <label class="block text-xs font-bold text-slate-500 mb-1.5 uppercase tracking-wider">Website</label>
                  <input v-model="form.website" type="text" placeholder="https://..." class="w-full bg-slate-50 border border-borderSoft rounded-xl px-4 py-3 text-sm text-espresso focus:outline-none focus:border-terracotta focus:ring-2 focus:ring-terracotta/20 transition-all" />
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Submit (full width below grid) -->
        <div class="pt-6 mt-8 border-t border-borderSoft flex flex-col sm:flex-row gap-3">
          <button type="button" @click="router.push('/profile')" class="sm:w-auto px-6 py-3.5 bg-slate-100 hover:bg-slate-200 text-espresso font-bold rounded-xl transition-colors text-sm order-2 sm:order-1">
            ← Kembali
          </button>
          <button type="submit" :disabled="isVerifying" class="flex-1 bg-slate-900 hover:bg-terracotta text-white font-bold py-3.5 rounded-xl transition-all duration-300 shadow-lg shadow-slate-900/10 hover:shadow-terracotta/20 active:scale-[0.98] disabled:opacity-50 disabled:cursor-not-allowed text-sm order-1 sm:order-2">
            Submit & Verifikasi
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
