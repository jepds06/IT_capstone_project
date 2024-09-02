<template>
    <div class="search-container">
      <input
        v-model="searchQuery"
        @input="performSearch"
        type="text"
        placeholder="Search suppliers..."
        class="search-input"
      />
    </div>
  </template>
  
  <script setup>
  import { ref } from 'vue';
  
  const searchQuery = ref('');
  
  const performSearch = () => {
    // Emit an event or perform a search operation
  };
  </script>
  
  <style scoped>
  .search-container {
    margin-bottom: 20px;
  }
  .search-input {
    width: 100%;
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 4px;
  }
  </style>
  