<script setup>
import {ref, onMounted, watch, onUpdated} from 'vue';
import Textarea from "primevue/textarea";
import Dialog from "primevue/dialog";
import Button from "primevue/button";

const handleSubmit = () => {
    fetch('/api/users/' + form.value.id, {
        method: 'PUT',
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

const form = ref({
    id: '',
    name: '',
    email: '',
    role: ''
})
const props = defineProps({user: {id: String, name: String, email: String, role: String}});
const emit = defineEmits(['update']);
const visible = ref(false);

onUpdated(() => {
    form.value.id = props.user.id;
    form.value.name = props.user.name;
    form.value.email = props.user.email;
    form.value.role = props.user.role;
})
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
                <input type="text" id="role" class="form-control" v-model="form.role"/>
            </div>
            <button type="submit" class="btn btn-primary">Update User</button>
        </form>
    </Dialog>
</template>

<style scoped>
/* Add your styles here if necessary */
</style>
