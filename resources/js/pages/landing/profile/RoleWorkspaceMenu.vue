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
                <div class="flex items-center gap-2 mt-1">
                  <span class="inline-block w-2 h-2 bg-green-500 rounded-full"></span>
                  <p class="text-[10px] font-bold text-green-700 uppercase tracking-widest">✓ Sudah Terdaftar</p>
                </div>
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
            <span v-if="isSwitchingRole">Mengubah...</span>
            <span v-else>Buka Dashboard</span>
          </button>
          <button v-else 
            disabled
            class="w-full bg-green-500 text-white font-bold py-3 px-5 rounded-lg text-sm opacity-60 cursor-not-allowed flex items-center justify-center gap-2">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" /></svg>
            Sedang Aktif
          </button>
        </div>

        <!-- Inactive Role Card (User belum punya) -->
        <div v-else
             class="p-6 rounded-2xl border-2 bg-gradient-to-br from-slate-50 to-slate-100 border-slate-300 hover:border-terracotta hover:shadow-lg transition-all duration-300 group cursor-pointer">
          
          <!-- Header -->
          <div class="flex items-start justify-between mb-4">
            <div class="flex items-center gap-3">
              <span class="text-4xl opacity-60 group-hover:opacity-100 transition-opacity">{{ getRoleIcon(role.name) }}</span>
              <div>
                <h4 class="font-black text-espresso text-sm uppercase tracking-widest">
                  {{ getRoleDisplayName(role.name) }}
                </h4>
                <div class="flex items-center gap-2 mt-1">
                  <span class="inline-block w-2 h-2 bg-slate-400 rounded-full"></span>
                  <p class="text-[10px] font-bold text-muted uppercase tracking-widest">Belum Terdaftar</p>
                </div>
              </div>
            </div>
          </div>

          <!-- Description -->
          <p class="text-sm text-muted mb-6 leading-relaxed font-medium">
            <span v-if="role.name === 'umkm'">Jual produk Anda dan kelola bisnis UMKM dengan AI Product Studio, analytics, dan co-creation tools.</span>
            <span v-else-if="role.name === 'designer'">Kolaborasikan design dengan UMKM dan dapatkan passive income dari karya kreatif Anda.</span>
            <span v-else>Belanja produk lokal terbaik, wishlist favorit, dan track pesanan Anda.</span>
          </p>

          <!-- Action -->
          <button 
            @click="handleRegisterRole(role.name)"
            class="w-full bg-surface border-2 border-slate-400 text-espresso font-bold py-3 px-5 rounded-lg hover:border-orange-600 hover:text-terracotta hover:shadow-lg transition-all duration-200 active:scale-95 text-sm group-hover:shadow-md flex items-center justify-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
            Daftar Sekarang
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

const router = useRouter();
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
    designer: 'Designer Profesional',
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
      alert('Gagal mengubah role.');
    }
  } catch (err) {
    alert('Terjadi kesalahan jaringan.');
    console.error('Failed to switch role', err);
  } finally {
    isSwitchingRole.value = false;
  }
};

const handleRegisterRole = (roleName) => {
  if (roleName === 'umkm') {
    router.push('/register/umkm');
  } else if (roleName === 'designer') {
    router.push('/register/designer');
  }
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
