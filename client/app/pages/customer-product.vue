<template>

  
  <div class="m-8 ">
    
    <!-- Search Input -->
    <div class="mb-4 flex justify-end">
      <input 
        v-model="searchTerm" 
        @input="filterProducts" 
        type="text" 
        placeholder="What are you looking for?" 
        class="p-2 rounded w-full max-w-md"
      />
    </div>
    <!-- Category Filter -->
   <div class="mb-4 flex justify-end">
      <select v-model="selectedCategory" @change="filterProducts" class="p-2 text-center rounded">
        <option value="">All Categories</option>
        <option v-for="category in categories" :key="category.prodCatID" :value="category.prodCatID">
          {{ category.description }}
        </option>
      </select>
    </div>

    <!-- Product Cards -->
    <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
      <UCard v-for="product in filteredProducts" :key="product.productID" class="flex flex-col h-full">
        
        <!-- Image Section -->
        <div class="flex justify-center w-full">
          <img :src="default" alt="Sample Image" class="object-contain h-48 w-50" />
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
        </div>

        <!-- Price and Add to Cart Section -->
        <div class="pt-4 flex justify-between items-center">
          <span class="font-bold text-lg text-green-600">₱{{ product.unitPrice }}</span>
          <button class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            Add to Cart
          </button>
        </div>
      </UCard>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';
import { apiService } from "~/api/apiService";

const products = ref([]);
const categories = ref([]);
const selectedCategory = ref('');
const searchTerm = ref('');

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

const getCategoryDescription = (categoryId) => {
  const category = categories.value.find(cat => cat.prodCatID === categoryId);
  return category ? category.description : 'Unknown';
};

// Filter products based on category and search term
const filteredProducts = computed(() => {
  return products.value
    .filter(product => {
      const matchesCategory = !selectedCategory.value || product.prodCatID === selectedCategory.value;
      const matchesSearch = product.productName.toLowerCase().includes(searchTerm.value.toLowerCase());
      return matchesCategory && matchesSearch;
    });
});

const filterProducts = () => {
  // Triggered automatically by v-model change
};

onMounted(() => {
  fetchProductsData();
  fetchCategoriesData();
});
</script>
