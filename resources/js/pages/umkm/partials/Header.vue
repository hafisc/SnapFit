<template>
  <header class="h-16 sm:h-[72px] bg-surface border-b border-borderSoft/60 sticky top-0 z-20 px-4 sm:px-6 lg:px-8 flex items-center justify-between">
    <div class="flex items-center gap-3 sm:gap-4 min-w-0">
      <!-- Mobile hamburger toggle -->
      <button
        @click="$emit('toggle-sidebar')"
        class="lg:hidden w-9 h-9 rounded-lg bg-slate-100 flex items-center justify-center text-muted flex-shrink-0"
      >
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
      </button>

      <!-- Page title & description -->
      <div class="min-w-0">
        <h1 class="text-sm sm:text-[15px] font-bold text-espresso truncate">{{ pageTitle }}</h1>
        <p class="text-[10px] sm:text-[11px] text-slate-400 font-medium -mt-0.5 truncate hidden sm:block">{{ pageDesc }}</p>
      </div>
    </div>

    <div class="flex items-center gap-2">
      <!-- Search bar -->
      <div class="hidden md:flex items-center bg-slate-50 rounded-lg px-3.5 py-2 gap-2 border border-borderSoft">
        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
        </svg>
        <input
          type="text"
          placeholder="Cari sesuatu..."
          class="bg-transparent outline-none text-[12px] font-medium text-muted w-40 placeholder:text-slate-400"
        />
      </div>

      <!-- Notification bell -->
      <button class="w-9 h-9 rounded-lg bg-slate-50 flex items-center justify-center text-slate-400 hover:bg-slate-100 hover:text-muted transition-colors relative border border-borderSoft flex-shrink-0">
        <span class="absolute top-2 right-2 w-2 h-2 bg-terracotta rounded-full"></span>
        <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
        </svg>
      </button>
    </div>
  </header>
</template>

<script setup>
defineProps({
  pageTitle: {
    type: String,
    default: 'Creator Hub',
  },
  pageDesc: {
    type: String,
    default: '',
  },
});

defineEmits(['toggle-sidebar']);
</script>
