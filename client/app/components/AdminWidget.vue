<template>
  <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
    <div class="bg-white p-4 rounded shadow">
      <h2 class="text-base text-black font-semibold">
        Monthly Order Statistics
      </h2>
      <div class="chart-container mt-3">
        <canvas id="monthlyOrderChart" />
      </div>
    </div>

    <div class="bg-white p-4 rounded shadow">
      <h2 class="text-base text-black font-semibold">Monthly Quotations</h2>
      <div class="chart-container mt-3">
        <canvas id="monthlyQuotationChart" />
      </div>
    </div>

    <div class="grid grid-cols-1 gap-6">
      <div class="bg-white text-black p-4 rounded shadow">
        <h2 class="text-base font-semibold">Pending Payments - Customers</h2>
        <ul class="mt-3">
          <li class="flex justify-between py-2 border-b">
            <span>Customer 1</span>
            <span>{{
              new Intl.NumberFormat("en-PH", {
                style: "currency",
                currency: "PHP",
              }).format(1000)
            }}</span>
          </li>
          <li class="flex justify-between py-2 border-b">
            <span>Customer 2</span>
            <span>{{
              new Intl.NumberFormat("en-PH", {
                style: "currency",
                currency: "PHP",
              }).format(1500)
            }}</span>
          </li>
          <li class="flex justify-between py-2 border-b">
            <span>Customer 3</span>
            <span>{{
              new Intl.NumberFormat("en-PH", {
                style: "currency",
                currency: "PHP",
              }).format(2000)
            }}</span>
          </li>
        </ul>
      </div>

      <div class="bg-white text-black p-4 rounded shadow">
        <h2 class="text-base font-semibold">Pending Payments - Suppliers</h2>
        <ul class="mt-3">
          <li class="flex justify-between py-2 border-b">
            <span>Supplier 1</span>
            <span>{{
              new Intl.NumberFormat("en-PH", {
                style: "currency",
                currency: "PHP",
              }).format(2500)
            }}</span>
          </li>
          <li class="flex justify-between py-2 border-b">
            <span>Supplier 2</span>
            <span>{{
              new Intl.NumberFormat("en-PH", {
                style: "currency",
                currency: "PHP",
              }).format(2000)
            }}</span>
          </li>
          <li class="flex justify-between py-2 border-b">
            <span>Supplier 3</span>
            <span>{{
              new Intl.NumberFormat("en-PH", {
                style: "currency",
                currency: "PHP",
              }).format(1000)
            }}</span>
          </li>
        </ul>
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
          <UProgress :value="200" :max="200" color="blue" />
        </li>
        <li class="flex flex-col py-2 border-b">
          <div class="flex justify-between items-center">
            <span>Product B</span>
            <span>180 units</span>
          </div>
          <span class="text-sm text-gray-500">Category: Clothing</span>
          <UProgress :value="180" :max="200" color="blue" />
        </li>
        <li class="flex flex-col py-2 border-b">
          <div class="flex justify-between items-center">
            <span>Product C</span>
            <span>150 units</span>
          </div>
          <span class="text-sm text-gray-500">Category: Home & Kitchen</span>
          <UProgress :value="150" :max="200" color="blue" />
        </li>
        <li class="flex flex-col py-2 border-b">
          <div class="flex justify-between items-center">
            <span>Product D</span>
            <span>130 units</span>
          </div>
          <span class="text-sm text-gray-500">Category: Sports</span>
          <UProgress :value="130" :max="200" color="blue" />
        </li>
        <li class="flex flex-col py-2 border-b">
          <div class="flex justify-between items-center">
            <span>Product E</span>
            <span>120 units</span>
          </div>
          <span class="text-sm text-gray-500">Category: Books</span>
          <UProgress :value="120" :max="300" color="blue" />
        </li>
      </ul>
    </div>
    <div class="bg-white p-4 rounded shadow">
      <h2 class="text-base text-black font-semibold">Out of Stock Products</h2>
      <ul class="mt-3">
        <li class="flex flex-col py-2 border-b">
          <span class="font-medium">Category: Electronics</span>
          <span>Product: Product X</span>
          <UProgress :value="2" :max="5" color="red" />
        </li>
        <li class="flex flex-col py-2 border-b">
          <span class="font-medium">Category: Home Appliances</span>
          <span>Product: Product Y</span>
          <span>5 units</span>
          <UProgress :value="5" :max="10" color="red" />
        </li>
        <li class="flex flex-col py-2 border-b">
          <span class="font-medium">Category: Furniture</span>
          <span>Product: Product Z</span>
          <span>6 units</span>
          <UProgress :value="6" :max="10" color="red" />
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
import { ref, onMounted } from "vue";
import Chart from "chart.js/auto";

export default {
  setup() {
    onMounted(() => {
      const ctxOrder = document
        .getElementById("monthlyOrderChart")
        .getContext("2d");
      const ctxQuotation = document
        .getElementById("monthlyQuotationChart")
        .getContext("2d");

      new Chart(ctxOrder, {
        type: "bar",
        data: {
          labels: ["January", "February", "March", "April"], // Update with actual months
          datasets: [
            {
              label: "Orders",
              data: [20, 40, 60, 80], // Update with actual order data
              backgroundColor: "rgba(75, 192, 192, 0.2)",
              borderColor: "rgba(75, 192, 192, 1)",
              borderWidth: 1,
            },
          ],
        },
        options: {
          responsive: true,
          scales: {
            y: {
              beginAtZero: true,
            },
          },
        },
      });

      new Chart(ctxQuotation, {
        type: "line",
        data: {
          labels: ["January", "February", "March", "April"], // Update with actual months
          datasets: [
            {
              label: "Quotations",
              data: [5, 15, 12, 30], // Update with actual quotation data
              fill: false,
              borderColor: "rgba(153, 102, 255, 1)",
              tension: 0.1,
            },
          ],
        },
        options: {
          responsive: true,
          plugins: {
            title: {
              display: true,
            },
          },
          scales: {
            y: {
              beginAtZero: true,
            },
          },
        },
      });
    });

    return {};
  },
};
</script>
