<template>
  <div class="min-h-screen bg-gray-50 font-sans selection:bg-orange-100">

    <!-- Sidebar Desktop -->
    <aside class="fixed inset-y-0 left-0 w-72 bg-white border-r border-orange-50 hidden lg:block z-30 shadow-sm">
      <div class="flex flex-col h-full">

        <!-- Logo -->
        <div class="p-8 border-b border-orange-50">
          <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-gradient-to-br from-orange-600 to-amber-400 rounded-xl shadow-lg shadow-orange-200 flex items-center justify-center">
              <span class="text-white font-black text-xl italic">S</span>
            </div>
            <div>
              <h1 class="font-black text-xl tracking-tight text-gray-900 leading-none">SnapFit</h1>
              <p class="text-[8px] font-bold tracking-[0.3em] text-orange-500 uppercase mt-1">Seller Dashboard</p>
            </div>
          </div>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 p-6">
          <p class="text-[9px] font-black text-gray-300 uppercase tracking-[0.3em] mb-4 px-2">Menu</p>
          <ul class="space-y-1">
            <li>
              <a
                href="#"
                :class="[
                  'group flex items-center gap-3 px-4 py-3 rounded-2xl transition-all duration-200 text-xs font-black uppercase tracking-widest',
                  activeTab === 'dashboard'
                    ? 'bg-gray-900 text-white shadow-xl'
                    : 'text-gray-400 hover:text-orange-600 hover:bg-orange-50'
                ]"
                @click="activeTab = 'dashboard'"
              >
                <svg class="w-4 h-4 flex-shrink-0" :class="activeTab === 'dashboard' ? 'text-orange-400' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"/>
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v2H8V5z"/>
                </svg>
                Dashboard
              </a>
            </li>
            <li>
              <a
                href="#"
                :class="[
                  'group flex items-center gap-3 px-4 py-3 rounded-2xl transition-all duration-200 text-xs font-black uppercase tracking-widest',
                  activeTab === 'products'
                    ? 'bg-gray-900 text-white shadow-xl'
                    : 'text-gray-400 hover:text-orange-600 hover:bg-orange-50'
                ]"
                @click="activeTab = 'products'"
              >
                <svg class="w-4 h-4 flex-shrink-0" :class="activeTab === 'products' ? 'text-orange-400' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
                Produk
              </a>
            </li>
            <li>
              <a
                href="#"
                :class="[
                  'group flex items-center gap-3 px-4 py-3 rounded-2xl transition-all duration-200 text-xs font-black uppercase tracking-widest',
                  activeTab === 'add-product'
                    ? 'bg-gray-900 text-white shadow-xl'
                    : 'text-gray-400 hover:text-orange-600 hover:bg-orange-50'
                ]"
                @click="activeTab = 'add-product'"
              >
                <svg class="w-4 h-4 flex-shrink-0" :class="activeTab === 'add-product' ? 'text-orange-400' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Produk
              </a>
            </li>
            <li>
              <a
                href="#"
                :class="[
                  'group flex items-center gap-3 px-4 py-3 rounded-2xl transition-all duration-200 text-xs font-black uppercase tracking-widest',
                  activeTab === 'orders'
                    ? 'bg-blue-900 text-white shadow-xl'
                    : 'text-gray-400 hover:text-orange-600 hover:bg-orange-50'
                ]"
                @click="activeTab = 'orders'"
              >
                <svg class="w-4 h-4 flex-shrink-0" :class="activeTab === 'orders' ? 'text-orange-400' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Pesanan
              </a>
            </li>
            <li>
              <a
                href="#"
                :class="[
                  'group flex items-center gap-3 px-4 py-3 rounded-2xl transition-all duration-200 text-xs font-black uppercase tracking-widest',
                  activeTab === 'transactions'
                    ? 'bg-blue-900 text-white shadow-xl'
                    : 'text-gray-400 hover:text-orange-600 hover:bg-orange-50'
                ]"
                @click="activeTab = 'transactions'"
              >
                <svg class="w-4 h-4 flex-shrink-0" :class="activeTab === 'transactions' ? 'text-orange-400' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                </svg>
                Transaksi
              </a>
            </li>
            <li>
              <a
                href="#"
                :class="[
                  'group flex items-center gap-3 px-4 py-3 rounded-2xl transition-all duration-200 text-xs font-black uppercase tracking-widest',
                  activeTab === 'analytics'
                    ? 'bg-blue-900 text-white shadow-xl'
                    : 'text-gray-400 hover:text-orange-600 hover:bg-orange-50'
                ]"
                @click="activeTab = 'analytics'"
              >
                <svg class="w-4 h-4 flex-shrink-0" :class="activeTab === 'analytics' ? 'text-orange-400' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                Analitik
              </a>
            </li>
          </ul>
        </nav>

        <!-- User Info -->
        <div class="p-6 border-t border-orange-50">
          <div class="flex items-center gap-3">
            <div class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center">
              <span class="text-orange-600 font-bold text-sm">{{ user?.name?.charAt(0) || 'U' }}</span>
            </div>
            <div class="flex-1 min-w-0">
              <p class="text-xs font-bold text-gray-900 truncate">{{ user?.name || 'Seller' }}</p>
              <p class="text-[8px] font-bold text-orange-500 uppercase tracking-widest">UMKM Partner</p>
            </div>
          </div>
        </div>
      </div>
    </aside>

    <!-- Mobile Sidebar Overlay -->
    <div v-if="mobileMenuOpen" class="fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden" @click="mobileMenuOpen = false"></div>

    <!-- Mobile Sidebar -->
    <aside class="fixed inset-y-0 left-0 w-72 bg-white border-r border-orange-50 lg:hidden z-50 transform transition-transform duration-300" :class="mobileMenuOpen ? 'translate-x-0' : '-translate-x-full'">
      <div class="flex flex-col h-full">
        <!-- Mobile Header -->
        <div class="p-6 border-b border-orange-50">
          <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
              <div class="w-10 h-10 bg-gradient-to-br from-orange-600 to-amber-400 rounded-xl shadow-lg shadow-orange-200 flex items-center justify-center">
                <span class="text-white font-black text-xl italic">S</span>
              </div>
              <div>
                <h1 class="font-black text-xl tracking-tight text-gray-900 leading-none">SnapFit</h1>
                <p class="text-[8px] font-bold tracking-[0.3em] text-orange-500 uppercase mt-1">Seller Dashboard</p>
              </div>
            </div>
            <button @click="mobileMenuOpen = false" class="p-2 rounded-lg hover:bg-gray-100 transition-colors">
              <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
              </svg>
            </button>
          </div>
        </div>

        <!-- Mobile Navigation -->
        <nav class="flex-1 p-6">
          <p class="text-[9px] font-black text-gray-300 uppercase tracking-[0.3em] mb-4 px-2">Menu</p>
          <ul class="space-y-1">
            <li>
              <a
                href="#"
                :class="[
                  'group flex items-center gap-3 px-4 py-3 rounded-2xl transition-all duration-200 text-xs font-black uppercase tracking-widest',
                  activeTab === 'dashboard'
                    ? 'bg-gray-900 text-white shadow-xl'
                    : 'text-gray-400 hover:text-orange-600 hover:bg-orange-50'
                ]"
                @click="activeTab = 'dashboard'; mobileMenuOpen = false"
              >
                <svg class="w-4 h-4 flex-shrink-0" :class="activeTab === 'dashboard' ? 'text-orange-400' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"/>
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v2H8V5z"/>
                </svg>
                Dashboard
              </a>
            </li>
            <li>
              <a
                href="#"
                :class="[
                  'group flex items-center gap-3 px-4 py-3 rounded-2xl transition-all duration-200 text-xs font-black uppercase tracking-widest',
                  activeTab === 'products'
                    ? 'bg-blue-900 text-white shadow-xl'
                    : 'text-gray-400 hover:text-orange-600 hover:bg-orange-50'
                ]"
                @click="activeTab = 'products'; mobileMenuOpen = false"
              >
                <svg class="w-4 h-4 flex-shrink-0" :class="activeTab === 'products' ? 'text-orange-400' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
                Produk
              </a>
            </li>
            <li>
              <a
                href="#"
                :class="[
                  'group flex items-center gap-3 px-4 py-3 rounded-2xl transition-all duration-200 text-xs font-black uppercase tracking-widest',
                  activeTab === 'add-product'
                    ? 'bg-blue-900 text-white shadow-xl'
                    : 'text-gray-400 hover:text-orange-600 hover:bg-orange-50'
                ]"
                @click="activeTab = 'add-product'; mobileMenuOpen = false"
              >
                <svg class="w-4 h-4 flex-shrink-0" :class="activeTab === 'add-product' ? 'text-orange-400' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Produk
              </a>
            </li>
            <li>
              <a
                href="#"
                :class="[
                  'group flex items-center gap-3 px-4 py-3 rounded-2xl transition-all duration-200 text-xs font-black uppercase tracking-widest',
                  activeTab === 'orders'
                    ? 'bg-blue-900 text-white shadow-xl'
                    : 'text-gray-400 hover:text-orange-600 hover:bg-orange-50'
                ]"
                @click="activeTab = 'orders'; mobileMenuOpen = false"
              >
                <svg class="w-4 h-4 flex-shrink-0" :class="activeTab === 'orders' ? 'text-orange-400' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Pesanan
              </a>
            </li>
            <li>
              <a
                href="#"
                :class="[
                  'group flex items-center gap-3 px-4 py-3 rounded-2xl transition-all duration-200 text-xs font-black uppercase tracking-widest',
                  activeTab === 'transactions'
                    ? 'bg-blue-900 text-white shadow-xl'
                    : 'text-gray-400 hover:text-orange-600 hover:bg-orange-50'
                ]"
                @click="activeTab = 'transactions'; mobileMenuOpen = false"
              >
                <svg class="w-4 h-4 flex-shrink-0" :class="activeTab === 'transactions' ? 'text-orange-400' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                </svg>
                Transaksi
              </a>
            </li>
            <li>
              <a
                href="#"
                :class="[
                  'group flex items-center gap-3 px-4 py-3 rounded-2xl transition-all duration-200 text-xs font-black uppercase tracking-widest',
                  activeTab === 'analytics'
                    ? 'bg-blue-900 text-white shadow-xl'
                    : 'text-gray-400 hover:text-orange-600 hover:bg-orange-50'
                ]"
                @click="activeTab = 'analytics'; mobileMenuOpen = false"
              >
                <svg class="w-4 h-4 flex-shrink-0" :class="activeTab === 'analytics' ? 'text-orange-400' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                Analitik
              </a>
            </li>
          </ul>
        </nav>

        <!-- Mobile User Info -->
        <div class="p-6 border-t border-orange-50">
          <div class="flex items-center gap-3">
            <div class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center">
              <span class="text-orange-600 font-bold text-sm">{{ user?.name?.charAt(0) || 'U' }}</span>
            </div>
            <div class="flex-1 min-w-0">
              <p class="text-xs font-bold text-gray-900 truncate">{{ user?.name || 'Seller' }}</p>
              <p class="text-[8px] font-bold text-orange-500 uppercase tracking-widest">UMKM Partner</p>
            </div>
          </div>
        </div>
      </div>
    </aside>

    <!-- Main Content -->
    <div class="lg:pl-72">
      <!-- Topbar -->
      <header class="bg-white border-b border-orange-50 px-6 py-4 lg:px-8">
        <div class="flex items-center justify-between">
          <!-- Mobile Menu Button -->
          <button @click="mobileMenuOpen = true" class="lg:hidden p-2 rounded-lg hover:bg-gray-100 transition-colors">
            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
          </button>

          <!-- Search -->
          <div class="flex-1 max-w-md mx-6">
            <div class="relative">
              <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
              </svg>
              <input
                type="text"
                placeholder="Cari produk, pesanan..."
                class="w-full bg-gray-50 border border-gray-200 rounded-xl pl-12 pr-4 py-3 text-sm font-medium text-gray-900 placeholder-gray-500 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all"
              />
            </div>
          </div>

          <!-- Actions -->
          <div class="flex items-center gap-4">
            <!-- Notifications -->
            <button class="relative p-2 rounded-lg hover:bg-gray-100 transition-colors">
              <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 12a9 9 0 01-9 9H9l-5 5V12a9 9 0 019-9h3a9 9 0 019 9z"/>
              </svg>
              <span class="absolute -top-1 -right-1 w-3 h-3 bg-red-500 rounded-full border-2 border-white"></span>
            </button>

            <!-- Profile -->
            <div class="flex items-center gap-3">
              <div class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center">
                <span class="text-orange-600 font-bold text-sm">{{ user?.name?.charAt(0) || 'U' }}</span>
              </div>
              <div class="hidden sm:block">
                <p class="text-sm font-bold text-gray-900">{{ user?.name || 'Seller' }}</p>
                <p class="text-xs text-gray-500">Online</p>
              </div>
            </div>
          </div>
        </div>
      </header>

      <!-- Content -->
      <main class="p-6 lg:p-8">
        <!-- Dashboard Tab -->
        <div v-if="activeTab === 'dashboard'" class="space-y-8">
          <!-- Welcome Section -->
          <div class="bg-gradient-to-r from-orange-600 to-amber-400 rounded-3xl p-8 text-white">
            <div class="flex items-center justify-between">
              <div>
                <h1 class="text-3xl font-black mb-2">Selamat Datang, {{ user?.name || 'Seller' }}!</h1>
                <p class="text-orange-100 font-medium">Pantau performa toko Anda hari ini</p>
              </div>
              <div class="hidden md:block">
                <svg class="w-24 h-24 text-orange-200" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                </svg>
              </div>
            </div>
          </div>

          <!-- Stats Cards -->
          <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6">
            <!-- Total Produk -->
            <div class="bg-white rounded-2xl p-5 lg:p-6 border border-orange-50 shadow-sm hover:shadow-md transition-all duration-200">
              <div class="flex items-center justify-between">
                <div class="flex-1 min-w-0">
                  <p class="text-xs font-black text-orange-600 uppercase tracking-widest mb-1">Total Produk</p>
                  <p class="text-2xl lg:text-3xl font-black text-gray-900 leading-none">{{ stats.totalProducts }}</p>
                  <p class="text-xs text-gray-500 mt-1">Aktif dijual</p>
                </div>
                <div class="w-10 h-10 lg:w-12 lg:h-12 bg-orange-100 rounded-xl flex items-center justify-center ml-3 flex-shrink-0">
                  <svg class="w-5 h-5 lg:w-6 lg:h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                  </svg>
                </div>
              </div>
            </div>

            <!-- Pesanan Hari Ini -->
            <div class="bg-white rounded-2xl p-5 lg:p-6 border border-orange-50 shadow-sm hover:shadow-md transition-all duration-200">
              <div class="flex items-center justify-between">
                <div class="flex-1 min-w-0">
                  <p class="text-xs font-black text-green-600 uppercase tracking-widest mb-1">Pesanan Hari Ini</p>
                  <p class="text-2xl lg:text-3xl font-black text-gray-900 leading-none">{{ stats.todayOrders }}</p>
                  <p class="text-xs text-gray-500 mt-1">Menunggu proses</p>
                </div>
                <div class="w-10 h-10 lg:w-12 lg:h-12 bg-green-100 rounded-xl flex items-center justify-center ml-3 flex-shrink-0">
                  <svg class="w-5 h-5 lg:w-6 lg:h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                  </svg>
                </div>
              </div>
            </div>

            <!-- Pendapatan Bulan Ini -->
            <div class="bg-white rounded-2xl p-5 lg:p-6 border border-orange-50 shadow-sm hover:shadow-md transition-all duration-200">
              <div class="flex items-center justify-between">
                <div class="flex-1 min-w-0">
                  <p class="text-xs font-black text-purple-600 uppercase tracking-widest mb-1">Pendapatan Bulan Ini</p>
                  <p class="text-xl lg:text-2xl font-black text-gray-900 leading-none">Rp {{ stats.monthlyRevenue.toLocaleString() }}</p>
                  <p class="text-xs text-gray-500 mt-1">+{{ stats.revenueGrowth }}% dari bulan lalu</p>
                </div>
                <div class="w-10 h-10 lg:w-12 lg:h-12 bg-purple-100 rounded-xl flex items-center justify-center ml-3 flex-shrink-0">
                  <svg class="w-5 h-5 lg:w-6 lg:h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                  </svg>
                </div>
              </div>
            </div>

            <!-- Rating Rata-rata -->
            <div class="bg-white rounded-2xl p-5 lg:p-6 border border-orange-50 shadow-sm hover:shadow-md transition-all duration-200">
              <div class="flex items-center justify-between">
                <div class="flex-1 min-w-0">
                  <p class="text-xs font-black text-yellow-600 uppercase tracking-widest mb-1">Rating Rata-rata</p>
                  <p class="text-2xl lg:text-3xl font-black text-gray-900 leading-none flex items-center gap-1">
                    {{ stats.averageRating }}
                    <svg class="w-4 h-4 lg:w-5 lg:h-5 text-yellow-500" fill="currentColor" viewBox="0 0 24 24">
                      <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                    </svg>
                  </p>
                  <p class="text-xs text-gray-500 mt-1">Dari {{ stats.totalReviews }} ulasan</p>
                </div>
                <div class="w-10 h-10 lg:w-12 lg:h-12 bg-yellow-100 rounded-xl flex items-center justify-center ml-3 flex-shrink-0">
                  <svg class="w-5 h-5 lg:w-6 lg:h-6 text-yellow-600" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                  </svg>
                </div>
              </div>
            </div>
          </div>

          <!-- Recent Orders -->
          <div class="bg-white rounded-2xl border border-orange-50 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-orange-50">
              <h3 class="text-xl font-black text-gray-900">Pesanan Terbaru</h3>
            </div>
            <div class="divide-y divide-orange-50">
              <div v-for="order in recentOrders" :key="order.id" class="p-6 hover:bg-orange-50/50 transition-colors">
                <div class="flex items-center justify-between">
                  <div class="flex items-center gap-4">
                    <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center">
                      <span class="text-orange-600 font-bold text-sm">{{ order.customer.charAt(0) }}</span>
                    </div>
                    <div>
                      <p class="font-bold text-gray-900">{{ order.customer }}</p>
                      <p class="text-sm text-gray-500">{{ order.product }}</p>
                    </div>
                  </div>
                  <div class="text-right">
                    <p class="font-bold text-gray-900">Rp {{ order.amount.toLocaleString() }}</p>
                    <p class="text-sm text-gray-500">{{ order.status }}</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Products Tab -->
        <div v-if="activeTab === 'products'" class="space-y-6">
          <div class="flex items-center justify-between">
            <h2 class="text-2xl font-black text-gray-900">Kelola Produk</h2>
            <button @click="activeTab = 'add-product'" class="bg-orange-600 text-white px-6 py-3 rounded-xl font-bold hover:bg-orange-700 transition-colors">
              Tambah Produk
            </button>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div v-for="product in products" :key="product.id" class="bg-white rounded-2xl border border-orange-50 shadow-sm overflow-hidden">
              <div class="aspect-square bg-gray-100 relative">
                <img :src="product.image" :alt="product.name" class="w-full h-full object-cover">
                <div class="absolute top-3 right-3">
                  <span :class="[
                    'px-3 py-1 rounded-full text-xs font-bold uppercase tracking-widest',
                    product.status === 'active' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'
                  ]">
                    {{ product.status }}
                  </span>
                </div>
              </div>
              <div class="p-6">
                <h3 class="font-bold text-gray-900 mb-2">{{ product.name }}</h3>
                <p class="text-sm text-gray-500 mb-4">{{ product.description }}</p>
                <div class="flex items-center justify-between">
                  <span class="text-xl font-black text-gray-900">Rp {{ product.price.toLocaleString() }}</span>
                  <div class="flex gap-2">
                    <button class="p-2 text-gray-400 hover:text-orange-600 transition-colors">
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                      </svg>
                    </button>
                    <button class="p-2 text-gray-400 hover:text-red-600 transition-colors">
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                      </svg>
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Add Product Tab -->
        <div v-if="activeTab === 'add-product'" class="max-w-2xl">
          <div class="bg-white rounded-2xl border border-orange-50 shadow-sm p-8">
            <h2 class="text-2xl font-black text-gray-900 mb-6">Tambah Produk Baru</h2>
            <form class="space-y-6">
              <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Nama Produk</label>
                <input v-model="newProduct.name" type="text" class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
              </div>
              <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Deskripsi</label>
                <textarea v-model="newProduct.description" rows="4" class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-orange-500 focus:border-orange-500"></textarea>
              </div>
              <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Harga</label>
                <input v-model="newProduct.price" type="number" class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
              </div>
              <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Gambar Produk</label>
                <input type="file" accept="image/*" class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
              </div>
              <button type="submit" class="w-full bg-orange-600 text-white py-3 rounded-xl font-bold hover:bg-orange-700 transition-colors">
                Simpan Produk
              </button>
            </form>
          </div>
        </div>

        <!-- Orders Tab -->
        <div v-if="activeTab === 'orders'" class="space-y-6">
          <h2 class="text-2xl font-black text-gray-900">Kelola Pesanan</h2>
          <div class="bg-white rounded-2xl border border-orange-50 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
              <table class="w-full">
                <thead class="bg-orange-50">
                  <tr>
                    <th class="px-6 py-4 text-left text-xs font-black text-orange-700 uppercase tracking-widest">ID Pesanan</th>
                    <th class="px-6 py-4 text-left text-xs font-black text-orange-700 uppercase tracking-widest">Pelanggan</th>
                    <th class="px-6 py-4 text-left text-xs font-black text-orange-700 uppercase tracking-widest">Produk</th>
                    <th class="px-6 py-4 text-left text-xs font-black text-orange-700 uppercase tracking-widest">Total</th>
                    <th class="px-6 py-4 text-left text-xs font-black text-orange-700 uppercase tracking-widest">Status</th>
                    <th class="px-6 py-4 text-left text-xs font-black text-orange-700 uppercase tracking-widest">Aksi</th>
                  </tr>
                </thead>
                <tbody class="divide-y divide-orange-50">
                  <tr v-for="order in orders" :key="order.id" class="hover:bg-orange-50/50 transition-colors">
                    <td class="px-6 py-4 text-sm font-bold text-gray-900">#{{ order.id }}</td>
                    <td class="px-6 py-4 text-sm text-gray-900">{{ order.customer }}</td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ order.product }}</td>
                    <td class="px-6 py-4 text-sm font-bold text-gray-900">Rp {{ order.amount.toLocaleString() }}</td>
                    <td class="px-6 py-4">
                      <span :class="[
                        'px-3 py-1 rounded-full text-xs font-bold uppercase tracking-widest',
                        order.status === 'completed' ? 'bg-green-100 text-green-700' :
                        order.status === 'pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700'
                      ]">
                        {{ order.status }}
                      </span>
                    </td>
                    <td class="px-6 py-4">
                      <button class="text-orange-600 hover:text-orange-800 font-bold text-sm">Detail</button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <!-- Transactions Tab -->
        <div v-if="activeTab === 'transactions'" class="space-y-6">
          <h2 class="text-2xl font-black text-gray-900">Riwayat Transaksi</h2>
          <div class="bg-white rounded-2xl border border-orange-50 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
              <table class="w-full">
                <thead class="bg-orange-50">
                  <tr>
                    <th class="px-6 py-4 text-left text-xs font-black text-orange-700 uppercase tracking-widest">Tanggal</th>
                    <th class="px-6 py-4 text-left text-xs font-black text-orange-700 uppercase tracking-widest">Deskripsi</th>
                    <th class="px-6 py-4 text-left text-xs font-black text-orange-700 uppercase tracking-widest">Jumlah</th>
                    <th class="px-6 py-4 text-left text-xs font-black text-orange-700 uppercase tracking-widest">Status</th>
                  </tr>
                </thead>
                <tbody class="divide-y divide-orange-50">
                  <tr v-for="transaction in transactions" :key="transaction.id" class="hover:bg-orange-50/50 transition-colors">
                    <td class="px-6 py-4 text-sm text-gray-900">{{ transaction.date }}</td>
                    <td class="px-6 py-4 text-sm text-gray-900">{{ transaction.description }}</td>
                    <td class="px-6 py-4 text-sm font-bold" :class="transaction.type === 'credit' ? 'text-green-600' : 'text-red-600'">
                      {{ transaction.type === 'credit' ? '+' : '-' }}Rp {{ transaction.amount.toLocaleString() }}
                    </td>
                    <td class="px-6 py-4">
                      <span :class="[
                        'px-3 py-1 rounded-full text-xs font-bold uppercase tracking-widest',
                        transaction.status === 'completed' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700'
                      ]">
                        {{ transaction.status }}
                      </span>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <!-- Analytics Tab -->
        <div v-if="activeTab === 'analytics'" class="space-y-6">
          <h2 class="text-2xl font-black text-gray-900">Analitik Penjualan</h2>
          <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white rounded-2xl border border-orange-50 shadow-sm p-6">
              <h3 class="text-lg font-black text-gray-900 mb-4">Penjualan Bulanan</h3>
              <div class="h-64 flex items-end justify-between gap-2">
                <div v-for="month in monthlySales" :key="month.month" class="flex-1 flex flex-col items-center">
                  <div class="w-full bg-orange-200 rounded-t-lg mb-2" :style="{ height: (month.sales / 100000) * 200 + 'px' }"></div>
                  <span class="text-xs font-bold text-gray-500">{{ month.month }}</span>
                </div>
              </div>
            </div>
            <div class="bg-white rounded-2xl border border-orange-50 shadow-sm p-6">
              <h3 class="text-lg font-black text-gray-900 mb-4">Produk Terlaris</h3>
              <div class="space-y-4">
                <div v-for="product in topProducts" :key="product.name" class="flex items-center justify-between">
                  <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center">
                      <span class="text-orange-600 font-bold text-sm">{{ product.name.charAt(0) }}</span>
                    </div>
                    <span class="font-bold text-gray-900">{{ product.name }}</span>
                  </div>
                  <span class="font-bold text-gray-500">{{ product.sales }} terjual</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </main>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'

// Reactive data
const activeTab = ref('dashboard')
const mobileMenuOpen = ref(false)
const user = ref(JSON.parse(localStorage.getItem('user')) || null)

// Stats data
const stats = ref({
  totalProducts: 24,
  todayOrders: 8,
  monthlyRevenue: 2500000,
  revenueGrowth: 12,
  averageRating: 4.8,
  totalReviews: 245
})

// Recent orders
const recentOrders = ref([
  { id: 1, customer: 'Ahmad Rahman', product: 'Kaos Custom Premium', amount: 150000, status: 'Dikirim' },
  { id: 2, customer: 'Siti Nurhaliza', product: 'Totebag Canvas', amount: 85000, status: 'Diproses' },
  { id: 3, customer: 'Budi Santoso', product: 'Mug Keramik', amount: 120000, status: 'Selesai' },
  { id: 4, customer: 'Maya Sari', product: 'Stiker Vinyl', amount: 50000, status: 'Dikirim' }
])

// Products data
const products = ref([
  {
    id: 1,
    name: 'Kaos Custom Premium',
    description: 'Kaos cotton combed 30s dengan print DTG berkualitas tinggi',
    price: 150000,
    image: 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=400',
    status: 'active'
  },
  {
    id: 2,
    name: 'Totebag Canvas',
    description: 'Totebag kanvas tebal dengan print custom',
    price: 85000,
    image: 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=400',
    status: 'active'
  },
  {
    id: 3,
    name: 'Mug Keramik',
    description: 'Mug keramik putih dengan print custom',
    price: 120000,
    image: 'https://images.unsplash.com/photo-1514228742587-6b1558fcf93a?w=400',
    status: 'active'
  }
])

// Orders data
const orders = ref([
  { id: '001', customer: 'Ahmad Rahman', product: 'Kaos Custom Premium', amount: 150000, status: 'completed' },
  { id: '002', customer: 'Siti Nurhaliza', product: 'Totebag Canvas', amount: 85000, status: 'pending' },
  { id: '003', customer: 'Budi Santoso', product: 'Mug Keramik', amount: 120000, status: 'completed' },
  { id: '004', customer: 'Maya Sari', product: 'Stiker Vinyl', amount: 50000, status: 'processing' }
])

// Transactions data
const transactions = ref([
  { id: 1, date: '2024-01-15', description: 'Penjualan Kaos Custom', amount: 150000, type: 'credit', status: 'completed' },
  { id: 2, date: '2024-01-14', description: 'Biaya Produksi', amount: 50000, type: 'debit', status: 'completed' },
  { id: 3, date: '2024-01-13', description: 'Penjualan Totebag', amount: 85000, type: 'credit', status: 'completed' },
  { id: 4, date: '2024-01-12', description: 'Penjualan Mug', amount: 120000, type: 'credit', status: 'completed' }
])

// Analytics data
const monthlySales = ref([
  { month: 'Jan', sales: 2500000 },
  { month: 'Feb', sales: 3200000 },
  { month: 'Mar', sales: 2800000 },
  { month: 'Apr', sales: 4100000 },
  { month: 'May', sales: 3800000 },
  { month: 'Jun', sales: 4500000 }
])

const topProducts = ref([
  { name: 'Kaos Custom Premium', sales: 45 },
  { name: 'Totebag Canvas', sales: 32 },
  { name: 'Mug Keramik', sales: 28 },
  { name: 'Stiker Vinyl', sales: 21 }
])

// New product form
const newProduct = ref({
  name: '',
  description: '',
  price: 0
})

// Initialize component
onMounted(() => {
  // Check authentication
  if (!user.value) {
    // Redirect to login if not authenticated
    window.location.href = '/login'
  }
})
</script>