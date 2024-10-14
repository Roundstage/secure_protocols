<script setup>
import Navbar from "./Components/Navbar.vue"
import Accordion from "@/Pages/Components/Accordion.vue";
import {onBeforeMount} from "vue";
import UserService from "@/Pages/Services/UserService.ts";

UserService.fetchUser();
const User = JSON.parse(localStorage.getItem('user')) || null;

</script>

<template>
    <Navbar></Navbar>
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
