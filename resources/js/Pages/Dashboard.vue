<template>
    <v-app>
        <v-navigation-drawer v-model="isDrawerOpen">
            <v-list>
                <v-list-subheader>Atende Cidadão</v-list-subheader>
                <v-list-item prepend-icon="mdi-home">Home</v-list-item>
                <v-list-item prepend-icon="mdi-badge-account-horizontal-outline"> <!-- <Link :href="route('person.index')"></Link> -->Pessoas</v-list-item>
                <v-list-item prepend-icon="mdi-school">Protocolos</v-list-item>
                <v-list-item prepend-icon="mdi-account-group">Usuários</v-list-item>
                <v-list-item prepend-icon="mdi-cog-outline">Configurações</v-list-item>
            </v-list>
        </v-navigation-drawer>
        <Head title="Atendimento Cidadão" />
        <v-app-bar flat class="border-b" color="indigo-darken-1">
            <v-app-bar-nav-icon @click="isDrawerOpen = !isDrawerOpen"></v-app-bar-nav-icon>

        </v-app-bar>
      

        <AuthenticatedLayout>
           
        </AuthenticatedLayout>
    </v-app>

</template>


<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { ref } from 'vue';

const isDrawerOpen = ref('false');
</script>
