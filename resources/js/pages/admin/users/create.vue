<template>
  <div class="max-w-3xl mx-auto space-y-6 animate-in fade-in slide-in-from-bottom-4 duration-700">
    <div class="flex items-center justify-between">
      <div>
        <h2 class="text-xl font-black text-espresso tracking-tight">Tambah Pengguna</h2>
        <p class="text-xs text-slate-400 font-medium mt-1">Buat akun baru untuk masuk ke ekosistem SnapFit.</p>
      </div>
      <router-link to="/admin/users" class="text-xs font-bold text-slate-400 hover:text-indigo-600 transition-colors">
        Kembali
      </router-link>
    </div>

    <form @submit.prevent="submit" class="bg-surface p-8 rounded-[2rem] border border-borderSoft shadow-[0_8px_30px_rgb(0,0,0,0.02)] space-y-6">
      <div v-if="errorMessage" class="p-4 bg-red-50 text-red-600 text-xs font-bold rounded-xl">
        {{ errorMessage }}
      </div>

      <div class="space-y-4">
        <div>
          <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2 ml-1">Nama Lengkap</label>
          <input v-model="form.name" type="text" required class="w-full bg-slate-50 border-none rounded-xl px-5 py-4 text-sm font-bold text-espresso outline-none focus:ring-2 focus:ring-indigo-100 transition-all" placeholder="Masukkan nama..." />
        </div>

        <div>
          <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2 ml-1">Email</label>
          <input v-model="form.email" type="email" required class="w-full bg-slate-50 border-none rounded-xl px-5 py-4 text-sm font-bold text-espresso outline-none focus:ring-2 focus:ring-indigo-100 transition-all" placeholder="email@snapfit.id" />
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

        <div>
          <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2 ml-1">Password</label>
          <input v-model="form.password" type="password" required minlength="8" class="w-full bg-slate-50 border-none rounded-xl px-5 py-4 text-sm font-bold text-espresso outline-none focus:ring-2 focus:ring-indigo-100 transition-all" placeholder="Minimal 8 karakter" />
        </div>
      </div>

      <div class="pt-4 flex justify-end">
        <button type="submit" :disabled="loading" class="bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-4 rounded-xl text-xs font-black tracking-widest uppercase transition-all shadow-lg shadow-indigo-600/20 hover:shadow-indigo-600/40 disabled:opacity-50">
          {{ loading ? 'Menyimpan...' : 'Simpan Pengguna' }}
        </button>
      </div>
    </form>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';

const router = useRouter();
const loading = ref(false);
const errorMessage = ref('');

const form = ref({
  name: '',
  email: '',
  role: 'umkm',
  password: ''
});

const submit = async () => {
  loading.value = true;
  errorMessage.value = '';

  try {
    const token = localStorage.getItem('token');
    const res = await fetch('/api/v1/admin/users', {
      method: 'POST',
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
      if (data.errors) {
        errorMessage.value = Object.values(data.errors)[0][0];
      } else {
        errorMessage.value = data.message || 'Gagal menyimpan data';
      }
    }
  } catch (error) {
    errorMessage.value = 'Terjadi kesalahan jaringan.';
  } finally {
    loading.value = false;
  }
};
</script>
