<template>
    <div class="mb-4">
      <label :for="id" class="block text-gray-700 dark:text-gray-300">{{ label }}</label>
      <input :type="type" :id="id" v-model="modelValue" class="w-full p-2 border rounded" required />
    </div>
  </template>
  
  <script>
  export default {
    props: {
      label: String,
      id: String,
      type: {
        type: String,
        default: 'text'
      },
      modelValue: String
    },
    emits: ['update:modelValue']
  };
  </script>
  