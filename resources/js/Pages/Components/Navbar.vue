<script setup>
import { Link, router } from '@inertiajs/vue3'
const User = JSON.parse(localStorage.getItem('user'));
const logout = () => {
    localStorage.clear();
    router.visit('/login')
};
</script>

<template>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Secure Protocols</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapsed navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <Link class="nav-link active" aria-current="page" method="get" as="button" type="button"
                              href="/">Home
                        </Link>
                    </li>
                    <li class="nav-item" v-if="User && User.role.level === 'Manager'">
                        <Link class="nav-link active" aria-current="page" method="get" as="button" type="button"
                              href="/user">Users
                        </Link>
                    </li>
                    <li class="nav-item" v-if="User && User.role.level === 'Manager'">
                        <Link class="nav-link active" aria-current="page" method="get" as="button" type="button"
                              href="/roles">Roles
                        </Link>
                    </li>
                    <li class="nav-item" v-if="User && User.role.level === 'Manager'">
                        <Link class="nav-link active" aria-current="page" method="get" as="button" type="button"
                              href="/protocol">Protocols
                        </Link>
                    </li>
                    <li v-if="!User && $nextTick(() => $inertia.visit('/'))"></li>
                </ul>
                <div class="nav-item ms-auto">
                    <button class="nav-link active" @click="logout">Logout</button>
                </div>
            </div>
        </div>
    </nav>
</template>

<style scoped>

</style>
