<template>
  <div class="fixed inset-0 z-[9999] flex items-center justify-center px-4 py-6 pointer-events-none">
    <transition-group name="notification" tag="div" class="flex w-full max-w-sm flex-col gap-3">
      <div
        v-for="notification in notifications"
        :key="notification.id"
        :class="[
          'pointer-events-auto w-full overflow-hidden rounded-[28px] border border-borderSoft/80 bg-surface/95 shadow-2xl backdrop-blur-xl ring-1 ring-slate-900/5 transition duration-300 ease-out',
          notificationVariants(notification.type),
        ]"
      >
        <div class="relative p-5">
          <div class="flex items-start gap-4">
            <div class="mt-1 flex h-11 w-11 items-center justify-center rounded-2xl bg-slate-100 text-espresso">
              <svg v-if="notification.type === 'success'" class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M20 6L9 17l-5-5" />
              </svg>
              <svg v-else-if="notification.type === 'error'" class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M18 6 6 18" />
                <path d="m6 6 12 12" />
              </svg>
              <svg v-else-if="notification.type === 'warning'" class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3.05h16.94a2 2 0 0 0 1.71-3.05L13.71 3.86a2 2 0 0 0-3.42 0Z" />
                <path d="M12 9v4" />
                <path d="M12 17h.01" />
              </svg>
              <svg v-else class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10" />
                <path d="M12 8v4" />
                <path d="M12 16h.01" />
              </svg>
            </div>

            <div class="flex-1">
              <p class="text-sm font-semibold uppercase tracking-[0.12em] text-espresso">
                {{ notification.title || notificationTypeLabel(notification.type) }}
              </p>
              <p class="mt-1 text-sm leading-6 text-muted">{{ notification.message }}</p>
            </div>

            <button
              type="button"
              @click="removeNotification(notification.id)"
              class="ml-2 rounded-full p-2 text-muted transition hover:bg-slate-100 hover:text-espresso"
            >
              <span class="sr-only">Tutup notifikasi</span>
              <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M18 6 6 18" />
                <path d="M6 6 18 18" />
              </svg>
            </button>
          </div>

          <div class="absolute inset-x-0 bottom-0 h-1 bg-slate-200/70">
            <div class="h-full bg-current animate-progress" :class="progressBarColor(notification.type)"></div>
          </div>
        </div>
      </div>
    </transition-group>
  </div>
</template>

<script setup>
import { useNotificationStore } from '@/stores/notificationStore';

const notificationStore = useNotificationStore();
const notifications = notificationStore.notifications;

const notificationVariants = (type) => {
  switch (type) {
    case 'success':
      return 'border-emerald-200/80 bg-emerald-50/80 text-espresso';
    case 'error':
      return 'border-rose-200/80 bg-rose-50/80 text-espresso';
    case 'warning':
      return 'border-amber-200/80 bg-amber-50/80 text-espresso';
    default:
      return 'border-sky-200/80 bg-sky-50/80 text-espresso';
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
      return 'bg-emerald-500';
    case 'error':
      return 'bg-rose-500';
    case 'warning':
      return 'bg-amber-500';
    default:
      return 'bg-sky-500';
  }
};

const removeNotification = (id) => {
  notificationStore.removeNotification(id);
};
</script>

<style scoped>
.notification-enter-active,
.notification-leave-active {
  transition: all 250ms cubic-bezier(0.22, 1, 0.36, 1);
}

.notification-enter-from {
  opacity: 0;
  transform: translateY(18px) scale(0.98);
}

.notification-leave-to {
  opacity: 0;
  transform: translateY(-12px) scale(0.96);
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
