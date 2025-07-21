<template>
    <div class="authform">
        <div class="tabs">
            <button :class="{ active: loginTab }" @click="loginTab = true">Login</button>
            <button :class="{ active: !loginTab }" @click="loginTab = false">Register</button>
        </div>
        <form @submit.prevent="handleSubmit">
            <div v-if="!loginTab">
                <label>Name:</label>
                <input type="text" v-model="form.name" :required="!loginTab" />
            </div>
            <div>
                <label>Email:</label>
                <input type="email" v-model="form.email" required />
            </div>

            <div>
                <label>Password:</label>
                <input type="password" v-model="form.password" required />
            </div>

            <div v-if="!loginTab">
                <label>Confirm Password:</label>
                <input type="password" v-model="form.password_confirmation" :required="loginTab" />
            </div>

            <button type="submit">{{ loginTab ? 'Login' : 'Register' }}</button>
        </form>
         <div v-if="error" class="error">
      {{ error }}
    </div>
    </div>
</template>

<script>
import axios from 'axios';
export default {
  name: 'Login',
  data() {
    return {
      loginTab: true,
      error: null,
      form: {
        email: '',
        name: '',
        password: '',
        password_confirmation: ''
      }
    };
  },
  methods: {
    async handleSubmit() {
        if (this.loginTab) {
        await this.login();
        } else {
        await this.register();
        }
    },
    async login() {
      this.error = null;
      try {
        await axios.get('/sanctum/csrf-cookie');
        const res = await axios.post('/login', {
          email: this.form.email,
          password: this.form.password
        });
        const token = res.data.access_token;
        localStorage.setItem('auth_token', token);
        axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
        
        const response = await axios.get('/api/user');
        const user = response.data;
            if (user.is_admin) {
            this.$router.push('/dashboardadmin');
            } else {
            this.$router.push('/dashboard');
        }
      } catch (err) {
        this.error = 'Invalid login credentials.';
      }
    },

    async register() {
      this.error = null;
      try {
        await axios.post('/register', {
          name: this.form.name,
          email: this.form.email,
          password: this.form.password,
          password_confirmation: this.form.password_confirmation
        });
        this.$router.push('/dashboard');
      } catch (err) {
        this.error = 'Registration failed. Please check your input.';
      }
    }
  }
};
</script>

<style scoped>
.authform {
  max-width: 400px;
  margin: auto;
}
.tabs {
  display: flex;
  justify-content: space-around;
  margin-bottom: 20px;
}
.tabs button.active {
  font-weight: bold;
  text-decoration: underline;
}
.error {
  color: red;
  margin-top: 10px;
}
</style>