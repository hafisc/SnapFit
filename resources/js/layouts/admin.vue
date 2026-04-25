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
              <p class="text-[8px] font-bold tracking-[0.3em] text-orange-500 uppercase mt-1">Admin Panel</p>
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
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v2H8V5z"></path>
                </svg>
                Dashboard
              </a>
            </li>
            <li>
              <a
                href="#"
                :class="[
                  'group flex items-center gap-3 px-4 py-3 rounded-2xl transition-all duration-200 text-xs font-black uppercase tracking-widest',
                  activeTab === 'users'
                    ? 'bg-gray-900 text-white shadow-xl'
                    : 'text-gray-400 hover:text-orange-600 hover:bg-orange-50'
                ]"
                @click="activeTab = 'users'"
              >
                <svg class="w-4 h-4 flex-shrink-0" :class="activeTab === 'users' ? 'text-orange-400' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                </svg>
                Users
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
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
                Products
              </a>
            </li>
            <li>
              <a
                href="#"
                :class="[
                  'group flex items-center gap-3 px-4 py-3 rounded-2xl transition-all duration-200 text-xs font-black uppercase tracking-widest',
                  activeTab === 'orders'
                    ? 'bg-gray-900 text-white shadow-xl'
                    : 'text-gray-400 hover:text-orange-600 hover:bg-orange-50'
                ]"
                @click="activeTab = 'orders'"
              >
                <svg class="w-4 h-4 flex-shrink-0" :class="activeTab === 'orders' ? 'text-orange-400' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Orders
              </a>
            </li>
          </ul>
        </nav>

        <!-- User Info -->
        <div class="p-6 border-t border-orange-50">
          <div class="flex items-center gap-3 p-3 bg-orange-50 rounded-2xl">
            <div class="w-10 h-10 bg-gradient-to-tr from-orange-500 to-amber-400 rounded-full flex items-center justify-center text-white font-black text-sm shadow-md">
              {{ (user?.name || 'A').charAt(0).toUpperCase() }}
            </div>
            <div class="flex-1 min-w-0">
              <p class="text-xs font-black text-gray-900 truncate leading-none">{{ user?.name || 'Admin' }}</p>
              <p class="text-[9px] text-orange-500 font-bold uppercase tracking-tighter mt-1 truncate">{{ user?.email || 'admin@snapfit.id' }}</p>
            </div>
          </div>
        </div>
      </div>
    </aside>

    <!-- Main Content -->
    <div class="lg:pl-72 flex flex-col min-h-screen">

      <!-- Topbar -->
      <header class="bg-white/80 backdrop-blur-xl border-b border-orange-50 px-6 py-4 sticky top-0 z-20">
        <div class="flex justify-between items-center">
          <div>
            <h1 class="text-2xl font-black tracking-tighter text-gray-900 leading-none">{{ getPageTitle() }}</h1>
            <p class="text-[10px] font-bold text-orange-500 uppercase tracking-widest mt-1">Welcome back, {{ user?.name || 'Admin' }}</p>
          </div>

          <div class="flex items-center gap-4">
            <!-- Mobile menu button -->
            <button
              @click="sidebarOpen = !sidebarOpen"
              class="lg:hidden p-2 rounded-xl hover:bg-orange-50 transition-colors"
            >
              <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16"></path>
              </svg>
            </button>

            <button
              @click="logout"
              class="flex items-center gap-2 bg-gray-900 text-white px-6 py-2.5 rounded-full text-xs font-black uppercase tracking-widest hover:bg-orange-600 transition-all shadow-xl shadow-gray-200"
            >
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
              </svg>
              <span class="hidden sm:inline">Logout</span>
            </button>
          </div>
        </div>
      </header>

      <!-- Content -->
      <main class="flex-1 p-6 space-y-8">

        <!-- Dashboard Tab -->
        <div v-if="activeTab === 'dashboard'" class="space-y-8">
          <!-- Stats Cards -->
          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white p-6 rounded-[2rem] border border-orange-50 shadow-sm hover:shadow-xl hover:border-orange-100 transition-all duration-300 group">
              <div class="flex items-center justify-between">
                <div>
                  <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Total Users</p>
                  <p class="text-4xl font-black text-gray-900 tracking-tighter">{{ stats.totalUsers || 0 }}</p>
                  <p class="text-[10px] text-orange-500 font-bold uppercase tracking-wider mt-2">↑ 12% bulan ini</p>
                </div>
                <div class="w-14 h-14 bg-orange-50 text-orange-600 rounded-2xl flex items-center justify-center group-hover:bg-orange-600 group-hover:text-white transition-colors duration-500">
                  <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                  </svg>
                </div>
              </div>
            </div>

            <div class="bg-white p-6 rounded-[2rem] border border-orange-50 shadow-sm hover:shadow-xl hover:border-orange-100 transition-all duration-300 group">
              <div class="flex items-center justify-between">
                <div>
                  <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">UMKM</p>
                  <p class="text-4xl font-black text-gray-900 tracking-tighter">{{ stats.umkm || 0 }}</p>
                  <p class="text-[10px] text-orange-500 font-bold uppercase tracking-wider mt-2">↑ 8% bulan ini</p>
                </div>
                <div class="w-14 h-14 bg-amber-50 text-amber-600 rounded-2xl flex items-center justify-center group-hover:bg-amber-500 group-hover:text-white transition-colors duration-500">
                  <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                  </svg>
                </div>
              </div>
            </div>

            <div class="bg-white p-6 rounded-[2rem] border border-orange-50 shadow-sm hover:shadow-xl hover:border-orange-100 transition-all duration-300 group">
              <div class="flex items-center justify-between">
                <div>
                  <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Designers</p>
                  <p class="text-4xl font-black text-gray-900 tracking-tighter">{{ stats.designers || 0 }}</p>
                  <p class="text-[10px] text-orange-500 font-bold uppercase tracking-wider mt-2">↑ 15% bulan ini</p>
                </div>
                <div class="w-14 h-14 bg-gray-100 text-gray-700 rounded-2xl flex items-center justify-center group-hover:bg-gray-900 group-hover:text-white transition-colors duration-500">
                  <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zM21 5a2 2 0 00-2-2h-4a2 2 0 00-2 2v12a4 4 0 004 4h4a2 2 0 002-2V5z"></path>
                  </svg>
                </div>
              </div>
            </div>

            <div class="bg-gray-900 p-6 rounded-[2rem] shadow-sm hover:shadow-xl transition-all duration-300 group">
              <div class="flex items-center justify-between">
                <div>
                  <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Orders</p>
                  <p class="text-4xl font-black text-white tracking-tighter">{{ stats.orders || 0 }}</p>
                  <p class="text-[10px] text-orange-400 font-bold uppercase tracking-wider mt-2">↑ 23% bulan ini</p>
                </div>
                <div class="w-14 h-14 bg-orange-500/20 text-orange-400 rounded-2xl flex items-center justify-center group-hover:bg-orange-500 group-hover:text-white transition-colors duration-500">
                  <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                  </svg>
                </div>
              </div>
            </div>
          </div>

          <!-- Recent Activity -->
          <div class="bg-white rounded-[2rem] border border-orange-50 overflow-hidden shadow-sm">
            <div class="p-6 border-b border-orange-50">
              <h3 class="text-lg font-black tracking-tighter text-gray-900">Recent Users</h3>
              <p class="text-[10px] text-orange-500 font-bold uppercase tracking-widest mt-1">Latest registrations</p>
            </div>

            <div class="overflow-x-auto">
              <table class="w-full">
                <thead class="bg-orange-50/50">
                  <tr>
                    <th class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">User</th>
                    <th class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Email</th>
                    <th class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Role</th>
                    <th class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Joined</th>
                  </tr>
                </thead>
                <tbody class="divide-y divide-orange-50">
                  <tr v-for="user in recentUsers" :key="user.id" class="hover:bg-orange-50/30 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="flex items-center">
                        <div class="w-8 h-8 bg-gradient-to-tr from-orange-500 to-amber-400 rounded-full flex items-center justify-center text-white text-xs font-black shadow-md shadow-orange-200">
                          {{ user.name.charAt(0).toUpperCase() }}
                        </div>
                        <div class="ml-3">
                          <div class="text-sm font-black text-gray-900">{{ user.name }}</div>
                        </div>
                      </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-medium">{{ user.email }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <span class="inline-flex px-3 py-1 text-[9px] font-black rounded-full uppercase tracking-widest"
                            :class="{
                              'bg-gray-900 text-white': user.role === 'admin',
                              'bg-orange-100 text-orange-700': user.role === 'umkm',
                              'bg-amber-100 text-amber-700': user.role === 'desainer',
                              'bg-gray-100 text-gray-600': user.role === 'pembeli'
                            }">
                        {{ user.role }}
                      </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ formatDate(user.created_at) }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <!-- Users Tab -->
        <div v-if="activeTab === 'users'" class="space-y-6">
          <!-- Add User Button -->
          <div class="flex justify-between items-center">
            <div>
              <h3 class="text-lg font-black tracking-tighter text-gray-900">Kelola User</h3>
              <p class="text-[10px] text-orange-500 font-bold uppercase tracking-widest mt-1">Tambah, edit, atau hapus user</p>
            </div>
            <button
              @click="showAddUserForm = true"
              class="flex items-center gap-2 bg-gray-900 text-white px-6 py-2.5 rounded-full text-xs font-black uppercase tracking-widest hover:bg-orange-600 transition-all shadow-xl shadow-gray-200"
            >
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
              </svg>
              Tambah User
            </button>
          </div>

          <!-- Add/Edit User Form Modal -->
          <div v-if="showAddUserForm" class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50 p-4">
            <div class="bg-white rounded-[2rem] shadow-2xl max-w-md w-full p-8 border border-orange-50">
              <h3 class="text-xl font-black tracking-tighter text-gray-900 mb-1">{{ editingUser ? 'Edit User' : 'Tambah User Baru' }}</h3>
              <p class="text-[10px] text-orange-500 font-bold uppercase tracking-widest mb-6">{{ editingUser ? 'Perbarui data user' : 'Isi form di bawah' }}</p>
              
              <form @submit.prevent="submitUserForm" class="space-y-4">
                <!-- Name -->
                <div>
                  <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Nama</label>
                  <input
                    v-model="userForm.name"
                    type="text"
                    placeholder="Nama user"
                    class="w-full border border-gray-100 bg-gray-50 rounded-xl px-4 py-3 text-sm font-medium outline-none focus:ring-2 focus:ring-orange-400 focus:border-transparent transition"
                  />
                  <p v-if="userFormErrors.name" class="text-red-500 text-xs font-bold mt-1">{{ userFormErrors.name[0] }}</p>
                </div>

                <!-- Email -->
                <div>
                  <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Email</label>
                  <input
                    v-model="userForm.email"
                    type="email"
                    placeholder="user@example.com"
                    class="w-full border border-gray-100 bg-gray-50 rounded-xl px-4 py-3 text-sm font-medium outline-none focus:ring-2 focus:ring-orange-400 focus:border-transparent transition"
                  />
                  <p v-if="userFormErrors.email" class="text-red-500 text-xs font-bold mt-1">{{ userFormErrors.email[0] }}</p>
                </div>

                <!-- Password (only for new users) -->
                <div v-if="!editingUser">
                  <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Password</label>
                  <input
                    v-model="userForm.password"
                    type="password"
                    placeholder="••••••••"
                    class="w-full border border-gray-100 bg-gray-50 rounded-xl px-4 py-3 text-sm font-medium outline-none focus:ring-2 focus:ring-orange-400 focus:border-transparent transition"
                  />
                  <p v-if="userFormErrors.password" class="text-red-500 text-xs font-bold mt-1">{{ userFormErrors.password[0] }}</p>
                </div>

                <!-- Role -->
                <div>
                  <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Role</label>
                  <select
                    v-model="userForm.role"
                    class="w-full border border-gray-100 bg-gray-50 rounded-xl px-4 py-3 text-sm font-medium outline-none focus:ring-2 focus:ring-orange-400 focus:border-transparent transition"
                  >
                    <option value="">Pilih Role</option>
                    <option value="pembeli">Pembeli</option>
                    <option value="umkm">UMKM</option>
                    <option value="desainer">Desainer</option>
                    <option value="admin">Admin</option>
                  </select>
                  <p v-if="userFormErrors.role" class="text-red-500 text-xs font-bold mt-1">{{ userFormErrors.role[0] }}</p>
                </div>

                <!-- Buttons -->
                <div class="flex gap-3 mt-8">
                  <button
                    type="submit"
                    :disabled="loadingUserForm"
                    class="flex-1 bg-gray-900 text-white py-3 rounded-xl text-xs font-black uppercase tracking-widest hover:bg-orange-600 transition-all shadow-xl shadow-gray-200 disabled:opacity-50"
                  >
                    {{ loadingUserForm ? 'Loading...' : (editingUser ? 'Update' : 'Tambah') }}
                  </button>
                  <button
                    type="button"
                    @click="closeUserForm"
                    class="flex-1 border-2 border-gray-100 py-3 rounded-xl text-xs font-black uppercase tracking-widest hover:bg-gray-50 transition"
                  >
                    Batal
                  </button>
                </div>
              </form>
            </div>
          </div>

          <!-- Users Table -->
          <div class="bg-white rounded-[2rem] border border-orange-50 overflow-hidden shadow-sm">
            <div class="overflow-x-auto">
              <table class="w-full">
                <thead class="bg-orange-50/50">
                  <tr>
                    <th class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">User</th>
                    <th class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Email</th>
                    <th class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Role</th>
                    <th class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Bergabung</th>
                    <th class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Aksi</th>
                  </tr>
                </thead>
                <tbody class="divide-y divide-orange-50">
                  <tr v-for="user in allUsers" :key="user.id" class="hover:bg-orange-50/30 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="flex items-center">
                        <div class="w-8 h-8 bg-gradient-to-tr from-orange-500 to-amber-400 rounded-full flex items-center justify-center text-white text-xs font-black shadow-md shadow-orange-200">
                          {{ user.name.charAt(0).toUpperCase() }}
                        </div>
                        <div class="ml-3">
                          <div class="text-sm font-black text-gray-900">{{ user.name }}</div>
                        </div>
                      </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-medium">{{ user.email }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <span class="inline-flex px-3 py-1 text-[9px] font-black rounded-full uppercase tracking-widest"
                            :class="{
                              'bg-gray-900 text-white': user.role === 'admin',
                              'bg-orange-100 text-orange-700': user.role === 'umkm',
                              'bg-amber-100 text-amber-700': user.role === 'desainer',
                              'bg-gray-100 text-gray-600': user.role === 'pembeli'
                            }">
                        {{ user.role }}
                      </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ formatDate(user.created_at) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm space-x-3">
                      <button
                        @click="editUser(user)"
                        class="text-xs font-black text-orange-600 hover:text-orange-700 uppercase tracking-widest transition"
                      >
                        Edit
                      </button>
                      <button
                        @click="confirmDelete(user.id)"
                        class="text-xs font-black text-gray-400 hover:text-red-500 uppercase tracking-widest transition"
                      >
                        Hapus
                      </button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <!-- Products Tab -->
        <div v-if="activeTab === 'products'" class="space-y-6">
          <div class="bg-white rounded-[2rem] border border-orange-50 shadow-sm p-8">
            <h3 class="text-lg font-black tracking-tighter text-gray-900 mb-1">All Products</h3>
            <p class="text-[10px] text-orange-500 font-bold uppercase tracking-widest">Manage all products on the platform</p>
            <!-- Products table would go here -->
          </div>
        </div>

        <!-- Orders Tab -->
        <div v-if="activeTab === 'orders'" class="space-y-6">
          <div class="bg-white rounded-[2rem] border border-orange-50 shadow-sm p-8">
            <h3 class="text-lg font-black tracking-tighter text-gray-900 mb-1">All Orders</h3>
            <p class="text-[10px] text-orange-500 font-bold uppercase tracking-widest">Manage all orders and transactions</p>
            <!-- Orders table would go here -->
          </div>
        </div>

      </main>
    </div>

    <!-- Mobile Sidebar Overlay -->
    <div
      v-if="sidebarOpen"
      @click="sidebarOpen = false"
      class="fixed inset-0 bg-black/50 lg:hidden z-20"
    ></div>

    <!-- Mobile Sidebar -->
    <aside
      :class="[
        'fixed inset-y-0 left-0 w-72 bg-white border-r border-orange-50 shadow-2xl lg:hidden z-30 transform transition-transform duration-300',
        sidebarOpen ? 'translate-x-0' : '-translate-x-full'
      ]"
    >
      <!-- Same content as desktop sidebar -->
      <div class="flex flex-col h-full">
        <div class="p-8 border-b border-orange-50">
          <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-gradient-to-br from-orange-600 to-amber-400 rounded-xl shadow-lg shadow-orange-200 flex items-center justify-center">
              <span class="text-white font-black text-xl italic">S</span>
            </div>
            <div>
              <h1 class="font-black text-xl tracking-tight text-gray-900 leading-none">SnapFit</h1>
              <p class="text-[8px] font-bold tracking-[0.3em] text-orange-500 uppercase mt-1">Admin Panel</p>
            </div>
          </div>
        </div>

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
                @click="activeTab = 'dashboard'; sidebarOpen = false"
              >
                <svg class="w-4 h-4 flex-shrink-0" :class="activeTab === 'dashboard' ? 'text-orange-400' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v2H8V5z"></path>
                </svg>
                Dashboard
              </a>
            </li>
            <li>
              <a
                href="#"
                :class="[
                  'group flex items-center gap-3 px-4 py-3 rounded-2xl transition-all duration-200 text-xs font-black uppercase tracking-widest',
                  activeTab === 'users'
                    ? 'bg-gray-900 text-white shadow-xl'
                    : 'text-gray-400 hover:text-orange-600 hover:bg-orange-50'
                ]"
                @click="activeTab = 'users'; sidebarOpen = false"
              >
                <svg class="w-4 h-4 flex-shrink-0" :class="activeTab === 'users' ? 'text-orange-400' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                </svg>
                Users
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
                @click="activeTab = 'products'; sidebarOpen = false"
              >
                <svg class="w-4 h-4 flex-shrink-0" :class="activeTab === 'products' ? 'text-orange-400' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
                Products
              </a>
            </li>
            <li>
              <a
                href="#"
                :class="[
                  'group flex items-center gap-3 px-4 py-3 rounded-2xl transition-all duration-200 text-xs font-black uppercase tracking-widest',
                  activeTab === 'orders'
                    ? 'bg-gray-900 text-white shadow-xl'
                    : 'text-gray-400 hover:text-orange-600 hover:bg-orange-50'
                ]"
                @click="activeTab = 'orders'; sidebarOpen = false"
              >
                <svg class="w-4 h-4 flex-shrink-0" :class="activeTab === 'orders' ? 'text-orange-400' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Orders
              </a>
            </li>
          </ul>
        </nav>
      </div>
    </aside>

  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()
const activeTab = ref('dashboard')
const sidebarOpen = ref(false)
const user = ref(null)
const stats = ref({
  totalUsers: 0,
  umkm: 0,
  designers: 0,
  orders: 0
})
const recentUsers = ref([])

const getPageTitle = () => {
  const titles = {
    dashboard: 'Dashboard Overview',
    users: 'User Management',
    products: 'Product Management',
    orders: 'Order Management'
  }
  return titles[activeTab.value] || 'Dashboard'
}

const logout = async () => {
  try {
    const token = localStorage.getItem('token')
    if (token) {
      // Get CSRF cookie first for Sanctum
      await fetch('/sanctum/csrf-cookie', {
        method: 'GET',
        credentials: 'same-origin'
      })

      // Get XSRF token from cookies
      const xsrfToken = document.cookie
        .split('; ')
        .find(row => row.startsWith('XSRF-TOKEN='))
        ?.split('=')[1]

      const headers = {
        'Authorization': `Bearer ${token}`,
        'Accept': 'application/json'
      }

      if (xsrfToken) {
        headers['X-XSRF-TOKEN'] = decodeURIComponent(xsrfToken)
      }

      await fetch('/api/v1/auth/logout', {
        method: 'POST',
        headers,
        credentials: 'same-origin'
      })
    }
  } catch (error) {
    console.error('Logout error:', error)
  } finally {
    localStorage.removeItem('user')
    localStorage.removeItem('token')
    router.push('/login')
  }
}

const formatDate = (dateString) => {
  return new Date(dateString).toLocaleDateString('id-ID', {
    year: 'numeric',
    month: 'short',
    day: 'numeric'
  })
}

const fetchStats = async () => {
  try {
    const token = localStorage.getItem('token')
    const response = await fetch('/api/v1/admin/stats', {
      headers: {
        'Authorization': `Bearer ${token}`,
        'Accept': 'application/json'
      }
    })

    if (response.ok) {
      const data = await response.json()
      stats.value = {
        totalUsers: data.users.total,
        umkm: data.users.umkm,
        designers: data.users.desainer,
        orders: data.orders.total
      }
    }
  } catch (error) {
    console.error('Error fetching stats:', error)
  }
}

const fetchRecentUsers = async () => {
  try {
    const token = localStorage.getItem('token')
    const response = await fetch('/api/v1/admin/users?limit=5', {
      headers: {
        'Authorization': `Bearer ${token}`,
        'Accept': 'application/json'
      }
    })

    if (response.ok) {
      const data = await response.json()
      recentUsers.value = data.data || []
    }
  } catch (error) {
    console.error('Error fetching users:', error)
  }
}

/* USER MANAGEMENT */
const allUsers = ref([])
const showAddUserForm = ref(false)
const editingUser = ref(null)
const loadingUserForm = ref(false)
const userFormErrors = ref({})
const userForm = ref({
  name: '',
  email: '',
  password: '',
  role: ''
})

const fetchAllUsers = async () => {
  try {
    const token = localStorage.getItem('token')
    const response = await fetch('/api/v1/admin/users', {
      headers: {
        'Authorization': `Bearer ${token}`,
        'Accept': 'application/json'
      }
    })

    if (response.ok) {
      const data = await response.json()
      allUsers.value = data.data || []
    }
  } catch (error) {
    console.error('Error fetching all users:', error)
  }
}

const editUser = (u) => {
  editingUser.value = u
  userForm.value = {
    name: u.name,
    email: u.email,
    password: '',
    role: u.role
  }
  showAddUserForm.value = true
}

const closeUserForm = () => {
  showAddUserForm.value = false
  editingUser.value = null
  userForm.value = { name: '', email: '', password: '', role: '' }
  userFormErrors.value = {}
}

const submitUserForm = async () => {
  loadingUserForm.value = true
  userFormErrors.value = {}

  try {
    const token = localStorage.getItem('token')
    const xsrfToken = document.cookie
      .split('; ')
      .find(row => row.startsWith('XSRF-TOKEN='))
      ?.split('=')[1]

    const headers = {
      'Content-Type': 'application/json',
      'Authorization': `Bearer ${token}`,
      'Accept': 'application/json'
    }

    if (xsrfToken) {
      headers['X-XSRF-TOKEN'] = decodeURIComponent(xsrfToken)
    }

    const url = editingUser.value
      ? `/api/v1/admin/users/${editingUser.value.id}`
      : '/api/v1/admin/users'
    
    const method = editingUser.value ? 'PUT' : 'POST'
    const body = editingUser.value
      ? { name: userForm.value.name, email: userForm.value.email, role: userForm.value.role }
      : userForm.value

    const response = await fetch(url, {
      method,
      headers,
      credentials: 'same-origin',
      body: JSON.stringify(body)
    })

    const data = await response.json()

    if (!response.ok) {
      userFormErrors.value = data.errors || {}
      throw new Error(data.message || 'Error saving user')
    }

    alert(data.message)
    closeUserForm()
    fetchAllUsers()
    fetchRecentUsers()

  } catch (error) {
    console.error('Error:', error)
    alert(error.message || 'Error saving user')
  } finally {
    loadingUserForm.value = false
  }
}

const confirmDelete = async (userId) => {
  if (!confirm('Yakin ingin menghapus user ini?')) return

  try {
    const token = localStorage.getItem('token')
    const xsrfToken = document.cookie
      .split('; ')
      .find(row => row.startsWith('XSRF-TOKEN='))
      ?.split('=')[1]

    const headers = {
      'Authorization': `Bearer ${token}`,
      'Accept': 'application/json'
    }

    if (xsrfToken) {
      headers['X-XSRF-TOKEN'] = decodeURIComponent(xsrfToken)
    }

    const response = await fetch(`/api/v1/admin/users/${userId}`, {
      method: 'DELETE',
      headers,
      credentials: 'same-origin'
    })

    const data = await response.json()

    if (!response.ok) {
      throw new Error(data.message || 'Error deleting user')
    }

    alert('User berhasil dihapus')
    fetchAllUsers()
    fetchRecentUsers()

  } catch (error) {
    console.error('Error:', error)
    alert(error.message || 'Error deleting user')
  }
}

onMounted(() => {
  const userData = localStorage.getItem('user')
  if (userData) {
    user.value = JSON.parse(userData)
  }

  fetchStats()
  fetchRecentUsers()
  fetchAllUsers()
})
</script>

<style scoped>
/* Custom scrollbar */
::-webkit-scrollbar {
  width: 4px;
}

::-webkit-scrollbar-track {
  background: transparent;
}

::-webkit-scrollbar-thumb {
  background: rgba(249, 115, 22, 0.2);
  border-radius: 999px;
}

::-webkit-scrollbar-thumb:hover {
  background: rgba(249, 115, 22, 0.4);
}

/* Smooth transitions */
* {
  transition-property: color, background-color, border-color, text-decoration-color, fill, stroke, opacity, box-shadow, transform, filter, backdrop-filter;
  transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
  transition-duration: 150ms;
}
</style>