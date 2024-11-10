<template>
    <div class="m-8">
      <!-- Title -->
      <h1 class="text-3xl font-semibold mb-4">Manage Payments</h1>
  
      <!-- Search Bar -->
      <div class="mb-4 flex gap-2">
        <input
          type="text"
          v-model="searchQuery"
          placeholder="Search by Payment ID or Customer Name"
          class="px-4 py-2 w-1/3 rounded border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500"
        />
      </div>
  
      <!-- Payment Table -->
      <div class="overflow-x-auto">
          <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow overflow-hidden">
            <thead class="bg-blue-600 text-white uppercase tracking-wide text-sm">
              <tr>
                <th class="py-3 px-4 text-left">Payment ID</th>
                <th class="py-3 px-4 text-left">Customer Name</th>
                <th class="py-3 px-4 text-left">Amount</th>
                <th class="py-3 px-4 text-left">Payment Method</th>
                <th class="py-3 px-4 text-left">Status</th>
                <th class="py-3 px-4 text-left">Actions</th>
              </tr>
            </thead>
          <tbody>
            <tr
              v-for="payment in filteredPayments"
              :key="payment.paymentID"
              class="border-b hover:bg-gray-100"
            >
              <td class="px-6 py-3">{{ payment.paymentID }}</td>
              <td class="px-6 py-3">{{ payment.customerName }}</td>
              <td class="px-6 py-3">{{ payment.amount }}</td>
              <td class="px-6 py-3">{{ payment.paymentMethod }}</td>
              <td class="px-6 py-3">
                <span
                  :class="{
                    'text-green-500': payment.status === 'Completed',
                    'text-yellow-500': payment.status === 'Pending',
                    'text-red-500': payment.status === 'Failed'
                  }"
                >
                  <i
                    :class="{
                      'fa-solid fa-check-circle': payment.status === 'Completed',
                      'fa-solid fa-hourglass-half': payment.status === 'Pending',
                      'fa-solid fa-times-circle': payment.status === 'Failed'
                    }"
                  ></i>
                </span>
              </td>
              <td class="px-6 py-3 flex gap-3">
                <!-- View and Edit Button Icons -->
                <button @click="openModal('view', payment.paymentID)" class="text-blue-500 hover:text-blue-700">
                  <i class="fa-solid fa-eye"></i>
                </button>
                <button @click="openModal('edit', payment.paymentID)" class="text-yellow-500 hover:text-yellow-700">
                  <i class="fa-solid fa-edit"></i>
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
  
      <!-- Pagination -->
      <div class="flex justify-between items-center mt-4">
        <span class="text-sm text-gray-500">Showing {{ start + 1 }} to {{ end }} of {{ payments.length }} payments</span>
        <div class="flex gap-4">
          <button
            :disabled="page === 1"
            @click="page--"
            class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300 disabled:opacity-50"
          >
            Previous
          </button>
          <button
            :disabled="page * itemsPerPage >= payments.length"
            @click="page++"
            class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300 disabled:opacity-50"
          >
            Next
          </button>
        </div>
      </div>
  
      <!-- Success Popup after Deletion -->
      <div
        v-if="showDeleteNotification"
        class="fixed bottom-10 right-10 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg transition-opacity duration-300"
      >
        <p>{{ deleteMessage }}</p>
      </div>
  
      <!-- View Modal -->
      <div v-if="modalType === 'view'" class="fixed inset-0 flex justify-center items-center bg-black bg-opacity-50">
        <div class="bg-white p-6 rounded-lg w-1/3">
          <h3 class="text-xl font-semibold mb-4">View Payment Details</h3>
          <p><strong>Payment ID:</strong> {{ currentPayment.paymentID }}</p>
          <p><strong>Customer Name:</strong> {{ currentPayment.customerName }}</p>
          <p><strong>Amount:</strong> {{ currentPayment.amount }}</p>
          <p><strong>Payment Method:</strong> {{ currentPayment.paymentMethod }}</p>
          <p><strong>Status:</strong> <span :class="statusClass(currentPayment.status)">{{ currentPayment.status }}</span></p>
          <button @click="closeModal" class="mt-4 px-4 py-2 bg-red-500 text-white rounded">Close</button>
        </div>
      </div>
  
      <!-- Edit Modal -->
      <div v-if="modalType === 'edit'" class="fixed inset-0 flex justify-center items-center bg-black bg-opacity-50">
        <div class="bg-white p-6 rounded-lg w-1/3">
          <h3 class="text-xl font-semibold mb-4">Edit Payment</h3>
          <input v-model="currentPayment.amount" class="mb-4 p-2 w-full border border-gray-300 rounded" placeholder="Amount" />
          <select v-model="currentPayment.status" class="mb-4 p-2 w-full border border-gray-300 rounded">
            <option value="Completed">Completed</option>
            <option value="Pending">Pending</option>
            <option value="Failed">Failed</option>
          </select>
          <button @click="saveEdit" class="mr-2 px-4 py-2 bg-yellow-500 text-white rounded">Save</button>
          <button @click="closeModal" class="px-4 py-2 bg-red-500 text-white rounded">Cancel</button>
        </div>
      </div>
    </div>
  </template>
  
  <script setup>
import auth from '../../../../middleware/auth'
// This page requires authentication
definePageMeta({
  middleware: [auth],
});
  import { ref, computed } from "vue";
  
  const payments = ref([
    {
      paymentID: 1,
      customerName: "Rhea",
      amount: "₱5000",
      paymentMethod: "Cash",
      status: "Completed",
    }
    // Add more payment records as necessary
  ]);
  
  const searchQuery = ref("");
  const page = ref(1);
  const itemsPerPage = 5;
  const showDeleteNotification = ref(false);
  const deleteMessage = ref("");
  const modalType = ref(null);
  const currentPayment = ref({});
  
  const filteredPayments = computed(() => {
    return payments.value.filter(
      (payment) =>
        payment.paymentID.toString().includes(searchQuery.value) ||
        payment.customerName.toLowerCase().includes(searchQuery.value.toLowerCase())
    );
  });
  
  const start = computed(() => (page.value - 1) * itemsPerPage);
  const end = computed(() => Math.min(page.value * itemsPerPage, payments.value.length));
  
  const openModal = (type, paymentID) => {
    const payment = payments.value.find(payment => payment.paymentID === paymentID);
    currentPayment.value = { ...payment }; // Create a copy to avoid modifying original data
    modalType.value = type;
  };
  
  const closeModal = () => {
    modalType.value = null;
  };
  
  const statusClass = (status) => {
    return {
      'text-green-500': status === 'Completed',
      'text-yellow-500': status === 'Pending',
      'text-red-500': status === 'Failed',
    };
  };
  
  const saveEdit = () => {
    const index = payments.value.findIndex(payment => payment.paymentID === currentPayment.value.paymentID);
    if (index !== -1) {
      payments.value[index] = { ...currentPayment.value };
      closeModal();
    }
  };
  
  const deletePayment = (paymentID) => {
    const index = payments.value.findIndex((payment) => payment.paymentID === paymentID);
    if (index !== -1) {
      payments.value.splice(index, 1);
      showDeleteNotification.value = true;
      deleteMessage.value = `Payment ID ${paymentID} successfully deleted!`;
  
      setTimeout(() => {
        showDeleteNotification.value = false;
      }, 3000);
    }
  };
  </script>
  
  <style scoped>
  ::-webkit-scrollbar {
    height: 8px;
  }
  ::-webkit-scrollbar-thumb {
    background-color: #6b7280;
    border-radius: 8px;
  }
  </style>
  