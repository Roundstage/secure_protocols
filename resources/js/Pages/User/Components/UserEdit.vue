<script setup>
import {ref, onMounted, watch, onUpdated} from 'vue';
import Textarea from "primevue/textarea";
import Dialog from "primevue/dialog";
import Button from "primevue/button";
import Toast from 'primevue/toast';
import {useToast} from 'primevue/usetoast';
import UserService from "@/Pages/Services/UserService.ts";

const toast = useToast();

const handleSubmit = async () => {
    try {
        const [userData, roleData] = await Promise.all([
            UserService.updateUser(form.value.id, form.value),
            UserService.updateUserRole(form.value.id, form.value.role.id)
        ]);

        const updatedUser = {
            ...userData.data,
            role: roleData.data.role
        };
        emit('update', updatedUser);
        toast.add({ severity: 'success', summary: 'Success', detail: 'User updated successfully.', life: 3000 });
    } catch (error) {
        console.error('Error updating user:', error);
        toast.add({ severity: 'error', summary: 'Error', detail: 'Failed to update user.', life: 3000 });
    }
}

const Roles = ref([]);
const form = ref({
    id: '',
    name: '',
    email: '',
    role: ''
});
const props = defineProps({ user: { id: String, name: String, email: String, role: Object } });
const emit = defineEmits(['update']);
const visible = ref(false);

onUpdated(async () => {
    Object.assign(form.value, props.user);

    try {
        const data = await UserService.fetchRoles();
        Roles.value = data.data;
    } catch (error) {
        console.error('Error fetching roles:', error);
        $inertia.visit('/login');
    }
});
</script>

<template>
    <Button @click="visible = true" outlined rounded icon="pi pi-pencil" severity="success" ></Button>
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
    <Toast/>
</template>

<style scoped>
/* Add your styles here if necessary */
</style>
