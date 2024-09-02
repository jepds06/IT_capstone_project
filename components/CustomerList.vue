<template>
  <div class="customer-list">
    <ul>
      <li v-for="customer in customers" :key="customer.id" @click="selectCustomer(customer)">
        {{ customer.name }}
      </li>
    </ul>
  </div>
</template>

<script setup>
import { ref } from 'vue';

const customers = ref([
  { id: 1, name: 'Customer 1' },
  { id: 2, name: 'Customer 2' }
]);

const selectCustomer = (customer) => {
  // Handle customer selection
  console.log('Selected customer:', customer);
};
</script>

<style scoped>
.customer-list ul {
  list-style-type: none;
  padding: 0;
}
.customer-list li {
  cursor: pointer;
  margin-bottom: 10px;
}
</style>
