<template>
    <Head title="Atendimento Cidadão" />
    <v-app>
        <AuthenticatedLayout>
            <v-main class="main-content">
                <v-card-text class="mt-3 ml-5 font-weight-bold" >Atende Cidadão > Home</v-card-text>
                <v-container class="container d-flex">
                        <v-img class="img-content" src="/img/5173528.jpg"></v-img>
                </v-container>

            </v-main>
        </AuthenticatedLayout>
    </v-app>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';


</script>

<style scoped>

</style>
