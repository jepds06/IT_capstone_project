<template>
    <div>
      <!-- Specify the admin layout -->
      <NuxtLayout name="admin">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 pt-16 pb-28">
          <CustomerSearch />
          <CustomerList />
          <CustomerDetail />
          <CustomerForm />
          <!-- Additional content can go here -->
          <p>Your additional content can be placed here.</p>
        </div>
      </NuxtLayout>
    </div>
  </template>
  
  <script setup>
  import CustomerSearch from '@/components/CustomerSearch.vue';
  import CustomerList from '@/components/CustomerList.vue';
  import CustomerDetail from '@/components/CustomerDetail.vue';
  import CustomerForm from '@/components/CustomerForm.vue';
  </script>
  
  <style scoped>
  /* Add any custom styles you need for this page */
  </style>
  