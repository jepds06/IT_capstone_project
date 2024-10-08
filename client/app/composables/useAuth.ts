import { ref, computed } from 'vue';

export const useAuth = () => {
  const authToken = ref<string | null>(null);

  // Load the token immediately
  if (process.client) {
    const storedToken = localStorage.getItem('authToken');
    authToken.value = storedToken ? storedToken : null;
  }

  const isAuthenticated = computed(() => {
    // Optionally check for token expiration if needed
    return !!authToken.value;
  });

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
