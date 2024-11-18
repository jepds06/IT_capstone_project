<template>
  <div class="p-6">
    <!-- Title and Add Button -->
    <div class="flex justify-between items-center mb-4">
      <h1 class="text-xl font-bold">Products</h1>
      <UButton
        icon="material-symbols:add-2-rounded"
        size="sm"
        color="primary"
        variant="solid"
        label="Product"
        title="Add Product"
        @click="openModal('add')"
        :trailing="false"
      />
    </div>

    <!-- Add/Edit Product Modal -->
    <div
      v-if="isModalVisible"
      class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50"
    >
      <div class="bg-white p-6 rounded-lg shadow-lg w-1/3 relative">
        <!-- Close Button -->
        <button
          class="absolute top-2 right-2 text-gray-500 hover:text-gray-800"
          @click="closeModal"
        >
          <i class="fas fa-times" />
        </button>
        <h2 class="text-lg text-black font-semibold mb-4">
          {{ formMode === "add" ? "Add Product" : "Edit Product" }}
        </h2>
        <form @submit.prevent="confirmProductSave">
          <div v-if="formMode === 'edit'" class="mb-4">
            <label for="id" class="block text-sm font-medium text-gray-700"
              >Id</label
            >
            <input
              id="id"
              v-model="form.productID"
              type="text"
              class="mt-1 block w-full border border-gray-300 rounded-lg p-2"
              :readonly="formMode === 'edit'"
            />
          </div>
          <div class="mb-4">
            <label for="prodCat" class="block text-sm font-medium text-gray-700"
              >Product Category</label
            >
            <select
              id="prodCat"
              v-model="form.prodCatID"
              class="mt-1 block w-full border border-gray-300 rounded-lg p-2"
            >
              <option
                v-for="category in categories"
                :key="category.prodCatID"
                :value="category.prodCatID"
              >
                {{ category.description }}
              </option>
            </select>
          </div>
          <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700"
              >Name</label
            >
            <input
              id="name"
              v-model="form.productName"
              type="text"
              class="mt-1 block w-full border border-gray-300 rounded-lg p-2"
            />
          </div>
          <div class="mb-4">
            <label for="image" class="block text-sm font-medium text-gray-700"
              >Image</label
            >
            <input
              type="file"
              @change="onFileChange"
              ref="imageInput"
              accept="image/*"
            />
            <div class="flex justify-center w-full">
              <div v-if="imagePreview">
                <img
                  :src="imagePreview"
                  alt="Image Preview"
                  class="object-contain h-48 w-50"
                />
              </div>
              <div v-else>
                <img
                  v-if="form?.image_url"
                  :src="form?.image_url"
                  alt="Sample Image"
                  class="object-contain h-48 w-50"
                />
              </div>
            </div>
          </div>
          <div class="mb-4">
            <label for="specs" class="block text-sm font-medium text-gray-700"
              >Specifications</label
            >
            <textarea
              id="specs"
              v-model="form.specifications"
              rows="3"
              class="mt-1 block w-full border border-gray-300 rounded-lg p-2"
            />
          </div>
          <div class="mb-4">
            <label
              for="unitPrice"
              class="block text-sm font-medium text-gray-700"
              >Unit Price</label
            >
            <input
              id="unitPrice"
              v-model="form.unitPrice"
              class="mt-1 block w-full border border-gray-300 rounded-lg p-2"
              @change="
                (e) => (e.target.value ? parseFloat(e.target.value) : null)
              "
            />
          </div>
          <div class="flex justify-end">
            <button
              type="submit"
              class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600"
            >
              Save
            </button>
            <button
              class="ml-2 bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600"
              @click="closeModal"
            >
              Cancel
            </button>
          </div>
        </form>
      </div>
    </div>

    <!-- Confirmation Modal Product-->
    <div
      v-if="isProductConfirmationVisible"
      class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
    >
      <div class="bg-white p-6 rounded-md w-1/3 shadow-lg">
        <h3 class="text-xl font-bold mb-4 text-black">
          Are you sure you want to proceed?
        </h3>
        <div class="flex justify-end mt-4">
          <button
            class="bg-blue-500 text-white py-1 px-3 rounded-md mr-2"
            @click="saveProduct"
          >
            Yes
          </button>
          <button
            class="text-red-600 py-1 px-3 rounded-md"
            @click="closeProductConfirmation"
          >
            No
          </button>
        </div>
      </div>
    </div>

    <!-- Confirmation Modal Material-->
    <div
      v-if="isMaterialConfirmationVisible"
      class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
    >
      <div class="bg-white p-6 rounded-md w-1/3 shadow-lg">
        <h3 class="text-xl font-bold mb-4 text-black">
          Are you sure you want to proceed?
        </h3>
        <div class="flex justify-end mt-4">
          <button
            class="bg-blue-500 text-white py-1 px-3 rounded-md mr-2"
            @click="saveMaterial"
          >
            Yes
          </button>
          <button
            class="text-red-600 py-1 px-3 rounded-md"
            @click="closeMaterialConfirmation"
          >
            No
          </button>
        </div>
      </div>
    </div>

    <!-- Success Message for Product Modal -->
    <div
      v-if="isSuccessProductVisible"
      class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
    >
      <div class="bg-white p-6 rounded-md w-1/3 shadow-lg">
        <h3 class="text-xl font-bold mb-4 text-green-600">Success!</h3>
        <p class="text-black">
          Product has been
          {{ formMode === "add" ? "created" : "updated" }} successfully!
        </p>
        <div class="flex justify-end mt-4">
          <button
            class="bg-blue-500 text-white py-1 px-3 rounded-md"
            @click="closeProductConfirmation"
          >
            OK
          </button>
        </div>
      </div>
    </div>

    <!-- Success Message for Material Modal -->
    <div
      v-if="isSuccessMaterialVisible"
      class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
    >
      <div class="bg-white p-6 rounded-md w-1/3 shadow-lg">
        <h3 class="text-xl font-bold mb-4 text-green-600">Success!</h3>
        <p class="text-black">
          Product Material has been
          {{ materialMode === "add" ? "created" : "updated" }} successfully!
        </p>
        <div class="flex justify-end mt-4">
          <button
            class="bg-blue-500 text-white py-1 px-3 rounded-md"
            @click="closeMaterialConfirmation"
          >
            OK
          </button>
        </div>
      </div>
    </div>

    <!-- Product Info Modal -->
    <div
      v-if="isProductInfoVisible"
      class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50"
    >
      <div class="bg-white p-6 rounded-lg shadow-lg w-1/2 relative">
        <!-- Close Button -->
        <button
          class="absolute top-2 right-2 text-gray-500 hover:text-gray-800"
          @click="closeProductInfo"
        >
          <i class="fas fa-times" />
        </button>

        <div class="flex justify-between items-center mb-4">
          <h2 class="text-lg text-black font-semibold">Product Materials</h2>

          <UButton
            icon="material-symbols:add-notes-outline-sharp"
            size="sm"
            color="primary"
            variant="solid"
            label="Add Material"
            :trailing="false"
            @click="openMaterialModal"
          />
        </div>
        <!-- Product Info View Table (Read-Only) -->
        <table class="min-w-full border border-gray-300 rounded-lg mb-4">
          <thead class="bg-gray-200">
            <tr class="p-2 border-b text-black text-center">
              <th>Name</th>
              <th>Specification</th>
              <th>Unit Price</th>
              <th>Category</th>
            </tr>
          </thead>
          <tbody>
            <tr class="p-2 border-b text-black text-center">
              <td>{{ selectedProduct?.productName }}</td>
              <td>{{ selectedProduct?.specifications }}</td>
              <td>
                {{
                  new Intl.NumberFormat("en-PH", {
                    style: "currency",
                    currency: "PHP",
                  }).format(parseFloat(selectedProduct?.unitPrice))
                }}
              </td>
              <td>{{ getCategoryDescription(selectedProduct?.prodCatID) }}</td>
            </tr>
          </tbody>
        </table>
        <div class="mb-4">
          <table class="min-w-full border border-gray-300 rounded-lg">
            <thead class="bg-gray-100">
              <tr class="p-2 border-b text-black text-center">
                <th>Material Id</th>
                <th>Name</th>
                <th>Specs</th>
                <th>Qty.</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody v-if="selectedProductMaterials.length > 0">
              <tr
                v-for="material in selectedProductMaterials"
                :key="material.materialID"
                class="p-2 border-b text-black text-center"
              >
                <td>{{ material.id }}</td>
                <td>{{ material.description }}</td>
                <td>{{ material.specification }}</td>
                <td>{{ material.quantity }}</td>
                <td
                  class="p-2 border-b text-center flex justify-center space-x-2"
                >
                  <!-- Placeholder for actions, e.g., edit or delete material -->
                  <button
                    class="text-yellow-500 hover:underline"
                    @click="editMaterial(material)"
                  >
                    <i class="fas fa-edit" />
                  </button>
                  <button
                    class="text-red-500 hover:underline"
                    @click="removeMaterial(material)"
                  >
                    <i class="fas fa-trash" />
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Add/Edit Material Modal -->
    <div
      v-if="isMaterialModalVisible"
      class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50"
    >
      <div class="bg-white p-6 rounded-lg shadow-lg w-1/3 relative">
        <!-- Close Button -->
        <button
          class="absolute top-2 right-2 text-gray-500 hover:text-gray-800"
          @click="closeMaterialModal"
        >
          <i class="fas fa-times" />
        </button>
        <h2 class="text-lg font-semibold mb-4">
          {{ materialMode === "add" ? "Add Material" : "Edit Material" }}
        </h2>
        <form @submit.prevent="confirmMaterialtSave">
          <div v-if="materialMode === 'edit'" class="mb-4">
            <label
              for="materialId"
              class="block text-sm font-medium text-gray-700"
              >Product Material Id</label
            >
            <input
              id="productMatsID"
              v-model="materialForm.productMatsID"
              type="text"
              class="mt-1 block w-full border border-gray-300 rounded-lg p-2"
              :readonly="materialMode === 'edit'"
            />
          </div>
          <div class="mb-4">
            <label for="prodCat" class="block text-sm font-medium text-gray-700"
              >Material</label
            >
            <select
              id="prodCat"
              v-model="materialForm.materialID"
              class="mt-1 block w-full border border-gray-300 rounded-lg p-2"
              :disabled="materialMode === 'edit'"
            >
              <option
                v-for="material in notAddedMaterials"
                :key="material.materialID"
                :value="material.materialID"
              >
                {{ material.description }}
              </option>
            </select>
          </div>
          <div class="mb-4">
            <label for="specs" class="block text-sm font-medium text-gray-700"
              >Specs</label
            >
            <textarea
              id="specs"
              rows="3"
              class="mt-1 block w-full border border-gray-300 rounded-lg p-2"
              readonly
              >{{ getSpecsMaterial(materialForm.materialID) }}</textarea
            >
          </div>
          <div class="mb-4">
            <label for="qty" class="block text-sm font-medium text-gray-700"
              >Quantity</label
            >
            <input
              id="qty"
              v-model="materialForm.quantity"
              type="number"
              class="mt-1 block w-full border border-gray-300 rounded-lg p-2"
            />
          </div>
          <div class="flex justify-end">
            <button
              type="submit"
              class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600"
            >
              Save
            </button>
            <button
              class="ml-2 bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600"
              @click="closeMaterialModal"
            >
              Cancel
            </button>
          </div>
        </form>
      </div>
    </div>

    <!-- Products Table -->
    <table class="min-w-full border border-gray-300 rounded-lg">
      <thead class="bg-gray-100">
        <tr>
          <th class="p-2 border-b text-black text-center">Id</th>
          <th class="p-2 border-b text-black text-center">Name</th>
          <th class="p-2 border-b text-black text-center">Specifications</th>
          <th class="p-2 border-b text-black text-center">Unit Price</th>
          <th class="p-2 border-b text-black text-center">Category</th>
          <th class="p-2 border-b text-black text-center">Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="product in products" :key="product.productID">
          <td class="p-2 border-b text-center">
            {{ product.productID }}
          </td>
          <td class="p-2 border-b text-center">
            {{ product.productName }}
          </td>
          <td class="p-2 border-b text-center">
            {{ product.specifications }}
          </td>
          <td class="p-2 border-b text-center">
            {{
              new Intl.NumberFormat("en-PH", {
                style: "currency",
                currency: "PHP",
              }).format(product.unitPrice)
            }}
          </td>
          <td class="p-2 border-b text-center">
            {{ getCategoryDescription(product.prodCatID) }}
          </td>
          <td class="p-2 border-b text-center flex justify-center space-x-2">
            <button
              class="text-blue-500 hover:underline"
              @click="viewProduct(product)"
            >
              <i class="fas fa-eye" />
            </button>
            <button
              class="text-yellow-500 hover:underline"
              @click="openModal('edit', product)"
            >
              <i class="fas fa-edit" />
            </button>
            <button
              class="text-green-500 hover:underline"
              @click="showMaterials(product)"
            >
              <i class="fas fa-cogs" />
            </button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup>
import { ref } from "vue";
import auth from "../../../../middleware/auth";

import { apiService } from "~/api/apiService";
// This page requires authentication
definePageMeta({
  middleware: [auth],
});

const isSuccessProductVisible = ref(false);
const isSuccessMaterialVisible = ref(false);
const showConfirmationModal = ref(false);
const isProductConfirmationVisible = ref(false);
const isMaterialConfirmationVisible = ref(false);

const products = ref([]);
const categories = ref([]);
const materials = ref([]);

const imageInput = ref(null);
const imagePreview = ref(null);

const isModalVisible = ref(false);
const formMode = ref("add"); // 'add' or 'edit'
const form = ref({
  productID: "",
  prodCatID: "",
  productName: "",
  specifications: "",
  unitPrice: "",
  image: null,
});

const isProductInfoVisible = ref(false);
const selectedProductMaterials = ref([]);
const selectedProduct = ref(null);
const notAddedMaterials = ref(null);

const isMaterialModalVisible = ref(false);
const materialMode = ref("add"); // 'add' or 'edit'
const materialForm = ref({
  materialID: "",
  productID: "",
  quantity: "",
  productMatsID: "",
});

function onFileChange(event) {
  form.value.image = event.target.files[0];
  previewImage();
}

function previewImage() {
  const file = imageInput.value.files[0]; // Get the selected file

  if (file) {
    const reader = new FileReader();
    reader.onloadend = () => {
      imagePreview.value = reader.result; // Set the preview image to the file content
    };

    reader.readAsDataURL(file); // Read the file as a data URL (Base64 string)
  } else {
    imagePreview.value = null; // Reset if no file is selected
  }
}

async function openModal(mode = "add", product = null) {
  setTimeout(async() => {
    imagePreview.value = null;
  await fetchCategoriesData();
  formMode.value = mode;
  if (mode === "edit" && product) {
    form.value = { ...product };
  } else {
    form.value = {
      id: "",
      prodCat: "",
      name: "",
      specs: "",
      unitPrice: "",
      image: null,
    };
  }
  isModalVisible.value = true;
  }, 2000);
}

function closeModal() {
  isModalVisible.value = false;
}

const showSuccessProductMessage = (message) => {
  isSuccessProductVisible.value = true;
  setTimeout(() => {}, 3000); // Automatically close after 3 seconds
};
const showSuccessMaterialMessage = (message) => {
  isSuccessMaterialVisible.value = true;
  setTimeout(() => {}, 3000); // Automatically close after 3 seconds
};
const confirmProductSave = () => {
  isProductConfirmationVisible.value = true;
};
const confirmMaterialtSave = () => {
  isMaterialConfirmationVisible.value = true;
};
const closeProductConfirmation = () => {
  isProductConfirmationVisible.value = false;
  isSuccessProductVisible.value = false;
};
const closeMaterialConfirmation = () => {
  isMaterialConfirmationVisible.value = false;
  isSuccessMaterialVisible.value = false;
};

async function saveProduct() {
  const formData = new FormData();
    Object.keys(form.value)?.forEach((property) => {
      formData.append(property, form.value[property]);
    });
  if (formMode.value === "add") {
    const { data } = await apiService.post("/api/products", formData);
    products.value.push(data);
    showSuccessProductMessage("Product created successfully!");
  } else if (formMode.value === "edit") {
    const index = products.value.findIndex(
      (prod) => prod.productID === form.value.productID
    );
    if (index !== -1) {
      const { data } = await apiService.post(
        `/api/products/${form.value.productID}`,
         formData
      );
      products.value[index] = data;
      showSuccessProductMessage("Product edited successfully!");
    }
  }
  imagePreview.value = null;
  closeModal();
}

function viewProduct(product) {
  alert(`Viewing product: ${product.productName}`);
}

async function showMaterials(product) {
  selectedProduct.value = product;
  // Simulating fetching materials for the selected product
  await fetchMaterialsData();
  await fetchProductMaterialsData();
  isProductInfoVisible.value = true;
}

function closeProductInfo() {
  isProductInfoVisible.value = false;
}

async function openMaterialModal() {
  const selectedMaterialID = selectedProductMaterials.value?.map(
    (val) => val.materialID
  );
  notAddedMaterials.value = materials.value?.filter(
    (val) => !selectedMaterialID?.includes(val.materialID)
  );
  materialMode.value = "add";
  materialForm.value = {
    materialID: "",
    productID: "",
    quantity: "",
    productMatsID: "",
  };
  isMaterialModalVisible.value = true;
}

function closeMaterialModal() {
  isMaterialModalVisible.value = false;
}

async function saveMaterial() {
  if (materialMode.value === "add") {
    const { data } = await apiService.post("/api/productMaterials", {
      ...materialForm.value,
      productID: selectedProduct.value.productID,
    });
    materials.value.push(data);
    showSuccessMaterialMessage("Product Material added successfully!");
    selectedProductMaterials.value.push({ ...materialForm.value });
  } else if (materialMode.value === "edit") {
    const index = selectedProductMaterials.value.findIndex(
      (mat) => mat.id === materialForm.value.id
    );
    if (index !== -1) {
      await apiService.put(
        `/api/productMaterials/${materialForm.value.productMatsID}`,
        { ...materialForm.value, productID: selectedProduct.value.productID }
      );
      selectedProductMaterials.value[index] = {
        ...materialForm.value,
        productID: selectedProduct.value.productID,
      };
      showSuccessMaterialMessage("Product Material edited successfully!");
    }
  }
  await fetchProductMaterialsData();
  closeMaterialModal();
}

function editMaterial(material) {
  notAddedMaterials.value = materials.value;
  materialMode.value = "edit";
  materialForm.value = { ...material };
  isMaterialModalVisible.value = true;
}

function removeMaterial(material) {
  selectedProductMaterials.value = selectedProductMaterials.value.filter(
    (mat) => mat.id !== material.id
  );
}

function getCategoryDescription(categoryId) {
  const category = categories.value.find((cat) => cat.prodCatID === categoryId);
  return category ? category.description : "Unknown";
}

function getSpecsMaterial(materialId) {
  const material = materials.value.find(
    (prod) => prod.materialID === materialId
  );
  return material ? material.specification : "Unknown";
}

// Define an async function to fetch categories data
const fetchCategoriesData = async () => {
  try {
    // Call the get method from ApiService
    const { data } = await apiService.get("/api/productCategories"); // Replace '/endpoint' with your actual API endpoint
    categories.value = data;
  } catch (error) {
    console.error("Error fetching data:", error);
  }
};

const fetchProductsData = async () => {
  try {
    // Call the get method from ApiService
    const { data } = await apiService.get("/api/products"); // Replace '/endpoint' with your actual API endpoint
    products.value = data?.map((value, index) => {
      return {
        ...value,
        id: index + 1,
      };
    });
  } catch (error) {
    console.error("Error fetching data:", error);
  }
};

const fetchMaterialsData = async () => {
  try {
    // Call the get method from ApiService
    const { data } = await apiService.get("/api/materials"); // Replace '/endpoint' with your actual API endpoint
    materials.value = data;
  } catch (error) {
    console.error("Error fetching data:", error);
  }
};

const fetchProductMaterialsData = async () => {
  try {
    const data = await apiService.get(
      `/api/productMaterials/materials/${selectedProduct.value.productID}`
    ); // Replace '/endpoint' with your actual API endpoint
    const transFormData = data["product_materials"]?.map((value, index) => {
      return {
        id: index + 1,
        materialID: value.materialID,
        description: value.material.description,
        specification: value.material.specification,
        quantity: value.quantity,
        productMatsID: value.productMatsID,
      };
    });
    selectedProductMaterials.value = transFormData;
  } catch (error) {
    console.error("Error fetching data:", error);
  }
};

onMounted(() => {
  fetchCategoriesData();
  fetchProductsData();
});
</script>

<style scoped>
/* Add any additional styling here */
</style>
