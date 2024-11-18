<template>
  <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
    <div class="bg-white p-4 rounded shadow">
      <h2 class="text-base text-black font-semibold">
        Last 5 Days Order Statistics
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
          <li class="flex justify-between py-2 border-b" v-for="payment in pendingAdminPayment">
            <span>{{getSupplierName(payment?.admin_order?.quotation?.userID)}}</span>
            <span>{{
              new Intl.NumberFormat("en-PH", {
                style: "currency",
                currency: "PHP",
              }).format(payment.amountToPay)
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
        <li class="flex flex-col py-2 border-b" v-for="product in topProducts">
          <div class="flex justify-between items-center">
            <span>{{product.productName}}</span>
            <span>{{product.qtyOrdered}}</span>
          </div>
          <span class="text-sm text-gray-500">Category: Electronics</span>
          <UProgress :value="product.qtyOrdered" :max="highestOrderQty" color="blue" />
        </li>
      </ul>
    </div>
    <div class="bg-white p-4 rounded shadow">
      <h2 class="text-base text-black font-semibold">Out of Stock Products</h2>
      <ul class="mt-3">
        <li class="flex flex-col py-2 border-b" v-for="product in products.filter((value) => value.stock < 10)">
          <span class="font-medium">Category: {{getCategoryDescription(product.prodCatID)}}</span>
          <span>Product: {{product.productName}}</span>
          <UProgress :value="product.stock" :max="10" color="red" />
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
import Chart from "chart.js/auto";
import { apiService } from "~/api/apiService";

export default {
  data() {
    return {
      products: [],
      categories: [],
      adminPayments: [],
      users: [],
    };
  },
  computed:{
    pendingAdminPayment(){
      return this.adminPayments
      ?.filter((value) => value.amountToPay !== value.amountPaid)
      ?.sort((a, b) => b.amountToPay - a.amountToPay)
      ?.slice(0,3)
    },
    highestOrderQty(){
      return Math.max(...this.products?.filter((v) => v?.stock !== 0 && v?.qtyOrdered)?.map((v) => parseInt(v?.qtyOrdered)))  
    },
    topProducts() {
      console.log(this.products)
      return this.products
          ?.filter((v) => v.stock !== 0)
          ?.sort((a, b) => b.qtyOrdered - a.qtyOrdered) // Sort by totalQtyOrdered (desc)
          ?.slice(0, 5);
          }
  },
  methods: {
    graphPresentation() {
      const ctxOrder = document
        .getElementById("monthlyOrderChart")
        .getContext("2d");
      const ctxQuotation = document
        .getElementById("monthlyQuotationChart")
        .getContext("2d");

      new Chart(ctxOrder, {
        type: "bar",
        data: {
          labels: [
            "November 14",
            "November 15",
            "November 16",
            "November 17",
            "November 18",
          ], // Update with actual months
          datasets: [
            {
              label: "Orders",
              data: [20, 40, 60, 80, 10], // Update with actual order data
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
    },
    getCategoryDescription(categoryId) {
      const category = this.categories.find(
        (cat) => cat.prodCatID === categoryId
      );
      return category ? category.description : "Unknown";
    },
    getSupplierName(userID) {
      const supplier = this.users?.find((value) => value.userID === userID);
      return supplier
        ? `${supplier.lastName} ${supplier.firstName}`
        : "Unknown";
    },
    async fetchUserData() {
      const result = await apiService.get("/api/users");
      this.users = result.data;
    },
    async fetchProductsData() {
      try {
        const { data } = await apiService.get("/api/products");
        this.products = data?.map((value) => {
          const qtyOrdered = value.sales_order?.reduce((total, detail) => {
            return total + parseInt(detail.qtyOrdered);
          }, 0);
          return {
            ...value,
            qtyOrdered,
          };
        });
      } catch (error) {
        console.error("Error fetching data:", error);
      }
    },
    async fetchCategoriesData() {
      try {
        const { data } = await apiService.get("/api/productCategories");
        this.categories = data;
      } catch (error) {
        console.error("Error fetching data:", error);
      }
    },
    async fetchFinishProductsData() {
      const result = await apiService.get("/api/finishedProducts");
      // const productIDs = result.data?.map((val) => val.production_detail.product.productID);

      const data = this.products?.map((value) => {
        const stockProducts = result.data?.filter(
          (val) => val.production_detail.product.productID === value.productID
        );
        const quantity = stockProducts?.reduce((total, detail) => {
          return total + parseInt(detail.quantity);
        }, 0);
        return {
          ...value,
          stock: quantity - value.qtyOrdered,
        };
      });
      this.products = data;
    },
    async fetchPaymentsData (){
      const result = await apiService.get("/api/adminPayments");
      this.adminPayments = result.data;
    }
  },
  async mounted() {
    this.graphPresentation();
    await this.fetchCategoriesData();
    await this.fetchUserData();
    await this.fetchProductsData();
    await this.fetchFinishProductsData();
    await this.fetchPaymentsData();
  },
};
</script>
