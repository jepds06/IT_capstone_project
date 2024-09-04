<template>
  <div class="p-6">
    <h1 class="text-2xl font-bold mb-4">Inventory Management</h1>
    <ProductCatalog />
    <StockUpdate />
  </div>
</template>

<script setup>
import ProductCatalog from '~/components/ProductCatalog.vue'
import StockUpdate from '~/components/StockUpdate.vue'
</script>

<style scoped>

</style>
