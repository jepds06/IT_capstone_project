<template>
    <div class="flex">
      <Sidebar />
      <div class="flex-1 p-6 bg-[#F0F4F8]">
        <Header />
        <main>
          <!-- Example widgets and content -->
          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="bg-white p-4 rounded shadow">
              <h2 class="text-lg font-semibold">Order Statistics</h2>
              <!-- Chart or table goes here -->
            </div>
            <div class="bg-white p-4 rounded shadow">
              <h2 class="text-lg font-semibold">Recent Quotations</h2>
              <!-- List or table of quotations -->
            </div>
            <div class="bg-white p-4 rounded shadow">
              <h2 class="text-lg font-semibold">Pending Payments</h2>
              <!-- List or table of payments -->
            </div>
          </div>
        </main>
      </div>
    </div>
  </template>
  
  <script setup>
  import Header from '~/components/Header.vue'
  import Sidebar from '~/components/Sidebar.vue'
  </script>
  
  <style scoped>
  </style>
  