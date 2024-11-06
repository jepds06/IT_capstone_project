<template>
    <div class="m-8">
      <!-- Product Details Section (only visible when a product is selected) -->
      <div v-if="selectedProduct" class="flex gap-8 bg-white shadow-lg rounded-lg p-6">
        <!-- Product Image Section -->
        <div class="flex justify-center w-1/3">
          <img :src="selectedProduct.image" alt="Product Image" class="h-80 w-80 object-cover rounded-lg shadow-md transition-transform duration-300 hover:scale-105" />
        </div>
  
        <!-- Product Details Section -->
        <div class="flex flex-col gap-4 w-2/3">
          <!-- Product Name -->
          <h1 class="text-3xl font-bold">{{ selectedProduct.productName }}</h1>
  
          <!-- Star Rating Section -->
          <div class="flex items-center gap-1 text-yellow-400">
            <span v-for="n in 5" :key="n" :class="n <= selectedProduct.averageRating ? 'text-yellow-400' : 'text-gray-300'">
              ★
            </span>
          </div>
          <p class="text-gray-500">{{ selectedProduct.reviews.length }} Reviews</p>
  
          <!-- Price -->
          <p class="text-2xl font-semibold text-green-600">₱{{ selectedProduct.unitPrice }}</p>
  
          <!-- Quantity Section (with - / + buttons) -->
          <div class="flex items-center gap-4">
            <p class="text-lg font-semibold">Qty:</p>
            <button @click="decreaseQuantity" class="bg-gray-300 text-lg p-2 rounded-full hover:bg-gray-400">
              -
            </button>
            <span class="text-lg">{{ quantity }}</span>
            <button @click="increaseQuantity" class="bg-gray-300 text-lg p-2 rounded-full hover:bg-gray-400">
              +
            </button>
          </div>
  
          <!-- Action Buttons -->
          <div class="flex gap-4 mt-4">
            <button @click="addToCart" class="bg-blue-500 text-white px-8 py-3 rounded-full hover:bg-blue-600 w-50 transition-transform transform hover:scale-105">
              Add to Cart
            </button>
            <button class="bg-green-500 text-white px-8 py-3 rounded-full hover:bg-green-600 w-36 transition-transform transform hover:scale-105">
              Buy Now
            </button>
          </div>
  
          <!-- Product Description -->
          <div class="mt-4">
            <h2 class="text-xl font-semibold">Description</h2>
            <p class="text-gray-700">{{ selectedProduct.specifications }}</p>
          </div>
  
          <!-- Reviews Section with Scrollbar -->
          <div class="mt-4 overflow-y-auto max-h-[300px]">
            <h2 class="text-xl font-semibold">Reviews</h2>
            <div class="space-y-3">
              <div
                v-for="review in selectedProduct.reviews"
                :key="review.id"
                class="cursor-pointer p-2 bg-gray-100 rounded hover:bg-gray-200"
                @click="toggleReviewVisibility(review.id)"
              >
                <p class="font-semibold">{{ review.title }}</p>
                <p v-if="review.isVisible" class="text-gray-600">{{ review.text }}</p>
              </div>
            </div>
          </div>
        </div>
      </div>
  
      <!-- Notification Toast -->
      <div v-if="showNotification" class="fixed bottom-10 right-10 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg transition-opacity duration-300">
        <p>{{ message }}</p>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref } from 'vue';
  
  const products = ref([
    {
      productID: 1,
      productName: 'Wooden Chair',
      specifications: 'A comfortable wooden chair for home and office use.',
      unitPrice: 2500,
      image: 'https://via.placeholder.com/300',
      reviews: [
        { id: 1, title: 'Comfortable and stylish', text: 'The chair is very comfortable and looks great in my living room.', isVisible: false, rating: 5 },
        { id: 2, title: 'Great value for money', text: 'I bought this chair at a good price, and it’s really sturdy.', isVisible: false, rating: 4 },
      ],
      averageRating: 4.5, // Calculated average rating for display
    },
  ]);
  
  const selectedProduct = ref(products.value[0]); // Initial product selection for demo
  const quantity = ref(1);
  const showNotification = ref(false);
  const message = ref('');
  
  // Show the notification with the product name and quantity added
  const addToCart = () => {
    showNotification.value = true;
    message.value = `${selectedProduct.value.productName} x${quantity.value} added to cart!`;
  
    // Hide the notification after 3 seconds
    setTimeout(() => {
      showNotification.value = false;
    }, 3000);
  };
  
  const increaseQuantity = () => {
    quantity.value++;
  };
  
  const decreaseQuantity = () => {
    if (quantity.value > 1) quantity.value--;
  };
  
  const toggleReviewVisibility = (reviewId) => {
    const review = selectedProduct.value.reviews.find(r => r.id === reviewId);
    if (review) {
      review.isVisible = !review.isVisible;
    }
  };
  </script>
  
  <style scoped>
  .m-8 {
    margin: 2rem;
  }
  .flex {
    display: flex;
  }
  .gap-8 {
    gap: 2rem;
  }
  .object-cover {
    object-fit: cover;
  }
  .rounded-lg {
    border-radius: 0.5rem;
  }
  .shadow-md {
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  }
  .cursor-pointer {
    cursor: pointer;
  }
  .bg-gray-100 {
    background-color: #f7fafc;
  }
  .bg-gray-200 {
    background-color: #edf2f7;
  }
  .p-2 {
    padding: 0.5rem;
  }
  .px-8 {
    padding-left: 2rem;
    padding-right: 2rem;
  }
  .py-3 {
    padding-top: 0.75rem;
    padding-bottom: 0.75rem;
  }
  .w-36 {
    width: 9rem;
  }
  .rounded-full {
    border-radius: 9999px;
  }
  </style>