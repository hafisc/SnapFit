<template>
  <div class="space-y-5 max-w-[1400px]">
    <!-- Roles Overview -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
      <div v-for="r in roles" :key="r.name"
        class="bg-white rounded-2xl border border-slate-200/60 p-5 cursor-pointer hover:shadow-md transition-all group"
        :class="selectedRole === r.name ? 'ring-2 ring-orange-500/30 border-orange-200' : ''" @click="selectedRole = r.name">
        <div class="flex items-center justify-between mb-4">
          <div class="w-10 h-10 rounded-xl flex items-center justify-center" :class="r.bgClass">
            <span class="text-lg">{{ r.emoji }}</span>
          </div>
          <span class="text-[10px] font-bold px-2 py-0.5 rounded-md" :class="r.countBg">{{ r.count }} user</span>
        </div>
        <h3 class="text-[14px] font-bold text-slate-800 mb-0.5 group-hover:text-orange-600 transition-colors">{{ r.label }}</h3>
        <p class="text-[11px] text-slate-400 font-medium leading-relaxed">{{ r.desc }}</p>
      </div>
    </div>

    <!-- Permission Matrix -->
    <div class="bg-white rounded-2xl border border-slate-200/60 overflow-hidden">
      <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between">
        <div>
          <h3 class="text-[14px] font-bold text-slate-800">Permission Matrix</h3>
          <p class="text-[11px] text-slate-400 font-medium mt-0.5">Kelola hak akses untuk role: <span class="text-orange-500 font-bold capitalize">{{ selectedRole }}</span></p>
        </div>
        <button class="px-4 py-2 bg-slate-800 hover:bg-slate-900 text-white text-[11px] font-bold rounded-lg transition-colors">Simpan Perubahan</button>
      </div>

      <table class="w-full text-left">
        <thead>
          <tr class="border-b border-slate-100 bg-slate-50/50">
            <th class="px-6 py-3.5 text-[10px] font-bold uppercase tracking-wider text-slate-400 w-1/3">Modul</th>
            <th class="px-4 py-3.5 text-[10px] font-bold uppercase tracking-wider text-slate-400 text-center">Lihat</th>
            <th class="px-4 py-3.5 text-[10px] font-bold uppercase tracking-wider text-slate-400 text-center">Buat</th>
            <th class="px-4 py-3.5 text-[10px] font-bold uppercase tracking-wider text-slate-400 text-center">Edit</th>
            <th class="px-4 py-3.5 text-[10px] font-bold uppercase tracking-wider text-slate-400 text-center">Hapus</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-50">
          <tr v-for="perm in currentPermissions" :key="perm.module" class="hover:bg-slate-50/60 transition-colors">
            <td class="px-6 py-3.5">
              <div class="flex items-center gap-2.5">
                <span class="text-sm">{{ perm.emoji }}</span>
                <div>
                  <p class="text-[12px] font-semibold text-slate-700">{{ perm.module }}</p>
                  <p class="text-[10px] text-slate-400">{{ perm.desc }}</p>
                </div>
              </div>
            </td>
            <td class="px-4 py-3.5 text-center">
              <button @click="perm.view = !perm.view" class="w-8 h-8 rounded-lg mx-auto flex items-center justify-center transition-all"
                :class="perm.view ? 'bg-emerald-50 text-emerald-500' : 'bg-slate-100 text-slate-300'">
                <svg v-if="perm.view" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
                <svg v-else class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
              </button>
            </td>
            <td class="px-4 py-3.5 text-center">
              <button @click="perm.create = !perm.create" class="w-8 h-8 rounded-lg mx-auto flex items-center justify-center transition-all"
                :class="perm.create ? 'bg-emerald-50 text-emerald-500' : 'bg-slate-100 text-slate-300'">
                <svg v-if="perm.create" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
                <svg v-else class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
              </button>
            </td>
            <td class="px-4 py-3.5 text-center">
              <button @click="perm.edit = !perm.edit" class="w-8 h-8 rounded-lg mx-auto flex items-center justify-center transition-all"
                :class="perm.edit ? 'bg-emerald-50 text-emerald-500' : 'bg-slate-100 text-slate-300'">
                <svg v-if="perm.edit" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
                <svg v-else class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
              </button>
            </td>
            <td class="px-4 py-3.5 text-center">
              <button @click="perm.delete = !perm.delete" class="w-8 h-8 rounded-lg mx-auto flex items-center justify-center transition-all"
                :class="perm.delete ? 'bg-emerald-50 text-emerald-500' : 'bg-slate-100 text-slate-300'">
                <svg v-if="perm.delete" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
                <svg v-else class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';

const selectedRole = ref('admin');

const roles = [
  { name: 'admin', label: 'Administrator', desc: 'Akses penuh ke semua fitur platform.', emoji: '🛡️', count: 2, bgClass: 'bg-slate-100', countBg: 'bg-slate-100 text-slate-600' },
  { name: 'umkm', label: 'UMKM Kreator', desc: 'Kelola produk, pesanan, dan studio AI.', emoji: '🏪', count: 142, bgClass: 'bg-orange-50', countBg: 'bg-orange-50 text-orange-600' },
  { name: 'desainer', label: 'Desainer', desc: 'Kolaborasi Co-Create dan portofolio.', emoji: '🎨', count: 67, bgClass: 'bg-blue-50', countBg: 'bg-blue-50 text-blue-600' },
  { name: 'pembeli', label: 'Pembeli', desc: 'Beli produk dan AR Try-On.', emoji: '🛒', count: 48, bgClass: 'bg-emerald-50', countBg: 'bg-emerald-50 text-emerald-600' },
];

const permissionsMap = {
  admin: [
    { module: 'Dashboard', desc: 'Analitik & overview', emoji: '📊', view: true, create: true, edit: true, delete: true },
    { module: 'Users', desc: 'Manajemen pengguna', emoji: '👥', view: true, create: true, edit: true, delete: true },
    { module: 'Products', desc: 'Moderasi produk', emoji: '📦', view: true, create: true, edit: true, delete: true },
    { module: 'Orders', desc: 'Transaksi & pembayaran', emoji: '🛍️', view: true, create: true, edit: true, delete: true },
    { module: 'Analytics', desc: 'Metrik global', emoji: '📈', view: true, create: true, edit: true, delete: true },
    { module: 'Roles', desc: 'Hak akses', emoji: '🔐', view: true, create: true, edit: true, delete: true },
  ],
  umkm: [
    { module: 'Dashboard', desc: 'Ringkasan UMKM', emoji: '📊', view: true, create: false, edit: false, delete: false },
    { module: 'Products', desc: 'Produk sendiri', emoji: '📦', view: true, create: true, edit: true, delete: true },
    { module: 'Orders', desc: 'Pesanan masuk', emoji: '🛍️', view: true, create: false, edit: true, delete: false },
    { module: 'AI Studio', desc: 'Generate desain AI', emoji: '🤖', view: true, create: true, edit: false, delete: false },
    { module: 'Co-Create', desc: 'Room kolaborasi', emoji: '🎨', view: true, create: true, edit: true, delete: false },
    { module: 'Profile', desc: 'Profil toko', emoji: '🏪', view: true, create: false, edit: true, delete: false },
  ],
  desainer: [
    { module: 'Dashboard', desc: 'Ringkasan desainer', emoji: '📊', view: true, create: false, edit: false, delete: false },
    { module: 'Co-Create', desc: 'Room kolaborasi', emoji: '🎨', view: true, create: false, edit: true, delete: false },
    { module: 'Portfolio', desc: 'Portofolio desain', emoji: '🖼️', view: true, create: true, edit: true, delete: true },
    { module: 'History', desc: 'Riwayat kolaborasi', emoji: '📋', view: true, create: false, edit: false, delete: false },
    { module: 'Profile', desc: 'Profil desainer', emoji: '👤', view: true, create: false, edit: true, delete: false },
    { module: 'Invitations', desc: 'Undangan masuk', emoji: '📩', view: true, create: false, edit: true, delete: false },
  ],
  pembeli: [
    { module: 'Marketplace', desc: 'Browse & beli produk', emoji: '🛒', view: true, create: false, edit: false, delete: false },
    { module: 'Orders', desc: 'Pesanan saya', emoji: '🛍️', view: true, create: true, edit: false, delete: false },
    { module: 'AR Try-On', desc: 'Coba produk via AR', emoji: '📱', view: true, create: true, edit: false, delete: false },
    { module: 'Reviews', desc: 'Ulasan produk', emoji: '⭐', view: true, create: true, edit: true, delete: true },
    { module: 'Profile', desc: 'Profil pembeli', emoji: '👤', view: true, create: false, edit: true, delete: false },
    { module: 'Wishlist', desc: 'Produk favorit', emoji: '❤️', view: true, create: true, edit: false, delete: true },
  ],
};

const currentPermissions = computed(() => permissionsMap[selectedRole.value] || []);
</script>
