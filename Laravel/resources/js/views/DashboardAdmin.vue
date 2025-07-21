<template>
  <div :class="theme">
    <h1>Admin dashboard!</h1>
    <label>Select your theme:</label>
    <select :value="theme" v-model="theme" @change="themeUpdater">
      <option value="light">Light</option>
      <option value="dark">Dark</option>
    </select>
    <form @submit.prevent="createUser">
      <input v-model="newUser.name" placeholder="name" required />
      <input v-model="newUser.email" type="email" placeholder="email" required />
      <input v-model="newUser.password" type="password" placeholder="password" required />
      <button type="submit">Add User</button>
    </form>
     <table>
        <thead>
          <tr>
            <th>Name</th><th>Email</th><th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="user in users" :key="user.id">
            <td>
              <input v-model="user.name" />
            </td>
            <td>
              <input v-model="user.email" />
            </td>
            <td>
              <button @click="updateUser(user)">Update</button>
              <button @click="deleteUser(user.id)">Delete</button>
            </td>
          </tr>
        </tbody>
    </table>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'DashboardAdmin',
  data() {
    return {
      theme: 'light',
      users: [],
      newUser: {
        name: '',
        email: '',
        password: '',
      },
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
    await this.fetchUsers();
  },
  methods: {
    async fetchUsers() {
      try {
        const res = await axios.get('/api/users');
        this.users = res.data;
      } catch (e) {
        console.error('Could not fetch users', e);
      }
    },
    async createUser() {
      try {
        await axios.post('/api/users', this.newUser);
        this.newUser.name = '';
        this.newUser.email = '';
        this.newUser.password = '';
        await this.fetchUsers();
      } catch (e) {
        console.error('Could not create user', e);
      }
    },
    async updateUser(user) {
      try {
        await axios.put(`/api/users/${user.id}`, {
          name: user.name,
          email: user.email,
        });
        await this.fetchUsers();
      } catch (e) {
        console.error('Could not update user', e);
      }
    },
    async deleteUser(id) {
      try {
        await axios.delete(`/api/users/${id}`);
        await this.fetchUsers();
      } catch (e) {
        console.error('Could not delete user', e);
      }
    },
    async themeUpdater() {
      try {
        await axios.post('/api/user-theme', { theme: this.theme });
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
table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 20px;
}
th, td {
  padding: 8px;
  border: 1px solid #ccc;
}
input {
  width: 100%;
  box-sizing: border-box;
}
button {
  margin-right: 5px;
}
</style>