<template>
  <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3 m-4">
    <div v-for="item in items" :key="item.id">
      <UCard class="">
        <template #header>
          <div class="flex">
            <p class="font-bold m-1">{{ item.content }}</p>
            <UBadge variant="subtle"
            size="lg"
            class="relative font-semibold">{{item.type}}</UBadge>
          </div>
        </template>

        <div class="items-center text-center">
          <img :src="item.src" alt="Sample Image" />
        </div>

        <template #footer> </template>
      </UCard>
    </div>
  </div>
</template>

<script setup>
const items = [
  { id: 1, content: "Item 1", src: "https://picsum.photos/id/1/200/300", type: 'Chair' },
  { id: 2, content: "Item 2", src: "https://picsum.photos/id/0/200/300", type: 'Chair' },
  { id: 3, content: "Item 3", src: "https://picsum.photos/id/1/200/300", type: 'Table' },
  { id: 4, content: "Item 4", src: "https://picsum.photos/id/1/200/300", type: 'Table' },
  { id: 5, content: "Item 5", src: "https://picsum.photos/id/1/200/300", type: 'Electronics' },
  { id: 6, content: "Item 6", src: "https://picsum.photos/id/1/200/300", type: 'Sofa' },
];
</script>

<style scoped>
/* Additional styles can go here */
</style>
