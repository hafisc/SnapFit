import { defineStore } from 'pinia';
import { ref, computed } from 'vue';

export const useCartStore = defineStore('cart', () => {
  // State
  const items = ref([]);
  const isLoading = ref(false);
  const error = ref('');

  // Computed
  const itemCount = computed(() => {
    return items.value.reduce((total, item) => total + (item.quantity || 1), 0);
  });

  const totalPrice = computed(() => {
    return items.value.reduce((total, item) => {
      const price = item.price || 0;
      const quantity = item.quantity || 1;
      return total + (price * quantity);
    }, 0);
  });

  const selectedItems = computed(() => {
    return items.value.filter(item => item.selected);
  });

  const selectedTotal = computed(() => {
    return selectedItems.value.reduce((total, item) => {
      const price = item.price || 0;
      const quantity = item.quantity || 1;
      return total + (price * quantity);
    }, 0);
  });

  const selectedCount = computed(() => {
    return selectedItems.value.reduce((total, item) => total + (item.quantity || 1), 0);
  });

  // Actions
  const loadCart = async () => {
    isLoading.value = true;
    error.value = '';

    try {
      // Load from localStorage first
      const stored = localStorage.getItem('snapfit_cart');
      if (stored) {
        items.value = JSON.parse(stored).map(item => ({
          selected: item.selected !== false,
          ...item,
        }));
      }

      // Try to sync with backend if user is logged in
      const token = localStorage.getItem('token');
      if (token) {
        const response = await fetch('/api/v1/cart', {
          headers: {
            'Authorization': `Bearer ${token}`,
            'Accept': 'application/json',
          },
        });

        if (response.ok) {
          const data = await response.json();
          const backendItems = Array.isArray(data) ? data : data.data || [];

          // Merge with localStorage items
          mergeWithBackend(backendItems);
        }
      }
    } catch (err) {
      console.error('Failed to load cart:', err);
      error.value = 'Gagal memuat keranjang';
    } finally {
      isLoading.value = false;
    }
  };

  const mergeWithBackend = (backendItems) => {
    const merged = [...items.value];

    backendItems.forEach(backendItem => {
      const existingIndex = merged.findIndex(item =>
        item.id === backendItem.id &&
        item.variant === backendItem.variant
      );

      const normalizedBackendItem = {
        selected: backendItem.selected !== false,
        ...backendItem,
      };

      if (existingIndex >= 0) {
        // Update existing item with backend data
        merged[existingIndex] = { ...merged[existingIndex], ...normalizedBackendItem };
      } else {
        // Add new item from backend
        merged.push(normalizedBackendItem);
      }
    });

    items.value = merged;
    saveToLocalStorage();
  };

  const addItem = async (product, quantity = 1, variant = null) => {
    const existingIndex = items.value.findIndex(item =>
      item.id === product.id &&
      item.variant === variant
    );

    if (existingIndex >= 0) {
      items.value[existingIndex].quantity += quantity;
    } else {
      const newItem = {
        id: product.id,
        name: product.name,
        price: product.price,
        image: product.images?.[0] || product.image_url,
        quantity: quantity,
        variant: variant,
        selected: true,
        product: product, // Keep full product data
      };
      items.value.push(newItem);
    }

    saveToLocalStorage();
    await syncWithBackend();
  };

  const updateQuantity = async (itemId, variant, newQuantity) => {
    const item = items.value.find(item =>
      item.id === itemId && item.variant === variant
    );

    if (item) {
      item.quantity = Math.max(1, newQuantity);
      saveToLocalStorage();
      await syncWithBackend();
    }
  };

  const removeItem = async (itemId, variant) => {
    const index = items.value.findIndex(item =>
      item.id === itemId && item.variant === variant
    );

    if (index >= 0) {
      items.value.splice(index, 1);
      saveToLocalStorage();
      await syncWithBackend();
    }
  };

  const toggleSelection = (itemId, variant) => {
    const item = items.value.find(item =>
      item.id === itemId && item.variant === variant
    );

    if (item) {
      item.selected = !item.selected;
      saveToLocalStorage();
    }
  };

  const selectAll = (selected) => {
    items.value.forEach(item => {
      item.selected = selected;
    });
    saveToLocalStorage();
  };

  const clearCart = async () => {
    items.value = [];
    saveToLocalStorage();
    await syncWithBackend();
  };

  const removeSelectedItems = async () => {
    items.value = items.value.filter(item => !item.selected);
    saveToLocalStorage();
    await syncWithBackend();
  };

  const saveToLocalStorage = () => {
    localStorage.setItem('snapfit_cart', JSON.stringify(items.value));
  };

  const syncWithBackend = async () => {
    const token = localStorage.getItem('token');
    if (!token) return;

    try {
      // Sync selected items to backend
      const response = await fetch('/api/v1/cart/sync', {
        method: 'POST',
        headers: {
          'Authorization': `Bearer ${token}`,
          'Content-Type': 'application/json',
          'Accept': 'application/json',
        },
        body: JSON.stringify({
          items: items.value.map(item => ({
            product_id: item.id,
            quantity: item.quantity,
            variant: item.variant,
          })),
        }),
      });

      if (!response.ok) {
        console.warn('Failed to sync cart with backend');
      }
    } catch (err) {
      console.error('Cart sync error:', err);
    }
  };

  const formatCurrency = (amount) => {
    return new Intl.NumberFormat('id-ID', {
      style: 'currency',
      currency: 'IDR',
      minimumFractionDigits: 0,
    }).format(amount);
  };

  // Initialize
  loadCart();

  return {
    // State
    items,
    isLoading,
    error,

    // Computed
    itemCount,
    totalPrice,
    selectedItems,
    selectedTotal,
    selectedCount,

    // Actions
    loadCart,
    addItem,
    updateQuantity,
    removeItem,
    toggleSelection,
    selectAll,
    clearCart,
    formatCurrency,
  };
});