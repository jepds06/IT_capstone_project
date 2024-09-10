<template>
  <div>
 <NuxtLayout name="admin">
   <div class="space-y-8">
     <!-- Top Stats Section -->
     <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
       <div class="bg-purple-500 text-white p-4 rounded-lg shadow-md">
         <h3 class="text-xl font-semibold">Total Orders</h3>
         <p class="text-4xl font-bold">5,678</p>
         <p class="text-sm">+20% month over month</p>
       </div>
       <div class="bg-yellow-500 text-white p-4 rounded-lg shadow-md">
         <h3 class="text-xl font-semibold">Total Revenue</h3>
         <p class="text-4xl font-bold">2,405</p>
         <p class="text-sm">+33% month over month</p>
       </div>
       <div class="bg-green-500 text-white p-4 rounded-lg shadow-md">
         <h3 class="text-xl font-semibold">Pending Orders</h3>
         <p class="text-4xl font-bold">353</p>
         <p class="text-sm">-8% month over month</p>
       </div>
     </div>

     <!-- Sales Chart Section -->
     <div class="bg-white p-6 rounded-lg shadow-md">
       <h3 class="text-xl font-semibold mb-4">Sales Chart</h3>
       <div>
         <!-- Placeholder for Chart -->
         <div class="h-48 bg-gray-200 rounded-lg flex items-center justify-center">
           <p>Chart Placeholder</p>
         </div>
       </div>
     </div>

     <!-- Recent Quotations Section -->
     <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
       <div class="bg-white p-6 rounded-lg shadow-md">
         <h3 class="text-xl font-semibold mb-4">Recent Quotations</h3>
         <ul>
           <li class="mb-4 flex items-center">
             <img src="https://via.placeholder.com/40" alt="Avatar" class="rounded-full mr-4" />
             <div>
               <p class="font-semibold">Helena</p>
               <p class="text-sm text-gray-600">email@figmasfakedomain.net</p>
             </div>
           </li>
           <!-- Add more quotations here -->
         </ul>
       </div>

       <!-- Inventory Levels Section -->
       <div class="bg-white p-6 rounded-lg shadow-md">
         <h3 class="text-xl font-semibold mb-4">Inventory Levels</h3>
         <table class="w-full text-left table-auto">
           <thead>
             <tr>
               <th class="px-4 py-2">Source</th>
               <th class="px-4 py-2">Sessions</th>
               <th class="px-4 py-2">Change</th>
             </tr>
           </thead>
           <tbody>
             <tr>
               <td class="border px-4 py-2">website.net</td>
               <td class="border px-4 py-2">4321</td>
               <td class="border px-4 py-2 text-green-500">+84%</td>
             </tr>
             <!-- Add more rows here -->
           </tbody>
         </table>
       </div>
     </div>
   </div>
 </NuxtLayout>
</div>
</template>

<script setup>
import DashboardLayout from '~/layouts/admin.vue'
</script>
