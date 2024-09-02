<template>
    <div>
      <!-- Specify the admin layout -->
      <NuxtLayout name="admin">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 pt-16 pb-28">
          <SupplierSearch />
          <SupplierList />
          <SupplierDetail />
          <SupplierForm />
          <!-- Additional content can go here -->
          <p>Your additional content can be placed here.</p>
        </div>
      </NuxtLayout>
    </div>
  </template>
  
  <script setup>
  import SupplierSearch from '@/components/SupplierSearch.vue'
  import SupplierList from '@/components/SupplierList.vue'
  import SupplierDetail from '@/components/SupplierDetail.vue'
  import SupplierForm from '@/components/SupplierForm.vue'
  </script>
  
  <style scoped>
  /* Add any custom styles you need for this page */
  </style>
  