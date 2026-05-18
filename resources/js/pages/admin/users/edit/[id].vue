<template>
  <div class="max-w-3xl mx-auto space-y-6 animate-in fade-in slide-in-from-bottom-4 duration-700">
    <div class="flex items-center justify-between">
      <div>
        <h2 class="text-xl font-black text-espresso tracking-tight">Edit Pengguna</h2>
        <p class="text-xs text-slate-400 font-medium mt-1">Perbarui data profil pengguna.</p>
      </div>
      <router-link to="/admin/users" class="text-xs font-bold text-slate-400 hover:text-indigo-600 transition-colors">
        Kembali
      </router-link>
    </div>

    <form @submit.prevent="submit" class="bg-surface p-8 rounded-[2rem] border border-borderSoft shadow-[0_8px_30px_rgb(0,0,0,0.02)] space-y-6">
      <div v-if="errorMessage" class="p-4 bg-red-50 text-red-600 text-xs font-bold rounded-xl">
        {{ errorMessage }}
      </div>

      <div class="space-y-4" v-if="!loadingData">
        <div>
          <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2 ml-1">Nama Lengkap</label>
          <input v-model="form.name" type="text" required class="w-full bg-slate-50 border-none rounded-xl px-5 py-4 text-sm font-bold text-espresso outline-none focus:ring-2 focus:ring-indigo-100 transition-all" />
        </div>

        <div>
          <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2 ml-1">Email</label>
          <input v-model="form.email" type="email" required class="w-full bg-slate-50 border-none rounded-xl px-5 py-4 text-sm font-bold text-espresso outline-none focus:ring-2 focus:ring-indigo-100 transition-all" />
        </div>

        <div>
          <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2 ml-1">Role</label>
          <select v-model="form.role" required class="w-full bg-slate-50 border-none rounded-xl px-5 py-4 text-sm font-bold text-espresso outline-none focus:ring-2 focus:ring-indigo-100 transition-all cursor-pointer">
            <option value="umkm">UMKM Kreator</option>
            <option value="desainer">Desainer</option>
            <option value="pembeli">Pembeli</option>
            <option value="admin">Admin</option>
          </select>
        </div>
      </div>
      <div v-else class="py-10 text-center text-slate-400 text-sm font-bold animate-pulse">
        Memuat data...
      </div>

      <div class="pt-4 flex justify-end">
        <button type="submit" :disabled="loading || loadingData" class="bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-4 rounded-xl text-xs font-black tracking-widest uppercase transition-all shadow-lg shadow-indigo-600/20 hover:shadow-indigo-600/40 disabled:opacity-50">
          {{ loading ? 'Menyimpan...' : 'Perbarui Pengguna' }}
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
  email: '',
  role: ''
});

const fetchUser = async () => {
  try {
    const token = localStorage.getItem('token');
    // Fetch user list and find this user (since no single endpoint for user detail exist for admin)
    const res = await fetch(`/api/v1/admin/users?search=${route.params.id}`, {
      headers: { 'Authorization': `Bearer ${token}` }
    });
    
    if (res.ok) {
      const data = await res.json();
      const user = data.data.find(u => u.id == route.params.id);
      if (user) {
        form.value.name = user.name;
        form.value.email = user.email;
        form.value.role = user.role;
      } else {
        errorMessage.value = 'User tidak ditemukan';
      }
    }
  } catch (error) {
    errorMessage.value = 'Terjadi kesalahan jaringan';
  } finally {
    loadingData.value = false;
  }
};

const submit = async () => {
  loading.value = true;
  errorMessage.value = '';

  try {
    const token = localStorage.getItem('token');
    const res = await fetch(`/api/v1/admin/users/${route.params.id}`, {
      method: 'PUT',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'Authorization': `Bearer ${token}`
      },
      body: JSON.stringify(form.value)
    });

    if (res.ok) {
      router.push('/admin/users');
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
  fetchUser();
});
</script>
