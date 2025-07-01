import { defineStore } from 'pinia'
import { ref, computed } from 'vue'
import axios from 'axios'

export const useAuthStore = defineStore('auth', () => {
  const user = ref(null)
  const token = ref(localStorage.getItem('token') || null)
  const loading = ref(false)

  // Computed properties
  const isAuthenticated = computed(() => !!token.value)
  const userRole = computed(() => user.value?.peranan?.toLowerCase())

  // Initialize axios defaults
  if (token.value) {
    axios.defaults.headers.common['Authorization'] = `Bearer ${token.value}`
  }

  // Actions
  const login = async (credentials) => {
    loading.value = true
    try {
      const response = await axios.post('/api/login', credentials)
      const { user: userData, token: authToken } = response.data
      
      user.value = userData
      token.value = authToken
      localStorage.setItem('token', authToken)
      axios.defaults.headers.common['Authorization'] = `Bearer ${authToken}`
      
      return { success: true, user: userData }
    } catch (error) {
      return { 
        success: false, 
        message: error.response?.data?.message || 'Login failed' 
      }
    } finally {
      loading.value = false
    }
  }

  const register = async (userData) => {
    loading.value = true
    try {
      const response = await axios.post('/api/register', userData)
      return { success: true, message: response.data.message }
    } catch (error) {
      return { 
        success: false, 
        message: error.response?.data?.message || 'Registration failed' 
      }
    } finally {
      loading.value = false
    }
  }

  const logout = async () => {
    try {
      await axios.post('/api/logout')
    } catch (error) {
      console.error('Logout error:', error)
    } finally {
      user.value = null
      token.value = null
      localStorage.removeItem('token')
      delete axios.defaults.headers.common['Authorization']
    }
  }

  const forgotPassword = async (email) => {
    loading.value = true
    try {
      const response = await axios.post('/api/forgot-password', { email })
      return { success: true, message: response.data.message }
    } catch (error) {
      return { 
        success: false, 
        message: error.response?.data?.message || 'Password reset failed' 
      }
    } finally {
      loading.value = false
    }
  }

  const fetchUser = async () => {
    if (!token.value) return false
    
    try {
      const response = await axios.get('/api/user')
      user.value = response.data
      return true
    } catch (error) {
      console.error('Fetch user error:', error)
      logout()
      return false
    }
  }

  const checkAuth = async () => {
    if (token.value && !user.value) {
      return await fetchUser()
    }
    return !!token.value
  }

  return {
    // State
    user,
    token,
    loading,
    
    // Computed
    isAuthenticated,
    userRole,
    
    // Actions
    login,
    register,
    logout,
    forgotPassword,
    fetchUser,
    checkAuth
  }
}) 