<script>
    import axios from 'axios'
    import { RouterLink } from 'vue-router'

    export default {
    data() {
        return {
            products: [],
            name: '',
            type: '',
            filteredProducts: [],
            message: '',
            token: localStorage.getItem('token')
        };
    },
    created() {
        this.getProducts();
    },

    mounted() {
        this.getProducts()
    },

    computed: {
        filteredProducts() {
            return this.products.filter(product => {
                return ((this.name === '' || product.name.toLowerCase().includes(this.name.toLowerCase())) && (this.type === '' || product.type.toLowerCase().includes(this.type.toLowerCase())));
            });
        }
        
    },
    methods: {
        async getProducts() {
            await axios.get('http://localhost:8000/api/products').then(res => {
                this.products = res.data.products;
            }).catch(err => {
                console.log(err);
            });
        },

        getImageUrl(image) {
            return `http://localhost:8000/products/${image}`;
        },

        getId(id) {
            return `edit/${id}`
        },

        performSarch() { },

        async deleteProduct(id) {
            await axios.delete(`http://localhost:8000/api/delete/${id}`).then(res => {
                this.message = res.data.message
            }).catch(err => {
                console.log(err)
            })
        }
    },
    components: { RouterLink }
}
</script>

<template>
    <div class="mt-4">

    <router-link class="btn btn-dark" to="add">Add New Product</router-link>

    <div class="row justify-content-center mt-2">
        <div class="col-6">
            <input type="text" class="form-control" placeholder="type name of product" @input="performSarch" v-model="name">
        </div>
        <div class="col-6">
            <select class="form-control" v-model="type">
                <option selected value="">Search by Type</option>
                <option value="Clothes">Clothes</option>
                <option value="Electronics">Electronics</option>
                <option value="Home Furniture">Home Furniture</option>
                <option value="Books">Books</option>
                <option value="Toys">Toys</option>
                <option value="Sports">Sports</option>
            </select>
        </div>
    </div>

    <div class="row gap-3 justify-content-center">

        <div class="col-4 p-0 card m-4 shadow" style="width: 20rem; height: auto;" v-for="product in filteredProducts" :key="product.id">
            <img :src="getImageUrl(product.image)" class="card-img-top" style="height: 250px;" alt="products images">
            <div class="card-body">
                <h5 class="card-title">{{ product.name }}</h5>
                <p class="card-text">{{ product.description }}</p>
                <i class="text-success">{{ product.price }} $</i>
                <p class="text-primary">{{ product.quantity }} piece</p>
                <div class="d-grid gap-2 d-md-flex justify-content-md-end" v-if="token">
                    <RouterLink :to="getId(product.id)" class="btn btn-primary">Edit</RouterLink>
                    <button class="btn btn-danger" @click="deleteProduct(product.id)" onclick="return confirm('Are you sure')">Delete</button>
                </div>
            </div>
        </div>
        
        
       
    </div>

    </div>
</template>

<style scoped>

</style>