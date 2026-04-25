<template>
  <div class="min-h-screen bg-white">

    <!-- Sidebar -->
    <aside class="fixed inset-y-0 left-0 w-72 bg-white shadow-lg border-r border-gray-200 hidden lg:block z-30">
      <div class="flex flex-col h-full">

        <!-- Logo -->
        <div class="p-8 border-b border-gray-100">
          <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-xl flex items-center justify-center">
              <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
              </svg>
            </div>
            <div>
              <h1 class="text-xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                SnapFit Admin
              </h1>
              <p class="text-xs text-gray-500">Management Dashboard</p>
            </div>
          </div>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 p-6">
          <ul class="space-y-2">
            <li>
              <a
                href="#"
                :class="[
                  'group flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200',
                  activeTab === 'dashboard'
                    ? 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-lg shadow-indigo-500/25'
                    : 'text-gray-700 hover:bg-white/60 hover:shadow-md'
                ]"
                @click="activeTab = 'dashboard'"
              >
                <svg class="w-5 h-5" :class="activeTab === 'dashboard' ? 'text-white' : 'text-gray-500'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v2H8V5z"></path>
                </svg>
                <span class="font-medium">Dashboard</span>
              </a>
            </li>
            <li>
              <a
                href="#"
                :class="[
                  'group flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200',
                  activeTab === 'users'
                    ? 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-lg shadow-indigo-500/25'
                    : 'text-gray-700 hover:bg-white/60 hover:shadow-md'
                ]"
                @click="activeTab = 'users'"
              >
                <svg class="w-5 h-5" :class="activeTab === 'users' ? 'text-white' : 'text-gray-500'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                </svg>
                <span class="font-medium">Users</span>
              </a>
            </li>
            <li>
              <a
                href="#"
                :class="[
                  'group flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200',
                  activeTab === 'products'
                    ? 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-lg shadow-indigo-500/25'
                    : 'text-gray-700 hover:bg-white/60 hover:shadow-md'
                ]"
                @click="activeTab = 'products'"
              >
                <svg class="w-5 h-5" :class="activeTab === 'products' ? 'text-white' : 'text-gray-500'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
                <span class="font-medium">Products</span>
              </a>
            </li>
            <li>
              <a
                href="#"
                :class="[
                  'group flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200',
                  activeTab === 'orders'
                    ? 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-lg shadow-indigo-500/25'
                    : 'text-gray-700 hover:bg-white/60 hover:shadow-md'
                ]"
                @click="activeTab = 'orders'"
              >
                <svg class="w-5 h-5" :class="activeTab === 'orders' ? 'text-white' : 'text-gray-500'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <span class="font-medium">Orders</span>
              </a>
            </li>
          </ul>
        </nav>

        <!-- User Info -->
        <div class="p-6 border-t border-gray-100">
          <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl">
            <div class="w-10 h-10 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-full flex items-center justify-center">
              <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
              </svg>
            </div>
            <div class="flex-1 min-w-0">
              <p class="text-sm font-medium text-gray-900 truncate">{{ user?.name || 'Admin' }}</p>
              <p class="text-xs text-gray-500 truncate">{{ user?.email || 'admin@snapfit.id' }}</p>
            </div>
          </div>
        </div>
      </div>
    </aside>

    <!-- Main Content -->
    <div class="lg:pl-72 flex flex-col min-h-screen">

      <!-- Topbar -->
      <header class="bg-white/80 backdrop-blur border-b border-gray-200 px-6 py-4 sticky top-0 z-20">
        <div class="flex justify-between items-center">
          <div>
            <h1 class="text-2xl font-bold text-gray-900">{{ getPageTitle() }}</h1>
            <p class="text-sm text-gray-600">Welcome back, {{ user?.name || 'Admin' }}</p>
          </div>

          <div class="flex items-center gap-4">
            <!-- Mobile menu button -->
            <button
              @click="sidebarOpen = !sidebarOpen"
              class="lg:hidden p-2 rounded-lg hover:bg-gray-100 transition-colors"
            >
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
              </svg>
            </button>

            <button
              @click="logout"
              class="flex items-center gap-2 bg-red-600 text-white px-5 py-2 rounded-full font-medium hover:bg-red-700 transition-all"
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
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 hover:shadow-lg transition-all duration-300 group">
              <div class="flex items-center justify-between">
                <div>
                  <p class="text-sm font-medium text-gray-600 mb-1">Total Users</p>
                  <p class="text-3xl font-bold text-gray-900">{{ stats.totalUsers || 0 }}</p>
                  <p class="text-xs text-green-600 font-medium mt-1">+12% from last month</p>
                </div>
                <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                  <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                  </svg>
                </div>
              </div>
            </div>

            <div class="bg-white/70 backdrop-blur-xl p-6 rounded-2xl shadow-xl border border-white/20 hover:shadow-2xl transition-all duration-300 group">
              <div class="flex items-center justify-between">
                <div>
                  <p class="text-sm font-medium text-gray-600 mb-1">UMKM</p>
                  <p class="text-3xl font-bold text-gray-900">{{ stats.umkm || 0 }}</p>
                  <p class="text-xs text-green-600 font-medium mt-1">+8% from last month</p>
                </div>
                <div class="w-12 h-12 bg-gradient-to-r from-green-500 to-green-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                  <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                  </svg>
                </div>
              </div>
            </div>

            <div class="bg-white/70 backdrop-blur-xl p-6 rounded-2xl shadow-xl border border-white/20 hover:shadow-2xl transition-all duration-300 group">
              <div class="flex items-center justify-between">
                <div>
                  <p class="text-sm font-medium text-gray-600 mb-1">Designers</p>
                  <p class="text-3xl font-bold text-gray-900">{{ stats.designers || 0 }}</p>
                  <p class="text-xs text-green-600 font-medium mt-1">+15% from last month</p>
                </div>
                <div class="w-12 h-12 bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                  <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zM21 5a2 2 0 00-2-2h-4a2 2 0 00-2 2v12a4 4 0 004 4h4a2 2 0 002-2V5z"></path>
                  </svg>
                </div>
              </div>
            </div>

            <div class="bg-white/70 backdrop-blur-xl p-6 rounded-2xl shadow-xl border border-white/20 hover:shadow-2xl transition-all duration-300 group">
              <div class="flex items-center justify-between">
                <div>
                  <p class="text-sm font-medium text-gray-600 mb-1">Orders</p>
                  <p class="text-3xl font-bold text-gray-900">{{ stats.orders || 0 }}</p>
                  <p class="text-xs text-green-600 font-medium mt-1">+23% from last month</p>
                </div>
                <div class="w-12 h-12 bg-gradient-to-r from-orange-500 to-orange-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                  <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                  </svg>
                </div>
              </div>
            </div>
          </div>

          <!-- Recent Activity -->
          <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="p-6 border-b border-gray-100">
              <h3 class="text-lg font-semibold text-gray-900">Recent Users</h3>
              <p class="text-sm text-gray-600">Latest user registrations</p>
            </div>

            <div class="overflow-x-auto">
              <table class="w-full">
                <thead class="bg-gray-50/50">
                  <tr>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Joined</th>
                  </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                  <tr v-for="user in recentUsers" :key="user.id" class="hover:bg-gray-50/50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="flex items-center">
                        <div class="w-8 h-8 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-full flex items-center justify-center text-white text-sm font-medium">
                          {{ user.name.charAt(0).toUpperCase() }}
                        </div>
                        <div class="ml-3">
                          <div class="text-sm font-medium text-gray-900">{{ user.name }}</div>
                        </div>
                      </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ user.email }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full"
                            :class="{
                              'bg-red-100 text-red-800': user.role === 'admin',
                              'bg-green-100 text-green-800': user.role === 'umkm',
                              'bg-purple-100 text-purple-800': user.role === 'desainer',
                              'bg-blue-100 text-blue-800': user.role === 'pembeli'
                            }">
                        {{ user.role }}
                      </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ formatDate(user.created_at) }}</td>
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
              <h3 class="text-lg font-semibold text-gray-900">Kelola User</h3>
              <p class="text-sm text-gray-600">Tambah, edit, atau hapus user dari platform</p>
            </div>
            <button
              @click="showAddUserForm = true"
              class="flex items-center gap-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-5 py-2 rounded-full font-medium hover:shadow-lg transition"
            >
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
              </svg>
              Tambah User
            </button>
          </div>

          <!-- Add/Edit User Form Modal -->
          <div v-if="showAddUserForm" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
            <div class="bg-white rounded-xl shadow-lg max-w-md w-full p-6">
              <h3 class="text-lg font-bold mb-4">{{ editingUser ? 'Edit User' : 'Tambah User Baru' }}</h3>
              
              <form @submit.prevent="submitUserForm" class="space-y-4">
                <!-- Name -->
                <div>
                  <label class="block text-sm font-medium mb-1">Nama</label>
                  <input
                    v-model="userForm.name"
                    type="text"
                    placeholder="Nama user"
                    class="w-full border border-gray-200 rounded-lg px-4 py-2 outline-none focus:ring-2 focus:ring-indigo-500"
                  />
                  <p v-if="userFormErrors.name" class="text-red-600 text-sm mt-1">{{ userFormErrors.name[0] }}</p>
                </div>

                <!-- Email -->
                <div>
                  <label class="block text-sm font-medium mb-1">Email</label>
                  <input
                    v-model="userForm.email"
                    type="email"
                    placeholder="user@example.com"
                    class="w-full border border-gray-200 rounded-lg px-4 py-2 outline-none focus:ring-2 focus:ring-indigo-500"
                  />
                  <p v-if="userFormErrors.email" class="text-red-600 text-sm mt-1">{{ userFormErrors.email[0] }}</p>
                </div>

                <!-- Password (only for new users) -->
                <div v-if="!editingUser">
                  <label class="block text-sm font-medium mb-1">Password</label>
                  <input
                    v-model="userForm.password"
                    type="password"
                    placeholder="••••••••"
                    class="w-full border border-gray-200 rounded-lg px-4 py-2 outline-none focus:ring-2 focus:ring-indigo-500"
                  />
                  <p v-if="userFormErrors.password" class="text-red-600 text-sm mt-1">{{ userFormErrors.password[0] }}</p>
                </div>

                <!-- Role -->
                <div>
                  <label class="block text-sm font-medium mb-1">Role</label>
                  <select
                    v-model="userForm.role"
                    class="w-full border border-gray-200 rounded-lg px-4 py-2 outline-none focus:ring-2 focus:ring-indigo-500"
                  >
                    <option value="">Pilih Role</option>
                    <option value="pembeli">Pembeli</option>
                    <option value="umkm">UMKM</option>
                    <option value="desainer">Desainer</option>
                    <option value="admin">Admin</option>
                  </select>
                  <p v-if="userFormErrors.role" class="text-red-600 text-sm mt-1">{{ userFormErrors.role[0] }}</p>
                </div>

                <!-- Buttons -->
                <div class="flex gap-3 mt-6">
                  <button
                    type="submit"
                    :disabled="loadingUserForm"
                    class="flex-1 bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-2 rounded-lg font-medium hover:shadow-lg transition disabled:opacity-50"
                  >
                    {{ loadingUserForm ? 'Loading...' : (editingUser ? 'Update' : 'Tambah') }}
                  </button>
                  <button
                    type="button"
                    @click="closeUserForm"
                    class="flex-1 border border-gray-200 py-2 rounded-lg font-medium hover:bg-gray-50 transition"
                  >
                    Batal
                  </button>
                </div>
              </form>
            </div>
          </div>

          <!-- Users Table -->
          <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
              <table class="w-full">
                <thead class="bg-gray-50/50">
                  <tr>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bergabung</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                  </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                  <tr v-for="user in allUsers" :key="user.id" class="hover:bg-gray-50/50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="flex items-center">
                        <div class="w-8 h-8 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-full flex items-center justify-center text-white text-sm font-medium">
                          {{ user.name.charAt(0).toUpperCase() }}
                        </div>
                        <div class="ml-3">
                          <div class="text-sm font-medium text-gray-900">{{ user.name }}</div>
                        </div>
                      </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ user.email }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full"
                            :class="{
                              'bg-red-100 text-red-800': user.role === 'admin',
                              'bg-green-100 text-green-800': user.role === 'umkm',
                              'bg-purple-100 text-purple-800': user.role === 'desainer',
                              'bg-blue-100 text-blue-800': user.role === 'pembeli'
                            }">
                        {{ user.role }}
                      </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ formatDate(user.created_at) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm space-x-2">
                      <button
                        @click="editUser(user)"
                        class="text-indigo-600 hover:text-indigo-700 font-medium transition"
                      >
                        Edit
                      </button>
                      <button
                        @click="confirmDelete(user.id)"
                        class="text-red-600 hover:text-red-700 font-medium transition"
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
          <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">All Products</h3>
            <p class="text-gray-600">Manage all products on the platform</p>
            <!-- Products table would go here -->
          </div>
        </div>

        <!-- Orders Tab -->
        <div v-if="activeTab === 'orders'" class="space-y-6">
          <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">All Orders</h3>
            <p class="text-gray-600">Manage all orders and transactions</p>
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
        'fixed inset-y-0 left-0 w-72 bg-white/95 backdrop-blur-xl shadow-2xl border-r border-white/20 lg:hidden z-30 transform transition-transform duration-300',
        sidebarOpen ? 'translate-x-0' : '-translate-x-full'
      ]"
    >
      <!-- Same content as desktop sidebar -->
      <div class="flex flex-col h-full">
        <div class="p-8 border-b border-gray-100">
          <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-xl flex items-center justify-center">
              <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
              </svg>
            </div>
            <div>
              <h1 class="text-xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                SnapFit Admin
              </h1>
              <p class="text-xs text-gray-500">Management Dashboard</p>
            </div>
          </div>
        </div>

        <nav class="flex-1 p-6">
          <ul class="space-y-2">
            <li>
              <a
                href="#"
                :class="[
                  'group flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200',
                  activeTab === 'dashboard'
                    ? 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-lg shadow-indigo-500/25'
                    : 'text-gray-700 hover:bg-white/60 hover:shadow-md'
                ]"
                @click="activeTab = 'dashboard'; sidebarOpen = false"
              >
                <svg class="w-5 h-5" :class="activeTab === 'dashboard' ? 'text-white' : 'text-gray-500'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v2H8V5z"></path>
                </svg>
                <span class="font-medium">Dashboard</span>
              </a>
            </li>
            <li>
              <a
                href="#"
                :class="[
                  'group flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200',
                  activeTab === 'users'
                    ? 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-lg shadow-indigo-500/25'
                    : 'text-gray-700 hover:bg-white/60 hover:shadow-md'
                ]"
                @click="activeTab = 'users'; sidebarOpen = false"
              >
                <svg class="w-5 h-5" :class="activeTab === 'users' ? 'text-white' : 'text-gray-500'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                </svg>
                <span class="font-medium">Users</span>
              </a>
            </li>
            <li>
              <a
                href="#"
                :class="[
                  'group flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200',
                  activeTab === 'products'
                    ? 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-lg shadow-indigo-500/25'
                    : 'text-gray-700 hover:bg-white/60 hover:shadow-md'
                ]"
                @click="activeTab = 'products'; sidebarOpen = false"
              >
                <svg class="w-5 h-5" :class="activeTab === 'products' ? 'text-white' : 'text-gray-500'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
                <span class="font-medium">Products</span>
              </a>
            </li>
            <li>
              <a
                href="#"
                :class="[
                  'group flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200',
                  activeTab === 'orders'
                    ? 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-lg shadow-indigo-500/25'
                    : 'text-gray-700 hover:bg-white/60 hover:shadow-md'
                ]"
                @click="activeTab = 'orders'; sidebarOpen = false"
              >
                <svg class="w-5 h-5" :class="activeTab === 'orders' ? 'text-white' : 'text-gray-500'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <span class="font-medium">Orders</span>
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
  width: 6px;
}

::-webkit-scrollbar-track {
  background: transparent;
}

::-webkit-scrollbar-thumb {
  background: rgba(156, 163, 175, 0.3);
  border-radius: 3px;
}

::-webkit-scrollbar-thumb:hover {
  background: rgba(156, 163, 175, 0.5);
}

/* Smooth transitions */
* {
  transition-property: color, background-color, border-color, text-decoration-color, fill, stroke, opacity, box-shadow, transform, filter, backdrop-filter;
  transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
  transition-duration: 150ms;
}
</style>
