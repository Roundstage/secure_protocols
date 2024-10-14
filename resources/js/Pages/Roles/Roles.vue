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

const Roles = ref({
    data: [
        {
            id: 1,
            name: 'Admin',
            description: 'Full access to all features',
            level: 10
        },
        {
            id: 2,
            name: 'Editor',
            description: 'Can edit content',
            level: 7
        },
        {
            id: 3,
            name: 'Viewer',
            description: 'Can view content only',
            level: 1
        }
    ]
});

onBeforeMount(async () =>
    fetch('/api/role', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${localStorage.getItem('access_token')}`
        }
    }).then(response => {
        if(!response.ok){
            $inertia.visit('/login');
            return;
        }
        return response.json();
    }).then(data => {
        Roles.value.data = data.data;
    })
);
const toast = useToast();
const receiveDataFromChild = (data) => {
    const index = Roles.value.data.findIndex(role => role.id === data.id);
    if (index !== -1) {
        Roles.value.data[index] = data;
        return
    }
    Roles.value.data.push(data);
};

const confirmDelete = async (id) => {
    if (confirm('Are you sure you want to delete this role?')) {
        try {
            const response = await fetch(`/api/role/${id}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${localStorage.getItem('access_token')}`,
                },
            });

            if (response.ok) {
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
