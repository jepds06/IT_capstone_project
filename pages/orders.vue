<template>
  <div class="p-6">
    <h1 class="text-2xl font-bold mb-4">Order Management</h1>
    <OrderList />
    <OrderStatusUpdate />
    <OrderNotification />
  </div>
</template>

<script setup>
import OrderList from '~/components/OrderList.vue'
import OrderStatusUpdate from '~/components/OrderStatusUpdate.vue'
import OrderNotification from '~/components/OrderNotification.vue'
</script>

<style scoped>

</style>
