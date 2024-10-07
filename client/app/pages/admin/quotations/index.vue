<template>
  <div class="p-6">
    <h2 class="text-2xl font-bold mb-4">Quotations</h2>

    <div class="flex justify-between mb-4">
      <input
        type="text"
        v-model="searchQuery"
        placeholder="Search..."
        class="w-1/3 p-2 border rounded-lg"
      />
      <div class="flex space-x-2">
        <button @click="openAddModal" class="p-2 bg-blue-500 text-white rounded hover:bg-blue-600" title="Add Quotation">
          <i class="fas fa-plus"></i>
        </button>
        <button @click="openEditModal" class="p-2 bg-yellow-500 text-white rounded hover:bg-yellow-600" :disabled="!selectedQuotation" title="Edit Quotation">
          <i class="fas fa-edit"></i>
        </button>
      </div>
    </div>

    <table class="min-w-full bg-white border border-gray-300">
      <thead class="bg-gray-100">
        <tr>
          <th class="px-6 py-2 text-black text-left border-b">Quotation ID</th>
          <th class="px-6 py-2 text-black text-left border-b">Supplier</th>
          <th class="px-6 py-2 text-black text-left border-b">Total Price</th>
          <th class="px-6 py-2 text-black text-left border-b">Date Issued</th>
          <th class="px-6 py-2 text-black text-left border-b">Status</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="quotation in filteredQuotations" :key="quotation.id" class="hover:bg-gray-50" @click="selectQuotation(quotation)">
          <td class="px-6 py-4 text-black border-b">{{ quotation.id }}</td>
          <td class="px-6 py-4 text-black border-b">{{ quotation.supplier }}</td>
          <td class="px-6 py-4 text-black border-b">${{ quotation.totalPrice.toFixed(2) }}</td>
          <td class="px-6 py-4 text-black border-b">{{ quotation.dateIssued }}</td>
          <td class="px-6 py-4 text-black border-b">{{ quotation.status }}</td>
        </tr>
      </tbody>
    </table>

    <div class="mt-4 flex justify-between">
      <button @click="prevPage" :disabled="currentPage === 1" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Previous</button>
      <span>Page {{ currentPage }} of {{ totalPages }}</span>
      <button @click="nextPage" :disabled="currentPage === totalPages" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Next</button>
    </div>

    <!-- Modal for Add/Edit Quotation -->
    <div v-if="isModalOpen" class="modal-overlay" @click.self="closeModal">
      <div class="modal-content">
        <h2 class="text-xl font-bold mb-4">{{ isEditMode ? 'Edit Quotation' : 'Add Quotation' }}</h2>
        <form @submit.prevent="saveQuotation">
          <label for="supplier" class="block mb-2">Supplier:</label>
          <input id="supplier" v-model="quotationForm.supplier" type="text" placeholder="Enter supplier's name" required class="w-full p-2 border rounded"/>
          
          <label for="totalPrice" class="block mb-2 mt-4">Total Price:</label>
          <input id="totalPrice" v-model.number="quotationForm.totalPrice" type="number" step="0.01" placeholder="Enter total price" required class="w-full p-2 border rounded"/>

          <label for="dateIssued" class="block mb-2 mt-4">Date Issued:</label>
          <input id="dateIssued" v-model="quotationForm.dateIssued" type="date" required class="w-full p-2 border rounded"/>

          <label for="status" class="block mb-2 mt-4">Status:</label>
          <select id="status" v-model="quotationForm.status" class="w-full p-2 border rounded" required>
            <option value="" disabled>Select status</option>
            <option value="Pending">Pending</option>
            <option value="Approved">Approved</option>
            <option value="Rejected">Rejected</option>
          </select>

          <div class="flex justify-end mt-4">
            <button type="button" @click="closeModal" class="bg-gray-300 px-4 py-2 rounded hover:bg-gray-400">Cancel</button>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">{{ isEditMode ? 'Update' : 'Add' }}</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';

// Mock data for quotations
const quotations = ref([
  { id: 1, supplier: 'Supplier A', totalPrice: 1200, dateIssued: '2024-09-23', status: 'Pending' },
  { id: 2, supplier: 'Supplier B', totalPrice: 1500, dateIssued: '2024-09-22', status: 'Approved' },
]);

const searchQuery = ref('');
const currentPage = ref(1);
const itemsPerPage = 10;
const selectedQuotation = ref(null);
const isModalOpen = ref(false);
const isEditMode = ref(false);
const quotationForm = ref({ supplier: '', totalPrice: '', dateIssued: new Date().toISOString().split('T')[0], status: '' });

const filteredQuotations = computed(() => {
  const startIndex = (currentPage.value - 1) * itemsPerPage;
  const endIndex = currentPage.value * itemsPerPage;

  return quotations.value
    .filter(quotation => {
      return (
        quotation.id.toString().includes(searchQuery.value) ||
        quotation.supplier.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
        quotation.dateIssued.includes(searchQuery.value)
      );
    })
    .slice(startIndex, endIndex);
});

const totalPages = computed(() => Math.ceil(quotations.value.length / itemsPerPage));

const selectQuotation = (quotation) => {
  selectedQuotation.value = quotation;
};

const openAddModal = () => {
  quotationForm.value = { supplier: '', totalPrice: '', dateIssued: new Date().toISOString().split('T')[0], status: '' }; // Set date to today
  isEditMode.value = false;
  isModalOpen.value = true;
};

const openEditModal = () => {
  if (selectedQuotation.value) {
    quotationForm.value = { ...selectedQuotation.value };
    isEditMode.value = true;
    isModalOpen.value = true;
  }
};

const saveQuotation = () => {
  if (isEditMode.value) {
    const index = quotations.value.findIndex(q => q.id === selectedQuotation.value.id);
    if (index !== -1) {
      quotations.value[index] = { ...quotationForm.value, id: selectedQuotation.value.id };
    }
  } else {
    const newId = quotations.value.length > 0 ? Math.max(...quotations.value.map(q => q.id)) + 1 : 1;
    const newQuotation = { ...quotationForm.value, id: newId };
    quotations.value.push(newQuotation);
  }
  closeModal();
};

const closeModal = () => {
  isModalOpen.value = false;
  selectedQuotation.value = null; // Clear selection after closing
};

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
  justify-content: center;
  align-items: center;
  z-index: 1000;
}
.modal-content {
  background: white;
  padding: 20px;
  border-radius: 5px;
  width: 400px;
}
</style>
