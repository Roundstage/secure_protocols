<script setup>
import {ref} from 'vue'
import Button from "primevue/button";
import Dialog from "primevue/dialog";

const form = ref({
    username: '',
    email: '',
    password: ''
})
const handleSubmit = () => {
    fetch('/api/users', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${localStorage.getItem('access_token')}`
        },
        body: JSON.stringify(form.value)
    }).then(response => {
        return response.json();
    }).then(data => {
        emit('update', data.data);
    })
}
const emit = defineEmits(['update'], 1);
const visible = ref(false);
</script>

<template>
    <Button label="New User" icon="pi pi-plus" severity="success" class="mr-2" @click="visible = true"/>
    <Dialog v-model:visible="visible" modal header="Create User" :style="{ width: '25rem' }">
        <form @submit.prevent="handleSubmit" class="p-fluid mx-auto" style="max-width: 400px; margin-top: 50px;">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" class="form-control" v-model="form.username"/>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" class="form-control" v-model="form.email"/>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" class="form-control" v-model="form.password"/>
            </div>
            <button type="submit" class="btn btn-primary">Create User</button>
        </form>
    </Dialog>
</template>

<style scoped>

</style>
