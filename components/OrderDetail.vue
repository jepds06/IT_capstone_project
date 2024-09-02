<template>
  <div class="order-details" v-if="order">
    <h2>Order #{{ order.id }}</h2>
    <p>Customer: {{ order.customerName }}</p>
    <p>Total Amount: ${{ order.totalAmount.toFixed(2) }}</p>
    <!-- Add more order details here -->
  </div>
  <div v-else>
    <p>Select an order to see the details.</p>
  </div>
</template>

<script setup>
import { computed } from 'vue';

// Assuming the order is passed as a prop
const props = defineProps({
  order: {
    type: Object,
    required: false,
    default: null,
  },
});
</script>

<style scoped>
.order-details {
  border: 1px solid #ddd;
  padding: 10px;
  margin-top: 20px;
}
</style>
