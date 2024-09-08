<script setup lang="ts">
  import { heroImageUrl } from '../utils/image.js'

  const heroCaption = 'Adopt A Pet'
  const heroTitle = 'Thousands of homeless dogs, one act of kindness'
  const heroDescription =
    'Find your new furry friend today! We have a wide variety of lovable pets available for adoption. Come visit us and take home your new best friend!'
</script>
<template>
  <section class="container mx-auto pt-20 pb-12 px-8">
    <BackgroundImageWrapper :image-url="heroImageUrl" class="rounded-3xl bg-cover bg-center">
      <div class="flex items-center justify-center h-full">
        <div class="lg:px-12 md:py-36 pb-6 pt-72 px-6 relative rounded-3xl bg-opacity-50">
          <div
            class="-mx-4 flex flex-wrap items-center mt-24 space-y-6 lg:space-y-0"
          >
            <div class="px-4 w-full md:w-8/12 xl:w-6/12">
              <h4
                class="font-bold font-serif mb-1 text-primary-600 dark:text-primary-200 uppercase"
              >
              Lorem Ipsum
              </h4>
              <h1 class="capitalize leading-tight mb-2 text-white">
                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, 
                when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, 
                but also the leap into electronic typesetting, remaining essentially unchanged. 
                It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, a
                nd more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
              </h1>
              <p class="font-semibold mb-6 text-gray-300">
                Lorem Ipsum
              </p>
          
            </div>
          </div>
        </div>
      </div>
    </BackgroundImageWrapper>
  </section>
</template>

<style scoped>
/* Optionally, you can add more styles here */
</style>
