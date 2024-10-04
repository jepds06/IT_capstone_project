<template>
  <div class="container mx-auto p-4">
    <!-- Title and Add User Button -->
    <div class="flex justify-between items-center mb-4">
      <h1 class="text-xl font-bold">Users</h1>
      <button @click="openModal('add')" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
        Add User
      </button>
    </div>

    <!-- Search Bar -->
    <div class="mb-4">
      <input
        type="text"
        placeholder="Search Users"
        v-model="searchQuery"
        class="border rounded px-2 py-1"
      />
    </div>

    <!-- User Table -->
    <table class="min-w-full bg-white border border-gray-300">
      <thead>
        <tr>
          <th class="border px-4 py-2 text-center">ID</th>
          <th class="border px-4 py-2 text-center">Last Name</th>
          <th class="border px-4 py-2 text-center">First Name</th>
          <th class="border px-4 py-2 text-center">Username</th>
          <th class="border px-4 py-2 text-center">Actions</th> <!-- Actions Column -->
        </tr>
      </thead>
      <tbody>
        <tr v-for="user in filteredUsers" :key="user.id">
          <td class="border px-4 py-2 text-center">{{ user.id }}</td>
          <td class="border px-4 py-2 text-center">{{ user.lname }}</td>
          <td class="border px-4 py-2 text-center">{{ user.fname }}</td>
          <td class="border px-4 py-2 text-center">{{ user.username }}</td>
          <td class="border px-4 py-2 text-center">
            <!-- View Button -->
            <button
              class="text-blue-500 hover:text-blue-700"
              @click="openViewModal(user)"
              title="View User"
            >
              👁️
            </button>
            <!-- Edit Button -->
            <button
              class="text-yellow-500 hover:text-yellow-700 mx-2"
              @click="openEditModal(user)"
              title="Edit User"
            >
              ✏️
            </button>
            <!-- Delete Button -->
            <button
              class="text-red-500 hover:text-red-700"
              @click="openDeleteModal(user)"
              title="Delete User"
            >
              🗑️
            </button>
          </td>
        </tr>
      </tbody>
    </table>

    <!-- Pagination Component -->
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

    <!-- Add/Edit/View User Modal -->
    <div v-if="showModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
      <div class="bg-white p-6 rounded-lg shadow-lg w-1/3">
        <h2 class="text-xl font-bold mb-4">{{ isView ? 'View User' : (isEdit ? 'Edit User' : 'Add User') }}</h2>
        <form @submit.prevent="isView ? closeModal() : (isEdit ? saveEdit() : addUser())">
          <div class="mb-4">
            <label for="lname" class="block text-gray-700">Last Name:</label>
            <input
              type="text"
              v-model="form.lname"
              id="lname"
              class="border rounded px-2 py-1 w-full"
              :readonly="isView"
            />
          </div>
          <div class="mb-4">
            <label for="fname" class="block text-gray-700">First Name:</label>
            <input
              type="text"
              v-model="form.fname"
              id="fname"
              class="border rounded px-2 py-1 w-full"
              :readonly="isView"
            />
          </div>
          <div class="mb-4">
            <label for="username" class="block text-gray-700">Username:</label>
            <input
              type="text"
              v-model="form.username"
              id="username"
              class="border rounded px-2 py-1 w-full"
              :readonly="isView"
            />
          </div>
          <div class="mb-4" v-if="!isView">
            <label for="password" class="block text-gray-700">Password:</label>
            <input
              type="password"
              v-model="form.password"
              id="password"
              class="border rounded px-2 py-1 w-full"
              :readonly="isEdit"
            />
          </div>
          <div class="flex justify-end">
            <button
              class="bg-gray-500 text-white px-4 py-2 rounded mr-2"
              @click="closeModal"
            >
              Cancel
            </button>
            <button
              type="submit"
              class="bg-blue-500 text-white px-4 py-2 rounded"
            >
              {{ isView ? 'Close' : (isEdit ? 'Save Changes' : 'Save') }}
            </button>
          </div>
        </form>
      </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div v-if="showDeleteModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
      <div class="bg-white p-6 rounded-lg shadow-lg w-1/3">
        <h2 class="text-xl font-bold mb-4">Delete User</h2>
        <p>Are you sure you want to delete {{ form.username }}?</p>
        <div class="flex justify-end mt-4">
          <button class="bg-gray-500 text-white px-4 py-2 rounded mr-2" @click="closeDeleteModal">
            Cancel
          </button>
          <button class="bg-red-500 text-white px-4 py-2 rounded" @click="deleteUser">
            Delete
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
      users: [], // Fetch users from API
      searchQuery: '',
      currentPage: 1,
      itemsPerPage: 10,
      showModal: false,
      showDeleteModal: false,
      form: {
        id: '',
        lname: '',
        fname: '',
        username: '',
        password: '',
      },
      isView: false,
      isEdit: false,
    };
  },
  computed: {
    filteredUsers() {
      const start = (this.currentPage - 1) * this.itemsPerPage;
      const filtered = this.users.filter((user) =>
        user.lname.includes(this.searchQuery) ||
        user.fname.includes(this.searchQuery) ||
        user.username.includes(this.searchQuery)
      );
      return filtered.slice(start, start + this.itemsPerPage);
    },
    totalPages() {
      return Math.ceil(this.users.length / this.itemsPerPage);
    },
  },
  methods: {
    openModal() {
      this.resetForm();
      this.showModal = true;
      this.isView = false;
      this.isEdit = false;
    },
    openViewModal(user) {
      this.form = { ...user, password: '' };
      this.showModal = true;
      this.isView = true;
    },
    openEditModal(user) {
      this.form = { ...user };
      this.showModal = true;
      this.isEdit = true;
    },
    openDeleteModal(user) {
      this.form = { ...user };
      this.showDeleteModal = true;
    },
    closeModal() {
      this.showModal = false;
    },
    closeDeleteModal() {
      this.showDeleteModal = false;
    },
    resetForm() {
      this.form = {
        id: '',
        lname: '',
        fname: '',
        username: '',
        password: '',
      };
    },
    addUser() {
      this.users.push({
        ...this.form,
        id: this.users.length + 1,
      });
      this.closeModal();
    },
    saveEdit() {
      const index = this.users.findIndex((u) => u.id === this.form.id);
      if (index !== -1) {
        this.users.splice(index, 1, { ...this.form });
      }
      this.closeModal();
    },
    deleteUser() {
      this.users = this.users.filter((u) => u.id !== this.form.id);
      this.closeDeleteModal();
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

<style scoped>

</style>
