<template>
    <div class="container">
      <h2 class="text-2xl font-semibold mb-4">Purchase Orders</h2>
      <table class="table-auto w-full bg-white shadow-lg rounded-lg">
        <thead>
          <tr class="bg-gray-200">
            <th class="p-4 text-center">PO ID</th>
            <th class="p-4 text-center">Supplier</th>
            <th class="p-4 text-center">Quotation ID</th>
            <th class="p-4 text-center">Total Amount</th>
            <th class="p-4 text-center">Status</th>
            <th class="p-4 text-center">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="po in purchaseOrders" :key="po.id" class="border-t">
            <td class="p-4 text-center">{{ po.id }}</td>
            <td class="p-4 text-center">{{ po.supplier }}</td>
            <td class="p-4 text-center">{{ po.quotationId }}</td>
            <td class="p-4 text-center">{{ po.total | currency }}</td>
            <td class="p-4 text-center">
              <span :class="statusClass(po.status)" class="py-1 px-3 rounded-full text-white text-sm">
                {{ po.status }}
              </span>
            </td>
            <td class="p-4 text-center">
              <button @click="viewDetails(po)" class="text-blue-600 mr-2">
                <i class="fas fa-eye"></i> <!-- View Icon -->
              </button>
              <button @click="updateStatus(po, 'Waiting for Delivery')" class="text-yellow-600 mr-2">
                <i class="fas fa-truck"></i> <!-- Mark as Delivered Icon -->
              </button>
              <button @click="cancelPO(po)" class="text-red-600">
                <i class="fas fa-trash"></i> <!-- Cancel Icon -->
              </button>
            </td>
          </tr>
        </tbody>
      </table>
  
      <!-- Modal for Purchase Order Details -->
      <div v-if="selectedPO" class="fixed bg-gray-600 bg-opacity-75 z-50">
        <div class="bg-white p-6 rounded-md">
          <h3 class="text-lg font-bold mb-2">Purchase Order Details</h3>
          <p><strong>PO ID:</strong> {{ selectedPO.id }}</p>
          <p><strong>Supplier:</strong> {{ selectedPO.supplier }}</p>
          <p><strong>Quotation ID:</strong> {{ selectedPO.quotationId }}</p>
          <p><strong>Total Amount:</strong> {{ selectedPO.total | currency }}</p>
          <p><strong>Status:</strong> {{ selectedPO.status }}</p>
          <button @click="closeModal" class="bg-blue-500 text-white px-4 py-2 rounded-md">Close</button>
        </div>
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
        purchaseOrders: [
          { id: 'PO001', supplier: 'Supplier A', quotationId: 'Q001', total: 5000, status: 'Pending' },
          { id: 'PO002', supplier: 'Supplier B', quotationId: 'Q002', total: 7000, status: 'Waiting for Delivery' },
          // Add more POs
        ],
        selectedPO: null, // To hold selected PO for modal
      };
    },
    methods: {
      statusClass(status) {
        switch (status) {
          case 'Pending':
            return 'bg-yellow-500';
          case 'Waiting for Delivery':
            return 'bg-blue-500';
          case 'Delivered':
            return 'bg-green-500';
          case 'Cancelled':
            return 'bg-red-500';
          default:
            return 'bg-gray-500';
        }
      },
      viewDetails(po) {
        this.selectedPO = po; // Set selected PO for the modal
      },
      closeModal() {
        this.selectedPO = null; // Clear selected PO to close modal
      },
      updateStatus(po, newStatus) {
        po.status = newStatus;
        alert(`PO ID ${po.id} marked as ${newStatus}`);
      },
      cancelPO(po) {
        po.status = 'Cancelled';
        alert(`PO ID ${po.id} has been cancelled`);
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
  
  th,
  td {
    padding: 12px 15px;
    text-align: left;
  }
  
  th {
    background-color: #0e8bf1;
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
    background-color: #0e8bf1;
  }
  
  .bg-blue-500:hover {
    background-color: #1069b5; /* Darker blue for hover */
  }
  
  .text-blue-600 {
    color: #0e8bf1;
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
  
    th,
    td {
      padding: 10px;
    }
  }
  </style>
  