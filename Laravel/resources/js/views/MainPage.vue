<template>
    <div>
        <nav class="navbar">
            <ul>
                <li><router-link to= "/">Home</router-link></li>
                <li><router-link to= "Login">Login</router-link></li>
            </ul>
        </nav>

        <div>
            <h1>Welcome!</h1>
            <p>Enjoy your stay on my website!</p>
        </div>
    </div>
</template>

<script>
export default {
  name: 'MainPage'
}
</script>
<style scoped>
.navbar {
  background-color: #f7e4f8;
  padding: 1rem;
}
ul {
  list-style: none;
  display: flex;
  gap: 1rem;
}
li {
  display: inline;
}
router-link {
  text-decoration: none;
  color: #333;
}
</style>