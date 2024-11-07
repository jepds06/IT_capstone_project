<template>
  <div class="p-6 bg-gray-50 min-h-screen">
    <!-- Main Tabs -->
    <div class="mb-8">
      <ul class="flex justify-around border-b">
        <li
          class="pb-2 cursor-pointer text-lg font-medium"
          :class="{ 'border-b-2 border-blue-500 text-blue-600': activeTab === 'itemcart' }"
          @click="activeTab = 'itemcart'"
        >
          Item Cart
        </li>
        <li
          class="pb-2 cursor-pointer text-lg font-medium"
          :class="{ 'border-b-2 border-blue-500 text-blue-600': activeTab === 'billing' }"
          @click="activeTab = 'billing'"
        >
          Billing
        </li>
        <li
          class="pb-2 cursor-pointer text-lg font-medium"
          :class="{ 'border-b-2 border-blue-500 text-blue-600': activeTab === 'payment' }"
          @click="activeTab = 'payment'"
        >
          Payment
        </li>
      </ul>
    </div>

    <!-- Item Cart Section -->
<div v-if="activeTab === 'itemcart'" class="space-y-6">
  <!-- Item Cart Table -->
  <div class="bg-white p-4 rounded-lg shadow-md">
    <h2 class="text-lg font-bold mb-4">Item Cart</h2>
    <table class="w-full">
      <thead>
        <tr class="bg-gray-100">
          <th class="py-2 text-left">Product</th>
          <th class="py-2 text-left">Price</th>
          <th class="py-2 text-left">Quantity</th>
          <th class="py-2 text-left">Total</th>
          <th class="py-2 text-left">Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="product in filteredProducts" :key="product.productID">
          <td class="py-2">{{ product.productName }}</td>
          <td class="py-2">${{ product.unitPrice.toFixed(2) }}</td>
          <td class="py-2">
            <div class="flex items-center gap-2 border px-2 py-1 rounded">
              <button class="text-gray-500 hover:text-gray-800">-</button>
              <span class="text-lg font-semibold">1</span>
              <button class="text-gray-500 hover:text-gray-800">+</button>
            </div>
          </td>
          <td class="py-2">${{ (product.unitPrice * 1).toFixed(2) }}</td>
          <td class="py-2">
            <button @click="removeProduct(product.productID)" class="text-red-500 hover:text-red-700">🗑</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>

  <!-- Order Summary -->
  <div class="bg-white p-4 rounded-lg shadow-md">
    <h2 class="text-lg font-bold">Order Summary</h2>
    <div class="space-y-2 mt-4">
      <div class="flex justify-between text-gray-600">
        <span>Subtotal</span>
        <span>$30</span>
      </div>
      <div class="flex justify-between text-gray-600">
        <span>Discount 5%</span>
        <span>-$2</span>
      </div>
      <div class="flex justify-between text-gray-600">
        <span>Shipping Charges</span>
        <span>$0</span>
      </div>
      <div class="flex justify-between text-gray-800 font-bold mt-4">
        <span>Total</span>
        <span>$28</span>
      </div>
    </div>
  </div>

  <!-- Action Buttons (Outside Order Summary Card) -->
  <div class="flex justify-between mt-6">
    <button class="bg-gray-200 px-4 py-2 rounded">Continue Shopping</button>
    <button class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Checkout</button>
  </div>
</div>

    <!-- Billing Section -->
<div v-if="activeTab === 'billing'" class="space-y-6">
  <div class="flex justify-between items-center mb-4">
    <h2 class="text-lg font-bold">Billing Addresses</h2>
    <button @click="openAddAddressModal" class="bg-blue-500 text-white px-4 py-2 rounded">+ Add Address</button>
  </div>

  <!-- Billing Address Cards -->
  <div class="flex flex-wrap gap-4">
    <div
      v-for="address in billingAddresses"
      :key="address.id"
      class="bg-white p-4 rounded-lg shadow-md w-full md:w-1/3 relative"
    >
      <span v-if="address.default" class="absolute top-0 right-0 bg-blue-200 text-blue-600 px-2 py-1 text-xs font-semibold">Default</span>
      <div class="flex flex-col">
        <h3 class="font-semibold">{{ address.name }}</h3>
        <p class="text-sm text-gray-500">{{ address.buildingNo }}, {{ address.street }}, {{ address.state }}</p>
        <p class="text-sm text-gray-500">Contact: {{ address.contact }}</p>
      </div>
      <div class="flex justify-between mt-4">
        <button class="text-blue-500 hover:underline">Deliver To This Address</button>
        <div class="flex gap-2">
          <button class="text-gray-500">✏️</button>
          <button class="text-red-500">🗑</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Order Summary and Shipping Address Side by Side -->
  <div class="flex gap-4 mt-6">
    <!-- Order Summary -->
    <div class="bg-white p-4 rounded-lg shadow-md w-full md:w-2/3">
      <h2 class="text-lg font-bold">Order Summary</h2>
      <div class="space-y-2 mt-4">
        <div class="flex justify-between text-gray-600">
          <span>Subtotal</span>
          <span>$30</span>
        </div>
        <div class="flex justify-between text-gray-600">
          <span>Discount 5%</span>
          <span>-$2</span>
        </div>
        <div class="flex justify-between text-gray-600">
          <span>Shipping Charges</span>
          <span>$0</span>
        </div>
        <div class="flex justify-between text-gray-800 font-bold mt-4">
          <span>Total</span>
          <span>$28</span>
        </div>
      </div>
    </div>

    <!-- Shipping Address -->
    <div class="bg-white p-4 rounded-lg shadow-md w-full md:w-1/3">
      <h2 class="text-lg font-bold">Shipping Address</h2>
      <div class="bg-white p-4 rounded-lg shadow-md mt-4">
        <span class="absolute top-0 right-0 bg-blue-200 text-blue-600 px-2 py-1 text-xs font-semibold">Default</span>
        <div class="flex flex-col">
          <h3 class="font-semibold">{{ billingAddresses.find(address => address.default)?.name }}</h3>
          <p class="text-sm text-gray-500">
            {{ billingAddresses.find(address => address.default)?.buildingNo }},
            {{ billingAddresses.find(address => address.default)?.street }},
            {{ billingAddresses.find(address => address.default)?.state }}
          </p>
          <p class="text-sm text-gray-500">Contact: {{ billingAddresses.find(address => address.default)?.contact }}</p>
        </div>
        <div class="flex justify-between mt-4">
          <button class="text-blue-500 hover:underline">Deliver To This Address</button>
          <div class="flex gap-2">
            <button class="text-gray-500">✏️</button>
            <button class="text-red-500">🗑</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Buttons Outside Order Summary -->
  <div class="flex justify-between mt-6">
    <button @click="goBackToPreviousTab" class="bg-gray-200 px-4 py-2 rounded">Back</button>
    <button @click="placeOrder" class="bg-blue-500 text-white w-full md:w-auto py-2 rounded-lg hover:bg-blue-600">Place An Order</button>
  </div>
</div>

    <!-- Add Address Modal -->
<div v-if="showAddAddressModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
  <div class="bg-white p-6 rounded-lg shadow-md w-full max-w-md">
    <h3 class="text-xl font-semibold mb-4">Add Billing Address</h3>

    <!-- Name Field -->
    <div class="mb-4">
      <label class="block text-sm font-medium mb-1">First Name</label>
      <input type="text" class="border px-3 py-2 rounded w-full" />
    </div>

    <!-- Address Type Radio Buttons -->
    <div class="mb-4">
      <label class="block text-sm font-medium mb-1">Address Type</label>
      <div class="flex items-center">
        <input type="radio" id="home" name="addressType" value="Home" class="mr-2" />
        <label for="home" class="mr-4">Home</label>
        <input type="radio" id="office" name="addressType" value="Office" class="mr-2" />
        <label for="office">Office</label>
      </div>
    </div>

    <!-- Building No Field -->
    <div class="mb-4">
      <label class="block text-sm font-medium mb-1">Building No</label>
      <input type="text" class="border px-3 py-2 rounded w-full" />
    </div>

    <!-- Street Field -->
    <div class="mb-4">
      <label class="block text-sm font-medium mb-1">Street</label>
      <input type="text" class="border px-3 py-2 rounded w-full" />
    </div>

    <!-- City and State Fields (Side-by-Side) -->
    <div class="flex gap-4 mb-4">
      <div class="flex-1">
        <label class="block text-sm font-medium mb-1">City</label>
        <input type="text" class="border px-3 py-2 rounded w-full" />
      </div>
      <div class="flex-1">
        <label class="block text-sm font-medium mb-1">State</label>
        <input type="text" class="border px-3 py-2 rounded w-full" />
      </div>
    </div>

    <!-- Country and Area Code Fields (Side-by-Side) -->
    <div class="flex gap-4 mb-4">
      <div class="flex-1">
        <label class="block text-sm font-medium mb-1">Country</label>
        <input type="text" class="border px-3 py-2 rounded w-full" />
      </div>
      <div class="flex-1">
        <label class="block text-sm font-medium mb-1">Area Code</label>
        <input type="text" class="border px-3 py-2 rounded w-full" />
      </div>
    </div>

    <!-- Contact Field -->
    <div class="mb-4">
      <label class="block text-sm font-medium mb-1">Contact</label>
      <input type="text" class="border px-3 py-2 rounded w-full" />
    </div>

    <!-- Default Toggle -->
    <div class="mb-6 flex items-center">
      <label class="text-sm font-medium mr-3">Default</label>
      <input type="checkbox" class="toggle-checkbox" />
    </div>

    <!-- Action Buttons -->
    <div class="flex justify-end">
      <button @click="closeAddAddressModal" class="text-gray-500 mr-4">Cancel</button>
      <button class="bg-blue-500 text-white px-4 py-2 rounded">Add Address</button>
    </div>
  </div>
</div>

    <!-- END Add Address Modal -->


    <!-- Payments Section -->
<div v-if="activeTab === 'payment'" class="flex space-x-4">
  <!-- Left Side: Delivery and Payment Options -->
  <div class="w-1/2 space-y-6">
    <!-- Delivery Options -->
    <div class="flex justify-between items-center mb-4">
      <h2 class="text-lg font-bold">Delivery Options</h2>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <div class="bg-white p-4 rounded-lg shadow-md">
        <label class="inline-flex items-center">
          <input type="radio" name="deliveryOption" value="standard" class="mr-2" />
          <div>
            <h3 class="font-bold">Standard Delivery</h3>
            <p class="text-gray-500">Delivery in 5-7 days.</p>
          </div>
        </label>
      </div>
      <div class="bg-white p-4 rounded-lg shadow-md">
        <label class="inline-flex items-center">
          <input type="radio" name="deliveryOption" value="express" class="mr-2" />
          <div>
            <h3 class="font-bold">Express Delivery</h3>
            <p class="text-gray-500">Delivery in 2-3 days.</p>
          </div>
        </label>
      </div>
    </div>

    <!-- Payment Options Section -->
    <div class="flex justify-between items-center mb-4 mt-6">
      <h2 class="text-lg font-bold">Payment Options</h2>
      <p class="text-gray-500"> *Select your preferred payment method to finalize your order.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <div class="bg-white p-4 rounded-lg shadow-md">
        <label class="inline-flex items-center">
          <input type="radio" name="paymentOption" value="creditCard" class="mr-2" />
          <div>
            <h3 class="font-bold">Credit Card</h3>
            <p class="text-gray-500">Pay securely with your credit card.</p>
          </div>
        </label>
      </div>
      <div class="bg-white p-4 rounded-lg shadow-md">
        <label class="inline-flex items-center">
          <input type="radio" name="paymentOption" value="paypal" class="mr-2" />
          <div>
            <h3 class="font-bold">PayPal</h3>
            <p class="text-gray-500">Pay easily through your PayPal account.</p>
          </div>
        </label>
      </div>
      <div class="bg-white p-4 rounded-lg shadow-md">
        <label class="inline-flex items-center">
          <input type="radio" name="paymentOption" value="bankTransfer" class="mr-2" />
          <div>
            <h3 class="font-bold">Bank Transfer</h3>
            <p class="text-gray-500">Transfer directly from your bank account.</p>
          </div>
        </label>
      </div>
    </div>
  </div>

  <!-- Right Side: Cart Items and Order Summary -->
  <div class="w-1/2 space-y-6">
    <!-- Cart Item -->
    <div class="bg-white p-4 rounded-lg shadow-md mt-6">
      <h3 class="font-bold">Cart Item</h3>
      <div class="space-y-2 mt-4">
        <div class="flex justify-between text-gray-600">
          <span></span> <!-- Empty span for subtotal label -->
          <span></span> <!-- Empty span for subtotal value -->
        </div>
        <div class="flex justify-between text-gray-600">
          <span></span> <!-- Empty span for discount label -->
          <span></span> <!-- Empty span for discount value -->
        </div>
        <div class="flex justify-between text-gray-600">
          <span></span> <!-- Empty span for shipping charges label -->
          <span></span> <!-- Empty span for shipping charges value -->
        </div>
        <div class="flex justify-between text-gray-800 font-bold mt-4">
          <span></span> <!-- Empty span for total label -->
          <span></span> <!-- Empty span for total value -->
        </div>
      </div>
    </div>

    <!-- Order Summary -->
    <div class="bg-white p-4 rounded-lg shadow-md mt-6">
      <h3 class="font-bold">Order Summary</h3>
      <div class="space-y-2 mt-4">
        <div class="flex justify-between text-gray-600">
          <span>Subtotal</span>
          <span>$30</span>
        </div>
        <div class="flex justify-between text-gray-600">
          <span>Discount 5%</span>
          <span>-$2</span>
        </div>
        <div class="flex justify-between text-gray-600">
          <span>Shipping Charges</span>
          <span>$0</span>
        </div>
        <div class="flex justify-between text-gray-800 font-bold mt-4">
          <span>Total</span>
          <span>$28</span>
        </div>
      </div>
    </div>
    
    <!-- Shipping Address -->
    <div class="bg-white p-4 rounded-lg shadow-md mt-6">
      <h3 class="font-bold">Shipping Address</h3>
      <p class="text-gray-600">John Doe</p>
      <p class="text-gray-600">1234 Elm Street</p>
      <p class="text-gray-600">City, State, Zip</p>
    </div>

    <div class="flex justify-between mt-6">
  <!-- Back Button (aligned below Delivery and Payment Options) -->
  <button class="bg-gray-500 text-white py-2 px-4 rounded-lg hover:bg-gray-600">
    Back
  </button>

  <!-- Complete an Order Button -->
  <button class="bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600">
    Complete an Order
  </button>
</div>
</div>
</div>
</div>
</template>


<script setup>
import { ref, computed, onMounted } from 'vue';
import { apiService } from '~/api/apiService';

const activeTab = ref('itemcart');
const showAddAddressModal = ref(false);
const products = ref([]);
const categories = ref([]);
const selectedCategory = ref('');
const searchTerm = ref('');
const billingAddresses = ref([
  { id: 1, name: 'John Doe', buildingNo: '123', street: 'Main St', state: 'NY', contact: '123-456-7890', default: true },
  { id: 2, name: 'Jane Smith', buildingNo: '456', street: 'Second St', state: 'NY', contact: '987-654-3210', default: false },
  { id: 3, name: 'Alice Johnson', buildingNo: '789', street: 'Third St', state: 'NY', contact: '555-555-5555', default: false },
]);

// Functions to handle modal visibility
const openAddAddressModal = () => { showAddAddressModal.value = true; };
const closeAddAddressModal = () => { showAddAddressModal.value = false; };

// Fetch data for products and categories
const fetchProductsData = async () => {
  try {
    const { data } = await apiService.get("/api/products");
    products.value = data;
  } catch (error) {
    console.error("Error fetching data:", error);
  }
};
const fetchCategoriesData = async () => {
  try {
    const { data } = await apiService.get("/api/productCategories");
    categories.value = data;
  } catch (error) {
    console.error("Error fetching data:", error);
  }
};

// Filtered products based on search and selected category
const filteredProducts = computed(() => {
  return products.value.filter(product => {
    const matchesCategory = !selectedCategory.value || product.prodCatID === selectedCategory.value;
    const matchesSearch = product.productName.toLowerCase().includes(searchTerm.value.toLowerCase());
    return matchesCategory && matchesSearch;
  });
});

// Remove product function
const removeProduct = (productID) => {
  products.value = products.value.filter(product => product.productID !== productID);
};

onMounted(() => {
  fetchProductsData();
  fetchCategoriesData();
});
</script>

<style>
.tab {
  transition: color 0.2s ease;
}
.tab:hover {
  color: #3b82f6;
}
</style>
