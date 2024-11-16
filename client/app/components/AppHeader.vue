<script setup lang="ts">
import { _width } from '#tailwind-config/theme';

const isSignInOpen = ref(false);
const isSignUpOpen = ref(false);
// import type { NavItem } from '@nuxt/content'

// const navigation = inject<Ref<NavItem[]>>('navigation', ref([]))

// const links = [{
//   label: 'Docs',
//   to: '/docs'
// }, {
//   label: 'Pricing',
//   to: '/pricing'
// }, {
//   label: 'Blog',
//   to: '/blog'
// }]

const closeModal = () => {
  isSignUpOpen.value = false;
};
</script>

<template>
  <Header>
    <template #logo>
      SupplyEase <UBadge label="SE" variant="subtle" class="mb-0.5" />
    </template>

    <template #right>
      <UButton label="Sign in" color="gray" @click="isSignInOpen = true" />

      <UModal v-model="isSignInOpen" :style="{width:'inherit', height:'inherit '}" class="">
        <div class="p-4">
          <Login />
        </div>
      </UModal>

      <!-- <UButton
        label="Sign up"
        icon="i-heroicons-arrow-right-20-solid"
        trailing
        color="black"
        @click="isSignUpOpen = true"
        class="hidden lg:flex"
      /> -->
      <!-- <UModal v-model="isSignUpOpen" prevent-close>
        <div class="p-4">
          <SignUp @close-modal="closeModal"/>
        </div>
      </UModal> -->
    </template>

    <!-- <template #panel>
      <UNavigationTree
        :links="mapContentNavigation(navigation)"
        default-open
      />
    </template> -->
  </Header>
</template>
