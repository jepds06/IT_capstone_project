<template>
  <div class="bg-white mt-10 text-black p-4 rounded shadow">
    <h2 class="text-lg font-semibold">
      Product Stock Details
    </h2>
    <table class="mt-5 text-center w-full text-sm">
      <thead>
        <tr>
          <th class="border-b border-black pb-2">
            Product Name
          </th>
          <th class="border-b border-black pb-2">
            Units Available
          </th>
          <th class="border-b border-black pb-2">
            Units On Order
          </th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="product in products" :key="product.productID" >
          <td class="border-b border-black py-1">
            {{product.productName }}
          </td>
          <td class="border-b border-black py-1">
            {{product.stock}}
          </td>
          <td class="border-b border-black py-1">
            {{product.qtyOrdered}}
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { apiService } from '~/api/apiService';
const products = ref([]);
const categories = ref([]);

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
    }
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

const fetchFinishProductsData = async() => {
  const result = await apiService.get("/api/finishedProducts");
  // const productIDs = result.data?.map((val) => val.production_detail.product.productID);

  const data = products.value?.map((value) => {
    const stockProducts = result.data?.filter((val) => val.production_detail.product.productID === value.productID);
    const quantity = stockProducts?.reduce((total, detail) => {
    return total + parseInt(detail.quantity);
  }, 0);
    return {
      ...value,
      stock: quantity - value.qtyOrdered
    }
  });
  products.value = data

}

onMounted(async () => { 
  await fetchProductsData();
  await fetchFinishProductsData();
  await fetchCategoriesData();
});

</script>