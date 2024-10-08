<template>
    <div class="p-4">
      <h2 class="text-2xl font-semibold mb-4">View Customers</h2>
  
      <!-- Search Bar -->
      <input
        type="text"
        v-model="searchQuery"
        placeholder="Search Customers"
        class="border rounded-md p-2 mb-4 w-full"
      />
  
      <div class="space-y-4">
        <div
          v-for="customer in paginatedCustomers"
          :key="customer.id"
          @click="handleCustomerClick(customer.id)"
          class="border rounded-md p-4 bg-white shadow-md cursor-pointer hover:bg-gray-100 transition"
        >
          <div class="flex justify-between items-center">
            <div>
              <h3 class="text-lg font-semibold text-blue-500 underline">
                {{ customer.name }}
              </h3>
              <p class="text-gray-600">{{ customer.email }}</p>
            </div>
            <button
              @click.stop="toggleDetails(customer.id)"
              class="text-blue-500 hover:underline"
            >
              {{ isOpen(customer.id) ? 'Hide Details' : 'Show Details' }}
            </button>
          </div>
  
          <div v-if="isOpen(customer.id)" class="mt-4">
            <p><strong>Contact Person:</strong> {{ customer.contactPerson }}</p>
            <p><strong>Phone:</strong> {{ customer.phone }}</p>
            <p><strong>Status:</strong>
              <span
                class="ml-2"
                :class="customer.status === 'Active' ? 'text-green-500' : 'text-red-500'"
              >
                {{ customer.status === 'Active' ? '✔️ Active' : '❌ Inactive' }}
              </span>
            </p>
          </div>
        </div>
      </div>
  
      <!-- Pagination -->
      <div class="flex justify-between mt-4">
        <button
          @click="prevPage"
          :disabled="currentPage === 1"
          class="border rounded-md px-4 py-2 bg-blue-500 text-white hover:bg-blue-600 disabled:bg-gray-300"
        >
          Previous
        </button>
        <span>Page {{ currentPage }} of {{ totalPages }}</span>
        <button
          @click="nextPage"
          :disabled="currentPage === totalPages"
          class="border rounded-md px-4 py-2 bg-blue-500 text-white hover:bg-blue-600 disabled:bg-gray-300"
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
  import { ref, computed } from 'vue';
  
  const customers = ref([
    { id: 1, name: 'John Doe', email: 'john@example.com', contactPerson: 'John', phone: '123-456-7890', status: 'Active' },
    { id: 2, name: 'Jane Smith', email: 'jane@example.com', contactPerson: 'Jane', phone: '098-765-4321', status: 'Inactive' },
    { id: 3, name: 'Alice Johnson', email: 'alice@example.com', contactPerson: 'Alice', phone: '555-123-4567', status: 'Active' },
    { id: 4, name: 'Bob Brown', email: 'bob@example.com', contactPerson: 'Bob', phone: '444-555-6666', status: 'Inactive' },
    { id: 5, name: 'Carol White', email: 'carol@example.com', contactPerson: 'Carol', phone: '333-444-5555', status: 'Active' },
    { id: 6, name: 'David Green', email: 'david@example.com', contactPerson: 'David', phone: '222-333-4444', status: 'Active' },
    // Add more customers as needed for testing
  ]);
  
  const openDetails = ref(new Set());
  const searchQuery = ref('');
  const currentPage = ref(1);
  const pageSize = 2; // Adjust the number of items per page
  const totalPages = computed(() => Math.ceil(filteredCustomers.value.length / pageSize));
  
  const toggleDetails = (id) => {
    if (openDetails.value.has(id)) {
      openDetails.value.delete(id);
    } else {
      openDetails.value.add(id);
    }
  };
  
  const isOpen = (id) => openDetails.value.has(id);
  
  // Filter customers based on search query
  const filteredCustomers = computed(() => {
    return customers.value.filter(customer => 
      customer.name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
      customer.email.toLowerCase().includes(searchQuery.value.toLowerCase())
    );
  });
  
  // Paginated customers based on current page
  const paginatedCustomers = computed(() => {
    const start = (currentPage.value - 1) * pageSize;
    return filteredCustomers.value.slice(start, start + pageSize);
  });
  
  // Pagination functions
  const prevPage = () => {
    if (currentPage.value > 1) {
      currentPage.value--;
    }
  };
  
  const nextPage = () => {
    if (currentPage.value < totalPages.value) {
      currentPage.value++;
    }
  };
  
  const handleCustomerClick = (id) => {
    console.log(`Customer ${id} clicked`);
    // Perform any logic here, such as navigating to a customer details page
  };
  </script>
  
  <style scoped>
  
  </style>
  