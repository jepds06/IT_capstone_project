import { defineNuxtRouteMiddleware, navigateTo } from 'nuxt/app'; 
import { useAuth } from '@/composables/useAuth';

export default defineNuxtRouteMiddleware(() => {
  const { isAuthenticated } = useAuth();

  // Use setTimeout or similar to allow localStorage access to be complete
  setTimeout(() => {
    if (!isAuthenticated.value) {
      return navigateTo('/');
    }
  }, 1000);
});
