<template>
  <div class="min-h-screen bg-white text-slate-900 font-sans selection:bg-orange-100 overflow-x-hidden">
    <Navbar
      :user="user"
      @logout="logout"
      @goToLogin="goToLogin"
      @goToProfile="goToProfile"
      @goToOrders="goToOrders"
    />

    <main class="pt-20 pb-24">
      <div class="max-w-[1400px] mx-auto px-6">
        <div class="mb-10 flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
          <div>
            <p class="text-sm font-black uppercase tracking-[0.25em] text-orange-600 mb-2">Wishlist</p>
            <h1 class="text-4xl font-black text-slate-900">Produk Favorit Saya</h1>
            <p class="mt-3 text-slate-600 max-w-2xl">Semua produk yang sudah kamu simpan akan ditampilkan di sini. Tambahkan ke keranjang atau hapus favorit kapan saja.</p>
          </div>
          <button @click="browseMarketplace" class="inline-flex items-center gap-2 rounded-3xl bg-orange-600 px-6 py-3 text-sm font-black uppercase tracking-[0.16em] text-white shadow-lg shadow-orange-200/50 hover:bg-orange-700 transition-all">
            Telusuri Marketplace
          </button>
        </div>

        <div v-if="isLoading" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
          <div v-for="i in 6" :key="i" class="animate-pulse rounded-3xl bg-gray-100 p-6 h-80"></div>
        </div>

        <div v-else-if="wishlistStore.count === 0" class="rounded-3xl border border-dashed border-orange-200 bg-orange-50 p-12 text-center">
          <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-orange-100 text-orange-600 mb-6">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
            </svg>
          </div>
          <h2 class="text-3xl font-black text-slate-900 mb-3">Belum ada item favorit</h2>
          <p class="text-slate-600 mb-6">Tambahkan produk ke wishlist dan temukan kembali nanti dengan mudah.</p>
          <button @click="browseMarketplace" class="inline-flex items-center gap-2 rounded-3xl bg-orange-600 px-6 py-3 text-sm font-black uppercase tracking-[0.16em] text-white hover:bg-orange-700 transition-all">Mulai Belanja</button>
        </div>

        <div v-else class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
          <div v-for="item in wishlistStore.items" :key="item.product_id || item.id" class="rounded-[2rem] bg-white border border-gray-100 shadow-sm overflow-hidden">
            <img
              :src="item.product?.images?.[0] || item.product?.image || 'https://images.unsplash.com/photo-1617627143750-d86bc21e42bb?q=80&w=1000'"
              :alt="item.product?.name"
              class="h-64 w-full object-cover"
            />
            <div class="p-6 flex flex-col gap-4">
              <div>
                <p class="text-xs uppercase tracking-[0.25em] text-orange-600 font-black mb-2">{{ item.product?.category || 'Marketplace' }}</p>
                <h2 class="text-xl font-black text-slate-900 leading-tight">{{ item.product?.name || 'Produk Favorit' }}</h2>
              </div>
              <div class="flex items-center justify-between gap-4">
                <p class="text-2xl font-black text-orange-600">Rp {{ formatCurrency(item.product?.price) }}</p>
                <span class="text-xs font-bold uppercase tracking-[0.2em] text-slate-400">{{ item.product?.stock ? 'In Stock' : 'Preorder' }}</span>
              </div>
              <div class="flex flex-col gap-3 sm:flex-row">
                <button @click="addToCart(item.product)" class="flex-1 rounded-3xl bg-orange-600 px-5 py-3 text-sm font-black uppercase tracking-[0.16em] text-white hover:bg-orange-700 transition-all">Tambah ke Keranjang</button>
                <button @click="removeFromWishlist(item.product_id)" class="flex-1 rounded-3xl border border-slate-200 bg-white px-5 py-3 text-sm font-black uppercase tracking-[0.16em] text-slate-700 hover:border-orange-300 hover:text-orange-600 transition-all">Hapus</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import { useCartStore } from '@/stores/cartStore';
import { useWishlistStore } from '@/stores/wishlistStore';
import { useNotificationStore } from '@/stores/notificationStore';
import Navbar from '@/components/common/Navbar.vue';

const router = useRouter();
const wishlistStore = useWishlistStore();
const cartStore = useCartStore();
const notificationStore = useNotificationStore();
const user = ref(null);
const isLoading = ref(true);

const formatCurrency = (value) => {
  const number = Number(value ?? 0);
  return number.toLocaleString('id-ID');
};

const loadWishlist = async () => {
  isLoading.value = true;
  await wishlistStore.loadWishlist();
  isLoading.value = false;
};

const addToCart = async (product) => {
  if (!product) return;
  await cartStore.addItem(product, 1);
  notificationStore.success('Berhasil menambahkan produk ke keranjang', 3000, 'Success');
};

const removeFromWishlist = async (productId) => {
  await wishlistStore.removeItem(productId);
};

const browseMarketplace = () => {
  router.push('/marketplace');
};

const goToLogin = () => router.push('/login');
const goToProfile = () => console.log('Navigate to profile');
const goToOrders = () => router.push('/marketplace/orders');
const logout = () => {
  localStorage.removeItem('user');
  localStorage.removeItem('token');
  user.value = null;
  router.push('/');
};

onMounted(() => {
  const stored = localStorage.getItem('user');
  if (stored) user.value = JSON.parse(stored);
  loadWishlist();
});
</script>
