<template>
  <div class="p-6">
    <!-- Page Title -->
    <h2 class="text-2xl font-bold mb-4">Quotation Details</h2>

    <!-- Search Bar -->
    <div class="flex justify-between mb-4">
      <input
        type="text"
        v-model="searchQuery"
        placeholder="Search by Material ID..."
        class="w-1/3 p-2 border rounded-lg"
      />
    </div>

    <!-- Quotation Details Table -->
    <table class="min-w-full bg-white border border-gray-300">
      <thead class="bg-gray-100">
        <tr>
          <th class="px-6 py-2 text-black text-left border-b">Material ID</th>
          <th class="px-6 py-2 text-black text-left border-b">Quantity</th>
          <th class="px-6 py-2 text-black text-left border-b">Price</th>
          <th class="px-6 py-2 text-black text-left border-b">Total Price</th>
        </tr>
      </thead>
      <tbody>
        <tr v-if="filteredDetails.length === 0">
          <td colspan="4" class="border text-center">No details found</td>
        </tr>
        <tr v-for="detail in filteredDetails" :key="detail.materialId" class="hover:bg-gray-50">
          <td class="px-6 py-4 text-black border-b">{{ detail.materialId }}</td>
          <td class="px-6 py-4 text-black border-b">{{ detail.qty }}</td>
          <td class="px-6 py-4 text-black border-b">{{ formatCurrency(detail.price) }}</td>
          <td class="px-6 py-4 text-black border-b">{{ formatCurrency(detail.qty * detail.price) }}</td>
        </tr>
      </tbody>
    </table>

    <!-- Pagination -->
    <div class="mt-4 flex text-white justify-between">
      <button
        @click="prevPage"
        :disabled="currentPage === 1"
        class="px-4 py-2 bg-red-600 rounded hover:bg-red-500"
      >
        Previous
      </button>
      <span>Page {{ currentPage }} of {{ totalPages }}</span>
      <button
        @click="nextPage"
        :disabled="currentPage === totalPages"
        class="px-4 py-2 bg-green-600 rounded hover:bg-green-500"
      >
        Next
      </button>
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

const searchQuery = ref('');
const itemsPerPage = 10;
const currentPage = ref(1);

const quotationDetails = ref([
  // Sample data
  { materialId: 'M001', qty: 10, price: 100 },
  { materialId: 'M002', qty: 5, price: 50 },
  // Add more details as needed
]);

const filteredDetails = computed(() => {
  const start = (currentPage.value - 1) * itemsPerPage;
  const end = start + itemsPerPage;

  return quotationDetails.value.filter(detail =>
    detail.materialId.toLowerCase().includes(searchQuery.value.toLowerCase())
  ).slice(start, end);
});

const formatCurrency = (amount) => {
  return `$${amount.toFixed(2)}`; // Example currency formatting
};

// Pagination methods
const totalPages = computed(() => Math.ceil(filteredDetails.value.length / itemsPerPage));
const nextPage = () => {
  if (currentPage.value < totalPages.value) {
    currentPage.value++;
  }
};
const prevPage = () => {
  if (currentPage.value > 1) {
    currentPage.value--;
  }
};
</script>

<style scoped>
.search-container {
  margin-bottom: 1rem;
}

.search-input {
  padding: 0.5rem;
  border: 1px solid #ccc;
  border-radius: 4px;
}

.text-center {
  text-align: center;
}

.hover\:bg-gray-50:hover {
  background-color: #f9fafb;
}
</style>
