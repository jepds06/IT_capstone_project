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
        <button
          @click="openAddModal"
          class="p-2 bg-blue-500 text-white rounded hover:bg-blue-600"
          title="Add Production"
        >
          <i class="fas fa-plus"></i>
        </button>
      </div>
    </div>

    <table class="min-w-full bg-white border border-gray-300 shadow-lg">
      <thead class="bg-gray-100">
        <tr>
          <th class="px-6 py-2 text-left border-b">Production ID</th>
          <th class="px-6 py-2 text-left border-b">Created By</th>
          <th class="px-6 py-2 text-left border-b">Date Encoded</th>
          <th class="px-6 py-2 text-left border-b">Year</th>
          <th class="px-6 py-2 text-left border-b">Month</th>
          <th class="px-6 py-2 text-left border-b">Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr
          v-for="production in paginatedProductions"
          :key="production.id"
          class="hover:bg-gray-50"
        >
          <td class="px-6 py-4 border-b">{{ production.id }}</td>
          <td class="px-6 py-4 border-b">{{ production.createdBy }}</td>
          <td class="px-6 py-4 border-b">{{ production.dateEncoded }}</td>
          <td class="px-6 py-4 border-b">{{ production.year }}</td>
          <td class="px-6 py-4 border-b">{{ production.month }}</td>
          <td class="px-6 py-4 border-b">
            <button
              @click="openViewModal(production)"
              class="text-green-500 hover:text-green-700"
              title="View Production"
            >
              <i class="fas fa-eye"></i>
            </button>
            <button
              @click="openEditModal(production)"
              class="text-yellow-500 hover:text-yellow-700 ml-2"
              title="Edit Production"
            >
              <i class="fas fa-edit"></i>
            </button>
            <button
              @click="openDeleteModal(production)"
              class="text-red-500 hover:text-red-700 ml-2"
              title="Delete Production"
            >
              <i class="fas fa-trash"></i>
            </button>
          </td>
        </tr>
      </tbody>
    </table>

    <div class="mt-4 flex justify-between">
      <button
        @click="prevPage"
        :disabled="currentPage === 1"
        class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400"
      >
        Previous
      </button>
      <span>Page {{ currentPage }} of {{ totalPages }}</span>
      <button
        @click="nextPage"
        :disabled="currentPage === totalPages"
        class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400"
      >
        Next
      </button>
    </div>

    <!-- Modal for Add/Edit Production -->
    <div v-if="isModalOpen" class="modal-overlay" @click.self="closeModal">
      <div class="modal-content">
        <h2 class="text-xl font-bold mb-4">{{ isEditMode ? 'Edit Production' : 'Add Production' }}</h2>
        <form @submit.prevent="saveProduction">
          <label for="createdBy" class="block mb-2">Created By:</label>
          <input
            id="createdBy"
            v-model="productionForm.createdBy"
            type="text"
            placeholder="Enter creator's name"
            required
            class="w-full p-2 border rounded"
          />

          <label for="dateEncoded" class="block mb-2 mt-4">Date Encoded:</label>
          <input
            id="dateEncoded"
            v-model="productionForm.dateEncoded"
            type="date"
            class="w-full p-2 border rounded"
          />

          <label for="year" class="block mb-2 mt-4">Year:</label>
          <input
            id="year"
            v-model="productionForm.year"
            type="number"
            placeholder="Enter year"
            class="w-full p-2 border rounded"
          />

          <label for="month" class="block mb-2 mt-4">Month:</label>
          <input
            id="month"
            v-model="productionForm.month"
            type="text"
            placeholder="Enter month"
            class="w-full p-2 border rounded"
          />

          <div class="flex justify-end mt-4">
            <button type="button" @click="closeModal" class="bg-gray-300 px-4 py-2 rounded hover:bg-gray-400">Cancel</button>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">{{ isEditMode ? 'Update' : 'Add' }}</button>
          </div>
        </form>
      </div>
    </div>

    <!-- Modal for Viewing Production Details -->
    <!-- Modal for Viewing Production Details -->
<div v-if="isViewModalOpen" class="modal-overlay" @click.self="closeViewModal">
  <div class="modal-content">
    <h2 class="text-xl font-bold mb-4">Production Details</h2>
    <div>
      <p><strong>Production Details No:</strong> {{ selectedProduction.detailsNo }}</p>
      <p><strong>Production ID:</strong> {{ selectedProduction.id }}</p>
      <p><strong>Quantity:</strong> {{ selectedProduction.quantity }}</p>
      <p>
        <strong>Status:</strong>
        <span class="inline-flex items-center">
          <i v-if="selectedProduction.status === 'active'" class="fas fa-check-circle text-green-500"></i>
          <i v-else-if="selectedProduction.status === 'inactive'" class="fas fa-times-circle text-red-500"></i>
          <span class="ml-1">{{ selectedProduction.status }}</span>
        </span>
      </p>
      <p><strong>Remarks:</strong> {{ selectedProduction.remarks }}</p>
    </div>
    <div class="flex justify-end mt-4">
      <button @click="openGenerateMaterialsModal(selectedProduction)" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 mr-2">
        Generate Materials
      </button>
      <button @click="closeViewModal" class="bg-gray-300 px-4 py-2 rounded hover:bg-gray-400">Close</button>
    </div>
  </div>
</div>

    <!-- Modal for Generating Materials -->
    <div v-if="isGenerateMaterialsModalOpen" class="modal-overlay" @click.self="closeGenerateMaterialsModal">
      <div class="modal-content">
        <h2 class="text-xl font-bold mb-4">Generate Materials for Production ID: {{ selectedProduction.id }}</h2>
        <p>Are you sure you want to generate materials for this production?</p>
        <div class="flex justify-end mt-4">
          <button @click="confirmGenerateMaterials" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Generate</button>
          <button @click="closeGenerateMaterialsModal" class="bg-gray-300 px-4 py-2 rounded hover:bg-gray-400">Cancel</button>
        </div>
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
  { id: 1, detailsNo: 'PD-001', quantity: 100, status: 'active', createdBy: 'Admin', dateEncoded: '2024-09-23', year: 2024, month: 'September', remarks: 'Initial production' },
  { id: 2, detailsNo: 'PD-002', quantity: 200, status: 'inactive', createdBy: 'User1', dateEncoded: '2024-09-22', year: 2024, month: 'September', remarks: 'Follow-up production' },
  // Add more sample data as needed for testing pagination
]);

const searchQuery = ref('');
const currentPage = ref(1);
const itemsPerPage = 5;

const isModalOpen = ref(false);
const isViewModalOpen = ref(false);
const isGenerateMaterialsModalOpen = ref(false);
const isDeleteModalOpen = ref(false);
const selectedProduction = ref(null);
const isEditMode = ref(false);
const productionForm = ref({ createdBy: '', dateEncoded: '', year: '', month: '' });

const filteredProductions = computed(() => {
  return productions.value.filter((production) =>
    production.createdBy.toLowerCase().includes(searchQuery.value.toLowerCase())
  );
});

const totalPages = computed(() => {
  return Math.ceil(filteredProductions.value.length / itemsPerPage);
});

const paginatedProductions = computed(() => {
  const start = (currentPage.value - 1) * itemsPerPage;
  return filteredProductions.value.slice(start, start + itemsPerPage);
});

const openAddModal = () => {
  isModalOpen.value = true;
  isEditMode.value = false;
  productionForm.value = { createdBy: '', dateEncoded: '', year: '', month: '' };
};

const openEditModal = (production) => {
  isModalOpen.value = true;
  isEditMode.value = true;
  productionForm.value = { ...production };
};

const saveProduction = () => {
  if (isEditMode.value) {
    const index = productions.value.findIndex(p => p.id === productionForm.value.id);
    if (index !== -1) {
      productions.value[index] = { ...productionForm.value };
    }
  } else {
    const newId = productions.value.length ? Math.max(productions.value.map(p => p.id)) + 1 : 1;
    productions.value.push({ ...productionForm.value, id: newId });
  }
  closeModal();
};

const closeModal = () => {
  isModalOpen.value = false;
};

const openViewModal = (production) => {
  selectedProduction.value = production;
  isViewModalOpen.value = true;
};

const closeViewModal = () => {
  isViewModalOpen.value = false;
};

const openGenerateMaterialsModal = (production) => {
  selectedProduction.value = production;
  isGenerateMaterialsModalOpen.value = true;
};

const closeGenerateMaterialsModal = () => {
  isGenerateMaterialsModalOpen.value = false;
};

const confirmGenerateMaterials = () => {
  console.log('Materials generated for production ID:', selectedProduction.value.id);
  closeGenerateMaterialsModal();
};

const openDeleteModal = (production) => {
  selectedProduction.value = production;
  isDeleteModalOpen.value = true;
};

const closeDeleteModal = () => {
  isDeleteModalOpen.value = false;
};

const confirmDelete = () => {
  productions.value = productions.value.filter(p => p.id !== selectedProduction.value.id);
  closeDeleteModal();
};

const nextPage = () => {
  if (currentPage.value < totalPages.value) {
    currentPage.value++;
  }
};

const prevPage = () => {
  if (currentPage.value > 1) {
    currentPage.value--;
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
}
.modal-content {
  background: white;
  padding: 20px;
  border-radius: 8px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
  max-width: 500px;
  width: 100%;
}
</style>
