<template>
  <div class="min-h-[90vh] flex items-center justify-center p-6 bg-transparent">
    <div class="w-full max-w-5xl flex flex-col md:flex-row bg-white rounded-[2.5rem] overflow-hidden shadow-[0_20px_50px_rgba(0,0,0,0.05)] border border-slate-100 relative">
      
      <button 
        @click="goToLanding" 
        class="absolute top-6 left-6 z-20 flex items-center gap-2 text-[10px] font-bold uppercase tracking-widest text-white/70 hover:text-white transition-colors group md:left-auto md:right-auto md:top-8 md:text-slate-400 md:hover:text-orange-600"
      >
        <svg class="w-4 h-4 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Back to Home
      </button>

      <div class="w-full md:w-5/12 bg-slate-900 p-12 flex flex-col justify-between relative overflow-hidden pt-20 md:pt-12">
        <div class="absolute top-0 left-0 w-full h-full opacity-30 pointer-events-none">
          <div class="absolute -top-24 -left-24 w-64 h-64 bg-orange-600 rounded-full blur-[80px]"></div>
          <div class="absolute -bottom-24 -right-24 w-64 h-64 bg-amber-500 rounded-full blur-[80px]"></div>
        </div>

        <div class="relative z-10">
          <div class="flex items-center gap-3 mb-12">
            <div class="w-8 h-8 bg-gradient-to-tr from-orange-500 to-amber-400 rounded-lg shadow-lg"></div>
            <span class="text-white font-bold tracking-tight text-xl italic">SnapFit</span>
          </div>
          
          <h2 class="text-4xl font-bold text-white leading-tight mb-6">
            Crafting <br/><span class="text-orange-500">Excellence</span> <br/>Together.
          </h2>
          <p class="text-slate-400 text-sm leading-relaxed">
            Bergabunglah dengan komunitas UMKM terkurasi dan nikmati pengalaman berbelanja produk lokal dengan standar internasional.
          </p>
        </div>

        <div class="relative z-10 mt-12 pt-8 border-t border-white/10">
          <p class="text-[10px] uppercase tracking-[0.3em] text-slate-500 font-bold mb-4">Official Partner of Premium UMKM</p>
          <div class="flex gap-4 opacity-30 grayscale invert">
             <div class="h-4 w-12 bg-white/40 rounded"></div>
             <div class="h-4 w-16 bg-white/40 rounded"></div>
             <div class="h-4 w-10 bg-white/40 rounded"></div>
          </div>
        </div>
      </div>

      <div class="w-full md:w-7/12 p-8 md:p-16 bg-white flex items-center">
        <div class="max-w-sm mx-auto w-full">
          <div class="mb-10">
            <h3 class="text-3xl font-bold text-slate-900 mb-2 tracking-tight">
              {{ isLogin ? 'Sign In' : 'Join Us' }}
            </h3>
            <p class="text-slate-500 text-sm font-medium">
              {{ isLogin ? 'Selamat datang kembali! Masuk ke akun Anda.' : 'Mulai perjalanan Anda bersama produk terbaik.' }}
            </p>
          </div>

          <form class="space-y-5" @submit.prevent="submit">
            <div v-if="!isLogin">
              <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-2 ml-1">Identity</label>
              <input v-model="name" type="text" placeholder="Nama Lengkap" 
                class="w-full bg-slate-50 border border-slate-100 rounded-2xl px-5 py-4 outline-none focus:ring-4 focus:ring-orange-500/10 focus:border-orange-500 focus:bg-white transition-all text-slate-900" />
            </div>

            <div>
              <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-2 ml-1">Email Address</label>
              <input v-model="email" type="email" placeholder="name@domain.com"
                class="w-full bg-slate-50 border border-slate-100 rounded-2xl px-5 py-4 outline-none focus:ring-4 focus:ring-orange-500/10 focus:border-orange-500 focus:bg-white transition-all text-slate-900" />
            </div>

            <div>
              <div class="flex justify-between mb-2 ml-1">
                <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Password</label>
                <button v-if="isLogin" type="button" class="text-[10px] font-bold text-orange-600 hover:text-orange-700">Lupa sandi?</button>
              </div>
              <input v-model="password" type="password" placeholder="••••••••"
                class="w-full bg-slate-50 border border-slate-100 rounded-2xl px-5 py-4 outline-none focus:ring-4 focus:ring-orange-500/10 focus:border-orange-500 focus:bg-white transition-all text-slate-900" />
            </div>

            <button :disabled="loading" type="submit"
              class="w-full bg-slate-900 text-white py-4 rounded-2xl font-bold tracking-widest uppercase text-xs hover:bg-orange-600 hover:shadow-2xl hover:shadow-orange-600/30 transition-all duration-500 active:scale-95 disabled:opacity-50 mt-4">
              <span v-if="loading">Processing...</span>
              <span v-else>{{ isLogin ? 'Access Account' : 'Confirm Join' }}</span>
            </button>

            <div class="pt-8 text-center border-t border-slate-50">
              <p class="text-xs text-slate-400 font-medium">
                {{ isLogin ? "Belum memiliki akun?" : "Sudah menjadi anggota?" }}
                <button @click="isLogin = !isLogin" class="ml-1 font-bold text-slate-900 hover:text-orange-600 transition-colors underline underline-offset-8 decoration-orange-200">
                  {{ isLogin ? 'Daftar Sekarang' : 'Masuk Disini' }}
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
import { ref } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()
const isLogin = ref(true)
const name = ref('')
const email = ref('')
const password = ref('')
const loading = ref(false)
const errors = ref({})

const submit = async () => {
  loading.value = true
  errors.value = {}

  try {
    await fetch('/sanctum/csrf-cookie', { method: 'GET', credentials: 'same-origin' })
    
    const url = isLogin.value ? '/api/v1/auth/login' : '/api/v1/auth/register'
    const res = await fetch(url, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
      body: JSON.stringify({ name: name.value, email: email.value, password: password.value }),
      credentials: 'same-origin'
    })

    const data = await res.json()
    if (!res.ok) {
      errors.value = data.errors || { general: [data.message] }
      throw new Error(data.message)
    }

    localStorage.setItem('user', JSON.stringify(data.user))
    localStorage.setItem('token', data.token)
    router.push(data.user.role === 'admin' ? '/admin' : '/')
  } catch (err) {
    console.error('Auth Error:', err.message)
  } finally {
    loading.value = false
  }
}

const goToLanding = () => router.push('/')
</script>

<style scoped>
.fade-enter-active, .fade-leave-active { transition: all 0.4s ease; }
.fade-enter-from, .fade-leave-to { opacity: 0; transform: translateY(-10px); }
</style>