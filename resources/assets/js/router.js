
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

const Foo = { template: '<div>foo</div>' }
const Bar = { template: '<div>bar</div>' }

// 2. Define some routes
// Each route should map to a component. The "component" can
// either be an actual component constructor created via
// `Vue.extend()`, or just a component options object.
// We'll talk about nested routes later.
const routes = [
  { path: '/foo', component: Foo },
  { path: '/bar', component: Bar },
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
]

export default routes;
