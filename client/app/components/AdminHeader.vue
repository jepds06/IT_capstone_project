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
  <UHeader>
    <template #logo> Supplier Dashboard </template>

    <template #right>
      <!-- <UButton label="Notifications" color="gray" />
      <UButton label="Profile" color="gray" />
      <UButton label="Settings" color="gray" /> -->
      <UAvatar
        icon="ant-design:bell-outlined"
        size="md"
        chip-text="+1"
        chip-position="top-right"
        alt="Avatar"
        chip-color="primary"
      />
      <UPopover mode="hover">
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
    </template>

    <!-- <template #panel>
      <UNavigationTree
        :links="mapContentNavigation(navigation)"
        default-open
      />
    </template> -->
  </UHeader>
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
