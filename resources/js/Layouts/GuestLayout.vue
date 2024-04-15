<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';
const isDrawerOpen = ref(false);
</script>

<template>
    <v-app>
        <v-navigation-drawer v-model="isDrawerOpen">
            <v-list>
                <v-list-item-title class="headline mb-5 mt-5"><v-avatar image="/img/455809-PFEHU6-634.jpg"
                        size="58"></v-avatar> Atende
                    Cidadão</v-list-item-title>
                    <v-list-item prepend-icon="mdi-home">
                    <Link href="/">Home</Link>
                </v-list-item>
                <v-list-item prepend-icon="mdi mdi-account-plus">
                    <Link :href="route('register')">Cadastrar</Link>
                </v-list-item>
                <v-list-item prepend-icon="mdi mdi-login">
                    <Link :href="route('login')">Entrar</Link>
                </v-list-item>
            </v-list>

        </v-navigation-drawer>
        <v-app-bar flat class="border-b flex justify-between" color="indigo-darken-1">
            <v-app-bar-nav-icon @click="isDrawerOpen = !isDrawerOpen"></v-app-bar-nav-icon>
        </v-app-bar>


        <main>
            <slot />
        </main>
    
    </v-app>
</template>
