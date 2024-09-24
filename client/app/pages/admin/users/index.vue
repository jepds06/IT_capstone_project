<template>
    <div class="container mx-auto p-4">
      <h1 class="text-2xl font-bold mb-4">Users</h1>
      
      <div class="mb-4">
        <input
          type="text"
          placeholder="Search Users"
          v-model="searchQuery"
          class="border rounded px-2 py-1"
        />
      </div>
  
      <table class="min-w-full bg-white border border-gray-300">
        <thead>
          <tr>
            <th class="border px-4 py-2">ID</th>
            <th class="border px-4 py-2">Last Name</th>
            <th class="border px-4 py-2">First Name</th>
            <th class="border px-4 py-2">Username</th>
            <th class="border px-4 py-2">Password</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="user in filteredUsers" :key="user.id">
            <td class="border px-4 py-2">{{ user.id }}</td>
            <td class="border px-4 py-2">{{ user.lname }}</td>
            <td class="border px-4 py-2">{{ user.fname }}</td>
            <td class="border px-4 py-2">{{ user.username }}</td>
            <td class="border px-4 py-2">******</td> <!-- Masked Password -->
          </tr>
        </tbody>
      </table>
  
      <!-- Pagination Component -->
      <pagination :total-pages="totalPages" v-model="currentPage" />
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
      };
    },
    computed: {
      filteredUsers() {
        const start = (this.currentPage - 1) * this.itemsPerPage;
        const filtered = this.users.filter(user => 
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
    mounted() {
      // Fetch user data from your API
    },
  };
  </script>

<style>

</style>