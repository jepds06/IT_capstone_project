<!-- <template>
    <header class="bg-[#003366] text-white p-4 flex justify-between items-center">
      <div class="text-xl font-semibold">Administrator Dashboard</div>
      <div class="flex space-x-4">
        <button class="bg-[#004080] px-4 py-2 rounded">Notifications</button>
        <button class="bg-[#004080] px-4 py-2 rounded">Profile</button>
        <button class="bg-[#004080] px-4 py-2 rounded">Settings</button>
      </div>
    </header>
  </template>
  
  <script setup>
  </script>
  
  <style scoped>
  </style>
   -->

<template>
    <header class="bg-gray-900 text-white p-3 shadow-lg">
      <div class="container mx-auto flex justify-between items-center">
        <!-- Logo Section -->
        <div class="text-xl font-bold">
          {{userInfo.userTypeDescription}} Dashboard
        </div>
  
  
        <div class="flex items-center">
          <!-- <UAvatar
          icon="ant-design:bell-outlined"
          size="md"
          chip-text="+1"
          chip-position="top-right"
          alt="Avatar"
          chip-color="primary"
          class="mr-2"
        /> -->
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
</template>

<script setup>
import { _width } from "#tailwind-config/theme";
import { apiService } from "~/api/apiService";
const userInfo = ref({ userName: "" });
const token = ref(null);

const logout = async() =>{
  await apiService.post('/api/logout', userInfo.value, token.value)
  localStorage.removeItem('userInfo')
  localStorage.removeItem('userPermission')
  localStorage.removeItem('authToken')
  navigateTo('/')
}
onMounted(() => {
  if (process.client) {
    const storage = JSON.parse(localStorage.getItem("userInfo"));
    userInfo.value = storage ? storage : null;
    token.value = localStorage.getItem("authToken")
  }
});
</script>
