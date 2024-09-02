<template>
  <div class="inventory-list">
    <ul>
      <li v-for="item in inventoryItems" :key="item.id">
        <a @click="selectItem(item)">{{ item.name }} - {{ item.quantity }} in stock</a>
      </li>
    </ul>
  </div>
</template>

<script setup>
import { ref } from 'vue';

const inventoryItems = ref([
  { id: 1, name: 'Item A', quantity: 10 },
  { id: 2, name: 'Item B', quantity: 5 },
  // Add more inventory items as needed
]);

const selectItem = (item) => {
  // Handle item selection, e.g., emit an event or log the selected item
  console.log('Selected item:', item);
};
</script>

<style scoped>
.inventory-list ul {
  list-style-type: none;
  padding: 0;
}
.inventory-list li {
  margin-bottom: 10px;
}
.inventory-list a {
  text-decoration: none;
  color: #007bff;
  cursor: pointer;
}
</style>
