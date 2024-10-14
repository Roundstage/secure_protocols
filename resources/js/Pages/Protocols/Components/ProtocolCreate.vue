<script setup>
import {ref} from 'vue'
import Button from "primevue/button";
import Dialog from "primevue/dialog";
import Toast from "primevue/toast";
import {useToast} from 'primevue/usetoast';
import ProtocolService from "@/Pages/Services/ProtocolService.ts";
const form = ref({
    priority: 0,
    name: '',
    description: ''
});

const toast = useToast();
const emit = defineEmits(['update']);
const visible = ref(false);

const handleSubmit = async () => {
    try {
        const data = await ProtocolService.createProtocol(form.value);
        emit('update', data.data);
        toast.add({ severity: 'success', summary: 'Success', detail: 'Protocol created successfully!', life: 3000 });
    } catch (error) {
        toast.add({ severity: 'error', summary: 'Error', detail: 'Failed to create protocol', life: 3000 });
    }
};
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
    <Toast></Toast>
</template>

<style scoped>

</style>
