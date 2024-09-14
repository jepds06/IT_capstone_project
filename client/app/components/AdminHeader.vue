<!-- <template>
    <header class="bg-[#003366] text-white p-4 flex justify-between items-center">
      <div class="text-xl font-semibold">Administrator Dashboard</div>
      <div class="flex space-x-4">
        <button class="bg-[#004080] px-4 py-2 rounded">Notifications</button>
        <button class="bg-[#004080] px-4 py-2 rounded">Profile</button>
        <button class="bg-[#004080] px-4 py-2 rounded">Settings</button>
      </div>
    </header>
  </template>
  
  <script setup>
  </script>
  
  <style scoped>
  </style>
   -->

 <script setup lang="ts">
import { _width } from '#tailwind-config/theme';


</script>

<template>
  <UHeader>
    <template #logo>
      Administrator Dashboard
    </template>

    <template #right>
      <UButton label="Notifications" color="gray" />
      <UButton label="Profile" color="gray" />
      <UButton label="Settings" color="gray" />
    
    </template>

    <!-- <template #panel>
      <UNavigationTree
        :links="mapContentNavigation(navigation)"
        default-open
      />
    </template> -->
  </UHeader>
</template>
