<template>
  <div class="procurement-details">
    <h2>{{ item.name }}</h2>
    <p>Details for {{ item.name }}</p>
    <!-- Add more details as needed -->
  </div>
</template>

<script setup>
import { ref } from 'vue';

const item = ref({ name: '' });
</script>

<style scoped>
.procurement-details h2 {
  margin-bottom: 10px;
}
</style>
