<template>
  <header class="bg-gray-900 text-white p-3 shadow-lg">
    <div class="container mx-auto flex justify-between items-center">
      <!-- Logo Section -->
      <div class="text-xl font-bold">
        {{ userInfo.userTypeDescription }} Dashboard
      </div>

      <div class="flex items-center">
        <UButton @click="store.isOpenCart = true" color="white" class="mr-2" icon="solar:cart-4-linear" size="md" :label="`Cart(${store.addedToCart.length})`" />
        <UPopover mode="hover" class="mr-2">
          <UAvatar icon="ant-design:user-outlined" size="md" />
          <template #panel>
            <div class="p-4">
              <UButton
                :padded="false"
                color="gray"
                variant="link"
                @click="logout"
              >
                Logout
              </UButton>
            </div>
          </template>
        </UPopover>
        <div :v-if="userInfo?.userName">{{ `Hi, ${userInfo.userName}` }}</div>
      </div>
    </div>
  </header>

  <UModal v-model="store.isOpenCart" fullscreen>
      <CustomerDashboard />
  </UModal>
</template>

<script setup>
import { store } from "~/composables/store";
import { _width } from "#tailwind-config/theme";
import { apiService } from "~/api/apiService";
const userInfo = ref({ userName: "" });
const token = ref(null);

const logout = async () => {
  await apiService.post("/api/logout", userInfo.value, token.value);
  localStorage.removeItem("userInfo");
  localStorage.removeItem("userPermission");
  localStorage.removeItem("authToken");
  navigateTo("/");
};
onMounted(() => {
  if (process.client) {
    const storage = JSON.parse(localStorage.getItem("userInfo"));
    userInfo.value = storage ? storage : null;
    token.value = localStorage.getItem("authToken");
  }
});
</script>
