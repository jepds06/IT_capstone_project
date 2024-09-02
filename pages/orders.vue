<template>
    <div>
      <!-- Specify the admin layout -->
      <NuxtLayout name="admin">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 pt-16 pb-28">
          <OrderSearch />
          <OrderList />
          <OrderDetail />
          <OrderForm />
          <!-- Additional content can go here -->
          <p>Your additional content can be placed here.</p>
        </div>
      </NuxtLayout>
    </div>
  </template>
  
  <script setup>
  import OrderSearch from '@/components/OrderSearch.vue'
  import OrderList from '@/components/OrderList.vue'
  import OrderDetail from '@/components/OrderDetail.vue'
  import OrderForm from '@/components/OrderForm.vue'
  </script>
  
  <style scoped>
  /* Add any custom styles you need for this page */
  </style>
  