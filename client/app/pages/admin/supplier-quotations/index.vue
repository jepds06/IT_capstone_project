<template>
    <div class="p-8">
      <!-- Page Header -->
      <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Supplier Quotations</h1>
      </div>
  
      <!-- Filters -->
      <div class="flex justify-between items-center mb-4">
        <input
          type="text"
          placeholder="Search quotations..."
          class="w-1/3 p-3 border rounded"
          v-model="searchQuery"
        />
        <select v-model="statusFilter" class="p-3 border rounded w-1/4">
          <option value="">All Status</option>
          <option value="Pending">Pending</option>
          <option value="Approved">Approved</option>
          <option value="Rejected">Rejected</option>
        </select>
        <input
          type="date"
          v-model="dateFilter"
          class="p-3 border rounded w-1/4"
        />
      </div>
  
      <!-- Supplier Quotations Table -->
      <div class="overflow-x-auto">
        <table class="table-auto w-full bg-white rounded shadow">
          <thead>
            <tr class="bg-gray-100 text-left text-gray-600">
              <th class="p-4">Quotation No</th>
              <th class="p-4">Supplier Name</th>
              <th class="p-4">Supplier ID</th>
              <th class="p-4">Status</th>
              <th class="p-4">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="quotation in filteredQuotations"
              :key="quotation.id"
              class="border-b"
            >
              <td class="p-4">{{ quotation.quotationNo }}</td>
              <td class="p-4">{{ quotation.supplierName }}</td>
              <td class="p-4">{{ quotation.supplierId }}</td>
              <td class="p-4">
                <span v-if="quotation.status === 'Pending'" class="text-yellow-500"> Pending</span>
                <span v-if="quotation.status === 'Approved'" class="text-green-500"> Approved</span>
                <span v-if="quotation.status === 'Rejected'" class="text-red-500"> Rejected</span>
              </td>
              <td class="p-4 flex space-x-4">
                <button @click="openDetailsModal(quotation)" class="text-blue-500 hover:underline">View Details</button>
                <button
                  v-if="quotation.status === 'Pending'"
                  @click="openPurchaseOrderModal(quotation)"
                  class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600"
                >
                  Purchase
                </button>
                <button
                  v-if="quotation.status === 'Pending'"
                  @click="openRejectConfirmationModal(quotation)"
                  class="text-red-500 hover:underline"
                  title="Reject Quotation"
                >
                  <i class="fas fa-trash"></i>
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
  
      <!-- Pagination -->
      <div class="flex justify-between items-center mt-6">
        <span class="text-gray-600">Showing 1-10 of {{ totalQuotations }}</span>
        <div class="flex space-x-2">
          <button class="bg-gray-300 text-gray-700 px-3 py-1 rounded">Previous</button>
          <button class="bg-blue-500 text-white px-3 py-1 rounded">Next</button>
        </div>
      </div>
  
      <!-- Quotation Details Modal -->
      <div v-if="showDetailsModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white p-6 rounded-lg shadow-lg w-2/3">
          <h2 class="text-xl font-bold mb-4">Quotation Details</h2>
          <table class="table-auto w-full">
            <thead>
              <tr class="bg-gray-100 text-left text-gray-600">
                <th class="p-2">Material ID</th>
                <th class="p-2">Quantity</th>
                <th class="p-2">Price</th>
                <th class="p-2">Total Price</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="item in selectedQuotation.items" :key="item.id">
                <td class="p-2">{{ item.materialId }}</td>
                <td class="p-2">{{ item.quantity }}</td>
                <td class="p-2">{{ item.price }}</td>
                <td class="p-2">{{ item.totalPrice }}</td>
              </tr>
            </tbody>
          </table>
          <div class="mt-6 flex justify-end space-x-4">
            <button @click="closeDetailsModal" class="bg-red-500 text-white px-4 py-2 rounded">Close</button>
            <button @click="downloadQuotation(selectedQuotation)" class="bg-blue-500 text-white px-4 py-2 rounded">Download PDF</button>
          </div>
        </div>
      </div>
  
      <!-- Purchase Order Modal -->
      <div v-if="showPurchaseOrderModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white p-6 rounded-lg shadow-lg w-1/2">
          <h2 class="text-xl font-bold mb-4">Purchase Order</h2>
          <p>Please confirm the purchase order for {{ selectedQuotation ? selectedQuotation.quotationNo : '' }}.</p>
          <div class="mt-6 flex justify-end space-x-4">
            <button @click="closePurchaseOrderModal" class="bg-red-500 text-white px-4 py-2 rounded">Cancel</button>
            <button @click="confirmPurchaseOrder" class="bg-green-500 text-white px-4 py-2 rounded">Confirm</button>
          </div>
        </div>
      </div>
  
      <!-- Reject Quotation Confirmation Modal -->
      <div v-if="showRejectConfirmationModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white p-6 rounded-lg shadow-lg w-1/2">
          <h2 class="text-xl font-bold mb-4">Confirm Rejection</h2>
          <p>Are you sure you want to reject quotation {{ selectedQuotation ? selectedQuotation.quotationNo : '' }}?</p>
          <div class="mt-6 flex justify-end space-x-4">
            <button @click="closeRejectConfirmationModal" class="bg-red-500 text-white px-4 py-2 rounded">Cancel</button>
            <button @click="rejectQuotation" class="bg-green-500 text-white px-4 py-2 rounded">Reject</button>
          </div>
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
  
  import { jsPDF } from 'jspdf';
  
  export default {
    data() {
      return {
        quotations: [
          {
            id: '1',
            quotationNo: 'Q-001',
            supplierName: 'Supplier 1',
            supplierId: 'SUP-123',
            status: 'Pending', // Initial status is Pending
            date: '2024-09-01',
            items: [
              { materialId: 'MAT-001', quantity: 10, price: '$100', totalPrice: '$1000' },
              { materialId: 'MAT-002', quantity: 5, price: '$200', totalPrice: '$1000' },
            ],
          },
          {
            id: '2',
            quotationNo: 'Q-002',
            supplierName: 'Supplier 2',
            supplierId: 'SUP-456',
            status: 'Pending', // Initial status is also Pending
            date: '2024-09-05',
            items: [
              { materialId: 'MAT-003', quantity: 15, price: '$150', totalPrice: '$2250' },
            ],
          },
        ],
        totalQuotations: 2,
        showDetailsModal: false,
        selectedQuotation: null,
        showPurchaseOrderModal: false,
        showRejectConfirmationModal: false,
        searchQuery: '',
        statusFilter: '',
        dateFilter: '',
      };
    },
    computed: {
      filteredQuotations() {
        return this.quotations.filter((quotation) => {
          const matchesSearch = quotation.quotationNo.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
            quotation.supplierName.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
            quotation.supplierId.toLowerCase().includes(this.searchQuery.toLowerCase());
  
          const matchesStatus = this.statusFilter ? quotation.status === this.statusFilter : true;
  
          const matchesDate = this.dateFilter ? quotation.date === this.dateFilter : true;
  
          return matchesSearch && matchesStatus && matchesDate;
        });
      },
    },
    methods: {
      openDetailsModal(quotation) {
        this.selectedQuotation = quotation;
        this.showDetailsModal = true;
      },
      closeDetailsModal() {
        this.showDetailsModal = false;
      },
      openPurchaseOrderModal(quotation) {
        this.selectedQuotation = quotation;
        this.showPurchaseOrderModal = true;
      },
      closePurchaseOrderModal() {
        this.showPurchaseOrderModal = false;
      },
      confirmPurchaseOrder() {
        // Update the status to Approved when confirmed
        this.selectedQuotation.status = 'Approved';
        this.closePurchaseOrderModal();
      },
      openRejectConfirmationModal(quotation) {
        this.selectedQuotation = quotation;
        this.showRejectConfirmationModal = true;
      },
      closeRejectConfirmationModal() {
        this.showRejectConfirmationModal = false;
      },
      rejectQuotation() {
        // Update the status to Rejected when rejected
        this.selectedQuotation.status = 'Rejected';
        this.closeRejectConfirmationModal();
      },
      downloadQuotation(quotation) {
        const doc = new jsPDF();
        doc.text(`Quotation No: ${quotation.quotationNo}`, 10, 10);
        doc.text(`Supplier Name: ${quotation.supplierName}`, 10, 20);
        doc.text(`Supplier ID: ${quotation.supplierId}`, 10, 30);
        doc.text(`Status: ${quotation.status}`, 10, 40);
        doc.text('Items:', 10, 50);
        quotation.items.forEach((item, index) => {
          const yPosition = 60 + index * 10;
          doc.text(`Material ID: ${item.materialId}, Quantity: ${item.quantity}, Price: ${item.price}, Total Price: ${item.totalPrice}`, 10, yPosition);
        });
        doc.save(`quotation_${quotation.quotationNo}.pdf`);
      },
    },
  };
  </script>
  
  
  <style scoped>
  .table-auto {
    border-collapse: collapse;
  }
  .table-auto th,
  .table-auto td {
    border: 1px solid #ddd;
  }
  </style>
  