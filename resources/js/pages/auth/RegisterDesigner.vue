<template>
  <div class="min-h-screen bg-gradient-to-b from-slate-50 to-white font-sans">
    <!-- Navbar -->
    <Navbar :user="user" />

    <div class="max-w-2xl mx-auto px-4 sm:px-6 py-12 pt-32">
      <!-- Header -->
      <div class="text-center mb-12">
        <div class="inline-block p-4 bg-gradient-to-br from-purple-100 to-pink-100 rounded-2xl mb-6">
          <span class="text-5xl">🎨</span>
        </div>
        <h1 class="text-4xl font-black text-espresso mb-3">Daftar sebagai Designer</h1>
        <p class="text-muted text-lg leading-relaxed">
          Kolaborasi dengan UMKM lokal dan dapatkan passive income dari karya kreatif Anda
        </p>
      </div>

      <!-- Form Card -->
      <div class="bg-surface rounded-3xl border border-borderSoft shadow-lg p-8 sm:p-10 mb-8">
        <form @submit.prevent="handleSubmit" class="space-y-6">
          <!-- Portfolio URL -->
          <div>
            <label for="designer_portfolio_url" class="block text-sm font-bold text-espresso mb-2">
              URL Portfolio / Website
            </label>
            <input id="designer_portfolio_url" v-model="form.designer_portfolio_url" type="url"
              placeholder="Contoh: https://portfolio.yourname.com atau https://dribbble.com/yourname"
              class="w-full px-4 py-3 border-2 border-borderSoft rounded-lg focus:border-purple-500 focus:outline-none transition-colors text-espresso font-medium placeholder:text-slate-400"
              :disabled="isLoading" />
            <p class="text-xs text-muted mt-2">Link ke portfolio online Anda yang menampilkan karya terbaik
              (Dribbble, Behance, personal website, dll)</p>
            <p v-if="errors.designer_portfolio_url" class="text-xs text-red-500 mt-1">{{ errors.designer_portfolio_url
              }}</p>
          </div>

          <!-- Designer Name -->
          <div>
            <label for="designer_name" class="block text-sm font-bold text-espresso mb-2">
              Nama Designer / Nama Panggilan
            </label>
            <input id="designer_name" v-model="form.designer_name" type="text"
              placeholder="Contoh: Rina Designer, Ahmad Illustrator"
              class="w-full px-4 py-3 border-2 border-borderSoft rounded-lg focus:border-purple-500 focus:outline-none transition-colors text-espresso font-medium placeholder:text-slate-400"
              :disabled="isLoading" />
            <p class="text-xs text-muted mt-2">Nama yang akan ditampilkan di profil designer Anda</p>
            <p v-if="errors.designer_name" class="text-xs text-red-500 mt-1">{{ errors.designer_name }}</p>
          </div>

          <!-- Designer Bio -->
          <div>
            <label for="designer_bio" class="block text-sm font-bold text-espresso mb-2">
              Bio / Deskripsi Diri
            </label>
            <textarea id="designer_bio" v-model="form.designer_bio" rows="4"
              placeholder="Ceritakan tentang diri Anda, spesialisasi design, pengalaman, dan apa yang membuat Anda unik. Contoh: Spesialis fashion design dengan 5 tahun pengalaman, mahir Adobe Creative Suite, fokus pada design sustainable fashion."
              class="w-full px-4 py-3 border-2 border-borderSoft rounded-lg focus:border-purple-500 focus:outline-none transition-colors text-espresso font-medium placeholder:text-slate-400 resize-none"
              maxlength="500" :disabled="isLoading"></textarea>
            <p class="text-xs text-muted mt-2">
              {{ form.designer_bio.length }}/500 karakter - Bio yang menarik membantu UMKM memilih Anda sebagai designer
            </p>
            <p v-if="errors.designer_bio" class="text-xs text-red-500 mt-1">{{ errors.designer_bio }}</p>
          </div>

          <!-- Specialization -->
          <div>
            <label for="specialization" class="block text-sm font-bold text-espresso mb-2">
              Spesialisasi (Pilih yang relevan)
            </label>
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
              <label v-for="spec in specializations" :key="spec" class="flex items-center gap-2 cursor-pointer group">
                <input type="checkbox" :value="spec" v-model="form.specializations"
                  class="w-4 h-4 border-2 border-slate-300 rounded text-purple-600 focus:ring-purple-500"
                  :disabled="isLoading" />
                <span class="text-sm text-espresso group-hover:text-purple-600 transition-colors">{{ spec }}</span>
              </label>
            </div>
            <p class="text-xs text-muted mt-2">Pilih minimal 1 spesialisasi yang Anda kuasai</p>
            <p v-if="errors.specializations" class="text-xs text-red-500 mt-1">{{ errors.specializations }}</p>
          </div>

          <!-- Contact Info -->
          <div>
            <label for="contact_email" class="block text-sm font-bold text-espresso mb-2">
              Email Kontak (opsional)
            </label>
            <input id="contact_email" v-model="form.contact_email" type="email" placeholder="Contoh: designer@email.com"
              class="w-full px-4 py-3 border-2 border-borderSoft rounded-lg focus:border-purple-500 focus:outline-none transition-colors text-espresso font-medium placeholder:text-slate-400"
              :disabled="isLoading" />
            <p class="text-xs text-muted mt-2">Email kontak opsional jika berbeda dengan email account SnapFit Anda
            </p>
            <p v-if="errors.contact_email" class="text-xs text-red-500 mt-1">{{ errors.contact_email }}</p>
          </div>

          <!-- Submit Button -->
          <div class="pt-6">
            <button type="submit" :disabled="isLoading"
              class="w-full bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 disabled:opacity-50 text-white font-black py-4 px-6 rounded-lg transition-all duration-200 active:scale-95 text-lg uppercase tracking-widest shadow-lg shadow-purple-500/30 flex items-center justify-center gap-2">
              <svg v-if="!isLoading" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
              </svg>
              <span v-if="isLoading">Mendaftarkan...</span>
              <span v-else>Daftar Sebagai Designer</span>
            </button>
            <p class="text-center text-xs text-muted mt-3">
              Dengan mendaftar, Anda setuju dengan Syarat & Ketentuan SnapFit Designer
            </p>
          </div>
        </form>

        <!-- Success Message -->
        <div v-if="successMessage"
          class="mt-6 p-4 bg-green-50 border border-green-200 rounded-lg flex items-start gap-3">
          <svg class="w-5 h-5 text-green-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd"
              d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
              clip-rule="evenodd" />
          </svg>
          <div>
            <p class="font-bold text-green-900">{{ successMessage }}</p>
            <p class="text-sm text-green-700 mt-1">Anda akan diarahkan ke dashboard designer...</p>
          </div>
        </div>
      </div>

      <!-- Info Box -->
      <div class="bg-gradient-to-r from-purple-50 to-pink-50 border border-purple-200 rounded-2xl p-6 space-y-3">
        <h3 class="font-bold text-espresso flex items-center gap-2">
          <span class="text-xl">💡</span> Apa saja yang bisa dilakukan sebagai Designer?
        </h3>
        <ul class="space-y-2 text-sm text-espresso">
          <li class="flex items-start gap-2">
            <span class="text-purple-600 font-bold mt-0.5">✓</span>
            <span>Lihat project kolaborasi dari UMKM lokal yang mencari designer</span>
          </li>
          <li class="flex items-start gap-2">
            <span class="text-purple-600 font-bold mt-0.5">✓</span>
            <span>Ajukan penawaran dan negosiasi budget project design</span>
          </li>
          <li class="flex items-start gap-2">
            <span class="text-purple-600 font-bold mt-0.5">✓</span>
            <span>Kerjakan design langsung di Co-creation Room dengan tools kolaborasi real-time</span>
          </li>
          <li class="flex items-start gap-2">
            <span class="text-purple-600 font-bold mt-0.5">✓</span>
            <span>Terima pembayaran untuk setiap project yang diselesaikan</span>
          </li>
          <li class="flex items-start gap-2">
            <span class="text-purple-600 font-bold mt-0.5">✓</span>
            <span>Bangun portfolio dan reputasi di komunitas designer SnapFit</span>
          </li>
        </ul>
      </div>

      <!-- Back Link -->
      <div class="text-center mt-8">
        <router-link to="/profile"
          class="inline-flex items-center gap-2 text-purple-600 hover:text-purple-700 font-semibold transition-colors">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
          </svg>
          Kembali ke Profile
        </router-link>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import Navbar from '@/pages/landing/partials/Navbar.vue';

const router = useRouter();
const user = ref(null);
const isLoading = ref(false);
const successMessage = ref('');
const errors = ref({});
const token = localStorage.getItem('token');

const specializations = [
  'Fashion Design',
  'Graphic Design',
  'UI/UX Design',
  'Product Design',
  'Illustration',
  'Packaging Design',
  '3D Design',
  'Branding',
  'Web Design',
  'Motion Graphics',
  'Photography',
  'Social Media Design'
];

const form = ref({
  designer_name: '',
  designer_portfolio_url: '',
  designer_bio: '',
  contact_email: '',
  specializations: []
});

// Check if user is authenticated and already has Designer role
onMounted(() => {
  const userData = localStorage.getItem('user');
  if (!userData || !token) {
    router.push('/login');
    return;
  }

  user.value = JSON.parse(userData);

  // Prevent access if already have Designer role
  if (user.value?.owned_roles?.includes('designer')) {
    router.push('/profile');
    return;
  }
});

const handleSubmit = async () => {
  // Reset errors
  errors.value = {};
  successMessage.value = '';

  // Validation
  if (form.value.specializations.length === 0) {
    errors.value.specializations = 'Pilih minimal 1 spesialisasi';
    return;
  }

  isLoading.value = true;

  try {
    const res = await fetch('/api/v1/designer/register', {
      method: 'POST',
      headers: {
        'Authorization': `Bearer ${token}`,
        'Content-Type': 'application/json',
        'Accept': 'application/json'
      },
      body: JSON.stringify({
        designer_name: form.value.designer_name?.trim() || null,
        designer_portfolio_url: form.value.designer_portfolio_url?.trim() || null,
        designer_bio: form.value.designer_bio?.trim() || null,
        contact_email: form.value.contact_email?.trim() || null,
        specializations: form.value.specializations
      })
    });

    const data = await res.json();

    if (res.ok) {
      successMessage.value = data.message || 'Berhasil terdaftar sebagai Designer!';

      // Update user in localStorage
      if (data.user) {
        localStorage.setItem('user', JSON.stringify(data.user));
      }

      // Redirect ke Designer dashboard setelah 2 detik
      setTimeout(() => {
        router.push('/designer/dashboard');
      }, 2000);
    } else {
      // Handle validation errors
      if (data.errors) {
        errors.value = data.errors;
      } else {
        errors.value.general = data.message || 'Terjadi kesalahan saat mendaftar.';
      }
    }
  } catch (err) {
    console.error('Failed to register as Designer', err);
    errors.value.general = 'Terjadi kesalahan jaringan. Silakan coba lagi.';
  } finally {
    isLoading.value = false;
  }
};
</script>

<style scoped>
/* Smooth transitions */
button {
  @apply transition-all duration-200;
}

input,
textarea {
  @apply transition-colors duration-200;
}
</style>
