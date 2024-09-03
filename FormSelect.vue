<template>
    <div class="mb-4">
      <label :for="id" class="block text-gray-700 dark:text-gray-300">{{ label }}</label>
      <div class="relative">
        <select :id="id" v-model="modelValue" class="w-full p-2 border rounded appearance-none bg-white dark:bg-gray-700 dark:border-gray-600">
          <option value="" disabled>Select your role</option>
          <option value="admin">Administrator</option>
          <option value="supplier">Supplier</option>
          <option value="customer">Customer</option>
        </select>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    props: {
      label: String,
      id: String,
      modelValue: String
    },
    emits: ['update:modelValue']
  };
  </script>
  