<script setup>
import Navbar from "@/Pages/Components/Navbar.vue";
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Toolbar from "primevue/toolbar";
import Button from "primevue/button";
import {Link} from '@inertiajs/vue3';
import ProtocolEdit from "@/Pages/Protocols/Components/ProtocolEdit.vue";
import ProtocolCreate from "@/Pages/Protocols/Components/ProtocolCreate.vue";
import {useToast} from 'primevue/usetoast';

import {ref, onBeforeMount} from 'vue';


const Protocols = ref({
    data: [
        {
            id: 1,
            name: 'Viribus Protocol',
            description: 'You should train to gain strength',
            priority: 10
        },
    ]
});

onBeforeMount(async () =>
    fetch('/api/protocol', {
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
        Protocols.value = data;
    })
);



const toast = useToast();
const receiveDataFromChild = (data) => {
    const index = Protocols.value.data.findIndex(protocol => protocol.id === data.id);
    if (index !== -1) {
        Protocols.value.data[index] = data;
        return;
    }
    Protocols.value.data.push(data);
};

const confirmDelete = async (id) => {
    if (confirm('Are you sure you want to delete this Protocol?')) {
        try {
            const response = await fetch(`/api/protocol/${id}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${localStorage.getItem('access_token')}`,
                },
            });

            if (response.ok) {
                Protocols.value.data = Protocols.value.data.filter(data => data.id !== id);
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
                        <ProtocolCreate @update="receiveDataFromChild"></ProtocolCreate>
                    </template>
                </Toolbar>
                <DataTable :value="Protocols.data" paginator :rows="5" :rowsPerPageOptions="[5, 10, 20, 50]"
                           tableStyle="min-width: 50rem" v-slot="slotProps">
                    <Column field="name" header="Name"></Column>
                    <Column field="description" header="Description" style="max-width: 30%"></Column>
                    <Column field="priority" header="Priority"></Column>
                    <Column :exportable="true" style="min-width:8rem">
                        <template #body="slotProps">
                            <ProtocolEdit :protocol="slotProps.data" @update="receiveDataFromChild"/>
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
