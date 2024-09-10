<template>
  <nav class="bg-gray-800 p-4 flex justify-between items-center">
    <!-- Burger Menu Button on Mobile (Moved to the left) -->
    <button
      @click="toggleSidebar"
      class="text-white md:hidden"
      aria-expanded="false"
      aria-controls="sidebar"
    >
      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
      </svg>
    </button>

    <!-- Search Bar (Collapsible) -->
    <div class="relative flex-grow max-w-md hidden md:flex">
      <button
        @click="toggleSearchBar"
        class="text-white flex items-center"
      >
        <svg
          class="w-6 h-6"
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor"
        >
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6l4 2" />
        </svg>
      </button>
      <transition name="fade">
        <div v-if="isSearchBarOpen" class="absolute inset-0 flex items-center justify-center">
          <input
            type="text"
            placeholder="Search..."
            class="w-full px-4 py-2 rounded-md text-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500"
          />
          <svg
            class="absolute top-3 right-3 w-5 h-5 text-gray-400"
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
          >
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m1.85-3.65A7.5 7.5 0 1 0 12 19.5a7.5 7.5 0 0 0 6.5-10.65z"/>
          </svg>
        </div>
      </transition>
    </div>

    <!-- Profile Icon with Dropdown -->
    <div class="relative flex items-center ml-auto">
      <button
        @click="toggleProfileMenu"
        class="text-white flex items-center rounded-full border border-gray-700 p-2"
      >
        <!-- Profile Icon: Circle with Initials or Profile Picture -->
        <div class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-600 text-white font-semibold">
          <span>F</span> <!-- Change this to initials or an image -->
        </div>
      </button>
      <!-- Dropdown Menu -->
      <transition name="fade">
        <div v-if="isProfileMenuOpen" class="absolute right-0 mt-2 w-48 bg-white text-gray-900 rounded-md shadow-lg">
          <ul class="py-1">
            <li>
              <a href="/profile" class="block px-4 py-2 text-sm hover:bg-gray-200">Profile</a>
            </li>
            <li>
              <a href="/settings" class="block px-4 py-2 text-sm hover:bg-gray-200">Settings</a>
            </li>
            <li>
              <a href="/logout" class="block px-4 py-2 text-sm hover:bg-gray-200">Logout</a>
            </li>
          </ul>
        </div>
      </transition>
    </div>
  </nav>
</template>

<script setup>
import { ref } from 'vue'

// Emits
const emit = defineEmits(['toggleSidebar'])

// States
const isSearchBarOpen = ref(false)
const isProfileMenuOpen = ref(false)

// Functions
function toggleSearchBar() {
  isSearchBarOpen.value = !isSearchBarOpen.value
}

function toggleProfileMenu() {
  isProfileMenuOpen.value = !isProfileMenuOpen.value
}

const toggleSidebar = () => {
  emit('toggleSidebar')
}
</script>

<style scoped>
/* Transition for fade effect */
.fade-enter-active, .fade-leave-active {
  transition: opacity 0.3s ease;
}
.fade-enter, .fade-leave-to {
  opacity: 0;
}

/* Custom styles for profile icon */
button {
  background: none;
  border: none;
  cursor: pointer;
}

button:hover {
  background-color: #f1f1f1;
}

/* Styles for profile dropdown menu */
.relative .absolute {
  top: 100%; /* Positions dropdown below the profile icon */
  right: 0; /* Aligns dropdown with the profile icon */
}

/* Hide search bar on smaller screens by default */
@media (max-width: 767px) {
  .relative.flex-grow {
    display: none;
  }
}
</style>
