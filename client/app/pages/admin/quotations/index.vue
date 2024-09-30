<template>
  <div class="p-6">
    <h1 class="text-2xl font-bold mb-6">Quotations</h1>

    <div class="search-container">
      <input 
        type="text" 
        v-model="searchQuery" 
        placeholder="Search..." 
        class="search-input" 
      />
    </div>

    <table class="min-w-full border-collapse">
      <thead>
        <tr>
          <th class="border text-center">Quotation No.</th>
          <th class="border text-center">Supplier Name</th>
          <th class="border text-center">Supplier ID</th>
          <th class="border text-center">Date</th>
          <th class="border text-center">Status</th> <!-- Added Status Column -->
          <th class="border text-center">Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="quotation in paginatedQuotations" :key="quotation.quotationNo">
          <td class="border text-center">{{ quotation.quotationNo }}</td>
          <td class="border text-center">{{ quotation.supplier }}</td>
          <td class="border text-center">{{ quotation.supplierId }}</td>
          <td class="border text-center">{{ formatDate(quotation.date) }}</td>
          <td class="border text-center">{{ quotation.status }}</td> <!-- Added Status Data -->
          <td class="border text-center">
            <button @click="viewQuotation(quotation)" class="btn"><i class="fas fa-eye"></i></button>
            <button @click="editQuotation(quotation)" class="btn"><i class="fas fa-edit"></i></button>
          </td>
        </tr>
      </tbody>
    </table>

    <pagination 
      :total-items="filteredQuotations.length" 
      :items-per-page="itemsPerPage" 
      @page-changed="onPageChange" 
    />

    <!-- Pagination Logic -->
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
import auth from '../../../../middleware/auth'
// This page requires authentication
definePageMeta({
  middleware: [auth],
});

import { ref, computed } from 'vue';

const searchQuery = ref('');
const itemsPerPage = 10;
const currentPage = ref(1);
const isModalVisible = ref(false);
const currentQuotation = ref(null);

const quotations = ref([
  // Sample data
  { quotationNo: 1, supplier: 'Supplier A', supplierId: 'S001', date: '2024-01-01', status: 'Pending' },
  { quotationNo: 2, supplier: 'Supplier B', supplierId: 'S002', date: '2024-01-02', status: 'Accepted' },
  // Add more quotations as needed
]);

const filteredQuotations = computed(() => {
  return quotations.value.filter(quotation =>
    quotation.supplier.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
    quotation.supplierId.toLowerCase().includes(searchQuery.value.toLowerCase())
  );
});

// Pagination logic
const totalPages = computed(() => Math.ceil(filteredQuotations.value.length / itemsPerPage));
const paginatedQuotations = computed(() => {
  const start = (currentPage.value - 1) * itemsPerPage;
  return filteredQuotations.value.slice(start, start + itemsPerPage);
});

const formatDate = (dateString) => {
  // Implement date formatting logic here
  return new Date(dateString).toLocaleDateString(); // Example
};

const viewQuotation = (quotation) => {
  currentQuotation.value = quotation;
  isModalVisible.value = true;
};

const editQuotation = (quotation) => {
  currentQuotation.value = quotation;
  isModalVisible.value = true; // Open modal for editing
};

const onPageChange = (newPage) => {
  currentPage.value = newPage;
};
</script>

<style>
.search-container {
  margin-bottom: 1rem;
}

.search-input {
  padding: 0.5rem;
  border: 1px solid #ccc;
  border-radius: 4px;
}

.btn {
  background: none;
  border: none;
  cursor: pointer;
}

.text-center {
  text-align: center;
}
</style>
