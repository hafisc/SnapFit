<template>
  <div class="min-h-screen flex flex-col md:justify-center md:items-center p-0 md:p-10 bg-[#2B1E16] md:bg-[#FAFAFA] font-sans selection:bg-sand">
    <!-- Back Button: absolute on mobile inside the dark header, fixed on desktop -->
    <button @click="goToLanding"
      class="absolute md:fixed top-6 left-6 md:top-8 md:left-8 z-50 flex items-center gap-2 md:gap-3 text-[10px] font-black uppercase tracking-[0.3em] text-white/80 md:text-slate-400 hover:text-[#D4AF37] md:hover:text-terracotta transition-all group bg-white/10 md:bg-surface/50 backdrop-blur-md px-4 py-2.5 md:px-5 md:py-3 rounded-full border border-white/10 md:border-borderSoft shadow-sm">
      <svg class="w-4 h-4 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor"
        viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
      </svg>
      Kembali ke Beranda
    </button>

    <div
      class="w-full max-w-4xl flex flex-col md:flex-row bg-[#2B1E16] md:bg-surface md:rounded-[3rem] overflow-hidden md:shadow-[0_30px_80px_-15px_rgba(0,0,0,0.06)] md:border md:border-white min-h-screen md:min-h-0">
      <!-- Left Branding Panel (Hidden on small screens) -->
      <div
        class="hidden md:flex w-full md:w-[45%] bg-[#2B1E16] p-8 md:p-12 flex-col justify-between relative overflow-hidden">
        
        <!-- Full Screen Batik Background -->
        <div class="absolute inset-0 bg-cover bg-left bg-no-repeat opacity-[0.08] pointer-events-none" 
             style="background-image: url('/assets/batik-bg.png');">
        </div>

        <div class="relative z-10">
          <div class="flex items-center gap-4 mb-16">
            <div
              class="w-12 h-12 rounded-xl overflow-hidden shadow-sm border border-white/10 transform group-hover:scale-105 transition-all duration-300 flex items-center justify-center bg-white">
              <img :src="'/images/logo_snapfit.png'" alt="SnapFit Logo" class="w-full h-full object-contain p-1.5" />
            </div>
            <div class="h-8 w-px bg-white/20"></div>
            <span class="text-white font-black tracking-tighter text-2xl">SnapFit.</span>
          </div>

          <h2 class="text-3xl lg:text-4xl font-black text-white leading-[1.2] mb-6 tracking-tight">
            Kreativitas Lokal, <br />
            <span class="text-gold">Naik Kelas</span> <br />
            Lewat Teknologi.
          </h2>

          <div class="space-y-4">
            <div v-for="feat in brandFeatures" :key="feat.label" class="flex items-center gap-3 text-white/70">
              <div class="w-5 h-5 rounded-full bg-[#B85C38]/20 flex items-center justify-center flex-shrink-0">
                <div class="w-1.5 h-1.5 bg-[#B85C38] rounded-full"></div>
              </div>
              <p class="text-xs font-bold uppercase tracking-widest">{{ feat.label }}</p>
            </div>
          </div>
        </div>

        <div class="relative z-10 mt-20 pt-10 border-t border-white/10">
          <div class="flex flex-wrap gap-x-6 gap-y-3 opacity-80">
            <div class="flex items-center gap-2">
              <svg class="w-4 h-4 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
              <span class="text-[10px] font-bold tracking-wider text-white">500+ UMKM KREATIF</span>
            </div>
            <div class="flex items-center gap-2">
              <svg class="w-4 h-4 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
              <span class="text-[10px] font-bold tracking-wider text-white">AI STUDIO READY</span>
            </div>
            <div class="flex items-center gap-2">
              <svg class="w-4 h-4 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
              <span class="text-[10px] font-bold tracking-wider text-white">AR TRY-ON SUPPORT</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Mobile Branding Panel (Visible only on mobile) -->
      <div class="md:hidden w-full bg-[#2B1E16] pt-20 pb-14 px-8 flex flex-col justify-center items-center text-center relative overflow-hidden">
        <!-- Full Screen Batik Background -->
        <div class="absolute inset-0 bg-cover bg-left bg-no-repeat opacity-[0.08] pointer-events-none" 
             style="background-image: url('/assets/batik-bg.png');">
        </div>

        <!-- Content -->
        <div class="relative z-10 flex flex-col items-center">
          <div class="w-12 h-12 rounded-xl overflow-hidden shadow-sm border border-white/10 mb-4 flex items-center justify-center bg-white">
            <img :src="'/images/logo_snapfit.png'" alt="SnapFit Logo" class="w-full h-full object-contain p-1.5" />
          </div>
          <h2 class="text-xl sm:text-2xl font-black text-white leading-snug tracking-tight">
            Kreativitas Lokal, <span class="text-gold">Naik Kelas</span> <br/> Lewat Teknologi.
          </h2>
        </div>
      </div>

      <!-- Right Form Panel -->
      <div class="w-full md:w-[55%] bg-[#FFFCF7] flex items-center relative rounded-t-[2.5rem] -mt-6 md:-mt-0 z-20 px-6 py-10 sm:p-10 md:p-12 shadow-[0_-15px_30px_rgba(0,0,0,0.04)] md:shadow-none flex-grow">
        <div class="max-w-md mx-auto w-full">
          
          <div class="mb-8 md:mb-10 text-center md:text-left">
            <h3 class="text-2xl font-black text-[#2B1E16] mb-2 tracking-tight">
              {{ isLogin ? 'Selamat Datang Kembali' : 'Mulai Perjalanan Kreatif Anda' }}
            </h3>
            <p class="text-[#6F6259] text-[13px] font-medium leading-relaxed">
              {{ isLogin
                ? 'Masuk untuk mengelola pesanan, toko, studio AI, dan kolaborasi kreatif Anda.'
                : 'Daftar sebagai pembeli terlebih dahulu, lalu buka toko atau bergabung sebagai designer setelah login.' }}
            </p>
          </div>

          <!-- Error Alert -->
          <div v-if="errorMessage" class="mb-6 px-5 py-4 bg-red-50 border border-red-100 rounded-2xl">
            <p class="text-xs font-bold text-red-600">{{ errorMessage }}</p>
          </div>

          <form class="space-y-4" @submit.prevent="submit">
            <!-- Name (Register only) -->
            <Transition name="slide-fade">
              <div v-if="!isLogin">
                <label class="block text-[10px] font-bold uppercase tracking-wider text-[#6F6259] mb-1.5 ml-1">Nama
                  Lengkap</label>
                <div class="relative group">
                  <span
                    class="absolute left-4 top-1/2 -translate-y-1/2 text-[#E8DCCB] group-focus-within:text-[#B85C38] transition-colors pointer-events-none">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                  </span>
                  <input v-model="name" type="text" placeholder="Nama Lengkap"
                    class="w-full bg-[#FFFCF7] border border-[#E8DCCB] rounded-xl pl-11 pr-5 py-3 text-sm outline-none focus:ring-[3px] focus:ring-[#B85C38]/10 focus:border-[#B85C38] hover:border-[#B85C38]/50 transition-all text-[#2B1E16] font-medium placeholder-[#6F6259]/50 shadow-sm" />
                </div>
              </div>
            </Transition>

            <!-- Email -->
            <div>
              <label class="block text-[10px] font-bold uppercase tracking-wider text-[#6F6259] mb-1.5 ml-1">Alamat
                Email</label>
              <div class="relative group">
                <span
                  class="absolute left-4 top-1/2 -translate-y-1/2 text-[#E8DCCB] group-focus-within:text-[#B85C38] transition-colors pointer-events-none">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-width="2"
                      d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                  </svg>
                </span>
                <input v-model="email" type="email" placeholder="name@email.com"
                  class="w-full bg-[#FFFCF7] border border-[#E8DCCB] rounded-xl pl-11 pr-5 py-3 text-sm outline-none focus:ring-[3px] focus:ring-[#B85C38]/10 focus:border-[#B85C38] hover:border-[#B85C38]/50 transition-all text-[#2B1E16] font-medium placeholder-[#6F6259]/50 shadow-sm" />
              </div>
            </div>

            <!-- Password -->
            <div>
              <label class="block text-[10px] font-bold uppercase tracking-wider text-[#6F6259] mb-1.5 ml-1">Kata
                Sandi</label>
              <div class="relative group">
                <span
                  class="absolute left-4 top-1/2 -translate-y-1/2 text-[#E8DCCB] group-focus-within:text-[#B85C38] transition-colors pointer-events-none">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-width="2"
                      d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                  </svg>
                </span>
                <input v-model="password" :type="showPassword ? 'text' : 'password'" placeholder="••••••••"
                  class="w-full bg-[#FFFCF7] border border-[#E8DCCB] rounded-xl pl-11 pr-11 py-3 text-sm outline-none focus:ring-[3px] focus:ring-[#B85C38]/10 focus:border-[#B85C38] hover:border-[#B85C38]/50 transition-all text-[#2B1E16] font-medium placeholder-[#6F6259]/50 shadow-sm" />

                <!-- Show/Hide Password Toggle -->
                <button type="button" @click="showPassword = !showPassword"
                  class="absolute right-3 top-1/2 -translate-y-1/2 text-[#6F6259]/70 hover:text-[#B85C38] transition-colors p-1">
                  <svg v-if="!showPassword" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                  </svg>
                  <svg v-else class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                  </svg>
                </button>
              </div>
              <div class="flex justify-end mt-2">
                <button v-if="isLogin" type="button"
                  class="text-[10px] font-bold tracking-wide text-[#B85C38] hover:text-[#9E4B2E] transition-colors underline decoration-[#B85C38]/30 underline-offset-4">
                  Lupa Kata Sandi?
                </button>
              </div>
            </div>

            <!-- Submit Button -->
            <button :disabled="loading" type="submit"
              class="w-full bg-[#B85C38] text-white py-3.5 rounded-xl font-black tracking-wide text-xs hover:bg-[#9E4B2E] hover:shadow-[0_10px_20px_-10px_rgba(184,92,56,0.5)] transition-all duration-300 hover:-translate-y-0.5 active:translate-y-0 active:scale-[0.98] disabled:opacity-50 mt-4 overflow-hidden relative group">
              <span class="relative z-10 flex items-center justify-center gap-2">
                {{ loading ? 'Memproses...' : (isLogin ? 'Masuk' : 'Daftar') }}
                <svg v-if="!loading" class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
              </span>
            </button>
            
            <!-- Info Card for Register -->
            <Transition name="slide-fade">
              <div v-if="!isLogin" class="mt-4 p-4 bg-[#F8F1E7] border border-[#E8DCCB] rounded-xl flex items-start gap-3">
                <svg class="w-5 h-5 text-[#B85C38] flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                <p class="text-xs text-[#6F6259] leading-relaxed font-medium">
                  Akun baru otomatis terdaftar sebagai pembeli.<br/>
                  Setelah login, Anda bisa <span class="font-bold text-[#2B1E16]">membuka toko UMKM</span> atau <span class="font-bold text-[#2B1E16]">bergabung sebagai designer</span>.
                </p>
              </div>
            </Transition>

            <!-- Divider -->
            <div class="relative flex items-center py-2">
              <div class="flex-grow border-t border-borderSoft"></div>
              <span
                class="flex-shrink-0 mx-4 text-slate-400 text-[10px] font-bold uppercase tracking-widest">Atau</span>
              <div class="flex-grow border-t border-borderSoft"></div>
            </div>

            <!-- Google Login Button -->
            <button @click="loginWithGoogle" type="button"
              class="w-full flex items-center justify-center gap-3 bg-[#FFFCF7] border border-[#E8DCCB] text-[#2B1E16] py-3 rounded-xl font-bold text-xs hover:bg-[#F8F1E7] hover:border-[#B85C38]/30 transition-all hover:-translate-y-0.5 active:translate-y-0 active:scale-[0.98]">
              <svg class="w-4 h-4" viewBox="0 0 24 24">
                <path
                  d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"
                  fill="#4285F4" />
                <path
                  d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"
                  fill="#34A853" />
                <path
                  d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"
                  fill="#FBBC05" />
                <path
                  d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"
                  fill="#EA4335" />
              </svg>
              Lanjutkan dengan Google
            </button>

            <div class="pt-4 text-center">
              <p class="text-[11px] text-slate-400 font-bold uppercase tracking-widest">
                {{ isLogin ? "Belum punya akun?" : "Sudah punya akun?" }}
                <button type="button" @click="isLogin = !isLogin"
                  class="ml-2 text-[#2B1E16] font-black hover:text-[#B85C38] transition-colors border-b-2 border-[#B85C38]/20 hover:border-[#B85C38] pb-0.5">
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

const router = useRouter();
const route = useRoute();
const isLogin = ref(true);
const name = ref('');
const email = ref('');
const password = ref('');
const showPassword = ref(false);
const loading = ref(false);
const errorMessage = ref('');

const brandFeatures = [
  { label: 'AI Product Studio' },
  { label: 'AR Try-On Experience' },
  { label: 'Kolaborasi Designer Real-time' },
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

        // Redirect ke redirect query jika ada, jika tidak sesuai role
        const redirectPath = route.query.redirect;
        if (redirectPath) return router.push(redirectPath);

        if (role === 'admin') return router.push('/admin/dashboard');
        if (role === 'umkm') return router.push('/umkm/dashboard');
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
  loading.value = true;
  errorMessage.value = '';

  try {
    // CSRF for Sanctum
    await fetch('/sanctum/csrf-cookie', { method: 'GET', credentials: 'same-origin' });

    const url = isLogin.value ? '/api/v1/auth/login' : '/api/v1/auth/register';
    const payload = isLogin.value
      ? { email: email.value, password: password.value }
      : { name: name.value, email: email.value, password: password.value };

    const res = await fetch(url, {
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
    localStorage.setItem('user', JSON.stringify(data.user));
    localStorage.setItem('token', data.token);

    // Redirect ke redirect query jika ada, jika tidak sesuai role
    const redirectPath = route.query.redirect;
    if (redirectPath) return router.push(redirectPath);

    const role = data.user?.role;
    if (role === 'admin') return router.push('/admin/dashboard');
    if (role === 'umkm') return router.push('/umkm/dashboard');
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
.slide-fade-enter-active {
  transition: all 0.4s ease-out;
}

.slide-fade-leave-active {
  transition: all 0.3s cubic-bezier(1, 0.5, 0.8, 1);
}

.slide-fade-enter-from,
.slide-fade-leave-to {
  transform: translateY(-20px);
  opacity: 0;
}
</style>
