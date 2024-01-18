<script>
import axios from 'axios';

    export default {
        data() {
            return {
                token: localStorage.getItem('token')
            }
        },

        methods: {
            async logout() {
                const token = localStorage.getItem('token')
                await axios.get('http://localhost:8000/api/auth/logout', {
                    headers: {
                        Authorization: `Bearer ${token}`,
                    }
                }).then(res => {
                    this.message = res.data.message
                    localStorage.removeItem('token')
                    this.$router.push('/login');
                }).catch(err => {
                    console.log(err)
                })
            }
        }
    }
</script>

<template>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <router-link class="navbar-brand" to="/">Product Management</router-link>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <router-link class="nav-link active" aria-current="page" to="/">Home</router-link>
                <div v-if="!token" class="d-flex">
                    <router-link class="nav-link active" aria-current="page" to="login">LogIn</router-link>
                    <router-link class="nav-link active" aria-current="page" to="register">Register</router-link>
                </div>
            </div>
        </div>
        <div v-if="token" class="d-flex justify-content-between">
            <button class="btn btn-danger me-2" @click="logout">logout</button>    
        </div>
        </div>
    </nav>
    <div class="container">
        <RouterView></RouterView>
    </div>
</template>

<style scoped>

</style>