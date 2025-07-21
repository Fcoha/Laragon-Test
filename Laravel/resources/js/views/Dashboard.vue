<template>
  <div :class="theme">
    <h1>Welcome to your dashboard!</h1>
    <label>Select your theme:</label>
    <select :value="theme" v-model="theme" @change="themeUpdater">
      <option value="light">Light</option>
      <option value="dark">Dark</option>
    </select>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'Dashboard',
  data() {
    return {
      theme: 'light',
    };
  },
   async created() {
    try {
      const res = await axios.get('/api/user-theme');
      console.log(res.data);
      this.theme = res.data.theme;
      document.body.className = this.theme;
    } catch (err) {
      console.error('Failed to load theme', err);
    }
  },
  methods: {
    async themeUpdater() {
      try {
        const token = localStorage.getItem('auth_token');
        await axios.post('/api/user-theme', { theme: this.theme }, {
            headers: {
                Authorization: `Bearer ${token}`
            }
        });
        
        document.body.className = this.theme;
      } catch (err) {
        console.error('Failed to update theme', err);
      }
    }
    
  }
}
</script>

<style scoped>
.light {
  background: #fff;
  color: #000;
}
.dark {
  background: #121212;
  color: #fff;
}
</style>