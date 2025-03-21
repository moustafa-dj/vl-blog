<template>
    <div class="nav">
        <div class="container">
            <div class="nav-content">
                <ul>
                    <li><router-link to="/login">Home</router-link></li>
                    <li><router-link to="/login">Posts</router-link></li>
                    <li><router-link to="/login">Categories</router-link></li>
                    <li><router-link to="/login">My-Posts</router-link></li>
                </ul>
                
                <router-link to="/login">Login</router-link>
            </div>
        </div>
    </div>
</template>
<script>

</script>
<style>
.container{
    max-width: 1200px;
}
.nav {
  position: fixed; /* or absolute if needed */
  top: 0;
  left: 0;
  width: 100%;
  z-index: 1000;
  border-bottom: 1px solid #e5e7eb; /* Light gray border */
}

.nav-content{
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 15px;
}
.nav-content ul li {
    display: inline;
    margin: 10px;
}
</style>