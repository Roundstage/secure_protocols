<script setup>
import Navbar from "@/Pages/Components/Navbar.vue";
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Toolbar from "primevue/toolbar";
import Button from "primevue/button";
import RoleCreate from "@/Pages/Roles/Components/RoleCreate.vue";
import {useToast} from 'primevue/usetoast';
import RoleEdit from "@/Pages/Roles/Components/RoleEdit.vue";
import {ref, onBeforeMount} from 'vue';
import RoleService from "@/Pages/Services/RoleService";
import UserService from "@/Pages/Services/UserService.ts";

UserService.fetchUser();

const Roles = ref({ data: [] });

const toast = useToast();

const fetchRoles = async () => {
    try {
        const data = await RoleService.getRoles();
        Roles.value.data = data.data;
    } catch (error) {
        console.error('Error fetching roles:', error);
        $inertia.visit('/login');
    }
};

onBeforeMount(fetchRoles);

const receiveDataFromChild = (data) => {
    const index = Roles.value.data.findIndex(role => role.id === data.id);
    if (index !== -1) {
        Roles.value.data[index] = data;
        return;
    }
    Roles.value.data.push(data);
};

const confirmDelete = async (id) => {
    if (confirm('Are you sure you want to delete this role?')) {
        try {
            const response = await RoleService.deleteRole(id);
            if (response.status === 200) {
                Roles.value.data = Roles.value.data.filter(role => role.id !== id);
                toast.add({severity: 'success', summary: 'Success', detail: 'Role deleted successfully', life: 3000});
            } else {
                toast.add({severity: 'error', summary: 'Error', detail: 'Failed to delete role', life: 3000});
            }
        } catch (error) {
            toast.add({severity: 'error', summary: 'Error', detail: 'Failed to delete role', life: 3000});
        }
    }
};
</script>

<template>
    <Navbar/>
    <Toast></Toast>
    <div class="p-4">
        <div class="p-5 mb-4 bg-light rounded-3">
            <div class="container-fluid py-5">
                <Toolbar class="mb-4">
                    <template #start>
                        <RoleCreate @update="receiveDataFromChild"></RoleCreate>
                    </template>
                </Toolbar>
                <DataTable :value="Roles.data" paginator :rows="5" :rowsPerPageOptions="[5, 10, 20, 50]"
                           tableStyle="min-width: 50rem" v-slot="slotProps">
                    <Column field="name" header="Name"></Column>
                    <Column field="description" header="Description" style="max-width: 30%"></Column>
                    <Column field="level" header="Level"></Column>
                    <Column :exportable="true" style="min-width:8rem">
                        <template #body="slotProps">
                            <RoleEdit :role="slotProps.data" @update="receiveDataFromChild"/>
                            <Button icon="pi pi-trash" outlined rounded severity="danger"
                                    @click="confirmDelete(slotProps.data.id)"/>
                        </template>
                    </Column>
                </DataTable>
            </div>
        </div>
    </div>

</template>

<style scoped>

</style>
