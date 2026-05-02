<template>
  <div class="space-y-6 animate-in fade-in slide-in-from-bottom-4 duration-700">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-white p-6 rounded-[2rem] border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.02)]">
      <div>
        <h2 class="text-xl font-black text-slate-800 tracking-tight">Data Produk</h2>
        <p class="text-xs text-slate-400 font-medium mt-1">Pantau produk yang dipublikasikan oleh UMKM.</p>
      </div>
    </div>

    <div class="bg-white rounded-[2rem] border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.02)] overflow-hidden">
      <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
          <thead>
            <tr class="bg-slate-50/50 border-b border-slate-100">
              <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400">Produk</th>
              <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400">Harga</th>
              <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400">UMKM</th>
              <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400">Status</th>
              <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400 text-right">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-50">
            <tr v-if="loading" class="animate-pulse">
              <td colspan="5" class="px-6 py-10 text-center text-slate-400 text-sm font-bold">Memuat data...</td>
            </tr>
            <tr v-else-if="products.length === 0">
              <td colspan="5" class="px-6 py-10 text-center text-slate-400 text-sm font-bold">Tidak ada produk.</td>
            </tr>
            <tr v-else v-for="item in products" :key="item.id" class="hover:bg-slate-50/50 transition-colors group">
              <td class="px-6 py-4 flex items-center gap-4">
                <img :src="item.image_url" class="w-12 h-12 rounded-xl object-cover bg-slate-100" />
                <div>
                  <p class="text-sm font-bold text-slate-800">{{ item.name }}</p>
                  <p class="text-[10px] text-slate-400 font-medium">{{ item.category }}</p>
                </div>
              </td>
              <td class="px-6 py-4">
                <span class="text-sm font-bold text-slate-700">Rp {{ Number(item.price).toLocaleString('id-ID') }}</span>
              </td>
              <td class="px-6 py-4">
                <span class="text-xs font-bold text-slate-500">{{ item.owner.name }}</span>
              </td>
              <td class="px-6 py-4">
                <span v-if="item.is_published" class="px-3 py-1 bg-emerald-50 text-emerald-600 rounded-full text-[10px] font-black tracking-widest uppercase">Published</span>
                <span v-else class="px-3 py-1 bg-slate-100 text-slate-500 rounded-full text-[10px] font-black tracking-widest uppercase">Draft</span>
              </td>
              <td class="px-6 py-4 text-right">
                <button @click="deleteProduct(item.id)" class="w-8 h-8 rounded-lg bg-red-50 text-red-600 flex items-center justify-center hover:bg-red-100 transition-colors inline-flex opacity-0 group-hover:opacity-100">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';

const products = ref([]);
const loading = ref(true);

const fetchProducts = async () => {
  try {
    const token = localStorage.getItem('token');
    const res = await fetch('/api/v1/admin/products', {
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

const deleteProduct = async (id) => {
  if (!confirm('Hapus produk ini? Tindakan ini tidak dapat dibatalkan.')) return;
  try {
    const token = localStorage.getItem('token');
    const res = await fetch(`/api/v1/admin/products/${id}`, {
      method: 'DELETE',
      headers: { 'Authorization': `Bearer ${token}` }
    });
    if (res.ok) {
      fetchProducts();
    }
  } catch (e) {
    console.error(e);
  }
};

onMounted(() => {
  fetchProducts();
});
</script>
