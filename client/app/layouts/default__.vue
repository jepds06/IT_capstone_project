<template>
    <div>
      <Header />
      <Sidebar />
      <main>
        <NuxtPage />
      </main>
    </div>
  </template>
  
  <script setup>
  import Header from '~/components/AdminHeader.vue'
  import Sidebar from '~/components/AdminSidebar.vue'
  </script>
  
  <style scoped>
  /* Add layout styles here */
  </style>
  