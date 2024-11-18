<script setup lang="ts">
import type { ParsedContent } from '@nuxt/content'
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
const { data: files } = useLazyFetch<ParsedContent[]>('/api/search.json', { default: () => [], server: false })

provide('navigation', navigation)
</script>

<template>
  <div>
    <AppHeader />

    <UMain>
      <UContainer>
       <main>
        Error
       </main>
      </UContainer>
    </UMain>

    <AppFooter />

    <UNotifications />
  </div>
</template>
