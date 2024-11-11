<template>
    <div class="p-8">
      <!-- Page Title -->
      <h1 class="text-2xl font-extrabold text-gray-800 mb-6">Inventory List</h1>
  
      <!-- Success Message -->
      <div v-if="showDeleteMessage" class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg">
        Item deleted successfully!
      </div>
  
      <!-- Search and Filter Section -->
      <div class="flex justify-between items-center mb-4">
        <input
          v-model="searchTerm"
          type="text"
          placeholder="Search by item name or SKU..."
          class="px-4 py-2 w-64 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
        />
  
        <select
          v-model="selectedCategory"
          class="px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
        >
          <option value="">All Categories</option>
          <option value="Wood">Wood</option>
          <option value="Fabric">Fabric</option>
          <option value="Accessories">Accessories</option>
        </select>
      </div>
  
      <!-- Inventory Table with Scrollbar and Pagination -->
      <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow overflow-hidden">
          <thead class="bg-gray-500 text-white uppercase tracking-wide text-sm">
            <tr>
              <th class="py-3 px-4 text-left">Item Name</th>
              <th class="py-3 px-4 text-left">SKU</th>
              <th class="py-3 px-4 text-left">Category</th>
              <th class="py-3 px-4 text-left">Stock Quantity</th>
              <th class="py-3 px-4 text-left">Reorder Level</th>
              <th class="py-3 px-4 text-left">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="item in paginatedItems"
              :key="item.sku"
              class="border-t transition-colors duration-300 hover:bg-gray-100 even:bg-gray-50"
            >
              <td class="py-3 px-4">{{ item.name }}</td>
              <td class="py-3 px-4">{{ item.sku }}</td>
              <td class="py-3 px-4">{{ item.category }}</td>
              <td class="py-3 px-4">{{ item.stock }}</td>
              <td :class="{'text-red-500 font-semibold': item.stock <= item.reorderLevel}" class="py-3 px-4">
                {{ item.reorderLevel }}
              </td>
              <td class="py-3 px-4">
                <button @click="openEditModal(item)" class="text-yellow-500 hover:text-yellow-600">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M6 18V6h8l6 6v8H6z" />
                  </svg>
                </button>
                <button @click="deleteItem(item)" class="text-red-500 hover:text-red-600 ml-3">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                  </svg>
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
  
      <!-- Pagination Controls -->
      <div class="flex justify-center items-center mt-4 space-x-2">
        <button
          @click="prevPage"
          :disabled="currentPage === 1"
          class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 disabled:bg-gray-100"
        >
          Previous
        </button>
        <span class="text-gray-700">Page {{ currentPage }} of {{ totalPages }}</span>
        <button
          @click="nextPage"
          :disabled="currentPage === totalPages"
          class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 disabled:bg-gray-100"
        >
          Next
        </button>
      </div>
  
      <!-- Edit Modal -->
      <div v-if="isEditModalOpen" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
        <div class="bg-white rounded-lg p-6 w-96 shadow-lg">
          <h2 class="text-xl font-bold text-gray-800 mb-4">Edit Item</h2>
          <label class="block text-gray-700 mb-2">Item Name:</label>
          <input v-model="editItemData.name" type="text" class="w-full px-4 py-2 border rounded-lg mb-4" />
          <label class="block text-gray-700 mb-2">Stock Quantity:</label>
          <input v-model="editItemData.stock" type="number" class="w-full px-4 py-2 border rounded-lg mb-4" />
          <div class="flex justify-end space-x-2">
            <button @click="closeEditModal" class="px-4 py-2 bg-gray-200 rounded-lg">Cancel</button>
            <button @click="saveEdit" class="px-4 py-2 bg-blue-500 text-white rounded-lg">Save</button>
          </div>
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
  import { ref, computed } from 'vue';
  
  // Sample inventory items
  const inventoryItems = ref([
    { name: 'Wooden Chair', sku: 'WC123', category: 'Wood', stock: 12, reorderLevel: 5 },
  ]);
  
  const searchTerm = ref('');
  const selectedCategory = ref('');
  const itemsPerPage = ref(5);
  const currentPage = ref(1);
  
  const filteredItems = computed(() => {
    return inventoryItems.value.filter((item) => {
      const matchesSearch =
        item.name.toLowerCase().includes(searchTerm.value.toLowerCase()) ||
        item.sku.toLowerCase().includes(searchTerm.value.toLowerCase());
      const matchesCategory = selectedCategory.value
        ? item.category === selectedCategory.value
        : true;
      return matchesSearch && matchesCategory;
    });
  });
  
  const paginatedItems = computed(() => {
    const start = (currentPage.value - 1) * itemsPerPage.value;
    const end = start + itemsPerPage.value;
    return filteredItems.value.slice(start, end);
  });
  const totalPages = computed(() => Math.ceil(filteredItems.value.length / itemsPerPage.value));
  
  const prevPage = () => {
    if (currentPage.value > 1) currentPage.value--;
  };
  const nextPage = () => {
    if (currentPage.value < totalPages.value) currentPage.value++;
  };
  
  // Modal and success message state
  const isEditModalOpen = ref(false);
  const editItemData = ref({});
  const showDeleteMessage = ref(false);
  
  // Open and close modal for editing
  const openEditModal = (item) => {
    editItemData.value = { ...item };
    isEditModalOpen.value = true;
  };
  const closeEditModal = () => {
    isEditModalOpen.value = false;
  };
  
  // Save changes in modal
  const saveEdit = () => {
    const index = inventoryItems.value.findIndex((i) => i.sku === editItemData.value.sku);
    if (index !== -1) {
      inventoryItems.value[index] = { ...editItemData.value };
    }
    closeEditModal();
  };
  
  // Delete item and show success message
  const deleteItem = (item) => {
    if (confirm(`Are you sure you want to delete ${item.name}?`)) {
      inventoryItems.value = inventoryItems.value.filter((i) => i.sku !== item.sku);
      showDeleteMessage.value = true;
      setTimeout(() => (showDeleteMessage.value = false), 3000);
    }
  };
  </script>
  
  <style scoped>
  /* Customize scrollbar for table overflow */
  ::-webkit-scrollbar {
    height: 8px;
  }
  ::-webkit-scrollbar-thumb {
    background-color: #6b7280;
    border-radius: 8px;
  }
  </style>
  