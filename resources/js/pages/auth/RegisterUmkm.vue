<template>
  <div class="min-h-screen bg-gradient-to-b from-slate-50 to-white font-sans">
    <!-- Navbar -->
    <Navbar :user="user" />

    <div class="max-w-2xl mx-auto px-4 sm:px-6 py-12 pt-32">
      <!-- Header -->
      <div class="text-center mb-12">
        <div class="inline-block p-4 bg-gradient-to-br from-orange-100 to-amber-100 rounded-2xl mb-6">
          <span class="text-5xl">🏪</span>
        </div>
        <h1 class="text-4xl font-black text-espresso mb-3">Daftar sebagai UMKM</h1>
        <p class="text-muted text-lg leading-relaxed">
          Mulai jual produk Anda dan kelola bisnis UMKM dengan tools profesional SnapFit
        </p>
      </div>

      <!-- Form Card -->
      <div class="bg-surface rounded-3xl border border-borderSoft shadow-lg p-8 sm:p-10 mb-8">
        <form @submit.prevent="handleSubmit" class="space-y-6">
          <!-- Business Name -->
          <div>
            <label for="business_name" class="block text-sm font-bold text-espresso mb-2">
              Nama Bisnis / UMKM <span class="text-red-500">*</span>
            </label>
            <input id="business_name" v-model="form.business_name" type="text"
              placeholder="Contoh: Batik Malang, Keramik Jepara, Furniture Jati"
              class="w-full px-4 py-3 border-2 border-borderSoft rounded-lg focus:border-orange-500 focus:outline-none transition-colors text-espresso font-medium placeholder:text-slate-400"
              required :disabled="isLoading" />
            <p class="text-xs text-muted mt-2">Nama bisnis Anda yang akan ditampilkan di marketplace</p>
            <p v-if="errors.business_name" class="text-xs text-red-500 mt-1">{{ errors.business_name }}</p>
          </div>

          <!-- Business Phone -->
          <div>
            <label for="business_phone" class="block text-sm font-bold text-espresso mb-2">
              Nomor Telepon Bisnis
            </label>
            <input id="business_phone" v-model="form.business_phone" type="tel"
              placeholder="Contoh: +62 812 3456 7890 atau 0812 3456 7890"
              class="w-full px-4 py-3 border-2 border-borderSoft rounded-lg focus:border-orange-500 focus:outline-none transition-colors text-espresso font-medium placeholder:text-slate-400"
              :disabled="isLoading" />
            <p class="text-xs text-muted mt-2">Nomor yang bisa dihubungi customer Anda</p>
            <p v-if="errors.business_phone" class="text-xs text-red-500 mt-1">{{ errors.business_phone }}</p>
          </div>

          <!-- Business Address -->
          <div>
            <label for="business_address" class="block text-sm font-bold text-espresso mb-2">
              Alamat Bisnis
            </label>
            <textarea id="business_address" v-model="form.business_address" rows="3"
              placeholder="Contoh: Jl. Merdeka No. 123, Kelurahan Sukun, Kecamatan Malang, Kota Malang, Jawa Timur 65145"
              class="w-full px-4 py-3 border-2 border-borderSoft rounded-lg focus:border-orange-500 focus:outline-none transition-colors text-espresso font-medium placeholder:text-slate-400 resize-none"
              :disabled="isLoading"></textarea>
            <p class="text-xs text-muted mt-2">Alamat lengkap lokasi bisnis Anda</p>
            <p v-if="errors.business_address" class="text-xs text-red-500 mt-1">{{ errors.business_address }}</p>
          </div>

          <!-- Business Bio -->
          <div>
            <label for="business_bio" class="block text-sm font-bold text-espresso mb-2">
              Deskripsi Bisnis / Bio
            </label>
            <textarea id="business_bio" v-model="form.business_bio" rows="4"
              placeholder="Ceritakan tentang bisnis Anda, produk unggulan, pengalaman, atau keunikan yang Anda tawarkan. Maksimal 500 karakter."
              class="w-full px-4 py-3 border-2 border-borderSoft rounded-lg focus:border-orange-500 focus:outline-none transition-colors text-espresso font-medium placeholder:text-slate-400 resize-none"
              maxlength="500" :disabled="isLoading"></textarea>
            <p class="text-xs text-muted mt-2">
              {{ form.business_bio.length }}/500 karakter - Deskripsi menarik membantu customer memilih produk Anda
            </p>
            <p v-if="errors.business_bio" class="text-xs text-red-500 mt-1">{{ errors.business_bio }}</p>
          </div>

          <!-- Submit Button -->
          <div class="pt-6">
            <button type="submit" :disabled="isLoading"
              class="w-full bg-gradient-to-r from-orange-600 to-amber-600 hover:from-orange-700 hover:to-amber-700 disabled:opacity-50 text-white font-black py-4 px-6 rounded-lg transition-all duration-200 active:scale-95 text-lg uppercase tracking-widest shadow-lg shadow-terracotta/50/30 flex items-center justify-center gap-2">
              <svg v-if="!isLoading" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
              </svg>
              <span v-if="isLoading">Mendaftarkan...</span>
              <span v-else>Daftar Sebagai UMKM</span>
            </button>
            <p class="text-center text-xs text-muted mt-3">
              Dengan mendaftar, Anda setuju dengan Syarat & Ketentuan SnapFit Seller
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
            <p class="text-sm text-green-700 mt-1">Anda akan diarahkan ke dashboard UMKM...</p>
          </div>
        </div>
      </div>

      <!-- Info Box -->
      <div class="bg-gradient-to-r from-blue-50 to-cyan-50 border border-blue-200 rounded-2xl p-6 space-y-3">
        <h3 class="font-bold text-espresso flex items-center gap-2">
          <span class="text-xl">💡</span> Apa saja yang bisa dilakukan sebagai UMKM?
        </h3>
        <ul class="space-y-2 text-sm text-espresso">
          <li class="flex items-start gap-2">
            <span class="text-blue-600 font-bold mt-0.5">✓</span>
            <span>Upload dan kelola katalog produk dengan foto berkualitas</span>
          </li>
          <li class="flex items-start gap-2">
            <span class="text-blue-600 font-bold mt-0.5">✓</span>
            <span>Gunakan AI Product Studio untuk generate deskripsi & foto produk</span>
          </li>
          <li class="flex items-start gap-2">
            <span class="text-blue-600 font-bold mt-0.5">✓</span>
            <span>Kolaborasi dengan Designer untuk design produk Anda</span>
          </li>
          <li class="flex items-start gap-2">
            <span class="text-blue-600 font-bold mt-0.5">✓</span>
            <span>Lihat analytics dan tracking penjualan real-time</span>
          </li>
          <li class="flex items-start gap-2">
            <span class="text-blue-600 font-bold mt-0.5">✓</span>
            <span>Terima pembayaran dari customer melalui multiple payment gateway</span>
          </li>
        </ul>
      </div>

      <!-- Back Link -->
      <div class="text-center mt-8">
        <router-link to="/profile"
          class="inline-flex items-center gap-2 text-terracotta hover:text-orange-700 font-semibold transition-colors">
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

const form = ref({
  business_name: '',
  business_phone: '',
  business_address: '',
  business_bio: ''
});

// Check if user is authenticated and already has UMKM role
onMounted(() => {
  const userData = localStorage.getItem('user');
  if (!userData || !token) {
    router.push('/login');
    return;
  }

  user.value = JSON.parse(userData);

  // Prevent access if already have UMKM role
  if (user.value?.owned_roles?.includes('umkm')) {
    router.push('/profile');
    return;
  }
});

const handleSubmit = async () => {
  // Reset errors
  errors.value = {};
  successMessage.value = '';

  // Basic validation
  if (!form.value.business_name?.trim()) {
    errors.value.business_name = 'Nama bisnis harus diisi';
    return;
  }

  isLoading.value = true;

  try {
    const res = await fetch('/api/v1/umkm/register', {
      method: 'POST',
      headers: {
        'Authorization': `Bearer ${token}`,
        'Content-Type': 'application/json',
        'Accept': 'application/json'
      },
      body: JSON.stringify({
        business_name: form.value.business_name.trim(),
        business_phone: form.value.business_phone?.trim() || null,
        business_address: form.value.business_address?.trim() || null,
        business_bio: form.value.business_bio?.trim() || null
      })
    });

    const data = await res.json();

    if (res.ok) {
      successMessage.value = data.message || 'Berhasil terdaftar sebagai UMKM!';

      // Update user in localStorage
      if (data.user) {
        localStorage.setItem('user', JSON.stringify(data.user));
      }

      // Redirect ke UMKM dashboard setelah 2 detik
      setTimeout(() => {
        router.push('/umkm/dashboard');
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
    console.error('Failed to register as UMKM', err);
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
