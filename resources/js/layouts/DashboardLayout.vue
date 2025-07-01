<template>
  <div class="dashboard-layout">
    <header class="dashboard-header">
      <h1>ePKAH Dashboard</h1>
      <nav>
        <router-link to="/logout">Logout</router-link>
      </nav>
    </header>
    
    <div class="dashboard-content">
      <aside class="sidebar">
        <nav>
          <router-link to="/dashboard">Dashboard</router-link>
          <router-link to="/penghantaran">Penghantaran</router-link>
          <router-link to="/profile">Profile</router-link>
        </nav>
      </aside>
      
      <main class="main-content">
        <router-view />
      </main>
    </div>
  </div>
</template>

<script>
export default {
  name: 'DashboardLayout'
}
</script>

<style scoped>
.dashboard-layout {
  min-height: 100vh;
  display: flex;
  flex-direction: column;
}

.dashboard-header {
  background-color: #333;
  color: white;
  padding: 1rem;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.dashboard-content {
  display: flex;
  flex: 1;
}

.sidebar {
  width: 250px;
  background-color: #f8f9fa;
  padding: 1rem;
}

.sidebar nav {
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
}

.sidebar a {
  padding: 0.5rem;
  text-decoration: none;
  color: #333;
  border-radius: 4px;
}

.sidebar a:hover {
  background-color: #e9ecef;
}

.main-content {
  flex: 1;
  padding: 2rem;
}
</style> 