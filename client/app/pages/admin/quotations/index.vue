<template>
  <div class="p-6">
    <h1 class="text-2xl font-bold mb-4">Quotations</h1>

    <!-- Search Bar -->
    <div class="mb-4">
      <input
        v-model="searchQuery"
        type="text"
        placeholder="Search Quotations..."
        class="p-2 border border-gray-300 rounded w-48"
        @input="searchQuotations"
      />
    </div>

    <!-- Quotations Table -->
    <table class="min-w-full border-collapse border">
      <thead>
        <tr class="bg-gray-200">
          <th class="border p-2 text-center cursor-pointer" @click="sort('quotationNo')">
            Quotation No
          </th>
          <th class="border p-2 text-center cursor-pointer" @click="sort('materialID')">
            Material ID
          </th>
          <th class="border p-2 text-center cursor-pointer" @click="sort('quantity')">
            Quantity
          </th>
          <th class="border p-2 text-center cursor-pointer" @click="sort('status')">
            Status
          </th>
          <th class="border p-2 text-center">Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="quotation in paginatedQuotations" :key="quotation.id">
          <td class="border p-2 text-center">{{ quotation.quotationNo }}</td>
          <td class="border p-2 text-center">{{ quotation.materialID }}</td>
          <td class="border p-2 text-center">{{ quotation.quantity }}</td>
          <td class="border p-2 text-center">
            <span class="flex items-center justify-center">
              <span :class="statusIconClass(quotation.status)"></span>
              <span class="ml-2">{{ quotation.status }}</span>
            </span>
          </td>
          <td class="border p-2 text-center">
            <button @click="openModal(quotation)" class="text-blue-500">
              <img src="https://img.icons8.com/ios-filled/24/000000/settings.png" alt="Send to Supplier" />
            </button>
          </td>
        </tr>
      </tbody>
    </table>

    <!-- Pagination Controls -->
    <div class="flex justify-between items-center mt-4">
      <button @click="prevPage" :disabled="currentPage === 1" class="bg-gray-300 px-4 py-2 rounded">
        Previous
      </button>
      <span>
        Page {{ currentPage }} of {{ totalPages }}
      </span>
      <button @click="nextPage" :disabled="currentPage === totalPages" class="bg-gray-300 px-4 py-2 rounded">
        Next
      </button>
    </div>

    <!-- Confirmation Modal -->
    <div v-if="isModalOpen" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
      <div class="bg-white rounded-lg p-6 w-96">
        <h2 class="text-lg font-bold mb-4">Confirm Action</h2>
        <p>Are you sure you want to send quotation {{ selectedQuotation.quotationNo }} to the supplier?</p>
        <div class="flex justify-end mt-4">
          <button @click="closeModal" class="bg-gray-300 px-4 py-2 rounded mr-2">Cancel</button>
          <button @click="sendToSupplier(selectedQuotation)" class="bg-blue-500 text-white px-4 py-2 rounded">Send</button>
        </div>
      </div>
    </div>

    <!-- Submission Confirmation Modal -->
    <div v-if="isConfirmationModalOpen" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
      <div class="bg-white rounded-lg p-6 w-96">
        <h2 class="text-lg font-bold mb-4">Quotation Submitted</h2>
        <p>Quotation {{ selectedQuotation.quotationNo }} has been successfully submitted to the supplier.</p>
        <div class="flex justify-end mt-4">
          <button @click="closeConfirmationModal" class="bg-blue-500 text-white px-4 py-2 rounded">OK</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import auth from "../../../../middleware/auth";
// This page requires authentication
definePageMeta({
  middleware: [auth],
});

import { ref, computed } from "vue";

export default {
  data() {
    return {
      searchQuery: '',
      currentPage: 1,
      itemsPerPage: 10,
      quotations: [
        { id: 1, quotationNo: 'QT-001', materialID: 'MAT-101', quantity: 100, status: 'Pending' },
        { id: 2, quotationNo: 'QT-002', materialID: 'MAT-102', quantity: 50, status: 'Sent' },
        { id: 3, quotationNo: 'QT-003', materialID: 'MAT-103', quantity: 30, status: 'Approved' },
        { id: 4, quotationNo: 'QT-004', materialID: 'MAT-104', quantity: 20, status: 'Rejected' },
        // Add more items as needed
      ],
      isModalOpen: false,
      isConfirmationModalOpen: false,
      selectedQuotation: {},
    };
  },
  computed: {
    paginatedQuotations() {
      const start = (this.currentPage - 1) * this.itemsPerPage;
      const end = start + this.itemsPerPage;
      return this.filteredQuotations.slice(start, end);
    },
    totalPages() {
      return Math.ceil(this.filteredQuotations.length / this.itemsPerPage);
    },
    filteredQuotations() {
      if (this.searchQuery) {
        return this.quotations.filter(quotation =>
          quotation.materialID.toLowerCase().includes(this.searchQuery.toLowerCase())
        );
      }
      return this.quotations;
    },
  },
  methods: {
    searchQuotations() {
      this.currentPage = 1;
    },
    sort(column) {
      // Implement sorting logic if necessary
    },
    openModal(quotation) {
      this.selectedQuotation = quotation;
      this.isModalOpen = true;
    },
    closeModal() {
      this.isModalOpen = false;
      this.selectedQuotation = {};
    },
    sendToSupplier(quotation) {
      console.log(`Sending quotation ${quotation.quotationNo} to supplier...`);
      this.isModalOpen = false;
      this.isConfirmationModalOpen = true; // Open the confirmation modal
      // Logic to send the quotation to the supplier
    },
    closeConfirmationModal() {
      this.isConfirmationModalOpen = false;
      this.selectedQuotation = {};
    },
    prevPage() {
      if (this.currentPage > 1) this.currentPage--;
    },
    nextPage() {
      if (this.currentPage < this.totalPages) this.currentPage++;
    },
    statusIconClass(status) {
      switch (status) {
        case 'Pending':
          return 'w-4 h-4 bg-yellow-400 rounded-full'; 
        case 'Sent':
          return 'w-4 h-4 bg-blue-400 rounded-full'; 
        case 'Approved':
          return 'w-4 h-4 bg-green-400 rounded-full'; 
        case 'Rejected':
          return 'w-4 h-4 bg-red-400 rounded-full'; 
        default:
          return 'w-4 h-4 bg-gray-400 rounded-full'; 
      }
    },
  },
};
</script>

<style scoped>
.modal-overlay {
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
  border-radius: 8px;
  width: 700px;
}
</style>
