<template>
    <div> 
      <button @click="toggle" class="w-full text-left p-4 hover:bg-gray-800 flex items-center">
        <UIcon :name="icon" class="w-5 h-5"/>
        <div class="m-1">{{ title }}</div>
        <!-- <svg :class="{'rotate-180': isOpen}" class="w-4 h-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
        </svg> -->
        <UIcon name="solar:double-alt-arrow-down-line-duotone" class="w-4 h-4"/>
      </button>
      <div v-if="isOpen" class="bg-gray-600">
        <slot></slot>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref } from 'vue';
  
  const props = defineProps({
    title: String,
    icon: String
  });
  
  const isOpen = ref(false);
  
  function toggle() {
    isOpen.value = !isOpen.value;
  }
  </script>
  
  <style scoped>
  .rotate-180 {
    transform: rotate(180deg);
  }
  </style>
  