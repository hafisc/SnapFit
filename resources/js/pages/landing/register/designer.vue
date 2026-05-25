<template>
  <div class="snapfit-heritage-bg min-h-screen font-sans">
    <Navbar :user="user" />

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8 pt-28">
      <!-- Header -->
      <div class="text-center mb-10">
        <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
          <span class="text-3xl">🎨</span>
        </div>
        <h1 class="text-3xl font-black text-espresso">Daftar sebagai Designer</h1>
        <p class="text-muted mt-2 max-w-md mx-auto">Tunjukkan skill kreatifmu dan bantu UMKM Indonesia tampil lebih profesional.</p>
      </div>

      <!-- AI Verification Result -->
      <div v-if="verificationResult" class="mb-8 animate-fade-in">
        <div class="bg-surface rounded-3xl p-8 border shadow-lg"
             :class="{
               'border-green-200 shadow-green-500/10': verificationResult.status === 'approved',
               'border-amber-200 shadow-amber-500/10': verificationResult.status === 'need_review',
               'border-red-200 shadow-red-500/10': verificationResult.status === 'rejected'
             }">
          
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
              <p class="text-sm text-muted">Verifikasi AI SnapFit</p>
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

          <div class="bg-slate-50 rounded-2xl p-4 mb-4">
            <p class="text-sm text-espresso leading-relaxed">{{ verificationResult.ai_summary }}</p>
          </div>

          <div v-if="verificationResult.ai_issues?.length" class="mb-4">
            <h4 class="text-xs font-bold text-red-600 uppercase tracking-wider mb-2">Yang Perlu Diperbaiki</h4>
            <ul class="space-y-1.5">
              <li v-for="issue in verificationResult.ai_issues" :key="issue" class="flex items-start gap-2 text-sm text-red-700">
                <svg class="w-4 h-4 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01" /></svg>
                {{ issue }}
              </li>
            </ul>
          </div>

          <div v-if="verificationResult.ai_recommendations?.length" class="mb-6">
            <h4 class="text-xs font-bold text-blue-600 uppercase tracking-wider mb-2">Rekomendasi</h4>
            <ul class="space-y-1.5">
              <li v-for="rec in verificationResult.ai_recommendations" :key="rec" class="flex items-start gap-2 text-sm text-blue-700">
                <svg class="w-4 h-4 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                {{ rec }}
              </li>
            </ul>
          </div>

          <div class="flex gap-3">
            <button v-if="verificationResult.status === 'approved'" @click="router.push('/designer/dashboard')" class="flex-1 bg-green-600 hover:bg-green-700 text-white font-bold py-3.5 px-6 rounded-xl transition-colors shadow-lg shadow-green-500/20">
              Buka Dashboard Designer
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
          <div class="absolute inset-0 border-4 border-t-purple-500 rounded-full animate-spin"></div>
          <div class="absolute inset-3 bg-purple-50 rounded-full flex items-center justify-center">
            <span class="text-2xl">🤖</span>
          </div>
        </div>
        <h3 class="text-xl font-black text-espresso mb-3">AI Sedang Memverifikasi</h3>
        <div class="space-y-2 max-w-sm mx-auto">
          <p class="text-sm text-muted" :class="{ 'animate-pulse': verifyStep === 0, 'text-green-600 font-semibold': verifyStep >= 1 }">
            {{ verifyStep >= 1 ? '✓' : '⏳' }} Menganalisis profil designer...
          </p>
          <p class="text-sm text-muted" :class="{ 'animate-pulse': verifyStep === 1, 'text-green-600 font-semibold': verifyStep >= 2 }">
            {{ verifyStep >= 2 ? '✓' : '⏳' }} Memeriksa skill dan portfolio...
          </p>
          <p class="text-sm text-muted" :class="{ 'animate-pulse': verifyStep === 2, 'text-green-600 font-semibold': verifyStep >= 3 }">
            {{ verifyStep >= 3 ? '✓' : '⏳' }} Mengevaluasi kesesuaian dengan SnapFit...
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
        <div>
          <h3 class="text-lg font-bold text-espresso mb-4 flex items-center gap-2">
            <span class="w-7 h-7 bg-purple-100 rounded-full flex items-center justify-center text-xs font-black text-purple-600">1</span>
            Profil Designer
          </h3>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label class="block text-xs font-bold text-slate-500 mb-1.5 uppercase tracking-wider">Nama Display *</label>
              <input v-model="form.display_name" type="text" required placeholder="Nama yang ditampilkan" class="w-full bg-slate-50 border border-borderSoft rounded-xl px-4 py-3 text-sm text-espresso focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 transition-all" />
            </div>
            <div>
              <label class="block text-xs font-bold text-slate-500 mb-1.5 uppercase tracking-wider">Domisili *</label>
              <input v-model="form.city" type="text" required placeholder="Kota tempat tinggal" class="w-full bg-slate-50 border border-borderSoft rounded-xl px-4 py-3 text-sm text-espresso focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 transition-all" />
            </div>
          </div>
          <div class="mt-4">
            <label class="block text-xs font-bold text-slate-500 mb-1.5 uppercase tracking-wider">Nomor WhatsApp *</label>
            <input v-model="form.whatsapp" type="text" required placeholder="08xxxxxxxxxx" class="w-full bg-slate-50 border border-borderSoft rounded-xl px-4 py-3 text-sm text-espresso focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 transition-all" />
          </div>
        </div>

        <!-- Section: Keahlian -->
        <div>
          <h3 class="text-lg font-bold text-espresso mb-4 flex items-center gap-2">
            <span class="w-7 h-7 bg-purple-100 rounded-full flex items-center justify-center text-xs font-black text-purple-600">2</span>
            Keahlian & Pengalaman
          </h3>
          <div class="mb-4">
            <label class="block text-xs font-bold text-slate-500 mb-2 uppercase tracking-wider">Keahlian Utama * (pilih minimal 1)</label>
            <div class="flex flex-wrap gap-2">
              <button v-for="skill in availableSkills" :key="skill" type="button"
                @click="toggleSkill(skill)"
                class="px-3 py-2 rounded-lg text-xs font-bold border transition-all"
                :class="form.skills.includes(skill) ? 'bg-purple-100 border-purple-300 text-purple-700' : 'bg-slate-50 border-borderSoft text-muted hover:border-purple-300'">
                {{ skill }}
              </button>
            </div>
          </div>
          <div class="space-y-4">
            <div>
              <label class="block text-xs font-bold text-slate-500 mb-1.5 uppercase tracking-wider">Bio Singkat *</label>
              <textarea v-model="form.bio" required rows="3" placeholder="Ceritakan tentang dirimu sebagai designer..." class="w-full bg-slate-50 border border-borderSoft rounded-xl px-4 py-3 text-sm text-espresso focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 transition-all resize-none"></textarea>
              <p class="text-xs text-muted mt-1">Minimal 30 karakter.</p>
            </div>
            <div>
              <label class="block text-xs font-bold text-slate-500 mb-1.5 uppercase tracking-wider">Pengalaman *</label>
              <textarea v-model="form.experience" required rows="3" placeholder="Pengalaman kerja atau proyek yang pernah dikerjakan..." class="w-full bg-slate-50 border border-borderSoft rounded-xl px-4 py-3 text-sm text-espresso focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 transition-all resize-none"></textarea>
            </div>
            <div>
              <label class="block text-xs font-bold text-slate-500 mb-1.5 uppercase tracking-wider">Software yang Dikuasai</label>
              <div class="flex flex-wrap gap-2">
                <button v-for="tool in availableTools" :key="tool" type="button"
                  @click="toggleTool(tool)"
                  class="px-3 py-2 rounded-lg text-xs font-bold border transition-all"
                  :class="form.tools.includes(tool) ? 'bg-blue-100 border-blue-300 text-blue-700' : 'bg-slate-50 border-borderSoft text-muted hover:border-blue-300'">
                  {{ tool }}
                </button>
              </div>
            </div>
          </div>
        </div>
          </div>

          <!-- RIGHT COLUMN -->
          <div class="space-y-6">
        <!-- Section: Portfolio -->
        <div>
          <h3 class="text-lg font-bold text-espresso mb-4 flex items-center gap-2">
            <span class="w-7 h-7 bg-purple-100 rounded-full flex items-center justify-center text-xs font-black text-purple-600">3</span>
            Portfolio & Karya
          </h3>
          <div class="space-y-4">
            <div>
              <label class="block text-xs font-bold text-slate-500 mb-1.5 uppercase tracking-wider">Link Portfolio (Behance / Dribbble / Website)</label>
              <input v-model="form.portfolio_url" type="text" placeholder="https://behance.net/username" class="w-full bg-slate-50 border border-borderSoft rounded-xl px-4 py-3 text-sm text-espresso focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 transition-all" />
            </div>
            <div>
              <label class="block text-xs font-bold text-slate-500 mb-1.5 uppercase tracking-wider">Upload Contoh Karya</label>
              <div class="relative">
                <input type="file" accept="image/*" @change="(e) => handleFileUpload(e, 'sample_work')" class="hidden" id="upload-sample-work" />
                <label for="upload-sample-work" class="flex items-center gap-3 w-full bg-slate-50 border-2 border-dashed border-borderSoft rounded-xl px-4 py-3 cursor-pointer hover:border-purple-400 hover:bg-purple-50/50 transition-all">
                  <div v-if="uploads.sample_work.url" class="w-10 h-10 rounded-lg overflow-hidden bg-slate-200 flex-shrink-0">
                    <img :src="uploads.sample_work.url" class="w-full h-full object-cover" />
                  </div>
                  <div v-else class="w-10 h-10 rounded-lg bg-slate-100 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                  </div>
                  <div class="flex-1 min-w-0">
                    <p class="text-xs font-semibold text-espresso truncate">{{ uploads.sample_work.name || 'Pilih gambar contoh karya' }}</p>
                    <p class="text-[10px] text-muted">JPG, PNG, WebP (maks 5MB)</p>
                  </div>
                  <span v-if="uploads.sample_work.uploading" class="w-5 h-5 border-2 border-slate-200 border-t-purple-500 rounded-full animate-spin flex-shrink-0"></span>
                  <svg v-else-if="uploads.sample_work.url" class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
                </label>
              </div>
            </div>
            <div>
              <label class="block text-xs font-bold text-slate-500 mb-1.5 uppercase tracking-wider">Jenis Kolaborasi yang Diminati</label>
              <input v-model="form.collaboration_interest" type="text" placeholder="Contoh: Branding UMKM, Packaging Design, Social Media" class="w-full bg-slate-50 border border-borderSoft rounded-xl px-4 py-3 text-sm text-espresso focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 transition-all" />
            </div>
            <div>
              <label class="block text-xs font-bold text-slate-500 mb-1.5 uppercase tracking-wider">Rate Jasa (Opsional)</label>
              <input v-model="form.rate" type="text" placeholder="Contoh: Mulai dari Rp 500.000 / project" class="w-full bg-slate-50 border border-borderSoft rounded-xl px-4 py-3 text-sm text-espresso focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 transition-all" />
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
          <button type="submit" :disabled="isVerifying || form.skills.length === 0" class="flex-1 bg-slate-900 hover:bg-purple-600 text-white font-bold py-3.5 rounded-xl transition-all duration-300 shadow-lg shadow-slate-900/10 hover:shadow-purple-500/20 active:scale-[0.98] disabled:opacity-50 disabled:cursor-not-allowed text-sm order-1 sm:order-2">
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

const availableSkills = [
  'Branding', 'Packaging Design', 'Fashion Design', 'Product Photography',
  'Illustration', 'UI/UX', 'Social Media Design', 'Typography',
  'Motion Graphics', 'Print Design'
];

const availableTools = [
  'Adobe Photoshop', 'Adobe Illustrator', 'Figma', 'Canva',
  'CorelDRAW', 'Adobe InDesign', 'Blender', 'Procreate',
  'Adobe After Effects', 'Sketch'
];

const form = ref({
  display_name: '',
  city: '',
  skills: [],
  bio: '',
  experience: '',
  portfolio_url: '',
  sample_work_url: '',
  tools: [],
  collaboration_interest: '',
  whatsapp: '',
  rate: '',
});

const isVerifying = ref(false);
const verifyStep = ref(0);
const verificationResult = ref(null);

const uploads = ref({
  sample_work: { url: '', name: '', uploading: false },
});

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
      if (type === 'sample_work') form.value.sample_work_url = data.url;
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

const toggleSkill = (skill) => {
  const idx = form.value.skills.indexOf(skill);
  if (idx >= 0) form.value.skills.splice(idx, 1);
  else form.value.skills.push(skill);
};

const toggleTool = (tool) => {
  const idx = form.value.tools.indexOf(tool);
  if (idx >= 0) form.value.tools.splice(idx, 1);
  else form.value.tools.push(tool);
};

const submitForm = async () => {
  if (!token) return router.push('/login');
  if (form.value.skills.length === 0) return alert('Pilih minimal 1 keahlian.');

  isVerifying.value = true;
  verifyStep.value = 0;

  const stepInterval = setInterval(() => {
    if (verifyStep.value < 4) verifyStep.value++;
  }, 1200);

  try {
    const res = await fetch('/api/v1/role-applications/designer', {
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

onMounted(async () => {
  if (!token) return router.push('/login');

  try {
    const res = await fetch('/api/v1/role-applications/status/designer', {
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
