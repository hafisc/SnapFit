import { defineStore } from 'pinia';
import { ref } from 'vue';

export const useNotificationStore = defineStore('notification', () => {
  const notifications = ref([]);
  let notificationId = 0;

  const addNotification = (message, type = 'success', duration = 3000, title = null) => {
    const id = notificationId++;
    const notification = { id, message, type, title };

    notifications.value.push(notification);

    if (duration > 0) {
      setTimeout(() => {
        removeNotification(id);
      }, duration);
    }

    return id;
  };

  const removeNotification = (id) => {
    const index = notifications.value.findIndex((n) => n.id === id);
    if (index >= 0) {
      notifications.value.splice(index, 1);
    }
  };

  const success = (message, duration = 3000, title = 'Success') => addNotification(message, 'success', duration, title);
  const error = (message, duration = 4000, title = 'Error') => addNotification(message, 'error', duration, title);
  const info = (message, duration = 3000, title = 'Info') => addNotification(message, 'info', duration, title);
  const warning = (message, duration = 3500, title = 'Warning') => addNotification(message, 'warning', duration, title);

  return {
    notifications,
    addNotification,
    removeNotification,
    success,
    error,
    info,
    warning,
  };
});
