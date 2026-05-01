<template>
  <header class="sticky top-0 z-50 bg-white/90 backdrop-blur-2xl border-b border-gray-100/50 shadow-sm">
    <nav class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
      <!-- Logo Section -->
      <a href="/" class="flex items-center gap-3 group cursor-pointer">
        <div class="w-11 h-11 bg-gradient-to-br from-orange-600 via-orange-500 to-amber-400 rounded-2xl shadow-lg shadow-orange-200/50 flex items-center justify-center transform group-hover:scale-105 group-hover:rotate-3 transition-all duration-300">
          <span class="text-white font-black text-xl italic drop-shadow-sm">S</span>
        </div>
        <div>
          <h1 class="font-black text-xl tracking-tight text-gray-900 leading-none group-hover:text-orange-600 transition-colors">SnapFit</h1>
          <p class="text-[8px] font-bold tracking-[0.3em] text-orange-500 uppercase mt-0.5">Creative Hub</p>
        </div>
      </a>

      <!-- Navigation Links -->
      <div class="hidden lg:flex items-center gap-2 bg-gray-50/80 px-3 py-2 rounded-2xl border border-gray-100">
        <a href="#marketplace" class="nav-link group relative px-5 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-[0.15em] text-gray-500 hover:text-orange-600 hover:bg-white transition-all duration-300">
          <span class="relative z-10">Marketplace</span>
          <div class="absolute inset-0 bg-gradient-to-r from-orange-50 to-amber-50 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
        </a>
        <a href="#features" class="nav-link group relative px-5 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-[0.15em] text-gray-500 hover:text-orange-600 hover:bg-white transition-all duration-300">
          <span class="relative z-10">AI Studio</span>
          <div class="absolute inset-0 bg-gradient-to-r from-orange-50 to-amber-50 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
        </a>
        <a href="#features" class="nav-link group relative px-5 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-[0.15em] text-gray-500 hover:text-orange-600 hover:bg-white transition-all duration-300">
          <span class="relative z-10">Co-Create</span>
          <div class="absolute inset-0 bg-gradient-to-r from-orange-50 to-amber-50 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
        </a>
        <a href="#features" class="nav-link group relative px-5 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-[0.15em] text-gray-500 hover:text-orange-600 hover:bg-white transition-all duration-300">
          <span class="relative z-10">AR Try-On</span>
          <div class="absolute inset-0 bg-gradient-to-r from-orange-50 to-amber-50 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
        </a>
      </div>

      <!-- User Menu / Auth Section -->
      <div class="flex items-center gap-4">
        <!-- Mobile Menu Button -->
        <button @click="toggleMobileMenu" class="lg:hidden p-2 rounded-xl hover:bg-gray-100 transition-colors">
          <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
          </svg>
        </button>

        <template v-if="isLoggedIn">
          <div class="flex items-center gap-4 border-l pl-4 border-gray-200 relative user-menu">
            <!-- Notification Bell -->
            <button class="relative p-2 rounded-xl hover:bg-gray-100 transition-colors group">
              <svg class="w-5 h-5 text-gray-600 group-hover:text-orange-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
              </svg>
              <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full border-2 border-white"></span>
            </button>

            <!-- User Info -->
            <div class="text-right hidden sm:block">
              <p class="text-xs font-black text-gray-900 leading-none">{{ user.name }}</p>
              <div class="flex items-center justify-end gap-1 mt-1">
                <span class="w-1.5 h-1.5 bg-green-500 rounded-full animate-pulse"></span>
                <p class="text-[9px] text-gray-500 font-bold uppercase tracking-wider">Online</p>
              </div>
            </div>

            <!-- Avatar Button -->
            <button
              @click="toggleUserMenu"
              class="relative w-11 h-11 rounded-2xl bg-gradient-to-br from-orange-500 via-orange-400 to-amber-400 flex items-center justify-center text-white font-black shadow-lg shadow-orange-200/50 hover:shadow-xl hover:shadow-orange-300/50 hover:scale-105 transition-all duration-300 ring-2 ring-white"
            >
              <span class="text-sm">{{ user.name.charAt(0).toUpperCase() }}</span>
              <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-green-500 rounded-full border-2 border-white"></div>
            </button>

            <!-- Dropdown Menu -->
            <Transition
              enter-active-class="transition ease-out duration-200"
              enter-from-class="opacity-0 scale-95 -translate-y-2"
              enter-to-class="opacity-100 scale-100 translate-y-0"
              leave-active-class="transition ease-in duration-150"
              leave-from-class="opacity-100 scale-100 translate-y-0"
              leave-to-class="opacity-0 scale-95 -translate-y-2"
            >
              <div v-if="showUserMenu" class="absolute right-0 top-full mt-3 w-64 bg-white rounded-3xl shadow-2xl border border-gray-100 overflow-hidden z-50">
                <!-- User Header -->
                <div class="bg-gradient-to-br from-orange-50 to-amber-50 px-6 py-5 border-b border-orange-100">
                  <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-orange-500 to-amber-400 flex items-center justify-center text-white font-black text-lg shadow-lg">
                      {{ user.name.charAt(0).toUpperCase() }}
                    </div>
                    <div>
                      <p class="text-sm font-black text-gray-900">{{ user.name }}</p>
                      <p class="text-[10px] text-orange-600 font-bold uppercase tracking-wider">Premium Member</p>
                    </div>
                  </div>
                </div>

                <!-- Menu Items -->
                <div class="py-2">
                  <button @click="goToProfile" class="w-full flex items-center gap-3 px-6 py-3 text-sm font-bold text-gray-700 hover:bg-orange-50 hover:text-orange-600 transition-all group">
                    <div class="w-8 h-8 rounded-xl bg-gray-100 group-hover:bg-orange-100 flex items-center justify-center transition-colors">
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                      </svg>
                    </div>
                    <span>My Profile</span>
                  </button>

                  <button @click="goToOrders" class="w-full flex items-center gap-3 px-6 py-3 text-sm font-bold text-gray-700 hover:bg-orange-50 hover:text-orange-600 transition-all group">
                    <div class="w-8 h-8 rounded-xl bg-gray-100 group-hover:bg-orange-100 flex items-center justify-center transition-colors">
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                      </svg>
                    </div>
                    <span>My Orders</span>
                  </button>

                  <button class="w-full flex items-center gap-3 px-6 py-3 text-sm font-bold text-gray-700 hover:bg-orange-50 hover:text-orange-600 transition-all group">
                    <div class="w-8 h-8 rounded-xl bg-gray-100 group-hover:bg-orange-100 flex items-center justify-center transition-colors">
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                      </svg>
                    </div>
                    <span>Wishlist</span>
                  </button>
                </div>

                <!-- Logout -->
                <div class="border-t border-gray-100 p-2">
                  <button @click="logout" class="w-full flex items-center gap-3 px-6 py-3 text-sm font-black text-red-600 hover:bg-red-50 rounded-2xl transition-all group">
                    <div class="w-8 h-8 rounded-xl bg-red-50 group-hover:bg-red-100 flex items-center justify-center transition-colors">
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                      </svg>
                    </div>
                    <span>Sign Out</span>
                  </button>
                </div>
              </div>
            </Transition>
          </div>
        </template>

        <button v-else @click="goToLogin" class="group relative bg-gradient-to-r from-gray-900 to-gray-800 text-white px-8 py-3 rounded-2xl text-xs font-black uppercase tracking-widest hover:from-orange-600 hover:to-orange-500 transition-all duration-300 shadow-lg hover:shadow-xl hover:shadow-orange-200/50 hover:-translate-y-0.5 overflow-hidden">
          <span class="relative z-10">Sign In</span>
          <div class="absolute inset-0 bg-gradient-to-r from-orange-600 to-orange-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
        </button>
      </div>
    </nav>

    <!-- Mobile Menu -->
    <Transition
      enter-active-class="transition ease-out duration-200"
      enter-from-class="opacity-0 -translate-y-4"
      enter-to-class="opacity-100 translate-y-0"
      leave-active-class="transition ease-in duration-150"
      leave-from-class="opacity-100 translate-y-0"
      leave-to-class="opacity-0 -translate-y-4"
    >
      <div v-if="showMobileMenu" class="lg:hidden border-t border-gray-100 bg-white/95 backdrop-blur-xl">
        <div class="max-w-7xl mx-auto px-6 py-4 space-y-2">
          <a href="#marketplace" class="block px-4 py-3 rounded-xl text-sm font-bold text-gray-700 hover:bg-orange-50 hover:text-orange-600 transition-all">Marketplace</a>
          <a href="#features" class="block px-4 py-3 rounded-xl text-sm font-bold text-gray-700 hover:bg-orange-50 hover:text-orange-600 transition-all">AI Studio</a>
          <a href="#features" class="block px-4 py-3 rounded-xl text-sm font-bold text-gray-700 hover:bg-orange-50 hover:text-orange-600 transition-all">Co-Create</a>
          <a href="#features" class="block px-4 py-3 rounded-xl text-sm font-bold text-gray-700 hover:bg-orange-50 hover:text-orange-600 transition-all">AR Try-On</a>
        </div>
      </div>
    </Transition>
  </header>
</template>

<script setup>
import { ref, computed, onMounted, onBeforeUnmount } from 'vue';

const props = defineProps({
  user: {
    type: Object,
    default: null
  }
});

const emit = defineEmits(['logout', 'goToLogin', 'goToProfile', 'goToOrders']);

const showUserMenu  = ref(false);
const showMobileMenu = ref(false);
const isLoggedIn    = computed(() => !!props.user);

const toggleUserMenu  = () => { showUserMenu.value  = !showUserMenu.value; };
const toggleMobileMenu = () => { showMobileMenu.value = !showMobileMenu.value; };

const goToLogin   = () => emit('goToLogin');
const goToProfile = () => { showUserMenu.value = false; emit('goToProfile'); };
const goToOrders  = () => { showUserMenu.value = false; emit('goToOrders'); };
const logout      = () => emit('logout');

// Close dropdown when clicking outside
const handleClickOutside = (e) => {
  if (!e.target.closest('.user-menu')) showUserMenu.value = false;
};

onMounted(() => document.addEventListener('click', handleClickOutside));
onBeforeUnmount(() => document.removeEventListener('click', handleClickOutside));
</script>

<style scoped>
.nav-link::after {
  content: '';
  position: absolute;
  bottom: 0;
  left: 50%;
  width: 0;
  height: 2px;
  background: linear-gradient(to right, #ea580c, #fbbf24);
  transform: translateX(-50%);
  transition: width 0.3s ease;
}

.nav-link:hover::after {
  width: 60%;
}
</style>
