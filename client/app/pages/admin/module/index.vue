<template>
  <div class="m-8">
    <div class="flex justify-between items-center mb-4">
      <h1 class="text-2xl text-color font-extrabold">Modules</h1>
      <button
        @click="openForm('add')"
        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
      >
        Add
      </button>
    </div>
    
    <input
      type="text"
      v-model="searchQuery"
      placeholder="Search Modules"
      class="border p-2 mb-4 w-full"
    />
    
    <table class="min-w-full bg-white border">
      <thead>
        <tr>
          <th class="border px-4 py-2 text-black">Module No.</th>
          <th class="border px-4 py-2 text-black">Module Name</th>
          <th class="border px-4 py-2 text-black">Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="module in filteredModules" :key="module.moduleID">
          <td class="border px-4 py-2 text-black text-center">{{ module.moduleID }}</td>
          <td class="border px-4 py-2 text-black text-center">{{ module.moduleName }}</td>
          <td class="p-2 border-b flex justify-center space-x-2">
            <button
              @click="viewModule(module)"
              class="text-blue-500 hover:underline"
            > 
              <i class="fas fa-eye"></i>
            </button>
            <button
              @click="editModule(module)"
              class="text-yellow-500 hover:underline"
            >
              <i class="fas fa-edit"></i>
            </button>
          </td>
        </tr>
      </tbody>
    </table>
    
    <!-- Pagination -->
    <div class="flex justify-between items-center mt-4">
      <span>Showing {{ currentPageStart }}-{{ currentPageEnd }} of {{ totalModules }}</span>
      <div>
        <button @click="previousPage" class="px-4 py-2" :disabled="currentPage === 1">Previous</button>
        <button @click="nextPage" class="px-4 py-2" :disabled="currentPage === totalPages">Next</button>
      </div>
    </div>
  </div>

  <Modal
    :isVisible="isFormVisible"
    title="Module Form"
    :showSave="true"
    @update:isVisible="isFormVisible = $event"
    @save="confirmSave"
  >
    <template v-slot:body>
      <form @submit.prevent="saveModule">
        <div class="mb-4" v-if="formMode === 'edit'">
          <label for="id" class="block text-sm font-medium text-gray-700"
            >Id</label
          >
          <input
            v-model="form.moduleID"
            type="text"
            id="id"
            class="mt-1 block w-full border border-gray-300 rounded-lg p-2"
            :readonly="formMode === 'edit'"
          />
        </div>
        <div class="mb-4">
          <label
            for="description"
            class="block text-sm font-medium text-gray-700"
            >Name</label
          >
          <input
            v-model="form.moduleName"
            type="text"
            id="description"
            class="mt-1 block w-full border border-gray-300 rounded-lg p-2"
          />
        </div>
        <!-- <div class="mb-4">
          <label for="status" class="block text-sm font-medium text-gray-700"
            >Status</label
          >
          <select
            v-model="form.status"
            id="status"
            class="mt-1 block w-full border border-gray-300 rounded-lg p-2"
          >
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
          </select>
        </div> -->
      </form>
    </template>
  </Modal>

   <!-- Confirmation Modal for Module -->
   <div
    v-if="showConfirmationModal"
    class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
  >
    <div class="bg-white p-6 rounded-md w-1/3 shadow-lg">
      <h3 class="text-xl font-bold mb-4 text-black">Are you sure you want to proceed?</h3>
      <div class="flex justify-end mt-4">
        <button
          class="bg-blue-500 text-white py-1 px-3 rounded-md mr-2"
          @click="saveModule"
        >
          Yes
        </button>
        <button
          class="text-red-600 py-1 px-3 rounded-md"
          @click="showConfirmationModal = false"
        >
          No
        </button>
      </div>
    </div>
  </div>

  <!-- Success Message Modal for Module -->
  <div
    v-if="showSuccessModal"
    class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
  >
    <div class="bg-white p-6 rounded-md w-1/3 shadow-lg">
      <h3 class="text-xl font-bold mb-4 text-green-600">Success!</h3>
      <p class="text-black">Module has been {{ formMode === 'add' ? 'created' : 'updated' }} successfully!</p>
      <div class="flex justify-end mt-4">
        <button
          class="bg-blue-500 text-white py-1 px-3 rounded-md"
          @click="handleSuccess"
        >
          OK
        </button>
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
import { apiService } from "~/api/apiService";

const modules = ref([]);

const searchQuery = ref('');
const currentPage = ref(1);
const itemsPerPage = 10;

const showConfirmationModal = ref(false);
const showSuccessModal = ref(false);
const isFormVisible = ref(false);
const formMode = ref("add");
const form = ref({
  moduleID: "",
  moduleName: "",
});

function handleSuccess() {
  closeForm(); // Close the form modal
  showSuccessModal.value = false; // Close the success modal
}

const confirmSave = () => {
  showConfirmationModal.value = true;
};

function openForm(mode = "add", category = null) {
  formMode.value = mode;
  if (mode === "edit" && category) {
    form.value = { ...category };
  } else {
    form.value = { moduleName: "",};
  }
  isFormVisible.value = true;
}

function closeForm() {
  isFormVisible.value = false;
}

async function saveModule() {
  showConfirmationModal.value = false;
  try {
    if (formMode.value === "add") {
    const { data } = await apiService.post("/api/modules", form.value);
    modules.value.push(data);
    showSuccessModal.value = true;
    formMode.value = 'add';
  } else if (formMode.value === "edit") {
    const index = modules.value.findIndex((cat) => cat.moduleID === form.value.moduleID);
    if (index !== -1) {
    const { data } = await apiService.put(`/api/modules/${form.value.moduleID}`, form.value);
    modules.value[index] = data;
    showSuccessModal.value = true;
    formMode.value = 'edit';
    }
  }
  closeForm();
  } catch (error) {
    console.log('error', error)
    closeForm();
  }
 
}

function viewModule(module) {
  alert(`Viewing module: ${module.moduleName}`);
}

function editModule(module) {
  openForm("edit", module);
}


const filteredModules = computed(() => {
  return modules.value.filter(module => {
    return module?.moduleName?.toLowerCase().includes(searchQuery.value.toLowerCase());
  });
});

const totalModules = computed(() => filteredModules.value.length);
const totalPages = computed(() => Math.ceil(totalModules.value / itemsPerPage));
const currentPageStart = computed(() => (currentPage.value - 1) * itemsPerPage + 1);
const currentPageEnd = computed(() => Math.min(currentPage.value * itemsPerPage, totalModules.value));

const paginatedModules = computed(() => {
  const start = (currentPage.value - 1) * itemsPerPage;
  return filteredModules.value.slice(start, start + itemsPerPage);
});

const previousPage = () => {
  if (currentPage.value > 1) currentPage.value--;
};

const nextPage = () => {
  if (currentPage.value < totalPages.value) currentPage.value++;
};

// Define an async function to fetch data
const fetchData = async () => {
  try {
    // Call the get method from ApiService
    const { data } = await apiService.get("/api/modules"); // Replace '/endpoint' with your actual API endpoint
    modules.value = data
  } catch (error) {
    console.error("Error fetching data:", error);
  }
};

onMounted(() => {
  fetchData()
})

</script>

<style lang="scss" scoped>

</style>