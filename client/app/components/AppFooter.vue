<script setup lang="ts">

</script>

<template>
  <UFooter>
    <template #left>
      <p class="text-gray-500 dark:text-gray-400 text-sm">
        SE Copyright © {{ new Date().getFullYear() }}. All rights reserved.
      </p>
    </template>

    <template #right>
      <UColorModeButton size="sm" />

    </template>
  </UFooter>
</template>
