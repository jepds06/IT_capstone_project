<script setup lang="ts">
import { _width } from "#tailwind-config/theme";
</script>

<template>
  <UHeader>
    <template #logo>
      SupplyEase <UBadge label="SE" variant="subtle" class="mb-0.5" />
    </template>

    <template #right>
      <!-- <UButton label="Notifications" color="gray" />
      <UButton label="Profile" color="gray" />
      <UButton label="Settings" color="gray" /> -->
      <UButton
        icon="material-symbols:account-circle"
        size="sm"
        color="gray"
      />
    </template>

    <!-- <template #panel>
         <UNavigationTree
           :links="mapContentNavigation(navigation)"
           default-open
         />
       </template> -->
  </UHeader>
</template>
