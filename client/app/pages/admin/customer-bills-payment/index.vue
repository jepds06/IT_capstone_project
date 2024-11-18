<template>
  <div class="m-8 space-y-6">
    <!-- Title -->
    <h1 class="text-2xl font-extrabold">Reports</h1>

    <!-- Overview Cards -->
    <div class="grid grid-cols-3 gap-4">
      <div class="bg-gray-500 text-white p-4 rounded-lg shadow">
        <h2 class="text-base font-semibold">Total Sales</h2>
        <p class="text-2xl mt-2 text-center">
          {{
            new Intl.NumberFormat("en-PH", {
              style: "currency",
              currency: "PHP",
            }).format(totalSales)
          }}
        </p>
      </div>
      <div class="bg-gray-500 text-white p-4 rounded-lg shadow">
        <h2 class="text-base font-semibold">Completed Orders</h2>
        <p class="text-2xl mt-2 text-center">{{completedOrders}}</p>
      </div>
      <div class="bg-gray-500 text-white p-4 rounded-lg shadow">
        <h2 class="text-base font-semibold">Waiting for delivery</h2>
        <p class="text-2xl mt-2 text-center">{{waitingForDeliveries}}</p>
      </div>
      <!-- <div class="bg-gray-500 text-white p-4 rounded-lg shadow">
        <h2 class="text-base font-semibold">Processed Delivery</h2>
        <p class="text-2xl mt-2 text-center">{{processedDeliveries}}</p>
      </div> -->
    </div>

    <!-- Filter Options -->
    <div class="flex gap-4">
      <input
        type="text"
        v-model="searchQuery"
        placeholder="Search by Order ID or Customer Name"
        class="px-4 py-2 w-full rounded border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500"
      />
      <!-- <input
        type="date"
        v-model="startDate"
        class="px-4 py-2 rounded border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500"
      />
      <input
        type="date"
        v-model="endDate"
        class="px-4 py-2 rounded border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500"
      /> -->
      <!-- <button
        @click="applyFilters"
        class="px-6 py-2 bg-blue-600 text-white rounded shadow hover:bg-blue-700"
      >
        Generate Report
      </button> -->
    </div>

    <!-- Export Options -->
    <div class="flex justify-end mb-4">
      <button
        @click="exportPDF"
        class="px-4 py-2 bg-red-600 text-white rounded shadow hover:bg-red-700 mr-2"
      >
        Export to PDF
      </button>
      <button
        @click="exportCSV"
        class="px-4 py-2 bg-green-600 text-white rounded shadow hover:bg-green-700"
      >
        Export to CSV
      </button>
    </div>

    <!-- Report Table -->
    <div class="overflow-x-auto">
      <table
        class="min-w-full bg-white border border-gray-300 rounded-lg shadow overflow-hidden"
      >
        <thead class="bg-gray-500 text-white uppercase tracking-wide text-sm">
          <tr>
            <th class="py-3 px-4 text-left">Order ID</th>
            <th class="py-3 px-4 text-left">Customer Name</th>
            <th class="py-3 px-4 text-left">Total Amount</th>
            <th class="py-3 px-4 text-left">Order Date</th>
            <th class="py-3 px-4 text-left">Status</th>
            <th class="py-3 px-4 text-left">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="report in filteredReports"
            :key="report.salesID"
            class="border-b hover:bg-gray-100"
          >
            <td class="px-6 py-3">{{ report.salesID }}</td>
            <td class="px-6 py-3">{{ getUserName(report.userID) }}</td>
            <td class="px-6 py-3">
              {{
                new Intl.NumberFormat("en-PH", {
                  style: "currency",
                  currency: "PHP",
                }).format(report.totalAmount)
              }}
            </td>
            <td class="px-6 py-3">{{ report.salesDate }}</td>
            <td class="px-6 py-3">
              <i
                :class="getStatusIcon(report.sales_deliveries.deliveryStatus)"
                :title="report.sales_deliveries.deliveryStatus"
              ></i>
            </td>
            <td class="px-6 py-3 flex gap-3">
                <button @click="viewReport(report.salesID)" class="text-blue-500 hover:text-blue-700">
                  <i class="fa-solid fa-eye"></i>
                </button>
                <button @click="editReport(report.salesID)" class="text-yellow-500 hover:text-yellow-700">
                  <i class="fa-solid fa-edit"></i>
                </button>
              </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    <div class="flex justify-between items-center mt-4">
      <span class="text-sm text-gray-500">
        Showing {{ start + 1 }} to {{ end }} of {{ reports.length }} reports
      </span>
      <div class="flex gap-4">
        <button
          :disabled="page === 1"
          @click="page--"
          class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300 disabled:opacity-50"
        >
          Previous
        </button>
        <button
          :disabled="page * itemsPerPage >= reports.length"
          @click="page++"
          class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300 disabled:opacity-50"
        >
          Next
        </button>
      </div>
    </div>

    <!-- View Modal -->
    <div v-if="isViewModalOpen" class="modal-overlay">
      <div class="modal-content">
        <h2 class="text-lg font-semibold">Report Details</h2>
        <p>Order ID: {{ modalData.salesID }}</p>
        <p>Customer Name: {{ getUserName(modalData.userID) }}</p>
        <button
          @click="closeModal"
          class="mt-4 bg-blue-600 text-white px-4 py-2 rounded"
        >
          Close
        </button>
      </div>
    </div>

    <!-- Edit Modal -->
    <div v-if="isEditModalOpen" class="modal-overlay">
      <div class="modal-content">
        <h2 class="text-lg font-semibold">Edit Report</h2>
        <label>
          Total Amount:
          <input
            v-model="modalData.totalAmount"
            class="mt-2 p-2 border rounded"
            type="text"
          />
        </label>
        <button
          @click="saveChanges"
          class="mt-4 bg-green-600 text-white px-4 py-2 rounded"
        >
          Save
        </button>
        <button
          @click="closeModal"
          class="mt-4 bg-gray-600 text-white px-4 py-2 rounded"
        >
          Cancel
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import auth from "../../../../middleware/auth";
// This page requires authentication
definePageMeta({
  middleware: [auth],
});
import { ref, computed } from "vue";
import { jsPDF } from "jspdf"; // Import jsPDF for PDF generationpnpm install jspdf
import { apiService } from "~/api/apiService";
import { format } from 'date-fns';

const reports = ref([
  // { orderID: 101, customerName: "Maria Santos", totalAmount: "₱15,000", orderDate: "2024-11-01", status: "Completed" },
  // Additional report data
]);

const users = ref([]);

const exportPDF = () => {
  const doc = new jsPDF();
  doc.text("Reports", 10, 10);

  let yOffset = 20; // Starting y-axis position
  reports.value.forEach((report, index) => {
    doc.text(`${index + 1}. Order ID: ${report.orderID}`, 10, yOffset);
    doc.text(`Customer Name: ${report.customerName}`, 10, yOffset + 10);
    doc.text(`Total Amount: ${report.totalAmount}`, 10, yOffset + 20);
    doc.text(`Order Date: ${report.orderDate}`, 10, yOffset + 30);
    doc.text(`Status: ${report.status}`, 10, yOffset + 40);
    yOffset += 50; // Move down for the next report
  });

  doc.save("Report.pdf");
};

const exportCSV = () => {
  const headers = [
    "Order ID",
    "Customer Name",
    "Total Amount",
    "Order Date",
    "Status",
  ];
  const csvContent = [
    headers.join(","), // CSV headers
    ...reports.value
      .slice(0, 5)
      .map((report) =>
        [
          report.orderID,
          report.customerName,
          report.totalAmount,
          report.orderDate,
          report.status,
        ].join(",")
      ),
  ].join("\n");

  const blob = new Blob([csvContent], { type: "text/csv;charset=utf-8;" });
  const url = URL.createObjectURL(blob);
  const link = document.createElement("a");
  link.setAttribute("href", url);
  link.setAttribute("download", "Report.csv");
  link.style.visibility = "hidden";
  document.body.appendChild(link);
  link.click();
  document.body.removeChild(link);
};

const searchQuery = ref("");
const startDate = ref("");
const endDate = ref("");
const page = ref(1);
const itemsPerPage = 5;

const isViewModalOpen = ref(false);
const isEditModalOpen = ref(false);
const modalData = ref({});

const filteredReports = computed(() => {
  return reports.value
    .filter(
      (report) =>{
        return report.salesID.toString().includes(searchQuery.value) ||
        getUserName(report.userID)
          .toLowerCase()
          .includes(searchQuery.value.toLowerCase())
      }
        
    )
    .slice(start.value, end.value);
});

const totalSales = computed(() => {
  return reports.value.reduce(
    (sum, item) => parseFloat(sum) + parseFloat(item.totalAmount),
    0
  );
});

const completedOrders = computed(() => {
  return reports.value.filter((value) => value?.sales_deliveries?.deliveryStatus === 'Completed')?.length;
});

const waitingForDeliveries = computed(() => {
  return reports.value.filter((value) => value?.sales_deliveries?.deliveryStatus === 'Waiting for delivery')?.length;
});

// const processedDeliveries = computed(() => {
//   return reports.value.filter((value) => value?.sales_deliveries?.deliveryStatus === 'Processed delivery')?.length;
// });

const start = computed(() => (page.value - 1) * itemsPerPage);
const end = computed(() =>
  Math.min(page.value * itemsPerPage, reports.value.length)
);

const getStatusIcon = (status) => {
  return {
    ["Completed"]: "fa-solid fa-check-circle text-green-500",
    ["Waiting for delivery"]: "fa-solid fa-hourglass-half text-yellow-500",
    ["Processed delivery"]: "fa-solid fa-times-circle text-red-500",
  }[status];
};

const viewReport = (salesID) => {
  const report = reports.value.find((r) => r.salesID === salesID);
  modalData.value = { ...report };
  isViewModalOpen.value = true;
};

const editReport = (salesID) => {
  const report = reports.value.find((r) => r.salesID === salesID);
  modalData.value = { ...report };
  isEditModalOpen.value = true;
};

const closeModal = () => {
  isViewModalOpen.value = false;
  isEditModalOpen.value = false;
};

const saveChanges = () => {
  console.log("Saving changes:", modalData.value);
  closeModal();
};

const getUserName = (userID) => {
  const user = users.value?.find((us) => us.userID === userID);
  return user ? `${user.lastName}, ${user.firstName}` : "Unknown";
};

const fetchUsersData = async () => {
  const result = await apiService.get("/api/users");
  users.value = result.data;
};
const fetchSalesData = async () => {
  const result = await apiService.get("/api/sales");

  reports.value = result.data?.map((value) => {
    const totalAmount = value.sales_orders?.reduce(
      (sum, item) => parseFloat(sum) + parseFloat(item.amount),
      0
    );
    return {
      ...value,
      totalAmount,
    };
  });
};

onMounted(async () => {
  await fetchUsersData();
  await fetchSalesData();
});
</script>

<style scoped>
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
}

.modal-content {
  background: white;
  padding: 2rem;
  border-radius: 0.5rem;
  width: 400px;
}
</style>
