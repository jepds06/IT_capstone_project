<template>
  <div class="p-6">
    <h2 class="text-2xl font-bold mb-4">Productions</h2>

    <div class="flex justify-between mb-4">
      <input
        type="text"
        v-model="searchQuery"
        placeholder="Search..."
        class="w-1/3 p-2 border rounded-lg"
      />
      <div class="flex space-x-2">
        <button @click="openAddModal" class="p-2 bg-blue-500 text-white rounded hover:bg-blue-600" title="Add Production">
          <i class="fas fa-plus"></i>
        </button>
        <button @click="openEditModal" class="p-2 bg-yellow-500 text-white rounded hover:bg-yellow-600" :disabled="!selectedProduction" title="Edit Production">
          <i class="fas fa-edit"></i>
        </button>
        <button @click="openDeleteModal" class="p-2 bg-red-500 text-white rounded hover:bg-red-600" :disabled="!selectedProduction" title="Delete Production">
          <i class="fas fa-trash"></i>
        </button>
      </div>
    </div>

    <table class="min-w-full bg-white border border-gray-300">
      <thead class="bg-gray-100">
        <tr>
          <th class="px-6 py-2 text-left border-b">Production ID</th>
          <th class="px-6 py-2 text-left border-b">Created By</th>
          <th class="px-6 py-2 text-left border-b">Date Encoded</th>
          <th class="px-6 py-2 text-left border-b">Year</th>
          <th class="px-6 py-2 text-left border-b">Month</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="production in filteredProductions" :key="production.id" class="hover:bg-gray-50" @click="selectProduction(production)">
          <td class="px-6 py-4 border-b">{{ production.id }}</td>
          <td class="px-6 py-4 border-b">{{ production.createdBy }}</td>
          <td class="px-6 py-4 border-b">{{ production.dateEncoded }}</td>
          <td class="px-6 py-4 border-b">{{ production.year }}</td>
          <td class="px-6 py-4 border-b">{{ production.month }}</td>
        </tr>
      </tbody>
    </table>

    <div class="mt-4 flex justify-between">
      <button @click="prevPage" :disabled="currentPage === 1" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Previous</button>
      <span>Page {{ currentPage }} of {{ totalPages }}</span>
      <button @click="nextPage" :disabled="currentPage === totalPages" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Next</button>
    </div>

    <!-- Modal for Add/Edit Production -->
    <div v-if="isModalOpen" class="modal-overlay" @click.self="closeModal">
      <div class="modal-content">
        <h2 class="text-xl font-bold mb-4">{{ isEditMode ? 'Edit Production' : 'Add Production' }}</h2>
        <form @submit.prevent="saveProduction">
          <label for="createdBy" class="block mb-2">Created By:</label>
          <input id="createdBy" v-model="productionForm.createdBy" type="text" placeholder="Enter creator's name" required class="w-full p-2 border rounded"/>
          
          <label for="dateEncoded" class="block mb-2 mt-4">Date Encoded:</label>
          <input id="dateEncoded" v-model="productionForm.dateEncoded" type="date" class="w-full p-2 border rounded"/>

          <label for="year" class="block mb-2 mt-4">Year:</label>
          <input id="year" v-model="productionForm.year" type="number" placeholder="Enter year" class="w-full p-2 border rounded"/>

          <label for="month" class="block mb-2 mt-4">Month:</label>
          <input id="month" v-model="productionForm.month" type="text" placeholder="Enter month" class="w-full p-2 border rounded"/>

          <div class="flex justify-end mt-4">
            <button type="button" @click="closeModal" class="bg-gray-300 px-4 py-2 rounded hover:bg-gray-400">Cancel</button>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">{{ isEditMode ? 'Update' : 'Add' }}</button>
          </div>
        </form>
      </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div v-if="isDeleteModalOpen" class="modal-overlay" @click.self="closeDeleteModal">
      <div class="modal-content">
        <h3 class="text-lg font-bold">Delete Production</h3>
        <p>Are you sure you want to delete production ID {{ selectedProduction?.id }}?</p>
        <div class="flex justify-end mt-4">
          <button @click="confirmDelete" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Delete</button>
          <button @click="closeDeleteModal" class="bg-gray-300 px-4 py-2 rounded hover:bg-gray-400">Cancel</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';

const productions = ref([
  { id: 1, createdBy: 'Admin', dateEncoded: '2024-09-23', year: 2024, month: 'September' },
  { id: 2, createdBy: 'User1', dateEncoded: '2024-09-22', year: 2024, month: 'September' },
]);

const searchQuery = ref('');
const currentPage = ref(1);
const itemsPerPage = 10;
const selectedProduction = ref(null);
const isModalOpen = ref(false);
const isDeleteModalOpen = ref(false);
const isEditMode = ref(false);
const productionForm = ref({ createdBy: '', dateEncoded: '', year: '', month: '' });

const filteredProductions = computed(() => {
  const startIndex = (currentPage.value - 1) * itemsPerPage;
  const endIndex = currentPage.value * itemsPerPage;

  return productions.value
    .filter(production => {
      return (
        production.id.toString().includes(searchQuery.value) ||
        production.createdBy.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
        production.dateEncoded.includes(searchQuery.value)
      );
    })
    .slice(startIndex, endIndex);
});

const totalPages = computed(() => Math.ceil(productions.value.length / itemsPerPage));

const selectProduction = (production) => {
  selectedProduction.value = production;
};

const openAddModal = () => {
  productionForm.value = { createdBy: '', dateEncoded: '', year: '', month: '' };
  isEditMode.value = false;
  isModalOpen.value = true;
};

const openEditModal = () => {
  if (selectedProduction.value) {
    productionForm.value = { ...selectedProduction.value };
    isEditMode.value = true;
    isModalOpen.value = true;
  }
};

const openDeleteModal = () => {
  if (selectedProduction.value) {
    isDeleteModalOpen.value = true;
  }
};

const saveProduction = () => {
  if (isEditMode.value) {
    const index = productions.value.findIndex(p => p.id === selectedProduction.value.id);
    if (index !== -1) {
      productions.value[index] = { ...productionForm.value, id: selectedProduction.value.id };
    }
  } else {
    const newId = productions.value.length > 0 ? Math.max(...productions.value.map(p => p.id)) + 1 : 1;
    const newProduction = { ...productionForm.value, id: newId };
    productions.value.push(newProduction);
  }
  closeModal();
};

const confirmDelete = () => {
  if (selectedProduction.value) {
    productions.value = productions.value.filter(p => p.id !== selectedProduction.value.id);
    selectedProduction.value = null; // Clear selected production after deletion
  }
  closeDeleteModal();
};

const closeModal = () => {
  isModalOpen.value = false;
  selectedProduction.value = null; // Clear selection after closing
};

const closeDeleteModal = () => {
  isDeleteModalOpen.value = false;
  selectedProduction.value = null; // Clear selection after closing
};

const prevPage = () => {
  if (currentPage.value > 1) currentPage.value--;
};

const nextPage = () => {
  if (currentPage.value < totalPages.value) currentPage.value++;
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
}
.modal-content {
  background: white;
  padding: 20px;
  border-radius: 5px;
  width: 400px;
}
</style>