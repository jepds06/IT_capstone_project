<template>
  <!-- Title and Add Button -->
  <div class="flex justify-between items-center mb-4">
    <h1 class="text-xl font-bold">Materials</h1>
    <button @click="openForm('add')" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
      Add
    </button>
  </div>

  <!-- Modal for Add/Edit Form -->
  <Modal
    :isVisible="isFormVisible"
    title="Material Form"
    :showSave="true"
    @update:isVisible="isFormVisible = $event"
    @save="saveMaterial"
  >
    <template v-slot:body>
      <form @submit.prevent="saveMaterial">
        <div class="mb-4" v-if="formMode === 'edit'">
          <label for="id" class="block text-sm font-medium text-gray-700">Id</label>
          <input v-model="form.materialID" type="text" id="id" class="mt-1 block w-full border border-gray-300 rounded-lg p-2" :readonly="formMode === 'edit'" />
        </div>
        <div class="mb-4">
          <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
          <input v-model="form.description" type="text" id="description" class="mt-1 block w-full border border-gray-300 rounded-lg p-2" />
        </div>
        <div class="mb-4">
          <label for="specs" class="block text-sm font-medium text-gray-700">Specification</label>
          <textarea v-model="form.specification" id="specs" rows="3" class="mt-1 block w-full border border-gray-300 rounded-lg p-2"></textarea>
        </div>
        <div class="mb-4">
          <label for="brand" class="block text-sm font-medium text-gray-700">Brand</label>
          <input v-model="form.brand" type="text" id="brand" class="mt-1 block w-full border border-gray-300 rounded-lg p-2" />
        </div>
        <div class="mb-4">
          <label for="unitOfMeasure" class="block text-sm font-medium text-gray-700">Unit of Measure</label>
          <input v-model="form.unitOfMeasure" id="unitPrice" class="mt-1 block w-full border border-gray-300 rounded-lg p-2"/>
        </div>
      </form>
    </template>
  </Modal>

  <!-- Materials Table -->
  <table class="min-w-full border border-gray-300 rounded-lg">
    <thead class="bg-gray-100">
      <tr>
        <th class="p-2 border-b text-black text-center">Id</th>
        <th class="p-2 border-b text-black text-center">Description</th>
        <th class="p-2 border-b text-black text-center">Brand</th>
        <th class="p-2 border-b text-black text-center">Unit of Measure</th>
        <th class="p-2 border-b text-black text-center">Actions</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="material in paginatedMaterials" :key="material.materialID">
        <td class="p-2 border-b text-center">{{ material.materialID }}</td>
        <td class="p-2 border-b text-center">{{ material.description }}</td>
        <td class="p-2 border-b text-center">{{ material.brand }}</td>
        <td class="p-2 border-b text-center">{{ material.unitOfMeasure }}</td>
        <td class="p-2 border-b flex justify-center space-x-2">
          <button @click="viewMaterial(material)" class="text-blue-500 hover:underline">
            <i class="fas fa-eye"></i>
          </button>
          <button @click="editMaterial(material)" class="text-yellow-500 hover:underline">
            <i class="fas fa-edit"></i>
          </button>
        </td>
      </tr>
    </tbody>
  </table>

  <!-- Pagination Controls -->
  <div class="flex justify-between items-center mt-4">
    <button @click="changePage(currentPage - 1)" :disabled="currentPage === 1" class="px-4 py-2 bg-gray-200 rounded-lg mx-1">
      Previous
    </button>

    <span class="mx-2">Page {{ currentPage }} of {{ totalPages }}</span>

    <button @click="changePage(currentPage + 1)" :disabled="currentPage === totalPages" class="px-4 py-2 bg-gray-200 rounded-lg mx-1">
      Next
    </button>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from "vue";
import Modal from "@/components/Modal.vue";

// Sample materials data
const materials = ref([
  // Add your materials data here
]);

// Pagination logic
const currentPage = ref(1);
const materialsPerPage = ref(5);
const paginatedMaterials = computed(() => {
  const start = (currentPage.value - 1) * materialsPerPage.value;
  const end = start + materialsPerPage.value;
  return materials.value.slice(start, end);
});
const totalPages = computed(() => Math.ceil(materials.value.length / materialsPerPage.value));
function changePage(page) {
  if (page >= 1 && page <= totalPages.value) {
    currentPage.value = page;
  }
}

const isFormVisible = ref(false);
const formMode = ref("add");
const form = ref({ materialID: "", description: "", specification: "", brand: "", unitOfMeasure: "" });
const selectedMaterial = ref(null);

function openForm(mode, material = null) {
  formMode.value = mode;
  if (mode === "edit" && material) {
    form.value = { ...material };
  } else {
    form.value = { materialID: "", description: "", specification: "", brand: "", unitOfMeasure: "" };
  }
  isFormVisible.value = true;
}

function viewMaterial(material) {
  selectedMaterial.value = material;
  isFormVisible.value = true;
}

function editMaterial(material) {
  openForm("edit", material);
}

function saveMaterial() {
  if (formMode.value === "add") {
    materials.value.push({ ...form.value });
  } else {
    const index = materials.value.findIndex((m) => m.materialID === form.value.materialID);
    if (index !== -1) {
      materials.value[index] = { ...form.value };
    }
  }
  isFormVisible.value = false;
}
</script>

  
  <style scoped>
  .fixed {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
  }
  </style>
  