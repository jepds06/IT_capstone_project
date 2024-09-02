<template>
  <div :class="sidebarClasses">
    <!-- Close Button for Sidebar -->
    <button
      v-if="isSidebarOpen"
      @click="toggleSidebar"
      class="absolute top-4 right-4 text-white md:hidden"
    >
      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
      </svg>
    </button>

    <!-- Sidebar Content -->
    <div class="font-bold text-lg mb-5">
      <i class="fas fa-bars"></i> Menu
    </div>
    
    <!-- Navigation Links -->
    <nav class="sidebar-content">
      <ul>
        <li v-for="(item, index) in menuItems" :key="index" class="mb-2">
          <router-link
            :to="item.href"
            class="flex items-center px-4 py-2 rounded hover:bg-gray-700"
          >
            <i :class="item.icon"></i>
            <span class="ml-3">{{ item.name }}</span>
          </router-link>
        </li>
      </ul>
    </nav>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'

const isSidebarOpen = ref(true) // Sidebar is open by default

// Menu items for the sidebar
const menuItems = [
  { name: "Dashboard", href: "/dashboard", icon: "fas fa-tachometer-alt" },
  { name: "Procurement Management", href: "/procurement", icon: "fas fa-warehouse" },
  { name: "Order Management", href: "/orders", icon: "fas fa-shopping-cart" },
  { name: "Inventory Management", href: "/inventory", icon: "fas fa-boxes" },
  { name: "Supplier Management", href: "/suppliers", icon: "fas fa-truck" },
  { name: "Customer Management", href: "/customers", icon: "fas fa-users" },
  { name: "Reports & Analytics", href: "/reports", icon: "fas fa-chart-line" },
  { name: "Settings & Configuration", href: "/settings", icon: "fas fa-cogs" },
  { name: "Help & Support", href: "/help", icon: "fas fa-question-circle" }
]

const toggleSidebar = () => {
  isSidebarOpen.value = !isSidebarOpen.value
}

const sidebarClasses = computed(() => [
  'bg-gray-900 text-white h-screen p-4 fixed top-0 left-0 z-40 transition-transform duration-300',
  'md:w-64',  // Always visible width for large screens
  { 'transform -translate-x-full': !isSidebarOpen.value, 'md:transform-none': true } // Toggle visibility
])

onMounted(() => {
  window.addEventListener('toggle-sidebar', toggleSidebar)
})
</script>

<style scoped>

/* Hide scrollbar but allow scrolling */
.sidebar-content {
  height: calc(100% - 4rem); /* Adjust if needed for spacing */
  overflow-y: auto; /* Allow vertical scrolling */
  -ms-overflow-style: none; /* IE and Edge */
  scrollbar-width: none; /* Firefox */
}

.sidebar-content::-webkit-scrollbar {
  display: none; /* Safari and Chrome */
}
.sidebar {
  width: 250px; /* Fixed width on larger screens */
  background: #444;
  color: white;
  position: fixed;
  top: 0;
  left: 0;
  height: 100%;
  overflow-y: auto;
  transition: transform 0.3s ease;
}

@media (max-width: 768px) {
  .sidebar {
    width: 100%;
  }
}

</style>
