<template>
  <div class="wrapper">
    <!-- Sidebar -->
    <nav class="sidebar bg-dark text-white" :class="{ 'sidebar-collapsed': sidebarCollapsed }">
      <div class="sidebar-header p-3">
        <div class="d-flex align-items-center">
          <img src="/logo_ePKAH.png" alt="ePKAH Logo" class="logo me-2" style="width: 40px; height: 40px;">
          <h5 class="mb-0" v-if="!sidebarCollapsed">ePKAH</h5>
        </div>
        <button 
          @click="toggleSidebar" 
          class="btn btn-link text-white p-0 mt-2"
          v-if="!sidebarCollapsed"
        >
          <i class="fas fa-bars"></i>
        </button>
      </div>

      <div class="sidebar-content">
        <div class="user-info p-3 border-bottom">
          <div class="d-flex align-items-center">
            <div class="avatar bg-primary rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 40px; height: 40px;">
              <i class="fas fa-user text-white"></i>
            </div>
            <div v-if="!sidebarCollapsed">
              <div class="fw-bold">{{ user?.nama }}</div>
              <small class="text-muted">{{ user?.peranan }}</small>
            </div>
          </div>
        </div>

        <ul class="nav flex-column">
          <!-- Admin Navigation -->
          <template v-if="userRole === 'admin'">
            <li class="nav-item">
              <router-link to="/admin/dashboard" class="nav-link text-white">
                <i class="fas fa-tachometer-alt me-2"></i>
                <span v-if="!sidebarCollapsed">Dashboard</span>
              </router-link>
            </li>
            <li class="nav-item">
              <router-link to="/admin/penghantaran" class="nav-link text-white">
                <i class="fas fa-truck me-2"></i>
                <span v-if="!sidebarCollapsed">Penghantaran</span>
              </router-link>
            </li>
            <li class="nav-item">
              <router-link to="/admin/dalam-proses" class="nav-link text-white">
                <i class="fas fa-clock me-2"></i>
                <span v-if="!sidebarCollapsed">Dalam Proses</span>
              </router-link>
            </li>
            <li class="nav-item">
              <router-link to="/admin/selesai" class="nav-link text-white">
                <i class="fas fa-check-circle me-2"></i>
                <span v-if="!sidebarCollapsed">Selesai</span>
              </router-link>
            </li>
            <li class="nav-item">
              <router-link to="/admin/senarai-pengguna" class="nav-link text-white">
                <i class="fas fa-users me-2"></i>
                <span v-if="!sidebarCollapsed">Senarai Pengguna</span>
              </router-link>
            </li>
            <li class="nav-item">
              <router-link to="/admin/senarai-vendor" class="nav-link text-white">
                <i class="fas fa-building me-2"></i>
                <span v-if="!sidebarCollapsed">Senarai Vendor</span>
              </router-link>
            </li>
            <li class="nav-item">
              <router-link to="/admin/statistik" class="nav-link text-white">
                <i class="fas fa-chart-bar me-2"></i>
                <span v-if="!sidebarCollapsed">Statistik</span>
              </router-link>
            </li>
          </template>

          <!-- Vendor Navigation -->
          <template v-if="userRole === 'vendor'">
            <li class="nav-item">
              <router-link to="/vendor/dashboard" class="nav-link text-white">
                <i class="fas fa-tachometer-alt me-2"></i>
                <span v-if="!sidebarCollapsed">Dashboard</span>
              </router-link>
            </li>
            <li class="nav-item">
              <router-link to="/vendor/penghantaran" class="nav-link text-white">
                <i class="fas fa-truck me-2"></i>
                <span v-if="!sidebarCollapsed">Penghantaran</span>
              </router-link>
            </li>
            <li class="nav-item">
              <router-link to="/vendor/kutipan" class="nav-link text-white">
                <i class="fas fa-recycle me-2"></i>
                <span v-if="!sidebarCollapsed">Kutipan</span>
              </router-link>
            </li>
          </template>

          <!-- Pengguna Navigation -->
          <template v-if="userRole === 'pengguna'">
            <li class="nav-item">
              <router-link to="/pengguna/dashboard" class="nav-link text-white">
                <i class="fas fa-tachometer-alt me-2"></i>
                <span v-if="!sidebarCollapsed">Dashboard</span>
              </router-link>
            </li>
            <li class="nav-item">
              <router-link to="/pengguna/penghantaran" class="nav-link text-white">
                <i class="fas fa-truck me-2"></i>
                <span v-if="!sidebarCollapsed">Penghantaran</span>
              </router-link>
            </li>
            <li class="nav-item">
              <router-link to="/pengguna/recycle-info" class="nav-link text-white">
                <i class="fas fa-info-circle me-2"></i>
                <span v-if="!sidebarCollapsed">Info Kitar Semula</span>
              </router-link>
            </li>
            <li class="nav-item">
              <router-link to="/pengguna/program" class="nav-link text-white">
                <i class="fas fa-calendar me-2"></i>
                <span v-if="!sidebarCollapsed">Program</span>
              </router-link>
            </li>
            <li class="nav-item">
              <router-link to="/pengguna/lokasi" class="nav-link text-white">
                <i class="fas fa-map-marker-alt me-2"></i>
                <span v-if="!sidebarCollapsed">Lokasi</span>
              </router-link>
            </li>
          </template>

          <!-- Sekolah Navigation -->
          <template v-if="userRole === 'sekolah/agensi'">
            <li class="nav-item">
              <router-link to="/sekolah/dashboard" class="nav-link text-white">
                <i class="fas fa-tachometer-alt me-2"></i>
                <span v-if="!sidebarCollapsed">Dashboard</span>
              </router-link>
            </li>
            <li class="nav-item">
              <router-link to="/sekolah/penghantaran" class="nav-link text-white">
                <i class="fas fa-truck me-2"></i>
                <span v-if="!sidebarCollapsed">Penghantaran</span>
              </router-link>
            </li>
          </template>
        </ul>
      </div>

      <div class="sidebar-footer p-3">
        <button @click="handleLogout" class="btn btn-outline-light btn-sm w-100">
          <i class="fas fa-sign-out-alt me-2"></i>
          <span v-if="!sidebarCollapsed">Logout</span>
        </button>
      </div>
    </nav>

    <!-- Main Content -->
    <div class="main-content" :class="{ 'main-content-expanded': sidebarCollapsed }">
      <!-- Top Navigation -->
      <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container-fluid">
          <button 
            @click="toggleSidebar" 
            class="btn btn-link text-dark"
          >
            <i class="fas fa-bars"></i>
          </button>
          
          <div class="navbar-nav ms-auto">
            <div class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                <i class="fas fa-user-circle me-1"></i>
                {{ user?.nama }}
              </a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#" @click="handleLogout">Logout</a></li>
              </ul>
            </div>
          </div>
        </div>
      </nav>

      <!-- Page Content -->
      <div class="content-wrapper p-4">
        <router-view />
      </div>
    </div>
  </div>
</template>

<script>
import { ref, computed, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/auth'

export default {
  name: 'DashboardLayout',
  setup() {
    const router = useRouter()
    const authStore = useAuthStore()
    const sidebarCollapsed = ref(false)

    const user = computed(() => authStore.user)
    const userRole = computed(() => authStore.userRole)

    const toggleSidebar = () => {
      sidebarCollapsed.value = !sidebarCollapsed.value
    }

    const handleLogout = async () => {
      await authStore.logout()
      router.push('/')
    }

    onMounted(async () => {
      await authStore.checkAuth()
    })

    return {
      user,
      userRole,
      sidebarCollapsed,
      toggleSidebar,
      handleLogout
    }
  }
}
</script>

<style scoped>
.wrapper {
  display: flex;
  min-height: 100vh;
}

.sidebar {
  width: 280px;
  min-height: 100vh;
  transition: width 0.3s ease;
  display: flex;
  flex-direction: column;
}

.sidebar-collapsed {
  width: 70px;
}

.sidebar-header {
  border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

.sidebar-content {
  flex: 1;
  overflow-y: auto;
}

.sidebar-footer {
  border-top: 1px solid rgba(255, 255, 255, 0.1);
}

.nav-link {
  padding: 0.75rem 1rem;
  transition: background-color 0.2s ease;
}

.nav-link:hover {
  background-color: rgba(255, 255, 255, 0.1);
}

.nav-link.router-link-active {
  background-color: rgba(255, 255, 255, 0.2);
  border-left: 3px solid #007bff;
}

.main-content {
  flex: 1;
  display: flex;
  flex-direction: column;
  transition: margin-left 0.3s ease;
}

.main-content-expanded {
  margin-left: 0;
}

.content-wrapper {
  flex: 1;
  background-color: #f8f9fa;
}

.navbar {
  border-bottom: 1px solid #dee2e6;
}

.logo {
  object-fit: cover;
}

@media (max-width: 768px) {
  .sidebar {
    position: fixed;
    z-index: 1000;
    transform: translateX(-100%);
  }
  
  .sidebar.show {
    transform: translateX(0);
  }
  
  .main-content {
    margin-left: 0;
  }
}
</style> 