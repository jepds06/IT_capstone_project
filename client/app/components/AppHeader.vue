<template>
   <header class="fixed top-0 left-0 w-full text-gray-800 py-2 shadow-md z-50"
    :class="{
        'bg-transparent text-white': !isScrolled,
        'bg-white text-gray-800': isScrolled
      }"
    >
    <div class="container mx-auto flex items-center justify-between px-6">  
      <!-- Left: Logo -->
      <div class="flex-1 flex justify-center items-center">
        <!-- SUPPLYEASE Logo with scroll behavior -->
        <h1 class="logo transition-all duration-80 centered-text_logo"
          :class="{
              'header-text_logo' : isScrolled,
              'centered-text_logo': !isScrolled
          }">
          S U P P L Y E A S E
          <span class="se-raised">
              <UBadge label="SE" variant="subtle" class="mb-0.5" />
          </span>
        </h1>
      </div>
      <!-- Right: Search Icon, Search Bar, and Sign In -->
      <div class="flex items-center space-x-4">
        <!-- Search Icon -->
        <div class="relative" ref="searchContainer">
          <button @click="toggleSearch" class="p-2 rounded-full hover:bg-gray-200 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m1.75-5.25a7.5 7.5 0 11-15 0 7.5 7.5 0 0115 0z" />
            </svg>
          </button>
        
          <!-- Search Bar (hidden by default) -->
          <input
            v-show="isSearchVisible"
            type="text"
            class="absolute top-full right-0 mt-2 bg-white border border-gray-300 rounded-md px-3 py-1 shadow-lg w-64 transition-all duration-300"
            placeholder="Search..."
          />
        </div>
      </div>

      <!-- Sign In Button -->
      <UButton label="Sign in" color="gray" @click="isSignInOpen = true" />

      <UModal v-model="isSignInOpen" :style="{width:'inherit', height:'inherit '}" class="">
        <div class="p-4">
          <Login />
        </div>
      </UModal>
    </div>
  </header>
</template>

<script setup lang="ts">
const isSignInOpen = ref(false);
import { _width } from '#tailwind-config/theme';

// Reactive state for search bar visibility and sign-in modal
const isSearchVisible = ref(false);

// Reference for the search container
const searchContainer = ref<HTMLElement | null>(null);

// Toggle the visibility of the search bar
const toggleSearch = () => {
  isSearchVisible.value = !isSearchVisible.value;
};
// Close the search bar
const closeSearch = () => {
  isSearchVisible.value = false;
};
// Hide search bar when clicking outside
const handleClickOutside = (event: MouseEvent) => {
  if (searchContainer.value && !searchContainer.value.contains(event.target as Node)) {
    closeSearch();
  }
};
// Setup click-outside listener
onMounted(() => {
  document.addEventListener('click', handleClickOutside);
});
// Clean up click-outside listener
onBeforeUnmount(() => {
  document.removeEventListener('click', handleClickOutside);
});
const isScrolled = ref(false); // Track scroll state
const isLogoExpanded = ref(false); // Track if search is hovered
const handleScroll = () => {
  isScrolled.value = window.scrollY > 0;
};
// Add and remove scroll listener
onMounted(() => window.addEventListener('scroll', handleScroll));
onUnmounted(() => window.removeEventListener('scroll', handleScroll));
</script>

<style scoped>
/* Background color */
.bg-dirty-white { background-color: #fff; }
  
/* Logo styling */
.logo {
  font-size: 2rem; /* Adjust font size for main text */
}

/* "SE" Styling */
.se-raised {
  font-size: 2rem; /* Larger size for emphasis */
  font-weight: bold;
  letter-spacing: 4px; /* Wider text spacing */
  color: white;
  font-family: 'Arial', sans-serif; /* Clean, minimalist font */
  position: relative;
  top: 0; /* Adjust vertical positioning */
  text-align: center;
}


.centered-text_logo {
    position: absolute;
    top: 15rem; /* I-adjust ni para ibaba pa ang logo */
    left: 50%;
    transform: translateX(-50%);
    max-width: none; /* Remove ang max-width para di ma-limit ang size */
    font-size: 4.3rem; /* Mas dako ang font size */
    letter-spacing: 5px; /* Mas lapad ang space sa mga letra */
    font-weight: 900; /* Pinaka-bold nga font weight */
    color: white; /* Pabilin nga puti ang text */
    text-align: center; /* Ensure nga naa sa center ang text */
    transition: color 0.1s ease, top 0.1s ease, font-size 0.1s ease;
}
/* Scrolled black logo styling (when scrolled) */
.header-text_logo {
  position: absolute;
  top: 0.7rem; /* Adjust to align within the header height */
  left:12rem;
  max-width: 400px;
  font-size: 1.5rem;
  font-weight: 500;
  color: black;
  transition: color 0.1s ease, top 0.1s ease, font-size 0.3s ease;
}
</style>