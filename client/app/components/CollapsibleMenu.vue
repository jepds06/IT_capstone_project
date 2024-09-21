<template>
    <li>
      <div @click="toggle" class="flex items-center justify-between p-4 cursor-pointer hover:bg-gray-800">
        <div class="flex items-center">
          <UIcon :name="icon" class="w-5 h-5 mr-5" />
          <span>{{ title }}</span>
        </div>
        <!-- Toggle arrow or icon to indicate expand/collapse -->
        <UIcon :name="isOpen ? 'mdi:chevron-up' : 'mdi:chevron-down'" class="w-5 h-5" />
      </div>
      <!-- The slot content is shown only if the menu is open -->
      <ul v-if="isOpen" class="ml-4">
        <slot></slot>
      </ul>
    </li>
  </template>
  
  <script setup>
  import { defineProps, defineEmits } from "vue";
  
  // Accept props
  const props = defineProps({
    icon: String,
    title: String,
    isOpen: Boolean, // Determines if the menu is open or closed
  });
  
  // Emit toggle event to the parent
  const emit = defineEmits(["toggle"]);
  
  function toggle() {
    emit("toggle");
  }
  </script>
  
  <style scoped>
  /* Add any necessary styles here */
  </style>
  