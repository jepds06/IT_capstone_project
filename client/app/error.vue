<script setup lang="ts">
import type { NuxtError } from '#app'

useSeoMeta({
  title: 'Page not found',
  description: 'We are sorry but this page could not be found.'
})

defineProps({
  error: {
    type: Object as PropType<NuxtError>,
    required: true
  }
})

useHead({
  htmlAttrs: {
    lang: 'en'
  }
})

const { data: navigation } = await useAsyncData('navigation', () => fetchContentNavigation(), { default: () => [] })

provide('navigation', navigation)
</script>

<template>
  <div>
    <AppHeader />

 
      <UContainer>
       <main>
        Error
       </main>
      </UContainer>

    <AppFooter />

    <UNotifications />
  </div>
</template>
