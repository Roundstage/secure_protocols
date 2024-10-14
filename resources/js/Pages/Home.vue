<script setup>
import Navbar from "./Components/Navbar.vue"
import Accordion from "@/Pages/Components/Accordion.vue";
import {ref, onBeforeMount} from 'vue';
import UserService from "@/Pages/Services/UserService.ts";
UserService.fetchUser();

const User = ref({
    id: 1,
    name: 'Fake User',
    email: 'fakeuser@example.com',
    role: {
        name: 'Fake Role',
        description: 'This is a fake role description',
        protocols: [
            {name: 'Fake Protocol 1', description: 'Description for Fake Protocol 1'},
            {name: 'Fake Protocol 2', description: 'Description for Fake Protocol 2'}
        ]
    }
});

const fetchUser = async () => {

    await UserService.fetchUser();

    User.value = JSON.parse(localStorage.getItem('user'));
};

onBeforeMount(fetchUser);
</script>

<template>
    <Navbar :user="User"></Navbar>
    <div class="container py-4">
        <div class="row align-items-md-stretch">
            <div class="col-md-6">
                <div class="h-100 p-5 bg-light border rounded-3">
                    <h2 class="user-box">Usuário logado: {{User.name}}</h2>
                    <h2 class="user-role pb-4">Papel desempenhado: {{User.role.name}}</h2>
                    <p class="user-role-desc"> {{User.role.description}}</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="h-100 p-5 bg-light border rounded-3">
                    <div class="h-100 p-5 bg-light border rounded-3">
                        <h2>Protocolos</h2>
                        <p>Por favor, siga os seguintes protocolos:</p>
                        <div class="accordion" id="accordionExample" v-for="protocol in User.role.protocols">
                            <Accordion accordionId="accordionExample" :accordionName="protocol.name" :accordionContent="protocol.description"></Accordion>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped></style>
