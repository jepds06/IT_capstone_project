<template>
  <header class="bg-gray-900 text-white p-3 shadow-lg">
    <div class="container mx-auto flex justify-between items-center">
      <!-- Logo Section -->
      <div class="text-xl font-bold">
        <NuxtLink to="/">SupplyEase <UBadge label="SE" variant="subtle" class="mb-0.5" /></NuxtLink>
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

<script setup>
const isSignInOpen = ref(false);
</script>

<style scoped>
/* Add custom styles here if needed */
</style>
