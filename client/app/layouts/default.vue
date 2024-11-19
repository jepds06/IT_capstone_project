<template>
  <div class="layout">
    <!-- Dynamic Header -->
    <component :is="getHeader()" />

    <!-- Conditional Admin Layout -->
    <div v-if="route.path.includes('/admin')" class="flex flex-grow">
      <!-- Sidebar (Visible Only for Admin) -->
      <AdminSidebar class="w-64 bg-gray-800" />
      <!-- Main Content -->
      <main class="flex-grow p-6">
        <slot />
      </main>
    </div>

    <!-- Non-Admin Layout -->
    <main v-else class="flex-grow">
      <slot />
    </main>

    <!-- Footer -->
    <component :is="getFooter()" />
    <!-- <AppFooter /> -->
  </div>
</template>

<script setup lang="ts">
import { useRoute } from 'vue-router';
import AdminHeader from '~/components/AdminHeader.vue';
import AppHeader from '~/components/AppHeader.vue';
import CustomerHeader from '~/components/CustomerHeader.vue';
import AppFooter from '~/components/AppFooter.vue';

const route = useRoute();

// Determine which header to use based on the route
const getHeader = () => {
  if (route.path.includes('/admin') || route.path.includes('/supplier')) return AdminHeader;
  else if (route.path.includes('/customer-product')) return CustomerHeader
  return AppHeader  ; // Default for non-admin routes
};

const getFooter = () => {
  if (route.path.includes('/admin') || route.path.includes('/supplier')) return;
  else if (route.path.includes('/customer-product')) return
  return AppFooter  ; // Default for non-admin routes
};
</script>

<style>
.layout {
  display: flex;
  flex-direction: column;
  min-height: 100vh; /* Full viewport height */
}

.flex {
  display: flex; /* Layout for admin routes */
}

main {
  flex-grow: 1; /* Ensure main content stretches */
  padding: 1rem; /* Optional padding for content */
}

.w-64 {
  width: 16rem; /* Sidebar width */
}

.bg-gray-800 {
  background-color: #2d3748; /* Sidebar background color */
}
</style>
