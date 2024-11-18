
<script setup lang="ts">
const route = useRoute();
const { data: navigation } = await useAsyncData(
  "navigation",
  () => fetchContentNavigation(),
  { default: () => [] }
);

provide("navigation", navigation);
</script>

<template>
  <div v-if="route.path === '/'">
    <AppHeader />

    <main>
      <slot />
    </main>

    <AppFooter />

  </div>

  <div v-else-if="route.path.includes('/admin')">
    <AdminHeader />
    <div class="flex">
      <AdminSidebar />
      <div class="flex-1 p-6">
        <main>
          <main>
            <slot />
          </main>
        </main>
      </div>
    </div>
    <AppFooter />
  </div>

  <div v-else-if="route.path.includes('/supplier')">
    <AdminHeader />
    <div class="flex">
      <div class="flex-1 p-6">
        <main>
          <main>
            <slot />
          </main>
        </main>
      </div>
    </div>
    <AppFooter />
  </div>

  <div v-else>
    <CustomerHeader />
    <main>
      <slot />
    </main>
    <!-- <ClientOnly>
      <LazyUContentSearch
        :files="files"
        :navigation="navigation"
      />
    </ClientOnly> -->
    <AppFooter />
  </div>
</template>
