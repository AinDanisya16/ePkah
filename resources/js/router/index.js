import { createRouter, createWebHistory } from 'vue-router'
import { useAuthStore } from '@/stores/auth'

// Auth views
import Login from '@/views/auth/Login.vue'
import Register from '@/views/auth/Register.vue'
import ForgotPassword from '@/views/auth/ForgotPassword.vue'

// Layout components
import DashboardLayout from '@/layouts/DashboardLayout.vue'

// Admin views
import AdminDashboard from '@/views/admin/Dashboard.vue'
import AdminFirstPage from '@/views/admin/FirstPage.vue'
import AdminPenghantaran from '@/views/admin/Penghantaran.vue'
import AdminDalamProses from '@/views/admin/DalamProses.vue'
import AdminSelesai from '@/views/admin/Selesai.vue'
import AdminSenaraiPengguna from '@/views/admin/SenaraiPengguna.vue'
import AdminSenaraiVendor from '@/views/admin/SenaraiVendor.vue'
import AdminStatistik from '@/views/admin/Statistik.vue'
import AdminAssignVendor from '@/views/admin/AssignVendor.vue'

// Vendor views
import VendorDashboard from '@/views/vendor/Dashboard.vue'
import VendorFirstPage from '@/views/vendor/FirstPage.vue'
import VendorPenghantaran from '@/views/vendor/Penghantaran.vue'
import VendorKutipan from '@/views/vendor/Kutipan.vue'

// Pengguna views
import PenggunaDashboard from '@/views/pengguna/Dashboard.vue'
import PenggunaPenghantaran from '@/views/pengguna/Penghantaran.vue'
import PenggunaRecycleInfo from '@/views/pengguna/RecycleInfo.vue'
import PenggunaHome from '@/views/pengguna/Home.vue'
import PenggunaProgram from '@/views/pengguna/Program.vue'
import PenggunaLokasi from '@/views/pengguna/Lokasi.vue'
import PenggunaFirstPage from '@/views/pengguna/FirstPage.vue'

// Sekolah views
import SekolahDashboard from '@/views/sekolah/Dashboard.vue'
import SekolahPenghantaran from '@/views/sekolah/Penghantaran.vue'
import SekolahFirstPage from '@/views/sekolah/FirstPage.vue'

const routes = [
  // Public routes
  {
    path: '/',
    name: 'login',
    component: Login,
    meta: { requiresGuest: true }
  },
  {
    path: '/register',
    name: 'register',
    component: Register,
    meta: { requiresGuest: true }
  },
  {
    path: '/forgot-password',
    name: 'forgot-password',
    component: ForgotPassword,
    meta: { requiresGuest: true }
  },

  // Admin routes
  {
    path: '/admin',
    component: DashboardLayout,
    meta: { requiresAuth: true, role: 'admin' },
    children: [
      {
        path: '',
        redirect: '/admin/dashboard'
      },
      {
        path: 'dashboard',
        name: 'admin.dashboard',
        component: AdminDashboard
      },
      {
        path: 'first-page',
        name: 'admin.first-page',
        component: AdminFirstPage
      },
      {
        path: 'penghantaran',
        name: 'admin.penghantaran',
        component: AdminPenghantaran
      },
      {
        path: 'dalam-proses',
        name: 'admin.dalam-proses',
        component: AdminDalamProses
      },
      {
        path: 'selesai',
        name: 'admin.selesai',
        component: AdminSelesai
      },
      {
        path: 'senarai-pengguna',
        name: 'admin.senarai-pengguna',
        component: AdminSenaraiPengguna
      },
      {
        path: 'senarai-vendor',
        name: 'admin.senarai-vendor',
        component: AdminSenaraiVendor
      },
      {
        path: 'statistik',
        name: 'admin.statistik',
        component: AdminStatistik
      },
      {
        path: 'assign-vendor/:id',
        name: 'admin.assign-vendor',
        component: AdminAssignVendor
      }
    ]
  },

  // Vendor routes
  {
    path: '/vendor',
    component: DashboardLayout,
    meta: { requiresAuth: true, role: 'vendor' },
    children: [
      {
        path: '',
        redirect: '/vendor/dashboard'
      },
      {
        path: 'dashboard',
        name: 'vendor.dashboard',
        component: VendorDashboard
      },
      {
        path: 'first-page',
        name: 'vendor.first-page',
        component: VendorFirstPage
      },
      {
        path: 'penghantaran',
        name: 'vendor.penghantaran',
        component: VendorPenghantaran
      },
      {
        path: 'kutipan',
        name: 'vendor.kutipan',
        component: VendorKutipan
      }
    ]
  },

  // Pengguna routes
  {
    path: '/pengguna',
    component: DashboardLayout,
    meta: { requiresAuth: true, role: 'pengguna' },
    children: [
      {
        path: '',
        redirect: '/pengguna/dashboard'
      },
      {
        path: 'dashboard',
        name: 'pengguna.dashboard',
        component: PenggunaDashboard
      },
      {
        path: 'penghantaran',
        name: 'pengguna.penghantaran',
        component: PenggunaPenghantaran
      },
      {
        path: 'recycle-info',
        name: 'pengguna.recycle-info',
        component: PenggunaRecycleInfo
      },
      {
        path: 'home',
        name: 'pengguna.home',
        component: PenggunaHome
      },
      {
        path: 'program',
        name: 'pengguna.program',
        component: PenggunaProgram
      },
      {
        path: 'lokasi',
        name: 'pengguna.lokasi',
        component: PenggunaLokasi
      },
      {
        path: 'first-page',
        name: 'pengguna.first-page',
        component: PenggunaFirstPage
      }
    ]
  },

  // Sekolah routes
  {
    path: '/sekolah',
    component: DashboardLayout,
    meta: { requiresAuth: true, role: 'sekolah/agensi' },
    children: [
      {
        path: '',
        redirect: '/sekolah/dashboard'
      },
      {
        path: 'dashboard',
        name: 'sekolah.dashboard',
        component: SekolahDashboard
      },
      {
        path: 'penghantaran',
        name: 'sekolah.penghantaran',
        component: SekolahPenghantaran
      },
      {
        path: 'first-page',
        name: 'sekolah.first-page',
        component: SekolahFirstPage
      }
    ]
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

// Navigation guards
router.beforeEach((to, from, next) => {
  const authStore = useAuthStore()
  
  if (to.meta.requiresAuth && !authStore.isAuthenticated) {
    next('/')
  } else if (to.meta.requiresGuest && authStore.isAuthenticated) {
    // Redirect to appropriate dashboard based on role
    const role = authStore.user?.peranan?.toLowerCase()
    if (role === 'admin') {
      next('/admin/dashboard')
    } else if (role === 'vendor') {
      next('/vendor/dashboard')
    } else if (role === 'pengguna') {
      next('/pengguna/dashboard')
    } else if (role === 'sekolah/agensi') {
      next('/sekolah/dashboard')
    } else {
      next('/')
    }
  } else if (to.meta.role && authStore.user?.peranan?.toLowerCase() !== to.meta.role) {
    // Redirect to appropriate dashboard if user doesn't have required role
    const role = authStore.user?.peranan?.toLowerCase()
    if (role === 'admin') {
      next('/admin/dashboard')
    } else if (role === 'vendor') {
      next('/vendor/dashboard')
    } else if (role === 'pengguna') {
      next('/pengguna/dashboard')
    } else if (role === 'sekolah/agensi') {
      next('/sekolah/dashboard')
    } else {
      next('/')
    }
  } else {
    next()
  }
})

export default router 