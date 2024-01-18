<script>
    import axios from 'axios'

    export default {
        data() {
            return {
                email: '',
                password: '',
                message: '',
                error: '',
                token: ''
            }
        },

        methods: {
            async loginUser() {
                const formData = new FormData()
                formData.append('email', this.email)
                formData.append('password', this.password)
                await axios.post("http://localhost:8000/api/auth/login", formData).then(res => {
                    this.message = res.data.message 
                    this.token = res.data.token
                    localStorage.setItem('token', this.token)
                    this.$router.push('/')
                }).catch(err => {
                    this.error = err.response.data.error
                })

            }
        }
    }


    
</script>

<template>
    
    <form class="container w-50" @submit.prevent="loginUser">
        <div class="bg-light shadow p-4">
            <h1 class="alert alert-primary">Welcome Back</h1>

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
            <button class="btn btn-outline-primary" type="submit">LogIn</button>
            <p>don't have an account register <RouterLink to="register">Here</RouterLink></p>
        </div>
        
    </div>
    
    <br>
    <div>
        <span class="alert alert-success" v-if="message">{{ message }}</span>
        <span class="alert alert-danger" v-if="error">{{ error }}</span>
    </div>
    </form>
</template>