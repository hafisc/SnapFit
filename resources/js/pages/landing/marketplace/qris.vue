<template>
  <section class="min-h-screen bg-slate-50 text-espresso p-6 lg:p-10">
    <div class="max-w-4xl mx-auto">
      <div class="rounded-[2rem] bg-surface p-10 shadow-sm border border-borderSoft text-center">
        <div class="flex justify-center mb-6">
          <div class="flex h-20 w-20 items-center justify-center rounded-full bg-slate-100 text-4xl text-espresso">💳</div>
        </div>

        <h1 class="text-4xl font-black text-espresso mb-4">Pembayaran QRIS</h1>
        <p class="text-muted text-lg mb-8">Silakan pindai QRIS di bawah untuk menyelesaikan pembayaran pesanan Anda.</p>

        <div class="mx-auto max-w-sm rounded-[2rem] bg-slate-50 border border-borderSoft p-8 text-center">
          <div class="mb-6 inline-flex h-60 w-60 items-center justify-center rounded-[2rem] bg-surface border border-borderSoft text-5xl text-slate-400">
            QRIS
          </div>
          <p class="text-sm text-muted mb-4">Tempatkan ponsel Anda di depan QRIS untuk memindai.</p>
          <p class="text-sm text-muted">Order ID: <span class="font-black text-espresso">{{ orderId || 'Tidak tersedia' }}</span></p>
        </div>

        <div class="mt-8 flex flex-col gap-3 sm:flex-row sm:justify-center">
          <router-link to="/marketplace/orders" class="rounded-3xl bg-terracotta px-6 py-3 text-sm font-black text-white hover:bg-terracottaDark transition-all">Kembali ke Pesanan</router-link>
          <router-link to="/marketplace" class="rounded-3xl border border-borderSoft bg-surface px-6 py-3 text-sm font-black text-espresso hover:bg-slate-100 transition-all">Kembali ke Marketplace</router-link>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { useRoute } from 'vue-router';

const route = useRoute();
const orderId = route.query.order_id || null;
</script>
