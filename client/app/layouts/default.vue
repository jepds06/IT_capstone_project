<!-- <script setup lang="ts">
import type { ParsedContent } from '@nuxt/content'
const route = useRoute()

const { data: navigation } = await useAsyncData('navigation', () => fetchContentNavigation(), { default: () => [] })
const { data: files } = useLazyFetch<ParsedContent[]>('/api/search.json', { default: () => [], server: false })

provide('navigation', navigation)
console.log(route.path)
</script>

<template>
  <div v-if="route.path === '/'">
    <AppHeader /> 

    <main>
      <NuxtPage />
    </main>

    <AppFooter />
  </div>

  <div v-else-if="route.path === '/admin'">
    <AdminHeader/>
    <AdminSidebar/>
    <main>
      <NuxtPage />
    </main>
  </div>

   <ClientOnly>
      <LazyUContentSearch
        :files="files"
        :navigation="navigation"
      />
    </ClientOnly>
</template> -->

<script setup lang="ts">
import type { ParsedContent } from "@nuxt/content";
const route = useRoute();
const { data: navigation } = await useAsyncData(
  "navigation",
  () => fetchContentNavigation(),
  { default: () => [] }
);
const { data: files } = useLazyFetch<ParsedContent[]>("/api/search.json", {
  default: () => [],
  server: false,
});

provide("navigation", navigation);
</script>

<template>
  <div v-if="route.path === '/'">
    <AppHeader />

    <UMain>
      <slot />
    </UMain>

    <AppFooter />

    <ClientOnly>
      <LazyUContentSearch :files="files" :navigation="navigation" />
    </ClientOnly>
  </div>

  <div v-else-if="route.path.includes('/admin')">
    <AdminHeader />
    <div class="flex">
      <AdminSidebar />
      <div class="flex-1 p-6">
        <main>
          <UMain>
            <slot />
          </UMain>
        </main>
      </div>
    </div>
    <AppFooter />

    <ClientOnly>
      <LazyUContentSearch :files="files" :navigation="navigation" />
    </ClientOnly>
  </div>

  <div v-else>
    <CustomerHeader />
    <UMain>
      <slot />
    </UMain>
    <!-- <ClientOnly>
      <LazyUContentSearch
        :files="files"
        :navigation="navigation"
      />
    </ClientOnly> -->
  </div>
</template>
