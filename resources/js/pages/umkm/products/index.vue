<template>
  <div class="space-y-6 animate-in fade-in slide-in-from-bottom-4 duration-700">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-surface p-6 rounded-2xl border border-borderSoft shadow-[0_8px_30px_rgb(0,0,0,0.02)]">
      <div>
        <h2 class="text-xl font-bold text-espresso tracking-tight">Produk Saya</h2>
        <p class="text-xs text-slate-400 font-medium mt-1">Kelola daftar produk yang tampil di Marketplace.</p>
      </div>
      
      <div class="flex items-center gap-3">
        <router-link to="/umkm/products/create" class="bg-terracotta hover:bg-terracotta text-white px-5 py-3 rounded-xl text-xs font-bold tracking-wider uppercase transition-all shadow-sm flex items-center gap-2">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
          Tambah Produk
        </router-link>
      </div>
    </div>

    <!-- Product Grid -->
    <div v-if="loading" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
      <div v-for="i in 4" :key="i" class="bg-surface rounded-3xl p-4 border border-borderSoft animate-pulse">
        <div class="w-full h-48 bg-slate-100 rounded-2xl mb-4"></div>
        <div class="h-4 w-3/4 bg-slate-100 rounded mb-2"></div>
        <div class="h-4 w-1/2 bg-slate-100 rounded"></div>
      </div>
    </div>
    
    <div v-else-if="products.length === 0" class="bg-surface rounded-2xl border border-borderSoft shadow-[0_8px_30px_rgb(0,0,0,0.02)] py-20 text-center">
      <div class="w-20 h-20 bg-sand text-orange-400 rounded-full flex items-center justify-center mx-auto mb-4 text-3xl">📦</div>
      <h3 class="text-lg font-bold text-espresso mb-1">Belum Ada Produk</h3>
      <p class="text-slate-400 text-sm font-medium mb-6">Mulai tambahkan produk pertamamu ke dalam sistem.</p>
      <router-link to="/umkm/products/create" class="bg-terracotta hover:bg-terracotta text-white px-6 py-3 rounded-xl text-xs font-bold tracking-wider uppercase transition-all shadow-sm inline-block">
        Tambah Produk
      </router-link>
    </div>

    <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
      <div v-for="product in products" :key="product.id" class="bg-surface rounded-2xl border border-borderSoft shadow-[0_8px_30px_rgb(0,0,0,0.02)] overflow-hidden group hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] transition-all">
        <div class="relative h-56 w-full bg-slate-100 overflow-hidden">
          <img :src="product.image_url" :alt="product.name" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" />
          
          <div class="absolute top-4 right-4 flex flex-col gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
            <button @click="togglePublish(product.id)" class="w-8 h-8 rounded-lg flex items-center justify-center shadow-lg transition-colors" :class="product.is_published ? 'bg-emerald-500 hover:bg-emerald-600 text-white' : 'bg-slate-400 hover:bg-slate-500 text-white'" title="Toggle Publish">
              <svg v-if="product.is_published" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
              <svg v-else class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" /></svg>
            </button>
            <router-link :to="`/umkm/products/edit/${product.id}`" class="w-8 h-8 rounded-lg bg-surface/90 text-espresso flex items-center justify-center shadow-lg hover:bg-surface transition-colors" title="Edit">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
            </router-link>
            <button @click="deleteProduct(product.id)" class="w-8 h-8 rounded-lg bg-red-500 hover:bg-red-600 text-white flex items-center justify-center shadow-lg transition-colors" title="Delete">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
            </button>
          </div>
          
          <div class="absolute bottom-4 left-4">
            <span class="px-3 py-1 bg-surface/90 backdrop-blur-sm text-[10px] font-bold tracking-wider uppercase rounded-full shadow-sm" :class="product.is_published ? 'text-emerald-600' : 'text-muted'">
              {{ product.is_published ? 'Published' : 'Draft' }}
            </span>
          </div>
        </div>
        
        <div class="p-5">
          <p class="text-[10px] text-terracotta font-bold uppercase tracking-wider mb-1">{{ product.category }}</p>
          <h3 class="font-bold text-espresso text-base mb-2 truncate">{{ product.name }}</h3>
          <p class="text-lg font-bold text-espresso tracking-tight">Rp {{ Number(product.price).toLocaleString('id-ID') }}</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';

const products = ref([]);
const loading = ref(true);

const fetchProducts = async () => {
  loading.value = true;
  try {
    const token = localStorage.getItem('token');
    const res = await fetch('/api/v1/umkm/products', {
      headers: { 'Authorization': `Bearer ${token}` }
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
      headers: { 'Authorization': `Bearer ${token}` }
    });
    if (res.ok) {
      fetchProducts();
    }
  } catch (error) {
    console.error(error);
  }
};

const deleteProduct = async (id) => {
  if (!confirm('Hapus produk ini? Tindakan tidak dapat dibatalkan.')) return;
  try {
    const token = localStorage.getItem('token');
    const res = await fetch(`/api/v1/umkm/products/${id}`, {
      method: 'DELETE',
      headers: { 'Authorization': `Bearer ${token}` }
    });
    if (res.ok) {
      fetchProducts();
    }
  } catch (error) {
    console.error(error);
  }
};

onMounted(() => {
  fetchProducts();
});
</script>
