<template>
  <div class="m-8">
    <div class="flex justify-between mb-4">
      <div class="w-2/5">
        <label class="block font-extrabold text-2xl mb-2">Customer</label>
        <USelectMenu
          v-model="store.selectedCustomer"
          :options="customer"
          searchable
          searchable-placeholder="Search a customer..."
        />
      </div>
      <div>
        <UButton
          @click="store.isOpenCart = true"
          color="white"
          class="mr-2"
          icon="solar:cart-4-linear"
          size="md"
          :label="`Cart(${store.addedToCart.length})`"
          :disabled="!store.selectedCustomer"
        />
        <UButton
          @click="store.isOpenOrderStatus = true"
          color="white"
          class="mr-2"
          icon="material-symbols-light:order-approve-outline-sharp"
          size="md"
          title="Order Status"
          :disabled="!store.selectedCustomer"
        />
      </div>
    </div>
    <!-- Search Input -->
    <div class="mb-4 flex justify-end">
      <input
        v-model="searchTerm"
        @input="filterProducts"
        type="text"
        placeholder="What are you looking for?"
        class="p-2 rounded w-full max-w-md bg-gray-100"
      />
    </div>
    <!-- Category Filter -->
    <div class="mb-4 flex justify-end">
      <select
        v-model="selectedCategory"
        @change="filterProducts"
        class="p-2 text-center rounded"
      >
        <option value="">All Categories</option>
        <option
          v-for="category in categories"
          :key="category.prodCatID"
          :value="category.prodCatID"
        >
          {{ category.description }}
        </option>
      </select>
    </div>

    <!-- <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
      <div class="col-span-1">
        <label class="block font-semibold text-lg mb-2">Customer</label>
        <USelectMenu
          v-model="store.selectedCustomer"
          :options="customer"
          searchable
          searchable-placeholder="Search a customer..."
        />
      </div>
    </div> -->

    <!-- Product Cards -->
    <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
      <UCard
        v-for="product in filteredProducts"
        :key="product.productID"
        class="flex flex-col h-full"
      >
        <!-- Image Section -->
        <div class="flex justify-center w-full">
          <img
            :src="product?.image_url"
            :alt="product.productName"
            class="object-contain h-48 w-50"
          />
        </div>

        <!-- Product Details Section -->
        <div class="mt-4 flex flex-col flex-grow">
          <!-- Product Name and Category -->
          <div class="flex items-center">
            <p class="font-bold text-lg">{{ product.productName }}</p>
            <UBadge variant="subtle" size="md" class="font-semibold ml-2">
              {{ getCategoryDescription(product.prodCatID) }}
            </UBadge>
          </div>

          <!-- Specifications -->
          <div class="mt-2 flex-grow mb-4">
            <p class="text-gray-700">{{ product.specifications }}</p>
          </div>

          <!-- Stocks -->
          <div class="mt-2 flex-grow mb-4 items-center">
            <div v-if="product.stock == 0">
              <!-- <UIcon name="fluent:box-dismiss-24-regular" class="text-2xl" /> -->
              <span class="text-gray-700">Out of stock</span>
            </div>
            <div v-else>
              <p class="text-gray-700">Stock: {{ product.stock }}</p>
            </div>
          </div>
        </div>

        <!-- Price and Add to Cart Section -->
        <div class="pt-4 flex justify-between items-center">
          <span class="font-bold text-lg text-green-600"
            >₱{{ product.unitPrice }}</span
          >
          <UButton
            icon="solar:cart-4-linear"
            @click="addToCart(product)"
            label="Add to Cart"
            :disabled="product.stock == 0"
          />
        </div>
      </UCard>

            <!-- Success/Error Message for  AddtoCart -->
            <div
            v-if="isCartMessageVisible"
            class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
            >
          <div class="bg-white p-6 rounded-md w-1/3 shadow-lg">
          <h3 class="text-xl font-bold mb-4" :class="cartMessageType === 'success' ? 'text-green-600' : 'text-red-600'">
            {{ cartMessageType === 'success' ? 'Success!' : 'Error!' }}
          </h3>
          <p class="text-black">{{ cartMessage }}</p>
          <div class="flex justify-end mt-4">
            <button
              class="bg-blue-500 text-white py-1 px-3 rounded-md"
              @click="closeCartMessage"
            >
              OK
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <UModal v-model="store.isOpenCart" fullscreen>
    <CustomerDashboard />
  </UModal>

  <UModal v-model="store.isOpenOrderStatus">
    <CustOrderStatus />
  </UModal>
</template>

<script setup>
import { ref, onMounted, computed, watchEffect } from "vue";
import { apiService } from "~/api/apiService";
import { store } from "~/composables/store";

useSeoMeta({
  title: "Customers",
  description: "Customer Dashboard",
});

const products = ref([]);
const categories = ref([]);
const selectedCategory = ref("");
const searchTerm = ref("");
const customer = ref([]);

const isCartMessageVisible = ref(false);
const cartMessage = ref("");
const cartMessageType = ref("success");
const showCartMessage = (message, type = "success") => {
  cartMessage.value = message;
  cartMessageType.value = type;
  isCartMessageVisible.value = true;
};
const closeCartMessage = () => {
  isCartMessageVisible.value = false;
};

const addToCart = (product) => {
  const alreadyAddedProduct = store.addedToCart?.find(
    (value) => value.productID === product.productID
  );
  if (alreadyAddedProduct) {
    //alert("Already added on the cart!");
    showCartMessage("Already added on the cart!");
  } else {
    store.addedToCart.push({ ...product, quantity: 1 });
  }
};
const fetchProductsData = async () => {
  try {
    const { data } = await apiService.get("/api/products");
    products.value = data?.map((value) => {
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
};

const fetchCategoriesData = async () => {
  try {
    const { data } = await apiService.get("/api/productCategories");
    categories.value = data;
  } catch (error) {
    console.error("Error fetching data:", error);
  }
};

const getCategoryDescription = (categoryId) => {
  const category = categories.value.find((cat) => cat.prodCatID === categoryId);
  return category ? category.description : "Unknown";
};

// Filter products based on category and search term
const filteredProducts = computed(() => {
  return products.value.filter((product) => {
    const matchesCategory =
      !selectedCategory.value || product.prodCatID === selectedCategory.value;
    const matchesSearch = product.productName
      .toLowerCase()
      .includes(searchTerm.value.toLowerCase());
    return matchesCategory && matchesSearch;
  });
});

const filterProducts = () => {
  // Triggered automatically by v-model change
};

const fetchFinishProductsData = async () => {
  const result = await apiService.get("/api/finishedProducts");
  // const productIDs = result.data?.map((val) => val.production_detail.product.productID);

  const data = products.value?.map((value) => {
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
  products.value = data;
};

const fetchUserData = async () => {
  const result = await apiService.get("/api/users");
  customer.value = result.data
    ?.filter((user) => user.userTypeID === 2)
    ?.map((user) => {
      return {
        id: user.userID,
        label: `${user.lastName} ${user.firstName}`,
      };
    });
};

onUnmounted (() => {
  store.selectedCustomer = null
  store.addedToCart = [];
})

onMounted(async () => {
  await fetchProductsData();
  await fetchFinishProductsData();
  await fetchCategoriesData();
  await fetchUserData();
});

watchEffect(async () => {
  // Automatically tracks `count` and recalculates `doubled` when `count` changes
  if (store.isOpenCart === false) {
    // Perform an API call or filter logic
    await fetchProductsData();
    await fetchFinishProductsData();
    await fetchCategoriesData();
  }
});
</script>
