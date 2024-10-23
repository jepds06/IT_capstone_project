<template>
  <div class="container mx-auto py-10">
    <!-- Quotation Table -->
    <h2 class="text-2xl font-bold mb-6">Quotation Records</h2>
    <table class="min-w-full bg-white border border-gray-300">
      <thead class="bg-gray-200">
        <tr>
          <th class="py-2 px-4 text-left">Quotation No.</th>
          <th class="py-2 px-4 text-left">Date</th>
          <th class="py-2 px-4 text-left">Sent By</th>
          <th class="py-2 px-4 text-left">Status</th>
          <th class="py-2 px-4 text-left">Action</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(quotation, index) in quotations" :key="index">
          <td class="py-2 px-4">{{ quotation.number }}</td>
          <td class="py-2 px-4">{{ quotation.date }}</td>
          <td class="py-2 px-4">{{ quotation.sentBy }}</td>
          <td class="py-2 px-4">{{ quotation.status }}</td>
          <td class="py-2 px-4">
            <!-- Eye Icon for View Quotation -->
            <button @click="openQuotationModal(quotation)" class="text-blue-600">
              <i class="fas fa-eye"></i>
            </button>
          </td>
        </tr>
      </tbody>
    </table>

    <!-- Quotation View Modal -->
    <div v-if="selectedQuotation" class="fixed inset-0 bg-gray-600 bg-opacity-75 flex items-center justify-center">
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
              <td class="py-2 px-4">
                <button @click="openSupplierDetails(supplier)" class="text-blue-600 underline">
                  {{ supplier.name }}
                </button>
              </td>
              <td class="py-2 px-4">{{ supplier.remarks }}</td>
              <td class="py-2 px-4">
                <button @click="confirmPurchaseOrder(supplier)" class="bg-blue-500 text-white py-1 px-3 rounded-md">
                  Generate PO
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

    <!-- Supplier Quotation Details Modal -->
    <div v-if="selectedSupplier" class="fixed inset-0 bg-gray-600 bg-opacity-75 flex items-center justify-center">
      <div class="bg-white p-6 rounded-md w-1/3">
        <h3 class="text-xl font-bold mb-4">Supplier Quotation Details</h3>
        <p><strong>Supplier Name:</strong> {{ selectedSupplier.name }}</p>
        <p><strong>Quantity:</strong> {{ selectedSupplier.qty }}</p>
        <p><strong>Price:</strong> {{ selectedSupplier.price }}</p>
        <button @click="closeSupplierDetails" class="text-red-600">Close</button>
      </div>
    </div>

  </div>
</template>

<script>
import auth from '../../../../middleware/auth'
// This page requires authentication
definePageMeta({
middleware: [auth],
});

import { ref } from "vue";

export default {
  data() {
    return {
      quotations: [
        {
          number: 'Q-1001',
          date: '2024-10-20',
          sentBy: 'Rhea',
          status: '3 suppliers quoted',
          suppliers: [
            { name: 'Supplier A', remarks: 'Lowest price', amount: '$5000', details: 'Quotation details here' },
            { name: 'Supplier B', remarks: 'Higher price', amount: '$5500', details: 'Quotation details here' },
            { name: 'Supplier C', remarks: 'Mid-range price', amount: '$5200', details: 'Quotation details here' },
          ],
        },
        {
          number: 'Q-1002',
          date: '2024-10-22',
          sentBy: 'Rhy',
          status: '2 suppliers quoted',
          suppliers: [
            { name: 'Supplier D', remarks: 'Lowest price', amount: '$4000', details: 'Quotation details here' },
            { name: 'Supplier E', remarks: 'Higher price', amount: '$4500', details: 'Quotation details here' },
          ],
        },
      ],
      selectedQuotation: null,
      selectedSupplier: null,
      showConfirmationModal: false,
      showSuccessModal: false,
    };
  },
  methods: {
    openQuotationModal(quotation) {
      this.selectedQuotation = quotation;
    },
    closeQuotationModal() {
      this.selectedQuotation = null;
    },
    openSupplierDetails(supplier) {
      this.selectedSupplier = supplier;
    },
    closeSupplierDetails() {
      this.selectedSupplier = null;
    },
    confirmPurchaseOrder(supplier) {
      this.showConfirmationModal = true; // Show confirmation modal
    },
    generatePurchaseOrder(supplier) {
      this.showConfirmationModal = false; // Hide confirmation modal
      this.showSuccessModal = true; // Show success modal
      // Here you can add your logic to generate the purchase order
      console.log(`Purchase order generated for ${supplier.name}`);
    },
    closeSuccessModal() {
      this.showSuccessModal = false; // Hide success modal
      this.selectedSupplier = null; // Reset selected supplier
    },
  },
};
</script>


<style scoped>

.container {
  font-family: 'Arial', sans-serif;
  background-color: #f9fafb;
  padding: 20px;
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

