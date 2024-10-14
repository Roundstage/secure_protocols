<script setup>
import {ref} from 'vue'
import Button from "primevue/button";
import Dialog from "primevue/dialog";
import Toast from "primevue/toast";
import {useToast} from "primevue/usetoast";

const form = ref({
    level: '',
    name: '',
    description: ''
})
const toast = useToast();
const handleSubmit = () => {
    fetch('/api/role', {
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
        toast.add({severity: 'success', summary: 'Success', detail: 'Role created successfully!'});
    })
}
const emit = defineEmits(['update'], 1);
const visible = ref(false);
</script>

<template>
    <Button label="New" icon="pi pi-plus" severity="success" class="mr-2" @click="visible = true"/>
    <Dialog v-model:visible="visible" modal header="Edit Profile" :style="{ width: '25rem' }">
        <form @submit.prevent="handleSubmit" class="p-fluid mx-auto" style="max-width: 400px; margin-top: 50px;">
            <div class="form-group">
                <label for="level">Level</label>
                <select id="level" class="form-control" v-model="form.level">
                    <option value="Manager">Manager</option>
                    <option value="Staff">Staff</option>
                </select>
            </div>
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" class="form-control" v-model="form.name"/>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" class="form-control" v-model="form.description"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Create Role</button>
        </form>
    </Dialog>
    <Toast></Toast>
</template>

<style scoped>

</style>
