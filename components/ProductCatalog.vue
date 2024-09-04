<template>
    <div class="bg-white shadow-md rounded-lg p-4">
      <h2 class="text-xl font-bold">Product Catalog</h2>
      <ul class="mt-4 space-y-4">
        <li v-for="product in products" :key="product.id" class="p-4 bg-gray-100 rounded-lg">
          <h3 class="text-lg">{{ product.name }}</h3>
          <p class="mt-2 text-sm text-gray-500">Stock: {{ product.stock }}</p>
          <button class="mt-2 bg-yellow-500 text-white py-2 px-4 rounded-lg shadow" @click="updateStock">
            Update Stock
          </button>
        </li>
      </ul>
    </div>
  </template>
  
  <script setup>
  import { ref } from 'vue'
  
  const products = ref([
    { id: 1, name: 'Product XYZ', stock: 10 },
    { id: 2, name: 'Product ABC', stock: 5 }
  ])
  
  const updateStock = () => {
    // Handle stock update action
    alert('Updating stock')
  }
  </script>
  
  <style scoped>
  /* Custom styles if needed */
  </style>
  