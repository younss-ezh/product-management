<script>
    import axios from 'axios'

    export default {
        data() {
            return {
                name: '',
                email: '',
                password: '',
                message: '',
                error: '',
                token: ''
            }
        },

        methods: {
            async registerUser() {
                await axios.post("http://localhost:8000/api/auth/register", {
                    name: this.name,
                    email: this.email,
                    password: this.password
                }).then(res => {
                    this.message = res.data.message 
                    this.token = res.data.token
                    localStorage.setItem('token', this.token)
                    this.$router.push('/')
                }).catch(err => {
                    this.error = err.response.data.message
                })

            },

        }
    }


    
</script>

<template>
    
    <form class="container w-50" @submit.prevent="registerUser">
        <div class="bg-light shadow p-4">
            <h1 class="alert alert-success">User Registration</h1>

        <div class="form-floating mb-3">
            <input type="text" class="form-control" id="floatingInput" placeholder="name" v-model="name">
            <label for="floatingInput">username</label>
        </div>
        <div class="form-floating mb-3">
            <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com" v-model="email">
            <label for="floatingInput">Email address</label>
        </div>
        <div class="form-floating">
            <input type="password" class="form-control" id="floatingPassword" placeholder="Password" v-model="password">
            <label for="floatingPassword">Password</label>
        </div>
        <br>
        <div>
            <button class="btn btn-outline-success" type="submit">Register</button>
            <p>have an account Login <RouterLink to="login">Here</RouterLink></p>
        </div>
        
    </div>
    
    <br>
    <div>
        <span class="alert alert-success" v-if="message">{{ message }}</span>
        <span class="alert alert-danger" v-if="error">{{ error }}</span>
    </div>
    </form>
</template>