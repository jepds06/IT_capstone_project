<template>
  <div class="inventory-details" v-if="item">
    <h2>{{ item.name }}</h2>
    <p>ID: {{ item.id }}</p>
    <p>Quantity: {{ item.quantity }}</p>
    <!-- Add more item details here -->
  </div>
  <div v-else>
    <p>Select an item to see the details.</p>
  </div>
</template>

<script setup>
import { computed } from 'vue';

// Assuming the item is passed as a prop
const props = defineProps({
  item: {
    type: Object,
    required: false,
    default: null,
  },
});
</script>

<style scoped>
.inventory-details {
  border: 1px solid #ddd;
  padding: 10px;
  margin-top: 20px;
}
</style>
