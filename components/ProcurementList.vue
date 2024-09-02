<template>
  <div class="procurement-list">
    <ul>
      <li v-for="item in items" :key="item.id" @click="selectItem(item)">
        {{ item.name }}
      </li>
    </ul>
  </div>
</template>

<script setup>
import { ref } from 'vue';

const items = ref([
  { id: 1, name: 'Procurement Item 1' },
  { id: 2, name: 'Procurement Item 2' }
]);

const selectItem = (item) => {
  // Handle item selection
};
</script>

<style scoped>
.procurement-list ul {
  list-style-type: none;
  padding: 0;
}
.procurement-list li {
  cursor: pointer;
  margin-bottom: 10px;
}
</style>
