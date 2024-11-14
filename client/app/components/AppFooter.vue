<script setup lang="ts">
</script>

<template>
  <div class="min-h-screen flex flex-col">
    <!-- Content Section -->
    <main class="flex-grow">
      <!-- Your main content here -->
    </main>

    <!-- Fixed Footer -->
    <UFooter class="fixed bottom-0 left-0 w-full bg-gray-800 text-white py-4">
      <!-- Left Section -->
      <template #left>
        <p class="text-gray-500 dark:text-gray-400 text-sm">
          SupplyEase Copyright © {{ new Date().getFullYear() }}. All rights reserved.
        </p>
      </template>

      <!-- Center Sections -->
      <template #center>
        <div class="flex justify-between space-x-12">
          <!-- May We Help You Section -->
          <div>
            <h4 class="text-lg font-semibold text-white">May We Help You?</h4>
            <ul class="text-gray-400">
              <li><a href="/faq" class="hover:text-gray-200">FAQ</a></li>
              <li><a href="/contact" class="hover:text-gray-200">Contact Us</a></li>
              <li><a href="/support" class="hover:text-gray-200">Support</a></li>
            </ul>
          </div>

          <!-- The Company Section -->
          <div>
            <h4 class="text-lg font-semibold text-white">The Company</h4>
            <ul class="text-gray-400">
              <li><a href="/about" class="hover:text-gray-200">About Us</a></li>
              <li><a href="/careers" class="hover:text-gray-200">Careers</a></li>
              <li><a href="/blog" class="hover:text-gray-200">Blog</a></li>
            </ul>
          </div>
        </div>
      </template>

      <!-- Right Section -->
      <template #right>
        <div class="flex items-center space-x-6">
          <a href="/privacy-policy" class="text-gray-400 hover:text-gray-200 transition-colors">
            Privacy Policy
          </a>
          <a href="/terms" class="text-gray-400 hover:text-gray-200 transition-colors">
            Terms & Conditions
          </a>
          <UColorModeButton size="sm" class="text-gray-400 hover:text-gray-200 transition-colors" />
        </div>
      </template>
    </UFooter>
  </div>
</template>

<style scoped>
/* Ensure the content section grows to fill the available space */
.flex-grow {
  flex-grow: 1;
}

body {
  margin: 0;
}

/* Styling for the fixed footer */
.UFooter {
  position: fixed;
  bottom: 0;
  left: 0;
  width: 100%;
  background-color: #1f2937; /* Tailwind's gray-800 */
  color: white;
  padding: 1rem 0;
  z-index: 50;
}
</style>
