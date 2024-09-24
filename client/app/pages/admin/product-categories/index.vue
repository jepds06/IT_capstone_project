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
import { ref, onMounted } from "vue";
import Modal from "~/components/Modal.vue"; // Adjust the path if needed
import { apiService } from "~/api/apiService";

const orders = ref([]);
const isFormVisible = ref(false);
const formMode = ref("add");
const form = ref({
  orderID: "",
  customerName: "",
  orderDate: "",
  status: "Pending", // Default status
});

function openForm(mode = "add", order = null) {
  formMode.value = mode;
  if (mode === "edit" && order) {
    form.value = { ...order };
  } else {
    form.value = {
      orderID: "",
      customerName: "",
      orderDate: "",
      status: "Pending",
    };
  }
  isFormVisible.value = true;
}

function closeForm() {
  isFormVisible.value = false;
}

async function saveOrder() {
  try {
    if (formMode.value === "add") {
      const { data } = await apiService.post("/api/orders", form.value);
      orders.value.push(data);
      alert("Order created successfully!");
    } else if (formMode.value === "edit") {
      const index = orders.value.findIndex((ord) => ord.orderID === form.value.orderID);
      if (index !== -1) {
        const { data } = await apiService.put(`/api/orders/${form.value.orderID}`, form.value);
        orders.value[index] = data;
        alert("Order updated successfully!");
      }
    }
    closeForm();
  } catch (error) {
    console.log('error', error);
    alert(`${form.value.orderID} already exists or there's an issue`);
    closeForm();
  }
}

function viewOrder(order) {
  alert(`Viewing order: ${order.orderID} - ${order.customerName}`);
}

function editOrder(order) {
  openForm("edit", order);
}

// Fetch orders from API
const fetchData = async () => {
  try {
    const { data } = await apiService.get("/api/orders");
    orders.value = data;
  } catch (error) {
    console.error("Error fetching orders:", error);
  }
};

onMounted(() => {
  fetchData();
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
