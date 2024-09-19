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
          <label for="id" class="block text-sm font-medium text-gray-700">Id</label>
          <input
            v-model="form.prodCatID"
            type="text"
            id="id"
            class="mt-1 block w-full border border-gray-300 rounded-lg p-2"
            :readonly="formMode === 'edit'"
          />
        </div>
        <div class="mb-4">
          <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
          <input
            v-model="form.description"
            type="text"
            id="description"
            class="mt-1 block w-full border border-gray-300 rounded-lg p-2"
          />
        </div>
      </form>
    </template>
  </Modal>

  <!-- Notification Modal -->
  <Modal
    v-if="notification.visible"
    :isVisible="notification.visible"
    title="Notification"
    @update:isVisible="notification.visible = $event"
  >
    <template v-slot:body>
      <p>{{ notification.message }}</p>
    </template>
  </Modal>

  <!-- Product Categories Table -->
  <table class="min-w-full border border-gray-300 rounded-lg">
    <thead class="bg-gray-100">
      <tr>
        <th class="p-2 border-b text-black text-center">Id</th>
        <th class="p-2 border-b text-black text-center">Description</th>
        <th class="p-2 border-b text-black text-center">Actions</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="category in paginatedCategories" :key="category.prodCatID">
        <td class="p-2 border-b text-center">{{ category.prodCatID }}</td>
        <td class="p-2 border-b text-center">{{ category.description }}</td>
        
        <td class="p-2 border-b flex justify-center space-x-2">
          <button @click="viewCategory(category)" class="text-blue-500 hover:underline">
            <i class="fas fa-eye"></i>
          </button>
          <button @click="editCategory(category)" class="text-yellow-500 hover:underline">
            <i class="fas fa-edit"></i>
          </button>
        </td>
      </tr>
    </tbody>
  </table>

  <!-- Pagination Controls -->
  <div class="flex justify-between items-center mt-4">
    <button
      @click="prevPage"
      :disabled="currentPage === 1"
      class="bg-gray-300 text-gray-700 px-4 py-2 rounded"
    >
      Previous
    </button>
    <span>Page {{ currentPage }} of {{ totalPages }}</span>
    <button
      @click="nextPage"
      :disabled="currentPage === totalPages"
      class="bg-gray-300 text-gray-700 px-4 py-2 rounded"
    >
      Next
    </button>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from "vue";
import Modal from "~/components/Modal.vue"; // Adjust the path if needed
import { apiService } from "~/api/apiService";

const categories = ref([]);
const isFormVisible = ref(false);
const formMode = ref("add");
const form = ref({
  prodCatID: "",
  description: "",
});
const currentPage = ref(1);
const itemsPerPage = 10;
const totalPages = computed(() => Math.ceil(categories.value.length / itemsPerPage));
const paginatedCategories = computed(() => {
  const start = (currentPage.value - 1) * itemsPerPage;
  return categories.value.slice(start, start + itemsPerPage);
});
const notification = ref({ visible: false, message: "" });

function openForm(mode = "add", category = null) {
  formMode.value = mode;
  if (mode === "edit" && category) {
    form.value = { ...category };
  } else {
    form.value = { description: "" };
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
      showNotification("Product Category created successfully!");
    } else if (formMode.value === "edit") {
      const index = categories.value.findIndex((cat) => cat.prodCatID === form.value.prodCatID);
      if (index !== -1) {
        const { data } = await apiService.put(`/api/productCategories/${form.value.prodCatID}`, form.value);
        categories.value[index] = data;
        showNotification("Product Category edited successfully!");
      }
    }
    closeForm();
  } catch (error) {
    showNotification("An error occurred while saving the category.");
    console.error("error", error);
  }
}

function viewCategory(category) {
  showNotification(`Viewing category: ${category.description}`);
}

function editCategory(category) {
  openForm("edit", category);
}

function showNotification(message) {
  notification.value.message = message;
  notification.value.visible = true;
  setTimeout(() => {
    notification.value.visible = false;
  }, 3000); // Adjust the duration (in milliseconds) as needed
}

function prevPage() {
  if (currentPage.value > 1) {
    currentPage.value--;
  }
}

function nextPage() {
  if (currentPage.value < totalPages.value) {
    currentPage.value++;
  }
}

// Fetch data on mounted
onMounted(async () => {
  try {
    const { data } = await apiService.get("/api/productCategories");
    categories.value = data;
  } catch (error) {
    console.error("Error fetching data:", error);
  }
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

.modal {
  max-width: 800px;
  margin: 1.5rem auto;
}
</style>

