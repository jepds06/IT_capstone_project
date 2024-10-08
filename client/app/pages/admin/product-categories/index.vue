<template>
  <!-- Title and Add Button -->
  <div class="flex justify-between items-center mb-4">
    <h1 class="text-xl text-color font-bold">Product Categories</h1>
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
    title="Product Category Form"
    :showSave="true"
    @update:isVisible="isFormVisible = $event"
    @save="saveCategory"
  >
    <template v-slot:body>
      <form @submit.prevent="saveCategory">
        <div class="mb-4" v-if="formMode === 'edit'">
          <label for="id" class="block text-sm font-medium text-gray-700"
            >Id</label
          >
          <input
            v-model="form.prodCatID"
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

  <!-- Product Categories Table -->
  <table class="min-w-full border border-gray-300 rounded-lg">
    <thead class="bg-gray-100">
      <tr>
        <th class="p-2 border-b text-black text-center">Id</th>
        <th class="p-2 border-b text-black text-center">Description</th>
        <!-- <th class="p-2 border-b text-center">Status</th> -->
        <th class="p-2 border-b text-black text-center">Actions</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="category in categories" :key="category.prodCatID">
        <td class="p-2 border-b text-center">{{ category.prodCatID }}</td>
        <td class="p-2 border-b text-center">{{ category.description }}</td>
        <!-- <td class="p-2 border-b text-center">
          <i
            v-if="category.status === 'active'"
            class="fas fa-check text-green-500"
          ></i>
          <i v-else class="fas fa-times text-red-500"></i>
        </td> -->
        <td class="p-2 border-b flex justify-center space-x-2">
          <button
            @click="viewCategory(category)"
            class="text-blue-500 hover:underline"
          > 
            <i class="fas fa-eye"></i>
          </button>
          <button
            @click="editCategory(category)"
            class="text-yellow-500 hover:underline"
          >
            <i class="fas fa-edit"></i>
          </button>
        </td>
      </tr>
    </tbody>
  </table>
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

const categories = ref([]);
const isFormVisible = ref(false);
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
    form.value = { description: "",};
  }
  isFormVisible.value = true;
}

function closeForm() {
  isFormVisible.value = false;
}

async function saveCategory() {
  try {
    if (formMode.value === "add") {
    const { data } = await apiService.post("/api/productCategories", form.value);
    categories.value.push(data);
    alert("Product Category created successfully!");
  } else if (formMode.value === "edit") {
    const index = categories.value.findIndex((cat) => cat.prodCatID === form.value.prodCatID);
    if (index !== -1) {
    const { data } = await apiService.put(`/api/productCategories/${form.value.prodCatID}`, form.value);
    categories.value[index] = data;
    alert("Product Category edited successfully!");
    }
  }
  closeForm();
  } catch (error) {
    console.log('error', error)
    closeForm();
  }
 
}

function viewCategory(category) {
  alert(`Viewing category: ${category.description}`);
}

function editCategory(category) {
  openForm("edit", category);
}

// Define an async function to fetch data
const fetchData = async () => {
  try {
    // Call the get method from ApiService
    const { data } = await apiService.get("/api/productCategories"); // Replace '/endpoint' with your actual API endpoint
    categories.value = data
  } catch (error) {
    console.error("Error fetching data:", error);
  }
};

onMounted(() => {
  fetchData()
})

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
