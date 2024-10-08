<template>
  <div>
    <h2 class="text-2xl font-bold mb-6">Production Materials</h2>

    <div class="search-container">
      <input 
        type="text" 
        v-model="searchQuery" 
        placeholder="Search..." 
        class="search-input" 
      />
    </div>

    <table class="min-w-full border-collapse">
      <thead>
        <tr>
          <th class="border text-center">Production Material No</th>
          <th class="border text-center">Production Details</th>
          <th class="border text-center">Product ID</th>
          <th class="border text-center">Material ID</th>
          <th class="border text-center">Total</th>
          <th class="border text-center">Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="material in filteredMaterials" :key="material.pmNo">
          <td class="border text-center">{{ material.pmNo }}</td>
          <td class="border text-center">{{ material.prodMatNo }}</td>
          <td class="border text-center">{{ material.productId }}</td>
          <td class="border text-center">{{ material.materialId }}</td>
          <td class="border text-center">{{ material.total }}</td>
          <td class="border text-center">
            <button @click="editMaterial(material)" class="btn">
              <i class="fas fa-edit"></i>
            </button>
            <button @click="deleteMaterial(material)" class="btn">
              <i class="fas fa-trash"></i>
            </button>
          </td>
        </tr>
      </tbody>
    </table>

    <pagination 
      :total-items="filteredMaterials.length" 
      :items-per-page="itemsPerPage" 
      @page-changed="onPageChange" 
    />
  </div>
</template>

<script setup>
import auth from '../../../../middleware/auth'
// This page requires authentication
definePageMeta({
  middleware: [auth],
});

import { ref, computed } from 'vue';

const searchQuery = ref('');
const itemsPerPage = 10; // Adjust as needed
const currentPage = ref(1);
const productionMaterials = ref([
  // Sample data
  { pmNo: 1, prodMatNo: 101, productId: 'P001', materialId: 'M001', total: 500 },
  { pmNo: 2, prodMatNo: 102, productId: 'P002', materialId: 'M002', total: 300 },
  // Add more production materials as needed
]);

const filteredMaterials = computed(() => {
  return productionMaterials.value.filter(material =>
    material.productId.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
    material.materialId.toLowerCase().includes(searchQuery.value.toLowerCase())
  );
});

const onPageChange = (newPage) => {
  currentPage.value = newPage;
  // Logic to fetch or filter items based on the new page
};

// Placeholder functions for editing and deleting materials
const editMaterial = (material) => {
  // Logic to edit the material
};

const deleteMaterial = (material) => {
  // Logic to delete the material
};
</script>

<style>
.search-container {
  margin-bottom: 1rem;
}

.search-input {
  padding: 0.5rem;
  border: 1px solid #ccc;
  border-radius: 4px;
}

.btn {
  background: none;
  border: none;
  cursor: pointer;
}

.text-center {
  text-align: center;
}
</style>