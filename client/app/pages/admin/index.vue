<template>
  <AdminWidget />
</template>

<script setup lang="ts">
import auth from '../../../middleware/auth'
// This page requires authentication

useSeoMeta({
  title: 'Admin',
  description: 'Admin Dashboard'
});

definePageMeta({
  middleware: [auth],
});
</script>

<style scoped></style>
