<template>
  <div class="supplier-details" v-if="supplier">
    <h2>{{ supplier.name }}</h2>
    <p>Contact: {{ supplier.contact }}</p>
    <p>Address: {{ supplier.address }}</p>
    <!-- Add more supplier details here -->
  </div>
  <div v-else>
    <p>Select a supplier to see the details.</p>
  </div>
</template>

<script setup>
import { computed } from 'vue';

// Assuming the supplier is passed as a prop
const props = defineProps({
  supplier: {
    type: Object,
    required: false,
    default: null,
  },
});
</script>

<style scoped>
.supplier-details {
  border: 1px solid #ddd;
  padding: 10px;
  margin-top: 20px;
}
</style>
