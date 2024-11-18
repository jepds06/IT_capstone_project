<template>
  <div class="m-8 space-y-6">
    <!-- Title and Add Button -->
    <div class="flex justify-between items-center mb-4">
      <h1 class="text-xl font-bold">Materials</h1>
      <button
        @click="openForm('add')"
        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
      >
        Add
      </button>
    </div>
  
    <!-- Modal for Add/Edit Form -->
    <Modal
      :isVisible="isFormVisible"
      title="Material Form"
      :showSave="true"
      @update:isVisible="isFormVisible = $event"
      @save="confirmSave"
    >
      <template v-slot:body>
        <form @submit.prevent="saveMaterial">
          <div class="mb-4" v-if="formMode === 'edit'">
            <label for="id" class="block text-sm font-medium text-gray-700"
              >Id</label
            >
            <input
              v-model="form.materialID"
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
              >Description</label
            >
            <input
              v-model="form.description"
              type="text"
              id="description"
              class="mt-1 block w-full border border-gray-300 rounded-lg p-2"
            />
          </div>
          <div class="mb-4">
            <label for="specs" class="block text-sm font-medium text-gray-700">Specification</label>
            <textarea v-model="form.specification" id="specs" rows="3" class="mt-1 block w-full border border-gray-300 rounded-lg p-2"></textarea>
          </div>
          <div class="mb-4">
            <label
              for="description"
              class="block text-sm font-medium text-gray-700"
              >Brand</label
            >
            <input
              v-model="form.brand"
              type="text"
              id="description"
              class="mt-1 block w-full border border-gray-300 rounded-lg p-2"
            />
          </div>
          <div class="mb-4">
            <label for="unitOfMeasure" class="block text-sm font-medium text-gray-700">Unit of Measure</label>
            <input v-model="form.unitOfMeasure" id="unitPrice" class="mt-1 block w-full border border-gray-300 rounded-lg p-2"/>
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

    <!-- Confirmation Modal -->
  <div
    v-if="showConfirmationModal"
    class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
    @keydown.enter="saveMaterial"  
    tabindex="0"
  >
    <div class="bg-white p-6 rounded-md w-1/3 shadow-lg">
      <h3 class="text-xl font-bold mb-4 text-black">Are you sure you want to proceed?</h3>
      <div class="flex justify-end mt-4">
        <button
          class="bg-blue-500 text-white py-1 px-3 rounded-md mr-2"
          @click="saveMaterial"
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

  <!-- Success Message Modal -->
  <div
    v-if="showSuccessModal"
    class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
  >
    <div class="bg-white p-6 rounded-md w-1/3 shadow-lg">
      <h3 class="text-xl font-bold mb-4 text-green-600">Success!</h3>
      <p class="text-black">Material has been {{ formMode === 'add' ? 'created' : 'updated' }} successfully!</p>
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
  
    <!--  Materials Table -->
    <table class="min-w-full border border-gray-300 rounded-lg">
      <thead class="bg-gray-100">
        <tr>
          <th class="p-2 border-b text-black text-center">Id</th>
          <th class="p-2 border-b text-black text-center">Description</th>
          <th class="p-2 border-b text-black text-center">Brand</th>
          <th class="p-2 border-b text-black text-center">Unit of Measure</th>
          <!-- <th class="p-2 border-b text-center">Status</th> -->
          <th class="p-2 border-b text-black text-center">Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="material in materials" :key="material.materialID">
          
          <td class="p-2 border-b text-center">{{ material.materialID }}</td>
          <td class="p-2 border-b text-center">{{ material.description }}</td>
          <td class="p-2 border-b text-center">{{ material.brand }}</td>
          <td class="p-2 border-b text-center">{{ material.unitOfMeasure }}</td>
          <!-- <td class="p-2 border-b text-center">
            <i
              v-if="category.status === 'active'"
              class="fas fa-check text-green-500"
            ></i>
            <i v-else class="fas fa-times text-red-500"></i>
          </td> -->
          <td class="p-2 border-b flex justify-center space-x-2">
            <button
              @click="viewMaterial(material)"
              class="text-blue-500 hover:underline"
            > 
              <i class="fas fa-eye"></i>
            </button>
            <button
              @click="editMaterial(material)"
              class="text-yellow-500 hover:underline"
            >
              <i class="fas fa-edit"></i>
            </button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
  </template>
  
  <script setup>
import auth from '../../../../middleware/auth'
// This page requires authentication
definePageMeta({
  middleware: [auth],
});
  import { ref } from "vue";
  import Modal from "~/components/Modal.vue"; // Adjust the path if needed
  import { apiService } from "~/api/apiService";
  
  const materials = ref([]);
  const isFormVisible = ref(false);
  const showConfirmationModal = ref(false);
  const showSuccessModal = ref(false);
  const formMode = ref("add");
  const form = ref({
    id: "",
    description: "",
    status: "active",
  });
  
  function openForm(mode = "add", category = null) {
    formMode.value = mode;
    if (mode === "edit" && category) {
      form.value = { ...category };
    } else {
      form.value = { description:"", specification:"", brand:"", unitOfMeasure:""};
    }
    isFormVisible.value = true;
  }
  
  function closeForm() {
  isFormVisible.value = false;
}

function handleSuccess() {
  closeForm(); // Close the form modal
  showSuccessModal.value = false; // Close the success modal
}

const confirmSave = () => {
  showConfirmationModal.value = true;
};


  
async function saveMaterial() {
  showConfirmationModal.value = false;
  
  if (formMode.value === "add") {
    const { data } = await apiService.post("/api/materials", form.value);
    materials.value.push(data);
    showSuccessModal.value = true; // Show the success modal for creation
    formMode.value = 'add'; // Set the form mode to 'add' for the success message
  } else if (formMode.value === "edit") {
    const index = materials.value.findIndex((cat) => cat.materialID === form.value.materialID);
    if (index !== -1) {
      const { data } = await apiService.put(`/api/materials/${form.value.materialID}`, form.value);
      materials.value[index] = data;
      showSuccessModal.value = true; // Show the success modal for update
      formMode.value = 'edit'; // Set the form mode to 'edit' for the success message
    }
  }
  closeForm();
}

  
  function viewMaterial(material) {
    alert(`Viewing category: ${material.description}`);
  }
  
  function editMaterial(material) {
    openForm("edit", material);
  }
  
  // Define an async function to fetch data
  const fetchData = async () => {
    try {
      // Call the get method from ApiService
      const { data } = await apiService.get("/api/materials"); // Replace '/endpoint' with your actual API endpoint
      materials.value = data
    } catch (error) {
      console.error("Error fetching data:", error);
    }
  };
  
  onMounted(() => {
  const handleKeydown = (event) => {
    if (showConfirmationModal.value && event.key === "Enter") {
      event.preventDefault(); // Prevent default form behavior
      saveMaterial();
    }
  };

  document.addEventListener("keydown", handleKeydown);

  // Clean up listener on unmount
  onUnmounted(() => {
    document.removeEventListener("keydown", handleKeydown);
  });
});
  
  </script>
  
  <style scoped>
  /* Center the modal */
  .fixed {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
  }
  </style>
  