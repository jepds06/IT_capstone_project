<template>
  <div class="p-6">
    <h1 class="text-2xl font-bold mb-6">User Permissions</h1>

    <!-- Search Input and Add Button -->
    <div class="mb-4 flex justify-between items-center">
      <div class="relative">
        <input
          v-model="searchQuery"
          type="text"
          placeholder="Search by Module or Privilege..."
          class="border p-2 w-full rounded-lg"
        />
      </div>
      <button @click="showAddModal" class="bg-blue-500 text-white px-4 py-2 rounded">
        Add Permission
      </button>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
      <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
        <thead class="bg-gray-200">
          <tr>
            <th class="py-2 px-4">Privilege Name</th>
            <th class="py-2 px-4">ID</th>
            <th class="py-2 px-4">Modules</th>
            <th class="py-2 px-4">Create</th>
            <th class="py-2 px-4">Update</th>
            <th class="py-2 px-4">Cancel</th>
            <th class="py-2 px-4">View</th>
            <th class="py-2 px-4">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(permission, index) in paginatedPermissions" :key="index" class="text-center">
            <td class="border-t px-4 py-2">{{ permission.priv_n }}</td>
            <td class="border-t px-4 py-2">{{ permission.id }}</td>
            <td class="border-t px-4 py-2">{{ permission.module }}</td>
            <td class="border-t px-4 py-2">
              <input type="checkbox" v-model="permission.canCreate" class="form-checkbox" />
            </td>
            <td class="border-t px-4 py-2">
              <input type="checkbox" v-model="permission.canUpdate" class="form-checkbox" />
            </td>
            <td class="border-t px-4 py-2">
              <input type="checkbox" v-model="permission.canCancel" class="form-checkbox" />
            </td>
            <td class="border-t px-4 py-2">
              <input type="checkbox" v-model="permission.canView" class="form-checkbox" />
            </td>
            <td class="border-t px-4 py-2">
              <span class="cursor-pointer" @click="viewPermission(permission)">👁️</span>
              <span class="cursor-pointer ml-2" @click="editPermission(permission)">✏️</span>
              <span class="cursor-pointer text-red-600 ml-2" @click="deletePermission(permission)">🗑️</span>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4 flex justify-between">
      <button
        @click="prevPage"
        :disabled="currentPage === 1"
        class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400"
      >
        Previous
      </button>
      <span>Page {{ currentPage }} of {{ totalPages }}</span>
      <button
        @click="nextPage"
        :disabled="currentPage === totalPages"
        class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400"
      >
        Next
      </button>
    </div>

    <!-- Modal for Adding/Editing Permission -->
    <div v-if="showModal" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50">
      <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-lg font-semibold mb-4">{{ isEditing ? 'Edit Permission' : 'Add New Permission' }}</h2>
        <form @submit.prevent="handleSubmit">
          <div class="mb-4">
            <label for="privilegeName" class="block text-sm font-medium text-gray-700">Privilege Name:</label>
            <input
              v-model="newPermission.priv_n"
              type="text"
              id="privilegeName"
              name="privilegeName"
              class="border p-2 w-full rounded-lg"
              required
            />
          </div>
          <div class="mb-4">
            <label for="moduleId" class="block text-sm font-medium text-gray-700">Module ID:</label>
            <input
              v-model="newPermission.module"
              type="text"
              id="moduleId"
              name="moduleId"
              class="border p-2 w-full rounded-lg"
              required
            />
          </div>
          <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Permissions:</label>
            <div class="flex items-center space-x-4">
              <label>
                <input type="checkbox" v-model="newPermission.canCreate" class="form-checkbox" />
                <span class="ml-2">Create</span>
              </label>
              <label>
                <input type="checkbox" v-model="newPermission.canUpdate" class="form-checkbox" />
                <span class="ml-2">Update</span>
              </label>
              <label>
                <input type="checkbox" v-model="newPermission.canCancel" class="form-checkbox" />
                <span class="ml-2">Cancel</span>
              </label>
              <label>
                <input type="checkbox" v-model="newPermission.canView" class="form-checkbox" />
                <span class="ml-2">View</span>
              </label>
            </div>
          </div>
          <div class="flex justify-end">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">
              {{ isEditing ? 'Update' : 'Add' }}
            </button>
            <button @click="closeModal" class="ml-2 bg-gray-300 text-gray-700 px-4 py-2 rounded">
              Cancel
            </button>
          </div>
        </form>
      </div>
    </div>
    <div v-if="showViewModal" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50">
      <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-lg font-semibold mb-4">View Permission</h2>
        <p><strong>Privilege Name:</strong> {{ selectedPermission.priv_n }}</p>
        <p><strong>Module:</strong> {{ selectedPermission.module }}</p>
        <p><strong>Create:</strong> {{ selectedPermission.canCreate ? 'Yes' : 'No' }}</p>
        <p><strong>Update:</strong> {{ selectedPermission.canUpdate ? 'Yes' : 'No' }}</p>
        <p><strong>Cancel:</strong> {{ selectedPermission.canCancel ? 'Yes' : 'No' }}</p>
        <p><strong>View:</strong> {{ selectedPermission.canView ? 'Yes' : 'No' }}</p>
        <div class="flex justify-end">
          <button @click="closeViewModal" class="ml-2 bg-gray-300 text-gray-700 px-4 py-2 rounded">
            Close
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      searchQuery: '',
      currentPage: 1,
      itemsPerPage: 5,
      permissions: [
        { id: 1, priv_n: 'Edit User', module: 'User Management', canCreate: false, canUpdate: true, canCancel: false, canView: true, isActive: true },
        { id: 2, priv_n: 'Delete User', module: 'User Management', canCreate: false, canUpdate: false, canCancel: true, canView: true, isActive: false },
      ],
      showModal: false,
      showViewModal: false, // New flag for the View Permission modal
      isEditing: false, // State to track if we're editing
      newPermission: {
        priv_n: '',
        module: '',
        canCreate: false,
        canUpdate: false,
        canCancel: false,
        canView: false,
      },
      selectedPermission: null, // State to store the selected permission for viewing or editing
    };
  },
  computed: {
    filteredPermissions() {
      return this.permissions.filter(permission => 
        permission.priv_n.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
        permission.module.toLowerCase().includes(this.searchQuery.toLowerCase())
      );
    },
    paginatedPermissions() {
      const start = (this.currentPage - 1) * this.itemsPerPage;
      const end = start + this.itemsPerPage;
      return this.filteredPermissions.slice(start, end);
    },
    totalPages() {
      return Math.ceil(this.filteredPermissions.length / this.itemsPerPage);
    },
  },
  methods: {
    prevPage() {
      if (this.currentPage > 1) this.currentPage--;
    },
    nextPage() {
      if (this.currentPage < this.totalPages) this.currentPage++;
    },
    showAddModal() {
      this.isEditing = false;
      this.newPermission = {
        priv_n: '',
        module: '',
        canCreate: false,
        canUpdate: false,
        canCancel: false,
        canView: false,
      };
      this.showModal = true;
    },
    handleSubmit() {
      if (this.isEditing) {
        // Update existing permission
        const index = this.permissions.findIndex(p => p.id === this.selectedPermission.id);
        if (index !== -1) {
          this.permissions.splice(index, 1, { ...this.selectedPermission, ...this.newPermission });
        }
      } else {
        // Add new permission
        const newId = this.permissions.length ? Math.max(this.permissions.map(p => p.id)) + 1 : 1;
        this.permissions.push({ id: newId, ...this.newPermission });
      }
      this.closeModal();
    },
    editPermission(permission) {
      this.isEditing = true;
      this.selectedPermission = { ...permission }; // Store selected permission
      this.newPermission = { ...permission }; // Fill form with selected permission details
      this.showModal = true;
    },
    viewPermission(permission) {
      this.selectedPermission = { ...permission }; // Store selected permission for viewing
      this.showViewModal = true; // Show view modal
    },
    deletePermission(permission) {
      const index = this.permissions.findIndex(p => p.id === permission.id);
      if (index !== -1) {
        this.permissions.splice(index, 1);
      }
    },
    closeModal() {
      this.showModal = false;
      this.newPermission = { priv_n: '', module: '', canCreate: false, canUpdate: false, canCancel: false, canView: false };
    },
    closeViewModal() {
      this.showViewModal = false;
      this.selectedPermission = null; // Reset selected permission
    },
  },
};
</script>

<style scoped>

</style>
