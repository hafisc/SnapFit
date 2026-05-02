<template>
  <div class="space-y-6 animate-in fade-in slide-in-from-bottom-4 duration-700">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-white p-6 rounded-[2rem] border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.02)]">
      <div>
        <h2 class="text-xl font-black text-slate-800 tracking-tight">Manajemen Pengguna</h2>
        <p class="text-xs text-slate-400 font-medium mt-1">Kelola data UMKM, Desainer, dan Pembeli dalam ekosistem SnapFit.</p>
      </div>
      
      <div class="flex items-center gap-3 w-full md:w-auto">
        <!-- Search -->
        <div class="relative flex-1 md:w-64">
          <svg class="w-4 h-4 absolute left-4 top-1/2 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
          <input v-model="search" @input="debounceSearch" type="text" placeholder="Cari nama atau email..." class="w-full bg-slate-50 border-none text-xs font-bold text-slate-600 rounded-xl pl-10 pr-4 py-3 outline-none focus:ring-2 focus:ring-indigo-100 transition-all" />
        </div>
        
        <!-- Filter Role -->
        <select v-model="roleFilter" @change="fetchUsers" class="bg-slate-50 border-none text-xs font-bold text-slate-600 rounded-xl px-4 py-3 outline-none focus:ring-2 focus:ring-indigo-100 cursor-pointer">
          <option value="">Semua Role</option>
          <option value="umkm">UMKM Kreator</option>
          <option value="desainer">Desainer</option>
          <option value="pembeli">Pembeli</option>
          <option value="admin">Admin</option>
        </select>
        
        <!-- Add Button -->
        <router-link to="/admin/users/create" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-3 rounded-xl text-xs font-black tracking-widest uppercase transition-all shadow-lg shadow-indigo-600/20 hover:shadow-indigo-600/40 flex items-center gap-2">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
          Tambah
        </router-link>
      </div>
    </div>

    <!-- Table Section -->
    <div class="bg-white rounded-[2rem] border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.02)] overflow-hidden">
      <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
          <thead>
            <tr class="bg-slate-50/50 border-b border-slate-100">
              <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400">Pengguna</th>
              <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400">Role Akses</th>
              <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400">Terdaftar Pada</th>
              <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400 text-right">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-50">
            <tr v-if="loading" class="animate-pulse">
              <td colspan="4" class="px-6 py-10 text-center text-slate-400 text-sm font-bold">Memuat data...</td>
            </tr>
            <tr v-else-if="users.length === 0">
              <td colspan="4" class="px-6 py-10 text-center text-slate-400 text-sm font-bold">Tidak ada data pengguna ditemukan.</td>
            </tr>
            <tr v-else v-for="user in users" :key="user.id" class="hover:bg-slate-50/50 transition-colors group">
              <td class="px-6 py-4">
                <div class="flex items-center gap-3">
                  <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 font-black flex-shrink-0">
                    {{ user.name.charAt(0).toUpperCase() }}
                  </div>
                  <div>
                    <p class="text-sm font-bold text-slate-800">{{ user.name }}</p>
                    <p class="text-[10px] text-slate-400 font-medium">{{ user.email }}</p>
                  </div>
                </div>
              </td>
              <td class="px-6 py-4">
                <span class="px-3 py-1 text-[10px] font-black tracking-widest uppercase rounded-full inline-block" :class="roleColor(user.role)">
                  {{ user.role }}
                </span>
              </td>
              <td class="px-6 py-4">
                <span class="text-xs font-bold text-slate-500">{{ formatDate(user.created_at) }}</span>
              </td>
              <td class="px-6 py-4 text-right">
                <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                  <router-link :to="`/admin/users/edit/${user.id}`" class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center hover:bg-indigo-100 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                  </router-link>
                  <button @click="deleteUser(user.id)" class="w-8 h-8 rounded-lg bg-red-50 text-red-600 flex items-center justify-center hover:bg-red-100 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
      <div v-if="pagination.last_page > 1" class="px-6 py-4 border-t border-slate-100 flex items-center justify-between bg-slate-50/30">
        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Halaman {{ pagination.current_page }} dari {{ pagination.last_page }}</p>
        <div class="flex items-center gap-2">
          <button @click="changePage(pagination.current_page - 1)" :disabled="pagination.current_page === 1" class="w-8 h-8 rounded-lg bg-white border border-slate-200 flex items-center justify-center text-slate-500 hover:bg-slate-50 disabled:opacity-50 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
          </button>
          <button @click="changePage(pagination.current_page + 1)" :disabled="pagination.current_page === pagination.last_page" class="w-8 h-8 rounded-lg bg-white border border-slate-200 flex items-center justify-center text-slate-500 hover:bg-slate-50 disabled:opacity-50 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';

const users = ref([]);
const loading = ref(true);
const search = ref('');
const roleFilter = ref('');
const pagination = ref({ current_page: 1, last_page: 1, total: 0 });

let searchTimeout = null;

const debounceSearch = () => {
  clearTimeout(searchTimeout);
  searchTimeout = setTimeout(() => {
    pagination.value.current_page = 1;
    fetchUsers();
  }, 500);
};

const fetchUsers = async (page = 1) => {
  loading.value = true;
  try {
    const token = localStorage.getItem('token');
    const params = new URLSearchParams({
      page,
      ...(search.value && { search: search.value }),
      ...(roleFilter.value && { role: roleFilter.value }),
    });

    const res = await fetch(`/api/v1/admin/users?${params.toString()}`, {
      headers: {
        'Accept': 'application/json',
        'Authorization': `Bearer ${token}`
      }
    });

    if (res.ok) {
      const data = await res.json();
      users.value = data.data;
      pagination.value = data.pagination;
    }
  } catch (error) {
    console.error('Failed to fetch users:', error);
  } finally {
    loading.value = false;
  }
};

const deleteUser = async (id) => {
  if (!confirm('Apakah Anda yakin ingin menghapus pengguna ini?')) return;
  
  try {
    const token = localStorage.getItem('token');
    const res = await fetch(`/api/v1/admin/users/${id}`, {
      method: 'DELETE',
      headers: {
        'Accept': 'application/json',
        'Authorization': `Bearer ${token}`
      }
    });

    if (res.ok) {
      fetchUsers(pagination.value.current_page);
    } else {
      alert('Gagal menghapus pengguna.');
    }
  } catch (error) {
    console.error('Delete error:', error);
  }
};

const changePage = (page) => {
  if (page < 1 || page > pagination.value.last_page) return;
  fetchUsers(page);
};

const formatDate = (dateString) => {
  if (!dateString) return '-';
  const date = new Date(dateString);
  return new Intl.DateTimeFormat('id-ID', { day: '2-digit', month: 'short', year: 'numeric' }).format(date);
};

const roleColor = (role) => {
  switch (role) {
    case 'admin': return 'bg-slate-900 text-white';
    case 'umkm': return 'bg-indigo-100 text-indigo-700';
    case 'desainer': return 'bg-purple-100 text-purple-700';
    default: return 'bg-slate-100 text-slate-700';
  }
};

onMounted(() => {
  fetchUsers();
});
</script>

<style scoped>
.animate-in { animation-duration: 0.5s; animation-fill-mode: both; }
@keyframes slideInUp { from { transform: translateY(10px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
.slide-in-from-bottom-4 { animation-name: slideInUp; }
@keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
.fade-in { animation-name: fadeIn; }
</style>
