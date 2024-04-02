<template>
 <v-app>
        <v-navigation-drawer v-model="isDrawerOpen">
            <v-list>
                <v-list-item-title class="headline mb-5 mt-5"><v-avatar image="/img/455809-PFEHU6-634.jpg" size="58"></v-avatar> Atende Cidadão</v-list-item-title>
                <v-list-item prepend-icon="mdi-home">
                    <Link :href="route('dashboard')">Home</Link>
                </v-list-item>
                <v-list-item prepend-icon="mdi-badge-account-horizontal-outline">
                    <Link :href="route('person.index')">Pessoas</Link>
                </v-list-item>
                <v-list-item prepend-icon="mdi-school">
                    <Link :href="route('protocols.index')">Protocolos</Link>
                </v-list-item>
                <v-list-item prepend-icon="mdi-account-group">Usuários</v-list-item>
                <v-list-item prepend-icon="mdi-cog-outline">Configurações</v-list-item>
            </v-list>
        </v-navigation-drawer>
        
        <v-app-bar flat class="border-b" color="indigo-darken-1">
            <v-app-bar-nav-icon @click="isDrawerOpen = !isDrawerOpen"></v-app-bar-nav-icon>
        </v-app-bar>
    </v-app>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';
const isDrawerOpen = ref(false);
</script>

