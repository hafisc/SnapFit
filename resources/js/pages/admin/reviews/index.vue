<template>
  <div class="space-y-6 animate-in fade-in slide-in-from-bottom-4 duration-700">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-surface p-6 rounded-[2rem] border border-borderSoft shadow-[0_8px_30px_rgb(0,0,0,0.02)]">
      <div>
        <h2 class="text-xl font-black text-espresso tracking-tight">Moderasi Ulasan</h2>
        <p class="text-xs text-slate-400 font-medium mt-1">Pantau dan hapus ulasan yang melanggar ketentuan platform.</p>
      </div>
    </div>

    <div class="bg-surface rounded-[2rem] border border-borderSoft shadow-[0_8px_30px_rgb(0,0,0,0.02)] overflow-hidden">
      <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
          <thead>
            <tr class="bg-slate-50/50 border-b border-borderSoft">
              <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400">Pembeli</th>
              <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400">Produk</th>
              <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400">Rating & Ulasan</th>
              <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400 text-right">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-50">
            <tr v-if="loading" class="animate-pulse">
              <td colspan="4" class="px-6 py-10 text-center text-slate-400 text-sm font-bold">Memuat data...</td>
            </tr>
            <tr v-else-if="reviews.length === 0">
              <td colspan="4" class="px-6 py-10 text-center text-slate-400 text-sm font-bold">Tidak ada ulasan ditemukan.</td>
            </tr>
            <tr v-else v-for="review in reviews" :key="review.id" class="hover:bg-slate-50/50 transition-colors group">
              <td class="px-6 py-4">
                <span class="text-xs font-bold text-espresso">{{ review.user.name }}</span>
              </td>
              <td class="px-6 py-4">
                <span class="text-xs font-bold text-muted line-clamp-1">{{ review.product?.name || 'Produk Dihapus' }}</span>
              </td>
              <td class="px-6 py-4 max-w-xs">
                <div class="flex items-center gap-1 mb-1">
                  <svg v-for="i in 5" :key="i" class="w-3 h-3" :class="i <= review.rating ? 'text-amber-400' : 'text-slate-200'" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                  </svg>
                </div>
                <p class="text-xs text-muted italic">"{{ review.comment }}"</p>
              </td>
              <td class="px-6 py-4 text-right">
                <button @click="deleteReview(review.id)" class="w-8 h-8 rounded-lg bg-red-50 text-red-600 flex items-center justify-center hover:bg-red-100 transition-colors inline-flex opacity-0 group-hover:opacity-100">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
      <div v-if="pagination.last_page > 1" class="px-6 py-4 border-t border-borderSoft flex items-center justify-between bg-slate-50/30">
        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Halaman {{ pagination.current_page }} dari {{ pagination.last_page }}</p>
        <div class="flex items-center gap-2">
          <button @click="changePage(pagination.current_page - 1)" :disabled="pagination.current_page === 1" class="w-8 h-8 rounded-lg bg-surface border border-borderSoft flex items-center justify-center text-muted hover:bg-slate-50 disabled:opacity-50 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
          </button>
          <button @click="changePage(pagination.current_page + 1)" :disabled="pagination.current_page === pagination.last_page" class="w-8 h-8 rounded-lg bg-surface border border-borderSoft flex items-center justify-center text-muted hover:bg-slate-50 disabled:opacity-50 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';

const reviews = ref([]);
const loading = ref(true);
const pagination = ref({ current_page: 1, last_page: 1, total: 0 });

const fetchReviews = async (page = 1) => {
  loading.value = true;
  try {
    const token = localStorage.getItem('token');
    const res = await fetch(`/api/v1/admin/reviews?page=${page}`, {
      headers: { 'Authorization': `Bearer ${token}` }
    });
    if (res.ok) {
      const data = await res.json();
      reviews.value = data.data;
      pagination.value = data.pagination;
    }
  } finally {
    loading.value = false;
  }
};

const deleteReview = async (id) => {
  if (!confirm('Apakah Anda yakin ingin menghapus ulasan ini?')) return;
  try {
    const token = localStorage.getItem('token');
    const res = await fetch(`/api/v1/admin/reviews/${id}`, {
      method: 'DELETE',
      headers: { 'Authorization': `Bearer ${token}` }
    });
    if (res.ok) {
      fetchReviews(pagination.value.current_page);
    } else {
      alert('Gagal menghapus ulasan.');
    }
  } catch (error) {
    console.error('Delete error:', error);
  }
};

const changePage = (page) => {
  if (page < 1 || page > pagination.value.last_page) return;
  fetchReviews(page);
};

onMounted(() => {
  fetchReviews();
});
</script>
