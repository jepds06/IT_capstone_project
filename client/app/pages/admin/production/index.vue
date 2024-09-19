<template>
  <!-- Title and Add Button -->
  <div class="flex justify-between items-center mb-4">
    <h1 class="text-xl text-color font-bold">Productions</h1>
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
    title="Production Form"
    :showSave="true"
    @update:isVisible="isFormVisible = $event"
    @save="saveProduction"
  >
    <template v-slot:body>
      <form @submit.prevent="saveProduction">
        <div class="mb-4" v-if="formMode === 'edit'">
          <label for="id" class="block text-sm font-medium text-gray-700">Id</label>
          <input
            v-model="form.productionId"
            type="text"
            id="id"
            class="mt-1 block w-full border border-gray-300 rounded-lg p-2"
            :readonly="formMode === 'edit'"
          />
        </div>
        <div class="mb-4">
          <label for="createdBy" class="block text-sm font-medium text-gray-700">Created By</label>
          <input
            v-model="form.createdBy"
            type="text"
            id="createdBy"
            class="mt-1 block w-full border border-gray-300 rounded-lg p-2"
          />
        </div>
        <div class="mb-4">
          <label for="dataEncoded" class="block text-sm font-medium text-gray-700">Data Encoded</label>
          <input
            v-model="form.dataEncoded"
            type="text"
            id="dataEncoded"
            class="mt-1 block w-full border border-gray-300 rounded-lg p-2"
          />
        </div>
        <div class="mb-4">
          <label for="year" class="block text-sm font-medium text-gray-700">Year</label>
          <input
            v-model="form.year"
            type="text"
            id="year"
            class="mt-1 block w-full border border-gray-300 rounded-lg p-2"
          />
        </div>
        <div class="mb-4">
          <label for="month" class="block text-sm font-medium text-gray-700">Month</label>
          <input
            v-model="form.month"
            type="text"
            id="month"
            class="mt-1 block w-full border border-gray-300 rounded-lg p-2"
          />
        </div>
      </form>
    </template>
  </Modal>

  <!-- Productions Table -->
  <table class="min-w-full border border-gray-300 rounded-lg">
    <thead class="bg-gray-100">
      <tr>
        <th class="p-2 border-b text-black text-center">Id</th>
        <th class="p-2 border-b text-black text-center">Created By</th>
        <th class="p-2 border-b text-black text-center">Data Encoded</th>
        <th class="p-2 border-b text-black text-center">Year</th>
        <th class="p-2 border-b text-black text-center">Month</th>
        <th class="p-2 border-b text-black text-center">Actions</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="production in productions" :key="production.productionId">
        <td class="p-2 border-b text-center">{{ production.productionId }}</td>
        <td class="p-2 border-b text-center">{{ production.createdBy }}</td>
        <td class="p-2 border-b text-center">{{ production.dataEncoded }}</td>
        <td class="p-2 border-b text-center">{{ production.year }}</td>
        <td class="p-2 border-b text-center">{{ production.month }}</td>
        <td class="p-2 border-b flex justify-center space-x-2">
          <button
            @click="viewProduction(production)"
            class="text-blue-500 hover:underline"
          >
            <i class="fas fa-eye"></i>
          </button>
          <button
            @click="editProduction(production)"
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

const productions = ref([]);
const isFormVisible = ref(false);
const formMode = ref("add");
const form = ref({
  productionId: "",
  createdBy: "",
  dataEncoded: "",
  year: "",
  month: ""
});

function openForm(mode = "add", production = null) {
  formMode.value = mode;
  if (mode === "edit" && production) {
    form.value = { ...production };
  } else {
    form.value = {
      productionId: "",
      createdBy: "",
      dataEncoded: "",
      year: "",
      month: ""
    };
  }
  isFormVisible.value = true;
}

function closeForm() {
  isFormVisible.value = false;
}

async function saveProduction() {
  try {
    if (formMode.value === "add") {
      const { data } = await apiService.post("/api/productions", form.value);
      productions.value.push(data);
      alert("Production created successfully!");
    } else if (formMode.value === "edit") {
      const index = productions.value.findIndex((prod) => prod.productionId === form.value.productionId);
      if (index !== -1) {
        const { data } = await apiService.put(`/api/productions/${form.value.productionId}`, form.value);
        productions.value[index] = data;
        alert("Production updated successfully!");
      }
    }
    closeForm();
  } catch (error) {
    console.log('error', error);
    alert(`${form.value.productionId} already exists or there's an issue`);
    closeForm();
  }
}

function viewProduction(production) {
  alert(`Viewing production: ${production.productionId}`);
}

function editProduction(production) {
  openForm("edit", production);
}

// Fetch productions from API
const fetchProductions = async () => {
  try {
    const { data } = await apiService.get("/api/productions");
    productions.value = data;
  } catch (error) {
    console.error("Error fetching productions:", error);
  }
};

onMounted(() => {
  fetchProductions();
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
