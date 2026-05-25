<template>
  <div class="fixed inset-x-0 top-0 z-[9999] flex flex-col items-center justify-start px-4 pt-28 pb-6 pointer-events-none">
    <transition-group name="notification" tag="div" class="flex w-full max-w-sm flex-col gap-3">
      <div
        v-for="notification in notifications"
        :key="notification.id"
        :class="[
          'pointer-events-auto w-full overflow-hidden rounded-2xl border bg-white/95 backdrop-blur-md transition duration-300 ease-out relative',
          notificationBorderAndShadow(notification.type),
        ]"
      >
        <!-- Top border glow -->
        <div class="absolute top-0 inset-x-0 h-1" :class="progressBarColor(notification.type)"></div>

        <div class="p-5 flex items-start gap-4">
          <!-- Icon Container -->
          <div class="flex-shrink-0 h-10 w-10 flex items-center justify-center rounded-xl" :class="iconContainerClass(notification.type)">
            <svg v-if="notification.type === 'success'" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
              <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4" />
              <circle cx="12" cy="12" r="10" />
            </svg>
            <svg v-else-if="notification.type === 'error'" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
              <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2" />
              <circle cx="12" cy="12" r="10" />
            </svg>
            <svg v-else-if="notification.type === 'warning'" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
            <svg v-else class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
              <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
          </div>

          <!-- Text content -->
          <div class="flex-1 min-w-0">
            <h4 class="text-xs font-black uppercase tracking-[0.15em] text-[#2B1E16]">
              {{ notification.title || notificationTypeLabel(notification.type) }}
            </h4>
            <p class="mt-1.5 text-xs font-semibold leading-relaxed text-[#5C4D41]">
              {{ notification.message }}
            </p>
          </div>

          <!-- Close button -->
          <button
            type="button"
            @click="removeNotification(notification.id)"
            class="flex-shrink-0 -mt-1 p-1 rounded-lg text-slate-400 hover:text-[#2B1E16] hover:bg-slate-100/80 transition duration-150"
          >
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
              <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>

        <!-- Sleek bottom timer bar -->
        <div class="absolute inset-x-0 bottom-0 h-[3px] bg-slate-100">
          <div class="h-full animate-progress" :class="progressBarColor(notification.type)"></div>
        </div>
      </div>
    </transition-group>
  </div>
</template>

<script setup>
import { useNotificationStore } from '@/stores/notificationStore';

const notificationStore = useNotificationStore();
const notifications = notificationStore.notifications;

const notificationBorderAndShadow = (type) => {
  switch (type) {
    case 'success':
      return 'border-emerald-500/20 shadow-[0_15px_30px_rgba(16,185,129,0.08)] ring-1 ring-emerald-500/5';
    case 'error':
      return 'border-rose-500/20 shadow-[0_15px_30px_rgba(244,63,94,0.08)] ring-1 ring-rose-500/5';
    case 'warning':
      return 'border-amber-500/20 shadow-[0_15px_30px_rgba(245,158,11,0.08)] ring-1 ring-amber-500/5';
    default:
      return 'border-sky-500/20 shadow-[0_15px_30px_rgba(14,165,233,0.08)] ring-1 ring-sky-500/5';
  }
};

const iconContainerClass = (type) => {
  switch (type) {
    case 'success':
      return 'bg-emerald-50 text-emerald-500';
    case 'error':
      return 'bg-rose-50 text-rose-500';
    case 'warning':
      return 'bg-amber-50 text-amber-500';
    default:
      return 'bg-sky-50 text-sky-500';
  }
};

const notificationTypeLabel = (type) => {
  switch (type) {
    case 'success':
      return 'Success';
    case 'error':
      return 'Error';
    case 'warning':
      return 'Warning';
    default:
      return 'Info';
  }
};

const progressBarColor = (type) => {
  switch (type) {
    case 'success':
      return 'bg-gradient-to-r from-emerald-400 to-teal-500';
    case 'error':
      return 'bg-gradient-to-r from-rose-400 to-red-500';
    case 'warning':
      return 'bg-gradient-to-r from-amber-400 to-orange-500';
    default:
      return 'bg-gradient-to-r from-sky-400 to-blue-500';
  }
};

const removeNotification = (id) => {
  notificationStore.removeNotification(id);
};
</script>

<style scoped>
.notification-enter-active,
.notification-leave-active {
  transition: all 400ms cubic-bezier(0.16, 1, 0.3, 1);
}

.notification-enter-from {
  opacity: 0;
  transform: translateY(-30px) scale(0.92);
}

.notification-leave-to {
  opacity: 0;
  transform: translateY(-20px) scale(0.95);
}

@keyframes progressBar {
  from {
    transform: scaleX(1);
    transform-origin: left;
  }
  to {
    transform: scaleX(0);
  }
}

.animate-progress {
  animation: progressBar 3s linear forwards;
}
</style>
