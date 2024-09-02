<template>
    <div>
      <!-- Specify the admin layout -->
      <NuxtLayout name="admin">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 pt-16 pb-28">
          <InventorySearch />
          <InventoryList />
          <InventoryDetail />
          <InventoryForm />
          <!-- Additional content can go here -->
          <p>Your additional content can be placed here.</p>
        </div>
      </NuxtLayout>
    </div>
  </template>
  
  <script setup>
  import InventorySearch from '@/components/InventorySearch.vue'
  import InventoryList from '@/components/InventoryList.vue'
  import InventoryDetail from '@/components/InventoryDetail.vue'
  import InventoryForm from '@/components/InventoryForm.vue'
  </script>
  
  <style scoped>
  /* Add any custom styles you need for this page */
  </style>
  