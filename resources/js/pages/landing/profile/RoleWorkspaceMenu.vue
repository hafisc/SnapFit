<template>
  <div class="space-y-8">
    <!-- Current Active Role Section -->
    <div v-if="roleMenu" class="p-6 bg-gradient-to-r from-orange-50 to-amber-50 border border-terracotta/30 rounded-2xl">
      <p class="text-xs font-bold text-terracotta uppercase tracking-widest mb-3">Role Aktif Saat Ini</p>
      <div class="flex items-center gap-4">
        <div class="flex items-center justify-center w-14 h-14 rounded-full bg-surface shadow-md border-2 border-orange-300">
          <span class="text-2xl">
            {{ getRoleIcon(roleMenu.current_active_role) }}
          </span>
        </div>
        <div>
          <p class="text-sm font-black text-espresso uppercase tracking-widest">
            {{ getRoleDisplayName(roleMenu.current_active_role) }}
          </p>
          <p class="text-xs text-muted mt-1">Ruang kerja yang sedang aktif</p>
        </div>
      </div>
    </div>

    <!-- Role Cards Grid -->
    <div v-if="roleMenu && !isLoadingRoles" class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <template v-for="role in roleMenu.roles" :key="role.name">
        <!-- Active Role Card (User sudah punya) -->
        <div v-if="role.status === 'active'"
             class="p-6 rounded-2xl border-2 bg-gradient-to-br from-green-50 to-emerald-50 border-green-300 shadow-lg hover:shadow-xl transition-all duration-300 group">
          
          <!-- Header -->
          <div class="flex items-start justify-between mb-4">
            <div class="flex items-center gap-3">
              <span class="text-4xl">{{ getRoleIcon(role.name) }}</span>
              <div>
                <h4 class="font-black text-espresso text-sm uppercase tracking-widest">
                  {{ getRoleDisplayName(role.name) }}
                </h4>
              </div>
            </div>
          </div>

          <!-- Description -->
          <p class="text-sm text-espresso mb-6 leading-relaxed font-medium">
            <span v-if="role.name === 'umkm'">Jual produk Anda dan kelola bisnis UMKM dengan AI Product Studio, analytics, dan co-creation tools.</span>
            <span v-else-if="role.name === 'designer'">Kolaborasikan design dengan UMKM dan dapatkan passive income dari karya kreatif Anda.</span>
            <span v-else>Belanja produk lokal terbaik, wishlist favorit, dan track pesanan Anda.</span>
          </p>

          <!-- Action -->
          <button 
            v-if="roleMenu.current_active_role !== role.name"
            @click="handleSwitchRole(role.name)"
            :disabled="isSwitchingRole"
            class="w-full bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 disabled:opacity-50 text-white font-bold py-3 px-5 rounded-lg transition-all duration-200 active:scale-95 text-sm shadow-md shadow-green-500/30 flex items-center justify-center gap-2">
            <svg v-if="!isSwitchingRole" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
            <span v-if="isSwitchingRole">Memproses...</span>
            <span v-else>Buka Dashboard</span>
          </button>
          <button v-else 
            @click="goToDashboard(role.name)"
            class="w-full bg-green-700 hover:bg-green-800 text-white font-bold py-3 px-5 rounded-lg text-sm transition-all duration-200 active:scale-95 shadow-md flex items-center justify-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" /></svg>
            Buka Dashboard
          </button>
        </div>

        <!-- Inactive/Pending/Rejected/Need Review Role Card -->
        <div v-else
             class="p-6 rounded-2xl border-2 bg-gradient-to-br from-slate-50 to-slate-100 transition-all duration-300 group cursor-pointer"
             :class="{
               'border-slate-300 hover:border-terracotta hover:shadow-lg': role.status === 'inactive',
               'border-amber-300 shadow-md bg-gradient-to-br from-amber-50 to-orange-50': role.status === 'pending',
               'border-orange-300 shadow-md bg-gradient-to-br from-orange-50 to-amber-50': role.status === 'need_review',
               'border-red-300 shadow-md bg-gradient-to-br from-red-50 to-rose-50': role.status === 'rejected'
             }">
          
          <!-- Header -->
          <div class="flex items-start justify-between mb-4">
            <div class="flex items-center gap-3">
              <span class="text-4xl opacity-60 group-hover:opacity-100 transition-opacity" :class="{'opacity-100': role.status !== 'inactive'}">{{ getRoleIcon(role.name) }}</span>
              <div>
                <h4 class="font-black text-espresso text-sm uppercase tracking-widest">
                  {{ getRoleDisplayName(role.name) }}
                </h4>
                <div class="flex items-center gap-2 mt-1">
                  <span class="inline-block w-2 h-2 rounded-full"
                        :class="{
                          'bg-slate-400': role.status === 'inactive',
                          'bg-amber-500 animate-pulse': role.status === 'pending',
                          'bg-orange-500': role.status === 'need_review',
                          'bg-red-500': role.status === 'rejected'
                        }"></span>
                  <p class="text-[10px] font-bold uppercase tracking-widest"
                     :class="{
                       'text-muted': role.status === 'inactive',
                       'text-amber-700': role.status === 'pending',
                       'text-orange-700': role.status === 'need_review',
                       'text-red-700': role.status === 'rejected'
                     }">
                    {{ role.status === 'pending' ? 'Menunggu Verifikasi' : (role.status === 'need_review' ? 'Perlu Dilengkapi' : (role.status === 'rejected' ? 'Ditolak' : 'Belum Terdaftar')) }}
                  </p>
                </div>
              </div>
            </div>
          </div>

          <!-- Description -->
          <p class="text-sm mb-6 leading-relaxed font-medium"
             :class="{
               'text-muted': role.status === 'inactive',
               'text-amber-900': role.status === 'pending',
               'text-orange-900': role.status === 'need_review',
               'text-red-900': role.status === 'rejected'
             }">
            <template v-if="role.status === 'pending'">Pengajuan Anda sedang ditinjau oleh AI SnapFit. Silakan tunggu update selanjutnya.</template>
            <template v-else-if="role.status === 'need_review'">
              <span class="block mb-1 font-bold">Data perlu dilengkapi (Skor: {{ role.ai_score }}/100)</span>
              <span class="text-xs">{{ role.ai_summary || 'Beberapa data belum memenuhi syarat. Klik untuk memperbaiki.' }}</span>
            </template>
            <template v-else-if="role.status === 'rejected'">
              <span class="block mb-1 font-bold">Pengajuan ditolak.</span>
              <span class="text-xs">{{ role.rejection_reason || 'Dokumen belum lengkap atau tidak memenuhi syarat.' }}</span>
            </template>
            <template v-else-if="role.name === 'umkm'">Jual produk lokal dan kelola toko Anda di SnapFit dengan fitur AI.</template>
            <template v-else-if="role.name === 'designer'">Kolaborasikan design dengan UMKM dan dapatkan passive income.</template>
            <template v-else>Belanja produk lokal terbaik, wishlist favorit, dan track pesanan Anda.</template>
          </p>

          <!-- Action -->
          <button 
            v-if="role.status === 'inactive' || role.status === 'rejected' || role.status === 'need_review'"
            @click="handleRegisterRole(role.name)"
            :disabled="isRegisteringRole"
            class="w-full font-bold py-3 px-5 rounded-lg transition-all duration-200 active:scale-95 text-sm flex items-center justify-center gap-2 disabled:opacity-50"
            :class="{
              'bg-surface border-2 border-slate-400 text-espresso hover:border-orange-600 hover:text-terracotta hover:shadow-lg': role.status === 'inactive',
              'bg-orange-600 hover:bg-orange-700 text-white shadow-md': role.status === 'need_review',
              'bg-red-600 hover:bg-red-700 text-white shadow-md': role.status === 'rejected'
            }">
            <svg v-if="!isRegisteringRole && role.status === 'inactive'" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
            <svg v-if="!isRegisteringRole && (role.status === 'rejected' || role.status === 'need_review')" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>
            <span v-if="isRegisteringRole">Mengirim...</span>
            <span v-else>{{ role.status === 'rejected' ? 'Ajukan Ulang' : (role.status === 'need_review' ? 'Perbaiki Data' : 'Daftar Sekarang') }}</span>
          </button>
          
          <button 
            v-if="role.status === 'pending'"
            disabled
            class="w-full bg-amber-200 text-amber-800 font-bold py-3 px-5 rounded-lg transition-all duration-200 text-sm flex items-center justify-center gap-2 opacity-80 cursor-not-allowed">
            <svg class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
            Sedang Diverifikasi AI
          </button>
        </div>
      </template>
    </div>

    <!-- Loading State -->
    <div v-if="isLoadingRoles" class="flex flex-col items-center justify-center py-16">
      <div class="w-12 h-12 border-4 border-terracotta/30 border-t-orange-600 rounded-full animate-spin mb-4"></div>
      <p class="text-muted text-sm font-medium">Memuat role menu...</p>
    </div>

    <!-- Error State -->
    <div v-if="!isLoadingRoles && !roleMenu" class="p-6 bg-red-50 border border-red-200 rounded-2xl text-center">
      <svg class="w-12 h-12 text-red-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4v.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
      <p class="text-sm font-semibold text-red-700">Gagal memuat role menu</p>
      <p class="text-xs text-red-600 mt-1">Silakan coba refresh halaman ini</p>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import { useNotificationStore } from '@/stores/notificationStore';

const router = useRouter();
const notificationStore = useNotificationStore();
const roleMenu = ref(null);
const isLoadingRoles = ref(false);
const isSwitchingRole = ref(false);
const token = localStorage.getItem('token');

const getRoleIcon = (roleName) => {
  const icons = {
    buyer: '🛍️',
    umkm: '🏪',
    designer: '🎨',
  };
  return icons[roleName] || '•';
};

const getRoleDisplayName = (roleName) => {
  const names = {
    buyer: 'Pembeli',
    umkm: 'UMKM',
    designer: 'Designer',
  };
  return names[roleName] || roleName;
};

const fetchRoleMenu = async () => {
  isLoadingRoles.value = true;
  try {
    const res = await fetch('/api/v1/profile/role-menu', {
      headers: {
        'Authorization': `Bearer ${token}`,
        'Accept': 'application/json',
      },
    });
    if (res.ok) {
      const json = await res.json();
      roleMenu.value = json;
    }
  } catch (err) {
    console.error('Failed to fetch role menu', err);
  } finally {
    isLoadingRoles.value = false;
  }
};

const handleSwitchRole = async (roleName) => {
  isSwitchingRole.value = true;
  try {
    const res = await fetch('/api/v1/profile/switch-role', {
      method: 'POST',
      headers: {
        'Authorization': `Bearer ${token}`,
        'Content-Type': 'application/json',
        'Accept': 'application/json',
      },
      body: JSON.stringify({ role: roleName }),
    });

    if (res.ok) {
      const data = await res.json();
      localStorage.setItem('user', JSON.stringify(data.user));

      // Refresh role menu
      await fetchRoleMenu();

      // Redirect ke dashboard role
      const dashboards = {
        buyer: '/dashboard',
        umkm: '/umkm/dashboard',
        designer: '/designer/dashboard',
      };

      setTimeout(() => {
        router.push(dashboards[roleName]);
      }, 600);
    } else {
      notificationStore.error('Gagal mengubah role.');
    }
  } catch (err) {
    notificationStore.error('Terjadi kesalahan jaringan.');
    console.error('Failed to switch role', err);
  } finally {
    isSwitchingRole.value = false;
  }
};

const goToDashboard = (roleName) => {
  const dashboards = {
    buyer: '/dashboard',
    umkm: '/umkm/dashboard',
    designer: '/designer/dashboard',
  };
  router.push(dashboards[roleName] || '/dashboard');
};

const isRegisteringRole = ref(false);

const handleRegisterRole = async (roleName) => {
  // Navigate to the dedicated registration form
  const routes = {
    umkm: '/register/umkm',
    designer: '/register/designer',
  };
  router.push(routes[roleName] || '/profile');
};

onMounted(() => {
  if (token) {
    fetchRoleMenu();
  }
});
</script>

<style scoped>
/* Smooth transitions for role cards */
div {
  @apply transition-all duration-300;
}
</style>
