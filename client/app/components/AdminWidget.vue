<template>
  <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
    <div class="bg-white p-4 rounded shadow">
      <h2 class="text-base text-black font-semibold">
        Monthly Order Statistics
      </h2>
      <div class="chart-container mt-3">
        <canvas id="monthlyOrderChart" />
      </div>
    </div>

    <div class="bg-white p-4 rounded shadow">
      <h2 class="text-base text-black font-semibold">
        Monthly Quotations
      </h2>
      <div class="chart-container mt-3">
        <canvas id="monthlyQuotationChart" />
      </div>
    </div>
  </div>

  <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
    <div class="bg-white p-4 rounded shadow">
      <h2 class="text-base text-black font-semibold">
        Top 5 In-Demand Products
      </h2>
      <ul class="mt-3">
        <li class="flex flex-col py-2 border-b">
          <div class="flex justify-between items-center">
            <span>Product A</span>
            <span>200 units</span>
          </div>
          <span class="text-sm text-gray-500">Category: Electronics</span>
          <div class="relative w-full h-2 bg-gray-200 mt-1">
            <div
              class="absolute top-0 left-0 h-full bg-blue-500"
              style="width: 80%;"
            />
          </div>
        </li>
        <li class="flex flex-col py-2 border-b">
          <div class="flex justify-between items-center">
            <span>Product B</span>
            <span>180 units</span>
          </div>
          <span class="text-sm text-gray-500">Category: Clothing</span>
          <div class="relative w-full h-2 bg-gray-200 mt-1">
            <div
              class="absolute top-0 left-0 h-full bg-blue-500"
              style="width: 72%;"
            />
          </div>
        </li>
        <li class="flex flex-col py-2 border-b">
          <div class="flex justify-between items-center">
            <span>Product C</span>
            <span>150 units</span>
          </div>
          <span class="text-sm text-gray-500">Category: Home & Kitchen</span>
          <div class="relative w-full h-2 bg-gray-200 mt-1">
            <div
              class="absolute top-0 left-0 h-full bg-blue-500"
              style="width: 60%;"
            />
          </div>
        </li>
        <li class="flex flex-col py-2 border-b">
          <div class="flex justify-between items-center">
            <span>Product D</span>
            <span>130 units</span>
          </div>
          <span class="text-sm text-gray-500">Category: Sports</span>
          <div class="relative w-full h-2 bg-gray-200 mt-1">
            <div
              class="absolute top-0 left-0 h-full bg-blue-500"
              style="width: 52%;"
            />
          </div>
        </li>
        <li class="flex flex-col py-2 border-b">
          <div class="flex justify-between items-center">
            <span>Product E</span>
            <span>120 units</span>
          </div>
          <span class="text-sm text-gray-500">Category: Books</span>
          <div class="relative w-full h-2 bg-gray-200 mt-1">
            <div
              class="absolute top-0 left-0 h-full bg-blue-500"
              style="width: 48%;"
            />
          </div>
        </li>
      </ul>
    </div>

    <div class="grid grid-cols-1 gap-6">
      <div class="bg-white text-black p-4 rounded shadow">
        <h2 class="text-base font-semibold">
          Pending Payments - Customers
        </h2>
        <ul class="mt-3">
          <li class="flex justify-between py-2 border-b">
            <span>Customer 1</span>
            <span>$1000</span>
          </li>
          <li class="flex justify-between py-2 border-b">
            <span>Customer 2</span>
            <span>$1500</span>
          </li>
          <li class="flex justify-between py-2 border-b">
            <span>Customer 3</span>
            <span>$2000</span>
          </li>
        </ul>
      </div>

      <div class="bg-white text-black p-4 rounded shadow">
        <h2 class="text-base font-semibold">
          Pending Payments - Suppliers
        </h2>
        <ul class="mt-3">
          <li class="flex justify-between py-2 border-b">
            <span>Supplier 1</span>
            <span>$2500</span>
          </li>
          <li class="flex justify-between py-2 border-b">
            <span>Supplier 2</span>
            <span>$2000</span>
          </li>
          <li class="flex justify-between py-2 border-b">
            <span>Supplier 3</span>
            <span>$1000</span>
          </li>
        </ul>
      </div>
    </div>
  </div>

  <!-- Full Width Container for Out of Stock Products -->
  <div class="bg-white p-4 rounded shadow mt-6 w-full">
    <h2 class="text-base text-black font-semibold">
      Out of Stock Products
    </h2>
    <ul class="mt-3">
      <li class="flex flex-col py-2 border-b">
        <span class="font-medium">Category: Electronics</span>
        <span>Product: Product X</span>
        <span>0 units</span>
        <div class="w-full bg-red-500 h-2 rounded-full mt-2" />
      </li>
      <li class="flex flex-col py-2 border-b">
        <span class="font-medium">Category: Home Appliances</span>
        <span>Product: Product Y</span>
        <span>0 units</span>
        <div class="w-full bg-red-500 h-2 rounded-full mt-2" />
      </li>
      <li class="flex flex-col py-2 border-b">
        <span class="font-medium">Category: Furniture</span>
        <span>Product: Product Z</span>
        <span>0 units</span>
        <div class="w-full bg-red-500 h-2 rounded-full mt-2" />
      </li>
    </ul>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue'
import Chart from 'chart.js/auto'

export default {
  setup() {
    onMounted(() => {
      const ctxOrder = document.getElementById('monthlyOrderChart').getContext('2d')
      const ctxQuotation = document.getElementById('monthlyQuotationChart').getContext('2d')

      new Chart(ctxOrder, {
        type: 'bar',
        data: {
          labels: ['January', 'February', 'March', 'April'], // Update with actual months
          datasets: [{
            label: 'Orders',
            data: [10, 20, 30, 40], // Update with actual order data
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1
          }]
        },
        options: {
          responsive: true,
          scales: {
            y: {
              beginAtZero: true
            }
          }
        }
      })

      new Chart(ctxQuotation, {
        type: 'line',
        data: {
          labels: ['January', 'February', 'March', 'April'], // Update with actual months
          datasets: [{
            label: 'Quotations',
            data: [5, 15, 25, 35], // Update with actual quotation data
            fill: false,
            borderColor: 'rgba(153, 102, 255, 1)',
            tension: 0.1
          }]
        },
        options: {
          responsive: true,
          scales: {
            y: {
              beginAtZero: true
            }
          }
        }
      })
    })

    return {}
  }
}
</script>
