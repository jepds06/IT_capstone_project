<template>
  <div class="flex h-screen bg-gray-200">
    <!-- Sidebar Component with Toggle Functionality -->
    <Sidebar :isSidebarOpen="isSidebarOpen" @toggleSidebar="toggleSidebar" />

    <div class="flex-1 flex flex-col">
      <!-- Navbar Component with Toggle Functionality -->
      <Navbar @toggleSidebar="toggleSidebar" />

      <!-- Main Content Area -->
      <main :class="['py-5 transition-transform duration-300', { 'ml-0': !isSidebarOpen, 'ml-64': isSidebarOpen }]">
        <div class="px-4 sm:px-6">
          <!-- Keep the currently active route component alive -->
          <keep-alive>
            <NuxtPage />
          </keep-alive>
          <!-- Slot for additional content or components -->
          <slot />
        </div>
      </main>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import Sidebar from '~/components/Sidebar.vue';
import Navbar from '~/components/Navbar.vue';

const isSidebarOpen = ref(true); // Start with sidebar open for testing

function toggleSidebar() {
  isSidebarOpen.value = !isSidebarOpen.value;
  console.log('Sidebar Toggled:', isSidebarOpen.value); // Debug log
}
</script>

<style scoped>
/* Smooth transition for the sidebar */
.sidebar {
  transition: transform 0.3s ease, width 0.3s ease;
}

.sidebar-collapsed {
  transform: translateX(-100%);
  width: 0;
}

.sidebar-expanded {
  transform: translateX(0);
  width: 16rem; /* Adjust according to sidebar width */
}

/* Smooth transition for the main content */
.transition-transform {
  transition: margin-left 0.3s ease;
}

.ml-0 {
  margin-left: 0;
}

.ml-64 {
  margin-left: 16rem; /* Adjust according to sidebar width */
}
</style>
