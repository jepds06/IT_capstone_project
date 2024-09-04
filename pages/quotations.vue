<template>
  <div class="p-6">
    <h1 class="text-2xl font-bold mb-4">Quotation Management</h1>
    <QuotationList />
    <QuotationDetails />
    <QuotationHistory />
  </div>
</template>

<script setup>
import QuotationList from '~/components/QuotationList.vue'
import QuotationDetails from '~/components/QuotationDetails.vue'
import QuotationHistory from '~/components/QuotationHistory.vue'
</script>

<style scoped>

</style>
