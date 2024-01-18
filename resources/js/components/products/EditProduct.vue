<script>
    import axios from 'axios'

    export default {
        data() {
            return {
                id: "" ,
                product: {
                    image: '',
                    name: '',
                    size: '',
                    type: '',
                    description: '',
                    price: '',
                    quantity: '',
                },
                message: '',
                error: '',
                errors: {}
            }

        },

        created() {
            this.id = this.$route.params.id
            this.getProduct()
            console.log(this.product)
        },

        methods: {
            cancel() {
                this.$router.push('/')
            },

            handelFileChange(e) {
                this.product.image = e.target.files[0]
            },

            async getProduct() {
                await axios.get(`http://localhost:8000/api/product/${this.id}`).then(res => {
                    this.product = res.data.product;
                }).catch(err => {
                    console.log(err);
                });
            },

            async editProduct() {
                const formData = new FormData()
                formData.append('image', this.product.image)
                formData.append('name', this.product.name)
                formData.append('size', this.product.size)
                formData.append('type', this.product.type)
                formData.append('description', this.product.description)
                formData.append('price', this.product.price)
                formData.append('quantity', this.product.quantity)


                await axios.post(`http://localhost:8000/api/edit/${this.id}`, formData).then(res => {
                                this.message = res.data.message
                                this.$router.push('/')
                            })
                            .catch(err => {
                                // this.error = err.response.data.errors.name[0]    
                                this.errors = {
                                    image: err.response.data.errors.image,
                                    name: err.response.data.errors.name,
                                    size: err.response.data.errors.size,
                                    type: err.response.data.errors.type,
                                    description: err.response.data.errors.description,
                                    price: err.response.data.errors.price,
                                    quantity: err.response.data.errors.quantity,
                                }
                            })

            },
        }
    }
</script>

<template>
    <div class="col-md-12">
       <h1 class="alert alert-dark text-center">Update Product</h1>
    </div>
    <br>
    <form class="row g-3 bg-light shadow p-2 mb-4" @submit.prevent="editProduct">
        <div class="col-md-4">
            <label for="name" class="form-label">Name</label>
            <input type="name" class="form-control" id="name" v-model="product.name">
            <span class="text-danger">{{ errors.name }}</span>
        </div>
        <div class="col-md-4">
            <label for="size" class="form-label">Size <i style="font-size: small; color: grey;">(optional)</i></label>
            <input type="text" class="form-control" id="size" v-model="product.size">
            <span class="text-danger">{{ errors.size }}</span>
        </div>
        <div class="col-md-4">
            <label for="type" class="form-label">Type</label>
            <select id="type" class="form-control" v-model="product.type">
                <option disabled selected>Choose Type</option>
                <option value="Clothes">Clothes</option>
                <option value="Electronics">Electronics</option>
                <option value="Home Furniture">Home Furniture</option>
                <option value="Books">Books</option>
                <option value="Toys">Toys</option>
                <option value="Sports">Sports</option>
            </select>
            <span class="text-danger">{{ errors.type }}</span>
        </div>
        <div class="col-12">
            <label for="description" class="form-label">Description</label>
            <textarea rows="10" class="form-control" id="description" placeholder="Some Description for the product" v-model="product.description"></textarea>
            <span class="text-danger">{{ errors.description }}</span>
        </div>
        <div class="col-md-4">
            <label for="price" class="form-label">Price</label>
            <input type="number" class="form-control" id="price" v-model="product.price">
            <span class="text-danger">{{ errors.price }}</span>
        </div>
        
        <div class="col-md-4">
            <label for="quantity" class="form-label">Quantity</label>
            <input type="number" class="form-control" id="quantity" v-model="product.quantity">
            <span class="text-danger">{{ errors.quantity }}</span>
        </div>

        <div class="col-md-4">
            <label for="image" class="form-label">Image</label>
            <input type="file" class="form-control" id="image" @change="handelFileChange">
            <span class="text-danger">{{ errors.image }}</span>
        </div>

        <div class="col-12 d-grid gap-2 d-md-flex justify-content-md-end">
            <button type="submit" class="btn btn-primary">Update</button>
            <button type="submit" class="btn btn-danger" @:click="cancel">Cancel</button>
        </div>

    </form>

    <div class="">
        <span class="alert alert-success" v-if="message">{{ message }}</span>
        <span class="alert alert-danger" v-if="error">{{ error }}</span>
    </div>
</template>