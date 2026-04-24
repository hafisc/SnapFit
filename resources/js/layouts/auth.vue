<template>
  <div class="min-h-screen bg-gray-50 flex items-center justify-center px-6 py-12">
    <div class="w-full max-w-6xl grid lg:grid-cols-2 bg-white rounded-[2rem] shadow-xl overflow-hidden border border-gray-100">
      <!-- Left Side -->
      <div class="bg-black text-white p-12 flex flex-col justify-between">
        <div>
          <p class="text-sm uppercase tracking-[0.25em] text-gray-400 mb-4">
            KreatiLink
          </p>

          <h1 class="text-5xl font-bold leading-tight mb-6">
            Welcome Back to
            Creative Commerce
          </h1>

          <p class="text-gray-300 text-lg leading-relaxed max-w-lg">
            Platform premium untuk UMKM kreatif, desainer, dan pembeli modern.
            Kelola produk, kolaborasi desain, dan pengalaman belanja digital
            dalam satu ekosistem.
          </p>
        </div>

        <div class="space-y-4 mt-10">
          <div class="border border-white/10 rounded-2xl p-4">
            ✨ AI Product Studio
          </div>
          <div class="border border-white/10 rounded-2xl p-4">
            🪞 Web AR Try-On
          </div>
          <div class="border border-white/10 rounded-2xl p-4">
            🤝 Realtime Co-Create Room
          </div>
        </div>
      </div>

      <!-- Right Side -->
      <div class="p-10 lg:p-14 flex items-center">
        <div class="w-full max-w-md mx-auto">
          <div class="mb-8">
            <h2 class="text-3xl font-bold mb-2">Sign In</h2>
            <p class="text-gray-500">
              Login untuk melanjutkan ke dashboard KreatiLink
            </p>
          </div>

          <form class="space-y-5">
            <div>
              <label class="block text-sm font-medium mb-2">Email Address</label>
              <input
                type="email"
                placeholder="you@example.com"
                class="w-full border border-gray-200 rounded-2xl px-5 py-4 outline-none focus:ring-2 focus:ring-black"
              />
            </div>

            <div>
              <label class="block text-sm font-medium mb-2">Password</label>
              <input
                type="password"
                placeholder="••••••••"
                class="w-full border border-gray-200 rounded-2xl px-5 py-4 outline-none focus:ring-2 focus:ring-black"
              />
            </div>

            <div class="flex items-center justify-between text-sm">
              <label class="flex items-center gap-2">
                <input type="checkbox" />
                Remember me
              </label>

              <a href="#" class="font-medium hover:underline">
                Forgot Password?
              </a>
            </div>

            <button
              type="submit"
              class="w-full bg-black text-white py-4 rounded-2xl font-semibold hover:scale-[1.01] transition"
            >
              Login
            </button>

            <button
              type="button"
              class="w-full border border-gray-200 py-4 rounded-2xl font-medium hover:bg-gray-50 transition"
            >
              Continue with Google
            </button>
          </form>

          <p class="text-center text-sm text-gray-500 mt-8">
            Belum punya akun?
            <a href="#" class="font-semibold text-black">Register sekarang</a>
          </p>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
// Login Page UI
</script>
