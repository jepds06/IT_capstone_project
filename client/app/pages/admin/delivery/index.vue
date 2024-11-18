<template>
  <div class="m-8 space-y-6">
    <h1 class="text-2xl font-extrabold mb-4">Delivery Records</h1>
   <!-- Overview Cards -->
   <div class="grid grid-cols-4 gap-4">
        <div class="bg-gray-500 text-white p-4 rounded-lg shadow">
          <h2 class="text-base font-semibold  ">Total Deliveries Today</h2>
          <p class="text-2xl font-bold mt-2 text-center">{{ totalDeliveries }}</p>
        </div>
        <div class="bg-gray-500 text-white p-4 rounded-lg shadow">
          <h2 class="text-base font-semibold">Pending Deliveries</h2>
          <p class="text-2xl font-bold mt-2 text-center"> {{ pendingDeliveries }}</p>
        </div>
        <div class="bg-gray-500 text-white p-4 rounded-lg shadow">
          <h2 class="text-base font-semibold">Delivered</h2>
          <p class="text-2xl font-bold mt-2 text-center">{{ delivered }}</p>
        </div>
        <div class="bg-gray-500 text-white p-4 rounded-lg shadow">
          <h2 class="text-base font-semibold">Rescheduled</h2>
          <p class="text-2xl font-bold mt-2 text-center">{{ rescheduled }}</p>
        </div>
      </div>

    <!-- Delivery Records Table -->
    <table class="table-auto w-full bg-white shadow-lg rounded-lg">
      <thead>
        <tr class="bg-gray-200">
          <th class="p-4 text-center">Delivery ID</th>
          <th class="p-4 text-center">PO ID</th>
          <th class="p-4 text-center">Supplier</th>
          <th class="p-4 text-center">Delivery Date</th>
          <th class="p-4 text-center">Status</th>
          <th class="p-4 text-center">Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="delivery in paginatedDeliveries" :key="delivery.id" class="border-t">
          <td class="p-4 text-center">{{ delivery.adminDlvrID }}</td>
          <td class="p-4 text-center">{{ delivery.adminOrdID }}</td>
          <td class="p-4 text-center">{{ getSupplierName(delivery.admin_order?.quotation?.userID) }}</td>
          <td class="p-4 text-center">{{ delivery.deliveryDate }}</td>
          <td class="p-4 text-center">
            <span :class="statusClass(delivery.deliveryStatus === 'Processed delivery' ? 'Waiting for delivery' : delivery.deliveryStatus)" class="py-1 px-3 rounded-full text-white text-sm">
              {{ delivery.deliveryStatus === "Processed delivery" ? "Waiting for delivery" : delivery.deliveryStatus }}
            </span>
          </td>
          <td class="p-4 text-center">
            <UButton
            :disabled="delivery.deliveryStatus === 'Delivered'"
            icon="emojione:ballot-box-with-check"
            @click="updateStatus(delivery, 'Delivered')"
            rounded="false"
            title="Delivery Complete"
            color="white" 
            square
            />
          </td>
        </tr>
      </tbody>
    </table>

    <!-- Pagination Controls -->
    <div class="pagination mt-4">
      <button @click="prevPage" :disabled="currentPage === 1" class="bg-blue-500 text-white p-2 rounded mr-2">
        Previous
      </button>
      <span>Page {{ currentPage }} of {{ totalPages }}</span>
      <button @click="nextPage" :disabled="currentPage === totalPages" class="bg-blue-500 text-white p-2 rounded ml-2">
        Next
      </button>
    </div>

    <!-- Modal for Delivery Details -->
    <modal v-if="showModal" @close="showModal = false">
      <template v-slot:header>
        <h2>Delivery Details for {{ selectedDelivery.id }}</h2>
      </template>
      <template v-slot:body>
        <!-- Detailed Information about the Delivery -->
        <p>Details about delivery go here...</p>
      </template>
    </modal>
  </div>
</template>

<script>
import { apiService } from '~/api/apiService';
import { format } from "date-fns";

export default {
  data() {
    return {
      users:[],
      deliveries: [], // Array to hold delivery records
      // totalDeliveries: 0,
      // pendingDeliveries: 0,
      // delivered: 0,
      // cancelled: 0,
      showModal: false,
      selectedDelivery: null,
      currentPage: 1,
      itemsPerPage: 5, // Number of deliveries per page
    };
  },
  computed: {
    totalPages() {
      return Math.ceil(this.deliveries.length / this.itemsPerPage);
    },
    paginatedDeliveries() {
      const start = (this.currentPage - 1) * this.itemsPerPage;
      return this.deliveries.slice(start, start + this.itemsPerPage);
    },
    totalDeliveries(){
      return this.deliveries.filter((item) => item.deliveryDate === format(new Date(),'yyyy-MM-dd') && item.deliveryStatus !== 'Delivered')?.length
    },
    pendingDeliveries(){
      return this.deliveries.filter((item) => item.deliveryStatus === 'Processed delivery')?.length
    },
    delivered(){
      return this.deliveries.filter((item) => item.deliveryStatus === 'Delivered')?.length
    },
    rescheduled(){
      return this.deliveries.filter((item) => item.deliveryStatus === 'Rescheduled delivery')?.length
    }
  },
  methods: {
    statusClass(status) {
      switch (status) {
        case 'Waiting for delivery':
          return 'bg-yellow-500';
        case 'Delivered':
          return 'bg-green-500';
        case 'Rescheduled delivery':
          return 'bg-red-500';
        default:
          return 'bg-gray-500';
      }
    },
    getSupplierName(userID) {
      const supplier = this.users?.find((value) => value.userID === userID);
      return supplier
        ? `${supplier.lastName} ${supplier.firstName}`
        : "Unknown";
    },
    viewDetails(delivery) {
      this.selectedDelivery = delivery;
      this.showModal = true;
    },
   async updateStatus(delivery, newStatus) {
      // Update delivery status logic
      delivery.deliveryStatus = newStatus;
      let qtyReceived = delivery?.admin_order?.admin_order_detail?.reduce((total, detail) => {
      return total + parseFloat(detail.qtyOrdered);
      }, 0);
      await apiService.put(`/api/adminDeliveries/${delivery.adminDlvrID}`, {
        adminDlvrID: delivery.adminDlvrID,
        adminOrdID: delivery.adminOrdID,
        deliveryDate: delivery.deliveryDate,
        deliveryStatus: delivery.deliveryStatus,
        qtyReceived,
      })
      alert(`Delivery ID ${delivery.adminDlvrID} marked as ${newStatus}`);
    },
    cancelDelivery(delivery) {
      // Cancel the delivery
      delivery.status = 'Cancelled';
      alert(`Delivery ID ${delivery.id} has been cancelled`);
    },
    async fetchDeliveries() {
      const result = await apiService.get("/api/adminDeliveries")

      this.deliveries = result.data
    },
    nextPage() {
      if (this.currentPage < this.totalPages) {
        this.currentPage++;
      }
    },
    prevPage() {
      if (this.currentPage > 1) {
        this.currentPage--;
      }
    },
  async fetchUserData() {
      const result = await apiService.get("/api/users");
      this.users = result.data;
    },
  },
  async mounted() {
    await this.fetchUserData()
    await this.fetchDeliveries(); // Call the fetch method when the component is mounted
  },
};
</script>
  
  <style scoped>
  .container {
    font-family: 'Arial', sans-serif;
    background-color: #f9fafb;
    padding: 50px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  }
  

  
  table {
    width: 100%;
    border-collapse: collapse;
  }
  
  th,
  td {
    padding: 12px 15px;
    text-align: left;
  }
  
  th {
    background-color: rgb(212, 209, 209);
    color: black;
    text-transform: uppercase;
  }
  
  tbody tr:nth-child(even) {
    background-color: #f2f2f2;
  }
  
  /* Table Row Hover Effect */
  tbody tr:hover {
    background-color: #d1e7f7;
    cursor: pointer;
  }
  
  button {
    cursor: pointer;
    transition: all 0.3s ease-in-out;
  }
  
  /* Action Button Styles */
  button i {
    font-size: 1.2rem;
  }
  
  button:hover i {
    color: #0e76a8; /* Slight hover effect for the eye icon */
  }
  
  /* Modal Styling */
  .fixed {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
  }
  
  .bg-gray-600 {
    background-color: rgba(0, 0, 0, 0.75);
  }
  
  .bg-white {
    background-color: white;
  }
  
  .p-6 {
    padding: 24px;
  }
  
  .rounded-md {
    border-radius: 8px;
  }
  
  button {
    padding: 8px 12px;
    border-radius: 5px;
    font-weight: bold;
  }
  
  .bg-blue-500 {
    background-color: #0e8bf1;
  }
  
  .bg-blue-500:hover {
    background-color: #1069b5;
  }
  
  .text-blue-600 {
    color: #0e8bf1;
  }
  
  .text-blue-600:hover {
    color: #0c6399;
  }
  
  .text-red-600 {
    color: #e3342f;
  }
  
  .text-red-600:hover {
    color: #c7281d;
  }
  
  /* Buttons Hover Effect */
  button:hover {
    transform: scale(1.05);
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
  }
  
  /* Add Responsive Table */
  @media (max-width: 768px) {
    table {
      display: block;
      width: 100%;
      overflow-x: auto;
      white-space: nowrap;
    }
  
    th,
    td {
      padding: 10px;
    }
  }
  .pagination {
  display: flex;
  align-items: center;
  justify-content: center;
}

.pagination button {
  margin: 0 5px;
  padding: 8px 12px;
  border-radius: 5px;
  font-weight: bold;
  cursor: pointer;
  transition: all 0.3s ease-in-out;
}

.pagination button:disabled {
  background-color: #ccc;
  cursor: not-allowed;
}

.pagination span {
  margin: 0 10px;
}
</style>
  