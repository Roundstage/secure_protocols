<script setup>
import {ref, onMounted, watch, onUpdated} from 'vue';
import Textarea from "primevue/textarea";
import Dialog from "primevue/dialog";
import Button from "primevue/button";

const handleSubmit = () => {
    Promise.all([
        fetch(`/api/user/${form.value.id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${localStorage.getItem('access_token')}`,
                'Cache-Control': 'no-cache'
            },
            body: JSON.stringify(form.value)
        }),
        fetch(`/api/user/${form.value.id}/role/${form.value.role.id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${localStorage.getItem('access_token')}`,
                'Cache-Control': 'no-cache'
            }
        })
    ]).then(async ([userResponse, roleResponse]) => {
        const userData = await userResponse.json();
        const roleData = await roleResponse.json();
        console.log(roleData);
        const updatedUser = {
            ...userData.data,
            role: roleData.data.role
        };
        emit('update', updatedUser);
    });
}

const Roles = ref([]);
const form = ref({
    id: '',
    name: '',
    email: '',
    role: ''
});
const props = defineProps({user: {id: String, name: String, email: String, role: Object}});
const emit = defineEmits(['update']);
const visible = ref(false);

onUpdated(() => {
    Object.assign(form.value, props.user);

    fetch('/api/role', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${localStorage.getItem('access_token')}`,
            'Cache-Control': 'no-cache'
        }
    }).then(response => {
        if (!response.ok) {
            $inertia.visit('/login');
            return;
        }
        return response.json();
    }).then(data => {
        Roles.value = data.data;
    });
});
</script>

<template>
    <Button @click="visible = true" outlined rounded icon="pi pi-pencil"></Button>
    <Dialog v-model:visible="visible" modal header="Edit User" :style="{ width: '25rem' }">
        <form @submit.prevent="handleSubmit" class="p-fluid mx-auto" style="max-width: 400px; margin-top: 50px;">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" class="form-control" v-model="form.name"/>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" class="form-control" v-model="form.email"/>
            </div>
            <div class="form-group">
                <label for="role">Role</label>
                <select id="role" class="form-control" v-model="form.role">
                    <option v-for="role in Roles" :key="role.id" :value="role">{{ role.name }}</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update User</button>
        </form>
    </Dialog>
</template>

<style scoped>
/* Add your styles here if necessary */
</style>
