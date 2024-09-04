<template>
  <div class="p-6">
    <h1 class="text-2xl font-bold mb-4">Dashboard Overview</h1>
    <SummaryCard />
    <NotificationList />
  </div>
</template>

<script setup>
import SummaryCard from '~/components/SummaryCard.vue'
import NotificationList from '~/components/NotificationList.vue'
</script>

<style scoped>

</style>
