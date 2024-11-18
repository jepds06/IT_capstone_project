<template>
  <div class="mx-auto py-10">
    <!-- Quotation Table -->
    <h2 class="text-2xl font-bold mb-6">Purchase Orders</h2>

    <!-- Search Bar -->
    <input
      v-model="searchQuery"
      type="text"
      placeholder="Search..."
      class="p-2 border border-gray-300 rounded w-48 mb-4"
    />
    <table class="table-auto w-full bg-white shadow-lg rounded-lg">
      <thead>
        <tr class="bg-gray-200">
          <th class="p-4 text-center">PO ID</th>
          <th class="p-4 text-center">Supplier</th>
          <th class="p-4 text-center">Quotation ID</th>
          <th class="p-4 text-center">Total Amount</th>
          <th class="p-4 text-center">Status</th>
          <th class="p-4 text-center">Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="po in paginatedPurchaseOrders" :key="po.id" class="border-t">
          <td class="p-4 text-center">{{ po.id }}</td>
          <td class="p-4 text-center">
            {{ getSupplierName(po?.quotation?.userID) }}
          </td>
          <td class="p-4 text-center">{{ `QN-${po.quoteID}` }}</td>
          <td class="p-4 text-center">
            {{
              new Intl.NumberFormat("en-PH", {
                style: "currency",
                currency: "PHP",
              }).format(po.totalAmount)
            }}
          </td>
          <td class="p-4 text-center">
            <span
              :class="statusClass(po.status)"
              class="py-1 px-3 rounded-full text-white text-sm"
            >
              {{ po.status }}
            </span>
          </td>
          <td class="p-4 text-center">
            <button @click="viewDetails(po)" class="text-blue-600 mr-2">
              <i class="fas fa-eye"></i>
              <!-- View Icon -->
            </button>
            <!-- Mark as Delivered Icon -->
            <!-- <button @click="updateStatus(po, 'Waiting for Delivery')" class="text-yellow-600 mr-2">
              <i class="fas fa-truck"></i> 
            </button> -->
            <!-- Cancel Icon -->
            <!-- <button @click="cancelPO(po)" class="text-red-600">
              <i class="fas fa-trash"></i> 
            </button> -->
          </td>
        </tr>
      </tbody>
    </table>

    <div
      v-if="statusMessage"
      class="mt-4 p-2 bg-green-100 text-green-700 rounded-md"
    >
      {{ statusMessage }}
    </div>

    <!-- Modal for Supplier Material Selection -->
    <div
      v-if="selectedPO"
      class="fixed inset-0 bg-gray-600 bg-opacity-75 flex items-center justify-center z-50"
    >
      <div class="bg-white p-6 rounded-md w-1/2">
        <h3 class="text-lg font-bold mb-2">{{`Materials for Purchase Order No: ${ selectedPO.id}`}}</h3>
        
        <label for="materialId" class="block mb-2 mt-4 text-black"
          >Supplier:<span>{{
            `${getSupplierName(selectedPO.quotation?.userID)}`
          }}</span></label
        >
        <label for="materialId" class="block mb-2 mt-4 text-black"
          >Quotation No: <span>{{ `QN-${selectedPO.quoteID}` }}</span></label
        >
        <!-- Scrollable Table Container -->
        <div
          class="max-h-64 overflow-y-auto border border-gray-300 rounded-md mb-4"
        >
          <table class="min-w-full bg-white">
            <thead class="bg-gray-200">
              <tr>
                <th class="py-2 px-4 text-left">Material ID</th>
                <th class="py-2 px-4 text-left">Product Material</th>
                <th class="py-2 px-4 text-left">Quantity</th>
                <th class="py-2 px-4 text-left">Amount</th>
              </tr>
            </thead>
            <tbody>
              <tr
                v-for="(material, index) in selectedPO.admin_order_detail"
                :key="material.id"
                class="border-t"
              >
                <td class="py-2 px-4">{{ index + 1 }}</td>
                <td class="py-2 px-4">
                  {{ this.getMaterialProductName(material?.prodtnMtrlID) }}
                </td>
                <td class="py-2 px-4">{{ material.qtyOrdered }}</td>
                <td class="py-2 px-4">
                  {{
                    new Intl.NumberFormat("en-PH", {
                      style: "currency",
                      currency: "PHP",
                    }).format(material.amount)
                  }}
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- <button @click="confirmMaterialsSelection" class="bg-blue-500 text-white px-4 py-2 rounded-md">Confirm</button> -->
        <div class="flex justify-between">
          <UButton @click="closeModal" color="red" label="Close" icon="material-symbols:close"  />
          <UButton @click="updateStatus(selectedPO, 'Approved')" color="green" label="Approved" icon="material-symbols-light:list-alt-check-outline-sharp" :disabled="selectedPO.isApproved === 1"/>
        </div>
      
      </div>
    </div>

    <!-- Pagination -->
    <div class="flex justify-between items-center mt-4">
      <button
        @click="prevPage"
        :disabled="currentPage === 1"
        class="bg-gray-300 px-4 py-2 rounded"
      >
        Previous
      </button>
      <span>Page {{ currentPage }} of {{ totalPages }}</span>
      <button
        @click="nextPage"
        :disabled="currentPage === totalPages"
        class="bg-gray-300 px-4 py-2 rounded"
      >
        Next
      </button>
    </div>
  </div>
</template>

<script>
import { apiService } from "~/api/apiService";

export default {
  data() {
    return {
      users: [],
      purchaseOrders: [],
      selectedPO: null,
      statusMessage: "",
      modalMessage: "",
      searchQuery: "",
      currentPage: 1,
      itemsPerPage: 5,
    };
  },

  computed: {
    filteredPurchaseOrders() {
      return this.purchaseOrders.filter(
        (po) =>
          this.getSupplierName(po.quotation.userID).toLowerCase().includes(this.searchQuery.toLowerCase())
      );
    },
    totalPages() {
      return Math.ceil(this.filteredPurchaseOrders.length / this.itemsPerPage);
    },
    paginatedPurchaseOrders() {
      const start = (this.currentPage - 1) * this.itemsPerPage;
      const end = start + this.itemsPerPage;
      return this.filteredPurchaseOrders.slice(start, end);
    },
  },
  async mounted() {
    await this.fetchUserData();
    await this.fetchAdminOrders();
  },
  methods: {
    previousPage() {
      if (this.currentPage > 1) {
        this.currentPage--;
      }
    },
    nextPage() {
      if (this.currentPage < this.totalPages) {
        this.currentPage++;
      }
    },
    setTemporaryMessage(messageType, message) {
      if (messageType === "status") {
        this.statusMessage = message;
      } else if (messageType === "modal") {
        this.modalMessage = message;
      }
      setTimeout(() => {
        if (messageType === "status") {
          this.statusMessage = "";
        } else if (messageType === "modal") {
          this.modalMessage = "";
        }
      }, 3000);
    },
    statusClass(status) {
      switch (status) {
        case "Pending":
          return "bg-yellow-500";
        case "Waiting for Delivery":
          return "bg-blue-500";
        case "Delivered":
          return "bg-green-500";
        case "In Progress":
          return "bg-red-500";
        default:
          return "bg-gray-500";
      }
    },
    async viewDetails(po) {
      await this.fetchMaterialsByProductionID(po.quotation.productionID);
      this.selectedPO = po;
      this.modalMessage = "";
    },
    closeModal() {
      this.selectedPO = null;
      this.modalMessage = "";
    },
    removeMaterial(material) {
      this.selectedPO.materials = this.selectedPO.materials.filter(
        (m) => m.id !== material.id
      );
      this.setTemporaryMessage(
        "modal",
        `Material ${material.name} has been removed.`
      );
    },
    confirmMaterialsSelection() {
      this.setTemporaryMessage("status", "Materials selection confirmed.");
      this.closeModal();
    },
    async updateStatus(po, newStatus) {
      po.status = newStatus;
      po.isApproved = true;
      await apiService.put(`/api/adminOrders/${po.adminOrdID}`, po);
      this.setTemporaryMessage(
        "status",
        `PO ID ${po.id} marked as ${newStatus}.`
      );
      this.fetchAdminOrders();
      this.closeModal();
    },
    cancelPO(po) {
      po.status = "Cancelled";
      this.setTemporaryMessage("status", `PO ID ${po.id} has been cancelled.`);
    },
    getSupplierName(userID) {
      const supplier = this.users?.find((value) => value.userID === userID);
      return supplier
        ? `${supplier.lastName} ${supplier.firstName}`
        : "Unknown";
    },
    getMaterialProductName(prodtnMtrlID) {
      const material = this.materials?.find(
        (val) => val.prodtnMtrlID == prodtnMtrlID
      );
      return `${material?.productName} -> ${material?.description}`;
    },
    async fetchMaterialsByProductionID(productionID) {
      const result = await apiService.get(
        `/api/materials/production/${productionID}`
      );
      this.materials = result;
    },
    async fetchUserData() {
      const result = await apiService.get("/api/users");
      this.users = result.data;
    },
    async fetchAdminOrders() {
      const result = await apiService.get("/api/adminOrders");
      const transFormData = result.data?.map((value, index) => {
        const totalAmount = value.admin_order_detail.reduce((total, detail) => {
          return total + parseFloat(detail.amount);
        }, 0);
        
        if (value.isApproved === 1){
          value.status = "Approved";
        }
        if (value.admin_payments) {
          value.status = "In Progress";
        }
        if (value.admin_deliveries) {
          if(value.admin_deliveries.deliveryStatus === 'Delivered'){
            value.status = value.admin_deliveries.deliveryStatus;
          } else {
          value.status = "Waiting for Delivery";
        }
        }
        if (!value.status) {
          value.status = "Pending";
        }
        return {
          ...value,
          totalAmount,
          id: (index + 1).toString(),
        };
      });
      this.purchaseOrders = transFormData;
    },
  },
};
</script>

<style scoped>
.container {
  font-family: "Arial", sans-serif;
  background-color: #f9fafb;
  padding: 50px;
  border-radius: 10px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

h2 {
  color: #333;
  margin-bottom: 20px;
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

tbody tr:hover {
  background-color: #d1e7f7;
  cursor: pointer;
}

button {
  cursor: pointer;
  transition: all 0.3s ease-in-out;
}

button i {
  font-size: 1.2rem;
}

button:hover i {
  color: #0e76a8;
}

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

button:hover {
  transform: scale(1.05);
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
}

@media (max-width: 768px) {
  table {
    display: block;
    width: 100%;
    overflow-x: auto;
  }
}
</style>
