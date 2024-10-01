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
        <button
          class="bg-green-500 text-white px-2 py-1 rounded"
          @click="openViewModal(user)"
        >
          View
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

    <!-- Add/View User Modal -->
    <div v-if="showModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
      <div class="bg-white p-6 rounded-lg shadow-lg w-1/3">
        <h2 class="text-xl font-bold mb-4">{{ isView ? 'View User' : 'Add User' }}</h2>
        <form @submit.prevent="isView ? closeModal() : addUser()">
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
              {{ isView ? 'Close' : 'Save' }}
            </button>
          </div>
        </form>
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
      form: {
        id: '',
        lname: '',
        fname: '',
        username: '',
        password: '',
      },
      isView: false,
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
    },
    openViewModal(user) {
      this.form = { ...user, password: '' }; // No password in view mode
      this.showModal = true;
      this.isView = true;
    },
    closeModal() {
      this.showModal = false;
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
      // Logic to add user
      this.users.push({
        ...this.form,
        id: this.users.length + 1,
      });
      this.closeModal();
    },
  },
  mounted() {
    // Fetch user data from your API
  },
};
</script>

<style>
/* Add custom styles if needed */
</style>
