<template>
  <div id="app">
    <router-view />
  </div>
</template>

<script>
export default {
  name: 'App'
}
</script>

<style>
#app {
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  color: #2c3e50;
}

.wrapper {
  min-height: 100vh;
  display: flex;
}

.main-content {
  flex: 1;
  padding: 20px;
  background-color: #f8f9fa;
}

.alert {
  margin-bottom: 20px;
}
</style> 