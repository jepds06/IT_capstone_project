<template>
  <div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Modules</h1>
    
    <input
      type="text"
      v-model="searchQuery"
      placeholder="Search Modules"
      class="border p-2 mb-4 w-full"
    />
    
    <table class="min-w-full bg-white border">
      <thead>
        <tr>
          <th class="border px-4 py-2">Module No.</th>
          <th class="border px-4 py-2">Module Name</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="module in filteredModules" :key="module.id">
          <td class="border px-4 py-2">{{ module.number }}</td>
          <td class="border px-4 py-2">{{ module.name }}</td>
        </tr>
      </tbody>
    </table>
    
    <!-- Pagination -->
    <div class="flex justify-between items-center mt-4">
      <span>Showing {{ currentPageStart }}-{{ currentPageEnd }} of {{ totalModules }}</span>
      <div>
        <button @click="previousPage" class="px-4 py-2" :disabled="currentPage === 1">Previous</button>
        <button @click="nextPage" class="px-4 py-2" :disabled="currentPage === totalPages">Next</button>
      </div>
    </div>
  </div>
</template>

<script setup>
import auth from '../../../../middleware/auth'
// This page requires authentication
definePageMeta({
  middleware: [auth],
});

import { ref, computed } from 'vue';

const modules = ref([
  { id: 1, number: '001', name: 'Introduction to Supply Chain' },
  { id: 2, number: '002', name: 'Inventory Management' },
  // More module objects...
]);

const searchQuery = ref('');
const currentPage = ref(1);
const itemsPerPage = 10;

const filteredModules = computed(() => {
  return modules.value.filter(module => {
    return module.name.toLowerCase().includes(searchQuery.value.toLowerCase());
  });
});

const totalModules = computed(() => filteredModules.value.length);
const totalPages = computed(() => Math.ceil(totalModules.value / itemsPerPage));
const currentPageStart = computed(() => (currentPage.value - 1) * itemsPerPage + 1);
const currentPageEnd = computed(() => Math.min(currentPage.value * itemsPerPage, totalModules.value));

const paginatedModules = computed(() => {
  const start = (currentPage.value - 1) * itemsPerPage;
  return filteredModules.value.slice(start, start + itemsPerPage);
});

const previousPage = () => {
  if (currentPage.value > 1) currentPage.value--;
};

const nextPage = () => {
  if (currentPage.value < totalPages.value) currentPage.value++;
};
</script>

<style lang="scss" scoped>

</style>