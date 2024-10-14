<script setup>
import {ref} from 'vue'
import Button from "primevue/button";
import Dialog from "primevue/dialog";
import Toast from 'primevue/toast';
import {useToast} from 'primevue/usetoast';
import UserService from "@/Pages/Services/UserService.ts";

const form = ref({
    name: '',
    email: '',
    password: ''
});

const toast = useToast();

const handleSubmit = async () => {
    try {
        const data = await UserService.createUser(form.value);
        emit('update', data.data);
        toast.add({ severity: 'success', summary: 'Success', detail: 'User created successfully!', life: 3000 });
    } catch (error) {
        console.error('Error creating user:', error);
        toast.add({ severity: 'error', summary: 'Error', detail: 'Failed to create user.', life: 3000 });
    }
}

const emit = defineEmits(['update']);
const visible = ref(false);
</script>

<template>
    <Button label="New User" icon="pi pi-plus" severity="success" class="mr-2" @click="visible = true"/>
    <Dialog v-model:visible="visible" modal header="Create User" :style="{ width: '25rem' }">
        <form @submit.prevent="handleSubmit" class="p-fluid mx-auto" style="max-width: 400px; margin-top: 50px;">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" class="form-control" v-model="form.name"/>
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
    <Toast/>
</template>

<style scoped>

</style>
