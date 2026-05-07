<template>
  <div class="min-h-screen bg-slate-50 font-sans">
    <!-- Menggunakan Navbar bawaan SnapFit -->
    <Navbar :user="user" />

    <div class="max-w-7xl mx-auto px-4 sm:px-6 py-8 pt-28 flex flex-col md:flex-row gap-6 md:gap-8">
      <!-- Sidebar -->
      <aside class="w-full md:w-72 flex-shrink-0 space-y-6">
        <!-- Profile Card -->
        <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm">
          <div class="flex items-center gap-4 mb-4">
            <div class="w-14 h-14 bg-gradient-to-tr from-orange-600 to-amber-400 rounded-full flex items-center justify-center text-xl font-bold text-white shadow-lg shadow-orange-500/20 flex-shrink-0 overflow-hidden border border-orange-200">
              <img :src="userAvatar" alt="Avatar" class="w-full h-full object-cover" />
            </div>
            <div class="flex-1 min-w-0">
              <h3 class="text-slate-900 font-bold text-base truncate">{{ user?.name || 'User' }}</h3>
              <p class="text-orange-600 font-black text-[10px] uppercase tracking-widest mt-1">Premium Member</p>
            </div>
          </div>
          <!-- Progress -->
          <div class="space-y-2">
            <div class="h-1.5 w-full bg-slate-100 rounded-full overflow-hidden">
              <div class="h-full bg-orange-500 w-3/4 rounded-full"></div>
            </div>
            <p class="text-[10px] text-slate-400 font-semibold text-right">7/10 data profil terisi</p>
          </div>
        </div>

        <!-- Navigation Menu -->
        <div class="bg-white rounded-2xl p-3 border border-slate-100 shadow-sm flex flex-col gap-1">
          <button v-for="menu in menus" :key="menu.id" 
            class="flex items-center gap-4 px-4 py-3.5 rounded-xl text-sm font-medium transition-colors text-left group"
            :class="activeMenu === menu.id ? 'bg-orange-50 text-orange-600 border border-orange-100' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900 border border-transparent'"
            @click="activeMenu = menu.id"
          >
            <span v-html="menu.icon" class="transition-colors" :class="activeMenu === menu.id ? 'text-orange-600' : 'text-slate-400 group-hover:text-slate-600'"></span>
            {{ menu.label }}
          </button>
        </div>

        <!-- Logout Button -->
        <div class="bg-white rounded-2xl p-3 border border-slate-100 shadow-sm">
          <button @click="logout" class="w-full flex items-center gap-4 px-4 py-3.5 rounded-xl text-sm font-bold text-red-500 hover:bg-red-50 transition-colors text-left group border border-transparent hover:border-red-100">
            <svg class="w-5 h-5 text-red-400 group-hover:text-red-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
            </svg>
            Keluar
          </button>
        </div>
      </aside>

      <!-- Main Content -->
      <main class="flex-1 min-w-0">
        <!-- Alert -->
        <div class="bg-orange-50 border border-orange-100 rounded-xl p-4 flex gap-3 items-start mb-8">
          <svg class="w-5 h-5 text-orange-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
          <p class="text-sm font-medium text-orange-800">Lengkapi profil Anda untuk mendapatkan rekomendasi produk yang lebih sesuai dan kemudahan saat checkout di platform SnapFit.</p>
        </div>

        <!-- Form Area -->
        <div class="bg-white rounded-[2rem] p-6 sm:p-10 border border-slate-100 shadow-sm">
          <div class="flex flex-col items-center mb-10">
            <div class="w-24 h-24 bg-gradient-to-tr from-orange-600 to-amber-400 rounded-full flex items-center justify-center text-4xl font-bold text-white shadow-xl shadow-orange-500/20 mb-4 relative group cursor-pointer border-4 border-white overflow-hidden">
              <img :src="userAvatar" alt="Avatar" class="w-full h-full object-cover" />
              <div class="absolute inset-0 bg-slate-900/40 rounded-full opacity-0 group-hover:opacity-100 flex items-center justify-center transition-opacity">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
              </div>
            </div>
            <button class="text-xs font-black uppercase tracking-widest text-slate-400 hover:text-orange-600 transition-colors">Ubah Foto</button>
          </div>

          <form class="space-y-6 max-w-2xl mx-auto" @submit.prevent="updateProfile">
            <!-- Nama Lengkap -->
            <div class="flex flex-col md:flex-row md:items-center gap-2 md:gap-8">
              <label class="w-48 text-sm font-bold text-slate-600 flex-shrink-0">Nama Lengkap</label>
              <input v-model="form.name" type="text" class="flex-1 bg-slate-50 border border-slate-200 rounded-xl px-5 py-3.5 text-sm text-slate-900 font-medium focus:outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition-all placeholder-slate-400" />
            </div>

            <!-- Email -->
            <div class="flex flex-col md:flex-row md:items-center gap-2 md:gap-8">
              <label class="w-48 text-sm font-bold text-slate-600 flex-shrink-0">Email</label>
              <input v-model="form.email" type="email" readonly class="flex-1 bg-slate-100 border border-slate-200 rounded-xl px-5 py-3.5 text-sm text-slate-400 font-medium cursor-not-allowed" />
            </div>

            <!-- Jenis Kelamin -->
            <div class="flex flex-col md:flex-row md:items-center gap-2 md:gap-8">
              <label class="w-48 text-sm font-bold text-slate-600 flex-shrink-0">Jenis Kelamin</label>
              <div class="flex-1 relative">
                <select v-model="form.gender" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-5 py-3.5 text-sm text-slate-900 font-medium focus:outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition-all appearance-none cursor-pointer">
                  <option value="Laki-laki">Laki-laki</option>
                  <option value="Perempuan">Perempuan</option>
                  <option value="Lainnya">Lainnya</option>
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none">
                  <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                </div>
              </div>
            </div>

            <!-- Tanggal Lahir -->
            <div class="flex flex-col md:flex-row md:items-center gap-2 md:gap-8">
              <label class="w-48 text-sm font-bold text-slate-600 flex-shrink-0">Tanggal Lahir</label>
              <input v-model="form.dob" type="date" class="flex-1 bg-slate-50 border border-slate-200 rounded-xl px-5 py-3.5 text-sm text-slate-900 font-medium focus:outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition-all cursor-pointer" />
            </div>

            

            <!-- Kota Asal -->
            <div class="flex flex-col md:flex-row md:items-center gap-2 md:gap-8">
              <label class="w-48 text-sm font-bold text-slate-600 flex-shrink-0">Kota Asal</label>
              <input v-model="form.city" type="text" placeholder="Pilih kota asal" class="flex-1 bg-slate-50 border border-slate-200 rounded-xl px-5 py-3.5 text-sm text-slate-900 font-medium focus:outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition-all placeholder-slate-400" />
            </div>

            <div class="pt-10 flex justify-end">
              <button type="submit" class="bg-orange-600 hover:bg-orange-700 text-white font-bold py-3.5 px-8 rounded-xl transition-colors active:scale-[0.98] text-sm shadow-lg shadow-orange-500/20">
                Simpan Perubahan
              </button>
            </div>
          </form>
        </div>
      </main>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import Navbar from '@/components/common/Navbar.vue';

const router = useRouter();
const user = ref(null);
const activeMenu = ref('profile');

const form = ref({
  name: '',
  email: '',
  gender: 'Laki-laki',
  dob: '',
  occupation: 'Mahasiswa',
  education: 'S1',
  city: ''
});

onMounted(() => {
  const storedUser = localStorage.getItem('user');
  if (storedUser) {
    user.value = JSON.parse(storedUser);
    form.value.name = user.value.name || '';
    form.value.email = user.value.email || '';
    if (user.value.profile) {
      form.value.city = user.value.profile.address || '';
    }
  } else {
    router.push('/login');
  }
});

const userAvatar = computed(() => {
  if (user.value?.avatar) {
    return user.value.avatar;
  }
  return `https://api.dicebear.com/7.x/avataaars/svg?seed=${user.value?.name || 'User'}&scale=130&backgroundColor=ffdfbf,c0aede,d1d4f9`;
});

const menus = [
  { 
    id: 'profile', 
    label: 'Profil Saya',
    icon: `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>`
  },
  { 
    id: 'orders', 
    label: 'Pesanan Saya',
    icon: `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" /></svg>`
  },
  { 
    id: 'cart', 
    label: 'Keranjang',
    icon: `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" /></svg>`
  },
  { 
    id: 'wishlist', 
    label: 'Wishlist',
    icon: `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" /></svg>`
  },
  { 
    id: 'settings', 
    label: 'Pengaturan',
    icon: `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>`
  }
];

const logout = () => {
  localStorage.removeItem('token');
  localStorage.removeItem('user');
  router.push('/login');
};

const updateProfile = () => {
  alert('Profil berhasil diperbarui!');
};
</script>

<style scoped>
/* Optional styling */
</style>
