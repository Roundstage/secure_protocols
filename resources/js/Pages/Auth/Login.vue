<script setup>
import "bootstrap/dist/css/bootstrap.min.css";
import "bootstrap";
import { ref } from 'vue';

const email = defineModel('email')
const password = defineModel('password')
const error = ref('')
function auth() {
    fetch('/api/auth', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body:JSON.stringify({
            "email":email.value,
            "password":password.value
        })
    }).then(response => {
            return response.json();
        }).then(data => {
            if(data.error){
                console.error('Erro ao carregar os dados', data.error);
                error.value = data.error;
                return;
            }
            error.value = '';
            localStorage.setItem('access_token', data.access_token);
            localStorage.setItem('token_type', data.token_type);

            window.location.href = '/';
        })
}
</script>

<template>
    <main class="form-signin d-flex justify-content-center align-items-center vh-100">
        <form @submit.prevent="auth">
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Email address</label>
                <input type="email" class="form-control" id="exampleInputEmail1" v-model="email"
                       aria-describedby="emailHelp">
                <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Password</label>
                <input type="password" class="form-control" id="exampleInputPassword1" v-model="password">
            </div>
            <div class="text-danger mb-3" v-if="error">{{ error }}</div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </main>

</template>

<style scoped>
.form-signin{
    width: 100%;
    max-width: 330px;
    height: 100%;
    padding: 15px;
    margin: auto;
}
</style>
