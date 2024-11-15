<script setup lang="ts">
import { ref, onMounted, onUnmounted } from 'vue';

// Key features (unchanged)
const featureSlides = [
  [
    { icon: 'fas fa-tachometer-alt', title: 'Efficiency', description: 'Optimize your production flow and reduce bottlenecks effortlessly.' },
    { icon: 'fas fa-users', title: 'Collaboration', description: 'Work seamlessly with your team using our real-time tools.' },
    { icon: 'fas fa-robot', title: 'Automation', description: 'Automate repetitive tasks and focus on what truly matters.' }
  ],
  [
    { icon: 'fas fa-chart-line', title: 'Analytics', description: 'Gain actionable insights into your production with real-time analytics.' },
    { icon: 'fas fa-expand-arrows-alt', title: 'Scalability', description: 'Easily scale your operations as your business grows.' },
    { icon: 'fas fa-lock', title: 'Security', description: 'Protect your data with state-of-the-art security measures.' }
  ]
];

const activeSlideIndex = ref(0);

const moveLeft = () => {
  if (activeSlideIndex.value > 0) {
    activeSlideIndex.value -= 1;
  }
};

const moveRight = () => {
  if (activeSlideIndex.value < featureSlides.length - 1) {
    activeSlideIndex.value += 1;
  }
};

// Testimonials data
const testimonials = ref([
  { name: 'Alice Johnson', comment: 'Supply Ease has revolutionized our workflow!', avatar: 'https://via.placeholder.com/100?text=A' },
  { name: 'Bob Smith', comment: 'An essential tool for streamlining production.', avatar: 'https://via.placeholder.com/100?text=B' },
  { name: 'Charlie Brown', comment: 'Highly recommend for anyone in manufacturing!', avatar: 'https://via.placeholder.com/100?text=C' },
]);

const activeTestimonialIndex = ref(0);
let testimonialInterval: number | undefined;

const startTestimonialRotation = () => {
  testimonialInterval = setInterval(() => {
    activeTestimonialIndex.value = (activeTestimonialIndex.value + 1) % testimonials.value.length;
  }, 4000); // Slower change every 4 seconds
};

onMounted(() => {
  startTestimonialRotation();
});

onUnmounted(() => {
  clearInterval(testimonialInterval);
});
</script>

<template>
  <div>
    <!-- Hero Section -->
    <section
      class="bg-cover bg-center relative"
      :style="{ backgroundImage: `url(${heroImageUrl})`, height: '600px' }">
      <div class="absolute inset-0 bg-gradient-to-r from-black/60 to-transparent"></div>
      <div class="flex items-center justify-center h-full">
        <div class="lg:px-12 md:py-36 pb-6 pt-72 px-6 relative text-center text-white fade-in">
          <h1 class="capitalize leading-tight mb-4 text-white text-3xl lg:text-5xl font-semibold tracking-wider">
            Streamlining Your Production Processes
          </h1>
          <p class="text-lg text-gray-300 font-semibold mb-8">
            Join us to optimize workflows and simplify your production journey.
          </p>
          <button class="bg-primary-600 hover:bg-primary-700 text-white font-bold py-2 px-6 rounded-lg transition">
            Get Started
          </button>
        </div>
      </div>
    </section>

    <!-- Features Section -->
    <section class="bg-gray-100 dark:bg-gray-800 py-20 px-8">
      <div class="container mx-auto text-center">
        <h2 class="text-3xl font-bold mb-6 fade-in text-gray-800 dark:text-gray-200">Our Key Features</h2>
        <div class="flex justify-between items-center mb-6">
          <button @click="moveLeft" :disabled="activeSlideIndex === 0" class="text-primary-600 dark:text-primary-400 p-4 hover:bg-gray-200 rounded-full">
            <i class="fas fa-chevron-left"></i>
          </button>

          <div class="w-full overflow-hidden">
            <div :style="{ transform: `translateX(-${activeSlideIndex * 100}%)`, transition: 'transform 0.5s ease' }" class="flex space-x-8">
              <div v-for="(features, slideIndex) in featureSlides" :key="slideIndex" class="w-full flex-shrink-0 p-4 fade-in">
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
                  <div v-for="(feature, index) in features" :key="index" class="flex flex-col items-center mb-8">
                    <div class="text-primary-600 dark:text-primary-400 mb-4">
                      <i :class="feature.icon + ' fa-3x'"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2 text-gray-800 dark:text-gray-200">{{ feature.title }}</h3>
                    <p class="text-gray-600 dark:text-gray-300 text-center">{{ feature.description }}</p>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <button @click="moveRight" :disabled="activeSlideIndex === featureSlides.length - 1" class="text-primary-600 dark:text-primary-400 p-4 hover:bg-gray-200 rounded-full">
            <i class="fas fa-chevron-right"></i>
          </button>
        </div>
      </div>
    </section>

    <!-- Testimonials Section -->
    <section class="container mx-auto pt-20 pb-12 px-8">
      <div class="text-center">
        <h2 class="text-3xl font-bold mb-6 fade-in text-gray-800 dark:text-gray-200">Testimonials</h2>
        <p class="max-w-2xl mx-auto text-gray-600 dark:text-gray-300 mb-8 fade-in">
          See what our users have to say about their experience with Supply Ease.
        </p>
        <div class="flex flex-col items-center">
          <div v-for="(testimonial, index) in testimonials" :key="index" v-show="index === activeTestimonialIndex" class="w-full max-w-xl p-6 bg-white shadow-md rounded-lg flex flex-col items-center space-y-4 fade-in">
            <img :src="testimonial.avatar" alt="User avatar" class="w-20 h-20 rounded-full object-cover shadow-lg" />
            <blockquote class="text-lg italic text-gray-600">
              "{{ testimonial.comment }}"
            </blockquote>
            <cite class="font-bold text-primary-600">{{ testimonial.name }}</cite>
          </div>
        </div>
      </div>
    </section>

    <!-- Contact Section -->
    <section class="bg-primary-600 dark:bg-primary-700 py-20 text-white px-8 mb-0">
      <div class="container mx-auto text-center">
        <h2 class="text-3xl font-bold mb-6 fade-in">Contact Us</h2>
        <p class="max-w-2xl mx-auto mb-8 fade-in">
          Have questions? Reach out to us and let us know how we can help.
        </p>
        <button class="bg-white text-primary-600 font-bold py-2 px-6 rounded-lg transition hover:bg-gray-200">
          Get in Touch
        </button>
      </div>
    </section>
  </div>
</template>

<style scoped>
.fade-in {
  opacity: 0;
  transform: translateY(20px);
  animation: fadeIn 1s ease forwards;
}

@keyframes fadeIn {
  to {
    opacity: 1;
    transform: translateY(0);
  }
}
</style>
