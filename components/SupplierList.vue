<template>
  <div class="supplier-list">
    <ul>
      <li v-for="supplier in suppliers" :key="supplier.id">
        <a @click="selectSupplier(supplier)">{{ supplier.name }}</a>
      </li>
    </ul>
  </div>
</template>

<script setup>
import { ref } from 'vue';

const suppliers = ref([
  { id: 1, name: 'Supplier A', contact: 'contactA@example.com' },
  { id: 2, name: 'Supplier B', contact: 'contactB@example.com' },
  // Add more suppliers as needed
]);

const selectSupplier = (supplier) => {
  // Handle supplier selection, e.g., emit an event or log the selected supplier
  console.log('Selected supplier:', supplier);
};
</script>

<style scoped>
.supplier-list ul {
  list-style-type: none;
  padding: 0;
}
.supplier-list li {
  margin-bottom: 10px;
}
.supplier-list a {
  text-decoration: none;
  color: #007bff;
  cursor: pointer;
}
</style>
