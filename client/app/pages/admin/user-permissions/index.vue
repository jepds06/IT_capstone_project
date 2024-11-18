<template>
  <div class="m-8">
    <h1 class="text-2xl font-extrabold mb-6">User Permissions</h1>

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
      <button
        @click="showAddModal"
        class="bg-blue-500 text-white px-4 py-2 rounded"
      >
        Add Permission
      </button>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
      <table class="min-w-full bg-white shadow-md rounded-lg border border-gray-300">
        <thead class="bg-gray-200">
          <tr>
            <th class="py-2 px-4 border-b border-gray-300">User</th>
            <th class="py-2 px-4 border-b border-gray-300">Modules</th>
            <th class="py-2 px-4 border-b border-gray-300">Create</th>
            <th class="py-2 px-4 border-b border-gray-300">Update</th>
            <th class="py-2 px-4 border-b border-gray-300">Cancel</th>
            <th class="py-2 px-4 border-b border-gray-300">View</th>
            <th class="py-2 px-4 border-b border-gray-300">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="(permission, index) in paginatedPermissions"
            :key="index"
            class="text-center"
          >
            <td class="border-t border-b border-gray-300 px-4 py-2" v-if="index === paginatedPermissions.findIndex(p => p.userID === permission.userID)" :rowspan="paginatedPermissions?.filter((per) => per.userID === permission.userID).length">
              {{ getUserName(permission.userID) }}
            </td>
            <td class="border-t border-b border-gray-300 px-4 py-2">
              {{ getModuleName(permission.moduleID) }}
            </td>
            <td class="border-t border-b border-gray-300 px-4 py-2">
              <input
                type="checkbox"
                :checked="permission.create === 1 ? true : false"
                class="form-checkbox"
                :disabled="true"
              />
            </td>
            <td class="border-t border-b border-gray-300 px-4 py-2">
              <input
                type="checkbox"
                :checked="permission.update === 1 ? true : false"
                class="form-checkbox"
                :disabled="true"
              />
            </td>
            <td class="border-t border-b border-gray-300 px-4 py-2">
              <input
                type="checkbox"
                :checked="permission.cancel === 1 ? true : false"
                class="form-checkbox"
                :disabled="true"
              />
            </td>
            <td class="border-t border-b border-gray-300 px-4 py-2">
              <input
                type="checkbox"
                :checked="permission.view === 1 ? true : false"
                class="form-checkbox"
                :disabled="true"
              />
            </td>
            <td class="border-t border-b border-gray-300 px-4 py-2">
              <span class="cursor-pointer" @click="viewPermission(permission)">👁️</span>
              <span class="cursor-pointer ml-2" @click="editPermission(permission)">✏️</span>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    

    <!-- Pagination -->
    <div class="mt-4 flex text-white justify-between">
      <button
        @click="prevPage"
        :disabled="currentPage === 1"
        class="px-4 py-2 bg-red-600 rounded hover:bg-red-500"
      >
        Previous
      </button>
      <span>Page {{ currentPage }} of {{ totalPages }}</span>
      <button
        @click="nextPage"
        :disabled="currentPage === totalPages"
        class="px-4 py-2 bg-green-600 rounded hover:bg-green-500"
      >
        Next
      </button>
    </div>

    <!-- Modal for Adding Permission -->
    <div
      v-if="showModal"
      class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50"
    >
      <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-lg font-semibold mb-4">
          {{ isEditing ? "Edit Permission" : "Add New Permission" }}
        </h2>
        <form @submit.prevent="openConfirmationModal">
          <div class="mb-4">
            <label for="prodCat" class="block text-sm font-medium text-gray-700"
              >User:
            </label>
            <select
              v-model="newPermission.userID"
              id="userID"
              class="mt-1 block w-full border border-gray-300 rounded-lg p-2"
            >
              <option
                v-for="user in users"
                :key="user.userID"
                :value="user.userID"
              >
                {{ `${user.lastName}, ${user.firstName}` }}
              </option>
            </select>
          </div>
          <div class="mb-4">
            <label for="prodCat" class="block text-sm font-medium text-gray-700"
              >Module:
            </label>
            <select
              v-model="newPermission.moduleID"
              id="moduleID"
              class="mt-1 block w-full border border-gray-300 rounded-lg p-2"
            >
              <option
                v-for="module in modules"
                :key="module.moduleID"
                :value="module.moduleID"
              >
                {{ module.moduleName }}
              </option>
            </select>
          </div>
          <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700"
              >Permissions:</label
            >
            <div class="flex items-center space-x-4">
              <label>
                <input
                  type="checkbox"
                  v-model="newPermission.create"
                  class="form-checkbox"
                />
                <span class="ml-2">Create</span>
              </label>
              <label>
                <input
                  type="checkbox"
                  v-model="newPermission.update"
                  class="form-checkbox"
                />
                <span class="ml-2">Update</span>
              </label>
              <label>
                <input
                  type="checkbox"
                  v-model="newPermission.cancel"
                  class="form-checkbox"
                />
                <span class="ml-2">Cancel</span>
              </label>
              <label>
                <input
                  type="checkbox"
                  v-model="newPermission.view"
                  class="form-checkbox"
                />
                <span class="ml-2">View</span>
              </label>
            </div>
          </div>
          <div class="flex justify-end">
            <button
              type="submit"
              class="bg-blue-500 text-white px-4 py-2 rounded"
            >
              {{ isEditing ? "Update" : "Add" }}
            </button>
            <button
              @click="closeModal"
              class="ml-2 bg-gray-300 text-gray-700 px-4 py-2 rounded"
            >
              Cancel
            </button>
          </div>
        </form>
      </div>
    </div>

    <!-- Confirmation Modal User-Permission-->
    <div v-if="isUserPermissionConfirmationVisible" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
      <div class="bg-white p-6 rounded-md w-1/3 shadow-lg">
        <h3 class="text-xl font-bold mb-4 text-black">Are you sure you want to proceed?</h3>
        <div class="flex justify-end mt-4">
          <button class="bg-blue-500 text-white py-1 px-3 rounded-md mr-2" @click="handleSubmit">
            Yes
          </button>
          <button class="text-red-600 py-1 px-3 rounded-md" @click="closeConfirmationModal">
            No
          </button>
        </div>
      </div>
    </div>

    <!-- Success Message for User-Permission Modal -->
  <div v-if="isSuccessUserPermissionVisible" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
    <div class="bg-white p-6 rounded-md w-1/3 shadow-lg">
      <h3 class="text-xl font-bold mb-4 text-green-600">Success!</h3>
      <p class="text-black">User Permission has been {{ isEditing ? 'updated' : 'created' }} successfully!</p>
      <div class="flex justify-end mt-4">
        <button class="bg-blue-500 text-white py-1 px-3 rounded-md" @click="closeSuccessModal">
        OK
        </button>
      </div>
    </div>
  </div>

    <div
      v-if="showViewModal"
      class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50"
    >
      <div class="bg-white p-6 rounded-lg shadow-md">
        <div style="display: flex; justify-content: flex-end">
          <h2 class="text-lg font-semibold">View Permission</h2>
          <UButton
            size="xs"
            color="gray"
            variant="ghost"
            icon="i-heroicons-x-mark-20-solid"
            @click="closeViewModal"
            :ui="{ inline: 'justifiy-end' }"
          />
        </div>
        <p>
          <strong>User:</strong> {{ getUserName(selectedPermission.userID) }}
        </p>
        <p>
          <strong>Module:</strong>
          {{ getModuleName(selectedPermission.moduleID) }}
        </p>
        <p>
          <strong>Create:</strong>
          {{ selectedPermission.create === 1 ? "Yes" : "No" }}
        </p>
        <p>
          <strong>Update:</strong>
          {{ selectedPermission.update === 1 ? "Yes" : "No" }}
        </p>
        <p>
          <strong>Cancel:</strong>
          {{ selectedPermission.cancel === 1 ? "Yes" : "No" }}
        </p>
        <p>
          <strong>View:</strong>
          {{ selectedPermission.view === 1 ? "Yes" : "No" }}
        </p>
      </div>
    </div>
  </div>
</template>

<script>
import { apiService } from "~/api/apiService";
import auth from "../../../../middleware/auth";
// This page requires authentication
definePageMeta({
  middleware: [auth],
});

export default {
  data() {
    return {
      searchQuery: "", // For the search input
      currentPage: 1, // For pagination
      itemsPerPage: 5, // Number of rows per page
      users: [],
      modules: [],
      permissions: [],
      showModal: false,
      showViewModal: false,
      isUserPermissionConfirmationVisible: false,
      isSuccessUserPermissionVisible: false,
      isEditing: false, // State to track if we're editing
      newPermission: {
        privilegeID: "",
        userID: "",
        moduleID: "",
        create: false,
        update: false,
        cancel: false,
        view: false,
      },
      selectedPermission: null,
    };
  },
  computed: {
    // Filter permissions based on the search query
    filteredPermissions() {
      return this.permissions.filter((permission) => {
        const search = this.searchQuery.toLowerCase();
        return (
          this.getUserName(permission.userID).toLowerCase().includes(search) ||
          this.getModuleName(permission.moduleID).toLowerCase().includes(search)
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
    openConfirmationModal() {
      this.isUserPermissionConfirmationVisible = true;
    },
    closeConfirmationModal() {
      this.isUserPermissionConfirmationVisible = false;
    },
    showSuccessModal() {
      this.isSuccessUserPermissionVisible = true;
    },
    closeSuccessModal() {
      this.isSuccessUserPermissionVisible = false;
      this.closeConfirmationModal(); // Reset confirmation modal
    },
    viewPermission(permission) {
      this.selectedPermission = { ...permission }; // Store selected permission for viewing
      this.showViewModal = true; // Show view modal
    },
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
      this.isEditing = false;
      (this.newPermission = {
        privilegeID: "",
        userID: "",
        moduleID: "",
        create: false,
        update: false,
        cancel: false,
        view: false,
      }),
        (this.showModal = true);
    },
    closeModal() {
      this.showModal = false;
    },
    async handleSubmit() {
      if (this.isEditing) {
        // Update existing permission
        await apiService.put(
          `/api/userPrivilage/${this.selectedPermission.privilegeID}`,
          this.newPermission
        );
        const index = this.permissions.findIndex(
          (p) => p.privilegeID === this.selectedPermission.privilegeID
        );
        if (index !== -1) {
          this.permissions.splice(index, 1, {
            ...this.selectedPermission,
            ...this.newPermission,
            create: this.newPermission.create ? 1 : 0,
            cancel: this.newPermission.cancel ? 1 : 0,
            view: this.newPermission.view ? 1 : 0,
            update: this.newPermission.update ? 1 : 0,
          });
        }

        this.showSuccessModal("User permission edited successfully!");
      } else {
        // Handle form submission to add new permission
        const result = await apiService.post(
          "/api/userPrivilage",
          this.newPermission
        );
        console.log("result-----", result);

        this.permissions.push({
          ...this.newPermission,
          create: this.newPermission.create ? 1 : 0,
          cancel: this.newPermission.cancel ? 1 : 0,
          view: this.newPermission.view ? 1 : 0,
          update: this.newPermission.update ? 1 : 0,
        }); // Set isActive to true for new permission
        this.showSuccessModal("User permission created successfully!");
      }
      this.closeModal();
    },
    closeModal() {
      this.showModal = false;
      this.newPermission = {
        privilegeID: "",
        userID: "",
        moduleID: "",
        create: false,
        update: false,
        cancel: false,
        view: false,
      };
    },
    deletePermission(permission) {
      const index = this.permissions.findIndex(p => p.privilegeID === permission.privilegeID);
      if (index !== -1) {
        this.permissions.splice(index, 1);  
      }
      alert("User permission deleted successfully!");
    },
    editPermission(permission) {
      this.isEditing = true;
      this.selectedPermission = {
        ...permission,
        create: permission.create === 1 ? true : false,
        update: permission.update === 1 ? true : false,
        view: permission.view === 1 ? true : false,
        cancel: permission.cancel === 1 ? true : false,
      }; // Store selected permission
      this.newPermission = {
        ...permission,
        create: permission.create === 1 ? true : false,
        update: permission.update === 1 ? true : false,
        view: permission.view === 1 ? true : false,
        cancel: permission.cancel === 1 ? true : false,
      }; // Fill form with selected permission details
      this.showModal = true;
    },
    toggleActive(permission) {
      permission.isActive = !permission.isActive; // Toggle isActive property
    },
    async fetchModulesData() {
      const result = await apiService.get("/api/modules");
      this.modules = result.data;
    },
    async fetchUserData() {
      const result = await apiService.get("/api/users");
      this.users = result.data;
    },
    async fetchUserPermissionData() {
      const result = await apiService.get("/api/userPrivilage");
      this.permissions = result.data;
    },
    getUserName(userID) {
      const user = this.users?.find((us) => us.userID === userID);
      return user ? `${user.lastName}, ${user.firstName}` : "Unknown";
    },
    getModuleName(moduleID) {
      const module = this.modules?.find((mod) => mod.moduleID === moduleID);
      return module ? module.moduleName : "Unknown";
    },
    closeViewModal() {
      this.showViewModal = false;
      this.selectedPermission = null; // Reset selected permission
    },
  },
  async mounted() {
    await this.fetchModulesData();
    await this.fetchUserData();
    await this.fetchUserPermissionData();
  },
};
</script>

<style scoped></style>
