<template>
    <div v-if="isVisible" class="fixed inset-0 z-50 flex items-center justify-center bg-gray-800 bg-opacity-75">
      <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
        <!-- Modal Header -->
        <div class="flex justify-between items-center mb-4">
          <h2 class="text-lg font-semibold">{{ title }}</h2>
          <button @click="close" class="text-gray-600 hover:text-gray-900">&times;</button>
        </div>
        <!-- Modal Body -->
        <div class="mb-4">
          <slot name="body"></slot>
        </div>
        <!-- Modal Footer -->
        <div class="flex justify-end">
          <button @click="close" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
            Cancel
          </button>
          <button v-if="showSave" @click="save" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 ml-2">
            Save
          </button>
        </div>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref } from 'vue';
  
  // Props for controlling visibility and title
  const props = defineProps({
    isVisible: {
      type: Boolean,
      required: true
    },
    title: {
      type: String,
      default: 'Modal Title'
    },
    showSave: {
      type: Boolean,
      default: false
    }
  });
  
  const emit = defineEmits(['update:isVisible', 'save']);
  
  function close() {
    emit('update:isVisible', false);
  }
  
  function save() {
    emit('save');
  }
  </script>
  
  <style scoped>
  /* Modal styles */
  .fixed {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
  }
  </style>
  