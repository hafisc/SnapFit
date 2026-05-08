<template>
  <div class="min-h-screen flex items-center justify-center p-4 md:p-10 bg-[#FAFAFA] font-sans selection:bg-orange-100">
    <button
      @click="goToLanding"
      class="fixed top-8 left-8 z-50 flex items-center gap-3 text-[10px] font-black uppercase tracking-[0.3em] text-slate-400 hover:text-orange-600 transition-all group bg-white/50 backdrop-blur-md px-5 py-3 rounded-full border border-slate-100 shadow-sm"
    >
      <svg class="w-4 h-4 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
      </svg>
      Kembali ke Beranda
    </button>

    <div class="w-full max-w-6xl flex flex-col md:flex-row bg-white rounded-[3.5rem] overflow-hidden shadow-[0_40px_100px_-20px_rgba(0,0,0,0.06)] border border-white">
      <!-- Left Branding Panel -->
      <div class="w-full md:w-[45%] bg-slate-900 p-10 md:p-16 flex flex-col justify-between relative overflow-hidden min-h-[400px] md:min-h-0">
        <div class="absolute top-0 left-0 w-full h-full opacity-40 pointer-events-none">
          <div class="absolute -top-24 -left-24 w-96 h-96 bg-orange-600 rounded-full blur-[100px] animate-pulse"></div>
          <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-amber-500 rounded-full blur-[100px]"></div>
        </div>

        <div class="relative z-10">
          <div class="flex items-center gap-4 mb-16">
            <div class="w-10 h-10 rounded-xl overflow-hidden shadow-sm border border-slate-100 transform group-hover:scale-105 transition-all duration-300 flex items-center justify-center bg-white">
          <img :src="'/images/logo.png'" alt="SnapFit Logo" class="w-full h-full object-cover" />
        </div>
            <div class="h-8 w-px bg-white/20"></div>
            <span class="text-white font-black tracking-tighter text-2xl italic">SnapFit.</span>
          </div>

          <h2 class="text-5xl font-black text-white leading-[1.1] mb-8 tracking-tighter">
            Dimana <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-400 to-amber-300 italic">Kreativitas</span> <br/>Bertemu Teknologi.
          </h2>

          <div class="space-y-4">
            <div v-for="feat in brandFeatures" :key="feat.label" class="flex items-center gap-3 text-slate-400">
              <div :class="`w-5 h-5 rounded-full bg-${feat.color}-500/20 flex items-center justify-center`">
                <div :class="`w-1.5 h-1.5 bg-${feat.color}-500 rounded-full`"></div>
              </div>
              <p class="text-xs font-bold uppercase tracking-widest">{{ feat.label }}</p>
            </div>
          </div>
        </div>

        <div class="relative z-10 mt-20 md:mt-0 pt-10 border-t border-white/5">
          <p class="text-[9px] uppercase tracking-[0.4em] text-slate-500 font-black mb-4">Dipercaya oleh Malang Creative Lab</p>
          <div class="flex gap-6 opacity-20 grayscale brightness-200">
            <div class="h-5 w-12 bg-white rounded-md"></div>
            <div class="h-5 w-20 bg-white rounded-md"></div>
            <div class="h-5 w-14 bg-white rounded-md"></div>
          </div>
        </div>
      </div>

      <!-- Right Form Panel -->
      <div class="w-full md:w-[55%] p-8 md:p-20 bg-white flex items-center">
        <div class="max-w-md mx-auto w-full">
          <div class="mb-12">
            
            <h3 class="text-4xl font-black text-slate-900 mb-3 tracking-tighter uppercase italic">
              {{ isLogin ? 'Selamat Datang' : 'Buat Akun' }}
            </h3>
            <p class="text-slate-400 text-sm font-medium leading-relaxed">
              {{ isLogin
                ? 'Akses dashboard Anda dan mulai berkolaborasi hari ini.'
                : 'Daftarkan diri Anda sebagai bagian dari ekosistem kreatif Malang.' }}
            </p>
          </div>

          <!-- Error Alert -->
          <div v-if="errorMessage" class="mb-6 px-5 py-4 bg-red-50 border border-red-100 rounded-2xl">
            <p class="text-xs font-bold text-red-600">{{ errorMessage }}</p>
          </div>

          <form class="space-y-6" @submit.prevent="submit">
            <!-- Name (Register only) -->
            <Transition name="slide-fade">
              <div v-if="!isLogin">
                <label class="block text-[9px] font-black uppercase tracking-[0.3em] text-slate-400 mb-3 ml-1">Nama Lengkap</label>
                <div class="relative group">
                  <span class="absolute left-5 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-orange-500 transition-colors pointer-events-none">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                  </span>
                  <input v-model="name" type="text" placeholder="John Doe"
                    class="w-full bg-slate-50 border border-slate-200 rounded-[1.25rem] pl-14 pr-6 py-[1.125rem] outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 focus:bg-white hover:border-slate-300 transition-colors text-slate-900 font-semibold placeholder-slate-400 caret-orange-500" />
                </div>
              </div>
            </Transition>

            <!-- Email -->
            <div>
              <label class="block text-[9px] font-black uppercase tracking-[0.3em] text-slate-400 mb-3 ml-1">Alamat Email</label>
              <div class="relative group">
                <span class="absolute left-5 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-orange-500 transition-colors pointer-events-none">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                  </svg>
                </span>
                <input v-model="email" type="email" placeholder="name@email.com"
                  class="w-full bg-slate-50 border border-slate-200 rounded-[1.25rem] pl-14 pr-6 py-[1.125rem] outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 focus:bg-white hover:border-slate-300 transition-colors text-slate-900 font-semibold placeholder-slate-400 caret-orange-500" />
              </div>
            </div>

            <!-- Password -->
            <div>
              <label class="block text-[9px] font-black uppercase tracking-[0.3em] text-slate-400 mb-3 ml-1">Kata Sandi</label>
              <div class="relative group">
                <span class="absolute left-5 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-orange-500 transition-colors pointer-events-none">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                  </svg>
                </span>
                <input v-model="password" :type="showPassword ? 'text' : 'password'" placeholder="••••••••"
                  class="w-full bg-slate-50 border border-slate-200 rounded-[1.25rem] pl-14 pr-14 py-[1.125rem] outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 focus:bg-white hover:border-slate-300 transition-colors text-slate-900 font-semibold placeholder-slate-400 caret-orange-500" />
                
                <!-- Show/Hide Password Toggle -->
                <button type="button" @click="showPassword = !showPassword" class="absolute right-5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-orange-600 transition-colors">
                  <svg v-if="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                  </svg>
                  <svg v-else class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                  </svg>
                </button>
              </div>
              <div class="flex justify-end mt-3">
                <button v-if="isLogin" type="button" class="text-[9px] font-black uppercase tracking-widest text-orange-600 hover:text-orange-700 underline underline-offset-4 decoration-orange-200">
                  Lupa Kata Sandi?
                </button>
              </div>
            </div>

            <!-- Submit Button -->
            <button :disabled="loading" type="submit"
              class="w-full bg-slate-900 text-white py-5 rounded-[1.25rem] font-black tracking-[0.2em] uppercase text-[10px] hover:bg-orange-600 hover:shadow-[0_20px_50px_-10px_rgba(234,88,12,0.4)] transition-all duration-500 active:scale-[0.98] disabled:opacity-50 mt-6 overflow-hidden relative group">
              <div class="absolute inset-0 w-full h-full bg-gradient-to-r from-orange-600 to-amber-500 opacity-0 group-hover:opacity-100 transition-opacity"></div>
              <span class="relative z-10">
                {{ loading ? 'Memproses...' : (isLogin ? 'Masuk' : 'Daftar Sekarang') }}
              </span>
            </button>

            <!-- Divider -->
            <div class="relative flex items-center py-2">
              <div class="flex-grow border-t border-slate-100"></div>
              <span class="flex-shrink-0 mx-4 text-slate-400 text-[10px] font-bold uppercase tracking-widest">Atau</span>
              <div class="flex-grow border-t border-slate-100"></div>
            </div>

            <!-- Google Login Button -->
            <button @click="loginWithGoogle" type="button" class="w-full flex items-center justify-center gap-3 bg-white border border-slate-200 text-slate-700 py-4 rounded-[1.25rem] font-bold text-xs hover:bg-slate-50 hover:border-slate-300 hover:shadow-sm transition-all active:scale-[0.98]">
              <svg class="w-5 h-5" viewBox="0 0 24 24">
                <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
              </svg>
              Masuk dengan Google
            </button>

            <div class="pt-4 text-center">
              <p class="text-[11px] text-slate-400 font-bold uppercase tracking-widest">
                {{ isLogin ? "Belum punya akun?" : "Sudah punya akun?" }}
                <button type="button" @click="isLogin = !isLogin" class="ml-2 text-slate-900 hover:text-orange-600 transition-colors border-b-2 border-orange-100 hover:border-orange-600 pb-0.5">
                  {{ isLogin ? 'Daftar Sekarang' : 'Masuk Di Sini' }}
                </button>
              </p>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRouter, useRoute } from 'vue-router';

const router       = useRouter();
const route        = useRoute();
const isLogin      = ref(true);
const name         = ref('');
const email        = ref('');
const password     = ref('');
const showPassword = ref(false);
const loading      = ref(false);
const errorMessage = ref('');

const brandFeatures = [
  { label: 'Studio Didukung AI',        color: 'orange' },
  { label: 'Kolaborasi Real-time',    color: 'amber'  },
  { label: 'Uji Coba AR di Web',            color: 'orange' },
];

onMounted(async () => {
  // Tangkap callback dari Google OAuth (berupa query string parameter)
  const urlParams = new URLSearchParams(window.location.search);
  const token = urlParams.get('token');
  const error = urlParams.get('error');
  const role = urlParams.get('role');

  if (error) {
    errorMessage.value = error;
    // Bersihkan URL
    window.history.replaceState({}, document.title, window.location.pathname);
  } else if (token) {
    loading.value = true;
    try {
      // Ambil data user lengkap menggunakan token dari Google
      const res = await fetch('/api/v1/auth/me', {
        headers: {
          'Authorization': `Bearer ${token}`,
          'Accept': 'application/json'
        }
      });
      const data = await res.json();
      
      if (res.ok) {
        localStorage.setItem('token', token);
        localStorage.setItem('user', JSON.stringify(data.user));
        
        // Bersihkan URL parameter agar token tidak terlihat
        window.history.replaceState({}, document.title, window.location.pathname);

        // Redirect sesuai role
        if (role === 'admin')    return router.push('/admin/dashboard');
        if (role === 'umkm')     return router.push('/umkm/dashboard');
        if (role === 'desainer') return router.push('/designer/dashboard');
        router.push('/');
      } else {
        errorMessage.value = 'Gagal memverifikasi sesi Google.';
      }
    } catch (e) {
      errorMessage.value = 'Terjadi kesalahan jaringan saat verifikasi Google.';
    } finally {
      loading.value = false;
    }
  }
});

const loginWithGoogle = () => {
  // Arahkan browser ke backend Laravel yang akan redirect ke Google
  window.location.href = '/api/v1/auth/google';
};

const submit = async () => {
  loading.value      = true;
  errorMessage.value = '';

  try {
    // CSRF for Sanctum
    await fetch('/sanctum/csrf-cookie', { method: 'GET', credentials: 'same-origin' });

    const url     = isLogin.value ? '/api/v1/auth/login' : '/api/v1/auth/register';
    const payload = isLogin.value
      ? { email: email.value, password: password.value }
      : { name: name.value, email: email.value, password: password.value };

    const res  = await fetch(url, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
      body: JSON.stringify(payload),
      credentials: 'same-origin',
    });

    const data = await res.json();

    if (!res.ok) {
      if (data.errors) {
        const firstError = Object.values(data.errors)[0][0];
        errorMessage.value = firstError;
      } else {
        errorMessage.value = data.message || 'Authentication failed.';
      }
      return;
    }

    // Store session
    localStorage.setItem('user',  JSON.stringify(data.user));
    localStorage.setItem('token', data.token);

    // Role-based redirect
    const role = data.user?.role;
    if (role === 'admin')    return router.push('/admin/dashboard');
    if (role === 'umkm')     return router.push('/umkm/dashboard');
    if (role === 'desainer') return router.push('/designer/dashboard');
    router.push('/');

  } catch (err) {
    errorMessage.value = 'Terjadi kesalahan jaringan. Coba lagi.';
    console.error('Auth error:', err);
  } finally {
    loading.value = false;
  }
};

const goToLanding = () => router.push('/');
</script>

<style scoped>
.slide-fade-enter-active { transition: all 0.4s ease-out; }
.slide-fade-leave-active { transition: all 0.3s cubic-bezier(1, 0.5, 0.8, 1); }
.slide-fade-enter-from,
.slide-fade-leave-to     { transform: translateY(-20px); opacity: 0; }
</style>
