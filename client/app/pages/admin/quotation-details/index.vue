<template>
  <div class="p-6">
    <h1 class="text-2xl font-bold mb-6">Quotation Details</h1>

    <div class="search-container">
      <input 
        type="text" 
        v-model="searchQuery" 
        placeholder="Search by Material ID..." 
        class="search-input" 
      />
    </div>

    <table class="min-w-full border-collapse">
      <thead>
        <tr>
          <th class="border text-center">Material ID</th>
          <th class="border text-center">Quantity</th>
          <th class="border text-center">Price</th>
          <th class="border text-center">Total Price</th> <!-- Added Total Price Column -->
        </tr>
      </thead>
      <tbody>
        <tr v-if="filteredDetails.length === 0">
          <td colspan="4" class="border text-center">No details found</td>
        </tr>
        <tr v-for="detail in filteredDetails" :key="detail.materialId">
          <td class="border text-center">{{ detail.materialId }}</td>
          <td class="border text-center">{{ detail.qty }}</td>
          <td class="border text-center">{{ formatCurrency(detail.price) }}</td>
          <td class="border text-center">{{ formatCurrency(detail.qty * detail.price) }}</td> <!-- Total Price Calculation -->
        </tr>
      </tbody>
    </table>

    <pagination 
      :total-items="filteredDetails.length" 
      :items-per-page="itemsPerPage" 
      @page-changed="onPageChange" 
    />
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
  return quotationDetails.value.filter(detail =>
    detail.materialId.toLowerCase().includes(searchQuery.value.toLowerCase())
  );
});

const formatCurrency = (amount) => {
  return `$${amount.toFixed(2)}`; // Example currency formatting
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

.text-center {
  text-align: center;
}
</style>
