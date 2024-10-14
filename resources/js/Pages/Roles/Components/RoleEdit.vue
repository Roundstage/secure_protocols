<script setup>
import {ref, onMounted, watch, onUpdated, onBeforeMount} from 'vue';
import Textarea from "primevue/textarea";
import Dialog from "primevue/dialog";
import Button from "primevue/button";
import MultiSelect from "primevue/multiselect";
import {useToast} from 'primevue/usetoast';
import ProtocolService from "@/Pages/Services/ProtocolService.ts";
import RoleService from "@/Pages/Services/RoleService.ts";

const toast = useToast();

const form = ref({
    id: '',
    level: '',
    name: '',
    description: '',
    protocols: []
});

const props = defineProps({ role: { id: String, level: String, name: String, description: String } });
const emit = defineEmits(['update']);
const visible = ref(false);

const Protocols = ref([]);

const fetchProtocols = async () => {
    try {
        const data = await ProtocolService.fetchProtocols();
        Protocols.value = data.data;
    } catch (error) {
        console.error('Error fetching protocols:', error);
        $inertia.visit('/login');
    }
};

const handleSubmit = async () => {
    try {
        const roleData = await RoleService.updateRole(form.value.id, form.value);
        await RoleService.updateRoleProtocols(form.value.id, form.value.protocols.map(p => p.id));
        emit('update', roleData.data);
        toast.add({ severity: 'success', summary: 'Success', detail: 'Role and protocols updated successfully', life: 3000 });
    } catch (error) {
        toast.add({ severity: 'error', summary: 'Error', detail: 'Failed to update role or protocols', life: 3000 });
    }
};

onBeforeMount(fetchProtocols);

onUpdated(() => {
    form.value.id = props.role.id;
    form.value.level = props.role.level;
    form.value.name = props.role.name;
    form.value.description = props.role.description;
    form.value.protocols = props.role.protocols ? props.role.protocols.map(protocol => {
        const matchedProtocol = Protocols.value.find(p => p.id === protocol.id);
        return matchedProtocol ? matchedProtocol : protocol;
    }) : form.value.protocols;
});
</script>

<template>
    <Button @click="visible = true" outlined rounded icon="pi pi-pencil"></Button>
    <Dialog v-model:visible="visible" modal header="Edit Role" :style="{ width: '25rem' }">
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
            <div class="form-group">
                <label for="Protocols">Select Protocols</label>
                <MultiSelect id="Protocols" v-model="form.protocols" :options="Protocols" optionLabel="name"
                             optionKey="id"
                             filter
                             placeholder="Select protocols" class="w-full md:w-80"/>
            </div>

            <button type="submit" class="btn btn-primary">Update Role</button>
        </form>
    </Dialog>
</template>

<style scoped>
/* Add your styles here if necessary */
</style>
