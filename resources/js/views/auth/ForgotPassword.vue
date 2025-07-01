<template>
  <div class="forgot-password-container">
    <h2>Forgot Password</h2>
    <form @submit.prevent="handleForgotPassword">
      <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" v-model="form.email" required>
      </div>
      <button type="submit" class="btn btn-primary">Send Reset Link</button>
    </form>
  </div>
</template>

<script>
export default {
  name: 'ForgotPassword',
  data() {
    return {
      form: {
        email: ''
      }
    }
  },
  methods: {
    handleForgotPassword() {
      // TODO: Implement forgot password logic
      console.log('Forgot password form submitted:', this.form)
    }
  }
}
</script>

<style scoped>
.forgot-password-container {
  max-width: 400px;
  margin: 0 auto;
  padding: 20px;
}

.form-group {
  margin-bottom: 15px;
}

.form-group label {
  display: block;
  margin-bottom: 5px;
}

.form-group input {
  width: 100%;
  padding: 8px;
  border: 1px solid #ddd;
  border-radius: 4px;
}

.btn {
  width: 100%;
  padding: 10px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

.btn-primary {
  background-color: #007bff;
  color: white;
}
</style> 