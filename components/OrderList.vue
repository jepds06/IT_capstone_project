<template>
    <div class="bg-white shadow-md rounded-lg p-4">
      <h2 class="text-xl font-bold">Orders</h2>
      <ul class="mt-4 space-y-4">
        <li v-for="order in orders" :key="order.id" class="p-4 bg-gray-100 rounded-lg">
          <OrderStatusUpdate :order="order" />
        </li>
      </ul>
    </div>
  </template>
  
  <script setup>
  import { ref } from 'vue'
  import OrderStatusUpdate from './OrderStatusUpdate.vue'
  
  const orders = ref([
    { id: 1, title: 'Order #1234', status: 'Processing', details: 'Details about order #1234' },
    { id: 2, title: 'Order #5678', status: 'Shipped', details: 'Details about order #5678' }
  ])
  </script>
  
  <style scoped>
  
  </style>
  