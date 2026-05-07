<template>
  <header class="fixed top-0 left-0 right-0 z-50 bg-white/90 backdrop-blur-2xl border-b border-gray-100/50 shadow-sm animate-slide-down">
    <nav class="max-w-[1600px] mx-auto px-6 py-2.5 flex justify-between items-center">
      <!-- Logo Section -->
      <a href="/" class="flex items-center gap-2.5 group cursor-pointer">
        <div class="w-10 h-10 rounded-xl overflow-hidden shadow-sm border border-slate-100 transform group-hover:scale-105 transition-all duration-300 flex items-center justify-center bg-white">
          <img :src="'/images/logo.png'" alt="SnapFit Logo" class="w-full h-full object-cover" />
        </div>
        <div>
          <h1 class="font-black text-lg tracking-tight text-gray-900 leading-none group-hover:text-orange-600 transition-colors">SnapFit</h1>
          
        </div>
      </a>

      <!-- Navigation Links -->
      <div class="hidden lg:flex items-center gap-1.5 bg-gray-50 px-2 py-1.5 rounded-xl border border-gray-100">
        <a href="#marketplace" class="nav-link group relative px-4 py-2 rounded-lg text-[10px] font-black uppercase tracking-[0.15em] text-gray-500 hover:text-orange-600 hover:bg-white transition-all duration-300">
          <span class="relative z-10">Marketplace</span>
          <div class="absolute inset-0 bg-orange-50 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity"></div>
        </a>
        <a href="#features" class="nav-link group relative px-4 py-2 rounded-lg text-[10px] font-black uppercase tracking-[0.15em] text-gray-500 hover:text-orange-600 hover:bg-white transition-all duration-300">
          <span class="relative z-10">AI Studio</span>
          <div class="absolute inset-0 bg-orange-50 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity"></div>
        </a>
        <a href="#features" class="nav-link group relative px-4 py-2 rounded-lg text-[10px] font-black uppercase tracking-[0.15em] text-gray-500 hover:text-orange-600 hover:bg-white transition-all duration-300">
          <span class="relative z-10">Co-Create</span>
          <div class="absolute inset-0 bg-orange-50 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity"></div>
        </a>
        <a href="#features" class="nav-link group relative px-4 py-2 rounded-lg text-[10px] font-black uppercase tracking-[0.15em] text-gray-500 hover:text-orange-600 hover:bg-white transition-all duration-300">
          <span class="relative z-10">AR Try-On</span>
          <div class="absolute inset-0 bg-orange-50 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity"></div>
        </a>
      </div>

      <!-- User Menu / Auth Section -->
      <div class="flex items-center gap-2 sm:gap-3">
        <!-- Search Input -->
        <div class="hidden md:flex relative items-center mr-2 search-container z-50">
          <input 
            v-model="searchQuery"
            @input="debouncedSearch"
            @focus="showSearchResults = searchQuery.length > 0"
            type="text" 
            placeholder="Cari Produk..." 
            class="w-48 lg:w-64 bg-gray-100/80 border border-gray-200 text-gray-800 text-xs rounded-xl pl-10 pr-4 py-2.5 outline-none focus:border-orange-400 focus:bg-white focus:ring-4 focus:ring-orange-100 transition-all placeholder-gray-500 font-bold shadow-inner" 
          />
          <svg class="w-4 h-4 text-gray-500 absolute left-3.5 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
          </svg>

          <!-- Search Results Dropdown -->
          <Transition
            enter-active-class="transition ease-out duration-200"
            enter-from-class="opacity-0 translate-y-1"
            enter-to-class="opacity-100 translate-y-0"
            leave-active-class="transition ease-in duration-150"
            leave-from-class="opacity-100 translate-y-0"
            leave-to-class="opacity-0 translate-y-1"
          >
            <div v-if="showSearchResults" class="absolute top-full mt-2 w-full bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden z-[60]">
              <div v-if="isSearching" class="p-4 text-center text-xs text-gray-500 font-bold">
                <svg class="animate-spin h-5 w-5 mx-auto text-orange-500 mb-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Mencari produk...
              </div>
              <div v-else-if="searchResults.length === 0" class="p-4 text-center text-xs text-gray-500 font-bold">
                Produk tidak ditemukan
              </div>
              <div v-else class="max-h-[60vh] overflow-y-auto hide-scrollbar">
                <a 
                  v-for="item in searchResults" 
                  :key="item.id" 
                  href="javascript:void(0)"
                  @click.prevent="goToProduct(item.id)"
                  class="flex items-center gap-3 p-3 hover:bg-orange-50 transition-colors border-b border-gray-50 last:border-0"
                >
                  <img :src="item.images?.[0] ?? item.image_url ?? '/images/placeholder.png'" class="w-10 h-10 rounded-lg object-cover bg-gray-100 flex-shrink-0" />
                  <div class="flex-1 min-w-0">
                    <p class="text-xs font-bold text-gray-900 truncate">{{ item.name }}</p>
                    <p class="text-[10px] text-orange-600 font-bold mt-0.5">Rp {{ Number(item.price ?? 0).toLocaleString('id-ID') }}</p>
                  </div>
                </a>
              </div>
            </div>
          </Transition>
        </div>


        <!-- Mobile Menu Button -->
        <button @click="toggleMobileMenu" class="lg:hidden p-2 rounded-lg hover:bg-gray-100 transition-colors">
          <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
          </svg>
        </button>

        <!-- Notification Bell (Always Visible) -->
        <div class="relative notification-menu">
          <button @click="toggleNotifications" class="relative p-1.5 rounded-lg hover:bg-gray-100 transition-colors group">
            <svg class="w-4 h-4 text-gray-600 group-hover:text-orange-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
            </svg>
            <span v-if="unreadCount > 0" class="absolute top-0.5 right-0.5 w-1.5 h-1.5 bg-red-500 rounded-full border border-white"></span>
          </button>

          <!-- Notification Dropdown -->
          <Transition
            enter-active-class="transition ease-out duration-200"
            enter-from-class="opacity-0 scale-95 -translate-y-2"
            enter-to-class="opacity-100 scale-100 translate-y-0"
            leave-active-class="transition ease-in duration-150"
            leave-from-class="opacity-100 scale-100 translate-y-0"
            leave-to-class="opacity-0 scale-95 -translate-y-2"
          >
            <div v-if="showNotifications" class="absolute right-0 sm:-right-8 top-full mt-3 w-[320px] sm:w-[380px] bg-white rounded-3xl shadow-2xl border border-gray-100 overflow-hidden z-50">
              <div class="bg-gray-50 px-5 py-4 border-b border-gray-100 flex justify-between items-center">
                <h3 class="font-black text-gray-900 text-sm">Notifikasi</h3>
                <button @click="markAllAsRead" class="text-[11px] font-bold text-orange-600 hover:text-orange-700 transition-colors">Tandai semua dibaca</button>
              </div>
              <div class="max-h-[360px] overflow-y-auto hide-scrollbar">
                <div v-if="notifications.length === 0" class="p-8 text-center text-sm text-gray-500 font-medium">
                  Belum ada notifikasi
                </div>
                <div v-else>
                  <div v-for="notif in notifications" :key="notif.id" class="p-5 border-b border-gray-50 hover:bg-orange-50/40 transition-colors cursor-pointer flex gap-3 relative">
                    <div class="w-2.5 h-2.5 rounded-full mt-1 flex-shrink-0 transition-colors duration-300" :class="notif.unread ? 'bg-orange-500 shadow-sm shadow-orange-300' : 'bg-transparent'"></div>
                    <div>
                      <h4 class="text-sm font-black text-gray-900">{{ notif.title }}</h4>
                      <p class="text-xs text-gray-600 mt-1 leading-relaxed">{{ notif.message }}</p>
                      <p class="text-[10px] text-gray-400 mt-2 font-bold">{{ notif.time }}</p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="p-4 border-t border-gray-100 text-center bg-gray-50/80 hover:bg-gray-100/80 transition-colors cursor-pointer">
                <button class="text-xs font-black text-gray-700 hover:text-orange-600 transition-colors">Lihat Semua Notifikasi</button>
              </div>
            </div>
          </Transition>
        </div>

        <!-- Cart Button (Always Visible) -->
        <div class="relative cart-menu">
          <button @click="toggleCart" class="relative p-1.5 rounded-lg hover:bg-gray-100 transition-colors group">
            <svg class="w-4 h-4 text-gray-600 group-hover:text-orange-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            <span v-if="cartCount > 0" class="absolute -top-1 -right-1 w-5 h-5 bg-orange-500 text-white text-[10px] font-black rounded-full flex items-center justify-center border border-white">
              {{ cartCount > 99 ? '99+' : cartCount }}
            </span>
          </button>

          <!-- Cart Dropdown -->
          <Transition
            enter-active-class="transition ease-out duration-200"
            enter-from-class="opacity-0 scale-95 -translate-y-2"
            enter-to-class="opacity-100 scale-100 translate-y-0"
            leave-active-class="transition ease-in duration-150"
            leave-from-class="opacity-100 scale-100 translate-y-0"
            leave-to-class="opacity-0 scale-95 -translate-y-2"
          >
            <div v-if="showCart" class="absolute right-0 sm:-right-8 top-full mt-3 w-[320px] sm:w-[380px] bg-white rounded-3xl shadow-2xl border border-gray-100 overflow-hidden z-50 flex flex-col">
              <div class="bg-gray-50 px-5 py-4 border-b border-gray-100 flex justify-between items-center">
                <h3 class="font-black text-gray-900 text-sm">Keranjang Belanja <span class="text-gray-500 font-medium">({{ cartCount }})</span></h3>
              </div>
              <div class="max-h-[360px] overflow-y-auto hide-scrollbar">
                <div v-if="cartStore.items.length === 0" class="p-8 text-center flex flex-col items-center">
                  <div class="w-16 h-16 bg-orange-50 rounded-full flex items-center justify-center mb-3">
                    <svg class="w-8 h-8 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                  </div>
                  <p class="text-sm text-gray-900 font-black mb-1">Keranjang masih kosong</p>
                  <p class="text-xs text-gray-500 font-medium">Yuk cari produk impianmu!</p>
                </div>
                <div v-else>
                  <div v-for="item in cartStore.items.slice(0, 4)" :key="item.id" class="p-4 border-b border-gray-50 flex gap-3 relative hover:bg-gray-50/50 transition-colors">
                    <img :src="item.image || '/images/placeholder.png'" class="w-14 h-14 rounded-xl object-cover bg-gray-100 flex-shrink-0" />
                    <div class="flex-1 min-w-0 flex flex-col justify-center">
                      <h4 class="text-sm font-bold text-gray-900 truncate">{{ item.name }}</h4>
                      <div class="flex justify-between items-center mt-1">
                        <p class="text-xs font-black text-orange-600">{{ cartStore.formatCurrency(item.price) }}</p>
                        <p class="text-[10px] text-gray-500 font-semibold bg-gray-100 px-2 py-0.5 rounded-md">x{{ item.quantity }}</p>
                      </div>
                    </div>
                  </div>
                  <div v-if="cartStore.items.length > 4" class="p-3 text-center text-xs font-bold text-gray-500 bg-gray-50">
                    + {{ cartStore.items.length - 4 }} produk lainnya
                  </div>
                </div>
              </div>
              <div v-if="cartStore.items.length > 0" class="p-4 border-t border-gray-100 bg-white">
                <div class="flex justify-between items-center mb-3">
                  <p class="text-xs font-semibold text-gray-500">Total Harga</p>
                  <p class="text-sm font-black text-orange-600">{{ cartStore.formatCurrency(cartStore.totalPrice) }}</p>
                </div>
                <button @click="goToCart" class="w-full bg-orange-600 text-white py-2.5 rounded-xl font-black text-xs uppercase tracking-widest hover:bg-orange-700 hover:shadow-lg transition-all active:scale-[0.98]">
                  Lihat Keranjang
                </button>
              </div>
            </div>
          </Transition>
        </div>

        <div class="h-6 w-px bg-gray-200 hidden sm:block mx-1"></div>

        <template v-if="isLoggedIn">
          <div class="relative user-menu">
            <!-- Avatar Button -->
            <button
              @click="toggleUserMenu"
              class="relative w-10 h-10 rounded-xl bg-white overflow-hidden flex items-center justify-center shadow-md shadow-orange-200/50 hover:shadow-lg hover:shadow-orange-300/50 hover:scale-105 transition-all duration-300 ring-2 ring-white"
            >
              <img :src="user.avatar || `https://api.dicebear.com/7.x/avataaars/svg?seed=${user.name}&scale=130&backgroundColor=ffdfbf,c0aede,d1d4f9`" alt="Avatar" class="w-full h-full object-cover" />
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
                <div class="bg-orange-50 px-6 py-5 border-b border-orange-100">
                  <div class="flex items-center gap-3">
                    <div class="w-14 h-14 rounded-2xl overflow-hidden bg-white flex items-center justify-center shadow-lg border border-orange-200">
                      <img :src="user.avatar || `https://api.dicebear.com/7.x/avataaars/svg?seed=${user.name}&scale=130&backgroundColor=ffdfbf,c0aede,d1d4f9`" alt="Avatar" class="w-full h-full object-cover" />
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

                  <button @click="goToCart" class="w-full flex items-center gap-3 px-6 py-3 text-sm font-bold text-gray-700 hover:bg-orange-50 hover:text-orange-600 transition-all group">
                    <div class="w-8 h-8 rounded-xl bg-gray-100 group-hover:bg-orange-100 flex items-center justify-center transition-colors">
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                      </svg>
                    </div>
                    <span>Cart</span>
                    <span v-if="cartCount > 0" class="ml-auto bg-orange-500 text-white text-xs font-black px-2 py-1 rounded-full">
                      {{ cartCount }}
                    </span>
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

        <button v-else @click="goToLogin" class="group relative bg-gray-900 text-white px-6 py-2 rounded-xl text-xs font-black uppercase tracking-widest hover:bg-orange-600 transition-all duration-300 shadow-md hover:shadow-lg hover:shadow-orange-200/50 hover:-translate-y-0.5 ml-1">
          <span class="relative z-10">Sign In</span>
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
        <div class="max-w-[1600px] mx-auto px-6 py-4 space-y-2">
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
import { useRouter } from 'vue-router';
import { useCartStore } from '@/stores/cartStore';

const router = useRouter();
const cartStore = useCartStore();

const props = defineProps({
  user: {
    type: Object,
    default: null
  }
});

const emit = defineEmits(['logout', 'goToLogin', 'goToProfile', 'goToOrders']);

const showUserMenu  = ref(false);
const showMobileMenu = ref(false);
const showNotifications = ref(false);
const showCart = ref(false);
const isLoggedIn    = computed(() => !!props.user);
const cartCount     = computed(() => cartStore.itemCount);

const toggleUserMenu  = () => { 
  showUserMenu.value  = !showUserMenu.value; 
  if (showUserMenu.value) { showNotifications.value = false; showCart.value = false; }
};

const toggleNotifications = () => {
  showNotifications.value = !showNotifications.value;
  if (showNotifications.value) { showUserMenu.value = false; showCart.value = false; }
};

const toggleCart = () => {
  showCart.value = !showCart.value;
  if (showCart.value) { showUserMenu.value = false; showNotifications.value = false; }
};

const toggleMobileMenu = () => { showMobileMenu.value = !showMobileMenu.value; };

// Notifications Dummy Data
const notifications = ref([
  { id: 1, title: 'Pesanan Dikirim', message: 'Pesanan #12345 sedang dalam perjalanan ke alamat Anda.', time: '5 mnt lalu', unread: true },
  { id: 2, title: 'Promo Spesial', message: 'Diskon 50% untuk produk kerajinan hari ini! Yuk cek sekarang.', time: '1 jam lalu', unread: true },
  { id: 3, title: 'Pembayaran Berhasil', message: 'Pembayaran pesanan #12344 telah dikonfirmasi.', time: 'Kemarin', unread: false },
]);
const unreadCount = computed(() => notifications.value.filter(n => n.unread).length);

const markAllAsRead = () => {
  notifications.value.forEach(n => n.unread = false);
};

// Search Logic
const searchQuery = ref('');
const searchResults = ref([]);
const isSearching = ref(false);
const showSearchResults = ref(false);
let searchTimeout = null;

const debouncedSearch = () => {
  if (searchTimeout) clearTimeout(searchTimeout);
  
  if (searchQuery.value.trim().length === 0) {
    searchResults.value = [];
    showSearchResults.value = false;
    return;
  }
  
  showSearchResults.value = true;
  isSearching.value = true;
  
  searchTimeout = setTimeout(async () => {
    try {
      const res = await fetch('/api/v1/products', { headers: { 'Accept': 'application/json' } });
      const data = await res.json();
      const products = Array.isArray(data) ? data : data?.data ?? [];
      
      const q = searchQuery.value.toLowerCase();
      searchResults.value = products.filter(p => 
        (p.name && p.name.toLowerCase().includes(q)) || 
        (p.category && p.category.toLowerCase().includes(q))
      ).slice(0, 5); // Ambil 5 teratas
    } catch (err) {
      console.error('Search error:', err);
    } finally {
      isSearching.value = false;
    }
  }, 300);
};

const goToProduct = (id) => {
  showSearchResults.value = false;
  searchQuery.value = '';
  router.push({ name: 'marketplace.product.detail', params: { id } });
};

const goToLogin   = () => emit('goToLogin');
const goToProfile = () => { showUserMenu.value = false; router.push('/profile'); };
const goToOrders  = () => { showUserMenu.value = false; router.push('/marketplace/orders'); };
const goToCart    = () => { showCart.value = false; router.push('/marketplace/cart'); };
const logout      = () => emit('logout');

// Close dropdown when clicking outside
const handleClickOutside = (e) => {
  if (!e.target.closest('.user-menu')) showUserMenu.value = false;
  if (!e.target.closest('.notification-menu')) showNotifications.value = false;
  if (!e.target.closest('.cart-menu')) showCart.value = false;
  if (!e.target.closest('.search-container')) showSearchResults.value = false;
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
  background: #ea580c;
  transform: translateX(-50%);
  transition: width 0.3s ease;
}

.nav-link:hover::after {
  width: 60%;
}

@keyframes slideDown {
  from {
    transform: translateY(-100%);
  }
  to {
    transform: translateY(0);
  }
}

.animate-slide-down {
  animation: slideDown 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
}

.hide-scrollbar::-webkit-scrollbar {
  display: none;
}
.hide-scrollbar {
  -ms-overflow-style: none;
  scrollbar-width: none;
}
</style>
