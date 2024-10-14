<script setup>
import {ref} from 'vue'
import Button from "primevue/button";
import Dialog from "primevue/dialog";

const form = ref({
    priority: 0,
    name: '',
    description: ''
})
const handleSubmit = () => {
    fetch('/api/protocol', {
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
    <Button label="New" icon="pi pi-plus" severity="success" class="mr-2" @click="visible = true"/>
    <Dialog v-model:visible="visible" modal header="Edit Protocol" :style="{ width: '25rem' }">
        <form @submit.prevent="handleSubmit" class="p-fluid mx-auto" style="max-width: 400px; margin-top: 50px;">
            <div class="form-group">
                <label for="priority">Priority</label>
                <input type="number" id="priority" class="form-control" v-model="form.priority"/>
            </div>
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" class="form-control" v-model="form.name"/>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" class="form-control" v-model="form.description"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Create Protocol</button>
        </form>
    </Dialog>
</template>

<style scoped>

</style>
