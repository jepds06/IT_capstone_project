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
              <font-awesome-icon v-if="permission.isActive" icon="check-circle" class="text-green-600 cursor-pointer" @click="toggleActive(permission)" />
              <font-awesome-icon v-else icon="times-circle" class="text-red-600 cursor-pointer" @click="toggleActive(permission)" />
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

    <!-- Modal for Adding Permission -->
    <div v-if="showModal" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50">
      <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-lg font-semibold mb-4">Add New Permission</h2>
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
              Add
            </button>
            <button @click="closeModal" class="ml-2 bg-gray-300 text-gray-700 px-4 py-2 rounded">
              Cancel
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import auth from '../../../../middleware/auth'
// This page requires authentication
definePageMeta({
  middleware: [auth],
});

export default {
  data() {
    return {
      searchQuery: '', // For the search input
      currentPage: 1, // For pagination
      itemsPerPage: 5, // Number of rows per page
      permissions: [
        {
          priv_n: 'Admin',
          id: 1,
          module: 'User Management',
          canCreate: true,
          canUpdate: true,
          canCancel: false,
          canView: true,
          isActive: true,
        },
        {
          priv_n: 'Editor',
          id: 2,
          module: 'Quotation Management',
          canCreate: true,
          canUpdate: false,
          canCancel: false,
          canView: true,
          isActive: true,
        },
        // Add more data here
        {
          priv_n: 'User',
          id: 3,
          module: 'Order Management',
          canCreate: false,
          canUpdate: true,
          canCancel: false,
          canView: true,
          isActive: false,
        },
        // Add more sample data here
      ],
      showModal: false,
      newPermission: {
        priv_n: '',
        module: '',
        canCreate: false,
        canUpdate: false,
        canCancel: false,
        canView: false,
      },
    };
  },
  computed: {
    // Filter permissions based on the search query
    filteredPermissions() {
      return this.permissions.filter((permission) => {
        const search = this.searchQuery.toLowerCase();
        return (
          permission.priv_n.toLowerCase().includes(search) ||
          permission.module.toLowerCase().includes(search)
        );
      });
    },
    // Get the current page of permissions
    paginatedPermissions() {
      const start = (this.currentPage - 1) * this.itemsPerPage;
      const end = start + this.itemsPerPage;
      return this.filteredPermissions.slice(start, end);
    },
    // Calculate total pages
    totalPages() {
      return Math.ceil(this.filteredPermissions.length / this.itemsPerPage);
    },
  },
  methods: {
    nextPage() {
      if (this.currentPage < this.totalPages) {
        this.currentPage++;
      }
    },
    prevPage() {
      if (this.currentPage > 1) {
        this.currentPage--;
      }
    },
    showAddModal() {
      this.showModal = true;
    },
    closeModal() {
      this.showModal = false;
    },
    handleSubmit() {
      // Handle form submission to add new permission
      this.permissions.push({ ...this.newPermission, isActive: true }); // Set isActive to true for new permission
      this.newPermission = {
        priv_n: '',
        module: '',
        canCreate: false,
        canUpdate: false,
        canCancel: false,
        canView: false,
      };
      this.showModal = false; // Close modal after submission
    },
    toggleActive(permission) {
      permission.isActive = !permission.isActive; // Toggle isActive property
    },
  },
};
</script>

<style scoped>

</style>
