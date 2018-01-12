
// 1. Define route components.
// These can be imported from other files
import DashboardIndex from './components/dashboard/DashboardIndex.vue';
import UserIndex from './components/user/UserIndex.vue';
import UserCreate from './components/user/UserCreate.vue';
import UserEdit from './components/user/UserEdit.vue';
import MobilIndex from './components/mobil/MobilIndex.vue';
import MobilCreate from './components/mobil/MobilCreate.vue';
import MobilEdit from './components/mobil/MobilEdit.vue';
import SupplierIndex from './components/supplier/SupplierIndex.vue';
import SupplierCreate from './components/supplier/SupplierCreate.vue';
import SupplierEdit from './components/supplier/SupplierEdit.vue';
import DriverIndex from './components/driver/DriverIndex.vue';
import DriverCreate from './components/driver/DriverCreate.vue';
import DriverEdit from './components/driver/DriverEdit.vue';
import GudangIndex from './components/gudang/GudangIndex.vue';
import GudangCreate from './components/gudang/GudangCreate.vue';
import GudangEdit from './components/gudang/GudangEdit.vue';


// 2. Define some routes
// Each route should map to a component. The "component" can
// either be an actual component constructor created via
// `Vue.extend()`, or just a component options object.
// We'll talk about nested routes later.
const routes = [
  { path: '/', component: DashboardIndex,name:'IndexDashboard' },
  { path: '/user', component: UserIndex,name: 'IndexUser' },
  { path: '/user/create', component: UserCreate,name: 'CreateUser' },
  { path: '/user/edit/:id', component: UserEdit,name: 'EditUser' },
  { path: '/mobil', component: MobilIndex,name: 'IndexMobil' },
  { path: '/mobil/create', component: MobilCreate,name: 'CreateMobil' },
  { path: '/mobil/edit/:id', component: MobilEdit,name: 'EditMobil' },
  { path: '/supplier', component:SupplierIndex,name: 'IndexSupplier' },
  { path: '/supplier/create', component:SupplierCreate,name: 'CreateSupplier' },
  { path: '/supplier/edit/:id', component:SupplierEdit,name: 'EditSupplier' },
  { path: '/driver', component:DriverIndex,name: 'IndexDriver' },
  { path: '/driver/create', component:DriverCreate,name: 'CreateDriver' },
  { path: '/driver/edit/:id', component:DriverEdit,name: 'EditDriver' },
  { path: '/gudang', component:GudangIndex,name: 'IndexGudang' },
  { path: '/gudang/create', component:GudangCreate,name: 'CreateGudang' },
  { path: '/gudang/edit/:id', component:GudangEdit,name: 'EditGudang' },
]

export default routes;
