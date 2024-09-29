// composables/useAuth.ts
import { ref, computed } from 'vue';

export const useAuth = () => {
  const authToken = ref<string | null>(null);

  // Check if running in a client environment
  if (process.client) {
    authToken.value = localStorage.getItem('authToken');
  }

  const isAuthenticated = computed(() => !!authToken.value);

  const setToken = (token: string) => {
    authToken.value = token;
    if (process.client) {
      localStorage.setItem('authToken', token);
    }
  };

  const logout = () => {
    authToken.value = null;
    if (process.client) {
      localStorage.removeItem('authToken');
    }
  };

  return { isAuthenticated, setToken, logout };
};
