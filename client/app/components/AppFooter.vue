<script setup lang="ts">
</script>

<template>
  <div class="relative pb-48">
    <div>
      <div class="py-16">
        <h2 class="text-2xl text-center font-semibold">Contact Us</h2>
      </div>
    </div>
  </div>

  <UFooter class="fixed bottom-0 left-0 w-full bg-white dark:bg-gray-900 z-50 shadow-lg">
    <template #left>
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-12 py-6 px-8">
        <div>
          <h4 class="text-gray-800 dark:text-white font-semibold mb-6">May We Help You?</h4>
          <ul class="text-gray-500 dark:text-gray-400 text-sm space-y-3">
            <li><a href="#" class="hover:underline">Customer Support</a></li>
            <li><a href="#" class="hover:underline">FAQs</a></li>
            <li><a href="#" class="hover:underline">Track Order</a></li>
            <li><a href="#" class="hover:underline">Shipping Information</a></li>
          </ul>
        </div>

        <div>
          <h4 class="text-gray-800 dark:text-white font-semibold mb-6">Company</h4>
          <ul class="text-gray-500 dark:text-gray-400 text-sm space-y-3">
            <li><a href="#" class="hover:underline">About Us</a></li>
            <li><a href="#" class="hover:underline">Careers</a></li>
            <li><a href="#" class="hover:underline">Press</a></li>
            <li><a href="#" class="hover:underline">Privacy Policy</a></li>
          </ul>
        </div>
      </div>
    </template>

    <template #center>
      <div class="flex flex-col items-center py-6 px-8 space-y-4">
        <div class="w-full sm:w-72">
          <h4 class="text-gray-800 dark:text-white font-semibold mb-6">Subscribe to our Newsletter</h4>
          <div class="relative">
            <input
              type="email"
              placeholder="Enter your email..."
              class="w-full p-3 pl-12 border-2 border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-700 dark:text-gray-200 placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 transition duration-300"
            />
            <span class="absolute left-3 top-3 text-gray-400 dark:text-gray-200">
              <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none">
                <path
                  d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"
                  fill="currentColor"
                />
              </svg>
            </span>
          </div>
        </div>
      </div>
    </template>

    <template #right>
      <div class="flex flex-col items-center py-6 px-8 space-y-4">
        <UColorModeButton size="sm" />
        <p class="text-gray-500 dark:text-gray-400 text-sm mt-4">
          SE Copyright © {{ new Date().getFullYear() }}. All rights reserved.
        </p>
      </div>
    </template>
  </UFooter>
</template>
