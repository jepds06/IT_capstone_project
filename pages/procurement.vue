<template>
    <div>
      <!-- Specify the admin layout -->
      <NuxtLayout name="admin">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 pt-16 pb-28">
          <ProcurementSearch />
          <ProcurementList />
          <ProcurementDetail />
          <ProcurementForm />
          <!-- Additional content can go here -->
          <p>Your additional content can be placed here.</p>
        </div>
      </NuxtLayout>
    </div>
  </template>
  
  <script setup>
  import ProcurementSearch from '@/components/ProcurementSearch.vue'
  import ProcurementList from '@/components/ProcurementList.vue'
  import ProcurementDetail from '@/components/ProcurementDetail.vue'
  import ProcurementForm from '@/components/ProcurementForm.vue'
  </script>
  
  <style scoped>
  /* Add any custom styles you need for this page */
  </style>
  