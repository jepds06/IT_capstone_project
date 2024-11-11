\<template>
    <div class="p-8 bg-gray-50 min-h-screen">
      <!-- Header and Search -->
      <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-semibold text-gray-800">Customer Orders</h1>
        <input
          type="text"
          v-model="searchQuery"
          placeholder="Search orders..."
          class="border border-gray-300 rounded-full px-4 py-2 w-1/3 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400"
        />
      </div>
  
      <!-- Orders Table -->
      <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full text-left">
            <thead class="bg-blue-600 text-white uppercase tracking-wide text-sm">
            <tr>
              <th class="py-3 px-4 text-left">Order ID</th>
              <th class="py-3 px-4 text-left">Customer</th>
              <th class="py-3 px-4 text-left">Date</th>
              <th class="py-3 px-4 text-left">Status</th>
              <th class="py-3 px-4 text-left">Total</th>
              <th class="py-3 px-4 text-left">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="(order, index) in filteredOrders"
              :key="index"
              class="bg-white border-b hover:bg-gray-100 transition duration-150 ease-in-out"
            >
              <td class="px-6 py-4">{{ order.id }}</td>
              <td class="px-6 py-4">{{ order.customer }}</td>
              <td class="px-6 py-4">{{ order.date }}</td>
              <td :class="getStatusClass(order.status)" class="px-6 py-4 font-semibold">
                {{ order.status }}
              </td>
              <td class="px-6 py-4">${{ order.total.toFixed(2) }}</td>
              <td class="px-6 py-4 flex items-center space-x-3">
                <button class="text-blue-500 hover:text-blue-700" @click="viewOrder(order)">
                  <i class="fas fa-eye"></i>
                </button>
                <button class="text-green-500 hover:text-green-700" @click="editOrder(order)">
                  <i class="fas fa-edit"></i>
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
  
      <!-- View Modal -->
      <div v-if="showViewModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-8 w-1/2 shadow-lg transform transition-all">
          <h2 class="text-xl font-bold mb-4">Order Details - {{ selectedOrder.id }}</h2>
          <p><strong>Customer:</strong> {{ selectedOrder.customer }}</p>
          <p><strong>Date:</strong> {{ selectedOrder.date }}</p>
          <p><strong>Status:</strong> {{ selectedOrder.status }}</p>
          <p><strong>Total:</strong> ${{ selectedOrder.total.toFixed(2) }}</p>
          <button class="mt-6 bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600" @click="showViewModal = false">
            Close
          </button>
        </div>
      </div>
  
      <!-- Edit Modal -->
      <div v-if="showEditModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-8 w-1/2 shadow-lg transform transition-all">
          <h2 class="text-xl font-bold mb-4">Edit Order - {{ selectedOrder.id }}</h2>
          <form @submit.prevent="updateOrder">
            <div class="mb-4">
              <label class="block text-gray-700 font-semibold mb-2">Status</label>
              <select v-model="selectedOrder.status" class="border border-gray-300 p-3 rounded-lg w-full focus:ring-2 focus:ring-blue-400">
                <option>Pending</option>
                <option>Shipped</option>
                <option>Completed</option>
              </select>
            </div>
            <div class="flex justify-end">
              <button type="button" class="mr-4 bg-gray-300 px-4 py-2 rounded-lg hover:bg-gray-400" @click="showEditModal = false">
                Cancel
              </button>
              <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600">
                Save Changes
              </button>
            </div>
          </form>
        </div>
      </div>
      <!-- Pagination Controls -->
    <div class="flex justify-center mt-4 space-x-2">
      <button
        @click="currentPage--"
        :disabled="currentPage === 1"
        class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400 disabled:opacity-50"
      >
        Previous
      </button>
      <span class="px-4 py-2">Page {{ currentPage }} of {{ totalPages }}</span>
      <button
        @click="currentPage++"
        :disabled="currentPage === totalPages"
        class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400 disabled:opacity-50"
      >
        Next
      </button>
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

const searchQuery = ref("");
const orders = ref([
  { id: "001", customer: "r", date: "2023-10-01", status: "Pending", total: 150.5 },
  { id: "002", customer: "h", date: "2023-10-02", status: "Completed", total: 200.0 },
  { id: "003", customer: "e", date: "2023-10-03", status: "Shipped", total: 300.25 },
  { id: "004", customer: "a", date: "2023-10-04", status: "Pending", total: 175.75 },
  // pagination testing lang
]);

const showViewModal = ref(false);
const showEditModal = ref(false);
const selectedOrder = ref(null);

const itemsPerPage = ref(5); 
const currentPage = ref(1);

const filteredOrders = computed(() =>
  orders.value.filter(
    (order) =>
      order.customer.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
      order.id.includes(searchQuery.value)
  )
);

// Compute paginated orders based on current page and items per page
const paginatedOrders = computed(() => {
  const start = (currentPage.value - 1) * itemsPerPage.value;
  return filteredOrders.value.slice(start, start + itemsPerPage.value);
});

const totalPages = computed(() => Math.ceil(filteredOrders.value.length / itemsPerPage.value));

const getStatusClass = (status) => {
  switch (status) {
    case "Pending":
      return "text-yellow-600";
    case "Completed":
      return "text-green-600";
    case "Shipped":
      return "text-blue-600";
    default:
      return "text-gray-600";
  }
};

const viewOrder = (order) => {
  selectedOrder.value = order;
  showViewModal.value = true;
};

const editOrder = (order) => {
  selectedOrder.value = { ...order };
  showEditModal.value = true;
};

const updateOrder = () => {
  const orderIndex = orders.value.findIndex((o) => o.id === selectedOrder.value.id);
  if (orderIndex !== -1) {
    orders.value[orderIndex] = { ...selectedOrder.value };
  }
  showEditModal.value = false;
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
  </style>
  