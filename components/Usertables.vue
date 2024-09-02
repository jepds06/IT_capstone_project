<template>
    <div class="overflow-x-auto">
      <table class="min-w-full bg-white border border-gray-200">
        <thead>
          <tr>
            <th class="px-6 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs leading-4 font-medium text-gray-600 uppercase tracking-wider">Name</th>
            <th class="px-6 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs leading-4 font-medium text-gray-600 uppercase tracking-wider">Email</th>
            <th class="px-6 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs leading-4 font-medium text-gray-600 uppercase tracking-wider">Role</th>
            <th class="px-6 py-3 border-b-2 border-gray-200 bg-gray-100"></th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(user, index) in users" :key="index">
            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">{{ user.name }}</td>
            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">{{ user.email }}</td>
            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">{{ user.role }}</td>
            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-right text-sm leading-5 font-medium">
              <a href="#" class="text-indigo-600 hover:text-indigo-900">Edit</a>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </template>
  
  <script setup>
  const users = [
    { name: 'John Doe', email: 'john@example.com', role: 'Admin' },
    { name: 'Jane Doe', email: 'jane@example.com', role: 'Editor' },
    // Add more users here
  ]
  </script>
  
  <style scoped>
  /* Add any additional styling here if needed */
  </style>
  