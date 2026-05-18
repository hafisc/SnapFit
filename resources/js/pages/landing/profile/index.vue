<template>
  <div class="min-h-screen bg-slate-50 font-sans">
    <!-- Menggunakan Navbar bawaan SnapFit -->
    <Navbar :user="user" />

    <div class="max-w-7xl mx-auto px-4 sm:px-6 py-8 pt-28 flex flex-col md:flex-row gap-6 md:gap-8">
      <!-- Sidebar -->
      <aside class="w-full md:w-72 flex-shrink-0 space-y-6">
        <!-- Profile Card -->
        <div class="bg-surface rounded-2xl p-6 border border-borderSoft shadow-sm">
          <div class="flex items-center gap-4 mb-4">
            <div class="w-14 h-14 bg-gradient-to-tr from-orange-600 to-amber-400 rounded-full flex items-center justify-center text-xl font-bold text-white shadow-lg shadow-terracotta/50/20 flex-shrink-0 overflow-hidden border border-terracotta/30">
              <img :src="userAvatar" alt="Avatar" class="w-full h-full object-cover" />
            </div>
            <div class="flex-1 min-w-0">
              <h3 class="text-espresso font-bold text-base truncate">{{ user?.name || 'User' }}</h3>
              
            </div>
          </div>
          <!-- Progress -->
          <div class="space-y-2">
            <div class="h-1.5 w-full bg-slate-100 rounded-full overflow-hidden">
              <div class="h-full bg-terracotta w-3/4 rounded-full"></div>
            </div>
            <p class="text-[10px] text-slate-400 font-semibold text-right">7/10 data profil terisi</p>
          </div>
        </div>

        <!-- Navigation Menu -->
        <div class="bg-surface rounded-2xl p-3 border border-borderSoft shadow-sm flex flex-col gap-1">
          <button v-for="menu in menus" :key="menu.id" 
            class="flex items-center gap-4 px-4 py-3.5 rounded-xl text-sm font-medium transition-colors text-left group"
            :class="activeMenu === menu.id ? 'bg-sand text-terracotta border border-terracotta/20' : 'text-muted hover:bg-slate-50 hover:text-espresso border border-transparent'"
            @click="activeMenu = menu.id"
          >
            <span v-html="menu.icon" class="transition-colors" :class="activeMenu === menu.id ? 'text-terracotta' : 'text-slate-400 group-hover:text-muted'"></span>
            {{ menu.label }}
          </button>
        </div>

        <!-- Logout Button -->
        <div class="bg-surface rounded-2xl p-3 border border-borderSoft shadow-sm">
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
        <div class="bg-sand border border-terracotta/20 rounded-xl p-4 flex gap-3 items-start mb-8">
          <svg class="w-5 h-5 text-terracotta flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
          <p class="text-sm font-medium text-orange-800">Lengkapi profil Anda untuk mendapatkan rekomendasi produk yang lebih sesuai dan kemudahan saat checkout di platform SnapFit.</p>
        </div>

        <!-- Form Area (Profil Saya) -->
        <div v-if="activeMenu === 'profile'" class="bg-surface rounded-[2rem] p-6 sm:p-10 border border-borderSoft shadow-sm">
          <div class="flex flex-col items-center mb-10">
            <div class="w-24 h-24 bg-gradient-to-tr from-orange-600 to-amber-400 rounded-full flex items-center justify-center text-4xl font-bold text-white shadow-xl shadow-terracotta/50/20 mb-4 relative group cursor-pointer border-4 border-white overflow-hidden">
              <img :src="userAvatar" alt="Avatar" class="w-full h-full object-cover" />
              <div class="absolute inset-0 bg-slate-900/40 rounded-full opacity-0 group-hover:opacity-100 flex items-center justify-center transition-opacity">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
              </div>
            </div>
            <button class="text-xs font-black uppercase tracking-widest text-slate-400 hover:text-terracotta transition-colors">Ubah Foto</button>
          </div>

          <form class="space-y-6 max-w-2xl mx-auto" @submit.prevent="updateProfile">
            <!-- Nama Lengkap -->
            <div class="flex flex-col md:flex-row md:items-center gap-2 md:gap-8">
              <label class="w-48 text-sm font-bold text-muted flex-shrink-0">Nama Lengkap</label>
              <input v-model="form.name" type="text" class="flex-1 bg-slate-50 border border-borderSoft rounded-xl px-5 py-3.5 text-sm text-espresso font-medium focus:outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition-all placeholder-slate-400" />
            </div>

            <!-- Email -->
            <div class="flex flex-col md:flex-row md:items-center gap-2 md:gap-8">
              <label class="w-48 text-sm font-bold text-muted flex-shrink-0">Email</label>
              <input v-model="form.email" type="email" readonly class="flex-1 bg-slate-100 border border-borderSoft rounded-xl px-5 py-3.5 text-sm text-slate-400 font-medium cursor-not-allowed" />
            </div>

            <!-- Jenis Kelamin -->
            <div class="flex flex-col md:flex-row md:items-center gap-2 md:gap-8">
              <label class="w-48 text-sm font-bold text-muted flex-shrink-0">Jenis Kelamin</label>
              <div class="flex-1 relative">
                <select v-model="form.gender" class="w-full bg-slate-50 border border-borderSoft rounded-xl px-5 py-3.5 text-sm text-espresso font-medium focus:outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition-all appearance-none cursor-pointer">
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
              <label class="w-48 text-sm font-bold text-muted flex-shrink-0">Tanggal Lahir</label>
              <input v-model="form.dob" type="date" class="flex-1 bg-slate-50 border border-borderSoft rounded-xl px-5 py-3.5 text-sm text-espresso font-medium focus:outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition-all cursor-pointer" />
            </div>

            

            

            <div class="pt-10 flex justify-end">
              <button :disabled="isSavingProfile" type="submit" class="bg-terracotta hover:bg-terracottaDark text-white font-bold py-3.5 px-8 rounded-xl transition-colors active:scale-[0.98] text-sm shadow-lg shadow-terracotta/50/20 disabled:opacity-50">
                {{ isSavingProfile ? 'Menyimpan...' : 'Simpan Perubahan' }}
              </button>
            </div>
          </form>
        </div>

        <!-- Role & Workspace -->
        <div v-else-if="activeMenu === 'roles'" class="bg-surface rounded-[2rem] p-6 sm:p-10 border border-borderSoft shadow-sm animate-fade-in">
          <h3 class="text-2xl font-bold text-espresso mb-2">Role & Workspace</h3>
          <p class="text-muted text-sm mb-8">Kelola role Anda dan akses ke berbagai workspace di SnapFit.</p>
          
          <RoleWorkspaceMenu />
        </div>

        <!-- Pesanan Saya -->
        <div v-else-if="activeMenu === 'orders'" class="bg-surface rounded-[2rem] p-6 sm:p-10 border border-borderSoft shadow-sm min-h-[400px] animate-fade-in">
          <div v-if="orders.length === 0" class="flex flex-col items-center justify-center text-center h-full pt-10">
            <div class="w-20 h-20 bg-sand rounded-full flex items-center justify-center text-terracotta mb-6 group hover:scale-110 transition-transform duration-300">
              <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg>
            </div>
            <h3 class="text-xl font-bold text-espresso mb-2">Belum ada pesanan</h3>
            <p class="text-muted max-w-sm mb-8 text-sm">Anda belum melakukan pemesanan apapun. Mari temukan karya UMKM dan desainer kreatif terbaik!</p>
            <button @click="router.push('/products')" class="bg-slate-900 text-white px-8 py-3.5 rounded-xl font-bold text-sm hover:bg-terracotta transition-all duration-300 shadow-lg shadow-slate-900/10 hover:shadow-terracotta/50/20 active:scale-[0.98]">Mulai Belanja</button>
          </div>
          <div v-else>
            <h3 class="text-2xl font-bold text-espresso mb-6">Riwayat Pesanan</h3>
            <div class="space-y-4">
              <div v-for="order in orders" :key="order.id" class="border border-borderSoft rounded-xl p-5 hover:border-orange-500 transition-colors bg-slate-50/50">
                <div class="flex justify-between items-center mb-4 border-b border-borderSoft pb-4">
                  <div>
                    <p class="text-[10px] text-slate-400 font-bold mb-1 uppercase tracking-widest">{{ new Date(order.created_at).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' }) }}</p>
                    <p class="text-sm font-bold text-espresso">{{ order.midtrans_order_id || `ORD-${order.id}` }}</p>
                  </div>
                  <div class="px-3 py-1.5 rounded-lg text-[10px] font-black uppercase tracking-widest"
                       :class="{
                         'bg-yellow-100 text-yellow-700': order.status === 'pending', 
                         'bg-green-100 text-green-700': order.status === 'paid' || order.status === 'completed', 
                         'bg-red-100 text-red-700': order.status === 'cancelled'
                       }">
                    {{ order.status }}
                  </div>
                </div>
                <div class="flex justify-between items-end">
                  <div>
                    <p class="text-xs font-semibold text-muted mb-1">{{ order.items?.length || 0 }} Produk</p>
                    <p class="font-black text-espresso text-lg">{{ formatPrice(order.total_amount) }}</p>
                  </div>
                  <button class="text-[11px] bg-surface border border-borderSoft text-espresso font-bold px-4 py-2 rounded-lg hover:bg-slate-50 hover:text-terracotta transition-colors">Detail Pesanan</button>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Keranjang -->
        <div v-else-if="activeMenu === 'cart'" class="bg-surface rounded-[2rem] p-6 sm:p-10 border border-borderSoft shadow-sm min-h-[400px] flex flex-col items-center justify-center text-center animate-fade-in">
          <div class="w-20 h-20 bg-amber-50 rounded-full flex items-center justify-center text-amber-500 mb-6 group hover:scale-110 transition-transform duration-300">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
          </div>
          <h3 class="text-xl font-bold text-espresso mb-2">Keranjang Anda kosong</h3>
          <p class="text-muted max-w-sm mb-8 text-sm">Kelihatannya Anda belum menambahkan apapun ke keranjang. Yuk cari inspirasi desain!</p>
          <button @click="router.push('/products')" class="bg-slate-900 text-white px-8 py-3.5 rounded-xl font-bold text-sm hover:bg-amber-500 transition-all duration-300 shadow-lg shadow-slate-900/10 hover:shadow-amber-500/20 active:scale-[0.98]">Cari Produk</button>
        </div>

        <!-- Wishlist -->
        <div v-else-if="activeMenu === 'wishlist'" class="bg-surface rounded-[2rem] p-6 sm:p-10 border border-borderSoft shadow-sm min-h-[400px] animate-fade-in">
          <div v-if="wishlists.length === 0" class="flex flex-col items-center justify-center text-center pt-10">
            <div class="w-20 h-20 bg-red-50 rounded-full flex items-center justify-center text-red-500 mb-6 group hover:scale-110 transition-transform duration-300">
              <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" /></svg>
            </div>
            <h3 class="text-xl font-bold text-espresso mb-2">Wishlist masih kosong</h3>
            <p class="text-muted max-w-sm mb-8 text-sm">Simpan produk atau desain favorit Anda di sini agar mudah ditemukan kembali nanti.</p>
            <button @click="router.push('/products')" class="bg-slate-900 text-white px-8 py-3.5 rounded-xl font-bold text-sm hover:bg-red-500 transition-all duration-300 shadow-lg shadow-slate-900/10 hover:shadow-red-500/20 active:scale-[0.98]">Eksplorasi Sekarang</button>
          </div>
          <div v-else>
            <h3 class="text-2xl font-bold text-espresso mb-6">Wishlist Tersimpan</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
              <div v-for="product in wishlists" :key="product.id" @click="router.push(`/products/${product.id}`)" class="group bg-surface border border-borderSoft rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 cursor-pointer flex flex-col">
                <div class="h-48 bg-slate-100 overflow-hidden relative">
                  <!-- Fallback to placeholder if parsing fails or no image -->
                  <img :src="(product.images && typeof product.images === 'string' && product.images.startsWith('[')) ? JSON.parse(product.images)[0] : (product.images || '/images/placeholder.png')" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" />
                  <div class="absolute top-3 right-3 w-8 h-8 bg-surface/90 backdrop-blur-sm rounded-full flex items-center justify-center text-red-500 shadow-sm group-hover:bg-red-500 group-hover:text-white transition-colors">
                    <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" /></svg>
                  </div>
                </div>
                <div class="p-5 flex flex-col flex-1">
                  <div class="flex items-center gap-2 mb-2 opacity-70">
                    <img :src="`https://api.dicebear.com/7.x/avataaars/svg?seed=${product.owner?.name || 'UMKM'}&backgroundColor=f1f5f9`" class="w-4 h-4 rounded-full" />
                    <p class="text-[10px] font-black uppercase tracking-widest text-muted">{{ product.owner?.profile?.full_name || product.owner?.name || 'UMKM' }}</p>
                  </div>
                  <h4 class="font-bold text-espresso leading-snug mb-1 line-clamp-2">{{ product.title }}</h4>
                  <div class="mt-auto pt-3 flex items-center justify-between">
                    <p class="text-terracotta font-black text-lg">{{ formatPrice(product.price) }}</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Pengaturan -->
        <div v-else-if="activeMenu === 'settings'" class="bg-surface rounded-[2rem] p-6 sm:p-10 border border-borderSoft shadow-sm animate-fade-in">
          <h3 class="text-2xl font-bold text-espresso mb-2">Pengaturan Akun</h3>
          <p class="text-muted text-sm mb-8">Kelola preferensi dan keamanan akun Anda.</p>
          
          <div class="space-y-2">
            <!-- Toggles -->
            <div class="flex items-center justify-between py-5 border-b border-borderSoft group">
              <div>
                <h4 class="font-bold text-espresso text-sm group-hover:text-terracotta transition-colors">Notifikasi Email</h4>
                <p class="text-xs text-muted mt-1">Terima email untuk pembaruan pesanan dan promo eksklusif.</p>
              </div>
              <label class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" class="sr-only peer" checked>
                <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-surface after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-terracotta"></div>
              </label>
            </div>
            
            <div class="flex items-center justify-between py-5 border-b border-borderSoft group">
              <div>
                <h4 class="font-bold text-espresso text-sm group-hover:text-terracotta transition-colors">Autentikasi Dua Faktor (2FA)</h4>
                <p class="text-xs text-muted mt-1">Amankan akun Anda dengan verifikasi dua langkah ekstra.</p>
              </div>
              <button class="text-xs font-bold text-terracotta bg-sand border border-terracotta/20 px-5 py-2.5 rounded-xl hover:bg-terracotta hover:text-white transition-all duration-300 active:scale-[0.98]">Aktifkan</button>
            </div>

            <!-- Danger Zone -->
            <div class="pt-8">
              <h4 class="font-bold text-red-600 text-sm mb-2 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                Zona Berbahaya
              </h4>
              <p class="text-xs text-muted mb-5">Setelah Anda menghapus akun, proses ini tidak dapat dibatalkan dan semua data akan hilang.</p>
              <button class="text-xs font-bold text-red-500 border border-red-200 bg-surface px-6 py-3 rounded-xl hover:bg-red-500 hover:text-white hover:border-red-500 transition-all duration-300 active:scale-[0.98]">Hapus Akun Permanen</button>
            </div>
          </div>
        </div>
      </main>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, watch } from 'vue';
import { useRouter } from 'vue-router';
import Navbar from '@/pages/landing/partials/Navbar.vue';
import RoleWorkspaceMenu from './RoleWorkspaceMenu.vue';

const router = useRouter();
const user = ref(null);
const activeMenu = ref('profile');

const form = ref({
  name: '',
  email: '',
  gender: 'Laki-laki',
  dob: '',
  city: ''
});

const orders = ref([]);
const wishlists = ref([]);
const isSavingProfile = ref(false);

const token = localStorage.getItem('token');

const formatPrice = (price) => {
  return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(price);
};

const fetchProfileData = async () => {
  if (!token) return router.push('/login');
  try {
    const res = await fetch('/api/v1/profile', {
      headers: { 'Authorization': `Bearer ${token}`, 'Accept': 'application/json' }
    });
    if (res.ok) {
      const data = await res.json();
      user.value = data.user;
      form.value.name = user.value.name || '';
      form.value.email = user.value.email || '';
      if (user.value.profile) {
        form.value.city = user.value.profile.address || '';
        form.value.gender = user.value.profile.gender || 'Laki-laki';
        // Date input needs YYYY-MM-DD
        if (user.value.profile.date_of_birth) {
          form.value.dob = new Date(user.value.profile.date_of_birth).toISOString().split('T')[0];
        }
      }
    }
  } catch (err) {
    console.error('Failed to fetch profile', err);
  }
};

const fetchOrders = async () => {
  try {
    const res = await fetch('/api/v1/orders', {
      headers: { 'Authorization': `Bearer ${token}`, 'Accept': 'application/json' }
    });
    if (res.ok) {
      const json = await res.json();
      orders.value = json.data;
    }
  } catch (err) {
    console.error('Failed to fetch orders', err);
  }
};

const fetchWishlists = async () => {
  try {
    const res = await fetch('/api/v1/wishlist', {
      headers: { 'Authorization': `Bearer ${token}`, 'Accept': 'application/json' }
    });
    if (res.ok) {
      const json = await res.json();
      wishlists.value = json.data;
    }
  } catch (err) {
    console.error('Failed to fetch wishlists', err);
  }
};

watch(activeMenu, (newVal) => {
  if (newVal === 'orders' && orders.value.length === 0) fetchOrders();
  if (newVal === 'wishlist' && wishlists.value.length === 0) fetchWishlists();
});

onMounted(() => {
  if (!token) {
    router.push('/login');
    return;
  }
  fetchProfileData();
});

const userAvatar = computed(() => {
  if (user.value?.profile?.avatar) {
    return user.value.profile.avatar;
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
    id: 'roles', 
    label: 'Role & Workspace',
    icon: `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" /></svg>`
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

const logout = async () => {
  try {
    const token = localStorage.getItem('token');
    if (token) {
      await fetch('/api/v1/auth/logout', {
        method: 'POST',
        headers: {
          'Authorization': `Bearer ${token}`,
          'Accept': 'application/json'
        }
      });
    }
  } catch (err) {
    console.error('Logout error:', err);
  } finally {
    localStorage.removeItem('token');
    localStorage.removeItem('user');
    window.location.href = '/';
  }
};

const updateProfile = async () => {
  isSavingProfile.value = true;
  try {
    const res = await fetch('/api/v1/profile', {
      method: 'PUT',
      headers: {
        'Authorization': `Bearer ${token}`,
        'Content-Type': 'application/json',
        'Accept': 'application/json'
      },
      body: JSON.stringify({
        full_name: form.value.name,
        address: form.value.city,
        gender: form.value.gender,
        date_of_birth: form.value.dob
      })
    });
    
    if (res.ok) {
      const data = await res.json();
      user.value = data.user;
      localStorage.setItem('user', JSON.stringify(data.user));
      alert('Profil berhasil diperbarui!');
    } else {
      alert('Gagal memperbarui profil.');
    }
  } catch (err) {
    alert('Terjadi kesalahan jaringan.');
  } finally {
    isSavingProfile.value = false;
  }
};
</script>

<style scoped>
.animate-fade-in {
  animation: fadeIn 0.4s ease-out forwards;
}

@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}
</style>
