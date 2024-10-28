<template>
  <div class="mx-auto py-10">
    <!-- Quotation Table -->
    <h2 class="text-2xl font-bold mb-6">Supplier Quotation</h2>

    <!-- Search Bar -->
    <input
      v-model="searchQuery"
      type="text"
      placeholder="Search..."
      class="p-2 border border-gray-300 rounded w-48 mb-4"
    />

    <!-- Quotation Table with Remarks Column -->
    <table class="min-w-full bg-white border border-gray-500">
      <thead class="bg-gray-200">
        <tr>
          <th class="py-2 px-4 text-left">Quotation No.</th>
          <th class="py-2 px-4 text-left">Date</th>
          <th class="py-2 px-4 text-left">Sent By</th>
          <th class="py-2 px-4 text-left">Status</th>
          <th class="py-2 px-4 text-left">Remarks</th>
          <th class="py-2 px-4 text-left">Action</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(quotation, index) in paginatedQuotations" :key="index">
          <td class="py-2 px-4">{{ quotation.number }}</td>
          <td class="py-2 px-4">{{ quotation.date }}</td>
          <td class="py-2 px-4">{{ quotation.sentBy }}</td>
          <td class="py-2 px-4">{{ quotation.status }}</td>
          <td class="py-2 px-4">{{ quotation.remarks }}</td>
          <td class="py-2 px-4">
            <button @click="openQuotationModal(quotation)" class="text-blue-600">
              <i class="fas fa-eye"></i>
            </button>
          </td>
        </tr>
      </tbody>
    </table>

    <!-- Quotation View Modal -->
    <div v-if="selectedQuotation" class="fixed inset-0 bg-gray-700 bg-opacity-75 flex items-center justify-center">
      <div class="bg-white p-6 rounded-md w-1/2">
        <h3 class="text-xl font-bold mb-4">Quotation Details (Quotation No: {{ selectedQuotation.number }})</h3>
        <table class="min-w-full bg-white border border-gray-300 mb-4">
          <thead class="bg-gray-200">
            <tr>
              <th class="py-2 px-4 text-left">Supplier</th>
              <th class="py-2 px-4 text-left">Remarks</th>
              <th class="py-2 px-4 text-left">Action</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(supplier, index) in selectedQuotation.suppliers" :key="index">
              <td class="py-2 px-4 relative">
                <span
                  @click="openSupplierDetails(supplier)"
                  @mouseleave="closeSupplierDetails"
                  class="text-blue-600 underline cursor-pointer"
                >
                  {{ supplier.name }}
                </span>
                <div
                  v-if="hoveredSupplier === supplier"
                  class="absolute bg-white border border-gray-300 p-2 w-64 top-8 left-0 z-10"
                >
                <h3 class="text-xl font-bold mb-4">Supplier Quotation Details</h3>
                  <p><strong>Quantity:</strong> {{ supplier.qty }}</p>
                  <p><strong>Amount:</strong> {{ supplier.price }}</p>
                </div>
              </td>
              <td class="py-2 px-4">{{ supplier.remarks }}</td>
              <td class="py-2 px-4">
                <button @click="confirmPurchaseOrder(supplier)" class="bg-blue-500 text-white py-1 px-3 rounded-md mr-2">
                  Generate PO
                </button>
                <button  class="bg-green-800 text-white py-1 px-3 rounded-md">
                  Download PDF
                </button>
              </td>
            </tr>
          </tbody>
        </table>
        <button @click="closeQuotationModal" class="text-red-600">Close</button>
      </div>
    </div>

    <!-- Confirmation Modal -->
    <div v-if="showConfirmationModal" class="fixed inset-0 bg-gray-600 bg-opacity-75 flex items-center justify-center">
      <div class="bg-white p-6 rounded-md w-1/3">
        <h3 class="text-xl font-bold mb-4">Are you sure you want to purchase this?</h3>
        <div class="flex justify-end">
          <button @click="generatePurchaseOrder(selectedSupplier)" class="bg-blue-500 text-white py-1 px-3 rounded-md mr-2">
            Yes
          </button>
          <button @click="showConfirmationModal = false" class="text-red-600">
            No
          </button>
        </div>
      </div>
    </div>

    <!-- Success Modal -->
    <div v-if="showSuccessModal" class="fixed inset-0 bg-gray-600 bg-opacity-75 flex items-center justify-center">
      <div class="bg-white p-6 rounded-md w-1/3">
        <h3 class="text-xl font-bold mb-4">Purchase Order Successfully Generated!</h3>
        <button @click="closeSuccessModal" class="bg-blue-500 text-white py-1 px-3 rounded-md">
          Close
        </button>
      </div>
    </div>

    <!-- Pagination -->
    <div class="flex justify-between items-center mt-4">
      <button @click="prevPage" :disabled="currentPage === 1" class="bg-gray-300 px-4 py-2 rounded">Previous</button>
      <span>Page {{ currentPage }} of {{ totalPages }}</span>
      <button @click="nextPage" :disabled="currentPage === totalPages" class="bg-gray-300 px-4 py-2 rounded">Next</button>
    </div>
  </div>
</template>

<script>
import { apiService } from "~/api/apiService";
import auth from "../../../../middleware/auth";
// This page requires authentication
definePageMeta({
  middleware: [auth],
});

import { ref, computed } from "vue";
export default {
  data() {
    return {
      quotations: [
        {
          number: 'Q-1001',
          date: '2024-10-20',
          sentBy: 'Rhea',
          status: '3 suppliers quoted',
          remarks: 'Pending',
          suppliers: [
            { name: 'Supplier A', remarks: 'Lowest price', qty: '100', price: '$5000' },
            { name: 'Supplier B', remarks: 'Higher price', qty: '100', price: '$5500' },
            { name: 'Supplier C', remarks: 'Mid-range price', qty: '100', price: '$5200' },
          ],
        },
        {
          number: 'Q-1002',
          date: '2024-10-22',
          sentBy: 'Rhy',
          status: '2 suppliers quoted',
          remarks: 'Pending',
          suppliers: [
            { name: 'Supplier D', remarks: 'Lowest price', qty: '50', price: '$4000' },
            { name: 'Supplier E', remarks: 'Higher price', qty: '50', price: '$4500' },
          ],
        },
      ],
      selectedQuotation: null,
      selectedSupplier: null,
      hoveredSupplier: null,
      showConfirmationModal: false,
      showSuccessModal: false,
      searchQuery: '',
      currentPage: 1,
      itemsPerPage: 5,
    };
  },
  computed: {
    filteredQuotations() {
      return this.quotations.filter(
        (quotation) =>
          quotation.number.includes(this.searchQuery) ||
          quotation.sentBy.toLowerCase().includes(this.searchQuery.toLowerCase())
      );
    },
    paginatedQuotations() {
      const start = (this.currentPage - 1) * this.itemsPerPage;
      const end = start + this.itemsPerPage;
      return this.filteredQuotations.slice(start, end);
    },
    totalPages() {
      return Math.ceil(this.filteredQuotations.length / this.itemsPerPage);
    },
  },
  methods: {
    openQuotationModal(quotation) {
      this.selectedQuotation = quotation;
    },
    closeQuotationModal() {
      this.selectedQuotation = null;
    },
    openSupplierDetails(supplier) {
      this.hoveredSupplier = supplier;
    },
    closeSupplierDetails() {
      this.hoveredSupplier = null;
    },
    confirmPurchaseOrder(supplier) {
      this.showConfirmationModal = true;
      this.selectedSupplier = supplier;
    },
    generatePurchaseOrder(supplier) {
      this.showConfirmationModal = false;
      this.showSuccessModal = true;
      supplier.remarks = 'PO Generated';
    },
    closeSuccessModal() {
      this.showSuccessModal = false;
      this.selectedSupplier = null;
    },
    prevPage() {
      if (this.currentPage > 1) {
        this.currentPage--;
      }
    },
    nextPage() {
      if (this.currentPage < this.totalPages) {
        this.currentPage++;
      }
    },
  },
};
</script>

  
  
  <style scoped>

  .container {
    font-family: 'Arial', sans-serif;
    background-color: #f9fafb;
    padding: 50px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  }
  
  h2 {
    color: #333;
    margin-bottom: 20px;
  }
  
  table {
    width: 100%;
    border-collapse: collapse;
  }
  
  th, td {
    padding: 12px 15px;
    text-align: left;
  }
  
  th {
    background-color: #0E8BF1;
    color: white;
    text-transform: uppercase;
  }
  
  tbody tr:nth-child(even) {
    background-color: #f2f2f2;
  }
  
  /* Table Row Hover Effect */
  tbody tr:hover {
    background-color: #d1e7f7;
    cursor: pointer;
  }
  
  button {
    cursor: pointer;
    transition: all 0.3s ease-in-out;
  }
  
  /* Action Button Styles */
  button i {
    font-size: 1.2rem;
  }
  
  button:hover i {
    color: #0e76a8; /* Slight hover effect for the eye icon */
  }

  /* Quotation View Modal Styling */
.bg-white {
  background-color: white;
  max-height: 80vh; /* 80% of the viewport height */
  overflow-y: auto; /* Scrollable content */
  padding: 24px;
}

.fixed {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
  background-color: rgba(0, 0, 0, 0.75); /* Modal overlay */
}

  
  
  /* Modal Styling */
  .fixed {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
  }
  
  .bg-gray-600 {
    background-color: rgba(0, 0, 0, 0.75);
  }
  
  .bg-white {
    background-color: white;
  }
  
  .p-6 {
    padding: 24px;
  }
  
  .rounded-md {
    border-radius: 8px;
  }
  
  button {
    padding: 8px 12px;
    border-radius: 5px;
    font-weight: bold;
  }
  
  .bg-blue-500 {
    background-color: #0E8BF1;
  }
  
  .bg-blue-500:hover {
    background-color: #1069b5; /* Darker blue for hover */
  }
  
  .text-blue-600 {
    color: #0E8BF1;
  }
  
  .text-blue-600:hover {
    color: #0c6399;
  }
  
  .text-red-600 {
    color: #e3342f;
  }
  
  .text-red-600:hover {
    color: #c7281d;
  }
  
  /* Buttons Hover Effect */
  button:hover {
    transform: scale(1.05);
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
  }
  
  /* Add Responsive Table */
  @media (max-width: 768px) {
    table {
      display: block;
      width: 100%;
      overflow-x: auto;
      white-space: nowrap;
    }
  
    th, td {
      padding: 10px;
    }
  
}
  </style>
  
  