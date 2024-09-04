<template>
    <div class="p-6">
      <h1 class="text-2xl font-bold mb-4">Reporting and Analytics</h1>
      <QuotationReport />
      <OrderReport />
      <DataExport />
    </div>
  </template>
  
  <script setup>
  import QuotationReport from '~/components/QuotationReport.vue'
  import OrderReport from '~/components/OrderReport.vue'
  import DataExport from '~/components/DataExport.vue'
  </script>
  
  <style scoped>

  </style>
  