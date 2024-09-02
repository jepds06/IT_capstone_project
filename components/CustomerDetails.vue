<template>
  <div class="customer-detail">
    <!-- Display details of the selected customer here -->
    <p>Customer Detail Component</p>
  </div>
</template>

<script setup>
import { ref } from 'vue';

const customer = ref(null);

// Function to set the selected customer details
const setCustomerDetail = (selectedCustomer) => {
  customer.value = selectedCustomer;
};
</script>

<style scoped>
.customer-detail {
  /* Add styling for customer details */
}
</style>
