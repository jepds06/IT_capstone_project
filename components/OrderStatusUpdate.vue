<template>
    <div class="p-4 bg-white rounded-lg shadow-md">
      <h3 class="text-lg font-bold">{{ order.title }}</h3>
      <p class="mt-2">{{ order.details }}</p>
      <p class="mt-2 text-sm text-gray-500">Status: {{ order.status }}</p>
      <button class="mt-4 bg-green-500 text-white py-2 px-4 rounded-lg shadow" @click="updateOrderStatus">
        Update Status
      </button>
    </div>
  </template>
  
  <script setup>
  const props = defineProps({
    order: {
      type: Object,
      required: true
    }
  })
  
  const updateOrderStatus = () => {
    // Handle status update action
    alert(`Updating status for ${props.order.title}`)
  }
  </script>
  
  <style scoped>
  /* Custom styles if needed */
  </style>
  