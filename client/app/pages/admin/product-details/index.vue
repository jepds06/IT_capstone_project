<template>
  <!-- Title and Add Button -->
  <div class="flex justify-between items-center mb-4">
    <h1 class="text-xl text-color font-bold">Product Details</h1>
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
    title="Product Detail Form"
    :showSave="true"
    @update:isVisible="isFormVisible = $event"
    @save="saveProductDetail"
  >
    <template v-slot:body>
      <form @submit.prevent="saveProductDetail">
        <div class="mb-4" v-if="formMode === 'edit'">
          <label for="id" class="block text-sm font-medium text-gray-700">Id</label>
          <input
            v-model="form.productId"
            type="text"
            id="id"
            class="mt-1 block w-full border border-gray-300 rounded-lg p-2"
            :readonly="formMode === 'edit'"
          />
        </div>
        <div class="mb-4">
          <label for="productionId" class="block text-sm font-medium text-gray-700">Production ID</label>
          <input
            v-model="form.productionId"
            type="text"
            id="productionId"
            class="mt-1 block w-full border border-gray-300 rounded-lg p-2"
          />
        </div>
        <div class="mb-4">
          <label for="qty" class="block text-sm font-medium text-gray-700">Qty</label>
          <input
            v-model="form.qty"
            type="text"
            id="qty"
            class="mt-1 block w-full border border-gray-300 rounded-lg p-2"
          />
        </div>
        <div class="mb-4">
          <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
          <select
            v-model="form.status"
            id="status"
            class="mt-1 block w-full border border-gray-300 rounded-lg p-2"
          >
            <option value="inStock">In Stock</option>
            <option value="outOfStock">Out of Stock</option>
          </select>
        </div>
      </form>
    </template>
  </Modal>

  <!-- Product Details Table -->
  <table class="min-w-full border border-gray-300 rounded-lg">
    <thead class="bg-gray-100">
      <tr>
        <th class="p-2 border-b text-black text-center">Id</th>
        <th class="p-2 border-b text-black text-center">Production ID</th>
        <th class="p-2 border-b text-black text-center">Qty</th>
        <th class="p-2 border-b text-black text-center">Status</th>
        <th class="p-2 border-b text-black text-center">Actions</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="detail in productDetails" :key="detail.productId">
        <td class="p-2 border-b text-center">{{ detail.productId }}</td>
        <td class="p-2 border-b text-center">{{ detail.productionId }}</td>
        <td class="p-2 border-b text-center">{{ detail.qty }}</td>
        <td class="p-2 border-b text-center">{{ detail.status }}</td>
        <td class="p-2 border-b flex justify-center space-x-2">
          <button
            @click="viewProductDetail(detail)"
            class="text-blue-500 hover:underline"
          >
            <i class="fas fa-eye"></i>
          </button>
          <button
            @click="editProductDetail(detail)"
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
import { ref, onMounted } from "vue";
import Modal from "~/components/Modal.vue"; // Adjust the path if needed
import { apiService } from "~/api/apiService";

const productDetails = ref([]);
const isFormVisible = ref(false);
const formMode = ref("add");
const form = ref({
  productId: "",
  productionId: "",
  qty: "",
  status: "inStock" // Default status
});

function openForm(mode = "add", detail = null) {
  formMode.value = mode;
  if (mode === "edit" && detail) {
    form.value = { ...detail };
  } else {
    form.value = {
      productId: "",
      productionId: "",
      qty: "",
      status: "inStock"
    };
  }
  isFormVisible.value = true;
}

function closeForm() {
  isFormVisible.value = false;
}

async function saveProductDetail() {
  try {
    if (formMode.value === "add") {
      const { data } = await apiService.post("/api/product-details", form.value);
      productDetails.value.push(data);
      alert("Product detail created successfully!");
    } else if (formMode.value === "edit") {
      const index = productDetails.value.findIndex((detail) => detail.productId === form.value.productId);
      if (index !== -1) {
        const { data } = await apiService.put(`/api/product-details/${form.value.productId}`, form.value);
        productDetails.value[index] = data;
        alert("Product detail updated successfully!");
      }
    }
    closeForm();
  } catch (error) {
    console.log('error', error);
    alert(`${form.value.productId} already exists or there's an issue`);
    closeForm();
  }
}

function viewProductDetail(detail) {
  alert(`Viewing product detail: ${detail.productId}`);
}

function editProductDetail(detail) {
  openForm("edit", detail);
}

// Fetch product details from API
const fetchProductDetails = async () => {
  try {
    const { data } = await apiService.get("/api/product-details");
    productDetails.value = data;
  } catch (error) {
    console.error("Error fetching product details:", error);
  }
};

onMounted(() => {
  fetchProductDetails();
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
