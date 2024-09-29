import { defineNuxtRouteMiddleware, navigateTo } from 'nuxt/app'; // Ensure the import is correct
import { useAuth } from '@/composables/useAuth';

export default defineNuxtRouteMiddleware((to) => {
  const { isAuthenticated } = useAuth();

  if (!isAuthenticated.value && to.path !== '/login') {
    return navigateTo('/');
  }
});