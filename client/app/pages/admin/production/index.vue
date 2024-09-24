<template>
    <div class="p-6">
      <h2 class="text-2xl font-bold mb-4">Productions</h2>
  
      <div class="flex justify-between mb-4">
        <input
          type="text"
          v-model="searchQuery"
          placeholder="Search..."
          class="w-1/3 p-2 border rounded-lg"
        />
      </div>
  
      <!-- Productions Table -->
      <table class="min-w-full bg-white border border-gray-300">
        <thead class="bg-gray-100">
          <tr>
            <th class="px-6 py-2 text-left border-b">Production ID</th>
            <th class="px-6 py-2 text-left border-b">Created By</th>
            <th class="px-6 py-2 text-left border-b">Date Encoded</th>
            <th class="px-6 py-2 text-left border-b">Year</th>
            <th class="px-6 py-2 text-left border-b">Month</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="production in filteredProductions" :key="production.id" class="hover:bg-gray-50">
            <td class="px-6 py-4 border-b">{{ production.id }}</td>
            <td class="px-6 py-4 border-b">{{ production.createdBy }}</td>
            <td class="px-6 py-4 border-b">{{ production.dateEncoded }}</td>
            <td class="px-6 py-4 border-b">{{ production.year }}</td>
            <td class="px-6 py-4 border-b">{{ production.month }}</td>
          </tr>
        </tbody>
      </table>
  
      <!-- Pagination -->
      <div class="mt-4 flex justify-between">
        <button
          @click="prevPage"
          :disabled="currentPage === 1"
          class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400"
        >
          Previous
        </button>
        <span>Page {{ currentPage }} of {{ totalPages }}</span>
        <button
          @click="nextPage"
          :disabled="currentPage === totalPages"
          class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400"
        >
          Next
        </button>
      </div>
      </div>
  </template>
  
  <script setup>
  import { ref, computed } from 'vue';
  
  // Sample data (replace with actual data)
  const productions = ref([
    { id: 1, createdBy: 'Admin', dateEncoded: '2024-09-23', year: 2024, month: 'September' },
    { id: 2, createdBy: 'User1', dateEncoded: '2024-09-22', year: 2024, month: 'September' },
    // Add more sample production data here...
  ]);
  
  const searchQuery = ref('');
  const currentPage = ref(1);
  const itemsPerPage = 10;
  
  const filteredProductions = computed(() => {
    if (!searchQuery.value) {
      return productions.value.slice((currentPage.value - 1) * itemsPerPage, currentPage.value * itemsPerPage);
    }
  
    return productions.value.filter(
      (production) =>
        production.id.toString().includes(searchQuery.value) ||
        production.createdBy.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
        production.dateEncoded.includes(searchQuery.value)
    );
  });
  
  const onPageChanged = (page) => {
    currentPage.value = page;
  };
  </script>
  
  <style scoped>
  /* Add styles if needed */
  </style>
  