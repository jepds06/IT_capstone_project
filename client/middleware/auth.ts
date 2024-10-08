import { defineNuxtRouteMiddleware, navigateTo } from 'nuxt/app'; 
import { useAuth } from '@/composables/useAuth';

export default defineNuxtRouteMiddleware(() => {
  const { isAuthenticated } = useAuth();

  // Use setTimeout or similar to allow localStorage access to be complete
  setTimeout(() => {
    console.log('isAuthenticated-----', isAuthenticated.value)
    if (!isAuthenticated.value) {
      console.log('isAuthenticated', isAuthenticated.value)
      return navigateTo('/');
    }
  }, 2000);
});
