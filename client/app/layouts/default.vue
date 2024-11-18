
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
  <div v-if="route.path === '/'" class="layout">
    <AppHeader />

    <main class="flex-grow">
      <slot />
    </main>

    <AppFooter />

  </div>

  <div v-else-if="route.path.includes('/admin')" class="layout">
    <AdminHeader />
    
    <div class="flex flex-grow">
      <!-- Sidebar -->
      <AdminSidebar class="w-64" />
      
      <!-- Main Content -->
      <div class="flex-1 flex flex-col">
        <main class="flex-grow p-6">
          <slot />
        </main>
        
        <!-- Footer -->
        <AppFooter />
      </div>
    </div>
  </div>

  <div v-else-if="route.path.includes('/supplier')" class="layout">
    <AdminHeader />
    <div class="flex">
          <main>
            <slot />
          </main>
    </div>
    <AppFooter />
  </div>

  <div v-else class="layout">
    <CustomerHeader />
    <main class="flex-grow">
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

<style>
.layout {
  display: flex;
  flex-direction: column;
  min-height: 100vh; /* Ensures the layout stretches to the full viewport height */
}

main {
  flex-grow: 1; /* Allows main content to take up remaining space */
}

.flex-grow {
  flex-grow: 1; /* Makes the content area expand */
}
</style>