<script setup>
import {ref, onMounted, watch, onUpdated} from 'vue';
import Textarea from "primevue/textarea";
import Dialog from "primevue/dialog";
import Button from "primevue/button";

const handleSubmit = () => {
    fetch('/api/protocol/' + form.value.id, {
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
    priority: 0,
    name: '',
    description: ''
})
const props = defineProps({protocol: {id: String,name: String,description: String,  priority: Number}});
const emit = defineEmits(['update']);
const visible = ref(false);

onUpdated(() => {
    form.value.id = props.protocol.id;
    form.value.priority = props.protocol.priority;
    form.value.name = props.protocol.name;
    form.value.description = props.protocol.description;
})
</script>

<template>
    <Button @click="visible = true" outlined rounded icon="pi pi-pencil"></Button>
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
            <button type="submit" class="btn btn-primary">Update Protocol</button>
        </form>
    </Dialog>
</template>

<style scoped>
/* Add your styles here if necessary */
</style>
