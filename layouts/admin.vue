<template>
  <div class="flex h-screen bg-gray-200">
    <!-- Sidebar Component with Toggle Functionality -->
    <Sidebar :isSidebarOpen="isSidebarOpen" @toggleSidebar="toggleSidebar" />

    <div class="flex-1 flex flex-col">
      <!-- Navbar Component with Toggle Functionality -->
      <Navbar @toggleSidebar="toggleSidebar" />
      <main class="py-5">
        <div class="px-4 sm:px-6">
          <keep-alive>
            <router-view />
          </keep-alive>
          <slot />
        </div>
      </main>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import Sidebar from '/components/Sidebar.vue'
import Navbar from '/components/Navbar.vue'

const isSidebarOpen = ref(true)

function toggleSidebar() {
  isSidebarOpen.value = !isSidebarOpen.value
}
</script>

<style scoped>
.sidebar {
  /* Base styles for small screens */
  width: 100%;
  position: fixed;
  top: 0;
  left: 0;
  height: 100%;
  overflow-y: auto;
  transition: transform 0.3s ease;
}

@media (min-width: 768px) {
  .sidebar {
    width: 250px; /* Fixed width on larger screens */
  }
}
.navbar {
  /* Base styles for small screens */
  display: flex;
  justify-content: space-between;
  align-items: center;
}

@media (min-width: 768px) {
  .navbar {
    /* Adjustments for larger screens */
    padding: 0 2rem;
  }
}
</style>
