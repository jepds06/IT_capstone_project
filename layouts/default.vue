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
  import Header from '~/components/Header.vue'
  import Sidebar from '~/components/Sidebar.vue'
  </script>
  
  <style scoped>
  /* Add layout styles here */
  </style>
  