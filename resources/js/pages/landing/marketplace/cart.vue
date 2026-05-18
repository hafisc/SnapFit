<template>
  <section class="min-h-screen bg-slate-50 text-espresso p-6 lg:p-10">
    <div class="max-w-6xl mx-auto">
      <!-- Header -->
      <div class="mb-8">
        <div class="flex items-center gap-3 mb-4">
          <router-link to="/marketplace" class="text-muted hover:text-espresso transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
          </router-link>
          <h1 class="text-3xl font-black text-espresso">Keranjang Belanja</h1>
        </div>
        <p class="text-muted">Kelola produk yang ingin Anda beli</p>
      </div>

      <!-- Loading State -->
      <div v-if="cartStore.isLoading" class="flex items-center justify-center py-32">
        <div class="text-center">
          <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-orange-500 mx-auto mb-4"></div>
          <p class="text-muted">Memuat keranjang...</p>
        </div>
      </div>

      <!-- Empty Cart -->
      <div v-else-if="cartStore.items.length === 0" class="text-center py-32">
        <div class="max-w-md mx-auto">
          <div class="w-24 h-24 bg-sand rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="w-12 h-12 text-terracotta" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
          </div>
          <h2 class="text-2xl font-black text-espresso mb-3">Keranjang Kosong</h2>
          <p class="text-muted mb-6">Belum ada produk di keranjang belanja Anda.</p>
          <router-link
            to="/marketplace"
            class="inline-flex items-center gap-2 bg-terracotta text-white px-6 py-3 rounded-2xl font-black text-sm uppercase tracking-widest hover:bg-terracottaDark transition-all"
          >
            Mulai Belanja
          </router-link>
        </div>
      </div>

      <!-- Cart Items -->
      <div v-else class="grid gap-8 lg:grid-cols-[1fr_350px]">
        <!-- Items List -->
        <div class="space-y-4">
          <!-- Select All -->
          <div class="bg-surface rounded-[2rem] p-6 shadow-sm border border-borderSoft">
            <label class="flex items-center gap-3 cursor-pointer">
              <input
                type="checkbox"
                :checked="allSelected"
                @change="cartStore.selectAll($event.target.checked)"
                class="w-5 h-5 text-terracotta bg-slate-100 border-slate-300 rounded focus:ring-orange-500 focus:ring-2"
              />
              <span class="font-semibold text-espresso">Pilih Semua ({{ cartStore.itemCount }} item)</span>
            </label>
          </div>

          <!-- Cart Items -->
          <div v-for="item in cartStore.items" :key="`${item.id}-${item.variant}`" class="bg-surface rounded-[2rem] p-6 shadow-sm border border-borderSoft">
            <div class="flex gap-4">
              <!-- Checkbox -->
              <div class="flex items-start pt-2">
                <input
                  type="checkbox"
                  :checked="item.selected"
                  @change="cartStore.toggleSelection(item.id, item.variant)"
                  class="w-5 h-5 text-terracotta bg-slate-100 border-slate-300 rounded focus:ring-orange-500 focus:ring-2"
                />
              </div>

              <!-- Product Image -->
              <div class="w-20 h-20 bg-slate-100 rounded-2xl overflow-hidden flex-shrink-0">
                <img
                  :src="item.image"
                  :alt="item.name"
                  class="w-full h-full object-cover"
                />
              </div>

              <!-- Product Details -->
              <div class="flex-1 min-w-0">
                <h3 class="font-bold text-espresso mb-1 line-clamp-2">{{ item.name }}</h3>
                <p v-if="item.variant" class="text-sm text-muted mb-2">Varian: {{ item.variant }}</p>
                <p class="text-lg font-black text-terracotta">{{ cartStore.formatCurrency(item.price) }}</p>
              </div>

              <!-- Quantity & Actions -->
              <div class="flex flex-col items-end gap-3">
                <!-- Quantity Selector -->
                <div class="flex items-center gap-2 bg-slate-100 rounded-2xl p-1">
                  <button
                    @click="cartStore.updateQuantity(item.id, item.variant, item.quantity - 1)"
                    :disabled="item.quantity <= 1"
                    class="w-8 h-8 rounded-xl bg-surface flex items-center justify-center text-espresso hover:bg-slate-200 disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
                  >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                    </svg>
                  </button>
                  <span class="w-12 text-center font-semibold text-espresso">{{ item.quantity }}</span>
                  <button
                    @click="cartStore.updateQuantity(item.id, item.variant, item.quantity + 1)"
                    class="w-8 h-8 rounded-xl bg-surface flex items-center justify-center text-espresso hover:bg-slate-200 transition-colors"
                  >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                  </button>
                </div>

                <!-- Remove Button -->
                <button
                  @click="cartStore.removeItem(item.id, item.variant)"
                  class="text-sm text-red-600 hover:text-red-700 font-semibold transition-colors"
                >
                  Hapus
                </button>
              </div>
            </div>

            <!-- Subtotal -->
            <div class="mt-4 pt-4 border-t border-borderSoft flex justify-between items-center">
              <span class="text-sm text-muted">Subtotal</span>
              <span class="font-bold text-espresso">{{ cartStore.formatCurrency(item.price * item.quantity) }}</span>
            </div>
          </div>
        </div>

        <!-- Order Summary -->
        <div class="space-y-6">
          <!-- Summary Card -->
          <div class="bg-surface rounded-[2rem] p-6 shadow-sm border border-borderSoft sticky top-6">
            <h3 class="text-lg font-black text-espresso mb-4">Ringkasan Belanja</h3>

            <div class="space-y-3 mb-6">
              <div class="flex justify-between text-sm">
                <span class="text-muted">Total Item ({{ cartStore.selectedCount }})</span>
                <span class="font-semibold text-espresso">{{ cartStore.formatCurrency(cartStore.selectedTotal) }}</span>
              </div>
              <div class="flex justify-between text-sm">
                <span class="text-muted">Ongkos Kirim</span>
                <span class="font-semibold text-espresso">Gratis</span>
              </div>
              <div class="border-t border-borderSoft pt-3 flex justify-between text-lg font-black">
                <span class="text-espresso">Total</span>
                <span class="text-terracotta">{{ cartStore.formatCurrency(cartStore.selectedTotal) }}</span>
              </div>
            </div>

            <div class="space-y-3">
              <button
                @click="proceedToCheckout"
                :disabled="cartStore.selectedCount === 0"
                class="w-full bg-terracotta hover:bg-terracottaDark disabled:bg-slate-300 text-white py-4 rounded-2xl font-black text-sm uppercase tracking-widest transition-colors disabled:cursor-not-allowed"
              >
                Checkout ({{ cartStore.selectedCount }})
              </button>

              <router-link
                to="/marketplace"
                class="w-full bg-slate-100 hover:bg-slate-200 text-espresso py-4 rounded-2xl font-black text-sm uppercase tracking-widest transition-colors text-center block"
              >
                Lanjut Belanja
              </router-link>
            </div>
          </div>

          <!-- Info Card -->
          <div class="bg-blue-50 rounded-[2rem] p-6 border border-blue-200">
            <div class="flex items-start gap-3">
              <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
              </div>
              <div>
                <h4 class="font-bold text-blue-900 mb-1">Informasi Pengiriman</h4>
                <p class="text-sm text-blue-700">Pengiriman gratis untuk semua pesanan di atas Rp 100.000. Estimasi pengiriman 2-5 hari kerja.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { computed } from 'vue';
import { useRouter } from 'vue-router';
import { useCartStore } from '@/stores/cartStore';

const router = useRouter();
const cartStore = useCartStore();

const allSelected = computed(() => {
  return cartStore.items.length > 0 && cartStore.items.every(item => item.selected);
});

const proceedToCheckout = () => {
  if (cartStore.selectedCount > 0) {
    router.push({ path: '/marketplace/checkout', query: { source: 'cart' } });
  }
};
</script>

<style scoped>
.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style>