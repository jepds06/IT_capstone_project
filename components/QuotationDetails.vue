<template>
    <div class="p-4 bg-white rounded-lg shadow-md">
      <h3 class="text-lg font-bold">{{ quotation.title }}</h3>
      <p class="mt-2">{{ quotation.details }}</p>
      <p class="mt-2 text-sm text-gray-500">Status: {{ quotation.status }}</p>
      <button class="mt-4 bg-blue-500 text-white py-2 px-4 rounded-lg shadow" @click="respondToQuotation">
        Respond
      </button>
    </div>
  </template>
  
  <script setup>
  const props = defineProps({
    quotation: {
      type: Object,
      required: true
    }
  })
  
  const respondToQuotation = () => {
    // Handle response action
    alert(`Responding to ${props.quotation.title}`)
  }
  </script>
  
  <style scoped>
  /* Custom styles if needed */
  </style>
  