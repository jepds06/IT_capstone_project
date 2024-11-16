<template>
  <header class="bg-gray-900 text-white p-3 shadow-lg">
    <div class="container mx-auto flex justify-between items-center">
      <!-- Logo Section -->
      <div class="text-xl font-bold">
        <NuxtLink to="/">SupplyEase <UBadge label="SE" variant="subtle" class="mb-0.5" /></NuxtLink>
      </div>

      <!-- Sign In Button -->
      <button 
        class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded " 
        @click="handleSignIn"
      >
        Sign In
      </button>
    </div>
  </header>
</template>

<script setup>
function handleSignIn() {
  // Redirect to the Sign In page
  window.location.href = '/sign-in';
}
</script>

<style scoped>
/* Add custom styles here if needed */
</style>
