<template>
  <div class="order-list">
    <ul>
      <li v-for="order in orders" :key="order.id">
        <a @click="selectOrder(order)">Order #{{ order.id }} - {{ order.customerName }}</a>
      </li>
    </ul>
  </div>
</template>

<script setup>
import { ref } from 'vue';

const orders = ref([
  { id: 1, customerName: 'John Doe', totalAmount: 100.00 },
  { id: 2, customerName: 'Jane Smith', totalAmount: 250.50 },
  // Add more orders as needed
]);

const selectOrder = (order) => {
  // Handle order selection, e.g., emit an event or log the selected order
  console.log('Selected order:', order);
};
</script>

<style scoped>
.order-list ul {
  list-style-type: none;
  padding: 0;
}
.order-list li {
  margin-bottom: 10px;
}
.order-list a {
  text-decoration: none;
  color: #007bff;
  cursor: pointer;
}
</style>
