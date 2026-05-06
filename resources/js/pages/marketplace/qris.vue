<template>
  <section class="min-h-screen bg-slate-50 text-slate-900 p-6 lg:p-10">
    <div class="max-w-4xl mx-auto">
      <div class="rounded-[2rem] bg-white p-10 shadow-sm border border-slate-200 text-center">
        <div class="flex justify-center mb-6">
          <div class="flex h-20 w-20 items-center justify-center rounded-full bg-slate-100 text-4xl text-slate-700">💳</div>
        </div>

        <h1 class="text-4xl font-black text-slate-900 mb-4">Pembayaran QRIS</h1>
        <p class="text-slate-600 text-lg mb-8">Silakan pindai QRIS di bawah untuk menyelesaikan pembayaran pesanan Anda.</p>

        <div class="mx-auto max-w-sm rounded-[2rem] bg-slate-50 border border-slate-200 p-8 text-center">
          <div class="mb-6 inline-flex h-60 w-60 items-center justify-center rounded-[2rem] bg-white border border-slate-200 text-5xl text-slate-400">
            QRIS
          </div>
          <p class="text-sm text-slate-500 mb-4">Tempatkan ponsel Anda di depan QRIS untuk memindai.</p>
          <p class="text-sm text-slate-500">Order ID: <span class="font-black text-slate-900">{{ orderId || 'Tidak tersedia' }}</span></p>
        </div>

        <div class="mt-8 flex flex-col gap-3 sm:flex-row sm:justify-center">
          <router-link to="/marketplace/orders" class="rounded-3xl bg-orange-600 px-6 py-3 text-sm font-black text-white hover:bg-orange-700 transition-all">Kembali ke Pesanan</router-link>
          <router-link to="/marketplace" class="rounded-3xl border border-slate-200 bg-white px-6 py-3 text-sm font-black text-slate-900 hover:bg-slate-100 transition-all">Kembali ke Marketplace</router-link>
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
