import { reactive } from 'vue'

export const store = reactive({
  addedToCart: [],
  isOpenCart: false,
  isOpenOrderStatus: false,
  isOpenPaymentStatus: false,
  billingAddress: { buildingNo: '', street: '', city: '', province: '', region: '', areaCode: '', contactNum: ''},
  selectedCustomer: null,
})