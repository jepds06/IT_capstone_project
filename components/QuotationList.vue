<template>
    <div class="bg-white shadow-md rounded-lg p-4">
      <h2 class="text-xl font-bold">Quotations</h2>
      <ul class="mt-4 space-y-4">
        <li v-for="quotation in quotations" :key="quotation.id" class="p-4 bg-gray-100 rounded-lg">
          <QuotationDetails :quotation="quotation" />
        </li>
      </ul>
    </div>
  </template>
  
  <script setup>
  import { ref } from 'vue'
  import QuotationDetails from './QuotationDetails.vue'
  
  const quotations = ref([
    { id: 1, title: 'Quotation #1234', status: 'Pending', details: 'Details about quotation #1234' },
    { id: 2, title: 'Quotation #5678', status: 'Approved', details: 'Details about quotation #5678' }
  ])
  </script>
  
  <style scoped>
  /* Custom styles if needed */
  </style>
  