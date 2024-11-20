<script setup lang="ts">
import { ref } from 'vue';

// Modal states
const showModal = ref(false); // Modal visibility
const selectedOrder = ref(null); // Selected order for modal details

// Sample data
const orders = ref([
  {
    id: 'ORD001',
    date: '2024-11-10',
    status: 'To Be Received',
    paymentHistory: [
      { date: '2024-11-01', amount: '500.00' },
      { date: '2024-11-05', amount: '200.00' },
    ],
    currentPayment: '200.00',
    balance: '300.00',
    totalAmount: '1000.00',
  },
  {
    id: 'ORD002',
    date: '2024-11-11',
    status: 'Completed',
    paymentHistory: [
      { date: '2024-11-06', amount: '1000.00' },
    ],
    currentPayment: '0.00',
    balance: '0.00',
    totalAmount: '1000.00',
  },
]);

// Open modal for selected order
const openModal = (order) => {
  selectedOrder.value = order;
  showModal.value = true;
};

// Close modal
const closeModal = () => {
  showModal.value = false;
  selectedOrder.value = null;
};
</script>

<template>
  <div class="p-6 bg-gray-100 min-h-screen">
    <!-- Orders Table -->
    <div class="bg-white rounded-lg shadow p-4">
      <table class="w-full text-left">
        <thead>
          <tr>
            <th class="py-2 px-4">Order ID</th>
            <th class="py-2 px-4">Order Date</th>
            <th class="py-2 px-4">Status</th>
            <th class="py-2 px-4 text-center">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="order in orders" :key="order.id" class="border-t">
            <td class="py-2 px-4">{{ order.id }}</td>
            <td class="py-2 px-4">{{ order.date }}</td>
            <td class="py-2 px-4">{{ order.status }}</td>
            <td class="py-2 px-4 text-center">
              <button @click="openModal(order)" class="text-blue-500 hover:text-blue-700">
                <i class="fas fa-eye"></i> <!-- View Icon -->
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Modal -->
    <div
      v-if="showModal"
      class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
    >
      <div class="bg-white rounded-lg shadow-lg w-3/4 max-w-lg relative">
        <!-- Modal Header -->
        <div class="flex justify-between items-center p-4 border-b">
          <h2 class="text-lg font-bold">Order Details: {{ selectedOrder?.id }}</h2>
          <button @click="closeModal" class="text-gray-500 hover:text-gray-700">
            <i class="fas fa-times"></i>
          </button>
        </div>

        <!-- Modal Content -->
        <div class="p-4 max-h-96 overflow-y-auto">
          <!-- Payment History -->
          <h3 class="text-md font-semibold mb-2">Payment History</h3>
          <div class="overflow-x-auto">
            <table class="w-full table-auto">
              <thead>
                <tr>
                  <th class="py-2 px-4 text-left">Date</th>
                  <th class="py-2 px-4 text-left">Amount</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="payment in selectedOrder?.paymentHistory" :key="payment.date">
                  <td class="py-2 px-4">{{ payment.date }}</td>
                  <td class="py-2 px-4">₱{{ payment.amount }}</td>
                </tr>
              </tbody>
            </table>
          </div>

          <!-- Current Payment -->
          <h3 class="text-md font-semibold mt-4 mb-2">Current Payment</h3>
          <p class="mb-4">₱{{ selectedOrder?.currentPayment }}</p>

          <!-- Balance -->
          <h3 class="text-md font-semibold mt-4 mb-2">Balance</h3>
          <p class="mb-4">₱{{ selectedOrder?.balance }}</p>

          <!-- Total Amount -->
          <h3 class="text-md font-semibold mt-4 mb-2">Total Amount</h3>
          <p>₱{{ selectedOrder?.totalAmount }}</p>
        </div>
      </div>
    </div>
  </div>
</template>

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

tr:hover {
  background-color: #e3f2fd;
}

button {
  cursor: pointer;
}

button:hover {
  opacity: 0.9;
}

input[type='text'],
input[type='date'],
select {
  width: 50%;
}

.modal-table th,
.modal-table td {
  border: 1px solid #ddd;
}

.modal-table th {
  background-color: #f3f4f6;
}

.modal-table tr:nth-child(even) {
  background-color: #f9fafb;
}
</style>
