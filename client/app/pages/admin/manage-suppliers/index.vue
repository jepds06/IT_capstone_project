<template>
    <div class="p-6">
      <!-- Title and Add Supplier Button -->
      <div class="flex justify-between items-center mb-4">
        <h1 class="text-xl font-bold">Manage Suppliers</h1>
        <button @click="openSupplierForm" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
          Add Supplier
        </button>
      </div>
  
      <!-- Suppliers Table -->
      <table class="min-w-full border border-gray-300 rounded-lg">
        <thead class="bg-gray-100">
          <tr>
            <th class="p-2 border-b text-center">Supplier Id</th>
            <th class="p-2 border-b text-center">Name</th>
            <th class="p-2 border-b text-center">Contact</th>
            <th class="p-2 border-b text-center">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="supplier in suppliers" :key="supplier.id">
            <td class="p-2 border-b text-center">{{ supplier.id }}</td>
            <td class="p-2 border-b text-center">{{ supplier.name }}</td>
            <td class="p-2 border-b text-center">{{ supplier.contact }}</td>
            <td class="p-2 border-b text-center">
              <button @click="viewSupplier(supplier)" class="text-blue-500 hover:underline">
                <i class="fas fa-eye"></i>
              </button>
              <button @click="editSupplier(supplier)" class="text-yellow-500 hover:underline">
                <i class="fas fa-edit"></i>
              </button>
              <button @click="viewSupplierMaterials(supplier)" class="text-green-500 hover:underline">
                <i class="fas fa-cubes"></i> <!-- Materials Icon -->
              </button>
            </td>
          </tr>
        </tbody>
      </table>
  
      <!-- Supplier Materials Modal -->
      <div v-if="showSupplierMaterialsModal" class="fixed inset-0 z-50 flex items-center justify-center bg-gray-800 bg-opacity-75">
        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-4xl">
          <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold">Supplier Materials</h2>
            <button @click="closeSupplierMaterialsModal" class="text-gray-600 hover:text-gray-900">&times;</button>
          </div>
  
          <!-- Supplier Info View Table (Read-Only) -->
          <table class="min-w-full border border-gray-300 rounded-lg mb-4">
            <thead class="bg-gray-200">
              <tr>
                <th class="p-2 border-b text-center">Supplier ID</th>
                <th class="p-2 border-b text-center">Name</th>
                <th class="p-2 border-b text-center">Contact</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="p-2 border-b text-center">{{ selectedSupplier.id }}</td>
                <td class="p-2 border-b text-center">{{ selectedSupplier.name }}</td>
                <td class="p-2 border-b text-center">{{ selectedSupplier.contact }}</td>
              </tr>
            </tbody>
          </table>
  
          <!-- Supplier Materials Table -->
          <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold">Materials</h3>
            <button @click="openMaterialForm" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
              Add Material
            </button>
          </div>
  
          <table class="min-w-full border border-gray-300 rounded-lg">
            <thead class="bg-gray-100">
              <tr>
                <th class="p-2 border-b text-center">Material ID</th>
                <th class="p-2 border-b text-center">Name</th>
                <th class="p-2 border-b text-center">Specification</th>
                <th class="p-2 border-b text-center">Quantity</th>
                <th class="p-2 border-b text-center">Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="material in selectedSupplier.materials" :key="material.id">
                <td class="p-2 border-b text-center">{{ material.id }}</td>
                <td class="p-2 border-b text-center">{{ material.name }}</td>
                <td class="p-2 border-b text-center">{{ material.specification }}</td>
                <td class="p-2 border-b text-center">{{ material.quantity }}</td>
                <td class="p-2 border-b text-center">
                  <button @click="toggleMaterialStatus(material)" class="text-green-500 hover:underline">
                    <i v-if="material.isActive" class="fas fa-check"></i>
                    <i v-else class="fas fa-times"></i>
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref } from 'vue';
  
  // Data
  const suppliers = ref([
    { id: '1', name: 'Supplier A', contact: '123-456-7890', materials: [] },

  ]);
  
  const selectedSupplier = ref(null);
  const showSupplierMaterialsModal = ref(false);
  
 
  function openSupplierForm() {
    
  }
  
  function viewSupplier(supplier) {
    
  }
  
  function editSupplier(supplier) {
    
  }
  
  function viewSupplierMaterials(supplier) {
    selectedSupplier.value = supplier;
    showSupplierMaterialsModal.value = true;
  }
  
  function closeSupplierMaterialsModal() {
    showSupplierMaterialsModal.value = false;
  }
  
  function openMaterialForm() {
    
  }
  
  function toggleMaterialStatus(material) {
    material.isActive = !material.isActive;
  }
  </script>
  