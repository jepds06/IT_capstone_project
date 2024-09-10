<template>
  <div :id="'sidebar'" :class="sidebarClasses">
    <!-- Close Button for Sidebar on Mobile -->
    <button
      v-if="isSidebarOpen && isMobile"
      @click="$emit('toggleSidebar')"
      class="absolute top-4 right-4 text-white md:hidden"
      aria-expanded="true"
      aria-controls="sidebar"
    >
      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
      </svg>
    </button>

    <!-- Sidebar Header -->
    <div class="font-bold text-lg mb-5 flex items-center">
      <span>Menu</span>
    </div>

    <!-- Navigation Links -->
    <nav class="sidebar-content">
      <ul role="list" class="flex flex-col gap-y-4">
        <li v-for="(item, index) in navigation" :key="index">
          <!-- Check if item has children for collapsible behavior -->
          <Disclosure as="div" v-if="item.children">
            <DisclosureButton 
              :class="[item.current ? 'bg-gray-50' : 'hover:bg-gray-50', 'flex items-center w-full text-left rounded-md p-2 gap-x-3 text-sm leading-6 font-semibold text-gray-700']"
              @click="toggleOpen(index)"
              :aria-expanded="openIndex === index"
            >
              <ChevronRightIcon :class="[openIndex === index ? 'rotate-90 text-gray-500' : 'text-gray-400', 'h-5 w-5 shrink-0']" aria-hidden="true" />
              {{ item.name }}
            </DisclosureButton>
            <DisclosurePanel as="ul" class="mt-1 px-2" v-if="openIndex === index">
              <li v-for="subItem in item.children" :key="subItem.name">
                <router-link :to="subItem.href" class="block rounded-md py-2 pr-2 pl-9 text-sm leading-6 text-gray-700">
                  {{ subItem.name }}
                </router-link>
              </li>
            </DisclosurePanel>
          </Disclosure>
          <!-- Regular item -->
          <router-link 
            v-else
            :to="item.href"
            :class="[item.current ? 'bg-gray-50' : 'hover:bg-gray-50', 'block rounded-md py-2 pr-2 pl-10 text-sm leading-6 font-semibold text-gray-700']"
          >
            <i :class="item.icon"></i>
            {{ item.name }}
          </router-link>
        </li>
      </ul>
    </nav>
  </div>
</template>
Script:

javascript
Copy code
<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue'
import { Disclosure, DisclosureButton, DisclosurePanel } from '@headlessui/vue'
import { ChevronRightIcon } from '@heroicons/vue/20/solid'

// Props
const props = defineProps({
  isSidebarOpen: Boolean
})

// Emits
const emit = defineEmits(['toggleSidebar'])

const isDesktop = ref(false)
const isMobile = ref(true)
const openIndex = ref(null) // Index of the currently open section

const navigation = [
  { name: 'Dashboard', href: '/dashboard', icon: 'fas fa-tachometer-alt', current: true, isOpen: false },
  {
    name: 'Users',
    current: false,
    isOpen: false,
    children: [
      { name: 'All Users', href: '/users/all' },
      { name: 'User Roles', href: '/users/roles' },
      { name: 'Permissions', href: '/users/permissions' },
    ],
  },
  {
    name: 'Reports',
    current: false,
    isOpen: false,
    children: [
      { name: 'Sales Reports', href: '/reports/sales' },
      { name: 'User Activity', href: '/reports/user-activity' },
      { name: 'Performance Metrics', href: '/reports/performance' },
    ],
  },
  {
    name: 'Settings',
    current: false,
    isOpen: false,
    children: [
      { name: 'General Settings', href: '/settings/general' },
      { name: 'Notification Settings', href: '/settings/notifications' },
      { name: 'Account Management', href: '/settings/account' },
    ],
  },
  {
    name: 'Analytics',
    current: false,
    isOpen: false,
    children: [
      { name: 'Overview', href: '/analytics/overview' },
      { name: 'Traffic Analysis', href: '/analytics/traffic' },
      { name: 'Conversion Metrics', href: '/analytics/conversion' },
    ],
  },
  {
    name: 'Help',
    current: false,
    isOpen: false,
    children: [
      { name: 'Documentation', href: '/help/documentation' },
      { name: 'Support Tickets', href: '/help/tickets' },
      { name: 'Contact Support', href: '/help/contact' },
    ],
  },
]

const sidebarClasses = computed(() => [
  'bg-gray-900 text-white h-screen p-4 fixed top-0 left-0 z-40 transition-transform duration-300 ease-in-out',
  'md:w-64',
  { 
    'transform -translate-x-full': !props.isSidebarOpen && !isDesktop.value, 
    'translate-x-0': props.isSidebarOpen || isDesktop.value 
  }
])

const handleResize = () => {
  if (typeof window !== 'undefined') {
    isDesktop.value = window.innerWidth >= 768
    isMobile.value = window.innerWidth < 768
    if (isDesktop.value) {
      emit('toggleSidebar', true)
    }
  }
}

const toggleOpen = (index) => {
  openIndex.value = openIndex.value === index ? null : index
}

onMounted(() => {
  handleResize()
  window.addEventListener('resize', handleResize)
})

onUnmounted(() => {
  window.removeEventListener('resize', handleResize)
})
;

</script>

<style scoped>
.sidebar-content {
  height: calc(100% - 4rem); /* Adjust if needed for spacing */
  overflow-y: auto; /* Allow vertical scrolling */
  -ms-overflow-style: none; /* IE and Edge */
  scrollbar-width: none; /* Firefox */
}

.sidebar-content::-webkit-scrollbar {
  display: none; /* Safari and Chrome */
}

button {
  background: none;
  border: none;
  cursor: pointer;
}

button:hover {
  background-color: #f1f1f1;
}

/* Optional: Add this to help debug spacing issues */
* {
  box-sizing: border-box;
}
</style>
why does it collapse the other one I want it still uncollapse until I press the arrow