<template>
  <div class="m-8">
    <!-- Title -->
    <h1 class="text-2xl font-extrabold mb-4">Bills Payment</h1>

    <!-- Search Bar -->
    <div class="mb-4 flex gap-2">
      <input
        type="text"
        v-model="searchQuery"
        placeholder="Search by Payment ID or Supplier Name"
        class="px-4 py-2 w-1/3 rounded border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500"
      />
    </div>

    <!-- Payment Table -->
    <div class="overflow-x-auto">
      <table
        class="min-w-full bg-white border border-gray-300 rounded-lg shadow overflow-hidden"
      >
        <thead class="bg-gray-500 text-white uppercase tracking-wide text-sm">
          <tr>
            <th class="py-3 px-4 text-left">Production ID</th>
            <th class="py-3 px-4 text-left">Supplier</th>
            <th class="py-3 px-4 text-left">Payment Date</th>
            <th class="py-3 px-4 text-left">Amount</th>
            <th class="py-3 px-4 text-left">Status</th>
            <th class="py-3 px-4 text-left">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="payment in filteredPayments"
            :key="payment.adminPayID"
            class="border-b hover:bg-gray-100"
          >
            <td class="px-6 py-3">
              {{ payment?.admin_order?.quotation?.productionID }}
            </td>
            <td class="px-6 py-3">
              {{ getSupplierName(payment?.admin_order?.quotation?.userID) }}
            </td>
            <td class="px-6 py-3">
              {{payment.paymentDate
              }}
            </td>
            <td class="px-6 py-3">
              {{
                new Intl.NumberFormat("en-PH", {
                  style: "currency",
                  currency: "PHP",
                }).format(payment.amountPaid)
              }}
            </td>
            <td class="px-6 py-3">
              <span
                :class="{
                  'text-green-500': payment.paymentStatus === 'completed',
                  'text-yellow-500': payment.paymentStatus === 'pending',
                  'text-red-500': payment.paymentStatus === 'cancelled',
                }"
              >
                <i
                  :class="{
                    'fa-solid fa-check-circle':
                      payment.paymentStatus === 'completed',
                    'fa-solid fa-hourglass-half':
                      payment.paymentStatus === 'pending',
                    'fa-solid fa-times-circle':
                      payment.paymentStatus === 'cancelled',
                  }"
                ></i>
              </span>
            </td>
            <td class="px-6 py-3 flex gap-3">
              <!-- View and Edit Button Icons -->
              <button
                @click="openModal('view', payment.adminPayID)"
                class="text-blue-500 hover:text-blue-700"
              >
                <i class="fa-solid fa-eye"></i>
              </button>
              <!-- <button @click="openModal('edit', payment.adminPayID)" class="text-yellow-500 hover:text-yellow-700">
                  <i class="fa-solid fa-edit"></i>
                </button> -->
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    <div class="flex justify-between items-center mt-4">
      <span class="text-sm text-gray-500"
        >Showing {{ start + 1 }} to {{ end }} of
        {{ payments?.length }} payments</span
      >
      <div class="flex gap-4">
        <button
          :disabled="page === 1"
          @click="page--"
          class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300 disabled:opacity-50"
        >
          Previous
        </button>
        <button
          :disabled="page * itemsPerPage >= payments?.length"
          @click="page++"
          class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300 disabled:opacity-50"
        >
          Next
        </button>
      </div>
    </div>

    <!-- Success Popup after Deletion -->
    <div
      v-if="showDeleteNotification"
      class="fixed bottom-10 right-10 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg transition-opacity duration-300"
    >
      <p>{{ deleteMessage }}</p>
    </div>

    <!-- View Modal -->
    <div
      v-if="modalType === 'view'"
      class="fixed inset-0 flex justify-center items-center bg-black bg-opacity-50"
    >
      <div class="bg-white p-6 rounded-lg w-1/3">
        <h3 class="text-xl font-semibold mb-4">View Payment Details</h3>
        <p><strong>Payment ID:</strong> {{ currentPayment.adminPayID }}</p>
        <p>
          <strong>Customer Name:</strong>
          {{ getUserName(currentPayment.admin_order.userID) }}
        </p>
        <p>
          <strong>Total Amount:</strong>
          {{
            new Intl.NumberFormat("en-PH", {
              style: "currency",
              currency: "PHP",
            }).format(currentPayment.amountToPay)
          }}
        </p>
        <p>
          <strong>Paid Amount:</strong>
          {{
            new Intl.NumberFormat("en-PH", {
              style: "currency",
              currency: "PHP",
            }).format(currentPayment.amountPaid)
          }}
        </p>
        <p>
          <strong>Unpaid Amount:</strong>
          {{
            new Intl.NumberFormat("en-PH", {
              style: "currency",
              currency: "PHP",
            }).format(currentPayment.amountToPay - currentPayment.amountPaid)
          }}
        </p>
        <p>
          <strong>Payment Method:</strong>
          {{ getPaymentMethod(currentPayment.payMethodID) }}
        </p>
        <p>
          <strong>Status:</strong>
          <span :class="statusClass(currentPayment.paymentStatus)">{{
            currentPayment.paymentStatus
          }}</span>
        </p>
        <button
          @click="closeModal"
          class="mt-4 px-4 py-2 bg-red-500 text-white rounded"
        >
          Close
        </button>
      </div>
    </div>

    <!-- Edit Modal -->
    <div
      v-if="modalType === 'edit'"
      class="fixed inset-0 flex justify-center items-center bg-black bg-opacity-50"
    >
      <div class="bg-white p-6 rounded-lg w-1/3">
        <h3 class="text-xl font-semibold mb-4">Edit Payment</h3>
        <input
          v-model="currentPayment.totalAmount"
          class="mb-4 p-2 w-full border border-gray-300 rounded"
          placeholder="Amount"
        />
        <select
          v-model="currentPayment.status"
          class="mb-4 p-2 w-full border border-gray-300 rounded"
        >
          <option value="Completed">Completed</option>
          <option value="Pending">Pending</option>
          <option value="Failed">Failed</option>
        </select>
        <button
          @click="saveEdit"
          class="mr-2 px-4 py-2 bg-yellow-500 text-white rounded"
        >
          Save
        </button>
        <button
          @click="closeModal"
          class="px-4 py-2 bg-red-500 text-white rounded"
        >
          Cancel
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { apiService } from "~/api/apiService";
import auth from "../../../../middleware/auth";
// This page requires authentication
definePageMeta({
  middleware: [auth],
});
import { ref, computed } from "vue";

const payments = ref([
  // Add more payment records as necessary
]);

const users = ref([]);
const paymentMethods = ref([]);
const searchQuery = ref("");
const page = ref(1);
const itemsPerPage = 5;
const showDeleteNotification = ref(false);
const deleteMessage = ref("");
const modalType = ref(null);
const currentPayment = ref({});

const filteredPayments = computed(() => {
  return payments.value?.filter(
    (payment) =>
      payment?.id?.toString().includes(searchQuery.value) ||
      getSupplierName(payment?.admin_order?.quotation?.userID)
        .toLowerCase()
        .includes(searchQuery.value.toLowerCase())
  );
});

const start = computed(() => (page.value - 1) * itemsPerPage);
const end = computed(() =>
  Math.min(page.value * itemsPerPage, payments.value?.length)
);

const openModal = (type, adminPayID) => {
  const payment = payments.value.find(
    (payment) => payment.adminPayID === adminPayID
  );
  currentPayment.value = { ...payment }; // Create a copy to avoid modifying original data
  modalType.value = type;
};

const closeModal = () => {
  modalType.value = null;
};

const statusClass = (status) => {
  return {
    "text-green-500": status === "completed",
    "text-yellow-500": status === "pending",
    "text-red-500": status === "cancelled",
  };
};

const saveEdit = () => {
  const index = payments.value.findIndex(
    (payment) => payment.adminPayID === currentPayment.value.adminPayID
  );
  if (index !== -1) {
    payments.value[index] = { ...currentPayment.value };
    closeModal();
  }
};

const deletePayment = (adminPayID) => {
  const index = payments.value.findIndex(
    (payment) => payment.adminPayID === adminPayID
  );
  if (index !== -1) {
    payments.value.splice(index, 1);
    showDeleteNotification.value = true;
    deleteMessage.value = `Payment ID ${adminPayID} successfully deleted!`;

    setTimeout(() => {
      showDeleteNotification.value = false;
    }, 3000);
  }
};

const getUserName = (userID) => {
  const user = users.value?.find((us) => us.userID === userID);
  return user ? `${user.lastName}, ${user.firstName}` : "Unknown";
};

const getSupplierName = (userID) => {
  const user = users.value?.find((us) => us.userID === userID);
  return user ? `${user.lastName} ${user.firstName}` : "Unknown";
};

const getPaymentMethod = (payMethodID) => {
  const payment = paymentMethods.value?.find(
    (us) => us.payMethodID === payMethodID
  );
  return payment ? payment.payMethodName : "Unknown";
};
const fetchPaymentsData = async () => {
  const result = await apiService.get("/api/adminPayments");
  console.log(result);
  payments.value = result.data;
};

const fetchPaymentMehtodsData = async () => {
  const result = await apiService.get("/api/paymentMethods");
  paymentMethods.value = result.data;
};

const fetchUserData = async () => {
  const result = await apiService.get("/api/users");
  users.value = result.data?.map((value, index) => {
    return {
      ...value,
      id: index + 1,
    };
  });
};

onMounted(async () => {
  await fetchUserData();
  await fetchPaymentsData();
  await fetchPaymentMehtodsData();
});
</script>

<style scoped>
::-webkit-scrollbar {
  height: 8px;
}
::-webkit-scrollbar-thumb {
  background-color: #6b7280;
  border-radius: 8px;
}
</style>
