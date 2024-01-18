import { createApp } from 'vue'
import App from './App.vue'
import { createRouter, createWebHistory } from 'vue-router'
import "bootstrap/dist/css/bootstrap.css";
import "bootstrap-vue/dist/bootstrap-vue.css";
import "bootstrap/dist/js/bootstrap.min.js"

import Register from './components/users/Register.vue'
import Login from './components/users/Login.vue'

import ProductList from './components/products/ProductList.vue'
import AddProduct from './components/products/AddProduct.vue'
import EditProduct from './components/products/EditProduct.vue'

const router = createRouter({
    history: createWebHistory(),
    routes: [
        {path: '/', component: ProductList},
        {path: '/login', component: Login},
        {path: '/register', component: Register},
        {path: '/add', component: AddProduct, meta: {requiresAuth: true}},
        {path: '/edit/:id', component: EditProduct, meta: {requiresAuth: true}},
    ]
})

router.beforeEach((to, from, next) => {
    const token = localStorage.getItem("token");

    // If the route requires authentication and there's no token, redirect to login
    if (to.meta.requiresAuth && !token) {
        next({ path: "/login" });
    } else {
        // Continue with the navigation
        next();
    }
});

const app = createApp(App)
app.use(router)
app.mount('#app')