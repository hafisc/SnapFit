<template>
  <div class="w-full space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white p-6 rounded-2xl border border-[#E8DCCB]/60">
      <div>
        <h2 class="text-lg font-bold text-[#2B1E16]">Produk Saya</h2>
        <p class="text-[11px] text-[#8A7A6C] mt-0.5">Kelola katalog produk yang tampil di marketplace SnapFit.</p>
      </div>
      <div class="flex items-center gap-2.5">
        <router-link to="/umkm/studio" class="px-4 py-2.5 bg-[#F8F1E7] text-[#B85C38] rounded-xl text-[12px] font-bold hover:bg-[#B85C38]/10 transition-colors flex items-center gap-1.5">
          <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" /></svg>
          AI Studio
        </router-link>
        <router-link to="/umkm/products/create" class="px-4 py-2.5 bg-[#2B1E16] hover:bg-[#B85C38] text-white rounded-xl text-[12px] font-bold transition-colors flex items-center gap-1.5">
          <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" /></svg>
          Tambah Produk
        </router-link>
      </div>
    </div>

    <!-- Loading -->
    <div v-if="loading" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
      <div v-for="i in 4" :key="i" class="bg-white rounded-2xl p-4 border border-[#E8DCCB]/60 animate-pulse">
        <div class="w-full h-44 bg-[#F8F1E7] rounded-xl mb-4"></div>
        <div class="h-3 w-3/4 bg-[#F8F1E7] rounded mb-2"></div>
        <div class="h-3 w-1/2 bg-[#F8F1E7] rounded"></div>
      </div>
    </div>

    <!-- Empty State -->
    <div v-else-if="products.length === 0" class="bg-white rounded-2xl border border-[#E8DCCB]/60 py-16 text-center">
      <div class="w-16 h-16 bg-[#F8F1E7] rounded-2xl flex items-center justify-center mx-auto mb-4">
        <svg class="w-7 h-7 text-[#B85C38]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
      </div>
      <h3 class="text-base font-bold text-[#2B1E16] mb-1.5">Belum ada produk di toko Anda</h3>
      <p class="text-[12px] text-[#8A7A6C] max-w-sm mx-auto mb-6">Mulai unggah produk pertama dan gunakan AI Product Studio agar katalog terlihat lebih profesional di marketplace.</p>
      <div class="flex items-center justify-center gap-3">
        <router-link to="/umkm/products/create" class="px-5 py-2.5 bg-[#2B1E16] hover:bg-[#B85C38] text-white rounded-xl text-[12px] font-bold transition-colors">
          Tambah Produk
        </router-link>
        <router-link to="/umkm/studio" class="px-5 py-2.5 bg-[#F8F1E7] text-[#B85C38] rounded-xl text-[12px] font-bold hover:bg-[#B85C38]/10 transition-colors">
          Gunakan AI Studio
        </router-link>
      </div>
    </div>

    <!-- Product Grid -->
    <div v-else class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-4 xl:grid-cols-5 gap-4">
      <div v-for="product in products" :key="product.id" class="bg-white rounded-2xl border border-[#E8DCCB]/60 overflow-hidden group hover:shadow-lg hover:border-[#E8DCCB] transition-all duration-200 max-w-[220px] w-full">
        <!-- Image -->
        <div class="relative aspect-[4/5] w-full bg-[#F8F1E7] overflow-hidden">
          <img :src="getProductImage(product)" :alt="product.name" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
          
          <!-- Actions overlay -->
          <div class="absolute top-3 right-3 flex gap-1.5 opacity-0 group-hover:opacity-100 transition-opacity">
            <button @click="togglePublish(product.id)" class="w-7 h-7 rounded-lg flex items-center justify-center shadow-md transition-colors"
              :class="product.is_published ? 'bg-[#0F8A4B] text-white' : 'bg-white/90 text-[#8A7A6C]'" :title="product.is_published ? 'Batalkan Publikasi' : 'Publikasikan'">
              <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
            </button>
            <router-link :to="`/umkm/products/edit/${product.id}`" class="w-7 h-7 rounded-lg bg-white/90 text-[#2B1E16] flex items-center justify-center shadow-md hover:bg-white transition-colors" title="Edit">
              <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
            </router-link>
            <button @click="deleteProduct(product.id)" class="w-7 h-7 rounded-lg bg-[#D94A38] text-white flex items-center justify-center shadow-md hover:bg-red-600 transition-colors" title="Hapus">
              <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
            </button>
          </div>

          <!-- Status badge -->
          <div class="absolute bottom-3 left-3">
            <span class="px-2.5 py-1 text-[9px] font-bold uppercase tracking-wider rounded-lg shadow-sm"
              :class="product.is_published ? 'bg-[#0F8A4B]/90 text-white' : 'bg-white/90 text-[#8A7A6C]'">
              {{ product.is_published ? 'Dipublikasikan' : 'Draf' }}
            </span>
          </div>
        </div>

        <!-- Info -->
        <div class="p-4">
          <p class="text-[10px] text-[#B85C38] font-bold uppercase tracking-wider mb-1">{{ product.category }}</p>
          <h3 class="font-semibold text-[#2B1E16] text-sm mb-2 truncate">{{ product.name }}</h3>
          <p class="text-[15px] font-bold text-[#2B1E16]">Rp {{ Number(product.price).toLocaleString('id-ID') }}</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';

const products = ref([]);
const loading = ref(true);

const getProductImage = (product) => {
  const imgs = product?.images;
  if (Array.isArray(imgs) && imgs.length > 0) return imgs[0];
  if (typeof imgs === 'string') {
    try {
      const parsed = JSON.parse(imgs);
      if (Array.isArray(parsed) && parsed.length > 0) return parsed[0];
      if (typeof parsed === 'string' && parsed) return parsed;
    } catch {
      if (imgs) return imgs;
    }
  }
  if (product?.image_url) return product.image_url;
  return '/images/products/kerajinan_fallback.png';
};

const fetchProducts = async () => {
  loading.value = true;
  try {
    const token = localStorage.getItem('token');
    const res = await fetch('/api/v1/umkm/products', {
      headers: { 'Authorization': `Bearer ${token}`, 'Accept': 'application/json' }
    });
    if (res.ok) {
      const data = await res.json();
      products.value = data.data;
    }
  } finally {
    loading.value = false;
  }
};

const togglePublish = async (id) => {
  try {
    const token = localStorage.getItem('token');
    const res = await fetch(`/api/v1/umkm/products/${id}/publish`, {
      method: 'PATCH',
      headers: { 'Authorization': `Bearer ${token}`, 'Accept': 'application/json' }
    });
    if (res.ok) fetchProducts();
  } catch (e) { console.error(e); }
};

const deleteProduct = async (id) => {
  if (!confirm('Hapus produk ini? Tindakan tidak dapat dibatalkan.')) return;
  try {
    const token = localStorage.getItem('token');
    const res = await fetch(`/api/v1/umkm/products/${id}`, {
      method: 'DELETE',
      headers: { 'Authorization': `Bearer ${token}`, 'Accept': 'application/json' }
    });
    if (res.ok) fetchProducts();
  } catch (e) { console.error(e); }
};

onMounted(() => { fetchProducts(); });
</script>
