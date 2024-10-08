<template>
  <div class="p-6">
    <!-- Title -->
    <h2 class="text-2xl font-bold mb-4">Quotations</h2>

    <!-- Search and Action Buttons -->
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

    <!-- Quotations Table -->
    <table class="min-w-full bg-white border border-gray-300">
      <thead class="bg-gray-100">
        <tr>
          <th class="px-6 py-2 text-black text-left border-b">Quotation ID</th>
          <th class="px-6 py-2 text-black text-left border-b">Material ID</th>
          <th class="px-6 py-2 text-black text-left border-b">Unit of Measure</th>
          <th class="px-6 py-2 text-black text-left border-b">Contact Person</th>
          <th class="px-6 py-2 text-black text-left border-b">Quantity Quoted</th>
          <th class="px-6 py-2 text-black text-left border-b">Unit Price</th>
          <th class="px-6 py-2 text-black text-left border-b">Total Price</th>
          <th class="px-6 py-2 text-black text-left border-b">Quotation Date</th>
          <th class="px-6 py-2 text-black text-left border-b">Validity Date</th>
          <th class="px-6 py-2 text-black text-left border-b">Remarks</th>
          <th class="px-6 py-2 text-black text-left border-b">Supplier ID</th>
          <th class="px-6 py-2 text-black text-left border-b">Status</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="quotation in filteredQuotations" :key="quotation.id" class="hover:bg-gray-50" @click="selectQuotation(quotation)">
          <td class="px-6 py-4 text-black border-b">{{ quotation.id }}</td>
          <td class="px-6 py-4 text-black border-b">{{ quotation.materialId }}</td>
          <td class="px-6 py-4 text-black border-b">{{ quotation.unitOfMeasure }}</td>
          <td class="px-6 py-4 text-black border-b">{{ quotation.contactPerson }}</td>
          <td class="px-6 py-4 text-black border-b">{{ quotation.quantityQuoted }}</td>
          <td class="px-6 py-4 text-black border-b">${{ quotation.unitPrice.toFixed(2) }}</td>
          <td class="px-6 py-4 text-black border-b">${{ quotation.totalPrice.toFixed(2) }}</td>
          <td class="px-6 py-4 text-black border-b">{{ quotation.quotationDate }}</td>
          <td class="px-6 py-4 text-black border-b">{{ quotation.validityDate }}</td>
          <td class="px-6 py-4 text-black border-b">{{ quotation.remarks }}</td>
          <td class="px-6 py-4 text-black border-b">{{ quotation.supplierId }}</td>
          <td class="px-6 py-4 text-black border-b">{{ quotation.status }}</td>
        </tr>
      </tbody>
    </table>

    <!-- Pagination Controls -->
    <div class="mt-4 flex justify-between">
      <button @click="prevPage" :disabled="currentPage === 1" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Previous</button>
      <span>Page {{ currentPage }} of {{ totalPages }}</span>
      <button @click="nextPage" :disabled="currentPage === totalPages" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Next</button>
    </div>

    <!-- Modal for Adding/Editing Quotations -->
    <div v-if="isModalOpen" class="modal-overlay" @click.self="closeModal">
      <div class="modal-content">
        <h2 class="text-xl font-bold mb-4 text-black">{{ isEditMode ? 'Edit Quotation' : 'Add Quotation' }}</h2>
        <form @submit.prevent="saveQuotation">
          <label for="supplier" class="block mb-2 text-black">Supplier ID:</label>
          <input id="supplier" v-model="quotationForm.supplierId" type="text" placeholder="Enter supplier's ID" required class="w-full p-2 border rounded"/>

          <label for="materialId" class="block mb-2 mt-4 text-black">Material ID:</label>
          <input id="materialId" v-model="quotationForm.materialId" type="text" placeholder="Enter material ID" required class="w-full p-2 border rounded"/>

          <label for="unitOfMeasure" class="block mb-2 mt-4 text-black">Unit of Measure:</label>
          <input id="unitOfMeasure" v-model="quotationForm.unitOfMeasure" type="text" placeholder="Enter unit of measure" required class="w-full p-2 border rounded"/>

          <label for="contactPerson" class="block mb-2 mt-4 text-black">Contact Person:</label>
          <input id="contactPerson" v-model="quotationForm.contactPerson" type="text" placeholder="Enter contact person's name" required class="w-full p-2 border rounded"/>

          <label for="quantityQuoted" class="block mb-2 mt-4 text-black">Quantity Quoted:</label>
          <input id="quantityQuoted" v-model.number="quotationForm.quantityQuoted" type="number" placeholder="Enter quantity quoted" required class="w-full p-2 border rounded"/>

          <label for="unitPrice" class="block mb-2 mt-4 text-black">Unit Price:</label>
          <input id="unitPrice" v-model.number="quotationForm.unitPrice" type="number" step="0.01" placeholder="Enter unit price" required class="w-full p-2 border rounded"/>

          <label for="totalPrice" class="block mb-2 mt-4 text-black">Total Price:</label>
          <input id="totalPrice" v-model.number="quotationForm.totalPrice" type="number" step="0.01" placeholder="Enter total price" required class="w-full p-2 border rounded" disabled/>

          <label for="quotationDate" class="block mb-2 mt-4 text-black">Quotation Date:</label>
          <input id="quotationDate" v-model="quotationForm.quotationDate" type="date" required class="w-full p-2 border rounded"/>

          <label for="validityDate" class="block mb-2 mt-4 text-black">Validity Date:</label>
          <input id="validityDate" v-model="quotationForm.validityDate" type="date" required class="w-full p-2 border rounded"/>

          <label for="remarks" class="block mb-2 mt-4 text-black">Remarks:</label>
          <textarea id="remarks" v-model="quotationForm.remarks" placeholder="Enter any remarks" class="w-full p-2 border rounded"></textarea>

          <!-- Dropdown for Status -->
      <label for="status" class="block mb-2 mt-4 text-black">Status:</label>
      <select id="status" v-model="quotationForm.status" class="w-full p-2 border rounded">
        <option value="Pending">Pending</option>
        <option value="Rejected">Rejected</option>
        <option value="Approved">Approved</option>
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

// Mock data for quotations with new fields
const quotations = ref([
  {
    id: 1,
    materialId: 'M001',
    unitOfMeasure: 'kg',
    contactPerson: 'John Doe',
    quantityQuoted: 10,
    unitPrice: 120,
    totalPrice: 1200,
    quotationDate: '2024-09-23',
    validityDate: '2024-10-23',
    remarks: 'Urgent order',
    supplierId: 'S001',
    status: 'Pending'
  },
  {
    id: 2,
    supplierId: 'S002',
    materialId: 'M002',
    unitOfMeasure: 'liters',
    contactPerson: 'Jane Smith',
    quantityQuoted: 200,
    unitPrice: 3.5,
    totalPrice: 700.0,
    quotationDate: '2024-10-02',
    validityDate: '2024-10-16',
    remarks: ''

  },
  // Add more quotations as needed...
]);

// State variables
const isModalOpen = ref(false);
const isEditMode = ref(false);
const selectedQuotation = ref(null);
const searchQuery = ref('');
const quotationForm = ref({
  supplierId: '',
  materialId: '',
  unitOfMeasure: '',
  contactPerson: '',
  quantityQuoted: null,
  unitPrice: null,
  totalPrice: null,
  quotationDate: '',
  validityDate: '',
  remarks: ''
});

// Computed properties
const filteredQuotations = computed(() => {
  return quotations.value.filter(quotation => {
    return (
      quotation.materialId.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
      quotation.contactPerson.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
      quotation.remarks.toLowerCase().includes(searchQuery.value.toLowerCase())
    );
  });
});

// Pagination logic
const currentPage = ref(1);
const itemsPerPage = 5;
const totalPages = computed(() => Math.ceil(filteredQuotations.value.length / itemsPerPage));

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

// Modal functions
const openAddModal = () => {
  isEditMode.value = false;
  resetForm();
  isModalOpen.value = true;
};

const openEditModal = () => {
  if (selectedQuotation.value) {
    isEditMode.value = true;
    Object.assign(quotationForm.value, selectedQuotation.value);
    isModalOpen.value = true;
  }
};

const closeModal = () => {
  isModalOpen.value = false;
};

const resetForm = () => {
  quotationForm.value = {
    supplierId: '',
    materialId: '',
    unitOfMeasure: '',
    contactPerson: '',
    quantityQuoted: null,
    unitPrice: null,
    totalPrice: null,
    quotationDate: '',
    validityDate: '',
    remarks: ''
  };
};

const saveQuotation = () => {
  if (isEditMode.value) {
    // Update existing quotation
    Object.assign(selectedQuotation.value, quotationForm.value);
  } else {
    // Add new quotation
    const newQuotation = { id: quotations.value.length + 1, ...quotationForm.value };
    newQuotation.totalPrice = newQuotation.unitPrice * newQuotation.quantityQuoted; // Calculate total price
    quotations.value.push(newQuotation);
  }
  closeModal();
};

// Selecting a quotation
const selectQuotation = (quotation) => {
  selectedQuotation.value = quotation;
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
  border-radius: 8px;
  max-height: 80%;
  overflow-y: auto;
  width: 600px;
}
</style>
