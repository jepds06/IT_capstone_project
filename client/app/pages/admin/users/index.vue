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
<!-- <div v-for="userType in userTypes">
  <h3 class="font-bold">
    {{userType.userTypeName}}
  </h3> -->
  <table class="min-w-full bg-white border border-gray-300 mb-8">
    <thead>
      <tr>
        <th class="border px-4 py-2 text-black text-center">ID</th>
        <th class="border px-4 py-2 text-black text-center">Last Name</th>
        <th class="border px-4 py-2 text-black text-center">First Name</th>
        <th class="border px-4 py-2 text-black text-center">Username</th>
        <th class="border px-4 py-2 text-black text-center">Email</th>
        <th class="border px-4 py-2 text-black text-center">User Type</th>
        <th class="border px-4 py-2 text-black text-center">Actions</th> <!-- Actions Column -->
      </tr>
    </thead>
    <tbody>
      <tr v-for="user in filteredUsers" :key="user.id">
        <td class="border px-4 py-2 text-black text-center">{{ user.userID }}</td>
        <td class="border px-4 py-2 text-black text-center">{{ user.lastName }}</td>
        <td class="border px-4 py-2 text-black text-center">{{ user.firstName }}</td>
        <td class="border px-4 py-2 text-black text-center">{{ user.userName }}</td>
        <td class="border px-4 py-2 text-black text-center">{{ user.email }}</td>
        <td class="border px-4 py-2 text-black text-center">{{ getUserTypeName(user.userTypeID) }}</td>
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
          <!-- <button
            class="text-red-500 hover:text-red-700"
            @click="openDeleteModal(user)"
            title="Delete User"
          >
            🗑️
          </button> -->
        </td>
      </tr>
    </tbody>
  </table>

<!-- </div> -->



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
        <h2 class="text-xl font-bold mb-4">{{ isView ? 'View User' : (isEdit ? 'Edit User' : 'Add User') }}</h2>
        <form @submit.prevent="isView ? closeModal() : (isEdit ? saveEdit() : addUser())">
          <div class="mb-4">
            <label for="prodCat" class="block text-sm font-medium text-gray-700">User Type:</label>
            <select v-model="form.userTypeID" id="prodCat" class="mt-1 block w-full border border-gray-300 rounded-lg p-2">
              <option v-for="userType in userTypes" :key="userType.userTypeID" :value="userType.userTypeID">
                {{ userType.userTypeName }}
              </option>
            </select>
          </div>
          <div class="mb-4">
            <label for="lname" class="block text-gray-700">Last Name:</label>
            <input
              type="text"
              v-model="form.lastName"
              id="lname"
              class="border rounded px-2 py-1 w-full"
              :readonly="isView"
            />
          </div>
          <div class="mb-4">
            <label for="fname" class="block text-gray-700">First Name:</label>
            <input
              type="text"
              v-model="form.firstName"
              id="fname"
              class="border rounded px-2 py-1 w-full"
              :readonly="isView"
            />
          </div>
          <div class="mb-4">
            <label for="username" class="block text-gray-700">Username:</label>
            <input
              type="text"
              v-model="form.userName"
              id="username"
              class="border rounded px-2 py-1 w-full"
              :readonly="isView"
            />
          </div>
          <div class="mb-4">
            <label for="username" class="block text-gray-700">Email:</label>
            <input
              type="text"
              v-model="form.email"
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
              v-if="!isView"
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
  </div>
</template>

<script>
import { apiService } from '~/api/apiService';
import auth from '../../../../middleware/auth'
// This page requires authentication
definePageMeta({
  middleware: [auth],
});

export default {
  data() {
    return {
      users: [], // Fetch users from API
      userTypes: [], // Fetch users from API
      searchQuery: '',
      currentPage: 1,
      itemsPerPage: 10,
      showModal: false,
      isEdit: false,
      form: {
        userID: '',
        lastName: '',
        firstName: '',
        userName: '',
        password: '',
        userTypeID: ''
      },
      isView: false,
    };
  },
  computed: {
    filteredUsers() {
      const start = (this.currentPage - 1) * this.itemsPerPage;
      const filtered = this.users.filter((user) =>
        user?.lastName.includes(this.searchQuery) ||
        user?.firstName.includes(this.searchQuery) ||
        user?.userName.includes(this.searchQuery)
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
      this.isView = false;
      this.isEdit = false;
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
    getUserTypeName(userTypeID){
      const userType = this.userTypes.find((userType) => userType.userTypeID === userTypeID);
      return userType.userTypeName
    },
    async addUser() {
      // Logic to add user
      const result = await apiService.post('/api/users', this.form)
      this.users.push({
        ...this.form,
        userID: result.data.userID,
      });
      alert("User added successfully!");
      this.closeModal();
    },

    async saveEdit() {
      await apiService.put(`/api/users/${this.form.userID}`, this.form)
      const index = this.users.findIndex((u) => u.userID === this.form.userID);
      if (index !== -1) {
        this.users.splice(index, 1, { ...this.form });
      } 
      alert("User edited successfully!")
      this.closeModal();
    },
    async fetchUserTypesData(){
      const result = await apiService.get('/api/userTypes')
      this.userTypes = result.data
    },
    async fetchUserData(){
      const result = await apiService.get('/api/users')
      this.users = result.data
    }
  },
  async mounted() {
   await this.fetchUserTypesData();
   await this.fetchUserData();
  },
};
</script>

<style>
/* Add custom styles if needed */
</style>
