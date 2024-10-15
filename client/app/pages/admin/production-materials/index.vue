<template>
  <div class="p-6">
    <h1 class="text-2xl font-bold mb-4">Production Materials</h1>

    <!-- Container for Button and Search Bar -->
    <div class="mb-4 flex justify-between items-center">
      <!-- Search Bar -->
      <input
        v-model="searchQuery"
        type="text"
        placeholder="Search..."
        class="p-2 border border-gray-300 rounded w-48"
        @input="searchMaterials"
      />

      <!-- Add Production Button -->
      <button @click="openAddMaterialModal" class="bg-blue-500 text-white p-2 rounded-full">
        <img src="https://img.icons8.com/ios-filled/24/FFFFFF/plus-math.png" alt="Add Icon" />
      </button>
    </div>

    <!-- Filters Dropdown -->
    <div class="mb-4">
      <select v-model="selectedStatus" @change="filterByStatus" class="border p-2">
        <option value="">All Statuses</option>
        <option value="Available">Available</option>
        <option value="Pending">Pending</option>
        <option value="Unavailable">Unavailable</option>
      </select>
    </div>

    <!-- Materials Table -->
    <table class="min-w-full border-collapse border">
      <thead>
        <tr class="bg-gray-200">
          <th class="border p-2 text-center cursor-pointer" @click="sort('productionDetailNo')">
            Production Detail No
          </th>
          <th class="border p-2 text-center cursor-pointer" @click="sort('productMaterialID')">
            Product Material ID
          </th>
          <th class="border p-2 text-center cursor-pointer" @click="sort('quantityNeeded')">
            Quantity Needed
          </th>
          <th class="border p-2 text-center">Status</th>
          <th class="border p-2 text-center">Actions</th> <!-- Column for Edit/Delete -->
        </tr>
      </thead>
      <tbody>
        <tr v-for="material in paginatedMaterials" :key="material.id">
          <td class="border p-2 text-center">{{ material.productionDetailNo }}</td>
          <td class="border p-2 text-center">{{ material.productMaterialID }}</td>
          <td class="border p-2 text-center">{{ material.quantityNeeded }}</td>
          <td class="border p-2 text-center">
            <span v-if="material.status === 'Available'">
              <img src="https://img.icons8.com/ios-filled/24/4CAF50/checkmark.png" alt="Available Icon" />
            </span>
            <span v-else-if="material.status === 'Pending'">
              <img src="https://img.icons8.com/ios-filled/24/FFC107/clock.png" alt="Pending Icon" />
            </span>
            <span v-else>
              <img src="https://img.icons8.com/ios-filled/24/FF5252/cancel.png" alt="Unavailable Icon" />
            </span>
          </td>
          <td class="border p-2 text-center">
            <button @click="openEditMaterialModal(material)" class="text-yellow-500">
              <img src="https://img.icons8.com/ios-filled/24/FFC107/edit.png" alt="Edit Icon" />
            </button>
            <button @click="confirmDeleteMaterial(material.id)" class="text-red-500 ml-2">
              <img src="https://img.icons8.com/ios-filled/24/FF5252/trash.png" alt="Delete Icon" />
            </button>
          </td>
        </tr>
      </tbody>
    </table>

    <!-- Pagination Controls -->
    <div class="flex justify-between items-center mt-4">
      <button @click="prevPage" :disabled="currentPage === 1" class="bg-gray-300 px-4 py-2 rounded">
        Previous
      </button>
      <span>
        Page {{ currentPage }} of {{ totalPages }}
      </span>
      <button @click="nextPage" :disabled="currentPage === totalPages" class="bg-gray-300 px-4 py-2 rounded">
        Next
      </button>
    </div>

    <!-- Add Material Modal -->
    <div v-if="isAddModalOpen" class="modal">
      <div class="modal-content">
        <span class="close" @click="isAddModalOpen = false">&times;</span>
        <h2 class="text-lg font-bold mb-2">Add Material</h2>
        <input v-model="newMaterial.productMaterialID" placeholder="Product Material ID" class="border p-2 mb-2 w-full" />
        <input v-model="newMaterial.quantityNeeded" placeholder="Quantity Needed" type="number" class="border p-2 mb-2 w-full" />
        <select v-model="newMaterial.status" class="border p-2 mb-2 w-full">
          <option value="Available">Available</option>
          <option value="Pending">Pending</option>
          <option value="Unavailable">Unavailable</option>
        </select>
        <button @click="addMaterial" class="bg-blue-500 text-white p-2 rounded-full w-full">Add</button>
      </div>
    </div>

    <!-- Edit Material Modal -->
    <div v-if="isEditModalOpen" class="modal">
      <div class="modal-content">
        <span class="close" @click="isEditModalOpen = false">&times;</span>
        <h2 class="text-lg font-bold mb-2">Edit Material</h2>
        <input v-model="selectedMaterial.productMaterialID" placeholder="Product Material ID" class="border p-2 mb-2 w-full" />
        <input v-model="selectedMaterial.quantityNeeded" placeholder="Quantity Needed" type="number" class="border p-2 mb-2 w-full" />
        <select v-model="selectedMaterial.status" class="border p-2 mb-2 w-full">
          <option value="Available">Available</option>
          <option value="Pending">Pending</option>
          <option value="Unavailable">Unavailable</option>
        </select>
        <button @click="editMaterial" class="bg-blue-500 text-white p-2 rounded-full w-full">Save</button>
      </div>
    </div>

    <!-- Confirm Delete Modal -->
    <div v-if="isDeleteModalOpen" class="modal">
      <div class="modal-content">
        <span class="close" @click="isDeleteModalOpen = false">&times;</span>
        <h2 class="text-lg font-bold mb-2">Confirm Deletion</h2>
        <p>Are you sure you want to delete this material?</p>
        <button @click="deleteMaterial" class="bg-red-500 text-white p-2 rounded-full w-full">Delete</button>
        <button @click="isDeleteModalOpen = false" class="bg-gray-300 p-2 rounded-full w-full">Cancel</button>
      </div>
    </div>
  </div>
</template>

<script>
import auth from "../../../../middleware/auth";
// This page requires authentication
definePageMeta({
  middleware: [auth],
});

import { ref, computed } from "vue";

export default {
  data() {
    return {
      searchQuery: '',
      selectedStatus: '',
      currentPage: 1,
      itemsPerPage: 10, // Define how many items to show per page
      materials: [
        { id: 1, productionDetailNo: 'PD-001', productMaterialID: 'MAT-101', quantityNeeded: 100, status: 'Available' },
        { id: 2, productionDetailNo: 'PD-002', productMaterialID: 'MAT-102', quantityNeeded: 50, status: 'Pending' },
        { id: 3, productionDetailNo: 'PD-003', productMaterialID: 'MAT-103', quantityNeeded: 30, status: 'Unavailable' },
        // Add more items as needed
      ],
      newMaterial: { productMaterialID: '', quantityNeeded: '', status: 'Available' },
      selectedMaterial: null,
      materialToDelete: null,
      isAddModalOpen: false,
      isEditModalOpen: false,
      isDeleteModalOpen: false,
    };
  },
  computed: {
    paginatedMaterials() {
      const start = (this.currentPage - 1) * this.itemsPerPage;
      const end = start + this.itemsPerPage;
      return this.filteredMaterials.slice(start, end);
    },
    totalPages() {
      return Math.ceil(this.filteredMaterials.length / this.itemsPerPage);
    },
    filteredMaterials() {
      let filtered = this.materials;
      if (this.searchQuery) {
        filtered = filtered.filter(material =>
          material.productMaterialID.toLowerCase().includes(this.searchQuery.toLowerCase())
        );
      }
      if (this.selectedStatus) {
        filtered = filtered.filter(material => material.status === this.selectedStatus);
      }
      return filtered;
    },
  },
  methods: {
    searchMaterials() {
      this.currentPage = 1; // Reset to the first page on search
    },
    filterByStatus() {
      this.currentPage = 1; // Reset to the first page on filter change
    },
    sort(column) {
      const order = this.sortOrder[column] = !this.sortOrder[column];
      this.materials.sort((a, b) => (a[column] > b[column] ? (order ? 1 : -1) : order ? -1 : 1));
    },
    openAddMaterialModal() {
      this.isAddModalOpen = true;
    },
    addMaterial() {
      // Add material to the list and reset newMaterial
      this.materials.push({ id: Date.now(), ...this.newMaterial });
      this.newMaterial = { productMaterialID: '', quantityNeeded: '', status: 'Available' };
      this.isAddModalOpen = false;
    },
    openEditMaterialModal(material) {
      this.selectedMaterial = { ...material }; // Create a copy for editing
      this.isEditModalOpen = true;
    },
    editMaterial() {
      // Update material in the list
      const index = this.materials.findIndex(material => material.id === this.selectedMaterial.id);
      if (index !== -1) {
        this.materials.splice(index, 1, this.selectedMaterial);
      }
      this.isEditModalOpen = false;
      this.selectedMaterial = null;
    },
    confirmDeleteMaterial(id) {
      this.materialToDelete = id;
      this.isDeleteModalOpen = true;
    },
    deleteMaterial() {
      this.materials = this.materials.filter(material => material.id !== this.materialToDelete);
      this.isDeleteModalOpen = false;
      this.materialToDelete = null;
    },
    prevPage() {
      if (this.currentPage > 1) this.currentPage--;
    },
    nextPage() {
      if (this.currentPage < this.totalPages) this.currentPage++;
    },
  },
};
</script>

<style>
.modal {
  display: flex;
  position: fixed;
  z-index: 1000;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  justify-content: center;
  align-items: center;
}

.modal-content {
  background-color: white;
  padding: 20px;
  border-radius: 8px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
  position: relative;
  width: 400px; 
}

.close {
  position: absolute;
  right: 10px;
  top: 10px;
  cursor: pointer;
  font-size: 24px;
}
</style>
