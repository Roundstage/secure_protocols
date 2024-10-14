<script setup>
import {ref, onMounted, watch, onUpdated, onBeforeMount} from 'vue';
import Textarea from "primevue/textarea";
import Dialog from "primevue/dialog";
import Button from "primevue/button";
import MultiSelect from "primevue/multiselect";

const handleSubmit = () => {
    fetch('/api/role/'+form.value.id, {
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
    fetch('/api/role/'+form.value.id+'/protocols', {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${localStorage.getItem('access_token')}`
        },
        body: JSON.stringify({'protocols':form.value.protocols.map(p => p.id)})
    }).then(response => {
        return response.json();
    })
}

const form = ref({
    id:'',
    level: '',
    name: '',
    description: '',
    protocols: [{
        id: 1,
        name: 'Viribus Protocol',
        description: 'You should train to gain strength',
        priority: 10
    }]
})
const props = defineProps({role: {id: String, level: String, name: String, description: String}});
const emit = defineEmits(['update']);
const visible = ref(false);

const Protocols = ref([
    {
        id: 1,
        name: 'Viribus Protocol',
        description: 'You should train to gain strength',
        priority: 10
    }
]);

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
        Protocols.value = data.data;
    })
);

onUpdated(() => {
    form.value.id = props.role.id;
    form.value.level = props.role.level;
    form.value.name = props.role.name;
    form.value.description = props.role.description;
    form.value.protocols = props.role.protocols ? props.role.protocols.map(protocol => {
        const matchedProtocol = Protocols.value.find(p => p.id === protocol.id);
        return matchedProtocol ? matchedProtocol : protocol;
    }) : form.value.protocols;

})
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
