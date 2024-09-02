<template>
  <div class="bg-blue-600 p-4 flex justify-between items-center">
    <!-- Toggle Button for Mobile View -->
    <button
      @click="toggleSidebar"
      class="md:hidden text-white"
    >
      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
      </svg>
    </button>

    <!-- Search Input -->
    <div class="flex-1 flex items-center md:justify-center">
      <input
        type="text"
        placeholder="Search..."
        class="p-2 rounded bg-white text-black w-full md:w-auto hidden md:block"
      />
    </div>

    <!-- Right Side Actions -->
    <div class="flex items-center space-x-4">
      <!-- Profile Icon always visible -->
      <i class="fas fa-bell text-white"></i>
      <button class="bg-blue-800 text-white px-4 py-2 rounded">Share</button>
      <img
        src="https://via.placeholder.com/40"
        class="rounded-full"
        alt="User"
      />
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'

const toggleSidebar = () => {
  const event = new CustomEvent('toggle-sidebar')
  window.dispatchEvent(event)
}
</script>

<style scoped>
.navbar {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 1rem;
  background: #333;
  color: white;
}

.search-bar {
  flex: 1;
  margin: 0 1rem;
}

.profile-icon {
  margin-left: 1rem;
}

@media (max-width: 768px) {
  .navbar {
    flex-direction: column;
    align-items: flex-start;
  }

  .search-bar {
    margin: 1rem 0;
  }
}
</style>
