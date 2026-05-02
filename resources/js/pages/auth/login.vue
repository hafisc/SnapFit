<template>
  <div class="min-h-screen flex items-center justify-center p-4 md:p-10 bg-[#FAFAFA] font-sans selection:bg-orange-100">
    <button
      @click="goToLanding"
      class="fixed top-8 left-8 z-50 flex items-center gap-3 text-[10px] font-black uppercase tracking-[0.3em] text-slate-400 hover:text-orange-600 transition-all group bg-white/50 backdrop-blur-md px-5 py-3 rounded-full border border-slate-100 shadow-sm"
    >
      <svg class="w-4 h-4 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
      </svg>
      Back to Home
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
            <div class="w-12 h-12 bg-gradient-to-tr from-orange-600 to-amber-400 rounded-2xl shadow-2xl shadow-orange-500/20 flex items-center justify-center rotate-3">
              <span class="text-white font-black text-2xl italic">S</span>
            </div>
            <div class="h-8 w-px bg-white/20"></div>
            <span class="text-white font-black tracking-tighter text-2xl italic">SnapFit.</span>
          </div>

          <h2 class="text-5xl font-black text-white leading-[1.1] mb-8 tracking-tighter">
            Where <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-400 to-amber-300 italic">Creativity</span> <br/>Meets Technology.
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
          <p class="text-[9px] uppercase tracking-[0.4em] text-slate-500 font-black mb-4">Trusted by Malang Creative Lab</p>
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
            <div class="flex items-center gap-2 mb-4">
              <span class="h-1 w-12 bg-orange-600 rounded-full"></span>
              <span class="text-[10px] font-black uppercase tracking-[0.3em] text-orange-600">Access Portal</span>
            </div>
            <h3 class="text-4xl font-black text-slate-900 mb-3 tracking-tighter uppercase italic">
              {{ isLogin ? 'Welcome Back' : 'Start Journey' }}
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
                <label class="block text-[9px] font-black uppercase tracking-[0.3em] text-slate-400 mb-3 ml-1">Full Identity</label>
                <div class="relative group">
                  <span class="absolute left-5 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-orange-500 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                  </span>
                  <input v-model="name" type="text" placeholder="John Doe"
                    class="w-full bg-slate-50 border border-slate-100 rounded-[1.25rem] pl-14 pr-6 py-[1.125rem] outline-none focus:ring-[6px] focus:ring-orange-500/5 focus:border-orange-500 focus:bg-white transition-all text-slate-900 font-semibold" />
                </div>
              </div>
            </Transition>

            <!-- Email -->
            <div>
              <label class="block text-[9px] font-black uppercase tracking-[0.3em] text-slate-400 mb-3 ml-1">Work Email</label>
              <div class="relative group">
                <span class="absolute left-5 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-orange-500 transition-colors">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                  </svg>
                </span>
                <input v-model="email" type="email" placeholder="name@domain.com"
                  class="w-full bg-slate-50 border border-slate-100 rounded-[1.25rem] pl-14 pr-6 py-[1.125rem] outline-none focus:ring-[6px] focus:ring-orange-500/5 focus:border-orange-500 focus:bg-white transition-all text-slate-900 font-semibold" />
              </div>
            </div>

            <!-- Password -->
            <div>
              <div class="flex justify-between mb-3 ml-1">
                <label class="text-[9px] font-black uppercase tracking-[0.3em] text-slate-400">Security Key</label>
                <button v-if="isLogin" type="button" class="text-[9px] font-black uppercase tracking-widest text-orange-600 hover:text-orange-700 underline underline-offset-4 decoration-orange-200">
                  Forgot Password?
                </button>
              </div>
              <div class="relative group">
                <span class="absolute left-5 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-orange-500 transition-colors">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                  </svg>
                </span>
                <input v-model="password" type="password" placeholder="••••••••"
                  class="w-full bg-slate-50 border border-slate-100 rounded-[1.25rem] pl-14 pr-6 py-[1.125rem] outline-none focus:ring-[6px] focus:ring-orange-500/5 focus:border-orange-500 focus:bg-white transition-all text-slate-900 font-semibold" />
              </div>
            </div>

            <!-- Submit Button -->
            <button :disabled="loading" type="submit"
              class="w-full bg-slate-900 text-white py-5 rounded-[1.25rem] font-black tracking-[0.2em] uppercase text-[10px] hover:bg-orange-600 hover:shadow-[0_20px_50px_-10px_rgba(234,88,12,0.4)] transition-all duration-500 active:scale-[0.98] disabled:opacity-50 mt-6 overflow-hidden relative group">
              <div class="absolute inset-0 w-full h-full bg-gradient-to-r from-orange-600 to-amber-500 opacity-0 group-hover:opacity-100 transition-opacity"></div>
              <span class="relative z-10">
                {{ loading ? 'Processing...' : (isLogin ? 'Access Account' : 'Initialize Profile') }}
              </span>
            </button>

            <div class="pt-6 text-center">
              <p class="text-[11px] text-slate-400 font-bold uppercase tracking-widest">
                {{ isLogin ? "New to the hub?" : "Already a member?" }}
                <button type="button" @click="isLogin = !isLogin" class="ml-2 text-slate-900 hover:text-orange-600 transition-colors border-b-2 border-orange-100 hover:border-orange-600 pb-0.5">
                  {{ isLogin ? 'Register Now' : 'Sign In Here' }}
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
import { ref } from 'vue';
import { useRouter } from 'vue-router';

const router       = useRouter();
const isLogin      = ref(true);
const name         = ref('');
const email        = ref('');
const password     = ref('');
const loading      = ref(false);
const errorMessage = ref('');

const brandFeatures = [
  { label: 'AI-Powered Studio',        color: 'orange' },
  { label: 'Real-time Co-Creation',    color: 'amber'  },
  { label: 'Web AR Try-On',            color: 'orange' },
];

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
