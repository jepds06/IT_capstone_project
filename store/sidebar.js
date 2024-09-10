import { reactive } from 'vue'

const state = reactive({
  isSidebarOpen: false
})

const toggleSidebar = () => {
  state.isSidebarOpen = !state.isSidebarOpen
}

export default {
  state,
  toggleSidebar
}
