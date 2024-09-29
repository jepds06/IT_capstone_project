<template>
  <AdminWidget />
</template>

<script setup lang="ts">
import auth from '../../../middleware/auth'
// This page requires authentication
definePageMeta({
  middleware: [auth],
});
</script>

<style scoped></style>
