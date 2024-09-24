<template>
    <div class="p-6">
      <h1 class="text-2xl font-bold mb-6">User Permissions</h1>
  
      <!-- Search Input -->
      <div class="mb-4">
        <input
          v-model="searchQuery"
          type="text"
          placeholder="Search by Module or Privilege..."
          class="border p-2 w-full rounded-lg"
        />
      </div>
  
      <!-- Table -->
      <div class="overflow-x-auto">
        <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
          <thead class="bg-gray-200">
            <tr>
              <th class="py-2 px-4">Priv_N</th>
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
                <button @click="editPermission(permission)" class="text-blue-600">
                <font-awesome-icon :icon="faEdit" />
              </button>
              <button @click="deletePermission(permission)" class="text-red-600">
                <font-awesome-icon :icon="faTrash" />
              </button>
              <button @click="viewPermission(permission)" class="text-green-600">
                <font-awesome-icon :icon="faEye" />
              </button>
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
    </div>
  </template>
  
  <script>
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
          },
          {
            priv_n: 'Editor',
            id: 2,
            module: 'Quotation Management',
            canCreate: true,
            canUpdate: false,
            canCancel: false,
            canView: true,
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
          },
          // Add more sample data here
        ],
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
    },
  };
  </script>
  
  <style scoped>
  
  </style>
  