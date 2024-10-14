<script setup>
import {ref, onMounted, watch, onUpdated} from 'vue';
import Textarea from "primevue/textarea";
import Dialog from "primevue/dialog";
import Button from "primevue/button";
import {useToast} from 'primevue/usetoast';
import ProtocolService from "@/Pages/Services/ProtocolService.ts";
const toast = useToast();

const form = ref({
    id: '',
    priority: 0,
    name: '',
    description: ''
});

const props = defineProps({
    protocol: {
        id: String,
        name: String,
        description: String,
        priority: Number
    }
});

const emit = defineEmits(['update']);
const visible = ref(false);

const handleSubmit = async () => {
    try {
        const data = await ProtocolService.updateProtocol(form.value.id, form.value);
        emit('update', data.data);
        toast.add({ severity: 'success', summary: 'Success', detail: 'Protocol updated successfully', life: 3000 });
    } catch (error) {
        toast.add({ severity: 'error', summary: 'Error', detail: 'Failed to update protocol', life: 3000 });
    }
};

onUpdated(() => {
    form.value.id = props.protocol.id;
    form.value.priority = props.protocol.priority;
    form.value.name = props.protocol.name;
    form.value.description = props.protocol.description;
});
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
