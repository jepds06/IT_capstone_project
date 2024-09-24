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
            <th class="border text-center">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="quotation in filteredQuotations" :key="quotation.quotationNo">
            <td class="border text-center">{{ quotation.quotationNo }}</td>
            <td class="border text-center">{{ quotation.supplier }}</td>
            <td class="border text-center">{{ quotation.supplierId }}</td>
            <td class="border text-center">{{ quotation.date }}</td>
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
  
      <!-- Modal for Viewing/Edit Quotation -->
      <modal v-if="isModalVisible" @close="isModalVisible">
        <template #header>
          <h3>{{ currentQuotation ? 'Edit Quotation' : 'View Quotation' }}</h3>
        </template>
        <template #body>
          <div>
            <p><strong>Quotation No:</strong> {{ currentQuotation?.quotationNo }}</p>
            <p><strong>Supplier:</strong> {{ currentQuotation?.supplier }}</p>
            <p><strong>Supplier ID:</strong> {{ currentQuotation?.supplierId }}</p>
            <p><strong>Date:</strong> {{ currentQuotation?.date }}</p>
            <!-- Add more fields as needed -->
          </div>
        </template>
        <template #footer>
          <button @click="isModalVisible = false">Close</button>
        </template>
      </modal>
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
  
  const searchQuery = ref('');
  const itemsPerPage = 10; // Adjust as needed
  const currentPage = ref(1);
  const isModalVisible = ref(false);
  const currentQuotation = ref(null);
  
  const quotations = ref([
    // Sample data
    { quotationNo: 1, supplier: 'Supplier A', supplierId: 'S001', date: '2024-01-01' },
    { quotationNo: 2, supplier: 'Supplier B', supplierId: 'S002', date: '2024-01-02' },
    // Add more quotations as needed
  ]);
  
  const filteredQuotations = computed(() => {
    return quotations.value.filter(quotation =>
      quotation.supplier.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
      quotation.supplierId.toLowerCase().includes(searchQuery.value.toLowerCase())
    );
  });
  
  const viewQuotation = (quotation) => {
    currentQuotation.value = quotation;
    isModalVisible.value = true;
  };
  
  const editQuotation = (quotation) => {
    // Logic to edit the quotation
    currentQuotation.value = quotation;
    isModalVisible.value = true; // Open modal for editing
  };
  
  const onPageChange = (newPage) => {
    currentPage.value = newPage;
    // Logic to fetch or filter items based on the new page
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
  