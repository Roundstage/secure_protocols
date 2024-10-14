<script setup>
import Navbar from "@/Pages/Components/Navbar.vue";
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Toolbar from "primevue/toolbar";
import Button from "primevue/button";
import {Link} from '@inertiajs/vue3';
import UserEdit from "@/Pages/User/Components/UserEdit.vue";
import UserCreate from "@/Pages/User/Components/UserCreate.vue";
import {useToast} from 'primevue/usetoast';

import {ref, onBeforeMount} from 'vue';

const Users = ref({
    data: [
        {
            id: 1,
            name: 'John Doe',
            email: 'john@example.com',
            role: 'Admin'
        },
    ]
});

onBeforeMount(async () =>
    fetch('/api/user/list', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${localStorage.getItem('access_token')}`
        }
    }).then(response => {
        if (!response.ok) {
            $inertia.visit('/login');
            return;
        }
        return response.json();
    }).then(data => {
        Users.value = data;
    })
);

const toast = useToast();
const receiveDataFromChild = (data) => {
    const index = Users.value.data.findIndex(user => user.id === data.id);
    if (index !== -1) {
        Users.value.data[index] = data;
        return;
    }
    Users.value.data.push(data);
};

const confirmDelete = async (id) => {
    if (confirm('Are you sure you want to delete this User?')) {
        try {
            const response = await fetch(`/api/user/${id}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${localStorage.getItem('access_token')}`,
                },
            });

            if (response.ok) {
                Users.value.data = Users.value.data.filter(data => data.id !== id);
                toast.add({severity: 'success', summary: 'Success', detail: 'User deleted successfully', life: 3000});
            } else {
                toast.add({severity: 'error', summary: 'Error', detail: 'Failed to delete user', life: 3000});
            }
        } catch (error) {
            toast.add({severity: 'error', summary: 'Error', detail: 'Failed to delete user', life: 3000});
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
                        <UserCreate @update="receiveDataFromChild"></UserCreate>
                    </template>
                </Toolbar>
                <DataTable :value="Users.data" paginator :rows="5" :rowsPerPageOptions="[5, 10, 20, 50]"
                           tableStyle="min-width: 50rem" v-slot="slotProps">
                    <Column field="name" header="Name"></Column>
                    <Column field="email" header="Email" style="max-width: 30%"></Column>
                    <Column field="role.name" header="Role"></Column>
                    <Column :exportable="true" style="min-width:8rem">
                        <template #body="slotProps">
                            <UserEdit :user="slotProps.data" @update="receiveDataFromChild"/>
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
