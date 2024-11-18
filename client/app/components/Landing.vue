<template>
  <div class="scrollable-container">
    <!-- Hero Section with Image -->
    <section
      class="hero relative flex items-center justify-center overflow-hidden transition-all duration-150"
      :class="{
         'h-[90vh]': !isScrolled, 
         'h-[50vh]': isScrolled }">
      <!-- Background Image Placeholder -->
      <div 
        class="absolute inset-0 bg-gray-300 bg-cover bg-center transition-all duration-500"
        :style="{ backgroundImage: `url(${heroImageUrl})` }">
      </div>

      <!-- Decorative Overlay Element -->
      <div class="absolute inset-0 bg-black bg-opacity-30 flex items-center justify-center">
        <div class="w-3/4 h-[50%] rounded-lg border-4 border-opacity-50 border-white shadow-lg flex items-center justify-center">
        </div>
      </div>
      <!-- Call to Action Button -->
      <div class="absolute bottom-8 w-full flex justify-center">
        <button 
          class="bg-blue-600 text-white text-lg font-semibold py-3 px-8 rounded-full shadow-md hover:bg-blue-700 transition-all transform hover:scale-105"
          @click="navigateToLearnMore">
          Explore Our Solutions
        </button>
      </div>
    </section>

    <!-- Why Choose SupplyEase Section -->
    <section class="why-choose bg-gray-50 py-12">
      <div class="max-w-7xl mx-auto px-6 text-center">
        <h2 class="text-3xl font-semibold mb-6 text-gray-800">Why Choose SupplyEase?</h2>
        <div class="scrollable-benefits overflow-x-auto flex space-x-6 pb-4">
          <!-- Benefit Cards -->
          <div class="benefit-card bg-white p-8 rounded-xl shadow-lg flex-shrink-0 w-[300px]">
            <h3 class="text-2xl font-bold mb-4 text-blue-600">Streamlined Procurement</h3>
            <p class="text-gray-700">Easily manage your supply chain with our user-friendly platform. Improve efficiency and reduce delays in the procurement process.</p>
          </div>
          <div class="benefit-card bg-white p-8 rounded-xl shadow-lg flex-shrink-0 w-[300px]">
            <h3 class="text-2xl font-bold mb-4 text-blue-600">Real-Time Inventory Tracking</h3>
            <p class="text-gray-700">Track your inventory in real time, allowing for better planning and reduced stockouts. Stay ahead of your supply chain needs.</p>
          </div>
          <div class="benefit-card bg-white p-8 rounded-xl shadow-lg flex-shrink-0 w-[300px]">
            <h3 class="text-2xl font-bold mb-4 text-blue-600">Advanced Analytics</h3>
            <p class="text-gray-700">Gain valuable insights into your procurement process with advanced analytics, helping you make data-driven decisions and optimize operations.</p>
          </div>
          <div class="benefit-card bg-white p-8 rounded-xl shadow-lg flex-shrink-0 w-[300px]">
            <h3 class="text-2xl font-bold mb-4 text-blue-600">Secure & Scalable</h3>
            <p class="text-gray-700">Our platform is designed with security in mind, ensuring your data is protected while scaling to meet your growing business needs.</p>
          </div>
          <div class="benefit-card bg-white p-8 rounded-xl shadow-lg flex-shrink-0 w-[300px]">
            <h3 class="text-2xl font-bold mb-4 text-blue-600">Seamless Integration</h3>
            <p class="text-gray-700">Integrate SupplyEase seamlessly with your existing tools and systems to ensure a smooth flow of data and enhanced performance.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Image Gallery Section -->
    <div class="image-gallery mb-12">
      <img src="https://plus.unsplash.com/premium_photo-1681487855134-d6c0434f91f8?q=80&w=1470&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Image 1">
      <!-- <img src="file:///C:/Users/rbeep/Downloads/89a5cee7-c945-465a-9730-5c7a768a0f08.webp" alt="Image 2"> -->
      <!-- <img src="file:///C:/Users/rbeep/Downloads/c469b4ea-8d11-4cfb-abfd-a753e985ccfb.webp" alt="Image 3"> -->
      <img src="https://plus.unsplash.com/premium_photo-1681487973297-ce56a7bf9b74?q=80&w=1470&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Image 4">
    </div>

    <!-- Subscription Plans Section -->
    <section class="subscription-plans bg-gray-100 py-12">
      <div class="max-w-7xl mx-auto px-6 text-center">
        <h2 class="text-3xl font-semibold mb-6 text-gray-800">Choose Your Plan</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
          <!-- Plan 1 -->
          <div class="plan bg-white p-8 rounded-xl shadow-lg">
            <h3 class="text-2xl font-bold mb-4 text-blue-600">Basic Plan</h3>
            <p class="text-gray-700 mb-4">Perfect for small businesses starting their supply chain management journey.</p>
            <p class="text-xl font-semibold text-blue-600">$19.99 / month</p>
            <button class="mt-4 bg-blue-600 text-white py-2 px-6 rounded-full shadow-md hover:bg-blue-700">Sign Up</button>
          </div>

          <!-- Plan 2 -->
          <div class="plan bg-white p-8 rounded-xl shadow-lg">
            <h3 class="text-2xl font-bold mb-4 text-blue-600">Standard Plan</h3>
            <p class="text-gray-700 mb-4">For growing businesses looking for more advanced features and scalability.</p>
            <p class="text-xl font-semibold text-blue-600">$49.99 / month</p>
            <button class="mt-4 bg-blue-600 text-white py-2 px-6 rounded-full shadow-md hover:bg-blue-700">Sign Up</button>
          </div>

          <!-- Plan 3 -->
          <div class="plan bg-white p-8 rounded-xl shadow-lg">
            <h3 class="text-2xl font-bold mb-4 text-blue-600">Premium Plan</h3>
            <p class="text-gray-700 mb-4">For enterprises needing full-scale support and advanced analytics.</p>
            <p class="text-xl font-semibold text-blue-600">$99.99 / month</p>
            <button class="mt-4 bg-blue-600 text-white py-2 px-6 rounded-full shadow-md hover:bg-blue-700">Sign Up</button>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import { heroImageUrl } from '../utils/image.js';

// Set up router for navigation
const router = useRouter();
const navigateToLearnMore = () => {
  router.push('/learn-more'); // Update with your actual route
};
const scrollDown = () => {
  // Scroll to a specific section, e.g., "why-choose" section
  const section = document.querySelector('.why-choose');
  if (section) {
    section.scrollIntoView({ behavior: 'smooth' });
  }
};
</script>

<style scoped>


.hero {
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
  min-height: 60vh; /* Ensure image fills at least 50vh */
}
.transition-all {
  transition: all 0.3s ease-out;
}

.content {
  flex: 1;
  overflow-y: auto;
}

.why-choose {
  background-color: #f8f9fa;
}

.scrollable-benefits {
  display: flex;
  gap: 1.5rem;
}

.benefit-card {
  padding: 2rem;
  background-color: white;
  border-radius: 12px;
  box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
  width: 300px;
  text-align: center;
}

.benefit-card h3 {
  color: #007BFF;
  font-size: 1.5rem;
  margin-bottom: 1rem;
}

.benefit-card p {
  color: #4A4A4A;
  font-size: 1rem;
}

.scrollable-benefits::-webkit-scrollbar {
  height: 6px;
}

.scrollable-benefits::-webkit-scrollbar-thumb {
  background-color: rgba(0, 123, 255, 0.5);
  border-radius: 3px;
}

.scrollable-benefits::-webkit-scrollbar-track {
  background-color: rgba(0, 0, 0, 0.1);
}
.image-gallery {
  display: grid;
  grid-template-columns: repeat(2, 1fr); /* 3 images per row */
  gap: 9px; /* Space between images */
}

.image-gallery img {
  width: 100%;
  height: auto;
  border-radius: 10px; /* Optional: adds rounded corners */
}

.subscription-plans {
  padding: 3rem;
  background-color: #f7f9fb;
}

.plan {
  text-align: center;
  padding: 2rem;
  background-color: white;
  border-radius: 12px;
  box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
}

.plan h3 {
  font-size: 2rem;
  font-weight: 700;
  color: #007bff;
}

.plan button {
  background-color: #007bff;
  color: white;
  padding: 10px 20px;
  border-radius: 5px;
  font-size: 1rem;
  margin-top: 1rem;
}

.plan button:hover {
  background-color: #0056b3;
}


</style>