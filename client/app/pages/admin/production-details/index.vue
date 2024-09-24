<template>
    <div class="p-6">
      <!-- Page Title -->
      <h2 class="text-2xl font-bold mb-4">Production Details</h2>
  
      <!-- Generate Production Materials Button -->
      <button class="mb-4 bg-blue-500 text-white px-4 py-2 rounded" @click="generateMaterials">
        Generate Production Materials
      </button>

      <!-- Modal for Generating Materials -->
    <div v-if="showModal" class="modal">
      <div class="modal-content">
        <h3>Generate Production Materials</h3>
        <p>Are you sure you want to generate materials for Production ID: {{ selectedProductionId }}?</p>
        <button @click="confirmGeneration">Confirm</button>
        <button @click="showModal = false">Cancel</button>
      </div>
    </div>
  
      <!-- Search Bar -->
      <div class="flex justify-between mb-4">
        <input
          type="text"
          v-model="searchQuery"
          placeholder="Search..."
          class="w-1/3 p-2 border rounded-lg"
        />
      </div>
  
      <!-- Production Details Table -->
      <table class="min-w-full bg-white border border-gray-300">
        <thead class="bg-gray-100">
          <tr>
            <th class="px-6 py-2 text-left border-b">Product Details No</th>
            <th class="px-6 py-2 text-left border-b">Production ID</th>
            <th class="px-6 py-2 text-left border-b">Product ID Qty</th>
            <th class="px-6 py-2 text-left border-b">Status</th>
            <th class="px-6 py-2 text-left border-b">Remarks</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="detail in filteredDetails" :key="detail.productDetailsNo" class="hover:bg-gray-50">
            <td class="px-6 py-4 border-b">{{ detail.productDetailsNo }}</td>
            <td class="px-6 py-4 border-b">{{ detail.productionId }}</td>
            <td class="px-6 py-4 border-b">{{ detail.productIdQty }}</td>
            <td class="px-6 py-4 border-b">
              <span v-if="detail.status === 'complete'" class="text-green-600">✔️</span>
              <span v-else-if="detail.status === 'pending'" class="text-yellow-600">⚠️</span>
              <span v-else class="text-red-600">❌</span>
            </td>
            <td class="px-6 py-4 border-b">{{ detail.remarks }}</td>
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
  const productionDetails = ref([
    { productDetailsNo: 1, productionId: 101, productIdQty: 50, status: 'complete', remarks: 'All good' },
    { productDetailsNo: 2, productionId: 102, productIdQty: 30, status: 'pending', remarks: 'Awaiting approval' },
    // Add more sample details here...
  ]);
  
  const searchQuery = ref('');
  const currentPage = ref(1);
  const itemsPerPage = 10;
  
  const filteredDetails = computed(() => {
    if (!searchQuery.value) {
      return productionDetails.value.slice((currentPage.value - 1) * itemsPerPage, currentPage.value * itemsPerPage);
    }
  
    return productionDetails.value.filter(
      (detail) =>
        detail.productDetailsNo.toString().includes(searchQuery.value) ||
        detail.productionId.toString().includes(searchQuery.value) ||
        detail.remarks.toLowerCase().includes(searchQuery.value.toLowerCase())
    );
  });
  
  const generateMaterials = (productionId) => {
  selectedProductionId.value = productionId;
  showModal.value = true;
};

const confirmGeneration = () => {
  // Logic to generate materials
  console.log("Materials generated for Production ID:", selectedProductionId.value);
  showModal.value = false; // Close the modal
};
  </script>
  
  <style scoped>
  .modal {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0, 0, 0, 0.5);
  display: flex;
  align-items: center;
  justify-content: center;
}
.modal-content {
  background: white;
  padding: 20px;
  border-radius: 5px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
}

  </style>
  