import { reactive } from 'vue'

export const store = reactive({
  addedToCart: [],
  isOpenCart: false,
  billingAddress: { buildingNo: '', street: '', city: '', province: '', region: '', areaCode: '', contactNum: ''}
})