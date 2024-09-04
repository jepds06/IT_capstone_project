<template>
    <div class="mb-4">
      <label :for="id" class="block text-gray-700">{{ label }}</label>
      <input :type="type" :id="id" v-model="modelValue" @input="$emit('update:modelValue', $event.target.value)" required class="w-full mt-1 p-2 border rounded" />
    </div>
  </template>
  
  <script>
  export default {
    props: {
      label: String,
      id: String,
      type: String,
      modelValue: String,
    },
  };
  </script>
  