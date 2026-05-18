<template>
  <div class="max-w-4xl mx-auto space-y-6 animate-in fade-in slide-in-from-bottom-4 duration-700">
    <div class="flex items-center justify-between">
      <div>
        <h2 class="text-xl font-black text-espresso tracking-tight">Edit Produk</h2>
        <p class="text-xs text-slate-400 font-medium mt-1">Perbarui detail, harga, atau stok produk Anda.</p>
      </div>
      <router-link to="/umkm/products" class="text-xs font-bold text-slate-400 hover:text-terracotta transition-colors flex items-center gap-1">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
        Kembali
      </router-link>
    </div>

    <form @submit.prevent="submit" class="bg-surface p-8 rounded-[2rem] border border-borderSoft shadow-[0_8px_30px_rgb(0,0,0,0.02)] space-y-8">
      <div v-if="errorMessage" class="p-4 bg-red-50 text-red-600 text-xs font-bold rounded-xl">
        {{ errorMessage }}
      </div>

      <div v-if="loadingData" class="py-20 text-center animate-pulse">
        <div class="w-10 h-10 border-4 border-terracotta/30 border-t-orange-500 rounded-full animate-spin mx-auto mb-4"></div>
        <p class="text-slate-400 font-bold text-sm">Memuat data produk...</p>
      </div>

      <div v-else class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Kolom Kiri -->
        <div class="space-y-6">
          <div>
            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2 ml-1">Nama Produk</label>
            <input v-model="form.name" type="text" required class="w-full bg-slate-50 border-none rounded-xl px-5 py-4 text-sm font-bold text-espresso outline-none focus:ring-2 focus:ring-orange-200 transition-all" />
          </div>

          <div>
            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2 ml-1">Kategori</label>
            <select v-model="form.category" required class="w-full bg-slate-50 border-none rounded-xl px-5 py-4 text-sm font-bold text-espresso outline-none focus:ring-2 focus:ring-orange-200 transition-all cursor-pointer">
              <option value="Pakaian">Pakaian</option>
              <option value="Kerajinan">Kerajinan Tangan</option>
              <option value="Aksesoris">Aksesoris</option>
              <option value="Makanan">Makanan/Minuman</option>
              <option value="Lainnya">Lainnya</option>
            </select>
          </div>

          <div>
            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2 ml-1">Harga (Rp)</label>
            <input v-model="form.price" type="number" min="0" required class="w-full bg-slate-50 border-none rounded-xl px-5 py-4 text-sm font-bold text-espresso outline-none focus:ring-2 focus:ring-orange-200 transition-all" />
          </div>
          
          <div>
            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2 ml-1">Stok Tersedia</label>
            <input v-model="form.stock" type="number" min="0" required class="w-full bg-slate-50 border-none rounded-xl px-5 py-4 text-sm font-bold text-espresso outline-none focus:ring-2 focus:ring-orange-200 transition-all" />
          </div>
        </div>

        <!-- Kolom Kanan -->
        <div class="space-y-6">
          <div>
            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2 ml-1">Deskripsi Lengkap</label>
            <textarea v-model="form.description" required rows="5" class="w-full bg-slate-50 border-none rounded-xl px-5 py-4 text-sm font-medium text-espresso outline-none focus:ring-2 focus:ring-orange-200 transition-all resize-none"></textarea>
          </div>
          
          <div>
            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2 ml-1">URL Gambar Produk</label>
            <input v-model="form.image_url" type="url" class="w-full bg-slate-50 border-none rounded-xl px-5 py-4 text-sm font-bold text-espresso outline-none focus:ring-2 focus:ring-orange-200 transition-all" />
          </div>
          
          <!-- Image Preview -->
          <div v-if="form.image_url" class="rounded-2xl overflow-hidden h-32 border border-borderSoft bg-slate-50">
            <img :src="form.image_url" class="w-full h-full object-cover" @error="form.image_url = ''" />
          </div>
        </div>
      </div>

      <div v-if="!loadingData" class="pt-6 border-t border-borderSoft flex items-center justify-between">
        <label class="flex items-center gap-3 cursor-pointer group">
          <div class="relative flex items-center justify-center w-12 h-6 bg-slate-200 rounded-full group-hover:bg-slate-300 transition-colors" :class="{ 'bg-terracotta group-hover:bg-terracotta': form.is_published }">
            <input type="checkbox" v-model="form.is_published" class="sr-only" />
            <div class="absolute left-1 w-4 h-4 bg-surface rounded-full transition-transform" :class="{ 'translate-x-6': form.is_published }"></div>
          </div>
          <span class="text-xs font-black uppercase tracking-widest" :class="form.is_published ? 'text-terracotta' : 'text-slate-400'">Published</span>
        </label>
        
        <button type="submit" :disabled="loading" class="bg-terracotta hover:bg-terracotta text-white px-8 py-4 rounded-xl text-xs font-black tracking-widest uppercase transition-all shadow-lg shadow-terracotta/50/20 disabled:opacity-50">
          {{ loading ? 'Menyimpan...' : 'Perbarui Produk' }}
        </button>
      </div>
    </form>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRouter, useRoute } from 'vue-router';

const router = useRouter();
const route = useRoute();
const loading = ref(false);
const loadingData = ref(true);
const errorMessage = ref('');

const form = ref({
  name: '',
  description: '',
  price: '',
  stock: '',
  category: 'Pakaian',
  image_url: '',
  is_published: false
});

const fetchProduct = async () => {
  try {
    const token = localStorage.getItem('token');
    // We fetch all myProducts and filter, because no show endpoint is explicitly defined
    const res = await fetch('/api/v1/umkm/products', {
      headers: { 'Authorization': `Bearer ${token}` }
    });
    if (res.ok) {
      const data = await res.json();
      const p = data.data.find(x => x.id == route.params.id);
      if (p) {
        form.value = {
          name: p.name,
          description: p.description,
          price: p.price,
          stock: p.stock,
          category: p.category,
          image_url: p.image_url,
          is_published: p.is_published
        };
      } else {
        errorMessage.value = 'Produk tidak ditemukan.';
      }
    }
  } catch (error) {
    errorMessage.value = 'Gagal memuat data produk.';
  } finally {
    loadingData.value = false;
  }
};

const submit = async () => {
  loading.value = true;
  errorMessage.value = '';

  try {
    const token = localStorage.getItem('token');
    const res = await fetch(`/api/v1/umkm/products/${route.params.id}`, {
      method: 'PUT',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'Authorization': `Bearer ${token}`
      },
      body: JSON.stringify({
        ...form.value,
        price: Number(form.value.price),
        stock: Number(form.value.stock)
      })
    });

    if (res.ok) {
      router.push('/umkm/products');
    } else {
      const data = await res.json();
      errorMessage.value = data.message || 'Gagal menyimpan data';
    }
  } catch (error) {
    errorMessage.value = 'Terjadi kesalahan jaringan.';
  } finally {
    loading.value = false;
  }
};

onMounted(() => {
  fetchProduct();
});
</script>
